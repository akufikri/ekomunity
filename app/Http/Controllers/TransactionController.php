<?php

namespace App\Http\Controllers;

use App\Models\GerbangPembayaran;
use App\Models\LogPaymentManpower;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Payment;
use App\Models\DetailManpower;
use App\Models\DetailCompany;
use App\Models\LogPaymentJoinCompany;
use App\Models\JoinCompany;
use App\Models\Certifikat;
use App\Models\PublishedCertificate;
use App\Models\Inbox;
use App\Models\InboxRecipient;
use App\Models\LogPaymentCawangan;
use App\Models\LogPaymentKetuaBahagian;
use App\Models\SettingSubscribe;
use App\Traits\ApiResponder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    use ApiResponder;

    private function generateOrderId()
    {
        $today = now()->format('dmY');
        $todayCount = Transaction::whereDate('created_at', today())->count() + 1;
        return "ORDER-{$todayCount}-{$today}";
    }

    public function callback(Request $request)
    {
        try {
            // Cari payment berdasarkan billcode
            $payment = Payment::where('id_bill', $request->billcode)->first();

            if (!$payment) {
                Log::warning('Payment record not found', [
                    'billcode' => $request->billcode
                ]);

                return response()->json([
                    'isSuccess' => false,
                    'message' => 'Payment record not found'
                ], 404);
            }

            // Update status payment
            $payment->paid = $request->status;
            if ($payment->paid == 1) {
                $payment->state = "success";
            } else if ($payment->paid == 2) {
                $payment->state = "pending";
            } else if ($payment->paid == 3) {
                $payment->state = "fail";
            }

            $payment->paid_amount = $request->amount * 100;
            if (isset($request->transaction_time)) {
                $payment->paid_at = $request->transaction_time;
            }

            $message = "Your payment failed";
            $status_payment = "false";

            if ($payment->paid == 1) {
                try {
                    switch ($payment->type_item) {
                        case "COMPANY_CARD":
                            $this->processCompanyCardPayment(
                                DetailManpower::where('id_user', $payment->id_user)->first(),
                                now()
                            );
                            break;
                        case "JOIN_COMPANY":
                            $this->processJoinCompanyPayment($payment);
                            break;
                        case "SUBSCRIBE_AHLI":
                            $this->processSubscribeAhliPayment(
                                $payment,
                                DetailManpower::where('id_user', $payment->id_user)->first(),
                                $payment->paid
                            );
                            break;
                    }

                    $message = "Your payment successfully";
                    $status_payment = "true";
                } catch (\Exception $e) {
                    Log::error('Error processing payment', [
                        'payment_id' => $payment->id,
                        'type_item' => $payment->type_item,
                        'error' => $e->getMessage(),
                    ]);
                    throw $e;
                }
            }

            $updated = $payment->update();

            if ($updated) {
                Log::info('Payment updated', [
                    'payment_id' => $payment->id,
                    'status' => $payment->paid,
                    'state' => $payment->state,
                ]);
                return response()->json(['isSuccess' => true, 'message' => "Success"]);
            } else {
                Log::error('Failed to update payment record', [
                    'payment_id' => $payment->id,
                ]);
                return response()->json(['isSuccess' => false, 'message' => "Failed"]);
            }
        } catch (\Exception $e) {
            Log::error('Exception in payment callback', [
                'billcode' => $request->billcode,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'isSuccess' => false,
                'message' => 'Callback processing failed: ' . $e->getMessage()
            ], 500);
        }
    }

    private function processCompanyCardPayment($manpower, $now)
    {
        $manpower->payment_kad_digital = $now;
        $manpower->kad_digital = "TRUE";
        $manpower->save();

        $recipient = [$manpower->id_user];
        $this->submitInbox('1', $recipient, "Pembayaran Kad Perniagaan", "Pembayaran Kad perniagaan berjaya.", Inbox::$paymentSuccessCardCompany);
    }

    private function processJoinCompanyPayment($payment)
    {
        $log_payment = LogPaymentJoinCompany::where('id', $payment->id_log_payment_join_company)->first();
        $log_payment->approval = "APPROVED";
        $log_payment->approval_note = "Payment automatic approval by sistem!";
        $log_payment->approval_date = now();
        $log_payment->approval_by = '1';
        $log_payment->save();

        $newDateTime = Carbon::now()->addYear(1);

        $join_company = JoinCompany::where('id', $log_payment->id_request_join_company)->first();
        $join_company->payment_date = now();
        $join_company->expired_at = $newDateTime;
        $join_company->payment_method = "TOYYIBPAY";
        $join_company->save();
    }

    private function processSubscribeAhliPayment($payment, $manpower, $status)
    {
        Log::info('Starting SUBSCRIBE_AHLI payment processing', [
            'payment_id' => $payment->id,
            'manpower_id' => $manpower->id ?? null,
            'user_id' => $manpower->id_user ?? null,
            'status' => $status,
            'log_payment_manpower_id' => $payment->id_log_payment_manpower
        ]);

        try {
            $log_payment = LogPaymentManpower::where('id_log_payment_manpower', $payment->id_log_payment_manpower)->first();
            
            if (!$log_payment) {
                Log::error('LogPaymentManpower not found', [
                    'id_log_payment_manpower' => $payment->id_log_payment_manpower,
                    'payment_id' => $payment->id
                ]);
                throw new \Exception('LogPaymentManpower not found');
            }

            $log_payment->approval = "APPROVED";
            $log_payment->approval_note = "Payment automatic approval by sistem!";
            $log_payment->approval_date = now();
            $log_payment->approval_by = '1';
            $log_payment->save();

            Log::info('LogPaymentManpower updated to APPROVED', [
                'log_payment_id' => $log_payment->id_log_payment_manpower
            ]);

            $certificate = Certifikat::first();
            if (!$certificate) {
                Log::error('Certificate template not found');
                throw new \Exception('Certificate template not found');
            }

            // FIX: Convert valid_time to integer and add validation
            $validTime = (int) $certificate->valid_time;
            
            // Validate that valid_time is a positive number
            if ($validTime <= 0) {
                Log::error('Invalid certificate valid_time', [
                    'raw_valid_time' => $certificate->valid_time,
                    'converted_valid_time' => $validTime,
                    'certificate_id' => $certificate->id ?? null
                ]);
                throw new \Exception('Invalid certificate valid_time: must be a positive number');
            }

            Log::info('Certificate valid_time processed', [
                'raw_valid_time' => $certificate->valid_time,
                'converted_valid_time' => $validTime,
                'data_type' => gettype($validTime)
            ]);

            $running_number = PublishedCertificate::orderBy('id_published_certificate', 'desc')->first();
            $check_exists = PublishedCertificate::where('id_user', $manpower->id_user)->first();

            $dateNow = date("dmy");
            $next_number = null;

            if (!$check_exists) {
                if ($running_number) {
                    $add_number = ((int)$running_number->number_certificate) + 1;
                    $next_number = str_pad($add_number, 6, '0', STR_PAD_LEFT);
                } else {
                    $next_number = str_pad(1, 6, '0', STR_PAD_LEFT);
                }

                Log::info('Generated new certificate number', [
                    'user_id' => $manpower->id_user,
                    'next_number' => $next_number,
                    'full_number' => 'A' . $dateNow . '-' . $next_number
                ]);
            } else {
                Log::info('Certificate already exists for user, will update expiry', [
                    'user_id' => $manpower->id_user,
                    'existing_certificate_id' => $check_exists->id_published_certificate
                ]);
            }

            // FIX: Use the validated integer value
            try {
                $newDateTime = Carbon::now()->addYear($validTime);
                
                Log::info('Certificate expiry date calculated', [
                    'valid_time_years' => $validTime,
                    'current_date' => Carbon::now()->toDateTimeString(),
                    'expiry_date' => $newDateTime->toDateTimeString()
                ]);
                
            } catch (\Exception $e) {
                Log::error('Error calculating certificate expiry date', [
                    'valid_time' => $validTime,
                    'error' => $e->getMessage()
                ]);
                throw new \Exception('Error calculating certificate expiry date: ' . $e->getMessage());
            }

            $manpower->subscribe_status = "APPROVED";
            $manpower->is_subscribe = "TRUE";
            $manpower->valid_time_certificate = $validTime; // Store as integer
            $manpower->certificate_expired_date = $newDateTime;

            if (!$check_exists) {
                $manpower->number_certificate = 'A' . $dateNow . '-' . $next_number;
                
                $publish = new PublishedCertificate();
                $publish->number_certificate = $next_number;
                $publish->id_user = $manpower->id_user;
                $publish->expire_date = $newDateTime;
                $publish->save();

                Log::info('New published certificate created', [
                    'certificate_id' => $publish->id_published_certificate,
                    'user_id' => $manpower->id_user,
                    'number_certificate' => $next_number,
                    'expire_date' => $newDateTime->toDateTimeString()
                ]);
            } else {
                $check_exists->expire_date = $newDateTime;
                $check_exists->save();

                Log::info('Existing published certificate updated', [
                    'certificate_id' => $check_exists->id_published_certificate,
                    'user_id' => $manpower->id_user,
                    'new_expire_date' => $newDateTime->toDateTimeString()
                ]);
            }

            $manpower->save();

            Log::info('Manpower subscription updated successfully', [
                'manpower_id' => $manpower->id,
                'user_id' => $manpower->id_user,
                'subscribe_status' => 'APPROVED',
                'certificate_expired_date' => $newDateTime->toDateTimeString()
            ]);
            if ($status == 1 || $status == '1') {
                $reqJoin = JoinCompany::where('id_detail_manpower', $manpower->id_detail_manpower)->first();
                $reqJoin->payment_method = "TOYYIBPAY";
                $reqJoin->payment_date = now();
                $reqJoin->save();
            }

            $this->createLogPaymentCawangan($manpower->id_user, $status, $log_payment->id_log_payment_manpower);
            
            Log::info('SUBSCRIBE_AHLI payment processing completed', [
                'payment_id' => $payment->id,
                'user_id' => $manpower->id_user
            ]);

            $this->createLogPaymentKetuaBahagian($manpower->id_user, $status, $log_payment->id_log_payment_manpower);


        } catch (\Exception $e) {
            Log::error('Error in processSubscribeAhliPayment', [
                'payment_id' => $payment->id,
                'manpower_id' => $manpower->id ?? null,
                'user_id' => $manpower->id_user ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
}

    protected function createLogPaymentCawangan($id_user, $status, $id_payment)
    {
        $detailAhli = DetailManpower::where('id_user', $id_user)->select('id_detail_manpower', 'id_user', 'id_cawangan')->first();

        if ($status == 2 || $status == '2') {
            $setStatus = 'PENDING';
        } elseif ($status == 1 || $status == '1') {
            $setStatus = 'PAID';
        } else {
            $setStatus = 'CANCEL';
        }
        $profit = $this->profitSharing('cawangan');

        $log = new LogPaymentCawangan();
        $log->id_payment = $id_payment;
        $log->id_user = $detailAhli->id_user;
        $log->id_cawangan = $detailAhli->id_cawangan;
        $log->amount = $profit;
        $log->status = $setStatus;
        $log->save();
    }

    protected function createLogPaymentKetuaBahagian($id_user, $status, $id_payment)
    {
        $detailAhli = DetailManpower::where('id_user', $id_user)->select('id_detail_manpower', 'id_user', 'id_cawangan')->first();

        if ($status == 2 || $status == '2') {
            $setStatus = 'PENDING';
        } elseif ($status == 1 || $status == '1') {
            $setStatus = 'PAID';
        } else {
            $setStatus = 'CANCEL';
        }
        $profit = $this->profitSharing('ketua_bahagian');

        $bahagian = DetailCompany::where('id_user', $detailAhli->id_cawangan)->select('id_detail_company', 'id_user', 'id_bahagian')->first();

        $log = new LogPaymentKetuaBahagian();
        $log->id_payment = $id_payment;
        $log->id_user = $detailAhli->id_user;
        $log->id_cawangan = $detailAhli->id_cawangan;
        $log->id_ketua_bahagian = $bahagian->id_bahagian;
        $log->amount = $profit;
        $log->status = $setStatus;
        $log->save();
    }

    protected function profitSharing($level_name)
    {
        $profit = SettingSubscribe::where('is_active', 'ENABLE')->first();

        if ($level_name == 'cawangan') {
            return $profit->price_cawangan;
        } elseif ($level_name == 'ketua_bahagian') {
            return $profit->price_ketua_bahagian;
        } else {
            return $profit->price;
        }
    }

    public function submitInbox($sender, $recipient, $title, $message, $trigger_inbox, $id_join_company = null)
    {
        $inbox = new Inbox();
        $inbox->sender = $sender;
        $inbox->title = $title;
        $inbox->message = $message;
        $inbox->trigger_inbox = $trigger_inbox;
        $inbox->id_join_company = $id_join_company;
        $inbox->save();

        foreach ($recipient as $r) {
            $recipient_record = new InboxRecipient();
            $recipient_record->id_inbox = $inbox->id;
            $recipient_record->recipient = $r;
            $recipient_record->save();
        }

        return true;
    }

    public function viewManagementPrice()
    {
        return view('admin.management-price.index');
    }

    public function getGerbangPembayaran()
    {
        try {
            $id_gerbang_pembayaran = request()->input('id_gerbang_pembayaran');
            $query = GerbangPembayaran::query();

            if ($id_gerbang_pembayaran) {
                $query->where('id', $id_gerbang_pembayaran);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<button class="btn btn-success btn-sm" onclick="editData(' . $row->id . ')"><i class="fas fa-edit"></i> Edit</button> ';
                    $btn .= '<button class="btn btn-danger btn-sm" onclick="deleteData(' . $row->id . ')"><i class="fas fa-trash"></i> Delete</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } catch (\Exception $e) {
            return $this->error("Failed fetch gerbang pembayaran", 500);
        }
    }

    public function createOrUpdateGerbangPembayaran(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'price_pusat' => 'required|numeric',
                'price_cawangan' => 'required|numeric',
                'price_ketua_bahagian' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                return $this->error("Validation failed: " . $validator->errors()->first(), 400);
            }

            $data = GerbangPembayaran::updateOrCreate(
                ['id' => $request->input('id')],
                [
                    'price_pusat' => $request->price_pusat,
                    'price_cawangan' => $request->price_cawangan,
                    'price_ketua_bahagian' => $request->price_ketua_bahagian
                ]
            );

            return $this->success($data, "Successfully saved gerbang pembayaran", 200);
        } catch (\Throwable $th) {
            return $this->error("Failed create or update gerbang pembayaran", 500);
        }
    }

    public function deleteGerbangPembayaran($id_gerbang_pembayaran)
    {
        try {
            $data = GerbangPembayaran::findOrFail($id_gerbang_pembayaran);
            if (!$data) {
                return $this->error("Failed fetch gerbang pembayaran", 404);
            }
            $data->delete();

            return $this->success(null, "Successfully delete gerbang pembayaran", 200);
        } catch (\Exception $e) {
            return $this->error("Failed delete gerbang pembayaran", 500);
        }
    }

    /**
     * log pembayaran keahlian
     */
    public function viewLogPembayaranKeahlian()
    {
        $user = Auth::user();
        if ($user->id_level == 3) {
            $dataValidation = User::where('id', $user->id)->first();

            if (!$dataValidation) {
                return "Data not found!";
            }
            return view('admin.logPembayaranKeahlian.index', compact('dataValidation'));
        }
        return view('admin.logPembayaranKeahlian.index');
    }
    public function getLogPembayaranKeahlian()
    {
        try {
            $id = request()->input('id');
            $type = request()->input('type');
            // dd($type);
            $auth = Auth::user();
            if (!$auth) {
                return $this->error("Unauthorized", 401);
            }

            if ($id) {
                $data = LogPaymentManpower::with('user.city', 'detailManpower.cawangan')->findOrFail($id);

                // Jika request untuk detail modal (single data)
                return response()->json([
                    'data' => [$data], // Wrap in array untuk konsistensi dengan DataTables
                    'status' => 'success'
                ]);
            } else {
                $query = LogPaymentManpower::with('user.city', 'detailManpower.cawangan');

                if ($auth->id_level == 3) {
                    if ($type == 'renewal') {
                        $data = $query->where('id_user', $auth->id)->where('category', 'RENEWAL')->orderBy('created_at', 'desc')->get();
                    } elseif ($type == 'register') {
                        $data = $query->where('id_user', $auth->id)->where('category', 'REGISTER')->orderBy('created_at', 'desc')->get();
                    } else {
                        $data = $query->where('id_user', $auth->id)->orderBy('created_at', 'desc')->get();
                    }
                } else {
                    if ($type == 'renewal') {
                        $data = $query->where('category', 'RENEWAL')->orderBy('created_at', 'desc')->get();
                    } elseif ($type == 'register') {
                        $data = $query->where('category', 'REGISTER')->orderBy('created_at', 'desc')->get();
                    } else {
                        $data = $query->orderBy('created_at', 'desc')->get();
                    }
                }
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user_fullname', function ($row) {
                    return $row->user->fullname ?? 'N/A';
                })
                ->addColumn('user_phone_number', function ($row) {
                    return $row->user->phone_number ?? 'N/A';
                })
                ->addColumn('bahagian_name', function ($row) {
                    return $row->detailManpower->state->state ?? 'N/A';
                })
                ->addColumn('detail_manpower_ic_number', function ($row) {
                    return $row->detailManpower->ic_number ?? 'N/A';
                })
                ->addColumn('cawangan_name', function ($row) {
                    return $row->detailManpower->cawangan->fullname ?? 'N/A';
                })
                ->addColumn('formatted_created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('d/m/Y H:i') : 'N/A';
                })
                ->addColumn('formatted_amount', function ($row) {
                    return 'RM ' . number_format($row->amount, 2);
                })
                ->addColumn('type', function ($row) {
                    return $row->category;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<button class="btn btn-success btn-sm" onclick="editData(' . $row->id . ')"><i class="fas fa-eye"></i> View</button> ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => "Failed fetch log pembayaran keahlian, please try again later",
                'data' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * APPROVAL KETUA BAHAGIAN
     */

    public function approvalPaymentOutstading(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id_payment' => 'required',
                'file' => 'required|mimes:png,jpg,pdf|max:2048'
            ]);

            if ($validator->fails()) {
                return $this->error("Please check your file field", 400);
            }

            // Tentukan model berdasarkan type
            if ($request->input('type') == 'payment_cawangan') {
                $log = LogPaymentCawangan::find($request->id_payment);
            } else {
                $log = LogPaymentKetuaBahagian::find($request->id_payment);
            }

            if (!$log) {
                return $this->error("Log payment not found", 404);
            }

            // Handle file upload jika ada file
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                
                // Generate nama file yang unik
                $fileName = 'resit_' . $request->id_payment . '_' . time() . '.' . $file->getClientOriginalExtension();
                
                // Simpan file ke storage/app/public/receipts
                $filePath = $file->storeAs('receipts', $fileName, 'public');
                
                // Generate URL untuk file
                $fileUrl = url('storage/' . $filePath);
                
                // Hapus file lama jika ada
                if ($log->resit && Storage::disk('public')->exists(str_replace('storage/', '', parse_url($log->resit, PHP_URL_PATH)))) {
                    Storage::disk('public')->delete(str_replace('storage/', '', parse_url($log->resit, PHP_URL_PATH)));
                }
                
                // Update database dengan URL file
                $log->resit = $fileUrl;
                $log->status_approval = 'APPROVE';
            } else {
                $log->status_approval = 'PENDING';
            }

            $log->save();

            return $this->success($log, "Successfully upload resit", 200);

        } catch (\Exception $e) {
            Log::error('File upload error: ' . $e->getMessage());
            return $this->error("Failed approval, please try again later", 500);
        }
    }
}
