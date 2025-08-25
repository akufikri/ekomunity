<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Session;
use DB;
use DataTables;
use Auth;
use App\Models\Certifikat;
use App\Models\User;
use App\Models\State;
use App\Models\DetailCompany;
use Illuminate\Support\Str;


class SettingsCertificateController extends Controller
{
    public function index(Request $request){

        $auth = Auth::user();

        if ($request->ajax()) {

            $data = Certifikat::orderBy('id_settings_certificate','desc');

            if($auth->id_level == '6'){
                $data = $data->where('id_state', $auth->id_state);
            }

            $data = $data->get();

            foreach($data as $d){
                $d->create_date = date('d-m-Y h:i:s', strtotime($d->created_at));
                if($d->id_state)
                    $d->state = State::where('id_state', $d->id_state)->first()->state;
                else
                    $d->state = 'Negeri belum diset';
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
        return view('admin.settingsCertificate.index');
    }   

    public function indexPersatuan(Request $request){

        $auth = Auth::user();

        if ($request->ajax()) {

            $data = DetailCompany::where('id_user', $auth->id)->get();

            foreach($data as $d){
                $d->create_date = date('d-m-Y h:i:s', strtotime($d->created_at));
            }

            return Datatables::of($data)->addIndexColumn()->make(true);
        }

        // $data = DetailCompany::where('id_user', $auth->id)->get();

        // return $data;
        return view('company.settingsCertificate.index');
    } 
    
    public function update(Request $request, $id)
    {
        
        $data = Certifikat::findOrFail($id);
        
        $data->sign_name = $request->sign_name;
        $data->valid_time = $request->valid_time;
        $data->sign_position = $request->sign_position;
        
        if($request->hasFile('img')){
            $file = $request->file('img');
            $n = $file->getClientOriginalName();
            $name = "$n";
            $file->move(public_path().'/SettingsCertificate',$name);
            $photo1 = $name;
        }else{
            $photo1 = $data->logo_1;
        }
        
        $data->logo_1 = $photo1;

        if($request->hasFile('img2')){
            $file = $request->file('img2');
            $n = $file->getClientOriginalName();
            $name = "$n";
            $file->move(public_path().'/SettingsCertificate',$name);
            $photo2 = $name;
        }else{
            $photo2 = $data->logo_2;
        }
        
        $data->logo_2 = $photo2;

        if($request->hasFile('img3')){
            $file = $request->file('img3');
            $n = $file->getClientOriginalName();
            $name = "$n";
            $file->move(public_path().'/SettingsCertificate',$name);
            $photo3 = $name;
        }else{
            $photo3 = $data->sign_picture;
        }
        
        $data->sign_picture = $photo3;

        $data->save();
        
        return response()->json([
            'newToken' => csrf_token(),
            'success'=> 'Update data successfully',
            'data'=>$data
            ]);
    }

    public function updatePersatuan(Request $request, $id)
    {
        
        $data = DetailCompany::findOrFail($id);
        
        $data->sign_name = $request->sign_name;
        $data->valid_time = $request->valid_time;
        $data->sign_position = $request->sign_position;
        
        if($request->hasFile('img')){
            $file = $request->file('img');
            $n = $file->getClientOriginalName();
            $randomString = Str::random(10);
            $name = "$n$randomString";
            $file->move(public_path().'/SettingsCertificate',$name);
            $photo1 = $name;
        }else{
            $photo1 = $data->logo_1;
        }
        
        $data->logo_1 = $photo1;

        if($request->hasFile('img2')){
            $file = $request->file('img2');
            $n = $file->getClientOriginalName();
            $randomString = Str::random(10);
            $name = "$n$randomString";
            $file->move(public_path().'/SettingsCertificate',$name);
            $photo2 = $name;
        }else{
            $photo2 = $data->logo_2;
        }
        
        $data->logo_2 = $photo2;

        if($request->hasFile('img3')){
            $file = $request->file('img3');
            $n = $file->getClientOriginalName();
            $randomString = Str::random(10);
            $name = "$n$randomString";
            $file->move(public_path().'/SettingsCertificate',$name);
            $photo3 = $name;
        }else{
            $photo3 = $data->sign_picture;
        }
        
        $data->sign_picture = $photo3;

        $data->save();
        
        return response()->json([
            'newToken' => csrf_token(),
            'success'=> 'Update data successfully',
            'data'=>$data
            ]);
    }
    
    public function show($id)
    {
        $data = Certifikat::findOrFail($id);
        return response()->json(['data'=>$data]);
    }

    public function showPersatuan($id)
    {
        $data = DetailCompany::findOrFail($id);
        return response()->json(['data'=>$data]);
    }
    
    public function edit(Request $request, $id)
    {
        $article = new Certifikat;
        $data = $article->findData($id);

        return response()->json(['data'=>$data]);

        // return response()->json(['html'=>$html]);

    }

    public function editPersatuan(Request $request, $id)
    {
        $data = DetailCompany::findOrFail($id);

        return response()->json(['data'=>$data]);

        // return response()->json(['html'=>$html]);

    }
}