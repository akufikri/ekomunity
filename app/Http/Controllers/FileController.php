<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyWorkers;
use App\Models\User;
use DataTables;
use DB;
use Auth;

class FileController extends Controller
{

    
    public function index()
    {
        
        
    }

    public function create()
    {
        
    }

    public function store(Request $r)
    {
        
    }
    

    public function show($id)
    {
    
    }

    public function edit($id, Request $r)
    {
        
    }

    public function update(Request $r, $id)
    {
        $this->validate($r, [
            'certificate' => 'required',
            'certificate.*' => 'mimes:doc,pdf,docx,zip'
        ]);
        
        $data = CompanyWorkers::findOrFail($id);
    
        $user = Auth::user()->id;
        $data->id_user = $user;
        if($r->id_segment) $data->id_segment = $r->id_segment;
        if($r->id_country) $data->id_country = $r->id_country;
        if($r->id_position) $data->id_position = $r->id_position;
        if($r->id_status) $data->id_status = $r->id_status;
        $data->ic_number = $r->ic_number;
        $data->name = $r->name;
        $data->save();
        
        $files = json_decode($data->certificate);
        if(is_array($r->file('certificate'))){
            foreach($r->file('certificate') as $file){
                $file = $file;
                $file->move(public_path()."/CertificateOfWork/",$file->getClientOriginalName());
                $files[] = $file->getClientOriginalName();
            }
            $data->certificate = json_encode($files);
            $data->save();
        }
        
        return redirect()->to('/companyWorkers#view')->with('success','Updated successfully');
    }
    
    public function remove_file($id)
    {
        $data = CompanyWorkers::findOrFail($id);
        
        $files = json_decode($data->certificate);
        foreach($files as $f){
            if($file != $f){
                $new[] = $f;
            }
        }
        $data->certificate = json_encode($new);
        $data->save();
        $file_path = public_path()."/CertificateOfWork/$file";
        // return $file_path;
        if(file_exists($file_path)) {
            unlink($file_path);
        }
    }

    public function destroy($id)
    {
        
    }
}
