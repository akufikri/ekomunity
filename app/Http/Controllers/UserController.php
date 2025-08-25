<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\City;
use App\Models\State;
use App\Models\Certifikat;
use App\Models\Country;
use App\Models\DetailCompany;
use App\Models\PublishedCertificate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        if ($request->ajax()) {
            $id_level = $request->id_level;
            $data = User::with('level');

            if ($id_level == '2') {
                $data = $data->with(['company.city', 'company.state', 'company.country'])->where('id_level', 2);
            }

            if ($id_level == 4) {
                if ($id_level && $id_level != '4') {
                    return DataTables::of(collect([]))->addIndexColumn()->make(true);
                }
                $data = $data->where('id_level', 4);
            } else {
                if ($id_level && $id_level != '2') {
                    $data = $data->where('id_level', $id_level);
                }
            }

            if ($id_level == 6) {
                $data = $data->whereHas('city', function ($query) use ($user) {
                    $query->where('id_state', $user->id_state);
                });
            }

            $data = $data->latest()->get();

            foreach ($data as $d) {
                $d->city_name = null;
                $d->state_name = null;
                $d->country_name = null;
                $d->nama_ketua_bahagian = null;

                if ($d->company) {
                    $d->city_name = $d->company->city->city ?? null;
                    $d->state_name = $d->company->state->state ?? null;
                    $d->country_name = $d->company->country->country_name ?? null;

                    // Ambil nama ketua bahagian untuk level 2
                    if ($id_level == '2' && $d->company->id_bahagian) {
                        $ketuaBahagian = User::find($d->company->id_bahagian);
                        if ($ketuaBahagian) {
                            $d->nama_ketua_bahagian = $ketuaBahagian->fullname;
                        } else {
                            $d->nama_ketua_bahagian = '-';
                        }
                    } else {
                        $d->nama_ketua_bahagian = '-';
                    }
                } elseif ($d->id_city) {
                    $d->city_name = City::where('id_city', $d->id_city)->first()->city;
                }

                if ($d->id_state) {
                    $d->state_name = State::where('id_state', $d->id_state)->first()->state;
                }

                $d->create_date = date('d-m-Y H:i:s', strtotime($d->created_at));
            }

            return DataTables::of($data)->addIndexColumn()->make(true);
        }

        $country    = Country::where('is_active', 'ENABLE')->get();
        $city       = City::where('is_active', 'ENABLE')->get();
        $state      = State::where('is_active', 'ENABLE')->get();
        $id_level   = $request->id_level;

        return view('users.index', compact('state', 'city', 'country', 'user', 'id_level'));
    }
    public function store(Request $request)
    {
        $auth = Auth::user();
        $user = new User;

        $email = $request->email;
        $em = User::where('email', $email)->first();

        if ($em) {
            return redirect()->back()->with('failed', 'Emel anda sudah digunakan, sila guna emel lain');
        }

        $user->fullname = $request->fullname;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->id_level = $request->filter_level;
        $user->email_verified_at = now();
        $user->is_verified = 1;
        $user->password = Hash::make($request->password);

        if ($request->filter_level == '4' || $request->filter_level == 4) {
            $user->id_city = $request->city;
            $user->no_ros = $request->no_ros;
            $user->kod_bahagian = $request->kod_bahagian;
            $user->status_ros = $request->status_ros;
        } elseif ($request->filter_level == '2' || $request->filter_level == 2) {
            $user->id_city = $request->id_city;
            $user->no_ros = $request->no_ros;
            $user->kod_cawangan = $request->kod_cawangan;
            $user->status_ros = $request->status_ros;
        }

        // Set id_state untuk level 6
        if ($request->filter_level == '6' || $request->filter_level == 6) {
            $user->id_state = $request->state;
        }

        // Simpan user terlebih dahulu
        $user->save();

        // Handle Certificate untuk level 6 (Ketua Negeri)
        if ($request->filter_level == '6' || $request->filter_level == 6) {
            $cekData = Certifikat::where('id_state', $user->id_state)->first();
            if (!$cekData) {
                $settingsCertificate = new Certifikat();
                $settingsCertificate->id_state = $user->id_state;
                $settingsCertificate->logo_1 = "default.png";
                $settingsCertificate->logo_2 = "default.png";
                $settingsCertificate->sign_picture = "default.png";
                $settingsCertificate->sign_name = "-";
                $settingsCertificate->sign_position = "-";
                $settingsCertificate->valid_time = 1;
                $settingsCertificate->watermark_image = "watermark.png";
                $settingsCertificate->save();
            }
        }

        // Handle Detail Company untuk level 2 (Cawangan)
        if ($request->filter_level == '2' || $request->filter_level == 2) {
            $detailCompany = DetailCompany::where('id_user', $user->id)->first();

            if (!$detailCompany) {
                $newDateTime = Carbon::now()->addYear(1);
                $running_number = PublishedCertificate::orderBy('id_published_certificate', 'desc')->first();

                if ($running_number) {
                    $add_number = ((int)$running_number->number_certificate) + 1;
                    $next_number = str_pad($add_number, 6, '0', STR_PAD_LEFT);
                } else {
                    $next_number = str_pad(1, 6, '0', STR_PAD_LEFT);
                }

                if ($auth && $auth->id_level == 4) {
                    $idBhagian = $auth->id;
                } else {
                    $insertKetuaBhagian = $this->storeKetuaBahagian($request->id_city);
                    if ($insertKetuaBhagian['status']) {
                        $idBhagian = $insertKetuaBhagian['data'];
                    } else {
                        $idBhagian = null;
                    }
                }

                $detailComp = new DetailCompany();
                $detailComp->id_user = $user->id;
                $detailComp->id_city = $request->id_city;
                $detailComp->id_bahagian = $idBhagian;
                $detailComp->status_approval = "APPROVED";
                $detailComp->status_certificate_approval = 1;
                $detailComp->certificate_expired_date = $newDateTime;
                $detailComp->number_certificate = 'P' . date("dmy") . '-' . $next_number;
                $detailComp->step_registration = 2;
                $detailComp->key_reference = Str::random(6);
                $detailComp->save();
            }
        }

        return redirect()->back()->with('success', 'Created Successfully');
    }

    protected function storeKetuaBahagian($id_city)
    {
        // Cari user dengan level 4 (Ketua Bahagian) yang memiliki id_city yang sama
        $data = User::where('id_city', $id_city)
            ->where('id_level', 4)
            ->first();

        if (!$data) {
            return [
                'status' => false,
                'data' => null
            ];
        }

        return [
            'status' => true,
            'data' => $data->id
        ];
    }

    public function edit($id, Request $r)
    {
        $data = User::with('level')->findOrFail($id);

        // $data = Position::where('id_position', $id)->first();

        return response()->json([
            'success' => 'Get data successfully',
            'data' => $data
        ]);
        // return view('admin.settingsPosition.index', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $email = $request->email;
        $em = User::where('email', $email)->where('id', '!=', $id)->first();

        if ($em) {
            return $this->commitResponse('Emel sudah digunakan, sila guna emel lain');
        }
        $user = User::findOrFail($id);
        $user->fullname = $request->fullname;
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        // $user->id_city = $request->id_city;
        // $user->id_state = $request->state;
        if ($user->id_level == 4) {
            $user->no_ros = $request->no_ros;
            $user->kod_bahagian = $request->kod_bahagian;
            $user->status_ros = $request->status_ros;
        }
        if ($user->id_level == 2) {
            $user->no_ros = $request->no_ros;
            $user->kod_cawangan = $request->kod_cawangan;
            $user->status_ros = $request->status_ros;
            $strBahagian = $this->storeKetuaBahagian($request->id_city);
            $cawangan = DetailCompany::where('id_user', $user->id)->first();
            $cawangan->id_city = $request->id_city;
            $cawangan->id_bahagian = $strBahagian['data'];
            $cawangan->save();
        }
        $user->save();

        return $this->commitResponse('Update data successfuly', true, $user);

    }

    public function update_password(Request $request, $id)
    {
        if ($request->password != $request->confirm_password) {
            return $this->commitResponse('Password invalid');
        }
        $user = User::findOrFail($id);
        $user->password = Hash::make($request->password);
        $user->save();

        return $this->commitResponse('Update Password successfuly', true, $user);
    }

    public function getCountry()
    {
        $data = Country::where('is_active', 'ENABLE')->get();

        return response()->json([
            'success' => true,
            'message' => 'successfully fetch country',
            'data' => $data
        ], 200);
    }
    public function getState($id_country)
    {
        $data = State::where('is_active', 'ENABLE')
            ->where('id_country', $id_country)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'successfully fetch state',
            'data' => $data
        ], 200);
    }
    public function getCity($id_state)
    {
        $data = City::where('is_active', 'ENABLE')
            ->where('id_state', $id_state)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'sucessfully fetch city',
            'data' => $data
        ], 200);
    }
    public function getBahagianWithKetuaBahagian($id)
    {
        try {
            $detailCawangan = DetailCompany::where("id_user", $id)->first();
            if (!$detailCawangan) {
                return response()->json([
                    'success' => false,
                    'message' => 'data not found',
                    'data' => null
                ], 404);
            }

            $ketuaBahagian = User::with('city')
                ->when($detailCawangan->id_bahagian, function ($query) use ($detailCawangan) {
                    $query->where('id', $detailCawangan->id_bahagian);
                })
                ->where('id_city', $detailCawangan->id_city)
                ->first(); 

            $result = [
                'name_ketua_bahagian' => $ketuaBahagian->fullname ?? "N/A",
                'bahagian' => $ketuaBahagian->city->city ?? "N/A"
            ];

            return response()->json([
                'success' => true,
                'message' => 'successfully get bahagian with ketua',
                'data' => $result
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed fetch bahagian with ketua bahagian',
                'data' => null,
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
