<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailCompany;
use App\Models\TempDetailCompany;
use App\Models\EquityBreakdown;
use App\Models\User;
use App\Models\CompanyShareHolders;
use App\Models\LogCertificate;
use App\Models\State;
use App\Models\City;
use App\Models\Certifikat;
use App\Models\DetailManpower;
use App\Models\PublishedCertificate;
use DataTables;
use Redirect;
use DB;
use Auth;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Crypt;


class CompanyController extends Controller
{

    public function index_equity(Request $request)
    {
        // if ($request->ajax()) {

        $user = Auth::user()->id;

        $data_bumiputera = CompanyShareHolders::where('id_user', $user)->where('id_status', '1')->sum('total');
        $data_non_bumiputera = CompanyShareHolders::where('id_user', $user)->where('id_status', '2')->sum('total');
        $data_foreign = CompanyShareHolders::where('id_user', $user)->where('id_status', '3')->sum('total');

        $data_equity_by_status = [
            'bumiputera' => $data_bumiputera,
            'non-bumiputera' => $data_non_bumiputera,
            'foreign' => $data_foreign
        ];

        return view('company.viewCompanyEquityBreakdown', compact('data_equity_by_status'));

        // }
    }

    public function index(Request $request)
    {
        // if ($request->ajax()) {
        //     $data = DB::table('users')->leftJoin('tb_detail_company','tb_detail_company.id_user','users.id')
        //             ->leftJoin('tb_city','tb_city.id_city','tb_detail_company.id_city')
        //             ->leftJoin('tb_state','tb_state.id_state','tb_detail_company.id_state')
        //             ->select('users.*','tb_detail_company.*','tb_city.*','tb_state.*')->orderBy('users.id','desc')->get();
        //     return Datatables::of($data)
        //         ->addIndexColumn()
        //         ->addColumn('action', 'company.action')
        //         ->rawColumns(['action'])
        //         ->make(true);
        // }
        // return view('company.index');
    }

    public function show(Request $request, $id)
    {

        $auth = Auth::user();

        if ($auth->sub_company != null) {
            $id = $auth->sub_company;
        }

        $data = User::findOrFail($id);

        $data_detail = DetailCompany::with('company_type')->where('id_user', $id)->first();

        // return response($data_detail);

        $temp_data = "";

        if ($data_detail->certificate_expired_date > date('Y-m-d')) {
            $temp_data = TempDetailCompany::with('company_type')->where('id_user', $id)
                ->orderBy('id_temp_detail_company', 'desc')->first();
        }

        // return response($temp_data->company_registration_old_number);

        return view('company.viewCompanyDetail', compact('data', 'data_detail', 'temp_data'));
    }

    public function edit($id)
    {
        $data = User::findOrFail($id);
        $state = State::where('is_active', 'ENABLE')->where('id_country', '1')->get();
        $city = City::where('is_active', 'ENABLE')->get();
        return view('company.editCompanyDetail', compact('data', 'state', 'city'));
    }

    public function updateBillplzPersatuan(Request $request)
    {

        $company = DetailCompany::where('id_detail_company', $request->id)->first();

        if (!$company) {
            return $this->commitResponse("Data persatuan not found!");
        }

        $company->secret_key = $request->secret_key;
        $company->collection_id = $request->collection_id;
        // $company->signature_payment = $request->signature_payment;

        $company->save();

        return $this->commitResponse("Update Billplz Successfuly!", true);
    }

    public function update(Request $request, $id)
    {
        $data = User::findOrFail($id);
        if ($data) {
            $man = DetailCompany::where('id_user', $data->id)->first();

            // ======== Handle Custom Link ========
            if ($request->custom_link) {
                // Replace spasi dengan "/"
                $processedLink = preg_replace('/\s+/', '/', trim($request->custom_link));

                // Cek duplicate custom_link di table detail_company (kecuali current user)
                $exists = DetailCompany::where('custom_link', $processedLink)
                    ->where('id_user', '!=', $data->id)
                    ->exists();

                if ($exists) {
                    return back()->withErrors(['custom_link' => 'Custom link sudah digunakan, silakan pilih link lain!']);
                }

                $man->custom_link = $processedLink;
            }

            // ======== Update data lain ========
            $man->full_company_name = $request->full_company_name;
            $man->company_registration = $request->company_registration;
            $man->address = $request->address;
            $man->postcode = $request->postcode;
            $man->phone_office = $request->phone_office;
            $man->fax_number = $request->fax_number;
            $man->company_website = $request->company_website;
            $man->joining_fee = $request->joining_fee;
            $man->slogan = $request->slogan;
            $man->mengenai = $request->mengenai;

            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $n = $file->getClientOriginalName();
                $name = "$n";
                $file->move(public_path() . '/CompanyLogo', $name);
                $man->logo_picture = $name;
            }

            if ($request->hasFile('banner')) {
                try {
                    $bannerDir = public_path('/CompanyBanner');
                    if (!file_exists($bannerDir)) {
                        mkdir($bannerDir, 0755, true);
                    }
                    $file = $request->file('banner');
                    $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                    $file->move($bannerDir, $filename);
                    $man->banner = $filename;
                } catch (\Exception $e) {
                    return back()->withErrors(['banner' => 'Failed to upload banner: ' . $e->getMessage()]);
                }
            }

            if ($request->id_state) $man->id_state = $request->id_state;
            if ($request->id_city) $man->id_city = $request->id_city;

            $man->save();
        }

        return redirect("companyDetail/$id")->with('success', 'Updated successfully');
    }

    public function create(Request $request) {}
    public function index_company()
    {
        return view('company.viewCompanyDetail');
    }
    public function edit_company()
    {
        return view('company.editCompanyDetail');
    }

    public function request_certificate(Request $request)
    {

        $user = Auth::user();
        $log = new LogCertificate();

        $log->id_user = $user->id;
        $log->id_created_by = $user->id;
        $log->id_level = $user->id_level;
        $log->status = "REQUEST";
        $log->note = "Your registration is under verification process. An email will be sent to you once approved or rejected.";
        $log->save();

        $company = DetailCompany::with('user')->where('id_user', $user->id)->first();

        $company->status_certificate_approval = "WAITING";
        $company->save();

        $from = "sabahloka.hq@gmail.com";
        $company_name = $company->full_company_name;
        $user_name = $user->first_name . ' ' . $user->last_name;
        $to_email = "sabahloka.hq@gmail.com";
        $msg = "Hai! Company " . $company_name . " request certificate.";
        $subject = "Company Request Certificate";

        $data = array(
            'data' => $user,
            'msg' => $msg,
            'name' => $user_name,
        );
        $mail = \Mail::send('email.company_approval', $data, function ($message) use ($user_name, $to_email, $from, $subject) {
            $message->to($to_email, $to_email)->subject($subject);
            $message->from($from, "OGSE");
        });

        // return view('company.viewLogCertificate')->with('success_request','Request certificate successfully');
        return redirect("/logCertificate")->with('success_request', 'You have requested for Registration Certificate. It may takes sometime while our team will verify your company information before we produce the certificate. An email will be sent once approved.');
    }

    public function index_certificate(Request $request)
    {

        $user = Auth::user();

        if ($user->sub_company != null) {
            $user = User::where('id', $user->sub_company)->first();
        }

        $dataValidation = User::findOrFail($user->id);

        if ($request->ajax()) {

            $status = $request->status;

            $data = LogCertificate::with('user', 'level', 'user.company', 'user.company.city', 'user.company.state')->whereHas('user')->orderBy('id_log_certificate', 'desc');

            // return response($data->get());

            if ($request->id_log_certificate) {
                $data = $data->where('id_log_certificate', $request->id_log_certificate);

                return response()->json($data->first());
            }

            if ($user->id_level != 1 && $user->id_level != 4) {
                $data = $data->where('id_user', $user->id);
            }

            if ($status != "") {
                $data = $data->where('status', $status);

                if ($status == "Approved" || $status == "Rejected") {
                    $data = $data->orderBy('id_log_certificate', 'DESC');
                }
            }

            if ($user->id_level == 4) {

                $pegawai_daerah = User::select('id')->where('id_city', $user->id_city)->where('id_level', 4)->get();

                foreach ($pegawai_daerah as $i => $d) {
                    if ($i == 0) {
                        $data = $data->whereHas('user.company', function ($query) use ($user) {
                            $query->where('id_pegawai_daerah', 'LIKE', '%' . $d->id . '%');
                        });
                    } else {
                        $data = $data->whereHas('user.company', function ($query) use ($user) {
                            $query->orWhere('id_pegawai_daerah', 'LIKE', '%' . $d->id . '%');
                        });
                    }
                }

                // $data = $data->whereHas('user.company', function($query) use($user) {
                //     $query->where('id_pegawai_daerah', 'LIKE', '%'. $user->id .'%');
                // });
            }

            $data = $data->get();

            foreach ($data as $d) {

                $d->company_name = DetailCompany::where('id_user', $d->id_user)->first()->full_company_name;

                $d->user_level = isset($d->level->level) ? $d->level->level : '';
                $d->status = isset($d->status) ? $d->status : '';
                $d->note = isset($d->note) ? $d->note : '';
                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
            }

            return Datatables::of($data)->addIndexColumn()->make(true);
        }

        return view('statusLog.index', compact('dataValidation'));
    }

    public function cetak_pdf(Request $request, $id)
    {

        if (strlen($id) > 20) {
            $id = Crypt::decryptString($id);
        }

        $data = User::findOrFail($id);

        if ($data->id_level == 2) {
            $detail = DetailCompany::where('id_user', $data->id)->first();

            $certificate = Certifikat::where('id_state', $detail->id_state)->first();

            if (!$certificate || $certificate->logo_1 == "default.png" || $certificate->logo_2 == "default.png" || $certificate->sign_picture == "default.png" || $certificate->sign_name == "-" || $certificate->sign_position == "-") {
                return redirect('/errorViewCertificate');
            }

            if ($certificate->logo_1 == null || $certificate->logo_1 == "") {
                $certificate->logo_1 = "default.png";
            }

            if ($certificate->logo_2 == null || $certificate->logo_2 == "") {
                $certificate->logo_2 = "default.png";
            }

            if ($certificate->sign_picture == null || $certificate->sign_picture == "") {
                $certificate->sign_picture = "default.png";
            }

            $detail->number_certificate = $this->generateCertificateNumber($data->id, "PERSATUAN");

            $pdf = PDF::loadview('company.certifikat', ['data' => $data, 'detail' => $detail, 'certificate' => $certificate])->setPaper('a4', 'landscape');
        } else {

            $detail = DetailManpower::where('id_user', $data->id)->first();

            $certificate = Certifikat::where('id_state', $detail->id_state)->first();

            if (!$certificate || $certificate->logo_1 == "default.png" || $certificate->logo_2 == "default.png" || $certificate->sign_picture == "default.png" || $certificate->sign_name == "-" || $certificate->sign_position == "-") {
                return redirect('/errorViewCertificate');
            }

            if ($certificate->logo_1 == null || $certificate->logo_1 == "") {
                $certificate->logo_1 = "default.png";
            }

            if ($certificate->logo_2 == null || $certificate->logo_2 == "") {
                $certificate->logo_2 = "default.png";
            }

            if ($certificate->sign_picture == null || $certificate->sign_picture == "") {
                $certificate->sign_picture = "default.png";
            }

            $detail->number_certificate = $this->generateCertificateNumber($data->id, "AHLI");

            $pdf = PDF::loadview('employee.certifikat', ['data' => $data, 'detail' => $detail, 'certificate' => $certificate])->setPaper('a4', 'landscape');
        }

        return $pdf->stream();
    }

    public function profilDigitalCompany()
    {

        $user = Auth::user();

        if ($user->sub_company != null) {
            $user = User::where('id', $user->sub_company)->first();
        }

        $dataValidation = User::findOrFail($user->id);

        $data = DetailCompany::with('user')->where('id_user', $user->id)->first();

        $data->share_link = env("APP_URL") . "/persatuan/$data->key_reference";

        if (!$data) {
            return "Data not found!";
        } else {
            return view('company.digitalProfile', compact('data', 'dataValidation'));
        }
    }
}
