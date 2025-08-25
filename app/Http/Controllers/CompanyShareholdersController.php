<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CompanyShareHolders;
use App\Models\TempCompanyShareHolders;
use App\Models\DetailCompany;
use DataTables;
use Redirect;
use DB;
use Auth;

class CompanyShareholdersController extends Controller
{
    
    public function index_shareholders(Request $request)
    {
        if ($request->ajax()) {
        
            $user = Auth::user()->id;
        
            $data = CompanyShareHolders::with('position_jabatan','status_native')
            ->where('id_user',$user)
            ->orderBy('id_company_shareholders','desc')
            ->get();
            
            foreach($data as $d){
                
                $company = DetailCompany::where('id_user', $user)->first();
                
                // $d->percentage = (($d->total / $company->paid_up_capital) * 100).'%';
                $d->percentage = number_format((($d->total / $company->paid_up_capital) * 100), 0, ',', '.').'%';
                
                setlocale(LC_MONETARY, 'ms_MY');
                $d->total = 'RM'.number_format(isset($d->total)?$d->total:'');
                
                $d->position_user = isset($d->position_jabatan->position)?$d->position_jabatan->position:'';
                $d->status = isset($d->status_native->status_native)?$d->status_native->status_native:'';
                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
                
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        
        return view('company.viewShareholders');
    }
    
    public function index_shareholders_temp(Request $request)
    {
        if ($request->ajax()) {
        
            $user = Auth::user()->id;
        
            $data = TempCompanyShareHolders::with('position_jabatan','status_native')
            ->where('id_user',$user)
            ->where('id_request_update','0')
            ->orderBy('id_temp_company_shareholders','desc')
            ->get();
            
            foreach($data as $d){
                
                $company = DetailCompany::where('id_user', $user)->first();
                
                // $d->percentage = (($d->total / $company->paid_up_capital) * 100).'%';
                $d->percentage = number_format((($d->total / $company->paid_up_capital) * 100), 0, ',', '.').'%';
                
                setlocale(LC_MONETARY, 'ms_MY');
                $d->total = 'RM'.number_format(isset($d->total)?$d->total:'');
                
                $d->position_user = isset($d->position_jabatan->position)?$d->position_jabatan->position:'';
                $d->status = isset($d->status_native->status_native)?$d->status_native->status_native:'';
                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
                
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        
        return view('company.viewShareholders');
    }
    
    public function index_shareholders_temp_admin(Request $request, $id, $id_request)
    {
        if ($request->ajax()) {
        
            $user = $id;
        
            $data = TempCompanyShareHolders::with('position_jabatan','status_native')
            ->where('id_user',$user)
            ->where('id_request_update', $id_request)
            ->orderBy('id_temp_company_shareholders','desc')
            ->get();
            
            foreach($data as $d){
                
                $company = DetailCompany::where('id_user', $user)->first();
                
                // $d->percentage = (($d->total / $company->paid_up_capital) * 100).'%';
                $d->percentage = number_format((($d->total / $company->paid_up_capital) * 100), 0, ',', '.').'%';
                
                setlocale(LC_MONETARY, 'ms_MY');
                $d->total = 'RM'.number_format(isset($d->total)?$d->total:'');
                
                $d->position_user = isset($d->position_jabatan->position)?$d->position_jabatan->position:'';
                $d->status = isset($d->status_native->status_native)?$d->status_native->status_native:'';
                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
                
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        
        return view('company.viewShareholders');
    }
    
    public function index_shareholders_admin($id, Request $request)
    {
        if ($request->ajax()) {
        
            $user = $id;
        
            $data = CompanyShareHolders::with('position_jabatan','status_native')
            ->where('id_user',$user)
            ->orderBy('id_company_shareholders','desc')
            ->get();
            
            foreach($data as $d){
                
                $company = DetailCompany::where('id_user', $user)->first();
                
                // $d->percentage = (($d->total / $company->paid_up_capital) * 100).'%';
                $d->percentage = number_format((($d->total / $company->paid_up_capital) * 100), 0, ',', '.').'%';
                
                setlocale(LC_MONETARY, 'ms_MY');
                $d->total = 'RM'.number_format(isset($d->total)?$d->total:'');
                
                $d->position_user = isset($d->position_jabatan->position)?$d->position_jabatan->position:'';
                $d->status = isset($d->status_native->status_native)?$d->status_native->status_native:'';
                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
                
                // $d->percentage = "0%";
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        return view('company.viewShareholders');
    }
    
    public function create(Request $request)
    {
    
        $user = Auth::user()->id;
        
        $data_company = DetailCompany::where('id_user', $user)->first();
        
        if($data_company->certificate_expired_date > date('Y-m-d')){
            
            $data = new TempCompanyShareHolders;
            
            $data->action = "CREATE";
            
        } else {
            
            $data = new CompanyShareHolders;
            
        }
        
        $sum_total_share = CompanyShareHolders::where('id_user', $user)->sum('total');
        
        $result = $sum_total_share + $request->total;
        
        if($result <= $data_company->auth_paid_up_capital){
            
            $data->id_user = $user;
            $data->id_position = $request->position;
            $data->id_status = $request->status;
            $data->name = $request->name;
            $data->number_id = $request->number_id;
            $data->total = $request->total;
            
            $data->save();
            
            //Update Paid Up Capital
            $data_company->paid_up_capital = $result;
            $data_company->save();
            
            return redirect()->back()->with('success','Created successfully');
            
            // $d->total = 'RM'.number_format('%i', isset($d->total)?$d->total:'');
            // 'RM'.number_format('%i', )
            
        }else{
            setlocale(LC_MONETARY, 'ms_MY');
            return redirect()->back()->with('failed','Failed, Error exceeding maximum limit of '.'RM'.number_format($data_company->auth_paid_up_capital));
        }
        
    }
    
    public function edit($id, Request $r)
    {
        $data = CompanyShareHolders::findOrFail($id);
        
        return response()->json([
            'success'=>'Get data successfully',
            'data'=>$data
            ]);
        // return view('admin.settingsPosition.index', compact('data'));
    }
    
    public function update(Request $request, $id)
    {
        
        $user = Auth::user()->id;
        
        $data_company = DetailCompany::where('id_user', $user)->first();
        
        if($data_company->certificate_expired_date > date('Y-m-d')){
            
            $data = new TempCompanyShareHolders;
            
            $data->id_user = $user;
            
            $data->id_company_shareholders = $id;
            $data->action = "UPDATE";
            
        } else {
            
            $data = CompanyShareHolders::findOrFail($id);

        }
        
        $sum_total_share = CompanyShareHolders::where('id_user', $user)->where('id_company_shareholders','!=',$id)->sum('total');
        
        $result = $sum_total_share + $request->total;
        
        if($result <= $data_company->auth_paid_up_capital){
        
            $data->id_position = $request->position;
            $data->id_status = $request->status;
            $data->name = $request->name;
            $data->number_id = $request->number_id;
            $data->total = $request->total;
            
            $data->save();
        
            //Update Paid Up Capital
            $sum_total_share_after = CompanyShareHolders::where('id_user', $user)->sum('total');
             $data_company->paid_up_capital = $sum_total_share_after;
             $data_company->save();
        
        return response()->json([
            'newToken' => csrf_token(),
            'success'=>'Update Data Successfully',
            'data'=>$data
            ]);
        
        } else {
            
            return response()->json([
            'success'=>'Failed, Error exceeding maximum limit of '.'RM'.number_format($data_company->auth_paid_up_capital),
            'data'=>$data
            ]);
            
        }
        
        // return redirect()->back()->with('success','Updated successfully');
    }
    
    public function destroy($id){
        
        $user = Auth::user()->id;
        
        $data_company = DetailCompany::where('id_user', $user)->first();
        
        $shareholders = CompanyShareHolders::where('id_company_shareholders', $id)->first();
        
        if($data_company->certificate_expired_date > date('Y-m-d')){
            
            $data = new TempCompanyShareHolders;
            
            $data->id_user = $user;
            $data->id_position = $shareholders->position;
            $data->id_status = $shareholders->status;
            $data->name = $shareholders->name;
            $data->number_id = $shareholders->number_id;
            $data->total = $shareholders->total;
            
            $data->id_company_shareholders = $id;
            $data->action = "DELETE";
            
            $data->save();
            
        } else {
            
            $data = CompanyShareHolders::where('id_company_shareholders', $id)->first();
            $data->delete();
            
            //Update Paid Up Capital
            $sum_total_share_after = CompanyShareHolders::where('id_user', $user)->sum('total');
            $data_company->paid_up_capital = $sum_total_share_after;
            $data_company->save();

        }

        return response()->json(['success'=>'Shareholders deleted successfully']);
    }
    
    public function temp_destroy($id){
        
        $data = TempCompanyShareHolders::where('id_temp_company_shareholders', $id)->first();
        $data->delete();

        return response()->json(['success'=>'Cancel update successfully']);
    }
    
}
