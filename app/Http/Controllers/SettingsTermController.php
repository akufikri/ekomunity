<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Session;
use DB;
use Auth;
use Str;
use DataTables;
use App\Models\Term;
use App\Models\User;
use App\Models\Level;
use App\Models\DetailCompany;

class SettingsTermController extends Controller
{
    
    // public function index(Request $request){
    //     $data = Term::get(); 
    //     $data->term_conditions = $request->term_conditions;
    //     // return response()->json([
    //     //     'success'=>'Update data successfully',
    //     //     'data'=>$data
    //     //     ]);
    //     return view('admin.settingsTerm.index');
    // }
    
    public function index(Request $request){
        if ($request->ajax()) {
            $data = Term::orderBy('id_term_conditions','desc')->with('level')->get();
            foreach($data as $d){
                $d->level_name = isset($d->level->level)?$d->level->level:'';
                $d->create_date = date('d-m-Y h:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }

        $level = Level::where('is_active', 'ENABLE')->get();

        return view('admin.settingsTerm.index', compact('level'));
        // return response()->json([
        //     'success'=>'Update data successfully',
        //     'data'=>$data
        //     ]);
    }
    
    public function create(Request $request)
    {
        $data = new Term;
        // $user = Auth::user()->id;
        // $data->id_user = $user;
        $data->id_level = $request->id_level;
        $data->term_conditions = $request->term_conditions;
        $data->is_active = $request->status;
        
        $data->save();
        return redirect()->back()->with('success','Created successfully');
    }
    
    public function update_term(Request $request, $id)
    {
        $data = Term::findOrFail($id);
        $data->id_level = $request->id_level;
        $data->term_conditions = $request->term_conditions;
        $data->is_active = $request->status;
        
        $data->save();
        
        return response()->json([
            'newToken' => csrf_token(),
            'success'=>'Update Data Successfully',
            'data'=>$data
            ]);
        
        // return redirect()->back()->with('success','Updated successfully');
    }
    
    public function edit($id, Request $r)
    {
        $data = Term::findOrFail($id);
        $data->level_name= $data->level->level?$data->level->level:'';
        $data->level->level?$data->level->level:'';
        // $data = Position::where('id_position', $id)->first();
        
        return response()->json([
            'success'=>'Get data successfully',
            'data'=>$data
            ]);
        // return view('admin.settingsPosition.index', compact('data'));
    }

    public function indexTermsConditionsPersatuan(Request $request){

        $auth = Auth::user();

        if ($request->ajax()) {

            $data = DetailCompany::where('id_user', $auth->id)->get();

            foreach($data as $d){
                $d->create_date = date('d-m-Y h:i:s', strtotime($d->created_at));
            }

            return Datatables::of($data)->addIndexColumn()->make(true);
        }

        // $data = DetailCompany::where('id_user', $auth->id)->get();

        // return $data;
        return view('company.settingsTermsConditions.index');
    } 

    public function updatePersatuan(Request $request, $id)
    {
        
        $data = DetailCompany::findOrFail($id);
        
        $data->sign_name = $request->sign_name;
        $data->sign_position = $request->sign_position;
        $data->joining_fee = $request->joining_fee;
        $data->tnc = $request->tnc;

        if($request->hasFile('img2')){
            $file = $request->file('img2');
            $n = $file->getClientOriginalName();
            $randomString = Str::random(10);
            $name = "$n$randomString";
            $file->move(public_path().'/SettingsCertificate',$name);
            $photo2 = $name;
        }else{
            $photo2 = $data->logo_2;
        }
        
        $data->logo_2 = $photo2;

        if($request->hasFile('img3')){
            $file = $request->file('img3');
            $n = $file->getClientOriginalName();
            $randomString = Str::random(10);
            $name = "$n$randomString";
            $file->move(public_path().'/SettingsCertificate',$name);
            $photo3 = $name;
        }else{
            $photo3 = $data->sign_picture;
        }
        
        $data->sign_picture = $photo3;

        $data->save();
        
        return response()->json([
            'newToken' => csrf_token(),
            'success'=> 'Update data successfully',
            'data'=>$data
            ]);
    }
    
}
