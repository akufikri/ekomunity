<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Session;
use DB;
use DataTables;
use App\Models\Qualification;
use App\Models\User;

class SettingsQualificationController extends Controller
{

    public function index(Request $request){
        
        if ($request->ajax()) {
            $data = Qualification::orderBy('id_qualification','desc')->get();
            foreach($data as $d){
                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        
        return view('admin.settingsQualification.index');
    }
    
    
    public function create(Request $request){
        
        $data = new Qualification;
        //$user = Auth::user()->id;
        
        //$data->id_user = $user;
        $data->qualification = $request->qualification;
        $data->description = $request->description;
        // $data->is_active = $request->status;
        
        $data->save();
        return redirect()->back()->with('success', 'Created Successfully');
        
    }
    
    public function update_qualification(Request $request, $id){
        $data = Qualification::findOrFail($id);
        $data->qualification = $request->qualification;
        $data->description = $request->description;
        $data->is_active = $request->status;
        
        $data->save();
        
        return response()->json([
            'newToken' => csrf_token(),
            'success'=>'Update data successfully',
            'data'=> $data
            ]);
        // return redirect()->back()->with('success', 'Created Successfully');
    }
    
    public function edit($id, Request $r)
    {
        $data = Qualification::findOrFail($id);
        
        // $data = Position::where('id_position', $id)->first();
        
        return response()->json([
            'success'=>'Get data successfully',
            'data'=>$data
            ]);
        // return view('admin.settingsPosition.index', compact('data'));
    }
    
    
    
    
}
