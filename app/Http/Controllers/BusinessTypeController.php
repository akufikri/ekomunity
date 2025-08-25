<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facedes\Hash;
use Illuminate\Support\Facedes\Validator;
use App\Models\BusinessType;
use Redirect;
use Session;
use DB;
use DataTables;

class BusinessTypeController extends Controller{
    
    public function index(Request $request){
        if($request->ajax()){
            $data = BusinessType::orderBy('id_business_type', 'asc')->get();
            foreach($data as $d){
                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        return view('admin.settingsBusinessType.index');
    }
    
    public function create(Request $request){
        $data = new BusinessType;
        
        $data->business_type = $request->business_type;
        $data->description = $request->description;
        
        $data->save();
        return redirect()->back()->with('success', 'Created Successfully');
    }
    
    public function edit($id, Request $r)
    {
        $data = BusinessType::findOrFail($id);
        
        // $data = Position::where('id_position', $id)->first();
        
        return response()->json([
            'success'=>'Get data successfully',
            'data'=>$data
            ]);
        // return view('admin.settingsPosition.index', compact('data'));
    }
    
    public function update(Request $request, $id)
    {
        $data = BusinessType::findOrFail($id);
        $data->business_type = $request->business_type;
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