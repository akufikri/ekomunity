<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailCompany;
use App\Models\CompanySegment;
use App\Models\TempCompanySegment;
use App\Models\User;
use App\Models\Segment;
use DataTables;
use Redirect;
use DB;
use Auth;

class CompanySegmentController extends Controller
{
    public function __constructor(){
        $this->middleware('company');
    }
    
    public function index_segment(Request $request){
        
        if ($request->ajax()) {
            
            $user = Auth::user()->id;
            
            $data = CompanySegment::with('segment')
            ->where('id_user', $user)
            ->orderBy('id_company_segment','desc')->get();
            foreach($data as $d){
                $d->segment_name = isset($d->segment->segment)?$d->segment->segment:'';
                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        // return view('employee.index');
        // return view('admin.settingsPosition.index');
        return view('company.viewSegment');
        
    }
    
    public function index_segment_temp(Request $request){
        
        if ($request->ajax()) {
            
            $user = Auth::user()->id;
            
            $data = TempCompanySegment::with('segment')
            ->where('id_user', $user)
            ->where('id_request_update','=','0')
            ->orderBy('id_company_segment','desc')->get();
            foreach($data as $d){
                $d->segment_name = isset($d->segment->segment)?$d->segment->segment:'';
                $d->create_date = date('d-m-Y h:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        // return view('employee.index');
        // return view('admin.settingsPosition.index');
        return view('company.viewSegment');
        
    }
    
    public function index_segment_admin($id, Request $request){
        
        if ($request->ajax()) {
            
            $user = $id;
            
            $data = CompanySegment::with('segment')
            ->where('id_user', $user)
            ->orderBy('id_company_segment','desc')->get();
            foreach($data as $d){
                $d->segment_name = isset($d->segment->segment)?$d->segment->segment:'';
                $d->create_date = date('d-m-Y h:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        // return view('employee.index');
        // return view('admin.settingsPosition.index');
        return view('company.viewSegment');
        
    }
    
    public function index_segment_temp_admin(Request $request, $id, $id_request){
        
        if ($request->ajax()) {
            
            $user = $id;
            
            $data = TempCompanySegment::with('segment')
            ->where('id_user', $user)
            ->where('id_request_update', $id_request)
            ->orderBy('id_company_segment','desc')->get();
            foreach($data as $d){
                $d->segment_name = isset($d->segment->segment)?$d->segment->segment:'';
                $d->create_date = date('d-m-Y h:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }

        return view('company.viewSegment');
        
    }
    
    public function create(Request $request)
    {
        
        $user = Auth::user()->id;
        
        $company = DetailCompany::where('id_user', $user)->first();
        
        if($company->certificate_expired_date > date('Y-m-d')){
            
            $data = new TempCompanySegment;
            
            $data->action = "CREATE";
            
        } else {
            
            $data = new CompanySegment;
            
        }
        
        $data->id_user = $user;
        $data->id_segment = $request->segment_add;
        
        if($request->segment_add === '0'){
            $data->others_segment = $request->others_segment_add;
        } else{
            $segment = Segment::where('id_segment',$request->segment_add)->first();
            $data->others_segment = $segment->segment;
        }

        $data->save();
        return redirect()->back()->with('success','Created successfully');
        
    }
    
    public function edit($id, Request $r)
    {
        $data = CompanySegment::with('segment')->findOrFail($id);
        
        // foreach($data as $d){
        //     $d->segment_name = $d->segment->segment;
        // }
        
        // $data->segment = 
        
        return response()->json([
            'success'=>'Get data successfully',
            'data'=>$data
            ]);
        // return view('admin.settingsPosition.index', compact('data'));
    }
    
    public function update(Request $request, $id)
    {
        
        $user = Auth::user()->id;
        
        $company = DetailCompany::where('id_user', $user)->first();
        
        if($company->certificate_expired_date > date('Y-m-d')){
            
            $data = new TempCompanySegment;
            
            $data->id_user = $user;
            
            $data->id_company_segment = $id;
            $data->action = "UPDATE";
            
        } else {
            
            $data = CompanySegment::findOrFail($id);

        }
        
        $data->id_segment = $request->segment;
        if($request->segment === '0'){
            $data->others_segment = $request->others_segment;
        } else{
            $segment = Segment::where('id_segment',$request->segment)->first();
            $data->others_segment = $segment->segment;
        }
        
        $data->save();
        
        return response()->json([
            'newToken' => csrf_token(),
            'success'=>'Update Data Successfully',
            'data'=>$data
            ]);
        
        // return redirect()->back()->with('success','Updated successfully');
    }
    
    public function destroy($id){
        
        $user = Auth::user()->id;
        
        $company = DetailCompany::where('id_user', $user)->first();
        
        if($company->certificate_expired_date > date('Y-m-d')){
            
            $data = new TempCompanySegment;
            
            $company_segment = CompanySegment::where('id_company_segment', $id)->first();
            
            $data->id_user = $user;
            
            $data->id_company_segment = $id;
            $data->id_segment = $company_segment->id_segment;
            $data->action = "DELETE";
            
            $data->save();
            
        } else {
            
            $data = CompanySegment::where('id_company_segment', $id)->first();
            $data->delete();

        }
            
        return response()->json(['success'=>'Segment deleted successfully']);
        
    }
    
    public function temp_destroy($id){
        
        $data = TempCompanySegment::where('id_temp_company_segment', $id)->first();
        $data->delete();

        return response()->json(['success'=>'Cancel update successfully']);
    }

    
}
