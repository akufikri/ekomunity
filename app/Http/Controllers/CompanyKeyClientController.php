<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailCompany;
use App\Models\CompanyProject;
use App\Models\TempCompanyProject;
use App\Models\Country;
use App\Models\User;
use App\Models\Segment;
use DataTables;
use Redirect;
use DB;
use Auth;

class CompanyKeyClientController extends Controller
{
    public function __constructor(){
        $this->middleware('company');
    }
    
    public function index_keyClient2(){
        return view('company.viewKeyClient&Project');
    }
    
    public function index_keyClient(Request $request)
    {
        if ($request->ajax()) {
            
            // $data = CompanyProject::orderBy('id_company_project','desc')->get();
            
            $user = Auth::user()->id;
            
             $data = CompanyProject::whereHas('source', function($source) {
                $source->where('id_source','1');
            })->with('source','country','segment')
            ->where('id_user',$user)
            ->orderBy('id_company_project','desc')->get();
            
            foreach($data as $d){
              
                $d->country_name_rafi = isset($d->country->country_name)?$d->country->country_name:'';
                $d->segment_name_rafi = isset($d->segment->segment)?$d->segment->segment:'';
                $d->start_date = date('d-m-Y h:i:s', strtotime($d->start_date));
                $d->completion_date = date('d-m-Y h:i:s', strtotime($d->completion_date));
                
                // let's print the international format for the en_US locale
                setlocale(LC_MONETARY, 'ms_MY');
                // setlocale(LC_MONETARY, 'id_ID');
                // setlocale(LC_MONETARY, 'en_US');
                // echo 'RM'.number_format($number) . "\n";
                // USD 1,234.56
                
                $d->project_value = 'RM'.number_format($d->project_value);
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        return view('company.viewKeyClientProject');
    }
    
    public function index_keyClient_temp(Request $request)
    {
        if ($request->ajax()) {
            
            $user = Auth::user()->id;
            
             $data = TempCompanyProject::whereHas('source', function($source) {
                $source->where('id_source','1');
            })->with('source','country','segment')
            ->where('id_user',$user)
            ->where('id_request_update','0')
            ->orderBy('id_company_project','desc')->get();
            
            foreach($data as $d){
              
                $d->country_name_rafi = isset($d->country->country_name)?$d->country->country_name:'';
                $d->segment_name_rafi = isset($d->segment->segment)?$d->segment->segment:'';
                $d->start_date = date('d-m-Y h:i:s', strtotime($d->start_date));
                $d->completion_date = date('d-m-Y h:i:s', strtotime($d->completion_date));
                
                // let's print the international format for the en_US locale
                setlocale(LC_MONETARY, 'ms_MY');
                // setlocale(LC_MONETARY, 'id_ID');
                // setlocale(LC_MONETARY, 'en_US');
                // echo 'RM'.number_format($number) . "\n";
                // USD 1,234.56
                
                $d->project_value = 'RM'.number_format($d->project_value);
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        return view('company.viewKeyClientProject');
    }
    
    public function index_keyClient_temp_admin(Request $request, $id, $id_request)
    {
        if ($request->ajax()) {
            
            $user = $id;
            
             $data = TempCompanyProject::whereHas('source', function($source) {
                $source->where('id_source','1');
            })->with('source','country','segment')
            ->where('id_user',$user)
            ->orderBy('id_company_project','desc')->get();
            
            foreach($data as $d){
              
                $d->country_name_rafi = isset($d->country->country_name)?$d->country->country_name:'';
                $d->segment_name_rafi = isset($d->segment->segment)?$d->segment->segment:'';
                $d->start_date = date('d-m-Y h:i:s', strtotime($d->start_date));
                $d->completion_date = date('d-m-Y h:i:s', strtotime($d->completion_date));
                
                // let's print the international format for the en_US locale
                setlocale(LC_MONETARY, 'ms_MY');
                // setlocale(LC_MONETARY, 'id_ID');
                // setlocale(LC_MONETARY, 'en_US');
                // echo 'RM'.number_format($number) . "\n";
                // USD 1,234.56
                
                $d->project_value = 'RM'.number_format('%i',$d->project_value);
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        return view('company.viewKeyClientProject');
    }
    
    public function index_keyClient_admin($id ,Request $request)
    {
        if ($request->ajax()) {
            
            // $data = CompanyProject::orderBy('id_company_project','desc')->get();
            
            $user = $id;
            
             $data = CompanyProject::whereHas('source', function($source) {
                $source->where('id_source','1');
            })->with('source','country','segment')
            ->where('id_user',$user)
            ->orderBy('id_company_project','desc')->get();
            
            foreach($data as $d){
              
                $d->country_name_rafi = isset($d->country->country_name)?$d->country->country_name:'';
                $d->segment_name_rafi = isset($d->segment->segment)?$d->segment->segment:'';
                $d->start_date = date('d-m-Y h:i:s', strtotime($d->start_date));
                $d->completion_date = date('d-m-Y h:i:s', strtotime($d->completion_date));
                
                // let's print the international format for the en_US locale
                setlocale(LC_MONETARY, 'ms_MY');
                // setlocale(LC_MONETARY, 'id_ID');
                // setlocale(LC_MONETARY, 'en_US');
                // echo 'RM'.number_format($number) . "\n";
                // USD 1,234.56
                
                $d->project_value = 'RM'.number_format($d->project_value);

            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        return view('company.viewKeyClientProject');
    }
    
    public function create(Request $request)
    {
        $this->validate($request, [
            'offer_later' => 'required',
            'offer_later.*' => 'mimes:doc,pdf,docx,zip'
        ]);
        
        if($request->hasfile('offer_later')){
            foreach($request->file('offer_later') as $file){
                $name=$file->getClientOriginalName();
                $file->move(public_path().'/CompanyProject/', $name);  
                $data_file[] = $name;  
            }
        }
        
        
        $user = Auth::user()->id;
        
        $company = DetailCompany::where('id_user', $user)->first();
        
        if($company->certificate_expired_date > date('Y-m-d')){
            
            $data = new TempCompanyProject;
            
            $data->action = "CREATE";
            
        } else {
            
            $data = new CompanyProject;
            
        }

        $data->id_user = $user;
        $data->id_source = 1;
        $data->id_country = $request->country;
        $data->id_segment = $request->segment;
        
        if($request->segment === '0'){
            $data->others = $request->others_segment_add;
        } else{
            $segment = Segment::where('id_segment',$request->segment)->first();
            $data->others = $segment->segment;
        }
        
        $data->client = $request->client;
        $data->project_name = $request->project_name;
        $data->start_date = $request->start_date;
        $data->completion_date = $request->completion_date;
        $data->project_value = $request->project_value;
        $data->offer_later=json_encode($data_file);
        
        $data->save();
        return redirect()->back()->with('success','Created successfully');
        
    }
    
    public function edit($id, Request $r)
    {
        $data = CompanyProject::findOrFail($id);
        $offer = array($data->offer_later);
        $datas = json_decode($offer[0]);
        return view('company.edit_key_project', compact('data','datas'));
    }
    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'offer_later' => 'required',
            'offer_later.*' => 'mimes:doc,pdf,docx,zip'
        ]);
        
        $data = CompanyProject::findOrFail($id);
        
        $data->id_source = 1;
        if($request->id_country) $data->id_country = $request->id_country;
        if($request->id_segment) $data->id_segment = $request->id_segment;
        if($request->others) $data->others = $data->id_segment;
        $data->client = $request->client;
        $data->project_name = $request->project_name;
        $data->start_date = $request->start_date;
        $data->completion_date = $request->completion_date;
        $data->project_value = $request->project_value;
        
        if($request->hasfile('offer_later')){
            foreach($request->file('offer_later') as $file){
                $name=$file->getClientOriginalName();
                $file->move(public_path().'/CompanyProject/', $name);  
                $data_file[] = $name;  
            }
        $data->offer_later = json_encode($data_file); 
        }else{
            $data->offer_later = $data->offer_later; 
        }
        
        $data->save();
        return redirect()->to('/companyKeyClientProject#view')->with('success','Updated successfully');; 
    }
    
    public function destroy($id){
        
        $user = Auth::user()->id;
        
        $data_company = DetailCompany::where('id_user', $user)->first();
        
        $company_project = CompanyProject::where('id_company_project', $id)->first();
        
        if($data_company->certificate_expired_date > date('Y-m-d')){
            
            $data = new TempCompanyProject;
            
            $data->id_user = $user;
            $data->id_source = 1;
            $data->id_country = $company_project->id_country;
            $data->id_segment = $company_project->id_segment;
            $data->others = $company_project->others;
            $data->client = $company_project->client;
            $data->project_name = $company_project->project_name;
            $data->start_date = $company_project->start_date;
            $data->completion_date = $company_project->completion_date;
            $data->project_value = $company_project->project_value;
            
            $data->id_company_project = $id;
            $data->action = "DELETE";
            
            $data->save();
            
        } else {
            
            $data = CompanyProject::where('id_company_project', $id)->first();
            $data->delete();

        }
            
        return response()->json(['success'=>'Project deleted successfully']);
    }
    
    public function temp_destroy($id){
        
        $data = TempCompanyProject::where('id_temp_company_project', $id)->first();
        $data->delete();

        return response()->json(['success'=>'Cancel update successfully']);
    }
}
