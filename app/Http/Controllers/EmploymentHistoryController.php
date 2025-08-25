<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmploymentHistory;
use App\Models\Position;
use App\Models\Segment;
use DataTables;
use DB;
use Auth;

class EmploymentHistoryController extends Controller
{

    public function getData(Request $request)
    {
        $user = Auth::user()->id;
        if ($request->ajax()) {
            $data = EmploymentHistory::where('id_user', $user)->orderBy('id_employment_history','desc')->get();
            foreach($data as $d){
                $position = Position::where('id_position', $d->id_position)->first();
                $segment = Segment::where('id_segment', $d->id_segment)->first();
                
                $d->position = isset($position)?$position->position:'';
                $d->segment = isset($segment)?$segment->segment:'';
                
                $d->from_date = date('d-m-Y', strtotime($d->from_date));
                $d->to_date = date('d-m-Y', strtotime($d->to_date));
            }
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->make(true);
                    
        }
        return view('employeentHistory.show');
    }
    
    public function index_admin($id, Request $request)
    {
        
        if ($request->ajax()) {
            
            $user = $id;
            
            $data = EmploymentHistory::where('id_user', $user)->orderBy('id_employment_history','desc')->get();
            foreach($data as $d){
                $position = Position::where('id_position', $d->id_position)->first();
                $segment = Segment::where('id_segment', $d->id_segment)->first();
                
                $d->position = isset($position)?$position->position:'';
                $d->segment = isset($segment)?$segment->segment:'';
                
                $d->from_date = date('d-m-Y', strtotime($d->from_date));
                $d->to_date = date('d-m-Y', strtotime($d->to_date));
            }
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->make(true);
                    
        }
        return view('employeentHistory.show');
    }

    public function create()
    {
        return view('employeentHistory.add');
    }

    public function store(Request $request)
    {
        $data = new EmploymentHistory;
        $user = Auth::user()->id;
        
        $data->id_user = $user;
        $data->company = $request->company;
        $data->id_position = $request->id_position;
        $data->id_segment = $request->id_segment;
        $data->from_date = $request->from_date;
        $data->to_date = $request->to_date;
         $fileEmploy = "default";
        if($request->file('certificate')){
            $file = $request->file('certificate');
            $fileEmploy = "EMPLOY-" . md5(time()) . '.' .$file->getClientOriginalExtension();
            $file->move(public_path().'/EMPLOY', $fileEmploy);
        }
        $data->certificate = $fileEmploy;
        
        $data->save();
        
        return redirect()->to('employmentDetail/'.$user)->with('success','Created successfully');
    }
    
    // public function download($filename)
    // {
    // $file_path = public_path('/public/EMPLOY'). $filename;
    // if (file_exists($file_path))
    // {
    //     return response()->json("nando");
    //     // Send Download
    //     return Response::download($file_path, $filename, [
    //         'Content-Length: '. filesize($file_path)
    //     ]);
    // }
    // else
    // {
    //     // Error
        
    // }

    // }

    public function show($id)
    {
        $data = EmploymentHistory::findOrFail($id);

        $html = '<div class="form-group">
                    <label for="Company">Company:</label>
                    <input type="text" class="form-control" name="company" disabled value="'.$data->company.'">
                </div>
                <div class="form-group">
                    <label for="Position">Position:</label>
                    <input type="text" class="form-control" name="position" disabled value="'.$data->position->position.'">
                </div>
                <div class="form-group">
                    <label for="Segment">Field of Work:</label>
                    <input type="text" class="form-control" name="segment" disabled value="'.$data->segment->segment.'">
                </div>
                <div class="form-group">
                    <label for="From Date">From Date:</label>
                    <input type="date" class="form-control" name="from_date" disabled value="'.$data->from_date.'">
                </div>
                <div class="form-group">
                    <label for="To Date">To Date:</label>
                    <input type="date" class="form-control" name="to_date" disabled value="'.$data->to_date.'">
                </div>';
                

        return response()->json(['html'=>$html]);
    }

    public function edit($id, Request $r)
    {
        $data = EmploymentHistory::findOrFail($id);
        return view('employeentHistory.edit_history', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user()->id;
        $data = EmploymentHistory::findOrFail($id);
        $data->company = $request->company;
        $data->id_position = $request->id_position;
        $data->id_segment = $request->id_segment;
        $data->from_date = $request->from_date;
        $data->to_date = $request->to_date;
        $fileEmploy = "default";
        if($request->file('certificate')){
            $file = $request->file('certificate');
            $fileEmploy = "EMPLOY-" . md5(time()) . '.' .$file->getClientOriginalExtension();
            $file->move(public_path().'/EMPLOY', $fileEmploy);
        }
        $data->certificate = $fileEmploy;
        
        $data->save();
       
       
        return redirect()->to('employmentDetail/'.$user)->with('success_add','Update successfully');;
    }

    public function destroy($id)
    {
        $employHis = EmploymentHistory::where('id_employment_history', $id)->first();
        $employHis->delete();
            
        return response()->json(['success'=>'Employment History deleted successfully']);
    }
}
