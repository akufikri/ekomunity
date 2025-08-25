<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DunImport;
use App\Exports\DunExport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Session;
use DB;
use DataTables;
use App\Models\Dun;
use App\Models\State;
use App\Models\Parliament;
use Auth;

class SettingsDunController extends Controller
{

    
    public function index(Request $request){

        $auth = Auth::user();

        if ($request->ajax()) {
            $data = Dun::orderBy('id','desc');

            if($auth->id_level == 6){
                $data = $data->where('id_state', $auth->id_state);
            }

            $data = $data->get();

            foreach($data as $d){
                $d->state = State::where('id_state', $d->id_state)->first()->state;
                $d->parliament = Parliament::where('id', $d->id_parliament)->first()->parliament;
                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }

        $state = State::where('is_active', 'ENABLE')->get();   
        $parliament = Parliament::where('is_active', 'ENABLE')->get();   
      
        return view('admin.settingsDun.index', compact('state', 'parliament'));
    }
    
    public function create(Request $request)
    {
        $code = $request->code;

        $cek_code = Dun::where('code', $code)->first();

        if($cek_code){
            return redirect()->back()->with('warning','WARNING! Code DUN sudah digunakan, sila ganti Code lain');
        }

        $data = new Dun;        
        $data->id_state = $request->id_state;
        $data->id_parliament = $request->id_parliament;
        $data->code = $code;
        $data->dun = $request->dun;
        $data->description = $request ->description;
        $data->save();
        return redirect()->back()->with('success','Created successfully');
    }
    
    public function update_dun(Request $request, $id){
       
        $code = $request->code;
        
        $data = Dun::findOrFail($id);

        $cek_code = Dun::where('code', $code)->where('id', '!=', $data->id)->first();

        if($cek_code){
            return response()->json([
                'newToken' => csrf_token(),
                'status' => false,
                'message'=>'Code DUN sudah digunakan, sila ganti Code lain',
                'data'=>null,
                ]);
        }

        $data->id_state = $request->id_state;
        $data->id_parliament = $request->id_parliament;
        $data->code = $code;
        $data->dun = $request->dun;
        $data->description = $request->description;
        $data->is_active = $request->status;
        
        $data->save();
        return response()->json([
            'newToken' => csrf_token(),
            'status' => true,
            'message'=>'Update Data Successfully',
            'data'=>$data
            ]);
    }
    
    public function edit($id, Request $r){
        $data = Dun::findOrFail($id);
        
        return response()->json([
            'success'=>'Get Data Successfully',
            'data'=>$data
            ]);
    }

    public function import(Request $request) 
    {

        try{
            Excel::import(new DunImport, $request->file('file'));
            return redirect()->back()->with('success', 'Dun imported successfully');
        }catch(\Exception $ex){
            Log::info($ex);
            return redirect()->back()->with('error','FAILED! Sila cek kembali data, pastikan State dan Parlimen sesuai database dan Code bersifat unik');
        }
        
    }

     /**
    * @return \Illuminate\Support\Collection
    */
    public function export() 
    {
        return Excel::download(new ParliamentExport, 'dun.xlsx');
    }
    
}
