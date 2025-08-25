<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailCompany;
use App\Models\TempDetailCompany;
use App\Models\User;
use App\Models\EquityBreakdown;
use App\Models\CompanyShareHolders;
use DataTables;
use Redirect;
use DB;
use Auth;

class CompanyEquityController extends Controller
{
    public function __constructor(){
        $this->middleware('company');
    }
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = EquityBreakdown::with('user','statusNative')
            ->orderBy('id_company_equity_breakdown','desc')->get();
            foreach($data as $d){
                
                
                $d->create_date = date('d-m-Y h:i:s', strtotime($d->created_at));
            }
            
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        // return view('employee.index');
        // return view('company.settingsPosition.index');
    }
    public function show($id)
    {
        $data = User::findOrFail($id);
        
        setlocale(LC_MONETARY, 'ms_MY');
                
        $data->auth_paid_up_capital = 'RM'.number_format($data->company->auth_paid_up_capital);
        $data->paid_up_capital = 'RM'.number_format($data->company->paid_up_capital);
        
        $user = Auth::user()->id;
            
             $data_bumiputera = CompanyShareHolders::where('id_user', $user)->where('id_status','1')->sum('total');
             $data_non_bumiputera = CompanyShareHolders::where('id_user', $user)->where('id_status','2')->sum('total');
             $data_foreign = CompanyShareHolders::where('id_user', $user)->where('id_status','3')->sum('total');
             
             $company_detail = DetailCompany::where('id_user', $user)->first();
             
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
            
            if($company_detail->paid_up_capital !== null && $data_bumiputera !== null && $data_bumiputera !== 0 && $data_bumiputera !== '0'){
                 $data->percentage_bumiputera = number_format((($data_bumiputera / $company_detail->paid_up_capital) * 100), 0, ',', '.').'%';
             }else{
                 $data->percentage_bumiputera = '0%';
             }
             
             if($company_detail->paid_up_capital !== null && $data_non_bumiputera !== null && $data_non_bumiputera !== 0 && $data_non_bumiputera !== '0'){
                 $data->percentage_non_bumiputera = number_format((($data_non_bumiputera / $company_detail->paid_up_capital) * 100), 0, ',', '.').'%';
             }else{
                 $data->percentage_non_bumiputera = '0%';
             }
             
             if($company_detail->paid_up_capital !== null && $data_foreign !== null && $data_foreign !== 0 && $data_foreign !== '0'){
                 $data->percentage_foreign = number_format((($data_foreign / $company_detail->paid_up_capital) * 100), 0, ',', '.').'%';
             }else{
                 $data->percentage_foreign = '0%';
             }
             
             
            //  $data->percentage_non_bumiputera = number_format((($data_non_bumiputera / $company_detail->paid_up_capital) * 100), 1, ',', '.').'%';
            //  $data->percentage_foreign = number_format((($data_foreign / $company_detail->paid_up_capital) * 100), 1, ',', '.').'%';
             
             
        
             $data_equity_by_status = [
                'bumiputera' => $data_bumiputera,
                'non-bumiputera' => $data_non_bumiputera,
                'foreign' => $data_foreign
                ];
        
            $data->bumiputera = 'RM'.number_format($data_bumiputera);
            $data->non_bumiputera = 'RM'.number_format($data_non_bumiputera);
            $data->foreign = 'RM'.number_format($data_foreign);
        
        return view('company.viewCompanyEquityBreakdown', compact('data'));
    }
    
    public function edit($id)
    {
        $data = User::findOrFail($id);
        return view('company.editCompanyEquityBreakdown', compact('data'));
    }
    
    public function update(Request $request, $id)
    {
        $data = User::findOrFail($id);
        $before = DetailCompany::where('id_user',$data->id)->first();
        
        if($data && ($request->paid_up_capital<=$request->auth_paid_up_capital)){
            
            if($before->certificate_expired_date > date('Y-m-d')){
                
                $man = TempDetailCompany::where('id_user', $data->id)
                ->orderBy('id_temp_detail_company','desc')->first();
                
                if($man === null){
                    $man = new TempDetailCompany;
                    $man->action = "UPDATE";
                    $man->id_detail_company = $before->id_detail_company;
                }
                
            } else {
                $man = DetailCompany::where('id_user',$data->id)->first();
            }
            
            
            $man->id_user = $data->id;
            
            $man->auth_paid_up_capital = $request->auth_paid_up_capital;
            // $man->paid_up_capital = $request->paid_up_capital;
            
            $man->save();
            
            return redirect("companyEquityBreakdown/$id")->with('success_update','Updated successfully');
        } else {
            return redirect("companyEquityBreakdown/$id")->with('failed_update','Paid up capital should not be bigger than Auth paid up capital');
        }
 
    }
    
    public function update_equity(Request $request, $id)
    {
        $user = Auth::user()->id;
        
        $data = EquityBreakdown::findOrFail($id);
        $data->id_status_native = $request->status;
        $data->value_rm = $request->total;

        $data->save();
        
        $sum_total = EquityBreakdown::where('id_user', $user)->sum('value_rm');
        $company = DetailCompany::where('id_user', $user)->first();
        $company->paid_up_capital = $sum_total;
        $company->save();
        
        return response()->json([
            'newToken' => csrf_token(),
            'success'=>'Update Data Successfully',
            'data'=>$data
            ]);
        
        return redirect()->back()->with('success','Updated successfully');
    }
    
    public function edit_list_equity($id, Request $r)
    {
        $data = EquityBreakdown::findOrFail($id);
        
        // $data = Position::where('id_position', $id)->first();
        
        return response()->json([
            'success'=>'Get data successfully',
            'data'=>$data
            ]);
        // return view('admin.settingsPosition.index', compact('data'));
    }
    
    public function destroy($id){
        
        $user = Auth::user()->id;
        
        $data = EquityBreakdown::where('id_company_equity_breakdown', $id)->first();
        $data->delete();
        
        $sum_total = EquityBreakdown::where('id_user', $user)->sum('value_rm');
        $company = DetailCompany::where('id_user', $user)->first();
        $company->paid_up_capital = $sum_total;
        $company->save();
            
        return response()->json(['success'=>'Company Equity deleted successfully']);
    }
    
    
    public function create(Request $request)
    {
        $user = Auth::user()->id;
        
        $cek_id_status = EquityBreakdown::with('statusNative')->where('id_status_native',$request->status)->first();
        
        if (!$cek_id_status) {
            $data = new EquityBreakdown;
    
            $data->id_user = $user;
            $data->id_status_native = $request->status;
            $data->value_rm = $request->total;
            $data->save();
            
            $sum_total = EquityBreakdown::where('id_user', $user)->sum('value_rm');
            $company = DetailCompany::where('id_user', $user)->first();
            $company->paid_up_capital = $sum_total;
            $company->save();
            
            return redirect()->back()->with('success','Created successfully');
            
        } else {
            
            return redirect()->back()->with('failed','Status '.$cek_id_status->statusNative->status_native.' already exist');
            
        }
    
    }
    
    
    public function index_equity(){
        return view('company.viewCompanyEquityBreakdown');
    }
    public function edit_equity(){
        return view('company.editCompanyEquityBreakdown');
    }
}
