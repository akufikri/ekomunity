<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SummaryQualification;
use App\Models\School;
use App\Models\Qualification;
use App\Models\Study;

use DataTables;
use DB;
use Auth;
use Redirect;

class SumQualificationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user()->id;
        if ($request->ajax()) {
            $data = SummaryQualification::where('id_user', $user)->orderBy('id_summary_qualification','desc')->get();
            foreach($data as $d){
                $school = School::where('id_school', $d->id_school)->first();
                $qualification = Qualification::where('id_qualification', $d->id_qualification)->first();
                $study = Study::where('id_study', $d->id_study)->first();
                
                $d->school = isset($school)?$school->school:'';
                $d->qualification = isset($qualification)?$qualification->qualification:'';
                $d->study = isset($study)?$study->study:'';
                
                $d->graduation_date = date('d-m-Y', strtotime($d->graduation_date));
            }
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->make(true);
                    
        }
        return view('sumQualification.index');
    }
    
    public function index_admin($id, Request $request)
    {
        
        if ($request->ajax()) {
            
            $user = $id;
            
            $data = SummaryQualification::where('id_user', $user)->orderBy('id_summary_qualification','desc')->get();
            foreach($data as $d){
                $school = School::where('id_school', $d->id_school)->first();
                $qualification = Qualification::where('id_qualification', $d->id_qualification)->first();
                $study = Study::where('id_study', $d->id_study)->first();
                
                $d->school = isset($school)?$school->school:'';
                $d->qualification = isset($qualification)?$qualification->qualification:'';
                $d->study = isset($study)?$study->study:'';
                
                $d->graduation_date = date('d-m-Y', strtotime($d->graduation_date));
            }
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->make(true);
                    
        }
        return view('sumQualification.index');
    }

    public function create()
    {
        return view('sumQualification.add');
    }

    public function store(Request $request)
    {
        $data = new SummaryQualification;
        $user = Auth::user()->id;
        
        $data->id_user = $user;
        $data->id_school = $request->id_school;
        $data->id_qualification = $request->id_qualification;
        $data->id_study = $request->id_study;
        $data->graduation_date = $request->graduation_date;
         $fileEmploy = "default";
        if($request->file('certificate')){
            $file = $request->file('certificate');
            $fileEmploy = "EMPLOY-" . md5(time()) . '.' .$file->getClientOriginalExtension();
            $file->move(public_path().'/SUMMARY', $fileEmploy);
        }
        $data->certificate = $fileEmploy;
        
        $data->save();
        return Redirect::to('summaryQualification')->with('success','Created successfully');
    }

    public function show($id)
    {
        $data = SummaryQualification::findOrFail($id);

        $html = '<div class="form-group">
                    <label for="Institute/University">Institute/University:</label>
                    <input type="text" class="form-control" name="school" disabled value="'.$data->school->school.'">
                </div>
                <div class="form-group">
                    <label for="Qualification">Qualification:</label>
                    <input type="text" class="form-control" name="qualification" disabled value="'.$data->qualification->qualification.'">
                </div>
                <div class="form-group">
                    <label for="Field of Study">Field of Study:</label>
                    <input type="text" class="form-control" name="study" disabled value="'.$data->study->study.'">
                </div>
                <div class="form-group">
                    <label for="Graduation Date">Graduation Date:</label>
                    <input type="date" class="form-control" name="graduation_date" disabled value="'.$data->graduation_date.'">
                </div>';

        return response()->json(['html'=>$html]);
    }

    public function edit($id, Request $r)
    {
        $data = SummaryQualification::findOrFail($id);
        return view('sumQualification.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = SummaryQualification::findOrFail($id);
        $data->id_school = $request->id_school;
        $data->id_qualification = $request->id_qualification;
        $data->id_study = $request->id_study;
        $data->graduation_date = $request->graduation_date;
         $fileEmploy = "default";
        if($request->file('certificate')){
            $file = $request->file('certificate');
            $fileEmploy = "EMPLOY-" . md5(time()) . '.' .$file->getClientOriginalExtension();
            $file->move(public_path().'/SUMMARY', $fileEmploy);
        }
        $data->certificate = $fileEmploy;
        
        $data->save();
        return Redirect::to('summaryQualification')->with('success','Updated successfully');
    }

    public function destroy($id)
    {
        $data = SummaryQualification::where('id_summary_qualification', $id)->first();
        $data->delete();
            
        return response()->json(['success'=>'Summary Qualification deleted successfully']);
    }
}
