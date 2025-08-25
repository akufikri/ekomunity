<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CollaborationAgency;
use App\Models\DetailManpower;
use App\Models\Agency;
use App\Models\User;
use DataTables;
use Auth;

class CollaborationAgencyController extends Controller
{
    
    public function index(Request $request) {

        $auth = Auth::user();
        
        if($request->id) {
            $auth->id = $request->id;
        }

        $dataValidation = User::findOrFail($auth->id);

        if ($request->ajax()) {

            $data = CollaborationAgency::orderBy('id', 'desc');

            $data = $data->get();

            foreach($data as $d) {
                $agency = Agency::where('id_agency', $d->id_agency)->first();
                $d->agency = ($d->id_agency != 0) ? $agency->agency : $d->other_agency;
                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));

            }

            return Datatables::of($data)->addIndexColumn()->make(true);

        }

        $agency = Agency::where('is_active', 'ENABLE')->get();

        return view('collaborationAgency.index', compact('agency', 'dataValidation'));

    }

    public function store(Request $request) {

        $auth = Auth::user();

        $manpower = DetailManpower::where('id_user', $auth->id)->first();

        $data = new CollaborationAgency();
        $data->id_user = $auth->id;
        $data->id_detail_manpower = $manpower->id_detail_manpower;
        $data->id_agency = $request->agency;
        $data->other_agency = $request->other_agency;
        $data->collaboration_matters = $request->collaboration_matters;
        $data->collaboration_date = $request->collaboration_date;

        $data->save();

        return redirect()->back()->with('success','Created successfuly');

    }

    public function edit($id) {
        $data = CollaborationAgency::select('id', 'id_agency', 'other_agency', 'collaboration_matters', 'collaboration_date')->where('id', $id)->first();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function update(Request $request, $id) {

        $data = CollaborationAgency::findOrFail($id);

        $data->id_agency = $request->agency;
        $data->other_agency = ($request->agency == '0') ? $request->other_agency : NULL;
        $data->collaboration_matters = $request->collaboration_matters;
        $data->collaboration_date = $request->collaboration_date;

        $data->save();

        return response()->json([
            'newToken' => csrf_token(),
            'status' => true,
            'message' => 'Update Data Successfuly'
        ]);


    }

    public function destroy($id) {

        $data = CollaborationAgency::findOrFail($id);

        $data->delete();

        // return redirect()->back()->with('success','Delete Data Successfully');
        return response()->json([
            'newToken' => csrf_token(),
            'status' => true,
            'message' => 'Delete Data Successfuly'
        ]);

    }

}
