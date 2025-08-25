<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailManpower;
use App\Models\DetailCompany;
use App\Models\JoinCompany;
use App\Models\User;
use App\Models\Religion;
use App\Models\State;
use App\Models\City;
use App\Models\Nation;
use App\Models\StatusNative;
use App\Models\Gender;
use App\Models\MaritalStatus;
use App\Models\AppConfig;
use App\Models\Payment;
use App\Models\Parliament;
use App\Models\Dun;
use App\Models\BusinessType;
use App\Models\BusinessActivity;
use App\Models\ManpowerPosition;
use App\Models\SubBusinessActivity;
use Auth;
use PDF;
use Redirect;

class EmployeeController extends Controller
{

    public function viewMap()
    {
        $city = City::select('id_city', 'city', 'representation', 'association', 'description', 'description2', 'phone_number', 'latitude', 'longitude', 'is_active')->where('is_active', 'ENABLE')->get();

        foreach($city as $d) {

            $d->city = strtoupper($d->city);


            $data_overall = DetailManpower::whereHas('user', function($user) {
                $user->where('status','ACTIVE');
            })->with('user')
            ->where('step_registration', DetailManpower::$stepRegistration)
            ->where('id_city', $d->id_city)->get()->count();

            $d->total_ahli_overall = $data_overall;

            $data = DetailManpower::select('id_detail_manpower', 'id_user', 'step_registration', 'id_city', 'business_income_weekly', 'certificate_expired_date')->whereHas('user', function($user) {
                $user->where('status','ACTIVE');
            })->with('user', function ($query) {
                $query->select('id','fullname');
            })
            ->where('step_registration', DetailManpower::$stepRegistration)
            ->where('id_city', $d->id_city)
            ->whereDate('certificate_expired_date', '>', now())->get()->count();

            $d->total_ahli = $data;

            $total_ahli_business_income_weekly = DetailManpower::select('id_detail_manpower', 'step_registration', 'id_city', 'business_income_weekly', 'certificate_expired_date')
            ->where('step_registration', DetailManpower::$stepRegistration)
            ->where('id_city', $d->id_city)
            ->where('business_income_weekly', '!=', null)
            ->whereDate('certificate_expired_date', '>', now())->get();

            $total_ahli_business_income_monthly = DetailManpower::select('id_detail_manpower', 'step_registration', 'id_city', 'business_income_monthly', 'certificate_expired_date')
            ->where('step_registration', DetailManpower::$stepRegistration)
            ->where('id_city', $d->id_city)
            ->where('business_income_monthly', '!=', null)
            ->whereDate('certificate_expired_date', '>', now())->get();

            $totalWeekly = 0;
            $avgWeekly = 0;
            foreach ($total_ahli_business_income_weekly as $item) {
                $totalWeekly = $totalWeekly+=$item->business_income_weekly;
            }

            if ($total_ahli_business_income_weekly->count() != 0) {
                $avgWeekly = round((int) $totalWeekly / (int) $total_ahli_business_income_weekly->count(), 2);
            }

            $d->total_weekly = "RM$avgWeekly";

            $totalMonthly = 0;
            foreach ($total_ahli_business_income_monthly as $item) {
                $totalMonthly = $totalMonthly+=$item->business_income_monthly;
            }

            if ($total_ahli_business_income_monthly->count() != 0) {
                $avgMonthly = round((int) $totalMonthly / (int) $total_ahli_business_income_monthly->count(), 2);
            }

            $d->total_monthly = "RM$avgMonthly";

            $total_ahli_business_type_all= DetailManpower::select('id_detail_manpower','business_type', 'id_city')->where('step_registration', DetailManpower::$stepRegistration)
            ->where('business_type', '!=', null)
            ->where('id_city', $d->id_city)
            ->get()->count();

            $business_type = BusinessType::select('id_business_type', 'business_type')->where('is_active', 'ENABLE')->get();

            foreach ($business_type as $item) {
                $total = DetailManpower::where('step_registration', DetailManpower::$stepRegistration)->where('business_type', $item->id_business_type)->where('id_city', $d->id_city)->get()->count();

                if ($total != 0) {
                    $sum = round(($total/$total_ahli_business_type_all)*100, 2);
                    $item->percentage_value = $sum;
                    $item->percentage_label = "$sum%";
                } else {
                    $sum = 0;
                    $item->percentage_value = $sum;
                    $item->percentage_label = "$sum%";
                }

            }

            $sortedArrayBusinessType = $business_type->sortByDesc('percentage_value')->values()->toArray();
            $top3BusinessType = array_slice($sortedArrayBusinessType, 0, 3);

            $percentBusinessType = array_sum(array_column($top3BusinessType, 'percentage_value'));
            if ($percentBusinessType != 0) {
                $othersBusinessType = round(100 - $percentBusinessType, 2);
                if ($othersBusinessType < 0) {
                    $othersBusinessType = 0;
                }
            } else {
                $othersBusinessType = 0;
            }

            $top3BusinessType[] = [
                'business_type' => 'Lain-lain',
                'percentage_value' => $othersBusinessType,
                'percentage_label' => "$othersBusinessType%",
            ];

            $total_ahli_business_activity_all= DetailManpower::where('step_registration', DetailManpower::$stepRegistration)
            ->where('business_activity', '!=', null)
            ->where('id_city', $d->id_city)
            ->get()->count();

            $business_activity = BusinessActivity::select('id_business_activity', 'business_activity')->where('is_active', 'ENABLE')->get();

            foreach ($business_activity as $item) {

                $total = DetailManpower::where('step_registration', DetailManpower::$stepRegistration)->where('business_activity', $item->id_business_activity)->where('id_city', $d->id_city)->get()->count();

                if ($total != 0) {
                    $sum = round(($total/$total_ahli_business_activity_all)*100, 2);
                    $item->percentage_value = $sum;
                    $item->percentage_label = "$sum%";
                } else {
                    $sum = 0;
                    $item->percentage_value = $sum;
                    $item->percentage_label = "$sum%";
                }

            }

            $sortedArrayBusinessActivity = $business_activity->sortByDesc('percentage_value')->values()->toArray();
            $top6BusinessActivity = array_slice($sortedArrayBusinessActivity, 0, 6);

            $percentBusinessActivity = array_sum(array_column($top6BusinessActivity, 'percentage_value'));
            if ($percentBusinessActivity != 0) {
                $othersBusinessActivity = round(100 - $percentBusinessActivity, 2);
                if ($othersBusinessActivity < 0) {
                    $othersBusinessActivity = 0;
                }
            } else {
                $othersBusinessActivity = 0;
            }

            $top6BusinessActivity[] = [
                'business_activity' => 'Lain-lain',
                'percentage_value' => $othersBusinessActivity,
                'percentage_label' => "$othersBusinessActivity%",
            ];

            $d->business_type = $top3BusinessType;
            $d->business_activity = $top6BusinessActivity;

            $total_ahli_sub_business_activity_all= DetailManpower::where('step_registration', DetailManpower::$stepRegistration)
            ->where('sub_business_activity', '!=', null)
            ->where('id_city', $d->id_city)
            ->get()->count();

            $sub_business_activity = SubBusinessActivity::select('id_sub_business_activity', 'sub_business_activity')->where('is_active', 'ENABLE')->get();

            foreach ($sub_business_activity as $item) {

                $total = DetailManpower::where('step_registration', DetailManpower::$stepRegistration)->where('sub_business_activity', 'LIKE' . '%' . $item->id_sub_business_activity . '%')->where('id_city', $d->id_city)->get()->count();

                if ($total != 0) {
                    $sum = round(($total/$total_ahli_sub_business_activity_all)*100, 2);
                    $item->percentage_value = $sum;
                    $item->percentage_label = "$sum%";
                } else {
                    $sum = 0;
                    $item->percentage_value = $sum;
                    $item->percentage_label = "$sum%";
                }

            }

            $sortedArraySubBusinessActivity = $sub_business_activity->sortByDesc('percentage_value')->values()->toArray();
            $top3SubBusinessActivity = array_slice($sortedArraySubBusinessActivity, 0, 3);

            $percentSubBusinessActivity = array_sum(array_column($top3SubBusinessActivity, 'percentage_value'));
            if ($percentSubBusinessActivity != 0) {
                $othersSubBusinessActivity = round(100 - $percentSubBusinessActivity, 2);
                if ($othersSubBusinessActivity < 0) {
                    $othersSubBusinessActivity = 0;
                }
            } else {
                $othersSubBusinessActivity = 0;
            }

            $top3SubBusinessActivity[] = [
                'sub_business_activity' => 'Lain-lain',
                'percentage_value' => $othersSubBusinessActivity,
                'percentage_label' => "$othersSubBusinessActivity%",
            ];

            $d->sub_business_activity = $top3SubBusinessActivity;

        }

        // return $city;

        return view('viewmap.index', compact('city'));
    }

    public function checkUserWithoutCity()
    {
        // $data = User::findOrFail($id);

      //  $city = City::where('is_active', 'ENABLE')->get();

    //    foreach($city as $d) {

            $data = DetailManpower::whereHas('user', function($user) {
                $user->where('status','ACTIVE');
            })->with('user')
            ->where('step_registration', 6)
            ->whereNull('id_city')->count();

            return response()->json($data);

     //   }

    //    return view('viewmap.index', compact('city'));
    }

    public function show($id)
    {
        $data = User::findOrFail($id);
        $dataValidation = User::findOrFail($id);

        $manpower = DetailManpower::with('cawangan', 'ketuaBahagian')->where('id_user', $id)->first();

        $joinCompany = JoinCompany::with(['company' => function ($query) {
            $query->select('id_detail_company', 'full_company_name', 'logo_picture');
        }])->where('id_detail_manpower', $manpower->id_detail_manpower)->whereDate('expired_at', '>', now())->get();

        return view('employee.viewPersonalDetail', compact('data', 'dataValidation', 'joinCompany', 'manpower'));
    }

    public function profilDigital(Request $request) {

        $user = new User();

        if($request->id_user){
            $user->id = $request->id_user;
            $data = DetailManpower::with('user')->where('id_user', $user->id)->first();
            $company = DetailCompany::where('id_user', Auth::user()->id)->first();
            $request_join = JoinCompany::where('id_detail_manpower', $data->id_detail_manpower)->where('id_detail_company', $company->id_detail_company)->where('status_approval', 'WAITING')->first();
        } else {
            $user = Auth::user();
        }

        $dataValidation = User::where('id', $user->id)->first();

        if(!$dataValidation) {
            return "Data not found!";
        }

        $data = DetailManpower::with('user')->where('id_user', $user->id)->first();

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://sys.rikod.my/api/codeCompany?email=$user->email",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $decode = json_decode($response);

        if(isset($decode))
            $data->company_code = $decode->data;

        $data->share_link = env('APP_URL').'/id/'.$data->key_reference;
        if(isset($request_join)){
            $data->request_join = $request_join;
        }

        if(!$data) {
            return "Data not found!";
        } else {

            if($request->api){
                return response()->json($data);
            } else {
                return view('employee.digitalProfile', compact('data', 'dataValidation'));
            }
        }

    }

    // public function companyCard(Request $request) {

    //     $user = Auth::user();

    //     if($request->id) {
    //         $user->id = $request->id;
    //     }

    //     $dataValidation = User::findOrFail($user->id);

    //     $data = DetailManpower::with('user')->where('id_user', $user->id)->first();

    //     $payment = Payment::where('id_user', $user->id)->where('paid', '0')->orderBy('id', 'DESC')->first();

    //     $data->paymentPending = false;
    //     if($payment){
    //         $data->paymentPending = true;
    //     }

    //     if(!isset($data->key_reference)) {
    //         return "Data not valid!";
    //     }

    //     $data->share_link = env('APP_URL').'/id/'.$data->key_reference;

    //     if(substr($data->business_phone, 0, 2) == "60"){
    //         $data->business_phone = substr($data->business_phone, 1);
    //     } else if (substr($data->business_phone, 0, 1) != "0") {
    //         $data->business_phone = "0$data->business_phone";
    //     } else {
    //         $data->business_phone = $data->business_phone;
    //     }

    //     // dd($data->user);
    //     if(!$data) {
    //         return "Data not found!";
    //     } else {
    //         return view('employee.companyCard', compact('data', 'payment', 'dataValidation'));
    //     }

    // }

     public function companyCard(Request $request) {

        $user = Auth::user();

        if($request->id) {
            $user->id = $request->id;
        }

        $dataValidation = User::findOrFail($user->id);

        $data = DetailManpower::with('user')->where('id_user', $user->id)->first();

        $payment = Payment::where('id_user', $user->id)->where('paid', '0')->orderBy('id', 'DESC')->first();

        $data->paymentPending = false;
        if($payment){
            $data->paymentPending = true;
        }

        if(!isset($data->key_reference)) {
            return "Data not valid!";
        }

        $data->share_link = env('APP_URL').'/id/'.$data->key_reference;

        if(substr($data->business_phone, 0, 2) == "60"){
            $data->business_phone = substr($data->business_phone, 1);
        } else if (substr($data->business_phone, 0, 1) != "0") {
            $data->business_phone = "0$data->business_phone";
        } else {
            $data->business_phone = $data->business_phone;
        }
        $data_manpower_position = ManpowerPosition::where('id_user', $data->id_user)->first();
        $jawatan = $data_manpower_position ? $data_manpower_position->position->position : 'AHLI USIA';
        // dd($data->user);
        if(!$data) {
            return "Data not found!";
        } else {
            return view('employee.companyCard', compact('data', 'payment', 'dataValidation', 'jawatan'));
        }

    }

    public function cetakProfilDigital()
    {

        $user = Auth::user();

        $data = DetailManpower::with('user')->where('id_user', $user->id)->first();
        $data->share_link = env('APP_URL').'/id/'.$data->key_reference;

        if(!$data) {
            return "Data not found!";
        }

        $pdf = PDF::loadview('digitalprofile.index',['data'=>$data])->setPaper('a4', 'landscape');

    	return $pdf->stream();
    }

    public function cetakCompanyCard(Request $request)
    {

        $user = Auth::user();

        if($request->id) {
            $user->id = $request->id;
        }

        $data = DetailManpower::with('user')->where('id_user', $user->id)->first();
        if(!isset($data->key_reference)) {
            return "Data not valid!";
        }

        $data->share_link = env('APP_URL').'/id/'.$data->key_reference;

        if(!$data) {
            return "Data not found!";
        }
        $data_manpower_position = ManpowerPosition::where('id_user', $data->id_user)->first();
        $jawatan = $data_manpower_position ? $data_manpower_position->position->position : 'AHLI USIA';
        $data->jawatan = $jawatan;
        $customPaper = array(0,0,441.00,643.80);
        $pdf = PDF::loadview('companycard.index',['data'=>$data])->setPaper('a4', 'landscape');

        return view('companycard.index', compact('data'));

    	return $pdf->stream();
    }

    public function invoiceCompanyCard(Request $request)
    {

        $auth = Auth::user();

        $data = AppConfig::first();

        return view('employee.companyCardInvoice', compact('data', 'auth'));
    }

    public function edit($id)
    {
        $data = User::findOrFail($id);
        $dataValidation = User::findOrFail($id);
        $religion = Religion::where('is_active', 'ENABLE')->get();
        $state = State::where('is_active', 'ENABLE')->where('id_country', '1')->get();
        $city = City::where('is_active', 'ENABLE')->get();
        $parliament = Parliament::where('is_active', 'ENABLE')->get();
        $dun = Dun::where('is_active', 'ENABLE')->get();
        $nation = Nation::where('is_active', 'ENABLE')->get();
        $status_native = StatusNative::where('is_active', 'ENABLE')->get();
        $gender = Gender::where('is_active', 'ENABLE')->get();
        $marital_status = MaritalStatus::where('is_active', 'ENABLE')->get();
        
        $cawangan = User::where('id_level', 2)
        ->select('id', 'fullname')
        ->latest()
        ->get();

        return view('employee.editPersonalDetail', compact('data', 'cawangan','dataValidation', 'religion', 'state', 'city', 'parliament', 'dun', 'nation', 'status_native', 'gender', 'marital_status'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $data = User::findOrFail($id);
        $data->fullname = $request->fullname;
        $data->phone_number = $request->phone_number;
        $data->email = $request->email;
        // return $data;

        $man = DetailManpower::where('id_user',$data->id)->first();
        $man->id_user = $data->id;
        $man->ic_number = $request->ic_number;
        $man->id_agama = $request->religion;
        $man->gender = $request->gender;
        $man->marital_status = $request->marital_status;
        $man->native_status = $request->native_status;
        $man->id_nation = $request->nation;
        $man->address = $request->address;
        if($request->id_state) $man->id_state = $request->id_state;
        if($request->id_city) $man->id_city = $request->id_city;
        if($request->parliament) $man->id_parliament = $request->parliament;
        if($request->dun) $man->id_dun = $request->dun;
        $man->postcode = $request->postcode;

        $man->business_phone = $request->phone_number;
        $man->business_email = $request->email;

        $man->business_instagram = $request->business_instagram;
        $man->business_facebook = $request->business_facebook;
        $man->business_tiktok = $request->business_tiktok;
        $man->business_youtube = $request->business_youtube;

        $man->id_cawangan = $request->id_cawangan;
        $man->nama_pencadang = $request->nama_pencadang;
        $man->nama_peyokong = $request->nama_peyokong;

        $man->is_mualaf = $request->mualaf;
        if($request->mualaf == '1' || $request->mualaf == 1)
        {
            $man->tarikh_pengislaman = $request->tarikh_pengislaman;
        }

        if($request->hasFile('img')){
            $file = $request->file('img');
            $n = $file->getClientOriginalName();
            $name = "$n";
            $file->move(public_path().'/Profil',$name);
            $photo1 = $name;
            $data->photo = $photo1;
        }

        $data->save();
        $man->save();

        $user = Auth::user()->id;
        return Redirect::to("personalDetail/$user")->with('success','Updated successfully');
    }
}
