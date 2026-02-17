<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\Models\User;
use App\Models\Inbox;
use App\Models\InboxRecipient;
use App\Models\DetailManpower;
use App\Models\JoinCompany;
use App\Models\Blogpost;
use App\Models\DetailCompany;
use App\Traits\ApiResponder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LoginUserController extends Controller
{
    use ApiResponder;

    public function redirectToGoogle()
    {

        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {

            $user = Socialite::driver('google')->user();

            $finduser = User::where('email', $user->email)->first();

            if ($finduser) {

                Auth::login($finduser);

                if ($finduser->id_level == "1" || $finduser->id_level == "4") {
                    return redirect()->to('home');
                }
                if ($finduser->id_level == "2") {
                    return redirect()->to('homeCompany');
                }

                if ($finduser->id_level == "3") {

                    $manpower = DetailManpower::where('id_user', $finduser->id)->first();

                    if (isset($manpower)) {
                        if ($manpower->key_reference == null || $manpower->key_reference == "") {

                            $key_reference = Str::random(6);

                            $cek = DetailManpower::where('key_reference', $key_reference)->first();
                            if ($cek) {
                                $key_reference = Str::random(6);
                                $cek = DetailManpower::where('key_reference', $key_reference)->first();
                                if ($cek) {
                                    $key_reference = Str::random(6);
                                }
                            }

                            $manpower->key_reference = $key_reference;
                            $manpower->save();
                        }
                    } else {
                        $finduser->delete();
                        Auth::logout();
                        return redirect("/register_ahli/create?email=$user->email");
                    }

                    return redirect()->to('homeManPower');
                }
            } else {

                return redirect("/register_ahli/create?email=$user->email");
            }
        } catch (Exception $e) {

            return redirect('auth/google');
        }
    }

    public function login(Request $request)
    {

        if (Auth::user()) {
            Auth::logout();
        }

        $user = DB::table('users')->where('email', $request->email)->first();

        if (!$user) {
            return $this->commitResponse('Login Failed! Incorrect Email');
        }


        if ($user->is_verified != "1") {
            return $this->commitResponse('Please verify your email first!');
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $user = User::where('id', $user->id)->first();

            $user->fcm_token = $request->fcm_token;
            $user->save();

            if ($user->id_level == "3") {
                $manpower = DetailManpower::where('id_user', $user->id)->first();

                if ($manpower->key_reference == "" || $manpower->key_reference == null) {
                    $key_reference = Str::random(6);

                    $cek = DetailManpower::where('key_reference', $key_reference)->first();
                    if ($cek) {
                        $key_reference = Str::random(6);
                        $cek = DetailManpower::where('key_reference', $key_reference)->first();
                        if ($cek) {
                            $key_reference = Str::random(6);
                        }
                    }

                    $manpower->key_reference = $key_reference;
                    $manpower->save();
                }

                $join_company_expired = JoinCompany::select('id', 'id_detail_company', 'id_detail_manpower', 'expired_at')->with([
                    'company' => function ($query) {
                        $query->select('id_detail_company', 'full_company_name');
                    }
                ])->where('id_detail_manpower', $manpower->id_detail_manpower)->whereDate('expired_at', '<', now())->get();

                $join_company_almost_expired = JoinCompany::select('id', 'id_detail_company', 'id_detail_manpower', 'expired_at')->with([
                    'company' => function ($query) {
                        $query->select('id_detail_company', 'full_company_name');
                    }
                ])->where('id_detail_manpower', $manpower->id_detail_manpower)->whereRaw('DATEDIFF(expired_at,now()) = 7')->get();

                foreach ($join_company_expired as $d) {

                    $inbox_join_company_expired = InboxRecipient::whereHas('inbox', function ($query) use ($d) {
                        $query->where('trigger_inbox', Inbox::$expiredJoinCompany);
                        $query->where('id_join_company', $d->id);
                    })->where('recipient', $user->id)->orderBy('id', 'DESC')->first();

                    if (!$inbox_join_company_expired) {
                        $company = isset($d->company->full_company_name) ? $d->company->full_company_name : '-';
                        $recipient = [$user->id];

                        $this->submitInbox($manpower->id_user, $recipient, "Keahlian Persatuan", "Keahlian Persatuan $company tamat.", Inbox::$expiredJoinCompany, $d->id);
                    } else {
                        continue;
                    }
                }

                foreach ($join_company_almost_expired as $d) {

                    $inbox_join_company_almost_expired = InboxRecipient::whereHas('inbox', function ($query) use ($d) {
                        $query->where('trigger_inbox', Inbox::$almostExpiredJoinCompany);
                        $query->where('id_join_company', $d->id);
                    })->where('recipient', $user->id)->orderBy('id', 'DESC')->first();

                    if (!$inbox_join_company_almost_expired) {
                        $company = $d->company->full_company_name;
                        $recipient = [$user->id];

                        $this->submitInbox($manpower->id_user, $recipient, "Keahlian Persatuan", "Keahlian Persatuan $company tamat 7 hari lagi.", Inbox::$almostExpiredJoinCompany, $d->id);
                    } else {
                        continue;
                    }
                }
            }

            return $this->commitResponse('Login Successfuly!, wait for the page to be redirected', true, $user);
        }

        return $this->commitResponse('Login Failed!, Incorrect Password');
    }

    public function loginByPass(Request $request)
    {

        if (Auth::user()) {
            Auth::logout();
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {

            return [
                'isSuccess' => false,
                'message' => 'Login Failed! Incorrect Email',
            ];
        }


        if ($user->is_verified != "1") {

            return [
                'isSuccess' => false,
                'message' => 'Please verify your email first!',
            ];
        }

        Auth::login($user, true);


        return [
            'isSuccess' => true,
            'message' => 'Login successfully!',
            'data' => Auth::user(),
        ];
    }

    /**
     * API Login - Returns token for authentication
     */
    public function apiLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Login Failed! Incorrect Email',
            ], 401);
        }

        if ($user->is_verified != "1") {
            return response()->json([
                'success' => false,
                'message' => 'Please verify your email first!',
            ], 403);
        }

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'success' => false,
                'message' => 'Login Failed! Incorrect Password',
            ], 401);
        }

        // Update FCM token if provided
        if ($request->has('fcm_token')) {
            $user->fcm_token = $request->fcm_token;
            $user->save();
        }

        // Create token
        $token = $user->createToken('api-token')->plainTextToken;

        // Load relationships based on user level
        if ($user->id_level == "3") {
            $user->load('manpower');
        } elseif ($user->id_level == "2") {
            $user->load('company');
        }

        return response()->json([
            'success' => true,
            'message' => 'Login successful!',
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
        ], 200);
    }

    /**
     * API Me - Get authenticated user info
     */
    public function me(Request $request)
    {
        try {
            Log::info('API /me called');

            $user = $request->user();
            Log::info('User authenticated', ['user_id' => $user ? $user->id : null]);

            if (!$user) {
                Log::warning('Unauthenticated user attempt');
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated',
                ], 401);
            }

            Log::info('Returning user data', ['id_level' => $user->id_level, 'user_id' => $user->id]);

            return response()->json([
                'success' => true,
                'data' => $user,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error in /me endpoint', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * API Logout - Revoke current access token
     */
    public function apiLogout(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated',
            ], 401);
        }

        // Revoke current access token
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout successful!',
        ], 200);
    }

    /**
     * API Refresh Token - Generate new token and revoke old one
     */
    public function refreshToken(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated',
            ], 401);
        }

        // Revoke current access token
        $request->user()->currentAccessToken()->delete();

        // Create new token
        $newToken = $user->createToken('api-token')->plainTextToken;

        // Load relationships based on user level
        if ($user->id_level == "3") {
            $user->load('manpower');
        } elseif ($user->id_level == "2") {
            $user->load('company');
        }

        return response()->json([
            'success' => true,
            'message' => 'Token refreshed successfully!',
            'data' => [
                'user' => $user,
                'token' => $newToken,
            ],
        ], 200);
    }

    /**
     * API Get Total Member - For Ketua Bahagian (id_level = 4)
     */

    public function getTotalMember(Request $request)
    {
        try {
            $user = Auth::user();

            if ($user->sub_company != null) {
                $id_user = $user->sub_company;
            } else {
                $id_user = $user->id;
            }

            if ($request->id_user) {
                $id_user = $request->id_user;
            }

            // Untuk level 2 (Persatuan), gunakan JoinCompany model
            if ($user->id_level == "2" || $request->id_user) {
                $detail = DetailCompany::where('id_user', $id_user)->first();

                if (!$detail) {
                    return $this->error("Company detail not found", 404);
                }

                // Base query untuk JoinCompany
                $baseQuery = JoinCompany::where('id_detail_company', $detail->id_detail_company)
                    ->whereDate('expired_at', '>', date('Y-m-d'));

                // Total member yang sudah join persatuan dan aktif (belum expired)
                $totalMember = (clone $baseQuery)
                    ->whereHas('manpower', function ($query) {
                        $query->where('step_registration', DetailManpower::$stepRegistration);
                    })
                    ->count();

                // Total active members
                $totalActive = (clone $baseQuery)
                    ->whereHas('manpower', function ($query) {
                        $query->where('step_registration', DetailManpower::$stepRegistration);
                    })
                    ->whereHas('manpower.user', function ($query) {
                        $query->where('status', 'ACTIVE');
                    })
                    ->count();

                // Total pending members (belum complete registration)
                $totalPending = JoinCompany::where('id_detail_company', $detail->id_detail_company)
                    ->whereHas('manpower', function ($query) {
                        $query->where('step_registration', '<', DetailManpower::$stepRegistration);
                    })
                    ->count();

                // Total expired members
                $totalExpired = JoinCompany::where('id_detail_company', $detail->id_detail_company)
                    ->whereDate('expired_at', '<', now())
                    ->count();
            } else {
                // Untuk level lain, gunakan DetailManpower
                $baseQuery = DetailManpower::query();

                // Filter berdasarkan level user
                if ($user->id_level == 6 || $user->id_level == 4) {
                    $baseQuery->where('id_state', $user->id_state);
                }

                // Total members yang sudah complete registration
                $totalMember = (clone $baseQuery)
                    ->where('step_registration', DetailManpower::$stepRegistration)
                    ->count();

                // Total active members
                $totalActive = (clone $baseQuery)
                    ->where('step_registration', DetailManpower::$stepRegistration)
                    ->whereHas('user', function ($query) {
                        $query->where('status', 'ACTIVE');
                    })
                    ->whereDate('certificate_expired_date', '>', now())
                    ->count();

                // Total pending members (belum complete registration)
                $totalPending = (clone $baseQuery)
                    ->where('step_registration', '<', DetailManpower::$stepRegistration)
                    ->count();

                // Total expired members
                $totalExpired = (clone $baseQuery)
                    ->whereDate('certificate_expired_date', '<', now())
                    ->count();
            }

            return $this->success([
                'total_member' => $totalMember,
                'total_active' => $totalActive,
                'total_pending' => $totalPending,
                'total_expired' => $totalExpired,
            ], "Successfully get total member", 200);
        } catch (\Exception $e) {
            Log::error('Error in getTotalMember: ' . $e->getMessage());
            return $this->error("Failed fetch total member: " . $e->getMessage(), 500);
        }
    }

    /**
     * API Get Total Event
     */
    public function getTotalEvent(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated',
            ], 401);
        }

        // Get total published events
        $totalEvent = Blogpost::where('status', 'published')->count();

        // Get total draft events
        $totalDraft = Blogpost::where('status', 'draft')->count();

        // Get total all events
        $totalAll = Blogpost::count();

        return response()->json([
            'success' => true,
            'data' => [
                'total_event' => $totalEvent,
                'total_draft' => $totalDraft,
                'total_all' => $totalAll,
            ],
        ], 200);
    }

    /**
     * API Get Single Member Detail
     */
    public function getMemberDetail(Request $request, $id)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated',
            ], 401);
        }

        // Get member detail with all relationships
        $member = DetailManpower::with([
            'user:id,fullname,phone_number,email,is_verified,registered_by,status',
            'company:id_detail_company,full_company_name',
            'status_native:id_status_native,status_native',
            'business_type_text:id_business_type,business_type',
            'business_activity_text:id_business_activity,business_activity',
            'business_income_text:id_business_income,business_income',
            'gender_text:id_gender,gender',
            'marital_status_text:id_marital_status,marital_status',
            'city:id_city,city',
            'state:id_state,state',
            'country:id_country,country_name',
            'parliament:id,parliament',
            'dun:id,dun',
            'religion:id_religion,religion',
            'nation:id_nation,nation',
        ])
            ->where('id_detail_manpower', $id)
            ->first();

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Member not found',
            ], 404);
        }

        // Check authorization for Ketua Bahagian
        if ($user->id_level == "4" && $member->id_state != $user->id_state) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. You can only view members from your state.',
            ], 403);
        }

        // Format additional data
        $member->status_native_text = $member->status_native->status_native ?? '';
        $member->persatuan = $member->company->full_company_name ?? 'Tiada Persatuan';
        $member->business_type_name = $member->business_type_text->business_type ?? '';
        $member->business_activity_name = $member->business_activity_text->business_activity ?? '';
        $member->business_income_name = $member->business_income_text->business_income ?? '';
        $member->gender_name = $member->gender_text->gender ?? '';
        $member->marital_status_name = $member->marital_status_text->marital_status ?? '';
        $member->city_name = $member->city->city ?? '';
        $member->state_name = $member->state->state ?? '';
        $member->country_name = $member->country->country_name ?? '';
        $member->parliament_name = $member->parliament->parliament ?? '';
        $member->dun_name = $member->dun->dun ?? '';
        $member->religion_name = $member->religion->religion ?? '';
        $member->nation_name = $member->nation->nation ?? '';

        // Invoice status
        if ($member->certificate_expired_date == null) {
            $member->invoice = 'UNPAID';
        } elseif ($member->certificate_expired_date > now()) {
            $member->invoice = 'PAID';
        } else {
            $member->invoice = 'EXPIRED';
        }

        // Registered by
        if ($member->user && $member->user->registered_by) {
            $registeredBy = User::find($member->user->registered_by);
            $member->registered_by_name = $registeredBy ? $registeredBy->fullname : '';
        } else {
            $member->registered_by_name = '';
        }

        return response()->json([
            'success' => true,
            'data' => $member,
        ], 200);
    }

    /**
     * API Get Member List
     */
    public function getMember(Request $request)
    {
        try {
            $filter = $request->filter ?? null;
            $status = $request->status;
            $license = $request->license;

            $user = Auth::user();

            if ($user->sub_company != null) {
                $id_user = $user->sub_company;
            } else {
                $id_user = $user->id;
            }

            if ($request->id_user) {
                $id_user = $request->id_user;
            }

            // Untuk level 2 (Persatuan), gunakan JoinCompany model
            if ($user->id_level == "2" || $request->id_user) {
                $detail = DetailCompany::where('id_user', $id_user)->first();

                if (!$detail) {
                    return $this->error("Company detail not found", 404);
                }

                $data = JoinCompany::with([
                    'manpower' => function ($query) {
                        $query->select('id_user', 'id_detail_manpower', 'id_detail_company', 'ic_number', 'step_registration', 'native_status', 'business_license_no', 'business_type', 'kad_digital', 'payment_kad_digital');
                    },
                    'company' => function ($query) {
                        $query->select('id_detail_company', 'full_company_name');
                    },
                    'manpower.user' => function ($query) {
                        $query->select('id', 'fullname', 'phone_number', 'email', 'is_verified', 'registered_by');
                    },
                    'manpower.status_native' => function ($query) {
                        $query->select('id_status_native', 'status_native');
                    },
                    'manpower.business_type_text' => function ($query) {
                        $query->select('id_business_type', 'business_type');
                    }
                ])
                ->where('id_detail_company', $detail->id_detail_company)
                ->whereDate('expired_at', '>', date('Y-m-d'))
                ->orderBy('created_at', 'DESC');

                // Filter status untuk JoinCompany
                if ($status == "Overall") {
                    $data->whereHas('manpower', function ($query) {
                        $query->where('step_registration', DetailManpower::$stepRegistration);
                    });
                }

                if ($status != "Overall" && $status != "Unfiltered" && $status != "") {
                    $data->whereHas('manpower.user', function ($query) use ($status) {
                        $query->where('status', $status);
                    })->whereHas('manpower', function ($query) {
                        $query->where('step_registration', DetailManpower::$stepRegistration);
                    });
                }

                if ($request->id_city) {
                    $id_city = $request->id_city;
                    $data->whereHas('manpower', function ($query) use ($id_city) {
                        $query->where('id_city', $id_city);
                    });
                }

                if ($license == "No") {
                    $data->whereHas('manpower', function ($query) {
                        $query->whereNull('business_license_no');
                    });
                }

                // Filter berdasarkan tanggal
                if ($filter == "today") {
                    $data->whereHas('manpower', function ($query) {
                        $query->whereDate('created_at', date('Ymd'));
                    });
                } elseif ($filter == "month") {
                    $data->whereHas('manpower', function ($query) {
                        $query->whereMonth('created_at', Carbon::today()->month)
                            ->whereYear('created_at', Carbon::today()->year);
                    });
                } elseif ($filter == "year") {
                    $data->whereHas('manpower', function ($query) {
                        $query->whereYear('created_at', Carbon::today()->year);
                    });
                }

                // Search query
                if ($request->q) {
                    $q = $request->q;
                    $data->whereHas('manpower.user', function ($query) use ($q) {
                        $query->where('fullname', 'LIKE', "%$q%")
                            ->orWhere('email', 'LIKE', "%$q%")
                            ->orWhere('phone_number', 'LIKE', "%$q%");
                    });
                }

                $data = $data->get();

                // Format data untuk JoinCompany
                foreach ($data as $d) {
                    $d->ref = Crypt::encryptString($d->id_user);

                    if ($d->manpower) {
                        $d->manpower->status_native_text = $d->manpower->status_native->status_native ?? '';
                    }

                    if ($d->payment_date == null) {
                        $d->invoice = 'UNPAID';
                    } elseif ($d->expired_at > date('Y-m-d')) {
                        $d->invoice = 'PAID';
                    } else {
                        $d->invoice = 'EXPIRED';
                    }

                    $d->persatuan = $d->company->full_company_name ?? '';

                    if ($d->manpower && $d->manpower->user && $d->manpower->user->registered_by) {
                        $d->registered_by_name = User::find($d->manpower->user->registered_by)?->fullname ?? '';
                    } else {
                        $d->registered_by_name = '';
                    }
                }

            } else {
                // Untuk level lain, gunakan DetailManpower
                $data = DetailManpower::select(
                    'id_user',
                    'id_detail_manpower',
                    'id_detail_company',
                    'ic_number',
                    'step_registration',
                    'native_status',
                    'business_license_no',
                    'business_type',
                    'business_activity',
                    'sub_business_activity',
                    'kad_digital',
                    'payment_kad_digital',
                    'subscribe_status',
                    'is_subscribe'
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
                        'id_user',
                        'id_detail_manpower',
                        'id_detail_company',
                        'ic_number',
                        'step_registration',
                        'native_status',
                        'is_subscribe',
                        'certificate_expired_date'
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

                $data = $data->get();

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
            }

            return $this->success($data, "Successfully get member list", 200);
        } catch (\Exception $e) {
            Log::error('Error in getMember: ' . $e->getMessage());
            return $this->error("Failed fetch member list: " . $e->getMessage(), 500);
        }
    }
}
