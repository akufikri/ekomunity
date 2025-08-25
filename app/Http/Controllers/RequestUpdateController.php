<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailCompany;
use App\Models\CompanySegment;
use App\Models\EquityBreakdown;
use App\Models\User;
use App\Models\CompanyShareHolders;
use App\Models\LogCertificate;
use App\Models\RequestUpdate;
use App\Models\TempCompanySegment;
use App\Models\TempCompanyVendorLicenses;
use App\Models\TempCompanyShareHolders;
use App\Models\TempCompanySwecCode;
use App\Models\CompanyWorkers;
use App\Models\CompanyProject;
use App\Models\TempCompanyWorkers;
use App\Models\TempCompanyProject;
use App\Models\CompanyVendorLicenses;
use App\Models\CompanySwecCode;
use App\Models\TempDetailCompany;
use DataTables;
use Redirect;
use DB;
use Auth;
use PDF;

class RequestUpdateController extends Controller
{
    public function __constructor(){
        $this->middleware('company');
    }
    
    public function clear_request_update($menu){
        
        $user = Auth::user()->id;
        
        if($menu === 'DETAIL_COMPANY'){
            $detail_company = TempDetailCompany::where('id_user', $user)
            ->orderBy('id_temp_detail_company','desc')->delete();
            
            return redirect("/companyDetail/$user#view");
        
        }else if($menu == 'SEGMENT'){
            $data = TempCompanySegment::where('id_user', $user)
            ->where('id_request_update','==', '0')->get();
            
            foreach($data as $d){
                $d->delete();
            }
            
            return redirect("/companySegment#view");
            
        } else if($menu == 'SHAREHOLDERS'){
            $data = TempCompanyShareHolders::where('id_user', $user)
            ->where('id_request_update','==', '0')->get();
            
            foreach($data as $d){
                $d->delete();
            }
            
            return redirect("/companyListofShareholders#view");
            
        } else if($menu == 'WORKERS'){
            $data = TempCompanyWorkers::where('id_user', $user)
            ->where('id_request_update','==', '0')->get();
            
            foreach($data as $d){
                $d->delete();
            }
            
            return redirect("/companyWorkers#view");
            
        } else if($menu == 'KEY_CLIENT'){
            $data = \App\Models\TempCompanyProject::where('id_user', $user)
            ->where('id_request_update', '0')
            ->where('id_source','1')->get();
            
            foreach($data as $d){
                $d->delete();
            }
            
            return redirect("/companyKeyClientProject#view");
            
        } else if($menu == 'OUTSOURCE_PROJECT'){
            $data = \App\Models\TempCompanyProject::where('id_user', $user)
            ->where('id_request_update', '0')
            ->where('id_source','2')->get();
            
            foreach($data as $d){
                $d->delete();
            }
            
            return redirect("/companyOutSourceProject#view");
            
        } else if($menu == 'VENDOR_LICENSES'){
            $data = \App\Models\TempCompanyVendorLicenses::where('id_user', $user)
            ->where('id_request_update', '0')->get();
            
            foreach($data as $d){
                $d->delete();
            }
            
            return redirect("/companyVendorLicenses#view");
            
        } else if($menu == 'SWEC_CODE'){
            $data = \App\Models\TempCompanySwecCode::where('id_user', $user)
            ->where('id_request_update', '0')->get();
            
            foreach($data as $d){
                $d->delete();
            }
            
            return redirect("/companySwecCode#view");
            
        } else {
            //CLEAR DATA REQUEST ON TABLE TEMP DETAIL COMPANY
            $detail_company = TempDetailCompany::where('id_user', $user)
            ->orderBy('id_temp_detail_company','desc')->delete();
            
            //CLEAR DATA REQUEST ON TABLE TEMP SEGMENT/FIELD OF BUSINESS
            $segment = TempCompanySegment::where('id_user', $user)
            ->where('id_request_update','==', '0')->get();
            
            //CLEAR DATA REQUEST ON TABLE TEMP VENDOR LICENSES
            $vendor_licenses = TempCompanyVendorLicenses::where('id_user', $user)
            ->where('id_request_update','==', '0')->get();
            
            //CLEAR DATA REQUEST ON TABLE TEMP SHAREHOLDERS
            $shareholders = TempCompanyShareHolders::where('id_user', $user)
            ->where('id_request_update','==', '0')->get();
            
            //CLEAR DATA REQUEST ON TABLE TEMP WORKERS
            $workers = TempCompanyWorkers::where('id_user', $user)
            ->where('id_request_update','==', '0')->get();
            
            //CLEAR DATA REQUEST ON TABLE TEMP PROJECT
            $project_key_client = TempCompanyProject::where('id_user', $user)
            ->where('id_request_update','==', '0')
            ->where('id_source', '1')->get();
            
            $project_outsource = TempCompanyProject::where('id_user', $user)
            ->where('id_request_update','==', '0')
            ->where('id_source', '2')->get();
            
            //CLEAR DATA REQUEST ON TABLE TEMP SWEC CODE
            $swec_code= TempCompanySwecCode::where('id_user', $user)
            ->where('id_request_update','==', '0')->get();
            
                       
            foreach($segment as $d){
                $d->delete();
            }
            
            foreach($vendor_licenses as $d){
                $d->delete();
            }
            
            foreach($shareholders as $d){
                $d->delete();
            }
            
            foreach($workers as $d){
                $d->delete();
            }
            
            foreach($project_key_client as $d){
                $d->delete();
            }
            
            foreach($project_outsource as $d){
                $d->delete();
            }
            
            foreach($swec_code as $d){
                $d->delete();
            }
            
            return redirect("/homeCompany");
        }
        
    }
    
    public function approve_request_update(Request $request, $id, $id_request){
        
        //UPDATE DETAIL COMPANY
        // $tempDetailCompanyUpdate = TempDetailCompany::where('id_user', $id)
        // ->where('id_request_update', $id_request)
        // ->where('action', 'UPDATE')->first();
        
        // $detailCompany = DetailCompany::where('id_user', $id)->orderBy('id_detail_company','asc')->first();
        
        // if ($tempDetailCompanyUpdate->id_user) $detailCompany->id_user = $tempDetailCompanyUpdate->id_user;
        // if ($tempDetailCompanyUpdate->id_city) $detailCompany->id_city = $tempDetailCompanyUpdate->id_city;
        // if ($tempDetailCompanyUpdate->id_state) $detailCompany->id_state = $tempDetailCompanyUpdate->id_state;
        // if ($tempDetailCompanyUpdate->id_country) $detailCompany->id_country = $tempDetailCompanyUpdate->id_country;
        // if ($tempDetailCompanyUpdate->id_company_type) $detailCompany->id_company_type = $tempDetailCompanyUpdate->id_company_type;
        // if ($tempDetailCompanyUpdate->company_registration_old_number) $detailCompany->company_registration_old_number = $tempDetailCompanyUpdate->company_registration_old_number;
        // if ($tempDetailCompanyUpdate->company_registration_new_number) $detailCompany->company_registration_new_number = $tempDetailCompanyUpdate->company_registration_new_number;
        // if ($tempDetailCompanyUpdate->full_company_name) $detailCompany->full_company_name = $tempDetailCompanyUpdate->full_company_name;
        // if ($tempDetailCompanyUpdate->address) $detailCompany->address = $tempDetailCompanyUpdate->address;
        // if ($tempDetailCompanyUpdate->postcode) $detailCompany->postcode = $tempDetailCompanyUpdate->postcode;
        // if ($tempDetailCompanyUpdate->phone_office) $detailCompany->phone_office = $tempDetailCompanyUpdate->phone_office;
        // if ($tempDetailCompanyUpdate->fax_number) $detailCompany->fax_number = $tempDetailCompanyUpdate->fax_number;
        // if ($tempDetailCompanyUpdate->company_website) $detailCompany->company_website = $tempDetailCompanyUpdate->company_website;
        // if ($tempDetailCompanyUpdate->logo_picture) $detailCompany->logo_picture = $tempDetailCompanyUpdate->logo_picture;
        // if ($tempDetailCompanyUpdate->auth_paid_up_capital) $detailCompany->auth_paid_up_capital = $tempDetailCompanyUpdate->auth_paid_up_capital;
        // if ($tempDetailCompanyUpdate->company_organization_chart) $detailCompany->company_organization_chart = $tempDetailCompanyUpdate->company_organization_chart;
        // if ($tempDetailCompanyUpdate->company_ssm_certificate) $detailCompany->company_ssm_certificate = $tempDetailCompanyUpdate->company_ssm_certificate;
        // if ($tempDetailCompanyUpdate->company_ssm_section_14) $detailCompany->company_ssm_section_14 = $tempDetailCompanyUpdate->company_ssm_section_14;
        // if ($tempDetailCompanyUpdate->company_ssm_section_17) $detailCompany->company_ssm_section_17 = $tempDetailCompanyUpdate->company_ssm_section_17;
        // if ($tempDetailCompanyUpdate->company_ssm_company_information) $detailCompany->company_ssm_company_information = $tempDetailCompanyUpdate->company_ssm_company_information;
        // if ($tempDetailCompanyUpdate->company_ssm_trading_license) $detailCompany->company_ssm_trading_license = $tempDetailCompanyUpdate->company_ssm_trading_license;
        
        // $detailCompany->save();
        
        //CREATE SEGMENT
        $tempCompanySegmentCreate = TempCompanySegment::where('id_user', $id)
        ->where('id_request_update', $id_request)
        ->where('action', 'CREATE')->get();
        
        foreach($tempCompanySegmentCreate as $d){
            $companySegment = new CompanySegment;
            $companySegment->id_user = $d->id_user;
            $companySegment->id_segment = $d->id_segment;
            $companySegment->others_segment = $d->others_segment;
            $companySegment->save();
        }
        
        //UPDATE SEGMENT
        $tempCompanySegmentUpdate = TempCompanySegment::where('id_user', $id)
        ->where('id_request_update', $id_request)
        ->where('action', 'UPDATE')->get();
        
        $companySegment = CompanySegment::select('id_company_segment')->where('id_user', $id)->get();
        
        $arrayIdCompanySegment = array();
        foreach($companySegment as $d){
            $arrayIdCompanySegment[] = $d->id_company_segment; 
        }
        
        foreach($tempCompanySegmentUpdate as $d){
            if(in_array($d->id_company_segment, $arrayIdCompanySegment)){
                $companySegment = CompanySegment::where('id_company_segment', $d->id_company_segment)->first();
                $companySegment->id_user = $d->id_user;
                $companySegment->id_segment = $d->id_segment;
                $companySegment->others_segment = $d->others_segment;
                $companySegment->save();
            }
        }
        
        //DELETE SEGMENT
        $tempCompanySegmentDelete = TempCompanySegment::where('id_user', $id)
        ->where('id_request_update', $id_request)
        ->where('action', 'DELETE')->get();
        
        $companySegment = CompanySegment::select('id_company_segment')->where('id_user', $id)->get();
        
        $arrayIdCompanySegment = array();
        foreach($companySegment as $d){
            $arrayIdCompanySegment[] = $d->id_company_segment; 
        }
        
        foreach($tempCompanySegmentDelete as $d){
            if(in_array($d->id_company_segment, $arrayIdCompanySegment)){
                $companySegment = CompanySegment::where('id_company_segment', $d->id_company_segment)->delete();
            }
        }
        
        //CREATE SHAREHOLDERS
        $tempCompanyShareholdersCreate = TempCompanyShareholders::where('id_user', $id)
        ->where('id_request_update', $id_request)
        ->where('action', 'CREATE')->get();
        
        foreach($tempCompanyShareholdersCreate as $d){
            $companyShareholders = new CompanyShareholders;
            $companyShareholders->id_user = $d->id_user;
            $companyShareholders->id_position = $d->id_position;
            $companyShareholders->id_status = $d->id_status;
            $companyShareholders->name = $d->name;
            $companyShareholders->number_id = $d->number_id;
            $companyShareholders->total = $d->total;
            $companyShareholders->save();
        }
        
        //UPDATE SHAREHOLDERS
        $tempCompanyShareholdersUpdate = TempCompanyShareholders::where('id_user', $id)
        ->where('id_request_update', $id_request)
        ->where('action', 'UPDATE')->get();
        
        $companyShareholders = CompanyShareholders::select('id_company_shareholders')->where('id_user', $id)->get();
        
        $arrayIdCompanyShareholders = array();
        foreach($companyShareholders as $d){
            $arrayIdCompanyShareholders[] = $d->id_company_shareholders; 
        }
        
        foreach($tempCompanyShareholdersUpdate as $d){
            if(in_array($d->id_company_shareholders, $arrayIdCompanyShareholders)){
                $companyShareholders = CompanyShareholders::where('id_company_shareholders', $d->id_company_shareholders)->first();
                $companyShareholders->id_user = $d->id_user;
                $companyShareholders->id_position = $d->id_position;
                $companyShareholders->id_status = $d->id_status;
                $companyShareholders->name = $d->name;
                $companyShareholders->number_id = $d->number_id;
                $companyShareholders->total = $d->total;
                $companyShareholders->save();
            }
        }
        
        //DELETE SHAREHOLDERS
        $tempCompanyShareholdersDelete = TempCompanyShareholders::where('id_user', $id)
        ->where('id_request_update', $id_request)
        ->where('action', 'DELETE')->get();
        
        $companyShareholders = CompanyShareholders::select('id_company_shareholders')->where('id_user', $id)->get();
        
        $arrayIdCompanyShareholders = array();
        foreach($companyShareholders as $d){
            $arrayIdCompanyShareholders[] = $d->id_company_shareholders; 
        }
        
        foreach($tempCompanyShareholdersDelete as $d){
            if(in_array($d->id_company_shareholders, $arrayIdCompanyShareholders)){
                $companyShareholders = CompanyShareholders::where('id_company_shareholders', $d->id_company_shareholders)->delete();
                
                //Update Paid Up Capital
                $data_company = DetailCompany::where('id_user', $id)->first();
                $sum_total_share_after = CompanyShareHolders::where('id_user', $id)->sum('total');
                $data_company->paid_up_capital = $sum_total_share_after;
                $data_company->save();
            }
        }
        
        //CREATE WORKERS
        $tempCompanyWorkersCreate = TempCompanyWorkers::where('id_user', $id)
        ->where('id_request_update', $id_request)
        ->where('action', 'CREATE')->get();
        
        foreach($tempCompanyWorkersCreate as $d){
            $companyWorkers = new CompanyWorkers;
            $companyWorkers->id_user = $d->id_user;
            $companyWorkers->id_country = $d->id_country;
            $companyWorkers->id_position = $d->id_position;
            $companyWorkers->id_status = $d->id_status;
            $companyWorkers->ic_number = $d->ic_number;
            $companyWorkers->id_segment = $d->id_segment;
            $companyWorkers->others_segment = $d->others_segment;
            $companyWorkers->name = $d->name;
            $companyWorkers->certificate = $d->certificate;
            $companyWorkers->save();
        }
        
        //DELETE WORKERS
        $tempCompanyWorkersDelete = TempCompanyWorkers::where('id_user', $id)
        ->where('id_request_update', $id_request)
        ->where('action', 'DELETE')->get();
        
        $companyWorkers = CompanyWorkers::select('id_company_workers')->where('id_user', $id)->get();
        
        $arrayIdCompanyWorkers = array();
        foreach($companyWorkers as $d){
            $arrayIdCompanyWorkers[] = $d->id_company_workers; 
        }
        
        foreach($tempCompanyWorkersDelete as $d){
            if(in_array($d->id_company_workers, $arrayIdCompanyWorkers)){
                $companyWorkers = CompanyWorkers::where('id_company_workers', $d->id_company_workers)->delete();
            }
        }
        
        //CREATE COMPANY PROJECT
        $tempCompanyProjectCreate = TempCompanyProject::where('id_user', $id)
        ->where('id_request_update', $id_request)
        ->where('action', 'CREATE')->get();
        
        foreach($tempCompanyProjectCreate as $d){
            $companyProject = new CompanyProject;
            $companyProject->id_user = $d->id_user;
            $companyProject->id_source = $d->id_source;
            $companyProject->id_country = $d->id_country;
            $companyProject->id_segment = $d->id_segment;
            $companyProject->others = $d->others;
            $companyProject->client = $d->client;
            $companyProject->project_name = $d->project_name;
            $companyProject->start_date = $d->start_date;
            $companyProject->completion_date = $d->completion_date;
            $companyProject->project_value = $d->project_value;
            $companyProject->offer_later = $d->offer_later;
            $companyProject->save();
        }
        
        //DELETE COMPANY PROJECT
        $tempCompanyProjectDelete = TempCompanyProject::where('id_user', $id)
        ->where('id_request_update', $id_request)
        ->where('action', 'DELETE')->get();
        
        $companyProject = CompanyProject::select('id_company_project')->where('id_user', $id)->get();
        
        $arrayIdCompanyProject = array();
        foreach($companyProject as $d){
            $arrayIdCompanyProject[] = $d->id_company_project; 
        }
        
        foreach($tempCompanyProjectDelete as $d){
            if(in_array($d->id_swec_company, $arrayIdCompanyProject)){
                $companyProject = CompanyProject::where('id_company_project', $d->id_company_project)->delete();
            }
        }
        
        //CREATE VENDOR LICENSES
        $tempCompanyVendorLicensesCreate = TempCompanyVendorLicenses::where('id_user', $id)
        ->where('id_request_update', $id_request)
        ->where('action', 'CREATE')->get();
        
        foreach($tempCompanyVendorLicensesCreate as $d){
            $companyVendorLicenses = new CompanyVendorLicenses;
            $companyVendorLicenses->id_user = $d->id_user;
            $companyVendorLicenses->id_vendor_licenses = $d->id_vendor_licenses;
            $companyVendorLicenses->others = $d->others;
            $companyVendorLicenses->issued_date = $d->issued_date;
            $companyVendorLicenses->expire_date = $d->expire_date;
            $companyVendorLicenses->licenses_file = $d->licenses_file;
            $companyVendorLicenses->save();
        }
        
        //UPDATE VENDOR LICENSES
        $tempCompanyVendorLicensesUpdate = TempCompanyShareholders::where('id_user', $id)
        ->where('id_request_update', $id_request)
        ->where('action', 'UPDATE')->get();
        
        $companyVendorLicenses = CompanyVendorLicenses::select('id_company_vendor_licenses')->where('id_user', $id)->get();
        
        $arrayIdCompanyVendorLicenses = array();
        foreach($companyVendorLicenses as $d){
            $arrayIdCompanyVendorLicenses[] = $d->id_company_vendor_licenses; 
        }
        
        foreach($tempCompanyVendorLicensesUpdate as $d){
            if(in_array($d->id_company_vendor_licenses, $arrayIdCompanyVendorLicenses)){
                $companyVendorLicenses = CompanyVendorLicenses::where('id_company_vendor_licenses', $d->id_company_vendor_licenses)->first();
                $companyVendorLicenses->id_user = $d->id_user;
                $companyVendorLicenses->id_vendor_licenses = $d->id_vendor_licenses;
                $companyVendorLicenses->others = $d->others;
                $companyVendorLicenses->issued_date = $d->issued_date;
                $companyVendorLicenses->expire_date = $d->expire_date;
                $companyVendorLicenses->licenses_file = $d->licenses_file;
                $companyVendorLicenses->save();
            }
        }
        
        //DELETE VENDOR LICENSES
        $tempCompanyVendorLicensesDelete = TempCompanyVendorLicenses::where('id_user', $id)
        ->where('id_request_update', $id_request)
        ->where('action', 'DELETE')->get();
        
        $companyVendorLicenses = CompanyVendorLicenses::select('id_company_vendor_licenses')->where('id_user', $id)->get();
        
        $arrayIdCompanyVendorLicenses = array();
        foreach($companyVendorLicenses as $d){
            $arrayIdCompanyVendorLicenses[] = $d->id_company_vendor_licenses; 
        }
        
        foreach($tempCompanyVendorLicensesDelete as $d){
            if(in_array($d->id_company_vendor_licenses, $arrayIdCompanyVendorLicenses)){
                $companyVendorLicenses = CompanyVendorLicenses::where('id_company_vendor_licenses', $d->id_company_vendor_licenses)->delete();
            }
        }
        
        //CREATE SWEC CODE
        $tempCompanySwecCodeCreate = TempCompanySwecCode::where('id_user', $id)
        ->where('id_request_update', $id_request)
        ->where('action', 'CREATE')->get();
        
        foreach($tempCompanySwecCodeCreate as $d){
            $companySwecCode = new CompanySwecCode;
            $companySwecCode->id_user = $d->id_user;
            $companySwecCode->id_work_category = $d->id_work_category;
            $companySwecCode->id_sub_work_category = $d->id_sub_work_category;
            $companySwecCode->id_specific_work = $d->id_specific_work;
            $companySwecCode->save();
        }
        
        //DELETE SWEC CODE
        $tempCompanySwecCodeDelete = TempCompanySwecCode::where('id_user', $id)
        ->where('id_request_update', $id_request)
        ->where('action', 'DELETE')->get();
        
        $companySwecCode = CompanySwecCode::select('id_swec_company')->where('id_user', $id)->get();
        
        $arrayIdCompanySwecCode = array();
        foreach($companySwecCode as $d){
            $arrayIdCompanySwecCode[] = $d->id_swec_company; 
        }
        
        foreach($tempCompanySwecCodeDelete as $d){
            if(in_array($d->id_swec_company, $arrayIdCompanySwecCode)){
                $companySwecCode = CompanySwecCode::where('id_swec_company', $d->id_swec_company)->delete();
            }
        }
        
        //UPDATE TABLE REQUEST UPDATE
        $requestUpdate = RequestUpdate::where('id_request_update', $id_request)->first();
        $requestUpdate->note_admin = $request->note;
        $requestUpdate->status_approval = "APPROVED";
        $requestUpdate->save();
        
        //SAVE TO LOG
        $log = new LogCertificate();
        
        $user = Auth::user();
        
        $log->id_user = $id;
        $log->id_created_by = $user->id;
        $log->id_level = $user->id_level;
        $log->status = "APPROVED";
        $log->note = $request->note;
        $log->save();
        
        $company = User::where('id', $id)->first();
        
        //SEND EMAIL
        $from = "sabahloka.hq@gmail.com";
        $user_name = $company->first_name.' '.$company->last_name;
        $company_name = $company->company->full_company_name;
        $user_email = isset($company->email)?$company->email:'mail@mail.com';
        $msg = "Congratulations! Your company ".$company_name." request data update Approved.";
        $subject = "Company Request Data Update Approved";
                
        $data = array('data' => $user,
                  'msg' => $msg,
                  'name' => $company_name,
                  );
        $mail = \Mail::send('email.company_approval', $data, function($message) use ($user_name, $user_email, $from, $subject) {
                    $message->to($user_email, $user_email)->subject($subject);
                    $message->from($from,"OGSE");
                });
        
        // return response()->json($companySegment);
        return view('admin.requestUpdateCompany.index_waiting');
        
    }
    
    public function reject_request_update(Request $request, $id, $id_request){
        
        //UPDATE TABLE REQUEST UPDATE
        $requestUpdate = RequestUpdate::where('id_request_update', $id_request)->first();
        $requestUpdate->note_admin = $request->note;
        $requestUpdate->status_approval = "REJECTED";
        $requestUpdate->save();
        
        //SAVE TO LOG
        $log = new LogCertificate();
        
        $user = Auth::user();
        
        $log->id_user = $id;
        $log->id_created_by = $user->id;
        $log->id_level = $user->id_level;
        $log->status = "REJECTED";
        $log->note = $request->note;
        $log->save();
        
        $company = User::where('id', $id)->first();
        
        //SEND EMAIL
        $from = "sabahloka.hq@gmail.com";
        $user_name = $company->first_name.' '.$company->last_name;
        $company_name = $company->company->full_company_name;
        $user_email = isset($company->email)?$company->email:'mail@mail.com';
        $msg = "Sorry! Your company ".$company_name." request data update Rejected.";
        $subject = "Company Request Data Update Rejected";
                
        $data = array('data' => $user,
                  'msg' => $msg,
                  'name' => $company_name,
                  );
        $mail = \Mail::send('email.company_approval', $data, function($message) use ($user_name, $user_email, $from, $subject) {
                    $message->to($user_email, $user_email)->subject($subject);
                    $message->from($from,"OGSE");
                });
        
        // return response()->json($companySegment);
        return view('admin.requestUpdateCompany.index_rejected');
        
    }
    
    public function index_detail($id){
        
        // $data = User::findOrFail($id);
        $data = RequestUpdate::findOrFail($id);
        
        $company = User::findOrFail($data->id_user);
        $detail_company = DetailCompany::where('id_user', $data->id_user)->first();
        
        $temp_company = User::findOrFail($data->id_user);
        
        $data_detail = DetailCompany::with('company_type')->where('id_user', $data->id_user)->first();
        // $temp_data_detail = TempDetailCompany::with('company_type','country')->where('id_user', $data->id_user)->where('id_request_update', $id)->first();
        // return response()->json($temp_data_detail);
        setlocale(LC_MONETARY, 'ms_MY');
                
        $company->auth_paid_up_capital = 'RM'.number_format($detail_company->auth_paid_up_capital);
        $company->paid_up_capital = 'RM'.number_format($detail_company->paid_up_capital);
        
        // $temp_company->auth_paid_up_capital = 'RM'.number_format($temp_data_detail->auth_paid_up_capital);
        // $temp_company->paid_up_capital = 'RM'.number_format($temp_data_detail->paid_up_capital);
        
        $user = $data->id_user;
            
         $data_bumiputera = CompanyShareHolders::where('id_user', $data->id_user)->where('id_status','1')->sum('total');
         $data_non_bumiputera = CompanyShareHolders::where('id_user', $data->id_user)->where('id_status','2')->sum('total');
         $data_foreign = CompanyShareHolders::where('id_user', $data->id_user)->where('id_status','3')->sum('total');
         
         $company_detail = DetailCompany::where('id_user', $data->id_user)->first();
         $temp_company_detail = TempDetailCompany::where('id_user', $data->id_user)->where('id_request_update', $id)->first();
         
        //  $company->company_type = $data_detail->company_type->company_type;
        //  $temp_company->company_type = $temp_data_detail->company_type->company_type;
        //  $temp_company->country = $temp_data_detail->country->country_name;
        //  $temp_company->state = $temp_data_detail->state->state;
        //  $temp_company->city = $temp_data_detail->city->city;
        //  $temp_company->logo_picture = $temp_data_detail->logo_picture;
        //  $temp_company->company_organization_chart = $temp_data_detail->company_organization_chart;
        //  $temp_company->company_ssm_certificate = $temp_data_detail->company_ssm_certificate;
        //  $temp_company->company_ssm_section_14 = $temp_data_detail->company_ssm_section_14;
        //  $temp_company->company_ssm_section_17 = $temp_data_detail->company_ssm_section_17;
        //  $temp_company->company_ssm_company_information = $temp_data_detail->company_ssm_company_information;
        //  $temp_company->company_ssm_trading_license = $temp_data_detail->company_ssm_trading_license;

         
        //  $temp_company->organization_chart = $temp_data_detail->temp_company->company_organization_chart;
         
        //  if($company_detail->paid_up_capital !== null){
        //      $data->percentage_bumiputera = number_format((($data_bumiputera / $company_detail->paid_up_capital) * 100), 1, ',', '.').'%';
        //  }else{
        //      $data->percentage_bumiputera = '0%';
        //  }
         
        //  if($company_detail->paid_up_capital !== null){
        //      $data->percentage_non_bumiputera = number_format((($data_non_bumiputera / $company_detail->paid_up_capital) * 100), 1, ',', '.').'%';
        //  }else{
        //      $data->percentage_non_bumiputera = '0%';
        //  }
         
        //  if($company_detail->paid_up_capital !== null){
        //      $data->percentage_foreign = number_format((($data_foreign / $company_detail->paid_up_capital) * 100), 1, ',', '.').'%';
        //  }else{
        //      $data->percentage_foreign = '0%';
        //  }
    
         $data_equity_by_status = [
            'bumiputera' => $data_bumiputera,
            'non-bumiputera' => $data_non_bumiputera,
            'foreign' => $data_foreign
            ];
    
        // $company->bumiputera = money_format('%i', $data_bumiputera);
        // $company->non_bumiputera = money_format('%i', $data_non_bumiputera);
        // $company->foreign = money_format('%i', $data_foreign);
        
        $company->id_user_company = $data->id_user;
        

        return view('admin.requestUpdateCompany.index_detail', compact('data','company','temp_company'));
        
    }
    
    public function request_update_company(){
        
        $user = Auth::user()->id;
        
        $data = new RequestUpdate;  
        
        $data->id_user = $user;
        
        $data->save();
        
        //UPDATE ID REQUEST ON TABLE TEMP DETAIL COMPANY
        $detail_company = TempDetailCompany::where('id_user', $user)
        ->orderBy('id_temp_detail_company','desc')->first();
        
        //UPDATE ID REQUEST ON TABLE TEMP SEGMENT/FIELD OF BUSINESS
        $segment = TempCompanySegment::where('id_user', $user)
        ->where('id_request_update','==', null)->get();
        
        //UPDATE ID REQUEST ON TABLE TEMP VENDOR LICENSES
        $vendor_licenses = TempCompanyVendorLicenses::where('id_user', $user)
        ->where('id_request_update','==', null)->get();
        
        //UPDATE ID REQUEST ON TABLE TEMP SHAREHOLDERS
        $shareholders = TempCompanyShareHolders::where('id_user', $user)
        ->where('id_request_update','==', null)->get();
        
        //UPDATE ID REQUEST ON TABLE TEMP WORKERS
        $workers = TempCompanyWorkers::where('id_user', $user)
        ->where('id_request_update','==', null)->get();
        
        //UPDATE ID REQUEST ON TABLE TEMP PROJECT
        $project_key_client = TempCompanyProject::where('id_user', $user)
        ->where('id_request_update','==', null)
        ->where('id_source', '1')->get();
        
        $project_outsource = TempCompanyProject::where('id_user', $user)
        ->where('id_request_update','==', null)
        ->where('id_source', '2')->get();
        
        //UPDATE ID REQUEST ON TABLE TEMP SWEC CODE
        $swec_code= TempCompanySwecCode::where('id_user', $user)
        ->where('id_request_update','==', null)->get();
        
        $new_data = RequestUpdate::where('id_user', $user)
        ->orderBy('id_request_update','desc')->first();
        
        // $detail_company->id_request_update = $new_data->id_request_update;
        // $detail_company->save();
                   
        foreach($segment as $d){
            $d->id_request_update = $new_data->id_request_update;
            $d->save();
        }
        
        foreach($vendor_licenses as $d){
            $d->id_request_update = $new_data->id_request_update;
            $d->save();
        }
        
        foreach($shareholders as $d){
            $d->id_request_update = $new_data->id_request_update;
            $d->save();
        }
        
        foreach($workers as $d){
            $d->id_request_update = $new_data->id_request_update;
            $d->save();
        }
        
        foreach($project_key_client as $d){
            $d->id_request_update = $new_data->id_request_update;
            $d->save();
        }
        
        foreach($project_outsource as $d){
            $d->id_request_update = $new_data->id_request_update;
            $d->save();
        }
        
        foreach($swec_code as $d){
            $d->id_request_update = $new_data->id_request_update;
            $d->save();
        }
        
        //SAVE TO LOG
        $log = new LogCertificate();
        
        $user = Auth::user();
        
        $log->id_user = $user->id;
        $log->id_created_by = $user->id;
        $log->id_level = $user->id_level;
        $log->status = "WAITING";
        $log->note = "Request Data Update Company";
        $log->save();
        
        $company = User::where('id', $user->id)->first();
        
        //SEND EMAIL
        $from = "sabahloka.hq@gmail.com";
        $user_name = $user->first_name.' '.$user->last_name;
        $company_name = $user->company->full_company_name;
        $user_email = 'sabahloka.hq@gmail.com';
        $msg = "There is a data update request from the company ".$company_name;
        $subject = "Company Request Data Update";
                
        $data = array('data' => $user,
                  'msg' => $msg,
                  'name' => $company_name,
                  );
        $mail = \Mail::send('email.company_approval', $data, function($message) use ($user_name, $user_email, $from, $subject) {
                    $message->to($user_email, $user_email)->subject($subject);
                    $message->from($from,"OGSE");
                });
        
        // $result = [
        //     'data vendor licenses' => $vendor_licenses,
        //     'data shareholders' => $shareholders,
        //     'data_segment' => $segment,
        //     'data swec code' => $swec_code,
        //     'id' => $new_data->id_request_update,
        //     ];
            
        // return response()->json($result);
        return redirect("/logCertificate")->with('success_request','You have requested for Data Update Company. It may takes sometime while our team will verify your company information. An email will be sent once approved.');
        
    }
    
    public function index(Request $request)
    {

        $user = Auth::user();

        if ($request->ajax()) {

            $status = $request->status;
        
            // $user = Auth::user();
        
            $data = RequestUpdate::with('user','detail_company')->orderBy('id_request_update','asc')->whereHas('user');
            
            if($user->id_level != 1) {
                $data = $data->where('id_user', $user->id);
            }

            if($status != "") {
                $data = $data->where('status_approval', $status);

                if($status == "Approved" || $status == "Rejected"){
                    $data = $data->orderBy('id_request_update', 'DESC');
                }
            }

            if($user->id_level == 4) {

                $pegawai_daerah = User::select('id')->where('id_city', $user->id_city)->where('id_level', 4)->get();

                foreach ($pegawai_daerah as $i => $d) {
                    if($i == 0){
                        $data = $data->whereHas('detail_company', function($query) use($user) {
                            $query->where('id_pegawai_daerah', 'LIKE', '%'. $d->id .'%');
                        });
                    } else {
                        $data = $data->whereHas('detail_company', function($query) use($user) {
                            $query->orWhere('id_pegawai_daerah', 'LIKE', '%'. $d->id .'%');
                        });
                    }
                    
                }

                // $data = $data->whereHas('detail_company', function($query) use($user) {
                //     $query->where('id_pegawai_daerah', 'LIKE', '%'. $user->id .'%');
                // });
            }

            $data = $data->get();

            foreach($data as $d){
                
                $d->company_name = isset($d->detail_company->full_company_name)?$d->detail_company->full_company_name: '';
                $d->contact_person = isset($d->user->first_name)?$d->user->last_name: '';
                $d->phone_office = isset($d->detail_company->phone_office)?$d->detail_company->phone_office: '';
                $d->email = isset($d->user->email)?$d->user->email: '';
                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
                
            }
            
            // $result = [
            //     'data' => $data
            //     ];
                
            // return response()->json($data);
            
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        
        return view('admin.requestUpdateCompany.index');
    }
    
    public function index_rejected(Request $request)
    {
        if ($request->ajax()) {
        
            $data = RequestUpdate::with('user','detail_company')->where('status_approval','REJECTED')->orderBy('id_request_update','desc')->get();
            
            foreach($data as $d){
                
                $d->company_name = isset($d->detail_company->full_company_name)?$d->detail_company->full_company_name: '';
                $d->contact_person = isset($d->user->first_name)?$d->user->last_name: '';
                $d->phone_office = isset($d->detail_company->phone_office)?$d->detail_company->phone_office: '';
                $d->email = isset($d->user->email)?$d->user->email: '';
                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
                
            }
            
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        
        return view('admin.requestUpdateCompany.index_rejected');
    }
    
    public function index_approved(Request $request)
    {
        if ($request->ajax()) {
        
            $data = RequestUpdate::with('user','detail_company')->where('status_approval','APPROVED')->orderBy('id_request_update','desc')->get();
            
            foreach($data as $d){
                
                $d->company_name = isset($d->detail_company->full_company_name)?$d->detail_company->full_company_name: '';
                $d->contact_person = isset($d->user->first_name)?$d->user->last_name: '';
                $d->phone_office = isset($d->detail_company->phone_office)?$d->detail_company->phone_office: '';
                $d->email = isset($d->user->email)?$d->user->email: '';
                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
                
            }
            
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        
        return view('admin.requestUpdateCompany.index_approved');
    }
    
    public function show($id)
    {
        $data = User::findOrFail($id);
    
        $data_detail = DetailCompany::with('company_type')->where('id_user', $id)->first();
        // $temp_data_detail = TempDetailCompany::with('company_type')->where('id_user', $id)->first();
        
        
        return view('company.viewCompanyDetail', compact('data','data_detail'));
    }
    
    public function edit($id)
    {
        $data = User::findOrFail($id);
        return view('company.editCompanyDetail', compact('data'));
    }
    
    public function update(Request $request, $id)
    {
        $data = User::findOrFail($id);
        
        if($data){
            $man = DetailCompany::where('id_user',$data->id)->first();
            $man->id_user = $data->id;
            $man->full_company_name = $request->full_company_name;
            $man->company_registration_old_number = $request->company_registration_old_number;
            $man->company_registration_new_number = $request->company_registration_new_number;
            $man->address = $request->address;
            $man->postcode = $request->postcode;
            $man->phone_office = $request->phone_office;
            $man->fax_number = $request->fax_number;
            $man->company_website = $request->company_website;
            if($request->id_country) $man->id_country = $request->id_country;
            if($request->id_state) $man->id_state = $request->id_state;
            if($request->id_city) $man->id_city = $request->id_city;
            if($request->id_company_type) $man->id_company_type = $request->id_company_type;
    
            if($request->hasFile('logo_picture')){
                $file = $request->file('logo_picture');
                $n = "LOGO-" . md5(time()) . '.' .$file->getClientOriginalExtension();
                $name = "$n";
                $file->move(public_path().'/CompanyLogo',$name);
                $file1 = $name;
            }else{
                $file1 = $man->logo_picture;
            }
            
            if($request->hasFile('company_organization_chart')){
                $file = $request->file('company_organization_chart');
                $n = "ORGANIZATION-CHART-" . md5(time()) . '.' .$file->getClientOriginalExtension();
                $name = "$n";
                $file->move(public_path().'/OrganizationChart',$name);
                $file2 = $name;
            }else{
                $file2 = $man->company_organization_chart;
            }
            
            if($request->hasFile('ssm_certificate')){
                $file = $request->file('ssm_certificate');
                // $n = $file->getClientOriginalName();
                $n = "SSM-CERTIFICATE-" . md5(time()) . '.' .$file->getClientOriginalExtension();
                $name = "$n";
                $file->move(public_path().'/CompanySsmCertificate',$name);
                $file3 = $name;
            }else{
                $file3 = $man->company_ssm_certificate;
            }
            
            if($request->hasFile('ssm_section_14')){
                $file = $request->file('ssm_section_14');
                $n = "SSM-SECTION-14-" . md5(time()) . '.' .$file->getClientOriginalExtension();
                $name = "$n";
                $file->move(public_path().'/CompanySsmSection14',$name);
                $file4 = $name;
            }else{
                $file4 = $man->company_ssm_section_14;
            }
            
            if($request->hasFile('ssm_section_17')){
                $file = $request->file('ssm_section_17');
                $n = "SSM-SECTION-17-" . md5(time()) . '.' .$file->getClientOriginalExtension();
                $name = "$n";
                $file->move(public_path().'/CompanySsmSection17',$name);
                $file5 = $name;
            }else{
                $file5 = $man->company_ssm_section_14;
            }
            
            if($request->hasFile('ssm_company_information')){
                $file = $request->file('ssm_company_information');
                $n = "SSM-COMPANY-INFORMATION-" . md5(time()) . '.' .$file->getClientOriginalExtension();
                $name = "$n";
                $file->move(public_path().'/CompanySsmCompanyInformation',$name);
                $file6 = $name;
            }else{
                $file6 = $man->company_ssm_company_information;
            }
            
            if($request->hasFile('ssm_trading_license')){
                $file = $request->file('ssm_trading_license');
                $n = "SSM-TRADING-LICENSE-" . md5(time()) . '.' .$file->getClientOriginalExtension();
                $name = "$n";
                $file->move(public_path().'/CompanySsmTradingLicense',$name);
                $file7 = $name;
            }else{
                $file7 = $man->company_ssm_trading_license;
            }
            
            $man->logo_picture = $file1;
            $man->company_organization_chart = $file2;
            $man->company_ssm_certificate = $file3;
            $man->company_ssm_section_14 = $file4;
            $man->company_ssm_section_17 = $file5;
            $man->company_ssm_company_information = $file6;
            $man->company_ssm_trading_license = $file7;
            $man->save();
        }
        // return $man;
        //return redirect()->back()->with('success','Updated successfully');
        return redirect("companyDetail/$id")->with('success','Updated successfully');
    }
    
    public function create(Request $request)
    {
        
    }
    public function index_company(){
        return view('company.viewCompanyDetail');
    }
    
    public function edit_company(){
        return view('company.editCompanyDetail');
    }
    
    public function request_certificate(Request $request){
        
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
        $user_name = $user->first_name.' '.$user->last_name;
        $to_email = "sabahloka.hq@gmail.com";
        $msg = "Hai! Company ".$company_name." request certificate.";
        $subject = "Company Request Certificate";
                
        $data = array('data' => $user,
                  'msg' => $msg,
                  'name' => $user_name,
                  );
        $mail = \Mail::send('email.company_approval', $data, function($message) use ($user_name, $to_email, $from, $subject) {
                    $message->to($to_email, $to_email)->subject($subject);
                    $message->from($from,"OGSE");
                });

        // return view('company.viewLogCertificate')->with('success_request','Request certificate successfully');
        return redirect("/logCertificate")->with('success_request','You have requested for Registration Certificate. It may takes sometime while our team will verify your company information before we produce the certificate. An email will be sent once approved.');
        
    }
    
    public function index_certificate(Request $request){
        
        if ($request->ajax()) {
        
            $user = Auth::user();
        
            $data = LogCertificate::with('user','level')->where('id_user', $user->id)->orderBy('id_log_certificate','desc')->get();
            
            foreach($data as $d){
                
                $d->user_level = isset($d->level->level)?$d->level->level: '';
                $d->status = isset($d->status)?$d->status: '';
                $d->note = isset($d->note)?$d->note: '';
                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
                
            }
            
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        
        return view('company.viewLogCertificate');
        
    }
    
    public function cetak_pdf(Request $request, $id)
    {
    	$data = User::findOrFail($id);
    
    	$pdf = PDF::loadview('company.certifikat',['data'=>$data]);
    	return $pdf->stream();
    }
    
    
}
