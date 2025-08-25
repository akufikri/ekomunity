<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Session;
use DB;
use DataTables;
use App\Models\Religion;

class SettingsReligionController extends Controller
{

    public function index(Request $request){
        if ($request->ajax()) {
            $data = Religion::orderBy('id_religion','desc')->get();
            foreach($data as $d){
                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
      
        return view('admin.settingsReligion.index');
    }
    
    public function create(Request $request)
    {
        $data = new Religion;        
        $data->religion = $request->religion;
        $data->description = $request ->description;
        
        $data->save();
        return redirect()->back()->with('success','Created successfully');
    }
    
    public function update_religion(Request $request, $id){
        $data = Religion::findOrFail($id);
        $data->religion = $request->religion;
        $data->description = $request->description;
        $data->is_active = $request->status;
        
        $data->save();
        return response()->json([
            'newToken' => csrf_token(),
            'success'=>'Update Data Successfully',
            'data'=>$data
            ]);
    }
    
    public function edit($id, Request $r){
        $data = Religion::findOrFail($id);
        
        return response()->json([
            'success'=>'Get Data Successfully',
            'data'=>$data
            ]);
    }
    
}
