<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\TypeSchool;
use App\Models\School;
use Redirect;
use Session;
use DB;
use DataTables;

class SettingsSchoolController extends Controller{
    
    public function index(Request $request){
        if($request->ajax()){
            $data = School::orderBy('id_school','desc')->with('typeSch')->get();
            foreach($data as $d){
                $d->type_school_name = isset($d->typeSch->type_school)?$d->typeSch->type_school:'';
                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        return view('admin.settingsSchool.index');
    }
    
    public function create(Request $request){
        $data = new School;
        
        $data->id_type_school = $request->id_type_school;
        $data->school = $request->school;
        $data->description = $request->description;
        
        $data->save();
        return redirect()->back()->with('success', 'Created Successfully');
    }
    
    public function update(Request $request, $id)
    {
        $data = School::findOrFail($id);
        $data->id_type_school = $request->id_type_school;
        $data->school = $request->school;
        $data->description = $request->description;
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
        $data = School::findOrFail($id);
        
        // $data = Position::where('id_position', $id)->first();
        
        return response()->json([
            'success'=>'Get data successfully',
            'data'=>$data
            ]);
        // return view('admin.settingsPosition.index', compact('data'));
    }
    
}