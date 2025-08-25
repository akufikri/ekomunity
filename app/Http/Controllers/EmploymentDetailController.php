<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailManpower;
use App\Models\StatusEducation;
use App\Models\BusinessActivity;
use App\Models\SubBusinessActivity;
use App\Models\BusinessType;
use App\Models\BusinessIncome;
use App\Models\CategoryProduct;
use App\Models\User;
use App\Models\Study;
use App\Models\VillageGuests;

class EmploymentDetailController extends Controller
{

    public function index(){
        
    }
    
    public function show($id)
    {
        $data = User::findOrFail($id);
        $dataValidation = User::findOrFail($id);
        return view('employeentHistory.show', compact('data', 'dataValidation'));
    }
    
    public function maklumatPerniagaan($id)
    {
        $data = User::findOrFail($id);
        $dataValidation = User::findOrFail($id);
        return view('employee.maklumatPerniagaan', compact('data', 'dataValidation'));
    }
    
    public function editMaklumatPendidikan($id)
    {
        $data = User::findOrFail($id);
        $dataValidation = User::findOrFail($id);
        $status_education = StatusEducation::where('is_active', 'ENABLE')->get();
        $study = Study::where('is_active', 'ENABLE')->get();
        return view('employee.editMaklumatPendidikan', compact('data', 'status_education', 'study', 'dataValidation'));
    }
    
    public function updateMaklumatPendidikan(Request $request, $id)
    {
        $data = User::findOrFail($id);
        $data->save();
        
        if($data){
            $man = DetailManpower::where('id_user',$data->id)->first();
            $man->id_status_education = $request->id_status_education;
            $man->education_field = $request->education_field;

            $sijil_kemahiran = $request->sijil_kemahiran;
            array_pop($sijil_kemahiran);
            $man->skills_certificate = $sijil_kemahiran;
            
            $sijil_kemahiran_tahun = $request->sijil_kemahiran_tahun;
            array_pop($sijil_kemahiran_tahun);
            $man->skills_certificate_year = $sijil_kemahiran_tahun;
            
            $man->save();
        }
        // return $man;
        return redirect()->to("employmentDetail/$id")->with('success','Updated successfully');
    }
    
    public function editMaklumatPerniagaan($id)
    {
        $data = User::findOrFail($id);
        $manpower = DetailManpower::where('id_user', $data->id)->first();
        $dataValidation = User::findOrFail($id);

        $business_activity = BusinessActivity::where('is_active', 'ENABLE')->get();
        $sub_business_activity = SubBusinessActivity::where('is_active', 'ENABLE')->get();
        $business_type = BusinessType::where('is_active', 'ENABLE')->get();
        $sub_business_activity = SubBusinessActivity::where('is_active', 'ENABLE')->get();
        $category_product = CategoryProduct::where('is_active', 'ENABLE')->get();
        $pegawai_daerah = User::where('status', 'ACTIVE')->where('id_level', 4)->get();
        $business_income = BusinessIncome::where('is_active', 'ENABLE')->where('type_income', "TAHUNAN")->get();
        if(isset($manpower->id_state)){
            $village_guests = VillageGuests::where('is_active', 'ENABLE')->where('id_state', $manpower->id_state)->get();
        } else {
            $village_guests = null;
        }
        
        return view('employee.editMaklumatPerniagaan', compact('data', 'dataValidation', 'business_activity', 'sub_business_activity', 'business_type', 'sub_business_activity', 'category_product', 'pegawai_daerah', 'business_income', 'village_guests', 'manpower'));
    }
    
    public function updateMaklumatPerniagaan(Request $request, $id)
    {
        $data = User::findOrFail($id);
        $data->save();
        
        if($data){
            $man = DetailManpower::where('id_user',$data->id)->first();
            $man->id_pegawai_daerah = $request->pegawai_daerah;

            $village_guests = $request->village_guests;
            // array_pop($village_guests);
            $man->id_village_guests = $village_guests;

            $sub_business_activity = $request->sub_business_activity;
            $man->sub_business_activity = $sub_business_activity;

            $man->name_of_business = $request->name_of_business;
            $man->business_type = $request->business_type;
            $man->business_license_no = $request->business_license_no;
            $man->business_address = $request->business_address;
            $man->business_activity = $request->business_activity;
            $man->business_income = $request->business_income;
            $man->business_phone = $request->business_phone;
            $man->business_email = $request->business_email;
            $man->business_sosmed = $request->business_sosmed;
            $man->business_lat = $request->place_latitude;
            $man->business_lng = $request->place_longitude;
            $man->website = $request->website;

            
            if($request->hasFile('img_picture_of_business')){
                $file = $request->file('img_picture_of_business');
                $n = $file->getClientOriginalName();
                $name = "$n";
                $file->move(public_path().'/BusinessImage',$name);
                $photo1 = $name;
                $man->picture_of_business = $photo1;
            }
            
            if($request->hasFile('img_picture_product')){
                $file = $request->file('img_picture_product');
                $n = $file->getClientOriginalName();
                $name = "$n";
                $file->move(public_path().'/BusinessProductImage',$name);
                $photo1 = $name;
                $man->picture_product = $photo1;
            }
            
            $man->save();
        }
        // return $man;
        return redirect()->to("maklumatPerniagaan/$id")->with('success','Updated successfully');
    }
    
    public function edit($id)
    {
        $data = User::findOrFail($id);
        $dataValidation = User::findOrFail($id);
        return view('employeentHistory.edit', compact('data', 'dataValidation'));
    }
    
    public function update(Request $request, $id)
    {
        $data = User::findOrFail($id);
        $data->save();
        
        if($data){
            $man = DetailManpower::where('id_user',$data->id)->first();
            $man->id_user = $data->id;
            $man->id_work_type = $request->id_work_type;
            $man->current_work_status = $request->current_work_status;
            
            $man->save();
        }
        // return $man;
        return redirect()->back()->with('success','Updated successfully');
    }
    
}
