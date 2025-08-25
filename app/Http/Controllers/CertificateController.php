<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyShareHolders;
use App\Models\DetailCompany;
use App\Models\DetailManpower;
use App\Models\LogCertificate;
use App\Models\Certifikat;
use App\Models\PublishedCertificate;
use App\Models\User;
use DataTables;
use Redirect;
use DB;
use Auth;
use Carbon\Carbon;

use Illuminate\Support\Facades\Crypt;


class CertificateController extends Controller {
    
    public function set_view_certificate($set){
        
        $user = Auth::user();

        if($user->sub_company != null){
            $user = User::where('id', $user->sub_company)->first();
        }

        // return $user;

        if($user->id_level == 2) {
            $data = DetailCompany::where('id_user', $user->id)->first();

            
            
        } else {
            $data = DetailManpower::where('id_user', $user->id)->first();
                       
        }
        
        $data->view_certificate = $set;
        
        $data->save();

        $encrypt = Crypt::encryptString($user->id);
        
        return redirect("/cetak_pdf/$encrypt");
        
        
    }
    
    public function index($id, $id_max) {
        
        $data = User::findOrFail($id);
    
        setlocale(LC_MONETARY, 'ms_MY');
                
        $data->auth_paid_up_capital = 'RM'.number_format($data->company->auth_paid_up_capital);
        $data->paid_up_capital = 'RM'.number_format($data->company->paid_up_capital);
        
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
            
            
    
        // $data->bumiputera = number_format('%i', $data_bumiputera);
        // $data->non_bumiputera = number_format('%i', $data_non_bumiputera);
        // $data->foreign = number_format('%i', $data_foreign);
        
        $data->bumiputera = 'RM'.number_format($data_bumiputera);
        $data->non_bumiputera = 'RM'.number_format($data_non_bumiputera);
        $data->foreign = 'RM'.number_format($data_foreign);
        
        // return response($data->bumiputera);
        
        $status_certificate = LogCertificate::where('id_user', $id)
        ->where('id_log_certificate', $id_max)->first();
        
        $data->status_detail = $status_certificate->status;
        
        $data->id_user_company = $id;
        
        
        // return view('company.viewCompanyEquityBreakdown', compact('data'));
        
        return view('admin.logSertificate.detailCertificate',compact('data'));
    }
    
    public function index_admin($id) {
        
        $data = User::findOrFail($id);
    
        setlocale(LC_MONETARY, 'ms_MY');
                
        $data->auth_paid_up_capital = 'RM'.number_format($data->company->auth_paid_up_capital);
        $data->paid_up_capital = 'RM'.number_format($data->company->paid_up_capital);
        
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
    
        $data->bumiputera = 'RM'.number_format($data_bumiputera);
        $data->non_bumiputera = 'RM'.number_format($data_non_bumiputera);
        $data->foreign = 'RM'.number_format($data_foreign);
        
        // $status_certificate = LogCertificate::where('id_user', $id)
        // ->where('id_log_certificate', $id_max)->first();
        
        // $data->status_detail = $status_certificate->status;
        
        $data->id_user_company = $id;
        
        
        // return view('company.viewCompanyEquityBreakdown', compact('data'));
        
        return view('admin.logSertificate.detailCertificate',compact('data'));
    }
    
    public function index_request_certificate(Request $request){
        
         if ($request->ajax()) {
        
            $data = LogCertificate::select(DB::raw('*, max(id_log_certificate) as id_max, max(created_at) as date_max, count(id_log_certificate) as attempt'))
            ->whereHas('detailCompany', function($detailCompany){
                $detailCompany->where('status_certificate_approval','WAITING');
            })
            ->with('user','level','detailCompany')
            ->where('status','REQUEST')
            ->groupBy('id_user')
            ->orderBy('created_at','desc')
            ->get();
            
            foreach($data as $d){
            
                $d->company_name = isset($d->detailCompany->full_company_name)?$d->detailCompany->full_company_name: '';
                $d->first_name = isset($d->user->first_name)?$d->user->first_name: '';
                $d->last_name = isset($d->user->last_name)?$d->user->last_name: '';
                $d->contact_person = $d->first_name.' '.$d->last_name;
                $d->phone_number = isset($d->user->phone_number)?$d->user->phone_number: '';
                $d->email = isset($d->user->email)?$d->user->email: '';
                $d->user_level = isset($d->level->level)?$d->level->level: '';
                $d->status = isset($d->status)?$d->status: '';
                $d->note = isset($d->note)?$d->note: '';
                $d->create_date = date('d-m-Y H:i:s', strtotime($d->date_max));
                
            }
            
            return Datatables::of($data)->addIndexColumn()->make(true);
            
            // $result = [
            //     'message' => 'Success request certificate',
            //     'data' => $data,
            // ];
            
            // return response()->json($result);

         }

        return view('admin.logSertificate.waitingCertificate');
        
    }
    
    public function index_approve_certificate(Request $request){
    
     if ($request->ajax()) {
    
        $data = LogCertificate::select(DB::raw('*, max(id_log_certificate) as id_max, max(created_at) as date_max, count(id_log_certificate) as attempt'))
        ->whereHas('detailCompany', function($detailCompany){
            $detailCompany->where('status_certificate_approval','APPROVED');
        })
        ->with('user','level','detailCompany')
        ->where('status','APPROVED')
        ->groupBy('id_user')
        ->orderBy('created_at','desc')
        ->get();
        
        foreach($data as $d){
        
            $d->company_name = isset($d->detailCompany->full_company_name)?$d->detailCompany->full_company_name: '';
            $d->first_name = isset($d->user->first_name)?$d->user->first_name: '';
            $d->last_name = isset($d->user->last_name)?$d->user->last_name: '';
            $d->contact_person = $d->first_name.' '.$d->last_name;
            $d->phone_number = isset($d->user->phone_number)?$d->user->phone_number: '';
            $d->email = isset($d->user->email)?$d->user->email: '';
            $d->user_level = isset($d->level->level)?$d->level->level: '';
            $d->status = isset($d->status)?$d->status: '';
            $d->note = isset($d->note)?$d->note: '';
            $d->create_date = date('d-m-Y H:i:s', strtotime($d->date_max));
            
        }
        
        return Datatables::of($data)->addIndexColumn()->make(true);

     }

    return view('admin.logSertificate.approvedCertificate');
    
    }
    
    public function index_rejected_certificate(Request $request){
    
     if ($request->ajax()) {
    
        $user = Auth::user();
    
        $data = LogCertificate::select(DB::raw('*, max(id_log_certificate) as id_max, max(created_at) as date_max, count(id_log_certificate) as attempt'))
        ->whereHas('detailCompany', function($detailCompany){
            $detailCompany->where('status_certificate_approval','REJECTED');
        })
        ->with('user','level','detailCompany')
        ->where('status','REJECTED')
        ->groupBy('id_user')
        ->orderBy('created_at','desc')
        ->get();
        
        foreach($data as $d){
        
            $d->company_name = isset($d->detailCompany->full_company_name)?$d->detailCompany->full_company_name: '';
            $d->first_name = isset($d->user->first_name)?$d->user->first_name: '';
            $d->last_name = isset($d->user->last_name)?$d->user->last_name: '';
            $d->contact_person = $d->first_name.' '.$d->last_name;
            $d->phone_number = isset($d->user->phone_number)?$d->user->phone_number: '';
            $d->email = isset($d->user->email)?$d->user->email: '';
            $d->user_level = isset($d->level->level)?$d->level->level: '';
            $d->status = isset($d->status)?$d->status: '';
            $d->note = isset($d->note)?$d->note: '';
            $d->create_date = date('d-m-Y H:i:s', strtotime($d->date_max));
            
        }
        
        return Datatables::of($data)->addIndexColumn()->make(true);

     }

    return view('admin.logSertificate.rejectedCertificate');
        
    }
    
    public function approve_certificate(Request $request){
    
        $user = Auth::user();
        // $log = new LogCertificate();
        $log_current = LogCertificate::where('id_log_certificate', $request->id_log_certificate)->first();
        $certificate = Certifikat::first();
        $publish = new PublishedCertificate();
        $running_number = PublishedCertificate::orderBy('id_published_certificate','desc')->first();

        $dateNow = date("dmy");
        
        if($running_number){
            $add_number = ((int)$running_number->number_certificate) + 1;
            $next_number = str_pad($add_number, 6, '0', STR_PAD_LEFT);
        }else{
            $next_number = str_pad(1, 6, '0', STR_PAD_LEFT);
        }
        
        // return response($next_number);
        
        $company = DetailCompany::with('user')->where('id_user', $log_current->id_user)->first();
        
        $log_current->status = $request->approval;
        $log_current->approval_note = $request->approval_note;
        $log_current->approval_by = $user->id;
        $log_current->approval_at = $dateNow;
        $log_current->save();

        // return response($company);

        $company->status_approval = $request->approval;
        $company->status_certificate_approval = $request->approval;

        if($request->approval == "APPROVED") {
            $newDateTime = Carbon::now()->addYear($certificate->valid_time);
        
            
            $company->valid_time_certificate = $certificate->valid_time;
            $company->certificate_file = 1;
            $company->certificate_expired_date = $newDateTime;
            $company->number_certificate = 'P'.$dateNow.'-'.$next_number;
            
            
            $publish->id_user = $request->id_user_company;
            $publish->number_certificate = $next_number;
            $publish->expire_date = $newDateTime;
            $publish->save();
        }

        $company->save();

        $result = [
            'data' => $log_current,
            'newToken' => csrf_token()
        ];

        return response()->json($result);
        
        
        
        // $from = "sabahloka.hq@gmail.com";
        // $user_name = $user->first_name.' '.$user->last_name;
        // $company_name = $company->full_company_name;
        // $user_email = isset($company->user->email)?$company->user->email:'mail@mail.com';
        // $msg = "Congratulation! Your company ".$company_name." certificate approved.";
        // $subject = "Company Certificate Approved";
                
        // $data = array('data' => $user,
        //           'msg' => $msg,
        //           'name' => $company_name,
        //           );
        // $mail = \Mail::send('email.company_approval', $data, function($message) use ($user_name, $user_email, $from, $subject) {
        //             $message->to($user_email, $user_email)->subject($subject);
        //             $message->from($from,"OGSE");
        //         });
        
        // return redirect("/approvedCertificate")->with('success_approve','Approve successfully');
        
    }
    
    public function reject_certificate(Request $request){
    
        $user = Auth::user();
        $log = new LogCertificate();
        
        $company = DetailCompany::where('id_user', $request->id_user_company)->first();
        
        $log->id_user = $request->id_user_company;
        $log->id_created_by = $user->id;
        $log->id_level = $user->id_level;
        $log->status = "REJECTED";
        $log->note = $request->note;
        $log->save();
        
        $company->status_certificate_approval = "REJECTED";
        $company->save();
        
        $from = "sabahloka.hq@gmail.com";
        $user_name = $user->first_name.' '.$user->last_name;
        $company_name = $company->full_company_name;
        $user_email = isset($company->user->email)?$company->user->email:'mail@mail.com';
        $msg = "Sorry! Your company ".$company_name." certificate rejected.";
        $subject = "Company Certificate Rejected";
                
        $data = array('data' => $user,
                  'msg' => $msg,
                  'name' => $user_name,
                  );
        $mail = \Mail::send('email.company_approval', $data, function($message) use ($user_name, $user_email, $from, $subject) {
                    $message->to($user_email, $user_email)->subject($subject);
                    $message->from($from,"OGSE");
                });
        
        return redirect("/rejectedCertificate")->with('success_reject','Reject successfully');
        
    }



    
}