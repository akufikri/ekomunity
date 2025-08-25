<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Session;
use DB;
use App\Models\SettingSubscribe;
use App\Models\User;
use App\Models\State;
use App\Models\DetailCompany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class SettingsSubscribeController extends Controller
{
    public function index(Request $request){
        $auth = Auth::user();
        if ($request->ajax()) {

            $data = SettingSubscribe::orderBy('id_setting_subscribe','desc');

            $data = $data->get();

            foreach($data as $d){
                $d->create_date = date('d-m-Y h:i:s', strtotime($d->created_at));
            }
            return DataTables::of($data)->addIndexColumn()->make(true);
        }
        return view('admin.settingsSubscribe.index');
    }   
    
    public function update(Request $request, $id)
    {
        
        $data = SettingSubscribe::findOrFail($id);
        
        $data->price = $request->price;
        $data->collection_id = $request->collection_id;
        $data->price_pusat = $request->price_pusat;
        $data->price_cawangan = $request->price_cawangan;
        $data->price_ketua_bahagian = $request->price_ketua_bahagian;
        $data->secret_key = $request->secret_key;

        $data->save();
        
        return response()->json([
            'newToken' => csrf_token(),
            'success'=> 'Update data successfully',
            'data'=>$data
            ]);
    }
    
    public function show($id)
    {
        $data = SettingSubscribe::findOrFail($id);
        return response()->json(['data'=>$data]);
    }
    
    public function edit(Request $request, $id)
    {
        $data = SettingSubscribe::where('id_setting_subscribe', $id)->first();

        return response()->json(['data'=>$data]);

        // return response()->json(['html'=>$html]);

    }

}