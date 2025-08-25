<?php

namespace App\Http\Controllers;

use App\Models\BusinessActivity;
use App\Models\SubBusinessActivity;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\CompanyShareHolders;
use App\Models\TempCompanyShareHolders;
use App\Models\DetailCompany;
use App\Models\ManpowerPosition;
use App\Models\Position;
use App\Models\DetailManpower;
use App\Models\StatusNative;
use App\Models\City;
use App\Models\JoinCompany;
use App\Models\VillageGuests;
use App\Imports\AhliImport;
use Illuminate\Support\Facades\Log;
use Redirect;
use DB;
// use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class SenaraiAhliController extends Controller
{
    //tes

    public function index(Request $request)
    {

        $user = Auth::user();

        if($user->sub_company != null){
            $id_user = $user->sub_company;
            $dataValidation = User::findOrFail($id_user);
        } else {
            $dataValidation = User::findOrFail($user->id);
            $id_user = $user->id;
        }

        if($request->id_user) {
            $id_user = $request->id_user;
        }

        $detail = null;
        if ($user->id_level == "2" || $request->id_user) {
            // return 'tes';
            $detail = DetailCompany::where('id_user', $id_user)->first();
            // return $detail;
        }

        $city = City::where('is_active', 'ENABLE');

        if ($user->id_level == "6" || $user->id_level == "4") {
            $city = $city->where('id_state', $user->id_state);
        }

        $city = $city->get();

        $status_native = StatusNative::where('is_active', 'ENABLE')->get();
        $business_activity = BusinessActivity::where('is_active', 'ENABLE')->get();
        $pegawai_daerah = User::where('status', 'ACTIVE')->where('id_level', 4)->get();
        $persatuan = User::where('status', 'ACTIVE')->where('id_level', '2')->get();

        return view('company.senaraiAhli.index', compact('dataValidation','city', 'status_native', 'business_activity', 'pegawai_daerah', 'persatuan', 'detail'));
    }

    public function import(Request $request)
    {
        try {
            $import = new AhliImport;

            // Import file Excel
            Excel::import($import, $request->file('file'));

            // Cek apakah ada row yang gagal
            if (!empty($import->failedRows)) {
                $errors = collect($import->failedRows)
                    ->map(function($f) {
                        return "Row {$f['row']}: {$f['reason']}";
                    })->toArray();

                return redirect()->back()->with('import_errors', $errors);
            }

            return redirect()->back()->with('success', 'Ahli imported successfully!');

        } catch (\Exception $ex) {
            // Tangani error global dari Excel atau lainnya
            Log::error('Import failed: ' . $ex->getMessage());
            return redirect()->back()->with('error', 'Import gagal! Sila periksa file atau data Anda.');
        }
    }


    public function activateCompanyCard(Request $request)
    {

        $manpower = \App\Models\DetailManpower::where('id_detail_manpower', $request->id_detail_manpower)->first();

        if(!$manpower) {
            $response = ['isSuccess' => false, 'message' => "Failed"];
            return response()->json($response);
        }

        $now = date('Y-m-d H:i:s');

        $manpower->payment_kad_digital = $now;
        $manpower->kad_digital = "TRUE";
        $manpower->save();

        if ($manpower) {
            $response = ['isSuccess' => true, 'message' => "Activate succesfuly"];
        } else {
            $response = ['isSuccess' => false, 'message' => "Failed"];
        }

        return response()->json($response);

    }

    // public function getData(Request $request)
    // {

    //     if($request->filter){
    //         $filter = $request->filter;
    //     }

    //     $user = Auth::user();

    //     $id_user = $user->id;

    //     if($request->id_user) {
    //         $id_user = $request->id_user;
    //     }

    //     if ($user->id_level == "2" || $request->id_user) {
    //         $detail = DetailCompany::where('id_user', $id_user)->first();
    //     }


    //     // $data = JoinCompany::with(['manpower' => function($query) {
    //     //         $query->select('id_user', 'id_detail_manpower', 'id_detail_company', 'ic_number', 'step_registration', 'native_status', 'business_license_no', 'business_type', 'kad_digital', 'payment_kad_digital');
    //     // }, 'company' => function($query) {
    //     //         $query->select('id_detail_company', 'full_company_name');
    //     // }, 'manpower.user' => function($query) {
    //     //         $query->select('id','fullname','phone_number', 'email', 'is_verified', 'registered_by');
    //     // }, 'manpower.status_native' => function($query) {
    //     //         $query->select('id_status_native', 'status_native');
    //     // }, 'manpower.business_type_text' => function($query) {
    //     //         $query->select('id_business_type', 'business_type');
    //     // }])->whereDate('expired_at', '>', date('Y-m-d'))->orderBy('created_at', 'DESC');

    //     // return $data->get();

    //     // whereDate('expired_at', '>', date('Y-m-d'))


    //     $data = DetailManpower::select('id_user', 'id_detail_manpower', 'id_detail_company', 'ic_number', 'step_registration', 'native_status', 'business_license_no', 'business_type', 'business_activity', 'sub_business_activity', 'kad_digital', 'payment_kad_digital', 'subscribe_status', 'is_subscribe')->with([
    //             'user' => function($query){
    //                 $query->select('id','fullname','phone_number', 'email', 'is_verified', 'registered_by');
    //             },
    //             'company' => function($query){
    //                 $query->select('id_detail_company', 'full_company_name');
    //             },
    //             'status_native' => function($query){
    //                 $query->select('id_status_native', 'status_native');
    //             },
    //             'business_type_text' => function($query){
    //                 $query->select('id_business_type', 'business_type');
    //             },
    //             'business_activity_text' => function($query){
    //                 $query->select('id_business_activity', 'business_activity');
    //             },
    //         ])->orderBy('created_at', 'DESC');


    //     $status = $request->status;
    //     $license = $request->license;

    //     // return compact('status', 'license');

    //     if($status == "Overall") {
    //         // $data = $data->whereHas('manpower', function($query) use($status) {
    //         //     $query->where('step_registration', DetailManpower::$stepRegistration);
    //         // });
    //         $data = $data->where('step_registration', DetailManpower::$stepRegistration);
    //     }

    //     if($status == "Expired") {
    //         // $data = $data->whereHas('manpower', function($query) use($status) {
    //         //     $query->where('certificate_expired_date', '<', now());
    //         // });
    //         $data = $data->whereDate('certificate_expired_date', '<', now());
    //     }

    //     // return compact('status');


    //     // return compact('cek');

    //     if($status != "Overall" && $status != "Unfiltered" && $status != "Expired" && $status != "") {

    //         // $data = $data->whereHas('manpower.user', function($query) use($status) {
    //         //     $query->where('status', $status);
    //         // })->whereHas('manpower', function($query) {
    //         //     $query->where('step_registration', DetailManpower::$stepRegistration);
    //         // })->whereDate('expired_at', '>', now());

    //         $data = $data->whereHas('user', function($query) use($status) {
    //             $query->where('status', $status);
    //         })->whereDate('certificate_expired_date', '>', now())->where('step_registration', DetailManpower::$stepRegistration);

    //     }

    //     if($user->id_level == 4) {

    //         if($user->id_city != null) {
    //             // $data = $data->whereHas('manpower', function($query) use($user) {
    //             //     $query->where('id_city', $user->id_city);
    //             // });
    //             $data = $data->where('id_city', $user->id_city);
    //         } else {
    //             // $data = $data->whereHas('manpower', function($query) use($user) {
    //             //     $query->where('id_city', 0);
    //             // });
    //             $data = $data->where('id_city', 0);
    //         }


    //     }

    //     if($user->id_level == 6) {
    //         // $data = $data->whereHas('manpower', function($query) use($user) {
    //         //     $query->where('id_state', $user->id_state);
    //         // });
    //         $data = $data->where('id_state', $user->id_state);
    //     }

    //     if($request->id_city) {
    //         // $data = $data->whereHas('manpower', function($query) use($user) {
    //         //     $query->where('id_city', $user->id_city);
    //         // });
    //         $data = $data->where('id_city', $request->id_city);
    //     }

    //     if($request->fullname == "true") {

    //         $data = $data->whereHas('user', function($query) {
    //             $query->whereIn('id', function($query) {
    //                 $query->select('id')->from('users')->groupBy('fullname')->havingRaw('count(*) > 1');
    //             });
    //         })->get();

    //         $temp_id = [];

    //         foreach($data as $d) {

    //             $check_user = User::where('fullname', $d->user->fullname)->get();

    //             foreach($check_user as $d) {
    //                 $temp_id[] = $d->id;
    //             }

    //         }

    //         // return $temp_id;

    //         $data = DetailManpower::select('id_user', 'id_detail_manpower', 'id_detail_company', 'ic_number', 'step_registration', 'native_status', 'is_subscribe', 'certificate_expired_date')->with([
    //             'user' => function($query){
    //                 $query->select('id','fullname','phone_number', 'email', 'is_verified', 'registered_by');
    //             },
    //             'company' => function($query){
    //                 $query->select('id_detail_company', 'full_company_name');
    //             },
    //             'status_native' => function($query){
    //                 $query->select('id_status_native', 'status_native');
    //             }
    //         ])->whereIn('id_user', $temp_id);

    //     }

    //     if($request->ic_number == "true") {
    //         $ic_number = $request->ic_number;
    //         // $data = $data->whereHas('manpower', function($query) use($ic_number) {
    //         //     $query->where('ic_number', $ic_number);
    //         // });
    //         $data = $data->where('ic_number', $ic_number);
    //     }

    //     if($request->phone_number == "true") {
    //         $phone_number = $request->phone_number;
    //         $data = $data->whereHas('user', function($query) use($phone_number) {
    //             $query->where('phone_number', $phone_number);
    //         });
    //     }

    //     if($request->email == "true") {
    //         $email = $request->email;
    //         $data = $data->whereHas('user', function($query) use($email) {
    //             $query->where('email', $email);
    //         });
    //     }

    //     if($license == "No") {
    //         // $data = $data->whereHas('manpower', function($query) {
    //         //     $query->where('business_license_no', NULL);
    //         // });
    //         $data = $data->where('business_license_no', NULL);
    //     }

    //     // return compact('filter');

    //     if($filter == "today"){
    //         // $data = $data->whereHas('manpower', function($query) {
    //         //     $query->whereDate('created_at', date('Ymd'));
    //         // });
    //         $data = $data->whereDate('created_at', date('Ymd'));
    //     } else if($filter == "month"){
    //         // $data = $data->whereHas('manpower', function($query) {
    //         //     $query->whereMonth('created_at', Carbon::today()->month)->whereYear('created_at', Carbon::today()->year);
    //         // });
    //         $data = $data->whereMonth('created_at', Carbon::today()->month)->whereYear('created_at', Carbon::today()->year);
    //     } else if($filter == "year"){
    //         // $data = $data->whereHas('manpower', function($query) {
    //         //     $query->whereYear('created_at', Carbon::today()->year);
    //         // });
    //         $data = $data->whereYear('created_at', Carbon::today()->year);
    //     }

    //     if($request->q){

    //         $q = $request->q;

    //         $data = $data->whereHas('user', function($query) use($q){
    //             $query->where('fullname', 'LIKE', '%' . $q . '%');
    //             $query->orWhere('email', 'LIKE', '%' . $q . '%');
    //             $query->orWhere('phone_number', 'LIKE', '%' . $q . '%');
    //         });
    //     }

    //     // return $request->id_user;

    //     if ($user->id_level == 2 || $request->id_user) {
    //         // $data = $data->where('id_detail_company', 'LIKE', '%'.$detail->id_detail_company.'%')->get();
    //         $data = $data->where('id_detail_company', 'LIKE', '%'.$detail->id_detail_company.'%')->get();
    //     } else {
    //         $data = $data->get();
    //     }

    //     // return compact('data');

    //     foreach($data as $d){

    //         $d->ref = Crypt::encryptString($d->id_user);

    //         if($status == "Expired") {
    //             $d->subscribe_status = "EXPIRED";
    //         }

    //         $d->status_native_text = isset($d->status_native) ? $d->status_native->status_native : '';

    //         if($d->payment_date == null){
    //             $d->invoice = 'UNPAID';
    //         } else if($d->expired_at > date('Y-m-d')) {
    //             $d->invoice = 'PAID';
    //         } else {
    //             $d->invoice = 'EXPIRED';
    //         }

    //         $d->persatuan = isset($d->id_detail_company) ? isset($d->company->full_company_name) ? $d->company->full_company_name : '' : 'Tiada Persatuan';
    //         if(isset($d->user->registered_by))
    //             $d->registered_by_name = User::where('id', $d->user->registered_by)->first()->fullname;
    //         else
    //             $d->registered_by_name = '';

    //     }

    //     // return $data;

    //     return Datatables::of($data)->addIndexColumn()->make(true);

    // }

    public function getData(Request $request)
    {
        $filter = $request->filter ?? null;
        $status = $request->status;
        $license = $request->license;

        $user = Auth::user();
        $id_user = $request->id_user ?? $user->id;

        if ($user->id_level == "2" || $request->id_user) {
            $detail = DetailCompany::where('id_user', $id_user)->first();
        }
        $data = DetailManpower::select(
            'id_user', 'id_detail_manpower', 'id_detail_company', 'ic_number', 'step_registration',
            'native_status', 'business_license_no', 'business_type', 'business_activity',
            'sub_business_activity', 'kad_digital', 'payment_kad_digital', 'subscribe_status', 'is_subscribe'
        )->with([
            'user:id,fullname,phone_number,email,is_verified,registered_by',
            'company:id_detail_company,full_company_name',
            'status_native:id_status_native,status_native',
            'business_type_text:id_business_type,business_type',
            'business_activity_text:id_business_activity,business_activity',
        ])->orderBy('created_at', 'DESC');

        // Filter berdasarkan status
        if ($status == "Overall") {
            $data->where('step_registration', DetailManpower::$stepRegistration);
        }

        if ($status == "Expired") {
            $data->whereDate('certificate_expired_date', '<', now());
        }

        if (!in_array($status, ["Overall", "Unfiltered", "Expired", ""])) {
            $data->whereHas('user', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->whereDate('certificate_expired_date', '>', now())
            ->where('step_registration', DetailManpower::$stepRegistration);
        }

        if ($user->id_level == 6 || $user->id_level == 4) {
            $data->where('id_state', $user->id_state);
        }

        // Filter berdasarkan inputan request
        if ($request->id_city) {
            $data->where('id_city', $request->id_city);
        }

        // Filter untuk fullname ganda
        if ($request->fullname == "true") {
            $duplicateUsers = DetailManpower::whereHas('user', function ($query) {
                $query->whereIn('id', function ($q) {
                    $q->select('id')->from('users')->groupBy('fullname')->havingRaw('count(*) > 1');
                });
            })->get();

            $temp_id = [];

            foreach ($duplicateUsers as $d) {
                $check_user = User::where('fullname', $d->user->fullname)->get();
                foreach ($check_user as $dupe) {
                    $temp_id[] = $dupe->id;
                }
            }

            $data = DetailManpower::select(
                'id_user', 'id_detail_manpower', 'id_detail_company', 'ic_number',
                'step_registration', 'native_status', 'is_subscribe', 'certificate_expired_date'
            )->with([
                'user:id,fullname,phone_number,email,is_verified,registered_by',
                'company:id_detail_company,full_company_name',
                'status_native:id_status_native,status_native',
            ])->whereIn('id_user', $temp_id);
        }

        if ($request->ic_number == "true") {
            $data->where('ic_number', $request->ic_number);
        }

        if ($request->phone_number == "true") {
            $data->whereHas('user', function ($query) use ($request) {
                $query->where('phone_number', $request->phone_number);
            });
        }

        if ($request->email == "true") {
            $data->whereHas('user', function ($query) use ($request) {
                $query->where('email', $request->email);
            });
        }

        if ($license == "No") {
            $data->whereNull('business_license_no');
        }

        // Filter berdasarkan tanggal (today / month / year)
        if ($filter == "today") {
            $data->whereDate('created_at', date('Ymd'));
        } elseif ($filter == "month") {
            $data->whereMonth('created_at', Carbon::today()->month)
                ->whereYear('created_at', Carbon::today()->year);
        } elseif ($filter == "year") {
            $data->whereYear('created_at', Carbon::today()->year);
        }

        // Search query
        if ($request->q) {
            $q = $request->q;
            $data->whereHas('user', function ($query) use ($q) {
                $query->where('fullname', 'LIKE', "%$q%")
                    ->orWhere('email', 'LIKE', "%$q%")
                    ->orWhere('phone_number', 'LIKE', "%$q%");
            });
        }

        // Data fetch: khusus level tertentu
        if ($user->id_level == 2 || $request->id_user) {
            $data = $data->where('id_detail_company', 'LIKE', '%' . $detail->id_detail_company . '%')->get();
        } else {
            $data = $data->get();
        }

        // Format data hasil akhir
        foreach ($data as $d) {
            $d->ref = Crypt::encryptString($d->id_user);

            if ($status == "Expired") {
                $d->subscribe_status = "EXPIRED";
            }

            $d->status_native_text = $d->status_native->status_native ?? '';

            if ($d->payment_date == null) {
                $d->invoice = 'UNPAID';
            } elseif ($d->expired_at > date('Y-m-d')) {
                $d->invoice = 'PAID';
            } else {
                $d->invoice = 'EXPIRED';
            }

            $d->persatuan = $d->company->full_company_name ?? 'Tiada Persatuan';

            // ✅ Null-safe untuk registered_by
            $d->registered_by_name = User::find($d->user?->registered_by)?->fullname ?? '';
        }


        return DataTables::of($data)->addIndexColumn()->make(true);
    }

    public function getDataAhliPersatuan(Request $request)
    {

        if($request->filter){
            $filter = $request->filter;
        }

        $user = Auth::user();

        if($user->sub_company != null){
            $id_user = $user->sub_company;
        } else {
            $id_user = $user->id;
        }

        if($request->id_user) {
            $id_user = $request->id_user;
        }

        if ($user->id_level == "2" || $request->id_user) {
            $detail = DetailCompany::where('id_user', $id_user)->first();
        }

        $data = JoinCompany::with(['manpower' => function($query) {
                $query->select('id_user', 'id_detail_manpower', 'id_detail_company', 'ic_number', 'step_registration', 'native_status', 'business_license_no', 'business_type', 'kad_digital', 'payment_kad_digital');
        }, 'company' => function($query) {
                $query->select('id_detail_company', 'full_company_name');
        }, 'manpower.user' => function($query) {
                $query->select('id','fullname','phone_number', 'email', 'is_verified', 'registered_by');
        }, 'manpower.status_native' => function($query) {
                $query->select('id_status_native', 'status_native');
        }, 'manpower.business_type_text' => function($query) {
                $query->select('id_business_type', 'business_type');
        }])->where('id_detail_company', $detail->id_detail_company)->whereDate('expired_at', '>', date('Y-m-d'))->orderBy('created_at', 'DESC');
        
        $status = $request->status;
        $license = $request->license;

        if($status == "Overall") {
            $data = $data->whereHas('manpower', function($query) use($status) {
                $query->where('step_registration', DetailManpower::$stepRegistration);
            });
        }

        if($status != "Overall" && $status != "Unfiltered" && $status != "") {
            $data = $data->whereHas('manpower.user', function($query) use($status) {
                $query->where('status', $status);
            })->where('step_registration', DetailManpower::$stepRegistration);

        }

        if($request->id_city) {
            $id_city = $request->id_city;
            $data = $data->whereHas('manpower', function($query) use($id_city) {
                $query->where('id_city', $id_city);
            });
            // $data = $data->where('id_city', $request->id_city);
        }

        if($license == "No") {
            $data = $data->whereHas('manpower', function($query) use($license) {
                $query->where('business_license_no', NULL);
            });

            // $data = $data->where('business_license_no', NULL);
        }

        if($request->filter){
            if($filter == "today"){
                $data = $data->whereHas('manpower', function($query) {
                    $query->whereDate('created_at', date('Ymd'));
                });
            } else if($filter == "month"){
                $data = $data->whereHas('manpower', function($query) {
                    $query->whereMonth('created_at', Carbon::today()->month)->whereYear('created_at', Carbon::today()->year);
                });
            } else if($filter == "year"){
                $data = $data->whereHas('manpower', function($query) {
                    $query->whereYear('created_at', Carbon::today()->year);
                });
            }
        }

        if($request->q){

            $q = $request->q;

            $data = $data->whereHas('manpower.user', function($query) use($q){
                $query->where('fullname', 'LIKE', '%' . $q . '%');
                $query->orWhere('email', 'LIKE', '%' . $q . '%');
                $query->orWhere('phone_number', 'LIKE', '%' . $q . '%');
            });
        }

        $data = $data->get();

        foreach($data as $d){
            $d->ref = Crypt::encryptString($d->id_user);
            $d->manpower->status_native_text = isset($d->manpower->status_native) ? $d->manpower->status_native->status_native : '';
            if($d->payment_date == null){
                $d->invoice = 'UNPAID';
            } else if($d->expired_at > date('Y-m-d')) {
                $d->invoice = 'PAID';
            } else {
                $d->invoice = 'EXPIRED';
            }

            $d->persatuan = isset($d->id_detail_company) ? isset($d->company->full_company_name) ? $d->company->full_company_name : '' : 'Tiada Persatuan';
            if($d->manpower->user->registered_by)
                $d->registered_by_name = User::where('id', $d->manpower->user->registered_by)->first()->fullname;
            else
                $d->registered_by_name = '';

        }

        return Datatables::of($data)->addIndexColumn()->make(true);

    }

    public function store(Request $request)
    {

        $user = Auth::user();

        $cek_email = User::where('email', $request->email)->first();

        if($cek_email) {
            return redirect()->back()->with('failed','Email already exist!');
        }

        $cek_phone = User::where('phone_number', $request->phone_number)->first();

        if($cek_phone) {
            return redirect()->back()->with('failed','Phone Number already exist!');
        }

        $cek_ic_number = DetailManpower::where('ic_number', $request->ic_number)->first();

        if($cek_ic_number) {
            return redirect()->back()->with('failed','IC Number already exist!');
        }


        $data = new User();
        $data->fullname = $request->fullname;
        $data->phone_number = $request->phone_number;
        $data->email = $request->email;
        $data->id_level = '3';
        $data->email_verified_at = now();
        $data->is_verified = 1;
        $data->password = Hash::make($request->password);
        $data->registered_by = $user->id;

        // $data->id_position = $request->id_position;
        // $data->date_appointment = $request->date_appointment;

        $data->save();

        $detail = new DetailManpower();
        $detail->id_user = $data->id;
        if($user->id_level == 4) {
            $detail->id_pegawai_daerah = $user->id;
        } else {
            $detail->id_pegawai_daerah = $request->pegawai_daerah;
        }


        if($user->id_level == 2) {

            $company = DetailCompany::where('id_user', $user->id)->first();
            $detail->id_detail_company = $company->id_detail_company;

        }

        $detail->ic_number = $request->ic_number;
        $detail->native_status = $request->native_status;
        $detail->is_subscribe = $request->invoice == 'PAID' ? 'TRUE' : 'FALSE';
        $detail->subscribe_status = $request->invoice == 'PAID' ? 'APPROVED' : 'UNPAID';

        $detail->save();

        return redirect()->back()->with('success','Created successfully');


    }

    public function edit($id, Request $r)
    {
        $data = DetailManpower::with('user')->where('id_detail_manpower', $id)->first();

        if(isset($data->id_state)){
            $has_state = true;
            $village_guests = VillageGuests::where('is_active', 'ENABLE')->where('id_state', $data->id_state)->get();
        } else {
            $has_state = false;
            $village_guests = null;
        }

        $sub_business_activity = SubBusinessActivity::where('is_active', 'ENABLE')->get();

        $data_manpower_position = ManpowerPosition::where('id_user', $data->id_user)->first();
        $data->invoice = $data->is_subscribe == 'TRUE' ? 'PAID' : 'UNPAID';
        $data->has_state = $has_state;
        $data->village_guest = $village_guests;
        $data->sub_business_activity_list = $sub_business_activity;
        $data->id_village_guests = json_decode($data->id_village_guests);
        $data->id_sub_business_activity = json_decode($data->sub_business_activity);
        $data->id_position = $data_manpower_position && $data_manpower_position->id_position !== null
        ? (int) $data_manpower_position->id_position
        : null;
        // $data->created_date = date('Y-m-d H:i:s', strtotime($data->created_at));

        return response()->json([
            'success'=>'Get data successfully',
            'data'=>$data
            ]);
        // return view('admin.settingsPosition.index', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $auth = Auth::user();

        // Ambil detail manpower berdasarkan ID
        $detail = DetailManpower::where('id_detail_manpower', $id)->first();
        if (!$detail) {
            return response()->json([
                'newToken' => csrf_token(),
                'message' => 'Detail manpower not found!',
                'data' => null
            ]);
        }

        // Ambil user terkait
        $data = User::find($detail->id_user);
        if (!$data) {
            return response()->json([
                'newToken' => csrf_token(),
                'message' => 'User data not found!',
                'data' => null
            ]);
        }

        // ================================
        //  Validasi unik untuk Email
        // ================================
        if ($request->email !== $data->email) {
            $cekEmail = User::where('email', $request->email)->exists();
            if ($cekEmail) {
                return response()->json([
                    'newToken' => csrf_token(),
                    'message' => 'Email already exists!',
                    'data' => null
                ]);
            }
        }

        // ================================
        //  Validasi unik untuk Phone Number
        // ================================
        if ($request->phone_number !== $data->phone_number) {
            $cekPhone = User::where('phone_number', $request->phone_number)->exists();
            if ($cekPhone) {
                return response()->json([
                    'newToken' => csrf_token(),
                    'message' => 'Phone Number already exists!',
                    'data' => null
                ]);
            }
        }

        // ================================
        //  Validasi unik untuk IC Number
        // ================================
        if ($request->ic_number !== $detail->ic_number) {
            $cekIcNumber = DetailManpower::where('ic_number', $request->ic_number)->exists();
            if ($cekIcNumber) {
                return response()->json([
                    'newToken' => csrf_token(),
                    'message' => 'IC Number already exists!',
                    'data' => null
                ]);
            }
        }

        // ================================
        //  Update data User
        // ================================
        $data->fullname = $request->fullname;
        $data->phone_number = $request->phone_number;
        $data->email = $request->email;

        // ================================
        //  Update data DetailManpower
        // ================================
        if ($request->persatuan && $request->persatuan !== '0') {
            $detail->id_detail_company = $request->persatuan;
        }

        $detail->ic_number = $request->ic_number;
        $detail->native_status = $request->native_status;
        $detail->business_activity = $request->business_activity;
        $detail->id_village_guests = $request->village_guests;
        $detail->sub_business_activity = $request->sub_business_activity;

        // Set status subscription
        $isPaid = $request->invoice === 'PAID';
        $detail->is_subscribe = $isPaid ? 'TRUE' : 'FALSE';
        $detail->subscribe_status = $isPaid ? 'APPROVED' : 'UNPAID';

        if ($auth->id_level == 1) {
            $detail->status_approval_admin_pusat = $request->status;
            if($request->status == 'APPROVE') {
                $detail->approve_at_admin_pusat = now();
            }else{
                $detail->approve_at_admin_pusat = null;
            }
        }

        // Simpan perubahan
        $detail->save();
        $data->save();

        // ================================
        //  Update atau buat posisi Manpower
        // ================================
        $manPowerPosition = ManpowerPosition::firstOrNew(['id_user' => $data->id]);
        $manPowerPosition->id_company = $data->id; // Jika memang id_company = id user
        $manPowerPosition->id_position = (int) $request->id_position;
        $manPowerPosition->date_appointment = now();
        $manPowerPosition->save();

        return response()->json([
            'newToken' => csrf_token(),
            'success' => 'Update Data Successfully',
            'data' => $data
        ]);
    }

    public function updateFactory(Request $request)
    {

        $user = Auth::user();

        $detail = DetailManpower::where('id_user', $user->id)->first();

        $detail->factory_address = $request->factory_address;
        $detail->factory_lat = $request->place_latitude;
        $detail->factory_lng = $request->place_longitude;

        $detail->save();

        return redirect('/maklumatProduk')->with('success', 'Maklumat Kilang berhasil diupdate');

    }

    public function updateHalal(Request $request)
    {

        $user = Auth::user();

        $detail = DetailManpower::where('id_user', $user->id)->first();

        if($request->hasFile('img_halal')){
            $file = $request->file('img_halal');
            $n = $file->getClientOriginalName();
            $current_date = date('Ymdhis');
            $name = "$current_date$n";
            $file->move(public_path().'/halalCertificate',$name);
            $image = $name;
        }else{
            $image = 'default.png';
        }

        // return $image;

        $detail->halal_certificate = $image;
        $detail->halal_certificate_number = $request->halal_certificate_number;
        $detail->halal_certificate_date = $request->halal_certificate_date;

        $detail->save();

        return redirect('/maklumatProduk')->with('success', 'Maklumat Halal berhasil diupdate');

    }

    public function updateGmp(Request $request)
    {

        $user = Auth::user();

        $detail = DetailManpower::where('id_user', $user->id)->first();

        if($request->hasFile('img_gmp')){
            $file = $request->file('img_gmp');
            $n = $file->getClientOriginalName();
            $current_date = date('Ymdhis');
            $name = "$current_date$n";
            $file->move(public_path().'/gmpCertificate',$name);
            $image = $name;
        }else{
            $image = 'default.png';
        }

        $detail->gmp_certificate = $image;
        $detail->gmp_certificate_number = $request->gmp_certificate_number;
        $detail->gmp_certificate_date = $request->gmp_certificate_date;

        $detail->save();

        return redirect('/maklumatProduk')->with('success', 'Maklumat GMP berhasil diupdate');

    }


    public function updateKkm(Request $request)
    {

        $user = Auth::user();

        $detail = DetailManpower::where('id_user', $user->id)->first();

        if($request->hasFile('img_kkm')){
            $file = $request->file('img_kkm');
            $n = $file->getClientOriginalName();
            $current_date = date('Ymdhis');
            $name = "$current_date$n";
            $file->move(public_path().'/kkmCertificate',$name);
            $image = $name;
        }else{
            $image = 'default.png';
        }

        $detail->kkm_certificate = $image;
        $detail->kkm_certificate_number = $request->kkm_certificate_number;
        $detail->kkm_certificate_date = $request->kkm_certificate_date;

        $detail->save();

        return redirect('/maklumatProduk')->with('success', 'Maklumat KKM berhasil diupdate');

    }

    public function destroy($id){

        $user = User::where('id', $id)->first();
        $data = DetailManpower::where('id_user', $user->id)->first();

        $user->delete();
        $data->delete();

        // return $data;


        return response()->json([
            'newToken' => csrf_token(),
            'isSuccess' => true,
            'success'=>'Senarai Ahli deleted successfully!',
            'data'=>$data
            ]);

        // return response()->json(['success'=>'Senarai Ahli deleted successfully']);
    }

    public function temp_destroy($id){

        $data = TempCompanyShareHolders::where('id_temp_company_shareholders', $id)->first();
        $data->delete();

        return response()->json(['success'=>'Cancel update successfully']);
    }

}
