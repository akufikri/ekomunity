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
use App\Http\Controllers\API\CommunityController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\AnnouncementController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\ActivityController;
use App\Http\Controllers\API\HistoryController;
use App\Http\Controllers\API\UserSettingsController;
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

// Registration & Auth (no auth required)
Route::post('/register', [App\Http\Controllers\API\ApiRegisterController::class, 'register']);
Route::post('/forgot-password', [LoginUserController::class, 'forgotPassword']);

// Email verification resend (authenticated)
Route::middleware('auth:sanctum')->post('/email/resend', function (\Illuminate\Http\Request $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return response()->json(['message' => 'Email already verified.'], 200);
    }
    $request->user()->sendEmailVerificationNotification();
    return response()->json(['message' => 'Verification email sent.'], 200);
})->middleware('throttle:6,1');

// Public email verification resend (no auth required — uses email param)
Route::post('/email/resend/public', function (\Illuminate\Http\Request $request) {
    $request->validate(['email' => 'required|email']);
    $user = User::where('email', $request->email)->first();
    if (!$user) {
        return response()->json(['success' => false, 'message' => 'Emel tidak dijumpai.'], 404);
    }
    if ($user->hasVerifiedEmail() || $user->is_verified == "1") {
        return response()->json(['success' => false, 'message' => 'Emel sudah disahkan.'], 200);
    }
    $user->sendEmailVerificationNotification();
    return response()->json(['success' => true, 'message' => 'Emel verifikasi telah dihantar. Sila semak peti masuk emel anda.'], 200);
})->middleware('throttle:6,1');

// All authenticated mobile API routes
Route::middleware('auth:sanctum')->group(function () {

    // Communities
    Route::get('/communities', [CommunityController::class, 'index']);
    Route::get('/communities/{id}', [CommunityController::class, 'show']);
    Route::put('/communities/{id}', [CommunityController::class, 'update']);
    Route::get('/communities/{id}/members', [CommunityController::class, 'members']);
    Route::put('/communities/{id}/members/{member_id}', [CommunityController::class, 'updateMember']);
    Route::post('/communities/{id}/invite', [CommunityController::class, 'invite']);
    Route::post('/communities/{id}/join', [CommunityController::class, 'join']);
    Route::delete('/communities/{id}/leave', [CommunityController::class, 'leave']);
    Route::get('/communities/{id}/feed', [CommunityController::class, 'feed']);

    // User Communities
    Route::get('/user/communities', [CommunityController::class, 'userCommunities']);
    Route::get('/user/community-members', [CommunityController::class, 'myMembers']);

    // User Settings
    Route::put('/user/settings', [UserSettingsController::class, 'update']);
    Route::get('/member/qr', [UserSettingsController::class, 'memberQr']);

    // Announcements
    Route::get('/announcements', [AnnouncementController::class, 'index']);
    Route::get('/announcements/{id}', [AnnouncementController::class, 'show']);

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount']);
    Route::put('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);
    Route::get('/notifications/{id}', [NotificationController::class, 'show']);
    Route::put('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);

    // Payments
    Route::get('/payments', [PaymentController::class, 'index']);
    Route::get('/payments/outstanding', [PaymentController::class, 'outstanding']);
    Route::get('/payments/{id}', [PaymentController::class, 'show']);

    // Activities
    Route::get('/activities', [ActivityController::class, 'index']);
    Route::get('/activities/{id}', [ActivityController::class, 'show']);
    Route::post('/activities/{id}/rsvp', [ActivityController::class, 'rsvp']);
    Route::delete('/activities/{id}/rsvp', [ActivityController::class, 'cancelRsvp']);

    // Transaction History
    Route::get('/transactions', [HistoryController::class, 'index']);
    Route::get('/transactions/{id}', [HistoryController::class, 'show']);
});

Route::get('/communities/{id}/qr', [CommunityController::class, 'qrCode']);


Route::any('/getCountry', [ApiController::class, 'getCountry']);
Route::any('/getState', [ApiController::class, 'getState']);
Route::any('/getCity', [ApiController::class, 'getCity']);
Route::any('/getParliament', [ApiController::class, 'getParliament']);
Route::any('/getDun', [ApiController::class, 'getDun']);
Route::any('/getNation', [ApiController::class, 'getNation']);
Route::any('/getReligion', [ApiController::class, 'getReligion']);
Route::any('/getCawangan', [ApiController::class, 'getCawangan']);
Route::any('/getGender', [ApiController::class, 'getGender']);
