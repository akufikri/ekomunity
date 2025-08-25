<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OtherQualification;

use DataTables;
use DB;
use Auth;
use Redirect;

class OthQualificationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user()->id;
        if ($request->ajax()) {
            $data = OtherQualification::where('id_user', $user)->orderBy('id_other_qualification','desc')->get();
            foreach($data as $d){
                $d->other_date = date('d-m-Y', strtotime($d->other_date));
            }
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->make(true);
                    
        }
        return view('otherQualification.index');
    }
    
    public function index_admin($id, Request $request)
    {
        
        if ($request->ajax()) {
            
            $user = $id;
            
            $data = OtherQualification::where('id_user', $user)->orderBy('id_other_qualification','desc')->get();
            foreach($data as $d){
                $d->other_date = date('d-m-Y', strtotime($d->other_date));
            }
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->make(true);
                    
        }
        return view('otherQualification.index');
    }

    public function create()
    {
        return view('otherQualification.add');
    }

    public function store(Request $request)
    {
        $data = new OtherQualification;
        $user = Auth::user()->id;
        
        $data->id_user = $user;
        $data->organizer = $request->organizer;
        $data->qualification = $request->qualification;
        $data->other_date = $request->other_date;
        $fileEmploy = "default";
        if($request->file('certificate')){
            $file = $request->file('certificate');
            $fileEmploy = "OTHER-" . md5(time()) . '.' .$file->getClientOriginalExtension();
            $file->move(public_path().'/SUMMARY', $fileEmploy);
        }
        $data->certificate = $fileEmploy;
        
        $data->save();
        return Redirect::to('otherQualification')->with('success','Created successfully');
    }

    public function show($id)
    {
        $data = OtherQualification::findOrFail($id);

        $html = '<div class="form-group">
                    <label for="Organizer">Organizer:</label>
                    <input type="text" class="form-control" name="organizer" disabled value="'.$data->organizer.'">
                </div>
                <div class="form-group">
                    <label for="Qualification">Qualification:</label>
                    <input type="text" class="form-control" name="qualification" disabled value="'.$data->qualification.'">
                </div>
                <div class="form-group">
                    <label for="Date">Date:</label>
                    <input type="date" class="form-control" name="other_date" disabled value="'.$data->other_date.'">
                </div>';

        return response()->json(['html'=>$html]);
    }

    public function edit($id, Request $r)
    {
        $data = OtherQualification::findOrFail($id);
        return view('otherQualification.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = OtherQualification::findOrFail($id);
        $data->organizer = $request->organizer;
        $data->qualification = $request->qualification;
        $data->other_date = $request->other_date;
         if($request->file('certificate')){
            $file = $request->file('certificate');
            $fileEmploy = "OTHER-" . md5(time()) . '.' .$file->getClientOriginalExtension();
            $file->move(public_path().'/SUMMARY', $fileEmploy);
        }
        $data->certificate = $fileEmploy;
        
        $data->save();
        return Redirect::to('otherQualification')->with('success','Updated successfully');
    }

    public function destroy($id)
    {
        $data = OtherQualification::where('id_other_qualification', $id)->first();
        $data->delete();
            
        return response()->json(['success'=>'Other Qualification deleted successfully']);
    }
}
