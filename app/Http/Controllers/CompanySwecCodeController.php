<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailCompany;
use App\Models\CompanySwecCode;
use App\Models\TempCompanySwecCode;
use App\Models\User;
use App\Models\Segment;
use App\Models\SpecificWork;
use App\Models\SubSpecificWork;
use DataTables;
use Redirect;
use DB;
use Auth;

class CompanySwecCodeController extends Controller
{
    public function __constructor(){
        $this->middleware('company');
    }
    
    public function index(Request $request){
        
        if ($request->ajax()) {
            
            $user = Auth::user()->id;
            
            $data = CompanySwecCode::with('user','specific_work','sub_work_category','work_category','sub_specific_work')
            ->where('id_user', $user)
            ->orderBy('id_swec_company','desc')->get();
            
            foreach($data as $d){
                
                $d->code_1 = isset($d->work_category->code)?$d->work_category->code:'';

                $d->code_2 = isset($d->sub_work_category->code)?$d->sub_work_category->code:'';

                $d->code_3 = isset($d->specific_work->code)?$d->specific_work->code:'';
                
                $d->code_4 = isset($d->sub_specific_work->code)?$d->sub_specific_work->code:'';

                $d->service = isset($d->sub_specific_work->sub_specific_work)?$d->sub_specific_work->sub_specific_work:'';
                // $d->service = "HAHAHA";
                
                $d->code = $d->code_1.''.$d->code_2.''.$d->code_3.''.$d->code_4;

                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
                
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
            
        }

        $data_code = SubSpecificWork::with('sub_work_category','work_category','specific_work')
        ->orderBy('id_swec_sub_specific_work','desc')->get();
        
        foreach($data_code as $d){
                
                $d->code_1 = isset($d->work_category->code)?$d->work_category->code:'';
                $d->id_code_1 = isset($d->work_category->id_swec_work_category)?$d->work_category->id_swec_work_category:'';
                
                $d->code_2 = isset($d->sub_work_category->code)?$d->sub_work_category->code:'';
                $d->id_code_2 = isset($d->sub_work_category->id_swec_sub_work_category)?$d->sub_work_category->id_swec_sub_work_category:'';
                
                $d->code_3 = isset($d->specific_work->code)?$d->specific_work->code:'';
                $d->id_code_3 = isset($d->specific_work->id_swec_specific_work)?$d->specific_work->id_swec_specific_work:'';
                
                $d->code_4 = isset($d->code)?$d->code:'';
                $d->id_code_4 = isset($d->id_swec_sub_specific_work)?$d->id_swec_sub_specific_work:'';

                $d->code = $d->code_1.''.$d->code_2.''.$d->code_3.''.$d->code_4;
                $d->id_code = $d->id_code_1.','.$d->id_code_2.','.$d->id_code_3.','.$d->id_code_4;
                
                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
                
            }

        return view('company.viewSwecCode', compact('data_code'));
        
        
    }
    
    // public function index(Request $request){
        
    //     if ($request->ajax()) {
            
    //         $user = Auth::user()->id;
            
    //         $data = CompanySwecCode::with('user','specific_work','sub_work_category','work_category')
    //         ->where('id_user', $user)
    //         ->orderBy('id_swec_company','desc')->get();
            
    //         foreach($data as $d){
                
    //             $d->code_1 = isset($d->work_category->code)?$d->work_category->code:'';

    //             $d->code_2 = isset($d->sub_work_category->code)?$d->sub_work_category->code:'';

    //             $d->code_3 = isset($d->specific_work->code)?$d->specific_work->code:'';

    //             $d->service = isset($d->specific_work->specific_work)?$d->specific_work->specific_work:'';
                
    //             $d->code = $d->code_1.''.$d->code_2.''.$d->code_3.'00';

    //             $d->create_date = date('d-m-Y h:i:s', strtotime($d->created_at));
                
    //         }
    //         return Datatables::of($data)->addIndexColumn()->make(true);
            
    //     }

    //     $data_code = SpecificWork::with('sub_work_category','work_category')
    //     ->orderBy('id_swec_specific_work','desc')->get();
        
    //     foreach($data_code as $d){
                
    //             $d->code_1 = isset($d->work_category->code)?$d->work_category->code:'';
    //             $d->id_code_1 = isset($d->work_category->id_swec_work_category)?$d->work_category->id_swec_work_category:'';
                
    //             $d->code_2 = isset($d->sub_work_category->code)?$d->sub_work_category->code:'';
    //             $d->id_code_2 = isset($d->sub_work_category->id_swec_sub_work_category)?$d->sub_work_category->id_swec_sub_work_category:'';
                
    //             $d->code_3 = isset($d->code)?$d->code:'';
    //             $d->id_code_3 = isset($d->id_swec_specific_work)?$d->id_swec_specific_work:'';
                

    //             $d->code = $d->code_1.''.$d->code_2.''.$d->code_3.'00';
    //             $d->id_code = $d->id_code_1.','.$d->id_code_2.','.$d->id_code_3.',00';
                
    //             $d->create_date = date('d-m-Y h:i:s', strtotime($d->created_at));
                
    //         }

    //     return view('company.viewSwecCode', compact('data_code'));
        
        
    // }
    
    public function index_temp(Request $request){
        
        if ($request->ajax()) {
            
            $user = Auth::user()->id;
            
            $data = TempCompanySwecCode::with('user','specific_work','sub_work_category','work_category','sub_specific_work')
            ->where('id_user', $user)
            ->orderBy('id_swec_company','desc')->get();
            
            foreach($data as $d){
                
                $d->code_1 = isset($d->work_category->code)?$d->work_category->code:'';

                $d->code_2 = isset($d->sub_work_category->code)?$d->sub_work_category->code:'';

                $d->code_3 = isset($d->specific_work->code)?$d->specific_work->code:'';
                
                $d->code_4 = isset($d->sub_specific_work->code)?$d->sub_specific_work->code:'';

                $d->service = isset($d->sub_specific_work->sub_specific_work)?$d->sub_specific_work->sub_specific_work:'';
                // $d->service = "HAHAHA";
                
                $d->code = $d->code_1.''.$d->code_2.''.$d->code_3.''.$d->code_4;

                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
                
            }
            
            // return response($data);
            
            return Datatables::of($data)->addIndexColumn()->make(true);
            
        }
        
    }
    
    public function index_admin($id, Request $request){
        
        // $sw = array();
        
        if ($request->ajax()) {
            
            $user = $id;
            
            $data = CompanySwecCode::with('user','specific_work','sub_work_category','work_category','specific_work')
            ->where('id_user', $user)
            ->orderBy('id_swec_company','desc')->get();
            
            foreach($data as $d){
                
                $d->code_1 = isset($d->work_category->code)?$d->work_category->code:'';

                $d->code_2 = isset($d->sub_work_category->code)?$d->sub_work_category->code:'';

                $d->code_3 = isset($d->specific_work->code)?$d->specific_work->code:'';
                
                $d->code_4 = isset($d->sub_specific_work->code)?$d->sub_specific_work->code:'';

                $d->service = isset($d->sub_specific_work->sub_specific_work)?$d->sub_specific_work->sub_specific_work:'';
                
                $d->code = $d->code_1.''.$d->code_2.''.$d->code_3.''.$d->code_4;

                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
                
                // $sw[$d] = $d->code;
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
            
        }

        // $data_code = SpecificWork::with('sub_work_category','work_category')
        // ->orderBy('id_swec_specific_work','desc')->get();
        
        // foreach($data_code as $d){
                
        //         $d->code_1 = isset($d->work_category->code)?$d->work_category->code:'';
        //         $d->id_code_1 = isset($d->work_category->id_swec_work_category)?$d->work_category->id_swec_work_category:'';
                
        //         $d->code_2 = isset($d->sub_work_category->code)?$d->sub_work_category->code:'';
        //         $d->id_code_2 = isset($d->sub_work_category->id_swec_sub_work_category)?$d->sub_work_category->id_swec_sub_work_category:'';
                
        //         $d->code_3 = isset($d->code)?$d->code:'';
        //         $d->id_code_3 = isset($d->id_swec_specific_work)?$d->id_swec_specific_work:'';
                
        //         // $d->service = isset($d->specific_work->specific_work)?$d->specific_work->specific_work:'';
                
        //         $d->code = $d->code_1.''.$d->code_2.''.$d->code_3.'00';
        //         $d->id_code = $d->id_code_1.','.$d->id_code_2.','.$d->id_code_3.',00';
                
        //         $d->create_date = date('d-m-Y h:i:s', strtotime($d->created_at));
                
        //         // $sw[$d] = $d->code;
        //     }
        
        // // $sw = \App\Models\SpecificWork::get();
        // // $sw = array();
        // return view('company.viewSwecCode', compact('data_code'));
        
        
    }
    
    public function index_temp_admin(Request $request, $id, $id_request){
        
        if ($request->ajax()) {
            
            $user = $id;
            
            $data = TempCompanySwecCode::with('user','specific_work','sub_work_category','work_category','sub_specific_work')
            ->where('id_user', $user)
            ->where('id_request_update', $id_request)
            ->orderBy('id_temp_swec_company','desc')->get();
            
            foreach($data as $d){
                
                $d->code_1 = isset($d->work_category->code)?$d->work_category->code:'';

                $d->code_2 = isset($d->sub_work_category->code)?$d->sub_work_category->code:'';

                $d->code_3 = isset($d->specific_work->code)?$d->specific_work->code:'';
                
                $d->code_4 = isset($d->sub_specific_work->code)?$d->sub_specific_work->code:'';

                $d->service = isset($d->sub_specific_work->sub_specific_work)?$d->sub_specific_work->sub_specific_work:'';
                
                $d->code = $d->code_1.''.$d->code_2.''.$d->code_3.''.$d->code_4;

                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
                
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
            
        }

        // $data_code = SpecificWork::with('sub_work_category','work_category')
        // ->orderBy('id_swec_specific_work','desc')->get();
        
        // foreach($data_code as $d){
                
        //         $d->code_1 = isset($d->work_category->code)?$d->work_category->code:'';
        //         $d->id_code_1 = isset($d->work_category->id_swec_work_category)?$d->work_category->id_swec_work_category:'';
                
        //         $d->code_2 = isset($d->sub_work_category->code)?$d->sub_work_category->code:'';
        //         $d->id_code_2 = isset($d->sub_work_category->id_swec_sub_work_category)?$d->sub_work_category->id_swec_sub_work_category:'';
                
        //         $d->code_3 = isset($d->code)?$d->code:'';
        //         $d->id_code_3 = isset($d->id_swec_specific_work)?$d->id_swec_specific_work:'';
                

        //         $d->code = $d->code_1.''.$d->code_2.''.$d->code_3.'00';
        //         $d->id_code = $d->id_code_1.','.$d->id_code_2.','.$d->id_code_3.',00';
                
        //         $d->create_date = date('d-m-Y h:i:s', strtotime($d->created_at));
                
        //     }

        // return view('company.viewSwecCode', compact('data_code'));
        
    }

    public function create(Request $request)
    {
    
        $user = Auth::user()->id;
        
        $company = DetailCompany::where('id_user', $user)->first();
        
        if($company->certificate_expired_date > date('Y-m-d')){
            
            $data = new TempCompanySwecCode;
            
            $data->action = "CREATE";
            
        } else {
            
            $data = new CompanySwecCode;
            
        }
    
        $get_code = explode(",",$request->swec_code);
        
        $data->id_user = $user;
        $data->id_work_category = $get_code[0];
        $data->id_sub_work_category = $get_code[1];
        $data->id_specific_work = $get_code[2];
        $data->id_sub_specific_work = $get_code[3];
        
        $data->save();
        return redirect()->back()->with('success','Created successfully');
        
    }
    
    public function destroy($id){
        
        $user = Auth::user()->id;
        
        $company = DetailCompany::where('id_user', $user)->first();
        
        $swec_code = CompanySwecCode::where('id_swec_company', $id)->first();
        
        if($company->certificate_expired_date > date('Y-m-d')){
        
            $data = new TempCompanySwecCode;
            $data->id_user = $user;
            $data->id_swec_company = $id;
            $data->action = "DELETE";
            $data->id_work_category = $swec_code->id_work_category;
            $data->id_sub_work_category = $swec_code->id_sub_work_category;
            $data->id_specific_work = $swec_code->id_specific_work;
            
            $data->save();
            
        } else {
            
            $data = CompanySwecCode::where('id_swec_company', $id)->first();
            $data->delete();
            
        }
        
        return response()->json(['success'=>'SWEC Code deleted successfully']);
    }
    
    public function temp_destroy($id){
        
        $data = TempCompanySwecCode::where('id_temp_swec_company', $id)->first();
        $data->delete();

        return response()->json(['success'=>'Cancel update successfully']);
    }

    
}
