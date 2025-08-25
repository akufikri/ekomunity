<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facedes\Hash;
use Illuminate\Support\Facedes\Validator;
use App\Models\BusinessActivity;
use Redirect;
use Session;
use DB;
use Yajra\DataTables\Facades\DataTables;

class BusinessActivityController extends Controller{
    
    public function index(Request $request){
        if($request->ajax()){
            $data = BusinessActivity::orderBy('id_business_activity', 'asc')->get();
            foreach($data as $d){
                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
            }
            return DataTables::of($data)->addIndexColumn()->make(true);
        }
        return view('admin.settingsBusinessActivity.index');
    }
    
    public function create(Request $request){
        $data = new BusinessActivity;
        
        $data->business_activity = $request->business_activity;
        $data->description = $request->description;
        
        $data->save();
        return redirect()->back()->with('success', 'Created Successfully');
    }
    
    public function edit($id, Request $r)
    {
        $data = BusinessActivity::findOrFail($id);
        
        // $data = Position::where('id_position', $id)->first();
        
        return response()->json([
            'success'=>'Get data successfully',
            'data'=>$data
            ]);
        // return view('admin.settingsPosition.index', compact('data'));
    }
    
    public function update(Request $request, $id)
    {
        $data = BusinessActivity::findOrFail($id);
        $data->business_activity = $request->business_activity;
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
    
    
}