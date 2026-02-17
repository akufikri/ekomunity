<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisCompanyController;
use App\Http\Controllers\RegisManpowerController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CompanyEquityController;
use App\Http\Controllers\EmploymentHistoryController;
use App\Http\Controllers\EmploymentDetailController;
use App\Http\Controllers\SumQualificationController;
use App\Http\Controllers\OthQualificationController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthLogController;
use App\Http\Controllers\BlogpostController;
use App\Http\Controllers\SettingsPositionController;
use App\Http\Controllers\SettingsQualificationController;
use App\Http\Controllers\SettingsCountryController;
use App\Http\Controllers\SettingStateController;
use App\Http\Controllers\SettingsCityController;
use App\Http\Controllers\SettingsSchoolTypeController;
use App\Http\Controllers\SettingsSchoolController;
use App\Http\Controllers\SettingsCertificateController;
use App\Http\Controllers\SettingsTermController;
use App\Http\Controllers\SettingsVendorController;
use App\Http\Controllers\SettingsPositionShareholdersController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\SettingsReligionController;
use App\Http\Controllers\NationController;
use App\Http\Controllers\StatusNativeController;
use App\Http\Controllers\GenderController;
use App\Http\Controllers\StatusEducationController;
use App\Http\Controllers\StudyController;
use App\Http\Controllers\BusinessActivityController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\BusinessTypeController;
use App\Http\Controllers\CategoryPostController;
use App\Http\Controllers\SubBusinessActivityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MaritalStatusController;
use App\Http\Controllers\JoinCompanyController;
use App\Http\Controllers\PushNotificationController;
use App\Http\Controllers\SettingsSubscribeController;
use App\Http\Controllers\SettingsParliamentController;
use App\Http\Controllers\SettingsDUNController;
use App\Http\Controllers\SettingsVillageGuestsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SenaraiAhliController;
use App\Http\Controllers\CollaborationAgencyController;
use App\Http\Controllers\DirektoriController;
use App\Http\Controllers\EmailSettingController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\PackageSettingController;
use App\Http\Controllers\PembayaranCawanganController;
use App\Http\Controllers\PembayaranKetuaBahagianController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingBrandingController;
use App\Http\Controllers\StatistikController;
use App\Http\Controllers\StatusApprovalController;
use App\Http\Controllers\SturctureOrganizationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;
use Carbon\Carbon;

use Illuminate\Support\Facades\Crypt;

use App\Models\User;
use App\Models\DetailManpower;
use App\Models\DetailCompany;
use App\Models\JoinCompany;
use App\Models\InboxRecipient;
use App\Models\Inbox;
use App\Models\ManpowerPosition;
use Illuminate\Http\Request;

// Route::get('/carta', function () {
//     return view('testing.carta-organtisasi');
// });

// require_once 'billPlz.php';
require_once 'toyyibPay.php';
require_once('globalFunction.php');

// Route::get('/landing-v2', function(){
//     return view('landingpage.pages.design-v2');
// });

Route::get('/', function () {
    return view('landingpage.pages.design-v2');
    // return redirect('/login');
});
Route::get('/direktori', [LandingPageController::class, 'direktori']);
Route::get('/buletin', [LandingPageController::class, 'blogPost']);
Route::get('/buletin/{slug}', [LandingPageController::class, 'detailPost']);
// Route::get('/', function () {
//     return redirect('/login');
// });

Route::get('checkExpired', function () {
    $data = DetailManpower::where('subscribe_status', 'APPROVED')->whereDate('certificate_expired_date', '<', now())->get()->count();
    return compact('data');
});


Route::get('/statistik', function () {
    return view('statistik.index');
});

Route::get('adjustIdLogPatment', function () {

    $log = \App\Models\LogPaymentManpower::get();
    $count = 0;
    foreach ($log as $d) {
        $ahli = \App\Models\DetailManpower::where('id_user', $d->id_user)->first();

        if ($ahli) {
            $d->id_detail_manpower = $ahli->id_detail_manpower;
            $d->save();
            $count++;
        }
    }

    return $count;
});

Route::post('/setToken', [PushNotificationController::class, 'setToken']);
Route::post('/send-notification', [PushNotificationController::class, 'sendPushNotification']);
Route::get('/summernote', function () {
    return view('summernote');
});

Route::get('/summernoteb4', function () {
    return view('summernoteb4');
});


Route::get('convertPersatuan', function () {
    $manpower = DetailManpower::select('id_detail_manpower', 'id_detail_company')->where('id_detail_company', '!=', null)->get();
    foreach ($manpower as $d) {
        $d->id_detail_company = json_decode($d->id_detail_company);

        if (is_string($d->id_detail_company) || is_int($d->id_detail_company)) {

            $d->id_detail_company = $d->id_detail_company;
        } else {

            $d->id_detail_company = $d->id_detail_company[0];
        }

        $join = new JoinCompany();
        $join->id_detail_manpower = $d->id_detail_manpower;
        $join->id_detail_company = $d->id_detail_company;

        $join->joining_fee = "0";

        $join->status_approval = "APPROVED";

        $join->status_approval_at = now();

        $join->status_approval_by = $d->id_detail_manpower;

        $join->payment_method = "CASH";

        $join->payment_date = now();

        $newDateTime = Carbon::now()->addYear(1);

        $join->expired_at = $newDateTime;

        $join->save();

        $d->id_detail_company = null;
        $d->save();
    }

    return 'success';
});

Route::get('generateKeyReferencePersatuan', function () {

    $company =  DetailCompany::whereNull('key_reference')->orWhere('key_reference', '')->get();
    foreach ($company as $d) {

        $d->key_reference = Str::random(6);

        $cek = DetailCompany::where('key_reference', $d->key_reference)->first();
        if ($cek) {
            $d->key_reference = Str::random(6);
            $cek = DetailCompany::where('key_reference', $d->key_reference)->first();
            if ($cek) {
                $d->key_reference = Str::random(6);
            }
        }

        $d->save();
    }

    return true;
});

Route::get('generateKeyReferenceAhli', function () {

    $manpower =  DetailManpower::whereNull('key_reference')->orWhere('key_reference', '')->get();
    foreach ($manpower as $d) {

        $d->key_reference = Str::random(6);

        $cek = DetailManpower::where('key_reference', $d->key_reference)->first();
        if ($cek) {
            $d->key_reference = Str::random(6);
            $cek = DetailManpower::where('key_reference', $d->key_reference)->first();
            if ($cek) {
                $d->key_reference = Str::random(6);
            }
        }

        $d->save();
    }

    return true;
});


Route::get('testEncrypt/{id}', function ($id) {

    $encrypt = Crypt::encryptString($id);
    $decrypted = Crypt::decryptString($encrypt);

    return compact('encrypt', 'decrypted');
});

Route::get('hashPassword/{password}', function ($password) {
    return Hash::make($password);
});

Route::get('google', function () {

    return view('googleAuth');
});

Route::post('/resetPassword', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'resetPassword']);

Route::get('/testSendEmailVerification/{id}', [App\Http\Controllers\RegisManpowerController::class, 'testSendEmailVerification']);

Route::get('/testSendEmailRegisAhli/{id}', [App\Http\Controllers\RegisManpowerController::class, 'testSendEmailRegisAhli']);


Route::get('/getStatsRegisterAhli', [App\Http\Controllers\HomeController::class, 'getStatsRegisterAhli']);

Route::get('/activateCompanyCard', [App\Http\Controllers\SenaraiAhliController::class, 'activateCompanyCard']);

Route::get('auth/google', [App\Http\Controllers\LoginUserController::class, 'redirectToGoogle']);

Route::get('auth/google/callback', [App\Http\Controllers\LoginUserController::class, 'handleGoogleCallback']);

Route::get('/view_map', [EmployeeController::class, 'viewMap']);
Route::get('/view_map_tamu_desa', [SettingsVillageGuestsController::class, 'viewMap']);
Route::get('/view_map_cawangan', [LandingPageController::class, 'viewMap']);

Route::get('/testgenerate', function () {

    $data = DetailManpower::get();

    foreach ($data as $d) {
        $d->key_reference = Str::random(6);
        $d->save();
    }

    return 'selesai';
});


Route::get('/setExpired/{email}', function ($email) {

    $user = \App\Models\User::where('email', $email)->first();
    if (!$user) {
        return [
            "status" => false,
            "message" => "Email not found!"
        ];
    }

    $detail = \App\Models\DetailManpower::where('id_user', $user->id)->first();
    if (!$detail) {
        return [
            "status" => false,
            "message" => "Detail ahli not found!"
        ];
    }

    $detail->subscribe_status = "EXPIRED";
    $detail->certificate_expired_date = date('Y-m-d', strtotime('-1 day'));
    $detail->save();

    return [
        "status" => true,
        "message" => "Set expired successfuly!"
    ];
});



Route::get('/checkDuplicateIC', function () {

    $data = DetailManpower::groupBy('ic_number')->having(DB::raw('count(ic_number)'), '>', 1)->get();

    return $data;
});

Route::get('/fixIC', function () {

    // $data = DetailManpower::select('ic_number')->where('id_detail_manpower', '8426')->first();
    // $data = DetailManpower::select('ic_number')->where('id_detail_manpower', '6395')->first();
    // $data = DetailManpower::select('ic_number')->where('id_detail_manpower', '11297')->first();
    $data = DetailManpower::get();

    $count = 0;

    foreach ($data as $d) {
        $detail = DetailManpower::where('id_detail_manpower', $d->id_detail_manpower)->first();
        $detail->ic_number = preg_replace("/[^0-9]+/", "", $detail->ic_number);
        $detail->save();
        $count += 1;
    }

    // $before = $data->ic_number;
    // $string = preg_replace("/[^0-9]+/", "", $before);

    return compact('count');
});



Route::get('/adjustDetailCompany', function () {

    $data = DetailManpower::get();

    // return $data;

    // $temp = json_encode($data->id_detail_company);
    // return $temp;

    foreach ($data as $d) {


        if ($d->id_detail_company != null) {
            $array = [];
            $array[0] = $d->id_detail_company;
            $d->id_detail_company = $array;
            $d->save();
        } else {
            continue;
        }
    }

    return 'selesai';
});


//clear cache browser
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

Route::get('/route-cache', function () {
    Artisan::call('route:clear');
    return "Route is cleared";
});

Route::get('/view-cache', function () {
    Artisan::call('view:clear');
    return "View is cleared";
});

Route::get('/optimize', function () {
    Artisan::call('optimize');
    return "Success Optimize";
});

Route::get('/semak_pendaftaran', [RegisManpowerController::class, 'semakPendaftaran']);

Route::get('/semak_pendaftaran_result', [RegisManpowerController::class, 'semakPendaftaranResult']);

Route::get('/id/{code}', function ($code) {

    $data = DetailManpower::with('user')->where('key_reference', $code)->first();

    // return $data;

    if (!$data) {
        return "Data not found!";
    } else {

        $user = User::where('id', $data->id_user)->first();

        if (!$user) {
            return "Data not found!";
        }

        $first = substr($data->business_phone, 0, 1);
        $second = substr($data->business_phone, 1, 1);
        if ($first . $second == 60) {
            $data->business_phone = $data->business_phone;
        } else if ($first == 0) {
            $data->business_phone = '6' . $data->business_phone;
        } else if ($first != 6 && $first != 0) {
            $data->business_phone = '60' . $data->business_phone;
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://sys.rikod.my/api/codeCompany?email=$user->email",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $decode = json_decode($response);
        $data->company_code = isset($decode->data);

        $data->share_link = env('APP_URL') . '/id/' . $data->key_reference;
        return view('digitalprofile.index', compact('data'));
    }
});

Route::get('/daftar_persatuan/{code}', function ($code) {
    $data = DetailCompany::with('user')->where('key_reference', $code)->first();
    $auth = Auth::user();

    $manpower = DetailManpower::where('id_user', $auth->id)->first();

    // default null biar aman
    $join_company = null;

    // cek kalau $manpower tidak null
    if ($manpower) {
        $join_company = JoinCompany::where('id_detail_company', $data->id_detail_company)
            ->where('id_detail_manpower', $manpower->id_detail_manpower)
            ->where('status_approval', 'APPROVED')
            ->first();
    }

    if (!$auth) {
        return redirect(env('APP_URL') . "/persatuan/$code");
    }

    if ($auth->id_level != '3') {
        return redirect(env('APP_URL') . "/persatuan/$code");
    }

    $user_auth = User::select('id', 'fullname', 'email')->with(['manpower' => function ($query) {
        $query->select('id_user', 'ic_number', 'id_city')->with(['city' => function ($query) {
            $query->select('id_city', 'city');
        }]);
    }])->where('id', $auth->id)->first();

    if (!$data) {
        return "Data not found!";
    } else {
        $user = User::where('id', $data->id_user)->first();

        if (!$user) {
            return "Data not found!";
        }

        if ($user->phone_number != null) {
            $first = substr($user->phone_number, 0, 1);
            $second = substr($user->phone_number, 1, 1);
            if ($first . $second == 60) {
                $data->phone_number = $user->phone_number;
            } else if ($first == 0) {
                $data->phone_number = '6' . $user->phone_number;
            } else if ($first != 6 && $first != 0) {
                $data->phone_number = '60' . $user->phone_number;
            }
        } else {
            $data->phone_number = '-';
        }

        $data->share_link = env('APP_URL') . "/persatuan/$data->key_reference";
        return view('digitalprofile.daftarPersatuan', compact('data', 'user_auth', 'join_company'));
    }
});

Route::get('/daftar_persatuan_success', function () {

    return view('digitalprofile.daftarPersatuanSuccess');
});

Route::get('/pembayaran_success', function () {

    return view('joinCompany.paymentSuccess');
});
// Route::get('/{code}', function ($code) {
//     $auth = Auth::user();

//     // 1️⃣ Coba cari dulu berdasarkan custom_link
//     $data = DetailCompany::with('user')->where('custom_link', $code)->first();
//     $total_company = DetailCompany::with('user')->where('custom_link', $code)->count();

//     // 2️⃣ Kalau tidak ketemu di custom_link, cek ke key_reference
//     if (!$data) {
//         $data = DetailCompany::with('user')->where('key_reference', $code)->first();
//         $total_company = DetailCompany::with('user')->where('key_reference', $code)->count();
//     }

//     if (!$data) {
//         return "Data not found!";
//     }

//     $user = User::where('id', $data->id_user)->first();
//     if (!$user) {
//         return "Data not found!";
//     }

//     // Format phone number
//     if ($user->phone_number != null) {
//         $first = substr($user->phone_number, 0, 1);
//         $second = substr($user->phone_number, 1, 1);
//         if ($first . $second == 60) {
//             $data->phone_number = $user->phone_number;
//         } else if ($first == 0) {
//             $data->phone_number = '6' . $user->phone_number;
//         } else if ($first != 6 && $first != 0) {
//             $data->phone_number = '60' . $user->phone_number;
//         }
//     } else {
//         $data->phone_number = '-';
//     }

//     // Tentukan share_link sesuai kondisi
//     if ($data->custom_link) {
//         $data->share_link = env('APP_URL') . "/persatuan/$data->custom_link";
//     } else {
//         $data->share_link = env('APP_URL') . "/persatuan/$data->key_reference";
//     }

//     return view('digitalprofile.persatuan', compact('data', 'auth', 'total_company'));
// })->where('code', '.*');
Route::get('/persatuan/{code}', function ($code) {
    $auth = Auth::user();

    // 1️⃣ Coba cari dulu berdasarkan custom_link
    $data = DetailCompany::with('user')->where('custom_link', $code)->first();
    $total_company = DetailCompany::with('user')->where('custom_link', $code)->count();

    // 2️⃣ Kalau tidak ketemu di custom_link, cek ke key_reference
    if (!$data) {
        $data = DetailCompany::with('user')->where('key_reference', $code)->first();
        $total_company = DetailCompany::with('user')->where('key_reference', $code)->count();
    }

    if (!$data) {
        return "Data not found!";
    }

    $user = User::where('id', $data->id_user)->first();
    if (!$user) {
        return "Data not found!";
    }

    // Format phone number
    if ($user->phone_number != null) {
        $first = substr($user->phone_number, 0, 1);
        $second = substr($user->phone_number, 1, 1);
        if ($first . $second == 60) {
            $data->phone_number = $user->phone_number;
        } else if ($first == 0) {
            $data->phone_number = '6' . $user->phone_number;
        } else if ($first != 6 && $first != 0) {
            $data->phone_number = '60' . $user->phone_number;
        }
    } else {
        $data->phone_number = '-';
    }

    // Tentukan share_link sesuai kondisi
    if ($data->custom_link) {
        $data->share_link = env('APP_URL') . "/persatuan/$data->custom_link";
    } else {
        $data->share_link = env('APP_URL') . "/persatuan/$data->key_reference";
    }

    return view('digitalprofile.persatuan', compact('data', 'auth', 'total_company'));
})->where('code', '.*');


// Route::get('/persatuan/{code}', function ($code) {

//     $data = DetailCompany::with('user')->where('key_reference', $code)->first();
//     $total_company = DetailCompany::with('user')->where('key_reference', $code)->count();
//     $auth = Auth::user();

//     if (!$data) {
//         return "Data not found!";
//     } else {

//         $user = User::where('id', $data->id_user)->first();

//         if (!$user) {
//             return "Data not found!";
//         }

//         if ($user->phone_number != null) {
//             $first = substr($user->phone_number, 0, 1);
//             $second = substr($user->phone_number, 1, 1);
//             if ($first . $second == 60) {
//                 $data->phone_number = $user->phone_number;
//             } else if ($first == 0) {
//                 $data->phone_number = '6' . $user->phone_number;
//             } else if ($first != 6 && $first != 0) {
//                 $data->phone_number = '60' . $user->phone_number;
//             }
//         } else {
//             $data->phone_number = '-';
//         }

//         $data->share_link = env('APP_URL') . "/persatuan/$data->key_reference";

//         return view('digitalprofile.persatuan', compact('data', 'auth', 'total_company'));
//     }
// });

Route::get('/persatuan/structure/{code}', function ($code) {

    $data = DetailCompany::with('user')->where('key_reference', $code)->first();
    $auth = Auth::user();

    $structure = ManpowerPosition::with(['user' => function ($query) {
        $query->select('id', 'fullname', 'photo');
    }, 'position' => function ($query) {
        $query->select('id_position', 'position');
    }])->where('id_company', $data->user->id)->get();

    // return $structure;

    if (!$data) {
        return "Data not found!";
    } else {

        $user = User::where('id', $data->id_user)->first();

        if (!$user) {
            return "Data not found!";
        }

        if ($user->phone_number != null) {
            $first = substr($user->phone_number, 0, 1);
            $second = substr($user->phone_number, 1, 1);
            if ($first . $second == 60) {
                $data->phone_number = $user->phone_number;
            } else if ($first == 0) {
                $data->phone_number = '6' . $user->phone_number;
            } else if ($first != 6 && $first != 0) {
                $data->phone_number = '60' . $user->phone_number;
            }
        } else {
            $data->phone_number = '-';
        }

        foreach ($structure as $d) {

            if ($d->user->photo == "" || $d->user->photo == NULL) {
                $d->user->photo = "logo.png";
            }
        }



        $data->share_link = env('APP_URL') . "/persatuan/$data->key_reference";
        return view('digitalprofile.persatuanStructure', compact('data', 'auth', 'structure'));
    }
});

Route::get('/digitalprofilesample', function () {


    return view('digitalprofile.sample');
});



Route::get('logout_test', function () {
    Auth::logout();
});


Route::get('/validationPhoneNumber', function () {

    $data = DetailCompany::get();

    foreach ($data as $d) {

        $phone = $d->phone_office;

        if ($phone != "" && $phone != null) {

            if ($phone == "60") {
                $phone = null;
            } else if (substr($phone, 0, 3) == "600") {
                $phone = substr($phone, 2);
                $phone = "6$phone";
            } else if (substr($phone, 0, 2) == "60") {
                $phone = $phone;
            } else if (substr($phone, 0, 1) == "0") {
                $phone = "6$phone";
            } else if (substr($phone, 0, 1) == "+") {
                $phone = substr($phone, 1);
            } else if (substr($phone, 0, 1) != "0") {
                $phone = "60$phone";
            } else {
                $phone = $phone;
            }

            $d->phone_office = $phone;

            $d->save();
        }
    }

    // if (substr($phone, 0, 3) == "600") {
    //     $phone = substr($phone, 2);
    //     $phone = "6$phone";
    // } else if(substr($phone, 0, 2) == "60"){
    //     $phone = $phone;
    // } else if (substr($phone, 0, 1) == "0") {
    //     $phone = "6$phone";
    // } else if (substr($phone, 0, 1) != "0") {
    //     $phone = "60$phone";
    // } else {
    //     $phone = $phone;
    // }

    return 'success';
});

Route::get('/test', function () {
    // return view('welcome_new');

    $dial_code = "+60";
    return substr($dial_code, 1);

    $user = User::where('id', '155')->first();

    return response($user);

    $from = env("MAIL_USERNAME", "info@g3pns.com");
    $user_name = $user->fullname;
    $user_email = isset($user->email) ? $user->email : 'mail@mail.com';
    $msg = "Terima Kasih kerana mendaftar! Teruskan proses pendaftaran dengan klik butang dibawah untuk sahkan emel anda.";
    $subject = "Sahkan Emel Anda";
    // $user->markEmailAsVerified();

    $data = array(
        'data' => $user,
        'msg' => $msg,
        'name' => $user_name,
        'verify_url' => "/verify_email?id=$user->id"
    );
    $mail = \Mail::send('email.user_verify', $data, function ($message) use ($user_name, $user_email, $from, $subject) {
        $message->to($user_email, $user_email)->subject($subject);
        $message->from($from, "USIA");
    });

    if ($mail) {
        return response('Success send email!');
    } else {
        return response()->json($mail);
    }
});

Route::get('/check-user', function () {
    return Auth::user();
});

Route::get('/login_to', [App\Http\Controllers\LoginUserController::class, 'loginByPass']);
Route::post('/auth_login', [App\Http\Controllers\LoginUserController::class, 'login']);
// Route::get('/',[App\Http\Controllers\LandingPageController::class, 'home']);
// Route::get('/', function () {
//     return redirect()->to('login');
//     // return redirect()->to('http://sogid.com.my');
// });
// Route::get('/about', [App\Http\Controllers\LandingPageController::class, 'about']);
Auth::routes(['verify' => true]);
// Route::get('/contact-us', [App\Http\Controllers\LandingPageController::class, 'contactUs']);

Route::get('/verify_email_all', function () {

    $auth = Auth::user();

    // $id = request()->id;
    $user = User::where('is_verified', 0)->get();

    $sum = 0;

    foreach ($user as $d) {
        $d->is_verified = true;
        $d->email_verified_at = date('d-m-Y h:i:s');
        if ($auth) {
            $d->verified_by = $auth->id;
        } else {
            $d->verified_by = $user->id;
        }
        $d->save();

        $sum++;
    }

    return compact('sum');
});

Route::get('/verify_email', function (Request $request) {

    $auth = Auth::user();

    $id = request()->id;
    $user = User::where('id', $id)->first();
    if (!$user) {
        return redirect()->to('login');
    }
    $user->is_verified = true;
    $user->email_verified_at = date('d-m-Y h:i:s');

    // if ($request->input('code')) {

    // }

    // if ($auth) {
    //     $user->verified_by = $auth->id;
    // } else {
    //     $user->verified_by = $user->id;
    // }
    $user->save();

    if ($auth) {
        return [
            'isSuccess' => true,
            'message' => 'Email already verified!'
        ];
    }

    $login = Auth::login($user);

    if ($user->id_level == "3") {
        if (request()->daftar_persatuan) {
            return redirect()->to('/register_ahli/step_two?daftar_persatuan=' . request()->daftar_persatuan . '&code=' . request()->code);
        } else {
            return redirect()->to('/register_ahli/step_two')->with('alert', 'Email verification is successful');
        }
    } else {
        return redirect()->to('/register_company/step_two')->with('alert', 'Email verification is successful');
    }

    return redirect()->to('login');
});


Route::get('/employee/edit', function () {
    return view('employee.editPersonalDetail');
});


// Route::post('/register_company', [RegisCompanyController::class, 'store']);

Route::prefix('/register_ahli')->group(function () {
    Route::get('/create', [RegisManpowerController::class, 'create'])->name('employee.create');
});
// Get bahagian with ketua
Route::get('/get_bahagian_with_ketua/{id}', [UserController::class, 'getBahagianWithKetuaBahagian']);

Route::prefix('/register_company')->group(function () {
    Route::get('/select_package', [RegisCompanyController::class, 'getSelectPackage']);
    Route::get('/create', [RegisCompanyController::class, 'create'])->name('company.create');
});




Route::post('/register_company', [RegisCompanyController::class, 'store'])->name('company.store');
Route::post('/register_ahli', [RegisManpowerController::class, 'store'])->name('employee.store');

Route::get('/success_register', function () {
    return view('success_register');
});

// Auth::routes();

// Route::group( ['middleware' => ['auth', 'roles'], 'roles' => [3,1]], function(){
//     Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// });

// Route::group( ['middleware' => ['auth', 'roles'], 'roles' => [3,1]], function(){
//     Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// });


//get country,state,city
Route::any('/getCountry', [ApiController::class, 'getCountry']);
Route::any('/getState', [ApiController::class, 'getState']);
Route::any('/getCity', [ApiController::class, 'getCity']);
Route::any('/getParliament', [ApiController::class, 'getParliament']);
Route::any('/getDun', [ApiController::class, 'getDun']);

Route::prefix('role/management')->group(function () {
    Route::get('/', [RoleController::class, 'getView']);
    Route::get('/getData', [RoleController::class, 'index']);
    Route::post('/store', [RoleController::class, 'store']);
    Route::post('/update/{id}', [RoleController::class, 'update']);
});

Route::any('/invoice', function () {
    $user = Auth::user();
    $detail = \App\Models\DetailManpower::where('id_user', $user->id)->first();
    $setting_subscribe = \App\Models\SettingSubscribe::where('subscribe_for', 'REGISTER AHLI')->where('is_active', 'ENABLE')->first();

    // return response()->json($detail);

    return view('email.invoice', compact('user', 'detail', 'setting_subscribe'));

    return view('email.invoice');
});

Route::get('/locale/{locale}', [LocaleController::class, 'set'])->name('locale.set');

Route::group(['middleware' => ['auth'],], function () {

    Route::get('/errorPaymentGateway', function () {
        return view('errorBillplz');
    });

    Route::get('/errorViewCertificate', function () {
        return view('errorViewCertificate');
    });

    Route::get('/category_product/get_data', [CategoryProductController::class, 'getData']);

    Route::get('/read_inbox/{id}', function ($id) {

        $recipient = InboxRecipient::where('id', $id)->first();
        $inbox = Inbox::where('id', $recipient->id_inbox)->first();

        if ($recipient->is_read == 0) {
            $recipient->is_read = 1;
            $recipient->read_at = now();
            $recipient->save();
        }

        if ($inbox->trigger_inbox == Inbox::$requestJoinCompany) {
            return redirect('/log_pendaftar_persatuan');
        } else if ($inbox->trigger_inbox == Inbox::$approveJoinCompany) {
            return redirect('/log_pendaftar_persatuan');
        } else if ($inbox->trigger_inbox == Inbox::$rejectJoinCompany) {
            return redirect('/log_pendaftar_persatuan');
        } else if ($inbox->trigger_inbox == Inbox::$paymentCashJoinCompany) {
            return redirect('/log_pembayaran_ahli');
        } else if ($inbox->trigger_inbox == Inbox::$approvePaymentJoinCompany) {
            return redirect('/log_pembayaran_ahli');
        } else if ($inbox->trigger_inbox == Inbox::$rejectPaymentJoinCompany) {
            return redirect('/log_pembayaran_ahli');
        } else {
            return redirect('/');
        }
    });
    Route::prefix('log-pembayaran-keahlian')->group(function () {
        Route::get('/', [TransactionController::class, 'viewLogPembayaranKeahlian'])->name('log.pembayaran.keahlian');
        Route::get('/get-data', [TransactionController::class, 'getLogPembayaranKeahlian']);
    });

    Route::get('/gerbang-pembayaran', [TransactionController::class, 'viewManagementPrice'])->name('gerbang.pembayaran');
    Route::get('/gerbang-pembayaran/get-data', [TransactionController::class, 'getGerbangPembayaran']);
    Route::post('/gerbang-pembayaran/create-or-update', [TransactionController::class, 'createOrUpdateGerbangPembayaran']);
    Route::delete('/gerbang-pembayaran/delete/{id_gerbang_pembayaran}', [TransactionController::class, 'deleteGerbangPembayaran']);

    Route::prefix('/register_ahli')->group(function () {
        Route::get('/step_two', [RegisManpowerController::class, 'registerStepTwo']);
        Route::post('/step_two_update', [RegisManpowerController::class, 'registerStepTwoUpdate']);
        Route::get('/step_five', [RegisManpowerController::class, 'registerStepFive']);
        Route::post('/step_five_update', [RegisManpowerController::class, 'registerStepFiveUpdate']);
        Route::get('/step_six', [RegisManpowerController::class, 'registerStepSix']);
        Route::post('/step_six_update', [RegisManpowerController::class, 'registerStepSixUpdate']);
        Route::get('/step_seven', [RegisManpowerController::class, 'registerStepSeven']);
        Route::post('/step_seven_update', [RegisManpowerController::class, 'registerStepSevenUpdate']);

        Route::get('/invoice', [RegisManpowerController::class, 'registerInvoice']);
        Route::get('/payment', [RegisManpowerController::class, 'registerPayment']);
        Route::get('/payment_cash', [RegisManpowerController::class, 'registerPaymentCash']);
        Route::post('/create_payment', [RegisManpowerController::class, 'createLogPaymentManpower']);
        Route::get('/waiting_payment_approval', [RegisManpowerController::class, 'waitingPaymentApproval']);
        Route::get('/pembayaran_success', function () {
            return view('paymentSuccess');
        });
        Route::get('/verification_payment', function () {

            return view('verificationPayment');
        });
    });

    Route::prefix('/register_company')->group(function () {
        Route::get('/step_two', [RegisCompanyController::class, 'registerStepTwo']);
        Route::post('/step_two_update', [RegisCompanyController::class, 'registerStepTwoUpdate']);
        Route::get('/waiting_approval', [RegisCompanyController::class, 'waitingApproval']);
        Route::get('/payment_success', function () {
            return redirect('/home')->with('success', 'Pembayaran berjaya! Pendaftaran anda telah selesai.');
        });
    });

    Route::resource('/users', UserController::class);
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::any('/users/update/{id}', [UserController::class, 'update']);
    Route::any('/users/update_password/{id}', [UserController::class, 'update_password']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});

Route::prefix('admin')->group(function () {
    Route::prefix('blog-post')->group(function () {
        Route::get('/', [BlogpostController::class, 'index']);
        Route::get('/get', [BlogpostController::class, 'getData']);
        Route::delete('/delete/{id}', [BlogpostController::class, 'deletePost']);
        Route::post('/store', [BlogpostController::class, 'createPost']);
        Route::post('/update/{id}', [BlogpostController::class, 'updatePost']);
    });
    // Route::resource('direktori', DirektoriController::class);
    // Route::get('/direktori', [DirektoriController::class, 'getView']);

    Route::prefix('direktori')->group(function () {
        Route::get('/', [DirektoriController::class, 'getView']);
        Route::get('/get', [DirektoriController::class, 'index']);
        Route::post('/store', [DirektoriController::class, 'store']);
        Route::delete('/delete/{id}', [DirektoriController::class, 'destroy']);
        Route::post('/update/{id}', [DirektoriController::class, 'update']);
    });

    Route::get('/user/activities', [AuthLogController::class, 'getView']);
    Route::get('/user/activities/get', [AuthLogController::class, 'index']);
    Route::get('/user/activities/get/{id}', [AuthLogController::class, 'show']);
});

Route::get('/get-cawangan/{id_city}', [RegisManpowerController::class, 'getCawanganByBahagian']);
Route::prefix('v1')->group(function () {
    Route::get('/buletin', [BlogpostController::class, 'getDataPublic']);
    Route::get('/direktori', [DirektoriController::class, 'getData']);
});

Route::prefix('emailSetting')->group(function () {
    Route::get('/', [EmailSettingController::class, 'index']);
    Route::get('/getData', [EmailSettingController::class, 'getData']);
    Route::get('/show/{id}', [EmailSettingController::class, 'show']);
    Route::post('/updateOrStore', [EmailSettingController::class, 'updateOrStore']);
});

Route::prefix('setting-brand')->group(function () {
    Route::get('/', [SettingBrandingController::class, 'getView']);
    Route::get('/detail', [SettingBrandingController::class, 'detail']);
    Route::get('/getData', [SettingBrandingController::class, 'index']);
    Route::delete('/delete/{id}', [SettingBrandingController::class, 'delete']);
    Route::post('/updateOrStore', [SettingBrandingController::class, 'updateOrStore']);
});

Route::prefix('packages')->group(function () {
    Route::get('/', [PackageSettingController::class, 'index']);
    Route::get('/getData', [PackageSettingController::class, 'getListPackage']);
    Route::post('/store', [PackageSettingController::class, 'store']);
    Route::get('/{id}', [PackageSettingController::class, 'edit']);
    Route::post('/update/{id}', [PackageSettingController::class, 'update']);
    Route::delete('/destroy/{id}', [PackageSettingController::class, 'destroy']);
});

Route::prefix('carta-organisasi')->group(function () {
    Route::get('/', [SturctureOrganizationController::class, 'getView']);
    Route::get('/getData', [SturctureOrganizationController::class, 'getData']);
    Route::get('/getAhli', [SturctureOrganizationController::class, 'getAhli']);
});


Route::get('/carta/organisasi/{id}', [SturctureOrganizationController::class, 'getDetail']);

Route::group(['middleware' => ['auth', 'registrationCompleted'],], function () {
    Route::get('/admin', function () {
        return view('admin');
    });

    // Route::get('/carta-organisasi', function () {
    //     return view('company.carta-organisasi.index');
    // });

    Route::prefix('carta-organisasi')->group(function () {
        Route::post('/save', [SturctureOrganizationController::class, 'saveStructure']);
        Route::post('/add', [SturctureOrganizationController::class, 'addPosition']);
        Route::put('/update/{id}', [SturctureOrganizationController::class, 'updatePosition']);
        Route::delete('/delete/{id}', [SturctureOrganizationController::class, 'deletePosition']);
    });

    Route::get('/request_join_bypass_approval/{id}', [App\Http\Controllers\JoinCompanyController::class, 'joinCompanyBypassApproval']);

    Route::get('/errorPaymentGateway/{ref}', [App\Http\Controllers\JoinCompanyController::class, 'errorPaymentGateway']);
    Route::get('/invoice_join_persatuan/{ref}', [JoinCompanyController::class, 'invoiceJoinCompany']);
    Route::get('/approval_jemput_ahli/{ref}', [JoinCompanyController::class, 'approvalJemputAhli']);
    Route::get('/payment_cash', [JoinCompanyController::class, 'paymentCash']);
    Route::post('/create_payment', [JoinCompanyController::class, 'createLogPayment']);

    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');

    Route::prefix('pembayaran-cawangan')->group(function () {
        Route::get('/', [PembayaranCawanganController::class, 'index']);
        Route::get('/get-data', [PembayaranCawanganController::class, 'getData']);
        Route::get('/get-cawangan', [PembayaranCawanganController::class, 'getCawangan']);
        Route::get('/detail/{id}', [PembayaranCawanganController::class, 'getDetail']);
    });

    Route::post('/payment/approval-outstading', [TransactionController::class, 'approvalPaymentOutstading']);

    Route::prefix('pembayaran-ketua-bahagian')->group(function () {
        Route::get('/', [PembayaranKetuaBahagianController::class, 'index']);
        Route::get('/get-data', [PembayaranKetuaBahagianController::class, 'getData']);
        Route::get('/get-ketua-bahagian', [PembayaranKetuaBahagianController::class, 'getKetuaBahagian']);
        Route::get('/detail/{id}', [PembayaranKetuaBahagianController::class, 'getDetail']);
    });

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/statistic', [StatistikController::class, 'index']);
    // Route::get('/transaction-bar-chart', [StatistikController::class, 'getTransactionBarChart']);
    Route::get('/chart/keahlian', [StatistikController::class, 'getAhliByBahagian'])->name('chart.keahlian');
    Route::get('/getRecentRegisterAhli', [App\Http\Controllers\HomeController::class, 'getRecentRegisterAhli']);
    Route::get('/homeManPower', [App\Http\Controllers\HomeManPowController::class, 'index'])->name('homeManPower');
    Route::get('/homeManPowerDetail/{id}', [App\Http\Controllers\HomeManPowController::class, 'index_admin'])->name('homeManPowerDetail');
    Route::get('/homeCompany', [App\Http\Controllers\HomeCompanyController::class, 'index']);
    Route::get('/homeCompany2', [App\Http\Controllers\HomeCompanyController::class, 'index2']);

    Route::prefix('status-approval')->group(function () {
        Route::get('/', [StatusApprovalController::class, 'index'])->name('status-approval');
        Route::get('/getData', [StatusApprovalController::class, 'getData']);
        Route::get('/detail/{id}', [StatusApprovalController::class, 'detail']);
        Route::get('/edit/{id}', [StatusApprovalController::class, 'edit']);
        Route::get('/info/{id}', [StatusApprovalController::class, 'getInfo']);
        Route::post('/update/{id}', [StatusApprovalController::class, 'updateApproval']);
        Route::post('/resubmit/rejection', [StatusApprovalController::class, 'resubmitApplication']);
    });

    // Route::get('/pengesahan-keahlian', [StatusApprovalController::class, 'viewPengesahanKeahlian']);

    Route::prefix('wallet')->group(function () {
        Route::get('/', [WalletController::class, 'getView']);
        Route::delete('/delete/{id}', [WalletController::class, 'delete']);
        Route::post('/store', [WalletController::class, 'updateOrCreate']);
        Route::get('/get', [WalletController::class, 'getData']);
    });

    //request update
    // Route::get('/requestUpdateCompany',[App\Http\Controllers\RequestUpdateController::class, 'index_waiting'])->name('admin.waitingRequestUpdateCompany');
    Route::get('/rejectedRequestUpdateCompany', [App\Http\Controllers\RequestUpdateController::class, 'index_rejected'])->name('admin.rejectedRequestUpdateCompany');
    Route::get('/approvedRequestUpdateCompany', [App\Http\Controllers\RequestUpdateController::class, 'index_approved'])->name('admin.approvedRequestUpdateCompany');
    // Route::get('/requestUpdateCompany',[App\Http\Controllers\RequestUpdateController::class, 'request_update_company']);
    Route::get('/clearRequestUpdateCompany', [App\Http\Controllers\RequestUpdateController::class, 'clear_request_update']);
    Route::any('/clearRequestUpdateCompany/{menu}', [App\Http\Controllers\RequestUpdateController::class, 'clear_request_update']);
    Route::any('/approveRequestUpdateCompany/{id}/{id_request}', [App\Http\Controllers\RequestUpdateController::class, 'approve_request_update']);
    Route::any('/rejectRequestUpdateCompany/{id}/{id_request}', [App\Http\Controllers\RequestUpdateController::class, 'reject_request_update']);
    Route::get('/detailRequestUpdateCompany/{id}', [App\Http\Controllers\RequestUpdateController::class, 'index_detail'])->name('admin.detailRequestUpdateCompany');

    Route::get('/log_pendaftar_persatuan', [App\Http\Controllers\JoinCompanyController::class, 'index']);
    Route::get('/log_pembayaran_ahli', [App\Http\Controllers\JoinCompanyController::class, 'logPaymentAhli']);
    Route::get('/log_pembayaran', [App\Http\Controllers\JoinCompanyController::class, 'logPayment']);


    //employment
    Route::get('/employmentDetail', [App\Http\Controllers\EmployeeController::class, 'index_employment']);
    Route::get('/employmentDetailEdit', [App\Http\Controllers\EmployeeController::class, 'edit_employment']);

    //company
    Route::get('/companyDetail', [App\Http\Controllers\CompanyController::class, 'index_company'])->name('company.detail');
    Route::get('/companyDetailEdit', [App\Http\Controllers\CompanyController::class, 'edit_company'])->name('company.edit');
    Route::get('/companyEquityBreakdownList', [App\Http\Controllers\CompanyController::class, 'index_equity'])->name('company.viewCompanyEquityBreakdown');
    Route::get('/companyEquityBreakdownEdit', [App\Http\Controllers\CompanyController::class, 'edit_equity']);

    Route::post('/update_billplz_persatuan', [App\Http\Controllers\CompanyController::class, 'updateBillplzPersatuan']);


    Route::get('/cetak_pdf/{id}', [App\Http\Controllers\CompanyController::class, 'cetak_pdf']);

    Route::get('/cetak_profil_digital', [App\Http\Controllers\EmployeeController::class, 'cetakProfilDigital']);
    Route::get('/cetak_company_card', [App\Http\Controllers\EmployeeController::class, 'cetakCompanyCard']);
    Route::get('/invoice_company_card', [App\Http\Controllers\EmployeeController::class, 'invoiceCompanyCard']);


    Route::prefix('maklumatJawatanKuasa')->group(function () {
        Route::get('/', [App\Http\Controllers\MaklumatJawatanKuasaController::class, 'index']);
        Route::post('/store', [App\Http\Controllers\MaklumatJawatanKuasaController::class, 'store']);
        Route::get('/edit/{id}', [App\Http\Controllers\MaklumatJawatanKuasaController::class, 'edit']);
        Route::post('/update/{id}', [App\Http\Controllers\MaklumatJawatanKuasaController::class, 'update']);
        Route::post('/delete/{id}', [App\Http\Controllers\MaklumatJawatanKuasaController::class, 'destroy']);
    });

    Route::get('/profilDigitalCompany', [CompanyController::class, 'profilDigitalCompany']);

    Route::get('/logPayment', [RegisManpowerController::class, 'listLogPaymentManpower']);
    Route::post('/approvalPayment/{id}', [RegisManpowerController::class, 'approvalPayment']);

    Route::post('/approvalPaymentJoinPersatuan/{id}', [JoinCompanyController::class, 'approvalPayment']);


    // Route::get('/listCompanyActive', [RegisCompanyController::class, 'index_active'])->name('company.active.index');

    Route::prefix('senaraiPersatuan')->group(function () {
        Route::get('/', [App\Http\Controllers\RegisCompanyController::class, 'index']);
        Route::any('/delete/{id}', [App\Http\Controllers\RegisCompanyController::class, 'destroy']);
    });

    Route::prefix('senaraiProduk')->group(function () {
        Route::get('/', [App\Http\Controllers\ProductController::class, 'senaraiProduk']);
        Route::get('/getData', [App\Http\Controllers\ProductController::class, 'senaraiProdukGetData']);
    });

    Route::prefix('requestUpdateCompany')->group(function () {
        Route::get('/', [App\Http\Controllers\RequestUpdateController::class, 'index']);
        // Route::any('/store', [App\Http\Controllers\RegisCompanyController::class, 'store']);
        // Route::any('/edit/{id}', [App\Http\Controllers\RegisCompanyController::class, 'edit']);
        // Route::any('/update/{id}', [App\Http\Controllers\RegisCompanyController::class, 'update']);
        // Route::any('/delete/{id}', [App\Http\Controllers\RegisCompanyController::class, 'destroy']);
    });


    Route::any('/requestCertificate', [App\Http\Controllers\CompanyController::class, 'request_certificate']);
    Route::get('/logCertificate', [App\Http\Controllers\CompanyController::class, 'index_certificate'])->name('company.viewLogCertificate');
    Route::get('/detailCertificate/{id}/{id_max}', [App\Http\Controllers\CertificateController::class, 'index'])->name('admin.logSertificate.detailCertificate');
    Route::any('/setViewCertificate/{set}', [App\Http\Controllers\CertificateController::class, 'set_view_certificate']);
    Route::get('/detailPersatuan/{id}', [App\Http\Controllers\CertificateController::class, 'index_admin']);

    // Route::get('/sijilPersatuan',[App\Http\Controllers\JoinCompanyController::class, 'sijil_persatuan']);
    Route::get('/sijilCawangan', [App\Http\Controllers\JoinCompanyController::class, 'sijil_persatuan']);
    Route::get('/sijilPersatuanView/{ref}', [App\Http\Controllers\JoinCompanyController::class, 'sijil_persatuan_view']);

    //COMPANY KEY CLIENT PROJECT
    Route::resource('companyKeyClientProject', App\Http\Controllers\CompanyKeyClientController::class);
    Route::any('/deleteTempCompanyKeyClientProject/{id}', [App\Http\Controllers\CompanyKeyClientController::class, 'temp_destroy']);
    Route::any('/createKeyClientProject', [App\Http\Controllers\CompanyKeyClientController::class, 'create']);
    Route::get('/companyKeyClientProject', [App\Http\Controllers\CompanyKeyClientController::class, 'index_keyClient'])->name('company.viewKeyClientProject');
    Route::get('/companyKeyClientProjectTemp', [App\Http\Controllers\CompanyKeyClientController::class, 'index_keyClient_temp']);
    Route::get('/companyKeyClientProjectTempAdmin/{id}/{id_request}', [App\Http\Controllers\CompanyKeyClientController::class, 'index_keyClient_temp_admin']);
    Route::get('/companyKeyClientProjectAdmin/{id}', [App\Http\Controllers\CompanyKeyClientController::class, 'index_keyClient_admin']);
    Route::any('/companyKeyClientProject/{id}', [App\Http\Controllers\CompanyKeyClientController::class, 'update']);

    //COMPANY KEY OUTSOURCE PROJECT
    Route::resource('companyOutSourceProject', App\Http\Controllers\CompanyOutSourceController::class);
    Route::any('/deleteTempCompanyOutSourceProject/{id}', [App\Http\Controllers\CompanyOutSourceController::class, 'temp_destroy']);
    Route::any('/createOutSourceProject', [App\Http\Controllers\CompanyOutSourceController::class, 'create']);
    Route::get('/companyOutSourceProject', [App\Http\Controllers\CompanyOutSourceController::class, 'index_outSource'])->name('company.viewOutSourceProject');
    Route::get('/companyOutSourceProjectTemp', [App\Http\Controllers\CompanyOutSourceController::class, 'index_outSource_temp']);
    Route::get('/companyOutSourceProjectTempAdmin/{id}/{id_request}', [App\Http\Controllers\CompanyOutSourceController::class, 'index_outSource_temp_admin']);
    Route::get('/companyOutSourceProjectAdmin/{id}', [App\Http\Controllers\CompanyOutSourceController::class, 'index_outSource_admin']);
    Route::any('/companyOutSourceProject/update/{id}', [App\Http\Controllers\CompanyOutSourceController::class, 'update']);

    //Company Segment
    Route::resource('companySegment', App\Http\Controllers\CompanySegmentController::class);
    Route::any('/deleteTempCompanySegment/{id}', [App\Http\Controllers\CompanySegmentController::class, 'temp_destroy']);
    Route::any('/createCompanySegment', [App\Http\Controllers\CompanySegmentController::class, 'create']);
    Route::any('/companySegment/{id}', [App\Http\Controllers\CompanySegmentController::class, 'update'])->name('company_segment.update');
    Route::get('/companySegment', [App\Http\Controllers\CompanySegmentController::class, 'index_segment'])->name('company.viewSegment');
    Route::get('/companySegmentTemp', [App\Http\Controllers\CompanySegmentController::class, 'index_segment_temp'])->name('company.viewSegmentTemp');
    Route::get('/companySegmentAdmin/{id}', [App\Http\Controllers\CompanySegmentController::class, 'index_segment_admin']);
    Route::get('/companySegmentTempAdmin/{id}/{id_request}', [App\Http\Controllers\CompanySegmentController::class, 'index_segment_temp_admin']);

    //Company Vendor Licenses
    Route::resource('companyVendorLicenses', App\Http\Controllers\CompanyVendorLicensesController::class);
    Route::any('/deleteTempCompanyVendorLicenses/{id}', [App\Http\Controllers\CompanyVendorLicensesController::class, 'temp_destroy']);
    Route::any('/createCompanyVendorLicenses', [App\Http\Controllers\CompanyVendorLicensesController::class, 'create']);
    Route::any('/updateCompanyVendorLicenses', [App\Http\Controllers\CompanyVendorLicensesController::class, 'update_data']);
    // Route::any('/companyVendorLicenses/{id}', [App\Http\Controllers\CompanyVendorLicensesController::class, 'update'])->name('company_vendor_licenses.update');
    Route::get('/companyVendorLicenses', [App\Http\Controllers\CompanyVendorLicensesController::class, 'index_vendor_licenses'])->name('company.viewVendorLicenses');
    Route::get('/companyVendorLicensesTemp', [App\Http\Controllers\CompanyVendorLicensesController::class, 'index_vendor_licenses_temp'])->name('company.viewVendorLicensesTemp');
    Route::get('/companyVendorLicensesAdmin/{id}', [App\Http\Controllers\CompanyVendorLicensesController::class, 'index_vendor_licenses_admin']);

    //Company Workers
    Route::resource('companyWorkers', App\Http\Controllers\CompanyWorkersController::class);
    Route::any('/deleteTempCompanyWorkers/{id}', [App\Http\Controllers\CompanyWorkersController::class, 'temp_destroy']);
    Route::any('/createCompanyWorkers', [App\Http\Controllers\CompanyWorkersController::class, 'create']);
    Route::any('/CompanyWorkers/fileCompanyWorkers/update/{id}', [App\Http\Controllers\FileController::class, 'update']);
    Route::resource('FileWorkers', App\Http\Controllers\FileController::class);
    Route::any('/updateCompanyWorkers', [App\Http\Controllers\CompanyWorkersController::class, 'update_data']);
    // Route::any('/companyWorkers/{id}', [App\Http\Controllers\CompanyWorkersController::class, 'update'])->name('company_workers.update');
    Route::get('/companyWorkers', [App\Http\Controllers\CompanyWorkersController::class, 'index'])->name('company.viewWorkers');
    Route::get('/companyWorkersTemp', [App\Http\Controllers\CompanyWorkersController::class, 'index_temp']);
    Route::get('/companyWorkersTempAdmin/{id}/{id_request}', [App\Http\Controllers\CompanyWorkersController::class, 'index_temp_admin']);
    Route::get('/companyWorkersAdmin/{id}', [App\Http\Controllers\CompanyWorkersController::class, 'index_admin']);
    Route::any('/companyWorkers/update/{id}', [App\Http\Controllers\CompanyWorkersController::class, 'update']);
    Route::any('/companyWorkers/delete_array', [App\Http\Controllers\CompanyWorkersController::class, 'delete_array'])->name('companyWorkers.delete_array');
    Route::delete('/companyWorkers/remove_file/{id}', [App\Http\Controllers\CompanyWorkersController::class, 'remove_file'])->name('remove_file');

    //COMPANY SWEC CODE
    Route::resource('companySwecCode', App\Http\Controllers\CompanySwecCodeController::class);
    Route::any('/deleteTempCompanySwecCode/{id}', [App\Http\Controllers\CompanySwecCodeController::class, 'temp_destroy']);
    Route::any('/createCompanySwecCode', [App\Http\Controllers\CompanySwecCodeController::class, 'create']);
    Route::get('/companySwecCode', [App\Http\Controllers\CompanySwecCodeController::class, 'index'])->name('company.viewSwecCode');
    Route::get('/companySwecCodeTemp', [App\Http\Controllers\CompanySwecCodeController::class, 'index_temp'])->name('company.viewSwecCodeTemp');
    Route::get('/companySwecCodeTempAdmin/{id}/{id_request}', [App\Http\Controllers\CompanySwecCodeController::class, 'index_temp_admin'])->name('company.viewSwecCodeTempAdmin');
    Route::get('/companySwecCodeAdmin/{id}', [App\Http\Controllers\CompanySwecCodeController::class, 'index_admin']);

    //COMPANY SHAREHOLDERS
    Route::resource('companyShareholders', App\Http\Controllers\CompanyShareholdersController::class);
    Route::any('/deleteTempCompanyShareholders/{id}', [App\Http\Controllers\CompanyShareholdersController::class, 'temp_destroy']);
    Route::any('/createShareholders', [App\Http\Controllers\CompanyShareholdersController::class, 'create']);
    Route::get('/companyListofShareholders', [App\Http\Controllers\CompanyShareholdersController::class, 'index_shareholders'])->name('company.viewShareholders', 'companyListofShareholder1');
    Route::get('/companyListofShareholdersTemp', [App\Http\Controllers\CompanyShareholdersController::class, 'index_shareholders_temp'])->name('company.viewShareholdersTemp');
    Route::get('/companyListofShareholdersTempAdmin/{id}/{id_request}', [App\Http\Controllers\CompanyShareholdersController::class, 'index_shareholders_temp_admin'])->name('company.viewShareholdersTempAdmin');
    Route::get('/companyListofShareholdersAdmin/{id}', [App\Http\Controllers\CompanyShareholdersController::class, 'index_shareholders_admin']);
    Route::any('/companyShareholders/{id}', [App\Http\Controllers\CompanyShareholdersController::class, 'update']);

    //list_company
    Route::resource('companyDetail', CompanyController::class);
    Route::any('/companyDetail/update/{id}', [CompanyController::class, 'update']);
    Route::get('/list_company', [RegisCompanyController::class, 'index'])->name('company.index');
    // Route::get('/listCompanyActive', [RegisCompanyController::class, 'index_active'])->name('company.index');
    // Route::get('/listCompanyActiveSabahan', [RegisCompanyController::class, 'index_active_sabahan'])->name('company.index');
    // Route::get('/listCompanyActiveOther', [RegisCompanyController::class, 'index_active_other'])->name('company.index');
    // Route::get('/listCompanyActiveForeign', [RegisCompanyController::class, 'index_active_foreign'])->name('company.index');

    //company active
    Route::get('/listCompanyActive', [RegisCompanyController::class, 'index_active'])->name('company.active.index');
    Route::any('/certifikat_company/{id}', [RegisCompanyController::class, 'certifikat_company'])->name('company.certifikat');
    Route::any('/certifikat_company_unavailable', [RegisCompanyController::class, 'certifikat_company_unavailable'])->name('company.certificate_not_available');
    Route::get('/listCompanyActiveSabahan', [RegisCompanyController::class, 'index_active_sabahan'])->name('company.active.sabahan');
    Route::get('/listCompanyActiveOther', [RegisCompanyController::class, 'index_active_other'])->name('company.active.other');
    Route::get('/listCompanyActiveForeign', [RegisCompanyController::class, 'index_active_foreign'])->name('company.active.foreign');

    //company suspend
    Route::get('/listCompanySuspend', [RegisCompanyController::class, 'index_suspend'])->name('company.suspend.index');
    Route::get('/listCompanySuspendSabahan', [RegisCompanyController::class, 'index_suspend_sabahan'])->name('company.suspend.sabahan');
    Route::get('/listCompanySuspendOther', [RegisCompanyController::class, 'index_suspend_other'])->name('company.suspend.other');
    Route::get('/listCompanySuspendForeign', [RegisCompanyController::class, 'index_suspend_foreign'])->name('company.suspend.foreign');

    //company banned
    Route::get('/listCompanyBanned', [RegisCompanyController::class, 'index_banned'])->name('company.banned.index');
    Route::get('/listCompanyBannedSabahan', [RegisCompanyController::class, 'index_banned_sabahan'])->name('company.banned.sabahan');
    Route::get('/listCompanyBannedOther', [RegisCompanyController::class, 'index_banned_other'])->name('company.banned.other');
    Route::get('/listCompanyBannedForeign', [RegisCompanyController::class, 'index_banned_foreign'])->name('company.banned.foreign');
    //TODO
    //company equity breakdown
    Route::resource('companyEquityBreakdown', CompanyEquityController::class);
    Route::any('editCompanyEquityBreakdown/{id}', [CompanyEquityController::class, 'edit_list_equity']);
    Route::any('/companyEquityBreakdown/update/{id}', [CompanyEquityController::class, 'update']);
    Route::any('/createListEquityBreakdown', [CompanyEquityController::class, 'create'])->name('company_list_equity.create');
    // Route::any('/update_position/{id}', [SettingsPositionController::class, 'update'])->name('settings_position.update');
    Route::any('/companyListEquityBreakdown/{id}', [CompanyEquityController::class, 'update_equity']);

    //list_manpower
    Route::resource('personalDetail', EmployeeController::class);
    Route::any('/personalDetail/update/{id}', [EmployeeController::class, 'update']);
    Route::get('/list_manpower', [RegisManpowerController::class, 'index'])->name('employee.index');
    Route::get('/profilDigital', [EmployeeController::class, 'profilDigital']);
    Route::get('/companyCard', [EmployeeController::class, 'companyCard']);


    //All
    Route::get('/listAllEmployed', [RegisManpowerController::class, 'all_employed'])->name('employee.all.employed');
    Route::get('/listAllUnemployed', [RegisManpowerController::class, 'all_unemployed'])->name('employee.all.unemployed');
    //Bumiputera
    Route::get('/listBumiputeraEmployed', [RegisManpowerController::class, 'bumiputera_employed'])->name('employee.bumiputera.employed');
    Route::get('/listBumiputeraUnemployed', [RegisManpowerController::class, 'bumiputera_unemployed'])->name('employee.bumiputera.unemployed');
    //Other
    Route::get('/listOtherEmployed', [RegisManpowerController::class, 'other_employed'])->name('employee.other.employed');
    Route::get('/listOtherUnemployed', [RegisManpowerController::class, 'other_unemployed'])->name('employee.other.unemployed');
    //Non
    Route::get('/listNonEmployed', [RegisManpowerController::class, 'non_employed'])->name('employee.non.employed');
    Route::get('/listNonUnemployed', [RegisManpowerController::class, 'non_unemployed'])->name('employee.non.unemployed');

    //employment detail
    // Route::resource('employmentDetail', EmploymentDetailController::class);
    Route::get('employmentDetail/{id}', [EmploymentDetailController::class, 'show']);
    Route::get('editMaklumatPendidikan/{id}', [EmploymentDetailController::class, 'editMaklumatPendidikan']);
    Route::post('maklumatPendidikan/update/{id}', [EmploymentDetailController::class, 'updateMaklumatPendidikan']);
    Route::post('maklumatPerniagaan/update/{id}', [EmploymentDetailController::class, 'updateMaklumatPerniagaan']);
    Route::get('editMaklumatPerniagaan/{id}', [EmploymentDetailController::class, 'editMaklumatPerniagaan']);
    Route::get('maklumatPerniagaan/{id}', [EmploymentDetailController::class, 'maklumatPerniagaan']);
    Route::any('/employmentDetail/update/{id}', [EmploymentDetailController::class, 'update']);

    //employment history
    Route::resource('/employmentDetail/employment_history', EmploymentHistoryController::class);
    Route::any('/store', [EmploymentHistoryController::class, 'store'])->name('employeentHistory.store');
    Route::any('/download/{filename}', [EmploymentHistoryController::class, 'download']);
    Route::any('/employmentDetail/employment_history/update/{id}', [EmploymentHistoryController::class, 'update']);
    Route::get('/getData', [EmploymentHistoryController::class, 'getData']);
    Route::get('/employmentHistoryAdmin/{id}', [EmploymentHistoryController::class, 'index_admin']);

    //summary qualification
    Route::resource('summaryQualification', SumQualificationController::class);
    Route::any('/summaryQualification/update/{id}', [SumQualificationController::class, 'update']);
    Route::get('/summaryQualification', [SumQualificationController::class, 'index'])->name('sumQualification.index');
    //admin
    Route::get('/summaryQualificationAdmin/{id}', [SumQualificationController::class, 'index_admin']);

    //waitingCertification
    Route::resource('waitingCertificate', CertificateController::class);
    Route::get('/waitingCertificate', [CertificateController::class, 'index_request_certificate'])->name('waitingCertification.index');

    //rejectedCertification
    Route::resource('rejectedCertificate', CertificateController::class);
    Route::get('/rejectedCertificate', [CertificateController::class, 'index_rejected_certificate'])->name('rejectedCertification.index');
    Route::any('/rejectCertificate', [CertificateController::class, 'reject_certificate']);

    //approvedCertification
    Route::resource('approvedCertificate', CertificateController::class);
    Route::get('/approvedCertificate', [CertificateController::class, 'index_approve_certificate'])->name('approvedCertification.index');

    Route::any('/approvalCertificate', [CertificateController::class, 'approve_certificate']);



    //other qualification
    Route::resource('otherQualification', OthQualificationController::class);
    Route::any('/otherQualification/update/{id}', [OthQualificationController::class, 'update']);
    Route::get('/otherQualification', [OthQualificationController::class, 'index'])->name('othQualification.index');
    //admin
    Route::get('/otherQualificationAdmin/{id}', [OthQualificationController::class, 'index_admin']);


    //Company Type
    Route::any('/getCompanyType', [ApiController::class, 'getCompanyType']);

    //Work type
    Route::any('/getWorkType', [ApiController::class, 'getWorkType']);

    //get position
    Route::any('/getPosition', [ApiController::class, 'getPosition']);

    //get segment
    Route::any('/getSegment', [ApiController::class, 'getSegment']);

    //get school
    Route::any('/getSchool', [ApiController::class, 'getSchool']);

    //get type school
    Route::any('/getTypeSchool', [ApiController::class, 'getTypeSchool']);

    //get status native
    Route::any('/getNative', [ApiController::class, 'getNative']);

    //Settings Position
    // Route::resource('/employmentDetail/employment_history', SettingsPositionController::class);


});

Route::middleware(['auth', 'adminAndCompany',])->group(function () {
    Route::prefix('senaraiAhli')->group(function () {
        Route::get('/', [App\Http\Controllers\SenaraiAhliController::class, 'index']);
        Route::any('/getData', [App\Http\Controllers\SenaraiAhliController::class, 'getData']);
        Route::any('/getDataAhliPersatuan', [App\Http\Controllers\SenaraiAhliController::class, 'getDataAhliPersatuan']);
        Route::any('/store', [App\Http\Controllers\SenaraiAhliController::class, 'store']);
        Route::any('/edit/{id}', [App\Http\Controllers\SenaraiAhliController::class, 'edit']);
        Route::any('/update/{id}', [App\Http\Controllers\SenaraiAhliController::class, 'update']);
        Route::any('/delete/{id}', [App\Http\Controllers\SenaraiAhliController::class, 'destroy']);
    });
});


Route::prefix('category/post')->group(function () {
    Route::get('/', [CategoryPostController::class, 'getView']);
    Route::get('/getData', [CategoryPostController::class, 'index']);
    Route::post('/store', [CategoryPostController::class, 'store']);
    Route::post('/update/{id}', [CategoryPostController::class, 'update']);
    Route::delete('/delete/{id}', [CategoryPostController::class, 'delete']);
});

Route::prefix('comunity')->group(function () {
    Route::get('/information', function () {
        return view('comunity-information.index');
    });
});

Route::middleware(['auth', 'admin',])->group(function () {
    Route::post('/ahli_import/', [SenaraiAhliController::class, 'import']);
    //get status native
    Route::resource('/settings_nation', NationController::class);
    Route::any('/list_settings_nation', [NationController::class, 'index']);
    Route::any('/update_nation/{id}', [NationController::class, 'update']);
    Route::any('/create_nation', [NationController::class, 'create']);

    //get
    Route::resource('/settings_status_education', StatusEducationController::class);
    Route::any('/list_settings_status_education', [StatusEducationController::class, 'index']);
    Route::any('/update_status_education/{id}', [StatusEducationController::class, 'update']);
    Route::any('/create_status_education', [StatusEducationController::class, 'create']);

    //get
    Route::resource('/settings_gender', GenderController::class);
    Route::any('/list_settings_gender', [GenderController::class, 'index']);
    Route::any('/update_gender/{id}', [GenderController::class, 'update']);
    // Route::any('/create_gender',[GenderController::class, 'create']);

    Route::resource('/settings_status_native', StatusNativeController::class);
    Route::any('/list_settings_status_native', [StatusNativeController::class, 'index']);
    Route::any('/update_status_native/{id}', [StatusNativeController::class, 'update']);
    Route::any('/create_status_native', [StatusNativeController::class, 'create']);

    Route::resource('/settings_marital_status', MaritalStatusController::class);
    Route::get('/list_marital_status', [MaritalStatusController::class, 'index']);
    Route::any('/create_marital_status', [MaritalStatusController::class, 'create']);
    Route::any('/update_marital_status/{id}', [MaritalStatusController::class, 'update']);

    Route::resource('/settings_position', SettingsPositionController::class);
    Route::get('/list_position', [SettingsPositionController::class, 'index']);
    Route::any('/create_position', [SettingsPositionController::class, 'create']);
    Route::any('/update_position/{id}', [SettingsPositionController::class, 'update_position']);

    Route::resource('/settings_business_activity', BusinessActivityController::class);
    Route::get('/list_settings_business_activity', [BusinessActivityController::class, 'index']);
    Route::any('/create_business_activity', [BusinessActivityController::class, 'create']);
    Route::any('/update_business_activity/{id}', [BusinessActivityController::class, 'update']);

    Route::resource('/settings_business_type', BusinessTypeController::class);
    Route::get('/list_settings_business_type', [BusinessTypeController::class, 'index']);
    Route::any('/create_business_type', [BusinessTypeController::class, 'create']);
    Route::any('/update_business_type/{id}', [BusinessTypeController::class, 'update']);

    Route::resource('/settings_study', StudyController::class);
    Route::get('/list_settings_study', [StudyController::class, 'index']);
    Route::any('/create_study', [StudyController::class, 'create']);
    Route::any('/update_study/{id}', [StudyController::class, 'update']);

    Route::resource('/settings_sub_business_activity', SubBusinessActivityController::class);
    Route::get('/list_settings_sub_business_activity', [SubBusinessActivityController::class, 'index']);
    Route::any('/create_sub_business_activity', [SubBusinessActivityController::class, 'create']);
    Route::any('/update_sub_business_activity/{id}', [SubBusinessActivityController::class, 'update']);

    Route::resource('/settings_category_product', CategoryProductController::class);
    Route::get('/list_settings_category_product', [CategoryProductController::class, 'index']);
    Route::any('/create_category_product', [CategoryProductController::class, 'create']);
    Route::any('/update_category_product/{id}', [CategoryProductController::class, 'update']);

    //Settings Qualification
    Route::resource('/settings_qualification', SettingsQualificationController::class);
    Route::get('/list_qualification', [SettingsQualificationController::class, 'index']);
    Route::any('/create_qualification', [SettingsQualificationController::class, 'create']);
    Route::any('/update_qualification/{id}', [SettingsQualificationController::class, 'update_qualification']);

    //Settings Country
    Route::resource('/settings_country', SettingsCountryController::class);
    Route::get('/list_setting_country', [SettingsCountryController::class, 'index']);
    Route::any('/create_country', [SettingsCountryController::class, 'create']);
    Route::any('/update_country/{id}', [SettingsCountryController::class, 'update_country']);

    //Settings Religion
    Route::resource('/settings_religion', SettingsReligionController::class);
    Route::get('/list_setting_religion', [SettingsReligionController::class, 'index']);
    Route::any('/create_religion', [SettingsReligionController::class, 'create']);
    Route::any('/update_religion/{id}', [SettingsReligionController::class, 'update_religion']);

    //Settings Parliament
    Route::resource('/settings_parliament', SettingsParliamentController::class);
    Route::get('/list_setting_parliament', [SettingsParliamentController::class, 'index']);
    Route::any('/create_parliament', [SettingsParliamentController::class, 'create']);
    Route::any('/update_parliament/{id}', [SettingsParliamentController::class, 'update_parliament']);
    Route::post('/settings_parliament_import/', [SettingsParliamentController::class, 'import']);
    Route::get('/settings_parliament_export/', [SettingsParliamentController::class, 'export']);


    //Settings Village Guests
    Route::resource('/settings_village_guests', SettingsVillageGuestsController::class);
    Route::get('/list_setting_village_guests', [SettingsVillageGuestsController::class, 'index']);
    Route::any('/create_village_guests', [SettingsVillageGuestsController::class, 'create']);
    Route::any('/update_village_guests/{id}', [SettingsVillageGuestsController::class, 'update_village_guests']);

    //Settings DUN
    Route::resource('/settings_dun', SettingsDUNController::class);
    Route::get('/list_setting_dun', [SettingsDUNController::class, 'index']);
    Route::any('/create_dun', [SettingsDUNController::class, 'create']);
    Route::any('/update_dun/{id}', [SettingsDUNController::class, 'update_dun']);
    Route::post('/settings_dun_import/', [SettingsDUNController::class, 'import']);
    Route::get('/settings_dun_export/', [SettingsDUNController::class, 'export']);


    //Settings State
    Route::resource('/settings_state', SettingStateController::class);
    Route::get('/list_setting_state', [SettingStateController::class, 'index'])->name('setting_state.index');
    Route::any('/create_state', [SettingStateController::class, 'create'])->name('setting_state.create');
    Route::any('/update_state/{id}', [SettingStateController::class, 'update']);

    //Settings City
    Route::resource('/settings_city', SettingsCityController::class);
    // Route::get('/list_setting_city', [SettingsCityController::class, 'index']);
    Route::get('/list_setting_data_bahagian', [SettingsCityController::class, 'index']);
    Route::any('/create_city', [SettingsCityController::class, 'create']);
    Route::any('/update_city/{id}', [SettingsCityController::class, 'update']);


    //School type
    Route::resource('/list_setting_schoolType', SettingsSchoolTypeController::class);
    Route::get('/list_setting_schoolType', [SettingsSchoolTypeController::class, 'index'])->name('settings_schooltype.index');
    Route::any('/create_schoolType', [SettingsSchoolTypeController::class, 'create'])->name('settings_schooltype.create');
    Route::any('/update_schooltype/{id}', [SettingsSchoolTypeController::class, 'update']);

    //School
    Route::resource('/settings_school', SettingsSchoolController::class);
    Route::get('/list_setting_school', [SettingsSchoolController::class, 'index']);
    Route::any('/create_school', [SettingsSchoolController::class, 'create']);
    Route::any('/update_school/{id}', [SettingsSchoolController::class, 'update']);

    //Settings Certificate
    Route::resource('/list_setting_certificate', SettingsCertificateController::class);
    Route::get('/list_setting_certificate', [SettingsCertificateController::class, 'index'])->name('settings_certificate.index');
    Route::any('/update_certificate/{id}', [SettingsCertificateController::class, 'update']);

    //Settings Yuran
    Route::resource('/list_setting_yuran', SettingsSubscribeController::class);
    Route::get('/gerbang_pembayaran', [SettingsSubscribeController::class, 'index'])->name('settings_yuran.index');
    Route::any('/update_yuran/{id}', [SettingsSubscribeController::class, 'update']);

    //Settings Term's Condition
    Route::resource('/settings_term', SettingsTermController::class);
    Route::get('/list_settings_term', [SettingsTermController::class, 'index']);
    Route::any('/create_term', [SettingsTermController::class, 'create']);
    Route::any('/update_term/{id}', [SettingsTermController::class, 'update_term']);

    //Settings Vendor
    Route::resource('/settings_vendor', SettingsVendorController::class);
    Route::get('/list_settings_vendor', [SettingsVendorController::class, 'index']);
    Route::any('/create_vendor', [SettingsVendorController::class, 'create']);
    Route::any('/update_vendor/{id}', [SettingsVendorController::class, 'update']);

    //Settings Position Shareholders
    Route::resource('/settings_position_jabatan', SettingsPositionShareholdersController::class);
    Route::get('/list_position_jabatan', [SettingsPositionShareholdersController::class, 'index']);
    Route::any('/create_position_jabatan', [SettingsPositionShareholdersController::class, 'create']);
    Route::any('/update_position_jabatan/{id}', [SettingsPositionShareholdersController::class, 'update_position']);
});

Route::middleware(['auth', 'companyAndEmployee',])->group(function () {
    Route::get('/approve_join/{id}', [App\Http\Controllers\JoinCompanyController::class, 'approveJoinCompany']);
    Route::get('/reject_join/{id}', [App\Http\Controllers\JoinCompanyController::class, 'rejectJoinCompany']);
});

Route::middleware(['auth', 'company',])->group(function () {

    Route::get('/request_join/{id}', [App\Http\Controllers\JoinCompanyController::class, 'requestJoinCompany']);

    Route::get('/setting_certificate', [SettingsCertificateController::class, 'indexPersatuan']);
    Route::get('/setting_terms_conditions', [SettingsTermController::class, 'indexTermsConditionsPersatuan']);
    Route::any('/show_persatuan/{id}', [SettingsCertificateController::class, 'showPersatuan']);
    Route::any('/update_certificate_persatuan/{id}', [SettingsCertificateController::class, 'updatePersatuan']);
    Route::any('/update_tnc_persatuan/{id}', [SettingsTermController::class, 'updatePersatuan']);
    Route::any('/edit_persatuan/{id}', [SettingsCertificateController::class, 'editPersatuan']);
});

Route::middleware(['auth', 'employee',])->group(function () {
    Route::get('/approve_join_by_email/{id}', [App\Http\Controllers\JoinCompanyController::class, 'approveJoinCompanyByEmail']);
    Route::get('/reject_join_by_email/{id}', [App\Http\Controllers\JoinCompanyController::class, 'rejectJoinCompanyByEmail']);

    Route::get('/maklumatProduk', [ProductController::class, 'index']);
    Route::get('/maklumatProduk/create', [ProductController::class, 'create']);
    Route::post('/maklumatProduk/store', [ProductController::class, 'store']);
    Route::get('/maklumatProduk/edit/{id_product}', [ProductController::class, 'edit']);
    Route::get('/maklumatProduk/show/{id_product}', [ProductController::class, 'show']);
    Route::post('/maklumatProduk/update', [ProductController::class, 'update']);
    Route::get('/maklumatProduk/destroy/{id_product}', [ProductController::class, 'destroy']);

    Route::post('/maklumatKilang/update', [SenaraiAhliController::class, 'updateFactory']);
    Route::post('/maklumatHalal/update', [SenaraiAhliController::class, 'updateHalal']);
    Route::post('/maklumatGmp/update', [SenaraiAhliController::class, 'updateGmp']);
    Route::post('/maklumatKkm/update', [SenaraiAhliController::class, 'updateKkm']);

    Route::get('/kerjasamaAgensi', [CollaborationAgencyController::class, 'index']);
    Route::any('/kerjasamaAgensi/store', [CollaborationAgencyController::class, 'store']);
    Route::get('/kerjasamaAgensi/edit/{id}', [CollaborationAgencyController::class, 'edit']);
    Route::any('/kerjasamaAgensi/update/{id}', [CollaborationAgencyController::class, 'update']);
    Route::delete('/kerjasamaAgensi/destroy/{id}', [CollaborationAgencyController::class, 'destroy']);
});

Route::get('/{code}', function ($code) {
    $auth = Auth::user();

    // Cari berdasarkan custom_link atau key_reference
    $query = DetailCompany::with('user')
        ->where('custom_link', $code)
        ->orWhere('key_reference', $code);

    $data = $query->first();
    $total_company = $query->count();

    if (!$data) {
        return "Data not found!";
    }

    $user = User::find($data->id_user);
    if (!$user) {
        return "Data not found!";
    }

    // Format phone number
    if ($user->phone_number) {
        $first = substr($user->phone_number, 0, 1);
        $second = substr($user->phone_number, 1, 1);

        if ($first . $second == "60") {
            $data->phone_number = $user->phone_number;
        } elseif ($first == "0") {
            $data->phone_number = '6' . $user->phone_number;
        } else {
            $data->phone_number = '60' . $user->phone_number;
        }
    } else {
        $data->phone_number = '-';
    }

    // Tentukan share link
    $data->share_link = env('APP_URL') . "/persatuan/" . ($data->custom_link ?? $data->key_reference);

    return view('digitalprofile.persatuan', compact('data', 'auth', 'total_company'));
})->where('code', '[A-Za-z0-9_-]+');
