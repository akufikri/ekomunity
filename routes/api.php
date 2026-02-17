<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\MaklumatJawatanKuasaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use App\Http\Controllers\PushNotificationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginUserController;
use App\Http\Controllers\MemberController;
use App\Models\DetailCompany;
use App\Models\Inbox;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Authentication Routes
Route::post('/login', [LoginUserController::class, 'apiLogin']);
Route::middleware('auth:sanctum')->get('/me', [LoginUserController::class, 'me']);
Route::middleware('auth:sanctum')->post('/logout', [LoginUserController::class, 'apiLogout']);
Route::middleware('auth:sanctum')->post('/refresh-token', [LoginUserController::class, 'refreshToken']);
Route::middleware('auth:sanctum')->post('/profile', [UserController::class, 'updateProfile']);

// Ketua Bahagian Routes
Route::middleware('auth:sanctum')->get('/total-member', [LoginUserController::class, 'getTotalMember']);
Route::middleware('auth:sanctum')->get('/total-event', [LoginUserController::class, 'getTotalEvent']);
Route::middleware('auth:sanctum')->get('/members/{id}', [LoginUserController::class, 'getMemberDetail']);
Route::middleware('auth:sanctum')->get('/members', [LoginUserController::class, 'getMember']);

// Member CRUD Routes (RESTful API)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/member', [MemberController::class, 'index']);           // List all members
    Route::get('/member/{id}', [MemberController::class, 'show']);       // Get member detail
    Route::post('/member', [MemberController::class, 'store']);          // Create new member
    Route::put('/member/{id}', [MemberController::class, 'update']);     // Update member
    Route::delete('/member/{id}', [MemberController::class, 'destroy']); // Delete member
});

Route::get('/countries-data', [UserController::class, 'getCountry']);
Route::get('/states-data/{id_country}', [UserController::class, 'getState']);
Route::get('/cities-data/{id_state}', [UserController::class, 'getCity']);

Route::get('/getPosition', [MaklumatJawatanKuasaController::class, "getPosition"]);
Route::post('/updateMaklumatJawatan/{id_manpower_position}', [MaklumatJawatanKuasaController::class, "updateMaklumatJawatan"]);

Route::post('/send-notification', [PushNotificationController::class, 'sendPushNotification']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/projectionDataAhli', [App\Http\Controllers\ApiController::class, 'projectionDataAhli']);
Route::get('/projectionDataBusinessType', [App\Http\Controllers\ApiController::class, 'projectionDataBusinessType']);
Route::get('/projectionDataGender', [App\Http\Controllers\ApiController::class, 'projectionDataGender']);
Route::get('/projectionDataNation', [App\Http\Controllers\ApiController::class, 'projectionDataNation']);
Route::get('/projectionDataMarital', [App\Http\Controllers\ApiController::class, 'projectionDataMarital']);
Route::get('/projectionDataAge', [App\Http\Controllers\ApiController::class, 'projectionDataAge']);
Route::get('/projectionDataBusinessActivity', [App\Http\Controllers\ApiController::class, 'projectionDataBusinessActivity']);

Route::post('/verifyAhli', [App\Http\Controllers\ApiController::class, 'verifyAhli']);
Route::post('/updateAhli', [App\Http\Controllers\ApiController::class, 'updateAhli']);
Route::get('/getDataAhli/{email}', [App\Http\Controllers\ApiController::class, 'getDataAhli']);

Route::post('/create-transaction', [TransactionController::class, 'createTransaction']);

Route::any('/callback-toyyibpay', [TransactionController::class, 'callback']);

// Registration Route
Route::post('/register', [App\Http\Controllers\API\ApiRegisterController::class, 'register']);


Route::any('/getCountry', [ApiController::class, 'getCountry']);
Route::any('/getState', [ApiController::class, 'getState']);
Route::any('/getCity', [ApiController::class, 'getCity']);
Route::any('/getParliament', [ApiController::class, 'getParliament']);
Route::any('/getDun', [ApiController::class, 'getDun']);
Route::any('/getNation', [ApiController::class, 'getNation']);
Route::any('/getReligion', [ApiController::class, 'getReligion']);
Route::any('/getCawangan', [ApiController::class, 'getCawangan']);
Route::any('/getGender', [ApiController::class, 'getGender']);