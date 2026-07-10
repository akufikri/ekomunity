<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Crypt;
use App\Models\{
    User,
    AppConfig,
    Payment,
    SettingSubscribe,
    JoinCompany,
    DetailManpower,
    DetailCompany,
    LogPaymentCawangan,
    LogPaymentJoinCompany,
    LogPaymentManpower,
    PublishedCertificate
};
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

/**
 * ToyyibPay Configuration
 */
class ToyyibPayConfig
{
    public static function getConfig()
    {
        $isDev = env('IS_DEV');
        $baseUrl = $isDev ? env('BASE_URL_TOYYIBPAY_DEV') : env('BASE_URL_TOYYIBPAY');

        $settingSubscribe = SettingSubscribe::where('subscribe_for', 'REGISTER AHLI')
            ->where('is_active', 'ENABLE')
            ->first();

        return [
            'isDev' => $isDev,
            'baseUrl' => $baseUrl,
            'createBillUrl' => $baseUrl . 'index.php/api/createBill',
            'callbackUrl' => env('APP_URL') . '/api/callback-toyyibpay',
            'userSecretKey' => $settingSubscribe->secret_key ?? null,
            'categoryCode' => $settingSubscribe->collection_id ?? null,
            'subscribePrice' => $settingSubscribe->price ?? 0
        ];
    }
}

/**
 * ToyyibPay Routes
 * Routes without prefix to maintain backward compatibility
 */
Route::any('/getBill', function () {
    $controller = new ToyyibPayController();
    return $controller->getBill();
});

Route::any('/create_bill_company_card', function () {
    $controller = new ToyyibPayController();
    return $controller->createBillCompanyCard();
});

Route::any('/create_bill_join_company', function () {
    $controller = new ToyyibPayController();
    return $controller->createBillJoinCompany();
});

Route::any('/create_bill_subscribe_ahli', function () {
    $controller = new ToyyibPayController();
    return $controller->createBillSubscribeAhli();
});

/**
 * ToyyibPay Controller Class
 */
class ToyyibPayController
{
    private $config;

    public function __construct()
    {
        $this->config = ToyyibPayConfig::getConfig();
    }

    /**
     * Get Bill Transactions
     */
    public function getBill()
    {
        $idBill = request()->id_bill;
        $url = $this->config['isDev']
            ? "https://dev.toyyibpay.com/index.php/api/getBillTransactions"
            : "https://toyyibpay.com/index.php/api/getBillTransactions";

        return $this->toyyibPayCurl($url, 'GET');
    }

    /**
     * Create Bill for Company Card
     */
    public function createBillCompanyCard()
    {
        $request = request();

        // Validation
        $validation = $this->validateRequired([
            [$request->id_user, 'id_user is required'],
        ]);

        if (!$validation['status']) {
            return $validation;
        }

        // Get user and config
        $user = User::find($request->id_user);
        if (!$user) {
            return $this->errorResponse('User does not exist');
        }

        $appConfig = AppConfig::first();

        // Create payment record
        $payment = $this->createPaymentRecord([
            'type_item' => 'COMPANY_CARD',
            'user' => $user,
            'amount' => $appConfig->price_company_card,
            'collection_id' => $this->config['categoryCode'],
            'description' => "Payment Kad Perniagaan {$user->fullname}",
        ]);

        // Prepare bill fields
        $fields = $this->prepareBillFields([
            'userSecretKey' => $this->config['userSecretKey'],
            'categoryCode' => $payment->collection_id,
            'billName' => 'Subscribe Ahli',
            'billDescription' => $payment->description,
            'billAmount' => $payment->amount,
            'billReturnUrl' => '',
            'billCallbackUrl' => $payment->callback_url,
            'billExternalReferenceNo' => $payment->id,
            'billTo' => $payment->name,
            'billEmail' => $payment->email,
            'billPhone' => $payment->mobile,
            'billContentEmail' => 'Thank you for purchasing Company Card!',
        ]);

        // Create bill via API
        return $this->processBillCreation($payment, $fields);
    }

    /**
     * Create Bill for Join Company
     */
    public function createBillJoinCompany()
    {
        $request = request();

        // decrypt ID dulu
        try {
            $id = Crypt::decryptString($request->id);
        } catch (\Exception $e) {
            return $this->errorResponse('Invalid ID provided');
        }

        // Validation
        $validation = $this->validateRequired([
            [$id, 'id join company is required'],
        ]);

        if (!$validation['status']) {
            return $validation;
        }

        // Get related data
        $joinCompany = JoinCompany::find($id);
        if (!$joinCompany) {
            return $this->errorResponse('Join Company record not found');
        }

        $manpower = DetailManpower::where('id_detail_manpower', $joinCompany->id_detail_manpower)->first();
        $company = DetailCompany::where('id_detail_company', $joinCompany->id_detail_company)->first();
        $user = User::find($manpower->id_user);

        if (!$user || !$company) {
            return $this->errorResponse('Required data not found');
        }

        // Create payment record
        $payment = $this->createPaymentRecord([
            'type_item' => 'JOIN_COMPANY',
            'user' => $user,
            'amount' => $joinCompany->joining_fee,
            'collection_id' => $company->collection_id,
            'description' => "Request Join Persatuan {$company->full_company_name}",
        ]);

        // Prepare bill fields
        $fields = $this->prepareBillFields([
            'userSecretKey' => $company->secret_key,
            'categoryCode' => $payment->collection_id,
            'billName' => 'Request Join Persatuan',
            'billDescription' => $payment->description,
            'billAmount' => $payment->amount,
            'billReturnUrl' => '',
            'billCallbackUrl' => $payment->callback_url,
            'billExternalReferenceNo' => $payment->id,
            'billTo' => $payment->name,
            'billEmail' => $payment->email,
            'billPhone' => $payment->mobile,
            'billContentEmail' => 'Thank you for purchasing our product!',
        ]);

        // Create bill via API
        $result = $this->processBillCreation($payment, $fields);

        if ($result['httpcode'] == 200) {
            $this->createJoinCompanyLog($joinCompany, $user, $payment);
            return redirect($result['payment_url']);
        }

        $encrypt = Crypt::encryptString($joinCompany->id);
        return redirect("/errorPaymentGateway/$encrypt");
    }


    /**
     * Create Bill for Subscribe Ahli
     */
    public function createBillSubscribeAhli()
    {
        $request = request();

        // Validation
        $validation = $this->validateRequired([
            [$request->id, 'id user is required'],
        ]);

        if (!$validation['status']) {
            return $validation;
        }

        // Decrypt user ID
        try {
            $userId = Crypt::decryptString($request->id);
        } catch (\Exception $e) {
            return redirect("/errorPaymentGateway");
        }

        // Get user and manpower
        $user = User::find($userId);
        if (!$user) {
            return redirect("/errorPaymentGateway");
        }

        $manpower = DetailManpower::where('id_user', $user->id)->first();
        if (!$manpower) {
            return redirect("/errorPaymentGateway");
        }

        // Use persatuan joining_fee if code provided, else fallback to global subscribe price
        $amount = $this->config['subscribePrice'];
        if ($request->code) {
            $company = DetailCompany::where('key_reference', $request->code)->first();
            if ($company && $company->joining_fee !== null) {
                $amount = $company->joining_fee;
            }
        }

        // Create payment record
        $payment = $this->createPaymentRecord([
            'type_item' => 'SUBSCRIBE_AHLI',
            'user' => $user,
            'amount' => $amount,
            'collection_id' => $this->config['categoryCode'],
            'description' => "Subscribe Ahli {$user->fullname}",
        ]);

        // Prepare bill fields
        $redirectUrl = env('APP_URL') . "/register_ahli/pembayaran_success";
        $fields = $this->prepareBillFields([
            'userSecretKey' => $this->config['userSecretKey'],
            'categoryCode' => $payment->collection_id,
            'billName' => 'Register Ahli',
            'billDescription' => $payment->description,
            'billAmount' => $payment->amount,
            'billReturnUrl' => $redirectUrl,
            'billCallbackUrl' => $payment->callback_url,
            'billExternalReferenceNo' => $payment->id,
            'billTo' => $payment->name,
            'billEmail' => $payment->email,
            'billPhone' => $payment->mobile,
            'billContentEmail' => 'Thank you for joining as Ahli!',
        ]);

        // Create bill via API
        $result = $this->processBillCreation($payment, $fields);

        // Create log if successful
        if ($result['httpcode'] == 200) {
            $this->createManpowerLog($user, $manpower, $payment);
            return redirect($result['payment_url']);
        }

        return redirect("/errorPaymentGateway");
    }

    /**
     * Helper Methods
     */

    private function createPaymentRecord($data)
    {
        $payment = new Payment();
        $payment->type_item = $data['type_item'];
        $payment->id_user = $data['user']->id;
        $payment->payment_gateway = "TOYYIBPAY";
        $payment->amount = $data['amount'] * 100; // Convert to cents
        $payment->collection_id = $data['collection_id'];
        $payment->email = $data['user']->email;
        $payment->mobile = $this->formatMalaysianPhone($data['user']->phone_number);
        $payment->name = $data['user']->fullname;
        $payment->callback_url = $this->config['callbackUrl'];
        $payment->description = $data['description'];
        $payment->state = "none";
        $payment->due_at = date('Y-m-d', strtotime('+1 days'));
        $payment->save();

        return $payment;
    }

    private function prepareBillFields($data)
    {
        return array_merge([
            'billPriceSetting' => 1,
            'billPayorInfo' => 1,
            'billSplitPayment' => 0,
            'billSplitPaymentArgs' => '',
            'billPaymentChannel' => '0',
            'billChargeToCustomer' => 0,
            'billExpiryDate' => date('Y-m-d', strtotime('+1 days')),
            'billExpiryDays' => 1
        ], $data);
    }

    private function processBillCreation($payment, $fields)
    {
        $bill = $this->toyyibPayCurl($this->config['createBillUrl'], 'POST', $fields);

        if (isset($bill->original)) {
            $bill = $bill->original;
        }

        $httpcode = $bill['httpcode'];
        $response = $bill['response'];

        if ($httpcode == 200) {
            if (!isset($response[0]['BillCode'])) {
                return redirect("/errorPaymentGateway");
            }

            $payment->id_bill = $response[0]['BillCode'];
            $payment->url = $this->config['baseUrl'] . $payment->id_bill;
            $payment->save();

            $paymentUrl = $payment->url;

            return [
                'httpcode' => $httpcode,
                'status' => true,
                'message' => "Please Complete your payment",
                'response' => $response,
                'data' => $payment,
                'payment_url' => $paymentUrl,
                'redirect' => redirect($paymentUrl)
            ];
        }

        return [
            'httpcode' => $httpcode,
            'status' => false,
            'message' => $response['error']['message'][0] ?? 'ERROR',
            'response' => $response
        ];
    }

    private function createJoinCompanyLog($joinCompany, $user, $payment)
    {
        $log = new LogPaymentJoinCompany();
        $log->id_request_join_company = $joinCompany->id;
        $log->id_user = $user->id;
        $log->id_detail_manpower = $joinCompany->id_detail_manpower;
        $log->id_detail_company = $joinCompany->id_detail_company;
        $log->day = date('d');
        $log->month = date('m');
        $log->year = date('Y');
        $log->amount = $joinCompany->joining_fee;
        $log->payment_proof = null;
        $log->payment_type = "TOYYIBPAY";
        $log->created_by = $user->id;
        $log->save();

        $payment->id_log_payment_join_company = $log->id;
        $payment->save();

        return $log;
    }

    private function createManpowerLog($user, $manpower, $payment)
    {
        $checkRenwal = $this->checkRenewalAhli($user->id);
        if ($checkRenwal == 0) {
            $logCategory = 'REGISTER';
        } else {
            $logCategory = 'RENEWAL';
        }

        $log = new LogPaymentManpower();
        $log->id_user = $user->id;
        $log->id_detail_manpower = $manpower->id_detail_manpower;
        $log->day = date('d');
        $log->month = date('m');
        $log->year = date('Y');
        $log->amount = $this->config['subscribePrice'];
        $log->payment_proof = null;
        $log->payment_type = "TOYYIBPAY";
        $log->category = $logCategory;
        $log->approval_note = "Payment automatic approval by sistem!";
        $log->approval_date = Carbon::now();
        $log->created_by = $user->id;
        $log->save();

        $payment->id_log_payment_manpower = $log->id_log_payment_manpower;
        $payment->save();

        $this->updateManpowerData($user->id);

        return $log;
    }

    private function checkRenewalAhli($id_user)
    {
        $ahli = DetailManpower::where('id_user', $id_user)->first();

        // If ahli not found, return needs renewal
        // if (!$ahli) {
        //     return 1;
        // }

        // If certificate expired date not set, return needs renewal
        // if (!$ahli->certificate_expired_date) {
        //     return 1;
        // }

        $dateNow = Carbon::now();
        $expiredDate = Carbon::parse($ahli->certificate_expired_date);

        // Check if certificate has expired (past the expiry date)
        if ($dateNow->greaterThan($expiredDate)) {
            return 1; // Needs renewal
        }

        return 0; // Still valid
    }

    private function updateManpowerData($id_user)
    {
        $newDateTime = Carbon::now()->addYear(1);
        $running_number = PublishedCertificate::orderBy('id_published_certificate', 'desc')->first();
        if ($running_number) {
            $add_number = ((int)$running_number->number_certificate) + 1;
            $next_number = str_pad($add_number, 6, '0', STR_PAD_LEFT);
        } else {
            $next_number = str_pad(1, 6, '0', STR_PAD_LEFT);
        }
        $data = DetailManpower::where('id_user', $id_user)->first();
        $data->is_subscribe = 'TRUE';
        $data->subscribe_status = 'APPROVED';
        $data->valid_time_certificate = 1;
        $data->certificate_expired_date = $newDateTime;
        $data->number_certificate = $next_number;
        $data->view_certificate = 1;
        $data->kad_digital = 'TRUE';
        $data->save();
    }



    private function formatMalaysianPhone($number)
    {
        $number = (string)$number;
        $sub1 = substr($number, 0, 1);
        $sub2 = substr($number, 0, 2);

        if ($sub1 == "0") {
            $number = "60" . substr($number, 1);
        } elseif ($sub2 != "60") {
            $number = "60" . $number;
        }

        // Limit to 12 characters
        if (strlen($number) > 12) {
            $number = substr($number, 0, 11);
        }

        return $number;
    }

    private function toyyibPayCurl($url, $method = 'GET', $fields = '')
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $fields,
        ]);

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $response = json_decode($response, true);

        return [
            'httpcode' => $httpcode,
            'response' => $response
        ];
    }

    private function validateRequired($requirements)
    {
        foreach ($requirements as $requirement) {
            [$value, $message] = $requirement;
            if (!$value) {
                return [
                    'status' => false,
                    'message' => $message
                ];
            }
        }

        return [
            'status' => true,
            'message' => 'Passed'
        ];
    }

    private function errorResponse($message)
    {
        return [
            'status' => false,
            'message' => $message
        ];
    }
}

/**
 * Email Service Class
 */
class EmailService
{
    public static function sendTransactionReceipt($customerName, $customerEmail, $transactionId)
    {
        $from = env("MAIL_USERNAME", "rikod.my@gmail.com");
        $url = env("APP_URL") . "/transaction_mobile/pdf/{$transactionId}";
        $userEmail = $customerEmail ?? 'mail@mail.com';

        $msg = "<p>Berikut link receipt transaksi anda: <br><a target='_blank' href='{$url}'>{$url}</a></p>";
        $subject = "Receipt Transaction";

        $data = [
            'title' => $subject,
            'data' => $customerName,
            'content' => $msg,
            'to_name' => $customerName,
        ];

        Mail::send('user_company.email', $data, function ($message) use ($customerName, $userEmail, $from, $subject) {
            $message->to($userEmail, $userEmail)->subject($subject);
            $message->from($from, "RIKOD LITE");
        });

        return true;
    }
}
