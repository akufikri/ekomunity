<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CompanyShareHolders;
use App\Models\TempCompanyShareHolders;
use App\Models\DetailCompany;
use App\Models\JoinCompany;
use App\Models\ManpowerPosition;
use App\Models\Position;
use DataTables;
use Redirect;
use DB;
use Auth;
use Illuminate\Support\Facades\Validator;

class MaklumatJawatanKuasaController extends Controller
{
        public function updateMaklumatJawatan(Request $request, $id_manpower_position)
        {
            try {

                $data = ManpowerPosition::find($id_manpower_position);
                if(!$data) return response()->json(['success' => false, 'message' => 'Data not found', 'data' => null], 404);

                $validator = Validator::make($request->all(),[
                    'id_position' => 'sometimes|exists:tb_position,id_position',
                    'date_appointment' => 'sometimes'
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid validation',
                        'data' => $validator->errors()
                    ], 400);
                }

                $data->update([
                    'id_position' => $request->id_position,
                    'date_appointment' => $request->date_appointment
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Successfully update',
                    'data' => $data
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed update maklumat jawatan, please try agin later',
                    'data' => $e->getMessage()
                ], 500);
            }
        }

    public function getPosition()
    {
        try {

            $data = Position::select('id_position', 'position')->get();

            return response()->json([
                'success' => true,
                'message' => 'Successfully get position data',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed get position data, please try again later',
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function index(Request $request)
    {
        $auth = Auth::user();

        if($auth->sub_company != null){
            $user = $auth->sub_company;
        } else {
            $user = Auth::user()->id;
        }

        if($request->id_user) $user = $request->id_user;

        if ($request->ajax()) {

            $data = ManpowerPosition::with('company', 'user', 'position')->where('id_company', $user)->get();
            foreach($data as $d){
                $d->date_appointment = date('d-m-Y H:i:s', strtotime($d->date_appointment));
                $d->date_create = date('d-m-Y H:i:s', strtotime($d->created_at));

            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }

        $detail = DetailCompany::where('id_user', $user)->first();
        $position = Position::where('is_active', 'ENABLE')->get();
        // $ahli = User::with('manpower')->whereHas('manpower', function($query) use($detail) {
        //     $query->where('id_detail_company', 'LIKE', '%'.$detail->id_detail_company.'%');
        //     $query->where('is_subscribe', 'TRUE');
        // })->where('status', 'ACTIVE')->get();

        $ahli = JoinCompany::with(['manpower' => function($query) {
            $query->select('id_user', 'id_detail_manpower', 'id_detail_company');
        }, 'manpower.user' => function($query) {
                $query->select('id','fullname','phone_number', 'email', 'is_verified', 'registered_by');
        }])->where('id_detail_company', $detail->id_detail_company)->whereDate('expired_at', '>', date('Y-m-d'))->orderBy('created_at', 'DESC')->get();

        // return $ahli;

        return view('company.maklumatJawatanKuasa.index', compact('position', 'ahli'));
    }

    public function store(Request $request)
    {

        $user = Auth::user()->id;

        $cek = ManpowerPosition::where('id_user', $request->id_user)->first();

        if($cek) {
            return redirect()->back()->with('failed','Nama sudah ada jawatankuasa!');
        }


        $data = new ManpowerPosition();
        $data->id_company = $user;
        $data->id_user = $request->id_user;
        $data->id_position = $request->id_position;
        $data->date_appointment = $request->date_appointment;
        $data->save();

        return redirect()->back()->with('success','Created successfully');
    }


    public function edit($id, Request $r)
    {
        $data = ManpowerPosition::where('id_manpower_position', $id)->first();

        $data->created_date = date('Y-m-d H:i:s', strtotime($data->created_at));

        return response()->json([
            'success'=>'Get data successfully',
            'data'=>$data
            ]);
        // return view('admin.settingsPosition.index', compact('data'));
    }

    public function update(Request $request, $id)
    {

        $user = Auth::user()->id;

        $data = ManpowerPosition::where('id_manpower_position', $id)->first();

        $data->id_company = $user;
        $data->id_user = $request->id_user;
        $data->id_position = $request->id_position;
        $data->date_appointment = $request->date_appointment;
        $data->save();

        return response()->json([
            'newToken' => csrf_token(),
            'success'=>'Update Data Successfully',
            'data'=>$data
            ]);

        // return redirect()->back()->with('success','Updated successfully');
    }

    public function destroy($id){

        $data = ManpowerPosition::where('id_manpower_position', $id)->delete();

        return response()->json(['success'=>'Shareholders deleted successfully']);
    }

    public function temp_destroy($id){

        $data = TempCompanyShareHolders::where('id_temp_company_shareholders', $id)->first();
        $data->delete();

        return response()->json(['success'=>'Cancel update successfully']);
    }

}
