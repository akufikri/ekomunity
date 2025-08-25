<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Session;
use DB;
use DataTables;
use App\Models\VillageGuests;
use App\Models\State;
use App\Models\Parliament;
use App\Models\Dun;
use App\Models\DetailManpower;
use App\Models\BusinessActivity;
use App\Models\BusinessType;

class SettingsVillageGuestsController extends Controller
{

    public function index(Request $request){
        if ($request->ajax()) {
            $data = VillageGuests::orderBy('id','desc')->get();
            foreach($data as $d){
                $d->state = State::where('id_state', $d->id_state)->first()->state;
                $d->parliament = Parliament::where('id', $d->id_parliament)->first()->parliament;
                $d->dun = Dun::where('id', $d->id_dun)->first()->dun;

                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
            }
            return Datatables::of($data)->addIndexColumn()->make(true);
        }

        $state = State::where('is_active', 'ENABLE')->get();   
        $parliament = Parliament::where('is_active', 'ENABLE')->get();  
        $dun = Dun::where('is_active', 'ENABLE')->get();  
      
        return view('admin.settingsVillageGuests.index', compact('state', 'parliament', 'dun'));
    }
    
    public function create(Request $request)
    {
        $data = new VillageGuests;        
        $data->id_state = $request->id_state;
        $data->id_parliament = $request->id_parliament;
        $data->id_dun = $request->id_dun;
        $data->village_guests = $request->village_guests;
        $data->description = $request ->description;
        $data->lat = $request->place_latitude;
        $data->lng = $request->place_longitude;
        
        $data->save();
        return redirect()->back()->with('success','Created successfully');
    }
    
    public function update_village_guests(Request $request, $id){
        $data = VillageGuests::findOrFail($id);
        $data->id_state = $request->id_state;
        $data->id_parliament = $request->id_parliament;
        $data->id_dun = $request->id_dun;
        $data->village_guests = $request->village_guests;
        $data->description = $request->description;
        $data->is_active = $request->status;
        $data->lat = $request->lat;
        $data->lng = $request->lng;
        
        $data->save();
        return response()->json([
            'newToken' => csrf_token(),
            'success'=>'Update Data Successfully',
            'data'=>$data
            ]);
    }
    
    public function edit($id, Request $r){
        $data = VillageGuests::findOrFail($id);
        
        return response()->json([
            'success'=>'Get Data Successfully',
            'data'=>$data
            ]);
    }

    public function viewMap()
    {
        // $data = User::findOrFail($id);

        $village_guests = VillageGuests::where('is_active', 'ENABLE')->get();
        
        foreach($village_guests as $d) {
            
            $data_overall = DetailManpower::select('id_detail_manpower', 'id_user', 'step_registration', 'id_village_guests')->whereHas('user', function($user) {
                $user->where('status','ACTIVE');   
            })->with('user')
            ->where('step_registration', DetailManpower::$stepRegistration)
            ->where('id_village_guests', 'LIKE', '%' . $d->id . '%')->get()->count();


            $data = DetailManpower::select('id_detail_manpower', 'id_user', 'step_registration', 'id_village_guests', 'certificate_expired_date')->whereHas('user', function($user) {
                $user->where('status','ACTIVE');   
            })->with('user')
            ->where('step_registration', DetailManpower::$stepRegistration)
            ->where('id_village_guests', 'LIKE', '%' . $d->id . '%')
            ->whereDate('certificate_expired_date', '>', now())->get()->count();

            $total_ahli_business_income_weekly = DetailManpower::select('id_detail_manpower', 'step_registration', 'id_village_guests', 'business_income_weekly', 'certificate_expired_date')
            ->where('step_registration', DetailManpower::$stepRegistration)
            ->where('id_village_guests', 'LIKE', '%' . $d->id . '%')
            ->where('business_income_weekly', '!=', null)
            ->whereDate('certificate_expired_date', '>', now())->get();

            $total_ahli_business_income_monthly = DetailManpower::select('id_detail_manpower', 'step_registration', 'id_village_guests', 'business_income_monthly', 'certificate_expired_date')
            ->where('step_registration', DetailManpower::$stepRegistration)
            ->where('id_village_guests', 'LIKE', '%' . $d->id . '%')
            ->where('business_income_monthly', '!=', null)
            ->whereDate('certificate_expired_date', '>', now())->get();

            $totalWeekly = 0;
            $avgWeekly = 0;
            foreach ($total_ahli_business_income_weekly as $item) {
                $totalWeekly = $totalWeekly+=$item->business_income_weekly;
            }

            if ($total_ahli_business_income_weekly->count() != 0) {
                $avgWeekly = round((int) $totalWeekly / (int) $total_ahli_business_income_weekly->count(), 2);
            }

            $d->total_weekly = "RM$avgWeekly";
            
            $totalMonthly = 0;
            foreach ($total_ahli_business_income_monthly as $item) {
                $totalMonthly = $totalMonthly+=$item->business_income_monthly;
            }

            if ($total_ahli_business_income_monthly->count() != 0) {
                $avgMonthly = round((int) $totalMonthly / (int) $total_ahli_business_income_monthly->count(), 2);
            }

            $d->total_monthly = "RM$avgMonthly";
            

            $total_ahli_business_type_all= DetailManpower::select('id_detail_manpower', 'step_registration', 'business_type', 'id_village_guests')->where('step_registration', DetailManpower::$stepRegistration)
            ->where('business_type', '!=', null)
            ->where('id_village_guests', 'LIKE', '%' . $d->id . '%')
            ->get()->count();

            $business_type = BusinessType::select('id_business_type', 'business_type')->where('is_active', 'ENABLE')->get();

            foreach ($business_type as $item) {
                $total = DetailManpower::select('id_detail_manpower', 'step_registration', 'business_type', 'id_village_guests')->where('step_registration', DetailManpower::$stepRegistration)->where('business_type', $item->id_business_type)->where('id_village_guests', 'LIKE', '%' . $d->id . '%')->get()->count();
                
                if ($total != 0) {
                    $sum = round(($total/$total_ahli_business_type_all)*100, 2);
                    $item->percentage_value = $sum;
                    $item->percentage_label = "$sum%";
                } else {
                    $sum = 0;
                    $item->percentage_value = $sum;
                    $item->percentage_label = "$sum%";
                }
                
            }

            $sortedArrayBusinessType = $business_type->sortByDesc('percentage_value')->values()->toArray();
            $top3BusinessType = array_slice($sortedArrayBusinessType, 0, 3);
            
            $percentBusinessType = array_sum(array_column($top3BusinessType, 'percentage_value'));
            if ($percentBusinessType != 0) {
                $othersBusinessType = round(100 - $percentBusinessType, 2);        
                
                if($othersBusinessType < 0) {
                    $othersBusinessType = 0;
                }
            } else {
                $othersBusinessType = 0;
            }

            $top3BusinessType[] = [
                'business_type' => 'Lain-lain',
                'percentage_value' => $othersBusinessType,
                'percentage_label' => "$othersBusinessType%",
            ];

            $total_ahli_business_activity_all= DetailManpower::select('id_detail_manpower', 'step_registration', 'business_activity', 'id_village_guests')->where('step_registration', DetailManpower::$stepRegistration)
            ->where('business_activity', '!=', null)
            ->where('id_village_guests', 'LIKE', '%' . $d->id . '%')
            ->get()->count();

            $business_activity = BusinessActivity::select('id_business_activity', 'business_activity')->where('is_active', 'ENABLE')->get();

            foreach ($business_activity as $item) {

                $total = DetailManpower::select('id_detail_manpower', 'step_registration', 'business_activity', 'id_village_guests')->where('step_registration', DetailManpower::$stepRegistration)->where('business_activity', $item->id_business_activity)->where('id_village_guests', 'LIKE', '%' . $d->id . '%')->get()->count();
               
                if ($total != 0) {
                    $sum = round(($total/$total_ahli_business_activity_all)*100, 2);
                    $item->percentage_value = $sum;
                    $item->percentage_label = "$sum%";
                } else {
                    $sum = 0;
                    $item->percentage_value = $sum;
                    $item->percentage_label = "$sum%";
                }

            }

            $sortedArrayBusinessActivity = $business_activity->sortByDesc('percentage_value')->values()->toArray();
            $top6BusinessActivity = array_slice($sortedArrayBusinessActivity, 0, 6);
            
            $percentBusinessActivity = array_sum(array_column($top6BusinessActivity, 'percentage_value'));
            if ($percentBusinessActivity != 0) {
                $othersBusinessActivity = round(100 - $percentBusinessActivity, 2);     
                if ($othersBusinessActivity < 0) {
                    $othersBusinessActivity = 0;
                }       
            } else {
                $othersBusinessActivity = 0;
            }

            $top6BusinessActivity[] = [
                'business_activity' => 'Lain-lain',
                'percentage_value' => $othersBusinessActivity,
                'percentage_label' => "$othersBusinessActivity%",
            ];

            $d->village_guests = strtoupper($d->village_guests);
            $d->total_ahli_overall = $data_overall;
            $d->total_ahli = $data;
            $d->business_type = $top3BusinessType;
            $d->business_activity = $top6BusinessActivity;
            
        }

        // return $village_guests;

        return view('viewmap.villageGuests', compact('village_guests'));
    }
    
}
