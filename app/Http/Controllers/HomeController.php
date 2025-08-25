<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailCompany;
use App\Models\DetailManpower;
use App\Models\LogPaymentManpower;
use App\Models\VillageGuests;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use DataTables;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = \Auth::user();
        $view = 'v_home';

        // return $user;

        $data = \App\Models\User::findOrFail($user->id);

        if($user->id_level == '1' || $user->id_level == '4' || $user->id_level == '5' || $user->id_level == '6' || $user->id_level == '7') {

            $view = 'admin';

            $persatuan = DetailCompany::where('id_detail_company', '>', '0')->where('step_registration', DetailCompany::$stepRegistration);
            $ahli_dalam_persatuan = DetailManpower::where('id_detail_company','!=', null)->where('step_registration', DetailManpower::$stepRegistration);
            $ahli_terus = DetailManpower::where('id_detail_company', null)->where('step_registration', DetailManpower::$stepRegistration);
            $yuran_dibayar = LogPaymentManpower::sum('amount');
            $perniaga_lelaki = DetailManpower::where('gender', '1')->where('step_registration', DetailManpower::$stepRegistration);
            $perniaga_perempuan = DetailManpower::where('gender', '2')->where('step_registration', DetailManpower::$stepRegistration);
            $tidak_berdaftar = 0;
            $belum_membayar_yuran = DetailManpower::where('is_subscribe', 'FALSE')->where('step_registration', DetailManpower::$stepRegistration)->count();

            $senarai_ahli = User::where('id_level', '3')->with('manpower')->orderBy('id', 'DESC')->whereHas('manpower', function($query) {
                $query->where('step_registration', DetailManpower::$stepRegistration);
            });

            $ahli_belum_complete_daftar = DetailManpower::where('id_detail_company','!=', null)->where('step_registration', '!=', DetailManpower::$stepRegistration);

            $senarai_persatuan = User::with('company')->orderBy('id', 'DESC')->where('id_level', '2')->whereHas('company', function($query) {
                $query->where('step_registration', DetailCompany::$stepRegistration);
            });

            if($user->id_level == '4') {

                $persatuan = $persatuan->where('id_pegawai_daerah', 'LIKE', '%'. $user->id .'%');
                $ahli_dalam_persatuan = $ahli_dalam_persatuan->where('id_pegawai_daerah', $user->id);
                $ahli_terus = $ahli_terus->where('id_pegawai_daerah', $user->id);
                $perniaga_lelaki = $perniaga_lelaki->where('id_pegawai_daerah', $user->id);
                $perniaga_perempuan = $perniaga_perempuan->where('id_pegawai_daerah', $user->id);
                $senarai_ahli = $senarai_ahli->whereHas('manpower', function($query) use($user) {
                    $query->where('id_pegawai_daerah', $user->id);
                });

                $senarai_persatuan = $senarai_persatuan->whereHas('company', function($query) use($user) {
                    $query->where('id_pegawai_daerah', 'LIKE', '%'. $user->id .'%');
                });
            }

            if($user->id_level == '6') {
                $persatuan = $persatuan->where('id_state', $user->id_state);
                $ahli_dalam_persatuan = $ahli_dalam_persatuan->where('id_state', $user->id_state);
                $ahli_terus = $ahli_terus->where('id_state', $user->id_state);
                $perniaga_lelaki = $perniaga_lelaki->where('id_state', $user->id_state);
                $perniaga_perempuan = $perniaga_perempuan->where('id_state', $user->id_state);
                $senarai_ahli = $senarai_ahli->whereHas('manpower', function($query) use($user) {
                    $query->where('id_state', $user->id_state);
                });

                $senarai_persatuan = $senarai_persatuan->whereHas('company', function($query) use($user) {
                    $query->where('id_state', $user->id_state);
                });
            }

            $persatuan = $persatuan->count();
            $ahli_dalam_persatuan = $ahli_dalam_persatuan->count();
            $ahli_terus = $ahli_terus->count();
            $perniaga_lelaki = $perniaga_lelaki->count();
            $ahli_belum_complete_daftar = $ahli_belum_complete_daftar->count();
            $perniaga_perempuan = $perniaga_perempuan->count();
            $senarai_ahli = $senarai_ahli->limit(8)->get();
            $senarai_persatuan = $senarai_persatuan->limit(8)->get();

            $result = compact('persatuan','ahli_dalam_persatuan','ahli_terus','yuran_dibayar','perniaga_lelaki','perniaga_perempuan','tidak_berdaftar','belum_membayar_yuran', 'senarai_ahli', 'senarai_persatuan', 'ahli_belum_complete_daftar');

            // return response()->json($result);

            return view($view, $result);

        }

        if($user->id_level == '2') $view = 'company.homeCompany';
        if($user->id_level == '3') return redirect('/homeManPower');
        return view($view, compact('data'));
    }


    public function dashboard(Request $request){

        return view('dashboard');

    }

    public function getRecentRegisterAhli(Request $request) {

        if ($request->filter) {
            $filter = $request->filter;
        }

        $data = DetailManpower::select('id_user', 'id_detail_manpower', 'id_detail_company', 'ic_number' , 'id_city', 'id_village_guests', 'step_registration', 'created_at')->with([
                'user' => function($query){
                    $query->select('id','fullname','phone_number', 'email', 'is_verified', 'registered_by');
                },
                'city' => function($query){
                    $query->select('id_city', 'city');
                },
            ])
            // ->where('step_registration', '!=', DetailManpower::$stepRegistration)
            ->orderBy('created_at', 'DESC');

        if($filter == "today"){
            $data = $data->whereDate('created_at', date('Ymd'));
        }
        else if ($filter == "week"){

            Carbon::setWeekStartsAt(CarbonInterface::SUNDAY);
            Carbon::setWeekEndsAt(CarbonInterface::SATURDAY);

            $data = $data->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ]);
        }
        else if($filter == "month"){
            $data = $data->whereMonth('created_at', Carbon::today()->month)->whereYear('created_at', Carbon::today()->year);
        }

        $data = $data->get();

        foreach ($data as $d) {
            $d->id_village_guests = json_decode($d->id_village_guests);
            $d->village_guest = null;
            $d->created_date = Carbon::parse($d->created_at)->format('d-m-Y');
            $d->created_time = Carbon::parse($d->created_at)->format('H:i:s');
            if ($d->id_village_guests != null) {
                $village_name = [];
                foreach ($d->id_village_guests as $item) {
                    $village_data = VillageGuests::where('id', $item)->first();
                    if ($village_data) {
                        $village_name[] = $village_data->village_guests;
                    }
                }
                $d->village_guest = $village_name;
            }
        }

        return Datatables::of($data)->addIndexColumn()->make(true);


        // return $data;


    }

    public function getStatsRegisterAhli(Request $request){

        $ahli = DetailManpower::where('step_registration', DetailManpower::$stepRegistration);

        $labels = [];
        $data = [];

        if (isset($request->filter)) {

            $filter = $request->filter;
            $startYear = 2023;
            $thisYear = Carbon::today()->year;
            $thisMonth = Carbon::today()->month;
            $daysInMonth = Carbon::now()->daysInMonth;

            if ($filter == "Daily") {

                for($i=1;$i<=$daysInMonth;$i++) {
                    $labels[]= date_format(date_create("$thisYear-$thisMonth-$i"), "d-m-Y");
                    $data[]= DetailManpower::where('step_registration', DetailManpower::$stepRegistration)->where('created_at', 'like', date_format(date_create("$thisYear-$thisMonth-$i"), "Y-m-d") .'%')->count();
                }

            } else if ($filter == "Weekly") {


                $ahli = $ahli->whereBetween('created_at', [Carbon::now()->subWeek()->format("Y-m-d H:i:s"), Carbon::now()]);

            } else if ($filter == "Monthly") {

                $labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

                for($i=1;$i<=12;$i++) {
                    $data[]= DetailManpower::where('step_registration', DetailManpower::$stepRegistration)->whereMonth('created_at', $i)->whereYear('created_at', $thisYear)->count();
                }


            } else if ($filter == "Yearly") {

                for($i=$startYear;$i<=$thisYear;$i++) {
                    $labels[]= $i;
                    $data[]= DetailManpower::where('step_registration', DetailManpower::$stepRegistration)->whereYear('created_at', $i)->count();

                }

            }

        }

        $datasetsAhli = [
                        'label' => 'Ahli',
                        'backgroundColor' => 'rgba(220,54,69,1)',
                        'borderColor' => 'rgba(220,54,69,1)',
                        'pointRadius' => false,
                        'pointColor' => '#000000',
                        'pointStrokeColor' => 'rgba(220,54,69,1)',
                        'pointHighlightFill' => '#fff',
                        'pointHighlightStroke' => 'rgba(220,54,69,1)',
                        'data' => $data,
                    ];

        $result = [
                        'labels' => $labels,
                        'datasets' => [$datasetsAhli],
                    ];

        return $result;

    }
}
