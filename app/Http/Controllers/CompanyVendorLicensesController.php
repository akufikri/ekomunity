<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailCompany;
use App\Models\CompanySegment;
use App\Models\User;
use App\Models\CompanyVendorLicenses;
use App\Models\TempCompanyVendorLicenses;
use App\Models\VendorLicenses;
use App\Models\Segment;
use DataTables;
use Redirect;
use DB;
use Auth;

class CompanyVendorLicensesController extends Controller
{
    public function __constructor(){
        $this->middleware('company');
    }
    
    public function index_vendor_licenses(Request $request){
        
        if ($request->ajax()) {
            
            $user = Auth::user()->id;
            
            $data = CompanyVendorLicenses::with('company_license')
            ->where('id_user', $user)
            ->orderBy('id_company_vendor_licenses','desc')->get();
            
            foreach($data as $d){
                $d->licenses = isset($d->company_license->vendor_licenses)?$d->company_license->vendor_licenses:'';
                $d->issued_date = date('d-m-Y', strtotime($d->issued_date));
                $d->expire_date = date('d-m-Y', strtotime($d->expire_date));
                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        // return view('employee.index');
        // return view('admin.settingsPosition.index');
        return view('company.viewCompanyVendorLicenses');
        
    }
    
    // public function index_admin_vendor($id, Request $request){
        
    //     if ($request->ajax()) {
            
    //         $user = $id;
            
    //         $data = CompanyVendorLicenses::with('company_license')
    //         ->where('id_user', $user)
    //         ->orderBy('id_company_vendor_licenses','desc')->get();
            
    //         foreach($data as $d){
    //             $d->licenses = isset($d->company_license->vendor_licenses)?$d->company_license->vendor_licenses:'';
    //             $d->issued_date = date('d-m-Y', strtotime($d->issued_date));
    //             $d->expire_date = date('d-m-Y', strtotime($d->expire_date));
    //             $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
    //         }
    //         return Datatables::of($data)->addIndexColumn()->make(true);
    //     }
    //     // return view('employee.index');
    //     // return view('admin.settingsPosition.index');
    //     return view('company.viewCompanyVendorLicenses');
    // }
    
    public function index_vendor_licenses_temp(Request $request){
    
        if ($request->ajax()) {
            
            $user = Auth::user()->id;
            
            $data = TempCompanyVendorLicenses::with('company_license')
            ->where('id_user', $user)
            ->where('id_request_update','0')
            ->orderBy('id_temp_company_vendor_licenses','desc')->get();
            
            foreach($data as $d){
                $d->licenses = isset($d->company_license->vendor_licenses)?$d->company_license->vendor_licenses:'';
                $d->issued_date = date('d-m-Y', strtotime($d->issued_date));
                $d->expire_date = date('d-m-Y', strtotime($d->expire_date));
                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }

        return view('company.viewCompanyVendorLicenses');
        
    }

    
    public function index_vendor_licenses_admin($id, Request $request){
        
        if ($request->ajax()) {
            
            $user = $id;
            
            $data = CompanyVendorLicenses::with('company_license')
            ->where('id_user', $user)
            ->orderBy('id_company_vendor_licenses','desc')->get();
            
            foreach($data as $d){
                $d->licenses = isset($d->company_license->vendor_licenses)?$d->company_license->vendor_licenses:'';
                $d->issued_date = date('d-m-Y', strtotime($d->issued_date));
                $d->expire_date = date('d-m-Y', strtotime($d->expire_date));
                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        // return view('employee.index');
        // return view('admin.settingsPosition.index');
        return view('company.viewCompanyVendorLicenses');
        
    }
    
    public function create(Request $request)
    {
        
        $user = Auth::user()->id;
        
        $company = DetailCompany::where('id_user', $user)->first();
        
        if($company->certificate_expired_date > date('Y-m-d')){
            
            $data = new TempCompanyVendorLicenses;
            
            $data->action = "CREATE";
            
        } else {
            
            $data = new CompanyVendorLicenses;
            
        }
        
        $data->id_user = $user;
        $data->id_vendor_licenses = $request->vendor_licenses_add;
        
        if($request->vendor_licenses_add === '0'){
            $data->others = $request->others_vendor_licenses_add;
        } else{
            $vendor_licenses = VendorLicenses::where('id_vendor_licenses',$request->vendor_licenses_add)->first();
            $data->others = $vendor_licenses->vendor_licenses;
        }
        
        $data->issued_date = $request->issued_date;
        $data->expire_date = $request->expire_date;
        
        if($request->hasFile('licenses_file')){
                $file = $request->file('licenses_file');
                $n = "License-" . md5(time()) . '.' .$file->getClientOriginalExtension();
                $name = "$n";
                $file->move(public_path().'/CompanyLicenses',$name);
                $file1 = $name;
        }else{
            $file1 = $data->licenses_file;
        }
        
        $data->licenses_file = $file1;
        
        $data->save();
        return redirect()->back()->with('success','Created successfully');
        
    }
    
    public function edit($id, Request $r)
    {
        $data = CompanyVendorLicenses::with('company_license')->findOrFail($id);
    
        
        return response()->json([
            'success'=>'Get data successfully',
            'data'=>$data
            ]);
        // return view('admin.settingsPosition.index', compact('data'));
    }
    
    public function update_data(Request $request)
    {
        $user = Auth::user()->id;
        
        $company = DetailCompany::where('id_user', $user)->first();
        
        if($company->certificate_expired_date > date('Y-m-d')){
            
            $data = new TempCompanyVendorLicenses;
            
            $data->id_user = $user;
            
            $data_before = CompanyVendorLicenses::where('id_company_vendor_licenses', $request->id)->first();
            
            $data->id_company_vendor_licenses = $request->id;
            $data->action = "UPDATE";
            
            if($request->hasFile('licenses_file')){
                $file = $request->file('licenses_file');
                $n = "License-" . md5(time()) . '.' .$file->getClientOriginalExtension();
                $name = "$n";
                $file->move(public_path().'/CompanyLicenses',$name);
                $file1 = $name;
            }else{
                $file1 = $data_before->licenses_file;
            }
            
            $data->licenses_file = $file1;
            
        } else {
            
            $data = CompanyVendorLicenses::where('id_company_vendor_licenses', $request->id)->first();
            
            if($request->hasFile('licenses_file')){
                $file = $request->file('licenses_file');
                $n = "License-" . md5(time()) . '.' .$file->getClientOriginalExtension();
                $name = "$n";
                $file->move(public_path().'/CompanyLicenses',$name);
                $file1 = $name;
            }else{
                $file1 = $data->licenses_file;
            }
            
            $data->licenses_file = $file1;
            
        }
        
        $data->id_vendor_licenses = $request->vendor_licenses_update;
        
        if($request->vendor_licenses_update === '0'){
            $data->others = $request->others_vendor_licenses_update;
        } else{
            $vendor_licenses = VendorLicenses::where('id_vendor_licenses', $request->vendor_licenses_update)->first();
            $data->others = $vendor_licenses->vendor_licenses;
        }
        
        $data->issued_date = $request->issued_date;
        $data->expire_date = $request->expire_date;
        
        $data->save();
        
        // return response()->json([
        //     'success'=>'Update data successfully',
        //     'data'=>$data
        //     ]);
        
        return redirect()->back()->with('success','Updated successfully');
    }
    
    public function destroy($id){
        
        $user = Auth::user()->id;
        
        $data_company = DetailCompany::where('id_user', $user)->first();
        
        $company_vendor_licenses = CompanyVendorLicenses::where('id_company_vendor_licenses', $id)->first();
        
        if($data_company->certificate_expired_date > date('Y-m-d')){
            
            $data = new TempCompanyVendorLicenses;
            
            $data->id_user = $user;
            
            $data->id_company_vendor_licenses = $id;
            $data->id_user= $company_vendor_licenses->id_user;
            $data->id_vendor_licenses= $company_vendor_licenses->id_vendor_licenses;
            $data->others= $company_vendor_licenses->others;
            $data->issued_date= $company_vendor_licenses->issued_date;
            $data->expire_date= $company_vendor_licenses->expire_date;
            $data->licenses_file= $company_vendor_licenses->licenses_file;
            $data->action = "DELETE";
            
            $data->save();
            
        } else {
            
            $data = CompanyVendorLicenses::where('id_company_vendor_licenses', $id)->first();
            $data->delete();
            
            //Update Paid Up Capital
            $sum_total_share_after = CompanyShareHolders::where('id_user', $user)->sum('total');
            $data_company->paid_up_capital = $sum_total_share_after;
            $data_company->save();

        }

        return response()->json(['success'=>'Segment deleted successfully']);
    }
    
    public function temp_destroy($id){
        
        $data = TempCompanyVendorLicenses::where('id_temp_company_vendor_licenses', $id)->first();
        $data->delete();

        return response()->json(['success'=>'Cancel update successfully']);
    }

    
}
