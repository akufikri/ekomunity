<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facedes\Hash;
use Illuminate\Support\Facedes\Validator;
use App\Models\SubBusinessActivity;
use Redirect;
use Session;
use DB;
use DataTables;

class SubBusinessActivityController extends Controller{
    
    public function index(Request $request){
        if($request->ajax()){
            $data = SubBusinessActivity::orderBy('id_sub_business_activity', 'desc')->get();
            foreach($data as $d){
                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        return view('admin.settingsSubBusinessActivity.index');
    }
    
    public function create(Request $request){
        $data = new SubBusinessActivity;
        
        $data->sub_business_activity = $request->sub_business_activity;
        $data->description = $request->description;
        
        $data->save();
        return redirect()->back()->with('success', 'Created Successfully');
    }
    
    public function edit($id, Request $r)
    {
        $data = SubBusinessActivity::findOrFail($id);
        
        // $data = Position::where('id_position', $id)->first();
        
        return response()->json([
            'success'=>'Get data successfully',
            'data'=>$data
            ]);
        // return view('admin.settingsPosition.index', compact('data'));
    }
    
    public function update(Request $request, $id)
    {
        $data = SubBusinessActivity::findOrFail($id);
        $data->sub_business_activity = $request->sub_business_activity;
        $data->description = $request->description;
        $data->is_active = $request->status;
        
        $data->save();
        
        return response()->json([
            'newToken' => csrf_token(),
            'success'=>'Update data successfully',
            'data'=>$data
            ]);
        
        // return redirect()->back()->with('success','Updated successfully');
    }
    
}