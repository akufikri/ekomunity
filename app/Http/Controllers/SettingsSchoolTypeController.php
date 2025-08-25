<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\TypeSchool;
use Redirect;
use Session;
use DB;
use DataTables;

class SettingsSchoolTypeController extends Controller{
    
    public function index(Request $request){
        if($request->ajax()){
            $data = TypeSchool::orderby('id_type_school','desc')->get();
            foreach($data as $d){
                $d->create_date = date('d-m-Y h:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        return view('admin.settingsTypeSchool.index');
    }
    
    public function create(Request $request){
        $data = new TypeSchool;
        
        $data->type_school = $request->type_school;
        $data->description = $request->description;
        
        $data->save();
        return redirect()->back()->with('success', 'Created Successfully');
    }
    
    public function show($id)
    {
        $data = TypeSchool::findOrFail($id);

        $html = '<div class="form-group">
                    <label for="Type School">Type School:</label>
                    <input type="text" class="form-control" name="type_school" id="showTypeSchool" disabled value="'.$data->type_school.'">
                </div>
                <div class="form-group">
                    <label for="Description">Description:</label>
                    <input type="text" class="form-control" name="description" id="showDescription" disabled value="'.$data->description.'">                     
                </div>
                <div class="form-group">
                    <label for="Status">Status:</label>
                    <input type="text" class="form-control" name="is_active" id="showStatus" disabled value="'.$data->is_active.'">                     
                </div>';

        return response()->json(['html'=>$html]);
    }
    
    public function edit($id, Request $request){
        $article = new TypeSchool;
        $data = $article->findOrFail($id);

        $html = '<div class="form-group">
                    <label for="Type School">Type School:</label>
                    <input type="text" class="form-control" name="type_school" id="showTypeSchool" value="'.$data->type_school.'">
                </div>
                <div class="form-group">
                    <label for="Description">Description:</label>
                    <input type="text" class="form-control" name="description" id="showDescription" value="'.$data->description.'">                     
                </div>
                <div class="form-group">
                    <label for="Status">Status:</label>
                    <input type="text" class="form-control" name="is_active" id="showStatus" value="'.$data->is_active.'">                     
                </div>';

        return response()->json(['html'=>$html]);
    }
    
    public function update(Request $request, $id){
        $data = TypeSchool::findOrFail($id);
        
        $data->type_school = $request->type_school;
        $data->description = $request->description;
        if($request->status) $data->is_active = $request->status;
        
        $data->save();
        
        return response()->json([
            'newToken' => csrf_token(),
            'success'=>'Update Data Successfully',
            'data'=>$data
            ]);
    }
    
}