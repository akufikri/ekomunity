<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Session;
use DB;
use DataTables;
use App\Models\VendorLicenses;
use App\Models\User;

class SettingsVendorController extends Controller
{
    
    public function index(Request $request){
        if ($request->ajax()) {
            $data = VendorLicenses::orderBy('id_vendor_licenses','desc')->get();
            foreach($data as $d){
                $d->create_date = date('d-m-Y h:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        return view('admin.settingsVendor.index');
    } 
    
    public function create(Request $request)
    {
        $data = new VendorLicenses;
        // $user = Auth::user()->id;
        
        // $data->id_user = $user;
        $data->vendor_licenses = $request->vendor_licenses;
        $data->description = $request->description;
        // $data->is_active = $request->status;
        
        $data->save();
        return redirect()->back()->with('success','Created successfully');
    }
    
    public function update(Request $request, $id)
    {
        $data = VendorLicenses::findOrFail($id);
        $data->vendor_licenses = $request->vendor_licenses;
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
        $data = VendorLicenses::findOrFail($id);
        
        // $data = Position::where('id_position', $id)->first();
        
        return response()->json([
            'success'=>'Get data successfully',
            'data'=>$data
            ]);
        // return view('admin.settingsPosition.index', compact('data'));
    }
    
    
}
