<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ParliamentImport;
use App\Exports\ParliamentExport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Session;
use DB;
use DataTables;
use App\Models\Parliament;
use App\Models\State;
use Auth;

class SettingsParliamentController extends Controller
{

    public function index(Request $request){

        $auth = Auth::user();

        if ($request->ajax()) {
            $data = Parliament::orderBy('id','desc');

            if($auth->id_level == 6){
                $data = $data->where('id_state', $auth->id_state);
            }

            $data = $data->get();
            
            foreach($data as $d){
                $d->state = State::where('id_state', $d->id_state)->first()->state;
                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }

        $state = State::where('is_active', 'ENABLE')->get();   

        return view('admin.settingsParliament.index', compact('state'));
    }
    
    public function create(Request $request)
    {
        $code = $request->code;

        $cek_code = Parliament::where('code', $code)->first();

        if($cek_code){
            return redirect()->back()->with('warning','WARNING! Code Parlimen sudah digunakan, sila ganti Code lain');
        }

        $data = new Parliament; 
        $data->id_state = $request->id_state;
        $data->code = $code;
        $data->parliament = $request->parliament;
        $data->description = $request ->description;

        $data->save();
        return redirect()->back()->with('success','Created successfully');
    }
    
    public function update_parliament(Request $request, $id){

        $code = $request->code;

        $data = Parliament::findOrFail($id);

        $cek_code = Parliament::where('code', $code)->where('id', '!=', $data->id)->first();

        if($cek_code){
            return response()->json([
                'newToken' => csrf_token(),
                'status' => false,
                'message'=>'Code Parlimen sudah digunakan, sila ganti Code lain',
                'data'=>null,
                ]);
        }

        $data->id_state = $request->id_state;
        $data->code = $code;
        $data->parliament = $request->parliament;
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
        $data = Parliament::findOrFail($id);
        
        return response()->json([
            'success'=>'Get Data Successfully',
            'data'=>$data
            ]);
    }

    public function import(Request $request) 
    {

        try{
            Excel::import(new ParliamentImport, $request->file('file'));
            return redirect()->back()->with('success', 'Parlimen imported successfully');
        }catch(\Exception $ex){
            Log::info($ex);
            return redirect()->back()->with('error','FAILED! Sila cek kembali data, pastikan State sesuai database dan Code bersifat unik');
        }
        
    }

     /**
    * @return \Illuminate\Support\Collection
    */
    public function export() 
    {
        return Excel::download(new ParliamentExport, 'parliament.xlsx');
    }
    
}
