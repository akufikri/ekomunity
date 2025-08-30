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
use App\Models\User;
use App\Models\Country;
use App\Models\City;
use App\Models\State;
use App\Models\DetailCompany;
use App\Models\CompanyShareHolders;
use App\Models\LogCertificate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class RegisCompanyController extends Controller
{

    //COMPANY ACTIVE
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($request->ajax()) {

            $status = $request->status;

            // $data = DetailCompany::with('user')->orderBy('created_at', 'DESC')->where('step_registration', DetailCompany::$stepRegistration);
            $data = DetailCompany::with('user')->orderBy('created_at', 'DESC');
            if ($status != "Overall" && $status != "") {
                $data = $data->whereHas('user', function($user) use($status) {
                    $user->where('status', $status);
                });
            }

            if ($user->id_level == 4) {
                $pegawai_daerah = User::select('id')->where('id_city', $user->id_city)->where('id_level', 4)->get();
                foreach ($pegawai_daerah as $i => $d) {
                    if($i == 0){
                        $data = $data->where('id_pegawai_daerah', 'LIKE', "%" .$d->id. "%");
                    } else {
                        $data = $data->orWhere('id_pegawai_daerah', 'LIKE', "%" .$d->id. "%");
                    }
                }
            }

            if ($user->id_level == 6) {
                $data = $data->where('id_state', $user->id_state);
            }

            $data = $data->get();

            foreach($data as $d){
                $city = City::where('id_city', $d->id_city)->first();
                $state = State::where('id_state', $d->id_state)->first();

                $d->city = isset($city)?$city->city:'';
                $d->state = isset($state)?$state->state:'';

                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
            }
            return DataTables::of($data)->addIndexColumn()->make(true);
        }

        return view('company.index');
    }

    public function index_active_sabahan(Request $request)
    {
        if ($request->ajax()) {

            $data = DetailCompany::whereHas('user', function($user) {
                $user->where('status','ACTIVE');
            })->with('user')
            ->where('id_country','1')
            ->where('id_state','1')
            ->orderBy('id_detail_company','desc')->get();

            foreach($data as $d){
                $city = City::where('id_city', $d->id_city)->first();
                $state = State::where('id_state', $d->id_state)->first();

                $d->city = isset($city)?$city->city:'';
                $d->state = isset($state)?$state->state:'';

                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        return view('company.active.sabahan');
    }

    public function index_active_other(Request $request)
    {
        if ($request->ajax()) {

            $data = DetailCompany::whereHas('user', function($user) {
                $user->where('status','ACTIVE');
            })->with('user')
            ->where('id_country','1')
            ->where('id_state','!=','1')
            ->orderBy('id_detail_company','desc')->get();

            foreach($data as $d){
                $city = City::where('id_city', $d->id_city)->first();
                $state = State::where('id_state', $d->id_state)->first();

                $d->city = isset($city)?$city->city:'';
                $d->state = isset($state)?$state->state:'';

                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        return view('company.active.other');
    }

    public function index_active_foreign(Request $request)
    {
        if ($request->ajax()) {

            $data = DetailCompany::whereHas('user', function($user) {
                $user->where('status','ACTIVE');
            })->with('user')
            ->where('id_country','!=', 1)
            ->orderBy('id_detail_company','desc')->get();

            foreach($data as $d){
                $city = City::where('id_city', $d->id_city)->first();
                $state = State::where('id_state', $d->id_state)->first();

                $d->city = isset($city)?$city->city:'';
                $d->state = isset($state)?$state->state:'';

                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        return view('company.active.foreign');
    }

    //COMPANY SUSPEND
    public function index_suspend(Request $request)
    {
        if ($request->ajax()) {

            $data = DetailCompany::whereHas('user', function($user) {
                $user->where('status','SUSPEND');
            })->with('user')->orderBy('id_detail_company','desc')->get();

            foreach($data as $d){
                $city = City::where('id_city', $d->id_city)->first();
                $state = State::where('id_state', $d->id_state)->first();

                $d->city = isset($city)?$city->city:'';
                $d->state = isset($state)?$state->state:'';

                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        return view('company.suspend.index');
    }

    public function index_suspend_sabahan(Request $request)
    {
        if ($request->ajax()) {

            $data = DetailCompany::whereHas('user', function($user) {
                $user->where('status','SUSPEND');
            })->with('user')
            ->where('id_country','1')
            ->where('id_state','1')
            ->orderBy('id_detail_company','desc')->get();

            foreach($data as $d){
                $city = City::where('id_city', $d->id_city)->first();
                $state = State::where('id_state', $d->id_state)->first();

                $d->city = isset($city)?$city->city:'';
                $d->state = isset($state)?$state->state:'';

                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        return view('company.suspend.sabahan');
    }

    public function index_suspend_other(Request $request)
    {
        if ($request->ajax()) {

            $data = DetailCompany::whereHas('user', function($user) {
                $user->where('status','SUSPEND');
            })->with('user')
            ->where('id_country','1')
            ->where('id_state','!=','1')
            ->orderBy('id_detail_company','desc')->get();

            foreach($data as $d){
                $city = City::where('id_city', $d->id_city)->first();
                $state = State::where('id_state', $d->id_state)->first();

                $d->city = isset($city)?$city->city:'';
                $d->state = isset($state)?$state->state:'';

                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        return view('company.suspend.other');
    }

    public function index_suspend_foreign(Request $request)
    {
        if ($request->ajax()) {

            $data = DetailCompany::whereHas('user', function($user) {
                $user->where('status','SUSPEND');
            })->with('user')
            ->where('id_country','!=', 1)
            ->orderBy('id_detail_company','desc')->get();

            foreach($data as $d){
                $city = City::where('id_city', $d->id_city)->first();
                $state = State::where('id_state', $d->id_state)->first();

                $d->city = isset($city)?$city->city:'';
                $d->state = isset($state)?$state->state:'';

                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        return view('company.suspend.foreign');
    }

    //COMPANY BANNED
    public function index_banned(Request $request)
    {
        if ($request->ajax()) {

            $data = DetailCompany::whereHas('user', function($user) {
                $user->where('status','BANNED');
            })->with('user')->orderBy('id_detail_company','desc')->get();

            foreach($data as $d){
                $city = City::where('id_city', $d->id_city)->first();
                $state = State::where('id_state', $d->id_state)->first();

                $d->city = isset($city)?$city->city:'';
                $d->state = isset($state)?$state->state:'';

                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        return view('company.banned.index');
    }

    public function index_banned_sabahan(Request $request)
    {
        if ($request->ajax()) {

            $data = DetailCompany::whereHas('user', function($user) {
                $user->where('status','BANNED');
            })->with('user')
            ->where('id_country','1')
            ->where('id_state','1')
            ->orderBy('id_detail_company','desc')->get();

            foreach($data as $d){
                $city = City::where('id_city', $d->id_city)->first();
                $state = State::where('id_state', $d->id_state)->first();

                $d->city = isset($city)?$city->city:'';
                $d->state = isset($state)?$state->state:'';

                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        return view('company.banned.sabahan');
    }

    public function index_banned_other(Request $request)
    {
        if ($request->ajax()) {

            $data = DetailCompany::whereHas('user', function($user) {
                $user->where('status','BANNED');
            })->with('user')
            ->where('id_country','1')
            ->where('id_state','!=','1')
            ->orderBy('id_detail_company','desc')->get();

            foreach($data as $d){
                $city = City::where('id_city', $d->id_city)->first();
                $state = State::where('id_state', $d->id_state)->first();

                $d->city = isset($city)?$city->city:'';
                $d->state = isset($state)?$state->state:'';

                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        return view('company.banned.other');
    }

    public function index_banned_foreign(Request $request)
    {
        if ($request->ajax()) {

            $data = DetailCompany::whereHas('user', function($user) {
                $user->where('status','BANNED');
            })->with('user')
            ->where('id_country','!=', 1)
            ->orderBy('id_detail_company','desc')->get();

            foreach($data as $d){
                $city = City::where('id_city', $d->id_city)->first();
                $state = State::where('id_state', $d->id_state)->first();

                $d->city = isset($city)?$city->city:'';
                $d->state = isset($state)?$state->state:'';

                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        return view('company.banned.foreign');
    }

    public function create()
    {

        return view('company.register.registercompany');
    }

    public function getSelectPackage()
    {
        return view('company.register.priceRegisterCompany');
    }

    public function waitingApproval() {
        return view('company.register.waitingApproval');
    }

    public function registerStepTwo()
    {
        $state = State::where('is_active', 'ENABLE')->get();
        $city = City::where('is_active', 'ENABLE')->get();

        $pegawai_daerah = User::where('status', 'ACTIVE')->where('id_level', 4)->get();

        // return response($pegawai_daerah);

        return view('company.register.registerStepTwo', compact('state', 'city', 'pegawai_daerah'));
    }

    public function registerStepTwoUpdate(Request $request)
    {

        $user = Auth::user();
        $email = $request->email_company;
        $company_registration = $request->company_registration;
        $em = DetailCompany::where('email_company', $email)->first();
        $company_registration = DetailCompany::where('company_registration', $company_registration)->first();

        if($em){
            Session::flash('success', 'Emel anda sudah digunakan, sila guna emel lain');
            Session::flash('alert-class', 'alert-warning');

            return redirect()->back()->withInput($request->all());
        }

        if($company_registration){
            Session::flash('success', 'No. Pendaftaran Persatuan already in use');
            Session::flash('alert-class', 'alert-warning');

            return redirect()->back()->withInput($request->all());
        }

        if($request->hasFile('img_logo_persatuan')){
            $file = $request->file('img_logo_persatuan');
            $n = $file->getClientOriginalName();
            $current_date = date('Ymdhis');
            $name = "$current_date$n";
            $file->move(public_path().'/CompanyLogo',$name);
            $logo_picture = $name;
        }else{
            $logo_picture = 'default.png';
        }

        if($request->hasFile('img_sijil_persatuan')){
            $file = $request->file('img_sijil_persatuan');
            $n = $file->getClientOriginalName();
            $current_date = date('Ymdhis');
            $name = "$current_date$n";
            $file->move(public_path().'/CompanyLicenses',$name);
            $license_picture = $name;
        }else{
            $license_picture = 'default.png';
        }

        $detail = DetailCompany::where('id_user', $user->id)->first();
        $detail->id_pegawai_daerah = $request->pegawai_daerah;
        $detail->company_registration = $request->company_registration ?? null;
        $detail->address = $request->address;
        $detail->id_country = '1';
        $detail->id_state = $request->state;
        $detail->id_city = $request->city;
        $detail->postcode = $request->postcode;
        $detail->phone_office = $this->adjustPhoneNumberMy("$request->dial_code$request->phone_office");
        $detail->email_company = $request->email_company;
        $detail->company_website = $request->company_website;

        $medsos = $request->medsos;
        array_pop($medsos);
        $detail->medsos = $medsos;

        $pautan = $request->pautan;
        array_pop($pautan);
        $detail->medsos_link = $pautan;

        $detail->logo_picture = $logo_picture;
        $detail->license_picture = $license_picture;
        $detail->step_registration = '2';

        $log_certificate = new LogCertificate();
        $log_certificate->id_user = $detail->id_user;
        $log_certificate->id_created_by = $user->id;
        $log_certificate->id_level = $user->id_level;
        $log_certificate->status = "WAITING";
        $log_certificate->note = "Your registration is under verification process. An email will be sent to you once approved or rejected.";

        $detail->save();
        $log_certificate->save();

        return redirect()->to('/home');

    }

    public function store(Request $request)
    {
        $user = new User;

        $email = $request->email;
        $phone_number = $this->adjustPhoneNumberMy("$request->dial_code$request->phone_number");
        $em = User::where('email',$email)->first();
        $phone = User::where('phone_number',$phone_number)->first();

        if($em){
            Session::flash('success', 'Emel anda sudah digunakan, sila guna emel lain');
            Session::flash('alert-class', 'alert-warning');

            return redirect()->back()->withInput($request->all());
        }

        if($phone){
            Session::flash('success', 'No Telefon anda sudah digunakan, sila guna No Telefon lain');
            Session::flash('alert-class', 'alert-warning');

            return redirect()->back()->withInput($request->all());
        }

        $user->fullname = $request->nama_penuh;
        $user->email = $request->email;
        $user->phone_number = $phone_number;
        $user->id_level = 2;
        $user->password = Hash::make($request->password);
        $user->save();

        if($user){
            $company = new DetailCompany;
            $company->id_user = $user->id;
            $company->full_company_name = $request->nama_pertubuhan;

            $company->key_reference = Str::random(6);

            $cek = DetailCompany::where('key_reference', $company->key_reference)->first();
            if($cek) {
                $company->key_reference = Str::random(6);
                $cek = DetailCompany::where('key_reference', $company->key_reference)->first();
                if($cek) {
                    $company->key_reference = Str::random(6);
                }
            }

            $company->price_subscribe = $request->price_subscribe;
            $company->year_expired_subscribe = Carbon::now()->addYear();
            $company->valid_subscribe = 1;

            $company->save();
        }

        $this->sendEmailVerification($user->id);

        return Redirect::to('/success_register')->withInput($request->all());
    }

    //Detail Company
    public function index_detail_company($id, $id_max) {

        $data = User::findOrFail($id);

        setlocale(LC_MONETARY, 'ms_MY');

        $data->auth_paid_up_capital = money_format('%i', $data->company->auth_paid_up_capital);
        $data->paid_up_capital = money_format('%i', $data->company->paid_up_capital);

        $user = $id;

         $data_bumiputera = CompanyShareHolders::where('id_user', $user)->where('id_status','1')->sum('total');
         $data_non_bumiputera = CompanyShareHolders::where('id_user', $user)->where('id_status','2')->sum('total');
         $data_foreign = CompanyShareHolders::where('id_user', $user)->where('id_status','3')->sum('total');

         $company_detail = DetailCompany::where('id_user', $user)->first();

         if($company_detail->paid_up_capital !== null){
             $data->percentage_bumiputera = number_format((($data_bumiputera / $company_detail->paid_up_capital) * 100), 1, ',', '.').'%';
         }else{
             $data->percentage_bumiputera = '0%';
         }

         if($company_detail->paid_up_capital !== null){
             $data->percentage_non_bumiputera = number_format((($data_non_bumiputera / $company_detail->paid_up_capital) * 100), 1, ',', '.').'%';
         }else{
             $data->percentage_non_bumiputera = '0%';
         }

         if($company_detail->paid_up_capital !== null){
             $data->percentage_foreign = number_format((($data_foreign / $company_detail->paid_up_capital) * 100), 1, ',', '.').'%';
         }else{
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
        return view('company.active.detailCompany',compact('data'));
    }

    public function certifikat_company($id, Request $r){
        $data = User::findOrFail($id);

        return view('company.certifikat', compact('data'));
    }

    public function certifikat_company_unavailable(Request $r){

        return view('company.certificate_not_available');
    }


    public function destroy($id){

        $user = User::where('id', $id)->first();
        $data = DetailCompany::where('id_user', $user->id)->first();

        $user->delete();
        $data->delete();

        // return $data;


        return response()->json([
            'newToken' => csrf_token(),
            'isSuccess' => true,
            'success'=>'Senarai Persatuan deleted successfully!',
            'data'=>$data
            ]);

        // return response()->json(['success'=>'Senarai Ahli deleted successfully']);
    }

}
