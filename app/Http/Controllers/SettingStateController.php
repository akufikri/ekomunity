<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\State;
use App\Models\Country;
use Redirect;
use Session;
use DB;
use DataTables;

class SettingStateController extends Controller
{

    public function index(Request $request){
        if ($request->ajax()) {
            $data = State::orderBy('id_state','desc')->with('country')->get();
            foreach($data as $d){
                $d->country_name = isset($d->country->country_name)?$d->country->country_name:'';
                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
            // return response()->json([
            // 'success'=>'Update data successfully',
            // 'data'=>$data
            // ]);
        }
      
        return view('admin.settingsState.index');
    }
    
    public function create(Request $request)
    {
        $data = new State;
        // $user = Auth::user()->id;
        
        // $data->id_user = $user;
        $data->id_country = $request->id_country;
        $data->local_code = $request->local_code;
        $data->state = $request->state;
        $data->description = $request->description;
        // $data->is_active = $request->status;
        
        $data->save();
        return redirect()->back()->with('success','Created successfully');
    }
    
    public function update(Request $request, $id)
    {
        $data = State::findOrFail($id);
        $data->id_country = $request->country;
        $data->local_code = $request->local_code;
        $data->state = $request->state;
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
        $data = State::findOrFail($id);
        
        // $data = Position::where('id_position', $id)->first();
        
        return response()->json([
            'success'=>'Get data successfully',
            'data'=>$data
            ]);
        // return view('admin.settingsPosition.index', compact('data'));
    }
    
    // public function destroy($id){
    //     $data = Position::where('id_position', $id)->first();
    //     $data->delete();
            
    //     return response()->json(['success'=>'Position deleted successfully']);
    // }
    
    // public function show($id)
    // {
    //     // $data = User::findOrFail($id);
    //     // return view('admin.settingsPosition', compact('data'));
    // }
    
    // // public function edit($id)
    // // {
    // //     $data = User::findOrFail($id);
    // //     return view('employee.editPersonalDetail', compact('data'));
    // // }
    

    
    // public function edit_employment(){
    //     return view('employee.editEmploymentDetail');
    // }
    
    // public function index_summary(){
    //     return view('employee.viewSummaryQualification');
    // }
    
    // public function index_other(){
    //     return view('employee.viewOtherQualification');
    // }
    
}
