<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Session;
use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\Religion;
use App\Models\Nation;
use App\Models\SettingSubscribe;
use App\Models\BusinessActivity;
use App\Models\DetailManpower;
use App\Models\DetailCompany;
use App\Models\StatusEducation;
use App\Models\LogPaymentManpower;
use App\Models\Gender;
use App\Models\StatusNative;
use App\Models\Study;
use App\Models\BusinessType;
use App\Models\Certifikat;
use App\Models\PublishedCertificate;
use App\Models\SubBusinessActivity;
use App\Models\CategoryProduct;
use App\Models\BusinessIncome;
use App\Models\Agency;
use App\Models\AgencyPelatihan;
use App\Models\MaritalStatus;
use App\Models\JoinCompany;
use App\Models\LogPaymentJoinCompany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class RegisManpowerController extends Controller
{

    public function testSendEmailVerification($id)
    {
        $this->sendEmailVerification($id);
    }

    public function testSendEmailRegisAhli($id)
    {
        $this->sendEmailNoticeAhliRegistered($id);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DetailManpower::orderBy('id_detail_manpower', 'desc')->get();
            foreach ($data as $d) {
                $city = City::where('id_city', $d->id_city)->first();
                $state = State::where('id_state', $d->id_state)->first();
                $user = User::where('id', $d->id_user)->first();
                $d->city = isset($city) ? $city->city : '';
                $d->state = isset($state) ? $state->state : '';
                $d->first_name = isset($user) ? $user->first_name : '';

                $d->create_date = date('d-m-Y h:i:s', strtotime($d->created_at));
            }
            return DataTables::of($data)->addIndexColumn()->make(true);
        }
        return view('employee.index');
    }

    //All
    public function all_employed(Request $request)
    {
        if ($request->ajax()) {

            $data = DetailManpower::whereHas('user', function ($user) {
                $user->where('status', 'ACTIVE');
            })->with('user')
                ->where('current_work_status', 'EMPLOYED')
                ->orderBy('id_detail_manpower', 'desc')->get();

            foreach ($data as $d) {
                $city = City::where('id_city', $d->id_city)->first();
                $state = State::where('id_state', $d->id_state)->first();
                $user = User::where('id', $d->id_user)->first();
                $d->city = isset($city) ? $city->city : '';
                $d->state = isset($state) ? $state->state : '';
                $d->first_name = isset($user) ? $user->first_name : '';

                $d->create_date = date('d-m-Y h:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        return view('employee.all.employed');
    }

    public function all_unemployed(Request $request)
    {
        if ($request->ajax()) {

            $data = DetailManpower::whereHas('user', function ($user) {
                $user->where('status', 'ACTIVE');
            })->with('user')
                ->where('current_work_status', 'UNEMPLOYED')
                ->orderBy('id_detail_manpower', 'desc')->get();

            foreach ($data as $d) {
                $city = City::where('id_city', $d->id_city)->first();
                $state = State::where('id_state', $d->id_state)->first();
                $user = User::where('id', $d->id_user)->first();
                $d->city = isset($city) ? $city->city : '';
                $d->state = isset($state) ? $state->state : '';
                $d->first_name = isset($user) ? $user->first_name : '';

                $d->create_date = date('d-m-Y h:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        return view('employee.all.unemployed');
    }

    //Bumiputera
    public function bumiputera_employed(Request $request)
    {
        if ($request->ajax()) {

            $data = DetailManpower::whereHas('user', function ($user) {
                $user->where('status', 'ACTIVE');
            })->with('user')
                ->where('current_work_status', 'EMPLOYED')
                ->where('id_country', '1')
                ->where('id_state', '1')
                ->orderBy('id_detail_manpower', 'desc')->get();

            foreach ($data as $d) {
                $city = City::where('id_city', $d->id_city)->first();
                $state = State::where('id_state', $d->id_state)->first();
                $user = User::where('id', $d->id_user)->first();
                $d->city = isset($city) ? $city->city : '';
                $d->state = isset($state) ? $state->state : '';
                $d->first_name = isset($user) ? $user->first_name : '';

                $d->create_date = date('d-m-Y h:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        return view('employee.bumiputera.employed');
    }

    public function bumiputera_unemployed(Request $request)
    {
        if ($request->ajax()) {

            $data = DetailManpower::whereHas('user', function ($user) {
                $user->where('status', 'ACTIVE');
            })->with('user')
                ->where('current_work_status', 'UNEMPLOYED')
                ->where('id_country', '1')
                ->where('id_state', '1')
                ->orderBy('id_detail_manpower', 'desc')->get();

            foreach ($data as $d) {
                $city = City::where('id_city', $d->id_city)->first();
                $state = State::where('id_state', $d->id_state)->first();
                $user = User::where('id', $d->id_user)->first();
                $d->city = isset($city) ? $city->city : '';
                $d->state = isset($state) ? $state->state : '';
                $d->first_name = isset($user) ? $user->first_name : '';

                $d->create_date = date('d-m-Y h:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        return view('employee.bumiputera.unemployed');
    }

    //Other
    public function other_employed(Request $request)
    {
        if ($request->ajax()) {

            $data = DetailManpower::whereHas('user', function ($user) {
                $user->where('status', 'ACTIVE');
            })->with('user')
                ->where('current_work_status', 'EMPLOYED')
                ->where('id_country', '1')
                ->where('id_state', '!=', '1')
                ->orderBy('id_detail_manpower', 'desc')->get();

            foreach ($data as $d) {
                $city = City::where('id_city', $d->id_city)->first();
                $state = State::where('id_state', $d->id_state)->first();
                $user = User::where('id', $d->id_user)->first();
                $d->city = isset($city) ? $city->city : '';
                $d->state = isset($state) ? $state->state : '';
                $d->first_name = isset($user) ? $user->first_name : '';

                $d->create_date = date('d-m-Y h:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        return view('employee.other.employed');
    }

    public function other_unemployed(Request $request)
    {
        if ($request->ajax()) {

            $data = DetailManpower::whereHas('user', function ($user) {
                $user->where('status', 'ACTIVE');
            })->with('user')
                ->where('current_work_status', 'UNEMPLOYED')
                ->where('id_country', '1')
                ->where('id_state', '!=', '1')
                ->orderBy('id_detail_manpower', 'desc')->get();

            foreach ($data as $d) {
                $city = City::where('id_city', $d->id_city)->first();
                $state = State::where('id_state', $d->id_state)->first();
                $user = User::where('id', $d->id_user)->first();
                $d->city = isset($city) ? $city->city : '';
                $d->state = isset($state) ? $state->state : '';
                $d->first_name = isset($user) ? $user->first_name : '';

                $d->create_date = date('d-m-Y h:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        return view('employee.other.unemployed');
    }

    //Non
    public function non_employed(Request $request)
    {
        if ($request->ajax()) {

            $data = DetailManpower::whereHas('user', function ($user) {
                $user->where('status', 'ACTIVE');
            })->with('user')
                ->where('current_work_status', 'EMPLOYED')
                ->where('id_country', '!=', '1')
                ->orderBy('id_detail_manpower', 'desc')->get();

            foreach ($data as $d) {
                $city = City::where('id_city', $d->id_city)->first();
                $state = State::where('id_state', $d->id_state)->first();
                $user = User::where('id', $d->id_user)->first();
                $d->city = isset($city) ? $city->city : '';
                $d->state = isset($state) ? $state->state : '';
                $d->first_name = isset($user) ? $user->first_name : '';

                $d->create_date = date('d-m-Y h:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        return view('employee.non.employed');
    }

    public function non_unemployed(Request $request)
    {
        if ($request->ajax()) {

            $data = DetailManpower::whereHas('user', function ($user) {
                $user->where('status', 'ACTIVE');
            })->with('user')
                ->where('current_work_status', 'UNEMPLOYED')
                ->where('id_country', '!=', '1')
                ->orderBy('id_detail_manpower', 'desc')->get();

            foreach ($data as $d) {
                $city = City::where('id_city', $d->id_city)->first();
                $state = State::where('id_state', $d->id_state)->first();
                $user = User::where('id', $d->id_user)->first();
                $d->city = isset($city) ? $city->city : '';
                $d->state = isset($state) ? $state->state : '';
                $d->first_name = isset($user) ? $user->first_name : '';

                $d->create_date = date('d-m-Y h:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        return view('employee.non.unemployed');
    }


    // RegisterController.php
    public function create()
    {
        $status = 'Active';

        // Ambil semua bahagian
        $getBahagian = City::where('is_active', 'ENABLE')
            ->orderBy('city', 'ASC')
            ->get();

        // Kosongkan dulu data cawangan (biar hanya muncul setelah pilih bahagian)
        $data = collect();

        return view('employee.register.registerManpower', compact('data', 'getBahagian'));
    }

    // AJAX endpoint untuk ambil cawangan by bahagian
    public function getCawanganByBahagian($id_city)
    {
        $status = 'Active';

        $data = DetailCompany::with('user')
            ->where('id_city', $id_city)
            ->whereHas('user', function ($query) use ($status) {
                if ($status !== "Overall" && $status !== "") {
                    $query->where('status', $status);
                }
            })
            ->orderBy('created_at', 'DESC')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }


    public function registerStepTwo()
    {

        $state = State::where('is_active', 'ENABLE')->get();
        $city = City::where('is_active', 'ENABLE')->get();

        return view('employee.register.registerStepTwo', compact('state', 'city'));
    }

    public function registerStepThree()
    {

        $status_education = StatusEducation::where('is_active', 'ENABLE')->get();
        $study = Study::where('is_active', 'ENABLE')->get();

        return view('employee.register.registerStepThree', compact('status_education', 'study'));
    }

    public function registerStepFour()
    {

        if (Auth::user()) {
            $auth = Auth::user();

            $user = User::with('manpower')->where('id', $auth->id)->first();

            // return $user;
        } else {
            $user = null;
        }

        $business_activity = BusinessActivity::where('is_active', 'ENABLE')->get();
        $business_type = BusinessType::where('is_active', 'ENABLE')->get();
        $sub_business_activity = SubBusinessActivity::where('is_active', 'ENABLE')->get();
        $category_product = CategoryProduct::where('is_active', 'ENABLE')->get();
        $pegawai_daerah = User::where('status', 'ACTIVE')->where('id_level', 4)->get();
        $business_income = BusinessIncome::where('is_active', 'ENABLE')->where('type_income', "TAHUNAN")->get();

        $persatuan = User::with('company')->whereHas('company', function ($q) {
            $q->where('step_registration', 2);
        })->where('status', 'ACTIVE')->where('id_level', '2')->get();

        return view('employee.register.registerStepFour', compact('user', 'business_activity', 'business_type', 'sub_business_activity', 'category_product', 'pegawai_daerah', 'business_income', 'persatuan'));
    }

    public function registerStepFive()
    {

        $agency = Agency::where('is_active', 'ENABLE')->get();
        $business_type = BusinessType::where('is_active', 'ENABLE')->get();
        $sub_business_activity = SubBusinessActivity::where('is_active', 'ENABLE')->get();
        $category_product = CategoryProduct::where('is_active', 'ENABLE')->get();
        $pegawai_daerah = User::where('status', 'ACTIVE')->where('id_level', 4)->get();
        $business_income = BusinessIncome::where('is_active', 'ENABLE')->where('type_income', "TAHUNAN")->get();

        return view('employee.register.registerStepFive', compact('agency', 'business_type', 'sub_business_activity', 'category_product', 'pegawai_daerah', 'business_income'));
    }

    public function registerStepSix()
    {

        $agency_pelatihan = AgencyPelatihan::where('is_active', 'ENABLE')->get();
        $business_type = BusinessType::where('is_active', 'ENABLE')->get();
        $sub_business_activity = SubBusinessActivity::where('is_active', 'ENABLE')->get();
        $category_product = CategoryProduct::where('is_active', 'ENABLE')->get();
        $pegawai_daerah = User::where('status', 'ACTIVE')->where('id_level', 4)->get();
        $business_income = BusinessIncome::where('is_active', 'ENABLE')->where('type_income', "TAHUNAN")->get();

        return view('employee.register.registerStepSix', compact('agency_pelatihan', 'business_type', 'sub_business_activity', 'category_product', 'pegawai_daerah', 'business_income'));
    }

    public function registerStepSeven()
    {

        $business_income_monthly = BusinessIncome::where('is_active', 'ENABLE')->where('type_income', "BULANAN")->get();
        $business_income_weekly = BusinessIncome::where('is_active', 'ENABLE')->where('type_income', "MINGGUAN")->get();
        $business_income_daily = BusinessIncome::where('is_active', 'ENABLE')->where('type_income', "HARIAN")->get();

        // return compact('business_income_monthly', 'business_income_weekly', 'business_income_daily');

        return view('employee.register.registerStepSeven', compact('business_income_monthly', 'business_income_weekly', 'business_income_daily'));
    }

    public function registerInvoice(Request $request)
    {
        $user = Auth::user();
        $detail = DetailManpower::with('business_type_text')->where('id_user', $user->id)->first();
        $setting_subscribe = SettingSubscribe::where('subscribe_for', 'REGISTER AHLI')->where('is_active', 'ENABLE')->first();

        if ($detail->subscribe_free == '0') {
            $setting_subscribe->price = $setting_subscribe->price;
        }

        // Retrieve query parameters
        $daftar_persatuan = $request->query('daftar_persatuan');
        $code = $request->query('code');

        // Log for debugging
        \Log::info('Invoice route parameters:', [
            'daftar_persatuan' => $daftar_persatuan,
            'code' => $code
        ]);

        return view('employee.register.invoice', compact(
            'user',
            'detail',
            'setting_subscribe',
            'daftar_persatuan',
            'code'
        ));
    }

    public function registerPayment()
    {

        $user = Auth::user();
        $detail = DetailManpower::where('id_user', $user->id)->first();
        $setting_subscribe = SettingSubscribe::where('subscribe_for', 'REGISTER AHLI')->where('is_active', 'ENABLE')->first();

        if ($detail->subscribe_free    == '0') {
            $setting_subscribe->price = $setting_subscribe->price;
        }

        // return response()->json($detail);

        $encrypt = Crypt::encryptString($user->id);

        return view('employee.register.payment', compact('user', 'detail', 'setting_subscribe', 'encrypt'));
    }

    public function registerPaymentCash(Request $r)
    {

        $user = Auth::user();

        if ($r->ref) {
            $id_user = Crypt::decryptString($r->ref);
        } else {
            $id_user = $user->id;
        }

        $detail = DetailManpower::where('id_user', $id_user)->first();
        $setting_subscribe = SettingSubscribe::where('subscribe_for', 'REGISTER AHLI')->where('is_active', 'ENABLE')->first();

        if ($detail->subscribe_free    == '0') {
            $setting_subscribe->price = 0;
        }

        if ($setting_subscribe->price == 0) {

            // return $setting_subscribe->price;

            $request = new Request;
            $request->day = date('d', strtotime(now()));
            $request->month = date('m', strtotime(now()));
            $request->year = date('Y', strtotime(now()));
            $request->subscribe_status = "APPROVED";
            $request->responsefunction = 1;

            $response_log = $this->createLogPaymentManpower($request);

            // return $response_log;

            $request = new Request;
            $request->approval = "Approve";
            $request->approval_note = "Payment automatic approval by sistem!";
            $request->id_user_company = $id_user;

            $approval_payment = $this->approvalPayment($request, $response_log);

            // return $approval_payment;

            $detail->subscribe_free = 1;
            $detail->save();

            try {
                $this->sendEmailNoticeAhliRegistered($id_user);
            } catch (\Exception $e) {
            }


            if ($approval_payment) {

                if ($r->daftar_persatuan) {
                    return redirect()->to("/daftar_persatuan/$r->code");
                }

                return redirect()->to('/');
            }
        }

        // return response()->json($detail);

        return view('employee.register.paymentCash', compact('user', 'detail', 'setting_subscribe'));
    }

    public function registerStepTwoUpdate(Request $request)
    {

        $user = Auth::user();
        // dd($user);
        if ($request->input('registered_by_persatuan')) {
            // $id_user = Crypt::decryptString($request->ref);
            // $user = User::where('id', $id_user)->first();
            $key_ref = request()->input('ref');
            $companyDetail = DetailCompany::where('key_reference', $key_ref)->first();
        }
        $detail = DetailManpower::where('id_user', $user->id)->first();
        $detail->address = $request->address;
        $detail->id_country = '1';
        $detail->id_state = $request->negeri;
        $detail->id_city = $request->bandar;
        $detail->id_parliament = $request->parliament;
        $detail->id_dun = $request->dun;
        $detail->postcode = $request->poskod;
        $detail->step_registration = '6';

        $detail->key_reference = Str::random(6);

        $cek = DetailManpower::where('key_reference', $detail->key_reference)->first();
        if ($cek) {
            $detail->key_reference = Str::random(6);
            $cek = DetailManpower::where('key_reference', $detail->key_reference)->first();
            if ($cek) {
                $detail->key_reference = Str::random(6);
            }
        }

        if ($request->input('registered_by_persatuan')) {
            $log_payment = new LogPaymentManpower();
            $log_payment->id_user = $user->id;
            $log_payment->id_detail_manpower =  $detail->id_detail_manpower;
            $log_payment->day = date('d', strtotime(now()));
            $log_payment->month = date('m', strtotime(now()));
            $log_payment->year = date('Y', strtotime(now()));
            $log_payment->amount = "0";
            $log_payment->payment_proof = "default.png";
            $log_payment->created_by = $key_ref ? $companyDetail->id_user : Auth::user()->id;
            $detail->subscribe_free = 1;

            $subscribe_status = "APPROVED";
            $detail->subscribe_status = $subscribe_status;

            $log_payment->save();
            $detail->save();

            if (Auth::user()->id_level == '2' || $key_ref) {
                $request = new Request;
                $request->approval = "Approve";
                $request->approval_note = "Payment bypass via Persatuan!";

                $approval_payment = $this->approvalPayment($request, $log_payment->id_log_payment_manpower);

                $company = DetailCompany::where('id_user', $companyDetail->id_user)->first();

                $join_company = new JoinCompany();
                $join_company->id_detail_manpower = $detail->id_detail_manpower;
                $join_company->id_detail_company = $company->id_detail_company;
                $join_company->joining_fee = $company->joining_fee;
                $join_company->status_approval = "APPROVED";
                $join_company->status_approval_at = date("Y-m-d H:i:s");
                $join_company->status_approval_by = $companyDetail->id_user;
                $join_company->created_by = $companyDetail->id_user;

                $newDateTime = Carbon::now()->addYear(1);

                $join_company->expired_at = $newDateTime;
                $join_company->payment_method = "CASH";
                $join_company->payment_date = date("Y-m-d H:i:s");

                $join_company->save();

                $log_payment_join_company = new LogPaymentJoinCompany();
                $log_payment_join_company->id_request_join_company = $join_company->id;
                $log_payment_join_company->id_user = $user->id;
                $log_payment_join_company->id_detail_manpower =  $join_company->id_detail_manpower;
                $log_payment_join_company->id_detail_company =  $join_company->id_detail_company;
                $log_payment_join_company->day = date('d', strtotime(now()));
                $log_payment_join_company->month = date('m', strtotime(now()));
                $log_payment_join_company->year = date('Y', strtotime(now()));
                $log_payment_join_company->amount = $join_company->joining_fee;
                $log_payment_join_company->payment_proof = "default.png";
                $log_payment_join_company->created_by = $companyDetail->id_user;

                $log_payment_join_company->approval = "Approved";
                $log_payment_join_company->approval_date = now();
                $log_payment_join_company->approval_by = $companyDetail->id_user;
                $log_payment_join_company->approval_note = "Payment bypass via Persatuan!";

                $log_payment_join_company->save();
            }
        }

        $detail->save();

        return $this->commitResponse('Update data successfuly!', true);

        // return redirect()->to('/home');

    }

    public function approvalPayment(Request $request, $id)
    {

        $user = Auth::user();

        $data = LogPaymentManpower::where('id_log_payment_manpower', $id)->first();
        $check_exists = \App\Models\PublishedCertificate::where('id_user', $data->id_user)->first();

        if (!$data) {
            $result = [
                'message' => "Payment not found!"
            ];

            return $result;
        }

        $detail_manpower = DetailManpower::where('id_user', $data->id_user)->first();
        $approval = "Waiting";
        if ($request->approval == "Approve") {
            $approval = "Approved";
            $detail_manpower->is_subscribe = "TRUE";
            $detail_manpower->subscribe_status = "APPROVED";

            $certificate = Certifikat::first();
            $publish = new PublishedCertificate();
            $running_number = PublishedCertificate::orderBy('id_published_certificate', 'desc')->first();

            $dateNow = date("dmy");

            if (!$check_exists) {
                if ($running_number) {
                    $add_number = ((int)$running_number->number_certificate) + 1;
                    $next_number = str_pad($add_number, 6, '0', STR_PAD_LEFT);
                } else {
                    $next_number = str_pad(1, 6, '0', STR_PAD_LEFT);
                }
            }

            // FIX: Cast valid_time ke integer
            $validTime = (int) $certificate->valid_time;

            // Gunakan addYears (plural) untuk multiple years, atau addYear untuk single year
            if ($validTime == 1) {
                $newDateTime = Carbon::now()->addYear();
            } else {
                $newDateTime = Carbon::now()->addYears($validTime);
            }

            if (!$check_exists) {
                $detail_manpower->number_certificate = 'A' . $dateNow . '-' . $next_number;
                $publish->number_certificate = $next_number;
                $publish->id_user = $detail_manpower->id_user;
                $publish->expire_date = $newDateTime;
                $publish->save();
            } else {
                $check_exists->expire_date = $newDateTime;
                $check_exists->save();
            }

            // Cast juga saat menyimpan ke detail_manpower
            $detail_manpower->valid_time_certificate = $validTime;
            $detail_manpower->certificate_expired_date = $newDateTime;
        } else {
            $approval = "Rejected";
            $detail_manpower->is_subscribe = "FALSE";
            $detail_manpower->subscribe_status = "REJECTED";
        }

        $data->approval = $approval;
        $data->approval_date = now();
        $data->approval_by = $user->id;
        $data->approval_note = $request->approval_note;

        $data->save();
        $detail_manpower->save();

        $result = [
            'message' => "Approval Successfully",
            'data' => $data,
        ];

        return response()->json($result);
    }

    public function listLogPaymentManpower(Request $request)
    {

        $user = Auth::user();

        if ($request->ajax()) {

            $data = LogPaymentManpower::with('user', 'user.manpower')->whereHas('user');
            $status = $request->status;
            $id = $request->id;

            // return $user->id_level;
            if ($user->id_level != 1 && $user->id_level != 4) {
                $data = $data->where('id_user', $user->id);
            }

            if ($status) {
                $data = $data->where('approval', $status);

                if ($status == "Approved" || $status == "Rejected") {
                    $data = $data->orderBy('id_log_payment_manpower', 'DESC');
                }
            }

            if ($user->id_level == 4) {

                $pegawai_daerah = User::select('id')->where('id_city', $user->id_city)->where('id_level', 4)->get();

                foreach ($pegawai_daerah as $i => $d) {
                    if ($i == 0) {
                        $data = $data->whereHas('user.manpower', function ($query) use ($d) {
                            $query->where('id_pegawai_daerah', $d->id);
                        });
                    } else {
                        $data = $data->whereHas('user.manpower', function ($query) use ($d) {
                            $query->orWhere('id_pegawai_daerah', $d->id);
                        });
                    }
                }

                // $data = $data->whereHas('user.manpower', function($query) use($user) {
                //     $query->where('id_pegawai_daerah', $user->id);
                // });
            }

            if ($id) {
                $data = $data->where('id_log_payment_manpower', $id);
            }

            $data = $data->get();

            foreach ($data as $d) {
                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
                $d->approval_by_name = "";
                $by = User::where('id', $d->approval_by)->first();
                if ($by) {
                    $d->approval_by_name = $by->fullname;
                }
            }

            if ($request->responseJson) {
                $result = [
                    'message' => "Success get data",
                    'data' => $data
                ];
                return response()->json($result);
            }

            return Datatables::of($data)->addIndexColumn()->make(true);
        }

        // $data = LogPaymentManpower::with('user')->get();
        // foreach($data as $d){
        //     $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
        // }

        // return $data;

        return view('logPayment.index');
    }

    public function createLogPaymentManpower(Request $request)
    {

        $user = Auth::user();

        if ($request->ref) {
            $id_user = Crypt::decryptString($request->ref);
        } else {
            $id_user = $user->id;
        }

        $detail = DetailManpower::where('id_user', $id_user)->first();

        $setting_subscribe = SettingSubscribe::where('subscribe_for', 'REGISTER AHLI')->where('is_active', 'ENABLE')->first();

        if ($detail->subscribe_free    == '0') {
            $setting_subscribe->price = 0;
        }

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $n = $file->getClientOriginalName();
            $current_date = date('Ymdhis');
            $name = "$current_date$n";
            $file->move(public_path() . '/ImagePaymentProof', $name);
            $image = $name;
        } else {
            $image = 'default.png';
        }

        $log_payment = new LogPaymentManpower();
        $log_payment->id_user = $id_user;
        $log_payment->id_detail_manpower =  $detail->id_detail_manpower;
        $log_payment->day = date('d', strtotime(now()));
        $log_payment->month = date('m', strtotime(now()));
        $log_payment->year = date('Y', strtotime(now()));
        $log_payment->amount = $setting_subscribe->price;
        $log_payment->payment_proof = $image;
        $log_payment->created_by = $user->id;

        $subscribe_status = "WAITING";
        if ($request->subscribe_status) $subscribe_status = $request->subscribe_status;

        $detail->subscribe_status = $subscribe_status;

        $log_payment->save();
        $detail->save();

        if (Auth::user()->id_level == '1') {
            $request = new Request;
            $request->approval = "Approve";
            $request->approval_note = "Payment bypass via Admin!";
            $request->id_user_company = $id_user;

            $approval_payment = $this->approvalPayment($request, $log_payment->id_log_payment_manpower);

            return redirect()->to('/senaraiAhli?status=Expired');
        }

        if ($request->responsefunction) {

            return $log_payment->id_log_payment_manpower;
            // $result = [
            //     'data' => ['logPayment' => $log_payment, 'detail' => $detail]
            // ];
            // return response()->json($result);
        }

        return redirect()->to('/');
    }

    public function waitingPaymentApproval()
    {
        return view('employee.register.waitingPaymentApproval');
    }

    public function registerStepThreeUpdate(Request $request)
    {

        $user = Auth::user();

        // return $user;

        $detail = DetailManpower::where('id_user', $user->id)->first();

        $detail->id_status_education = $request->status_education;
        $detail->education_field = $request->bidang;

        $sijil_kemahiran = $request->sijil_kemahiran;
        array_pop($sijil_kemahiran);
        $detail->skills_certificate = $sijil_kemahiran;

        $sijil_kemahiran_tahun = $request->sijil_kemahiran_tahun;
        array_pop($sijil_kemahiran_tahun);
        $detail->skills_certificate_year = $sijil_kemahiran_tahun;

        $detail->step_registration = '3';
        $detail->save();

        return redirect()->to('/home');
    }

    public function registerStepFourUpdate(Request $request)
    {

        $user = Auth::user();

        // return $user;

        if ($request->hasFile('img_perniagaan')) {
            $file = $request->file('img_perniagaan');
            $n = $file->getClientOriginalName();
            $current_date = date('Ymdhis');
            $name = "$current_date$n";
            $file->move(public_path() . '/BusinessImage', $name);
            $perniagaan_picture = $name;
        } else {
            $perniagaan_picture = 'default.png';
        }

        if ($request->hasFile('img_produk')) {
            $file = $request->file('img_produk');
            $n = $file->getClientOriginalName();
            $current_date = date('Ymdhis');
            $name = "$current_date$n";
            $file->move(public_path() . '/BusinessProductImage', $name);
            $product_picture = $name;
        } else {
            $product_picture = 'default.png';
        }

        $detail = DetailManpower::where('id_user', $user->id)->first();


        if ($request->persatuan && $request->persatuan != '0') {
            $detail->id_detail_company = $request->persatuan;
        }

        // return $detail;

        $detail->id_pegawai_daerah = $request->pegawai_daerah;
        $detail->name_of_business = $request->nama_perniagaan;
        $detail->business_type = $request->jenis_pendaftaran_perniagaan;
        $detail->business_license_no = $request->no_lesen_berniaga;
        $detail->business_address = $request->alamat_perniagaan;
        $detail->business_lat = $request->place_latitude;
        $detail->business_lng = $request->place_longitude;
        $detail->business_activity = $request->aktiviti_perniagaan;
        $detail->sub_business_activity = $request->jenis_kategori_perniagaan;
        $detail->category_product = $request->kategori_produk;
        $detail->business_income = $request->pendapatan_tahunan;
        $detail->business_phone = $this->adjustPhoneNumberMy($request->no_telefon_perniagaan);
        $detail->business_email = $request->emel;

        $detail->picture_of_business = $perniagaan_picture;
        $detail->picture_product = $product_picture;

        $medsos = $request->medsos;
        array_pop($medsos);
        $detail->business_sosmed = $medsos;

        $pautan = $request->pautan;
        array_pop($pautan);
        $detail->business_sosmed_link = $pautan;

        $detail->website = $request->website_syarikat;
        $detail->step_registration = '4';
        $detail->save();

        // $this->sendEmailInvoice($user->id);

        return redirect()->to('/home');
    }

    public function registerStepFiveUpdate(Request $request)
    {

        $user = Auth::user();

        $detail = DetailManpower::where('id_user', $user->id)->first();

        $detail->q_financing = $request->radio1;

        if ($request->agency) {
            $id_agency = $request->agency;
            // array_pop($id_agency);
            $detail->id_agency = $id_agency;
        }


        $jumlah_pinjaman = $request->jumlah_pinjaman;
        array_pop($jumlah_pinjaman);
        $detail->agency_loan_amount = $jumlah_pinjaman;

        $tahun_pinjaman = $request->tahun_pinjaman;
        array_pop($tahun_pinjaman);
        $detail->agency_load_year = $request->tahun_pinjaman;

        $detail->q_financing_interest = $request->radio2;

        $detail->id_agency_interest = $request->agency_minat;
        $detail->financing_amount_interest = $request->request_pembiayaan;

        $detail->save();

        // $this->sendEmailInvoice($user->id);

        return redirect()->to('/register_ahli/step_six');
    }

    public function registerStepSixUpdate(Request $request)
    {

        $user = Auth::user();

        $detail = DetailManpower::where('id_user', $user->id)->first();

        $detail->q_pelatihan = $request->radio1;
        $detail->choose_agency_pelatihan = $request->agency_minat;
        $detail->header_class = $request->tajuk_kelas;

        $detail->save();

        // $this->sendEmailInvoice($user->id);

        return redirect()->to('/register_ahli/step_seven');
    }

    public function registerStepSevenUpdate(Request $request)
    {

        $user = Auth::user();

        $detail = DetailManpower::where('id_user', $user->id)->first();

        $detail->business_income_monthly = $request->business_income_monthly;
        $detail->business_income_weekly = $request->business_income_weekly;
        $detail->business_income_daily = $request->business_income_daily;

        $detail->save();

        // $this->sendEmailInvoice($user->id);

        return redirect()->to('/home');
    }

    public function semakPendaftaran(Request $request)
    {

        return view('employee.register.checkRegistration');
    }

    public function semakPendaftaranResult(Request $request)
    {

        $manpower = DetailManpower::where('ic_number', $request->no_kad)->first();

        if ($manpower) {

            $tgl_daftar = date_format($manpower->created_at, "d/m/Y");

            $data = [
                "no_kad" => "MYKADNO. $request->no_kad",
                "level" => "ahli",
                "message" => "Ahli USIA berdaftar pada $tgl_daftar",
            ];
        } else {
            $data = [
                "no_kad" => "MYKADNO. $request->no_kad",
                "level" => "notfound",
                "message" => "Individu belum mendaftar USIA",
            ];
        }

        // return $data['no_kad'];

        return view('employee.register.checkRegistrationResult', compact('data'));
    }

    public function store(Request $request)
    {
        $auth = Auth::user();
        $authCompany = false;

        if (isset($auth)) {
            if ($auth->id_level != 2) {
                return $this->commitResponse('Anda tidak bisa membuat akaun ahli, silahkan logout dahulu!');
            }
            $authCompany = true;
        }

        $user = new User;

        $email = $request->email;
        $em = User::where('email', $email)->first();

        if ($em) {
            return $this->commitResponse('Emel anda sudah digunakan, sila guna emel lain!');
        }

        $isForeign = $request->is_foreign == 1 || $request->is_foreign == "true" || $request->is_foreign == true;

        if (!$isForeign) {
            $ic_number = preg_replace("/[^0-9]+/", "", $request->no_kad);
        } else {
            $ic_number = $request->no_kad;
        }

        $emic = DetailManpower::where('ic_number', $ic_number)->first();

        if ($emic) {
            return $this->commitResponse('IC Number sudah digunakan!');
        }

        $dial_code = substr($request->dial_code, 1);

        $user->fullname = $request->nama_penuh;
        $user->phone_number = $this->adjustPhoneNumberMy("$dial_code$request->no_telefon");
        $user->email = $request->email;
        $user->id_level = 3;

        if ($authCompany) {
            $user->registered_by = $auth->id;
            $user->is_verified = true;
            $user->email_verified_at = date('d-m-Y h:i:s');
            $user->verified_by = $auth->id;
        }

        $user->password = Hash::make($request->password);
        $user->save();

        if ($user) {
            $employee = new DetailManpower;
            $employee->id_user = $user->id;
            $employee->ic_number = $ic_number;
            $employee->is_foreign = $isForeign;

            // Sudah tidak ada id_cawangan, pencadang, peyokong, mualaf, tarikh_pengislaman
            $employee->save();
        }

        if (!$authCompany) {
            try {
                $this->sendEmailVerification($user->id, $request->daftar_persatuan, $request->code);
            } catch (\Exception $e) {
                // Handle exception silently
            }
        }

        $encrypt = Crypt::encryptString($user->id);
        return $this->commitResponse('Registration Successfuly!', true, $encrypt);
    }



    public function verify_email(Request $r, $id)
    {
        return $id;
    }

    public function index_detail_employee($id, $id_max)
    {

        $data = User::findOrFail($id);

        setlocale(LC_MONETARY, 'ms_MY');

        $data->auth_paid_up_capital = money_format('%i', $data->company->auth_paid_up_capital);
        $data->paid_up_capital = money_format('%i', $data->company->paid_up_capital);

        $user = $id;

        $data_bumiputera = CompanyShareHolders::where('id_user', $user)->where('id_status', '1')->sum('total');
        $data_non_bumiputera = CompanyShareHolders::where('id_user', $user)->where('id_status', '2')->sum('total');
        $data_foreign = CompanyShareHolders::where('id_user', $user)->where('id_status', '3')->sum('total');

        $company_detail = DetailCompany::where('id_user', $user)->first();

        if ($company_detail->paid_up_capital !== null) {
            $data->percentage_bumiputera = number_format((($data_bumiputera / $company_detail->paid_up_capital) * 100), 1, ',', '.') . '%';
        } else {
            $data->percentage_bumiputera = '0%';
        }

        if ($company_detail->paid_up_capital !== null) {
            $data->percentage_non_bumiputera = number_format((($data_non_bumiputera / $company_detail->paid_up_capital) * 100), 1, ',', '.') . '%';
        } else {
            $data->percentage_non_bumiputera = '0%';
        }

        if ($company_detail->paid_up_capital !== null) {
            $data->percentage_foreign = number_format((($data_foreign / $company_detail->paid_up_capital) * 100), 1, ',', '.') . '%';
        } else {
            $data->percentage_foreign = '0%';
        }

        $data_equity_by_status = [
            'bumiputera' => $data_bumiputera,
            'non-bumiputera' => $data_non_bumiputera,
            'foreign' => $data_foreign
        ];

        $data->bumiputera = money_format('%i', $data_bumiputera);
        $data->non_bumiputera = money_format('%i', $data_non_bumiputera);
        $data->foreign = money_format('%i', $data_foreign);

        $status_certificate = LogCertificate::where('id_user', $id)
            ->where('id_log_certificate', $id_max)->first();

        $data->status_detail = $status_certificate->status;

        $data->id_user_company = $id;


        // return view('company.viewCompanyEquityBreakdown', compact('data'));
        return view('company.active.detailCompany', compact('data'));
    }
}
