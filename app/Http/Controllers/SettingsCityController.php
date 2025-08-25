<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facedes\Hash;
use Illuminate\Support\Facedes\Validator;
use App\Models\State;
use App\Models\City;
use Redirect;
use Session;
use DB;
use DataTables;

class SettingsCityController extends Controller{
    
    public function index(Request $request){
        if($request->ajax()){
            $data = City::orderBy('id_city', 'desc')->with('state')->get();
            foreach($data as $d){
                $d->state_name = isset($d->state->state)?$d->state->state:'';
                $d->city_name = isset($d->city)?$d->city:'';
                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        return view('admin.settingsCity.index');
    }
    
    public function create(Request $request){
        $data = new City;
        
        $data->id_state = $request->id_state;
        $data->city = $request->city;
        $data->representation = $request->representation;
        $data->association = $request->association;
        $data->description = $request->description;
        $data->description2 = $request->description2;
        $data->phone_number = $request->phone_number;
        $data->latitude = $request->place_latitude;
        $data->longitude = $request->place_longitude;
        
        $data->save();
        return redirect()->back()->with('success', 'Created Successfully');
    }
    
    public function edit($id, Request $r)
    {
        $data = City::findOrFail($id);
        
        // $data = Position::where('id_position', $id)->first();
        
        return response()->json([
            'success'=>'Get data successfully',
            'data'=>$data
            ]);
        // return view('admin.settingsPosition.index', compact('data'));
    }
    
    public function update(Request $request, $id)
    {
        $data = City::findOrFail($id);
        $data->id_state = $request->id_state;
        $data->city = $request->city;
        $data->representation = $request->representation;
        $data->association = $request->association;
        $data->description = $request->description;
        $data->description2 = $request->description2;
        $data->phone_number = $request->phone_number;
        $data->latitude = $request->place_latitude;
        $data->longitude = $request->place_longitude;
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