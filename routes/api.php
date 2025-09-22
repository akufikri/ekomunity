<?php

use App\Http\Controllers\MaklumatJawatanKuasaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use App\Http\Controllers\PushNotificationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
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
