<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailCompany;
use App\Models\CompanySegment;
use App\Models\User;
use App\Models\Segment;
use App\Models\CompanyWorkers;
use App\Models\TempCompanyWorkers;
use DataTables;
use Redirect;
use DB;
use Auth;
use File;

class CompanyWorkersController extends Controller
{
    public function __constructor(){
        $this->middleware('company');
    }
    
    public function index(Request $request){
        
        if ($request->ajax()) {
            
            $user = Auth::user()->id;
            
            $data = CompanyWorkers::with('user','segment','position','country','status')
            ->where('id_user', $user)
            ->orderBy('id_company_workers','desc')->get();
            
            foreach($data as $d){
                $d->segment_name = isset($d->segment->segment)?$d->segment->segment:'';
                $d->position_name = isset($d->position->position)?$d->position->position:'';
                $d->country_name = isset($d->country->country_name)?$d->country->country_name:'';
                $d->status_native = isset($d->status->status_native)?$d->status->status_native:'';
                $certifikat = array($d->certificate);
                $datas = json_decode($certifikat[0]);
                $d->certificate = $datas;
                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
                
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        // return view('employee.index');
        // return view('admin.settingsPosition.index');
        return view('company.viewWorkers');
        
    }
    
    public function index_temp(Request $request){
        
        if ($request->ajax()) {
            
            $user = Auth::user()->id;
            
            $data = TempCompanyWorkers::with('user','segment','position','country','status')
            ->where('id_user', $user)
            ->where('id_request_update','0')
            ->orderBy('id_temp_company_workers','desc')->get();
            
            foreach($data as $d){
                $d->segment_name = isset($d->segment->segment)?$d->segment->segment:'';
                $d->position_name = isset($d->position->position)?$d->position->position:'';
                $d->country_name = isset($d->country->country_name)?$d->country->country_name:'';
                $d->status_native = isset($d->status->status_native)?$d->status->status_native:'';
                
                $d->create_date = date('d-m-Y h:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        
        // return response($data);

        return view('company.viewWorkers');
        
    }
    
    public function index_temp_admin(Request $request, $id, $id_request){
        
        if ($request->ajax()) {
            
            $user = $id;
            
            $data = TempCompanyWorkers::with('user','segment','position','country','status')
            ->where('id_user', $user)
            ->orderBy('id_company_workers','desc')->get();
            foreach($data as $d){
                $d->segment_name = isset($d->segment->segment)?$d->segment->segment:'';
                $d->position_name = isset($d->position->position)?$d->position->position:'';
                $d->country_name = isset($d->country->country_name)?$d->country->country_name:'';
                $d->status_native = isset($d->status->status_native)?$d->status->status_native:'';
                
                $d->create_date = date('d-m-Y h:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        // return view('employee.index');
        // return view('admin.settingsPosition.index');
        return view('company.viewWorkers');
        
    }
    
    public function index_admin($id, Request $request){
        
        if ($request->ajax()) {
            
            $user = $id;
            
            $data = CompanyWorkers::with('user','segment','position','country','status')
            ->where('id_user', $user)
            ->orderBy('id_company_workers','desc')->get();
            foreach($data as $d){
                $d->segment_name = isset($d->segment->segment)?$d->segment->segment:'';
                $d->position_name = isset($d->position->position)?$d->position->position:'';
                $d->country_name = isset($d->country->country_name)?$d->country->country_name:'';
                $d->status_native = isset($d->status->status_native)?$d->status->status_native:'';
                
                $d->create_date = date('d-m-Y h:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        // return view('employee.index');
        // return view('admin.settingsPosition.index');
        return view('company.viewWorkers');
        
    }
    
    public function create(Request $request)
    {
        $this->validate($request, [
            'certificate' => 'required',
            'certificate.*' => 'mimes:doc,pdf,docx,zip'
        ]);
        
        if($request->hasfile('certificate')){
            foreach($request->file('certificate') as $file){
                $name=$file->getClientOriginalName();
                $file->move(public_path().'/CertificateOfWork/', $name);  
                $data_file[] = $name;  
            }
        }
        
        $user = Auth::user()->id;
        
        $company = DetailCompany::where('id_user', $user)->first();
        
        if($company->certificate_expired_date > date('Y-m-d')){
            
            $data = new TempCompanyWorkers;
            
            $data->action = "CREATE";
            
        } else {
            
            $data = new CompanyWorkers;
            
        }
        
        $data->id_user = $user;
        $data->ic_number = $request->ic_number;
        $data->name = $request->name;
        $data->id_segment = $request->segment_add;
        $data->id_country = $request->country;
        $data->id_position = $request->position;
        $data->id_status = $request->status;
        
        if($request->segment_add === '0'){
            $data->others_segment = $request->others_segment_add;
        } else{
            $segment = Segment::where('id_segment',$request->segment_add)->first();
            $data->others_segment = $segment->segment;
        }
        
        $data->certificate=json_encode($data_file);
        $data->save();
        
        return redirect()->back()->with('success','Created successfully');
        
    }
    
    public function edit($id, Request $r)
    {
        $data = CompanyWorkers::findOrFail($id);
        $certifikat = array($data->certificate);
        $datas = json_decode($certifikat[0]);
        return view('company.edit_workers', compact('data','datas'));
    }
    
    public function show($id, Request $r)
    {
        $data = CompanyWorkers::findOrFail($id);
        $certifikat = array($data->certificate);
        $datas = json_decode($certifikat[0]);
        return view('company.edit_workers', compact('data','datas'));
    }
    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'certificate' => 'required',
            'certificate.*' => 'mimes:doc,pdf,docx,zip'
        ]);
        
        $data = CompanyWorkers::findOrFail($id);
    
        $user = Auth::user()->id;
        $data->id_user = $user;
        if($request->id_segment) $data->id_segment = $request->id_segment;
        if($request->id_country) $data->id_country = $request->id_country;
        if($request->id_position) $data->id_position = $request->id_position;
        if($request->id_status) $data->id_status = $request->id_status;
        
        $files = json_decode($data->certificate);
        if(is_array($r->file('certificate'))){
            foreach($r->file('certificate') as $file){
                $file = $file;
                $file->move(public_path()."/CertificateOfWork/",$file->getClientOriginalName());
                $files[] = $file->getClientOriginalName();
            }
            $data->certificate = json_encode($files);
            $data->save();
        }
        
        $data->ic_number = $request->ic_number;
        $data->name = $request->name;
        $data->save();
        
        return $data;
        // $data->save();
        return redirect()->to('/companyWorkers#view')->with('success','Updated successfully');; 
    }
    
    public function destroy($id){
        
        $user = Auth::user()->id;
        
        $data_company = DetailCompany::where('id_user', $user)->first();
        
        $company_workers = CompanyWorkers::where('id_company_workers', $id)->first();
        
        if($data_company->certificate_expired_date > date('Y-m-d')){
            
            $data = new TempCompanyWorkers;
            
            $data->id_user = $user;
            $data->ic_number = $company_workers->ic_number;
            $data->name = $company_workers->name;
            $data->id_segment = $company_workers->id_segment;
            $data->id_country = $company_workers->id_country;
            $data->id_position = $company_workers->id_position;
            $data->id_status = $company_workers->id_status;
            $data->others_segment = $company_workers->others_segment;
            
            $data->id_company_workers = $id;
            $data->action = "DELETE";
            
            $data->save();
            
        } else {
            
            $data = CompanyWorkers::where('id_company_workers', $id)->first();
            $data->delete();

        }
        
        return response()->json(['success'=>'Workers deleted successfully']);
    }
    
    public function remove_file(Request $r, $id){
        
        $data = CompanyWorkers::findOrFail($file);
        $files = json_decode($data->certificate);
        
        foreach($files as $file){
            File::delete(public_path('CertificateOfWork/' . $file));
        }
        
        $data->delete();
        
        \Session::flash('success', "File($file) Removed successfully!");
        \Session::flash('alert-class', 'alert-success');
        
        return redirect()->back();
    }
    
    public function temp_destroy($id){
        
        $data = TempCompanyWorkers::where('id_temp_company_workers', $id)->first();
        $data->delete();

        return response()->json(['success'=>'Cancel update successfully']);
    }

    
}
