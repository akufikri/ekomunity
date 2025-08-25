<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Session;
use DB;
use DataTables;
use App\Models\Country;

class SettingsCountryController extends Controller
{

    public function index(Request $request){
        if ($request->ajax()) {
            $data = Country::orderBy('id_country','desc')->get();
            foreach($data as $d){
                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
      
        return view('admin.settingsCountry.index');
    }
    
    public function create(Request $request)
    {
        $data = new Country;
        // $user = Auth::user()->id;
        
        // $data->id_user = $user;
        $data->country_name = $request->country_name;
        $data->country_code = $request->country_code;
        $data->description = $request ->description;
        // $data->is_active = $request->status;
        
        $data->save();
        return redirect()->back()->with('success','Created successfully');
    }
    
    public function update_country(Request $request, $id){
        $data = Country::findOrFail($id);
        // $data = Country::where('id_country', $id)->first();
        $data->country_name = $request->country_name;
        $data->country_code = $request->country_code;
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
        $data = Country::findOrFail($id);
        
        return response()->json([
            'success'=>'Get Data Successfully',
            'data'=>$data
            ]);
    }
    
    // public function update(Request $request, $id)
    // {
    //     $data = Position::findOrFail($id);
    //     $data->position = $request->position;
    //     $data->description = $request->description;
    //     $data->is_active = $request->status;
        
    //     $data->save();
        
    //     return response()->json([
    //         'success'=>'Update data successfully',
    //         'data'=>$data
    //         ]);
        
    //     // return redirect()->back()->with('success','Updated successfully');
    // }
    
    // public function edit($id, Request $r)
    // {
    //     $data = Position::findOrFail($id);
        
    //     // $data = Position::where('id_position', $id)->first();
        
    //     return response()->json([
    //         'success'=>'Get data successfully',
    //         'data'=>$data
    //         ]);
    //     // return view('admin.settingsPosition.index', compact('data'));
    // }
    
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
