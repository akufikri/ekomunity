<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DetailManpower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserSettingsController extends Controller
{
    /**
     * PUT /api/user/settings
     * Update settings pengguna (FCM token, password, etc.)
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'fcm_token'            => 'nullable|string',
            'current_password'     => 'nullable|string',
            'new_password'         => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Update FCM token for push notifications
        if ($request->filled('fcm_token')) {
            if (in_array('fcm_token', $user->getFillable())) {
                $user->fcm_token = $request->fcm_token;
            }
        }

        // Change password
        if ($request->filled('new_password')) {
            if (!$request->filled('current_password')) {
                return response()->json(['message' => 'Kata laluan semasa diperlukan'], 422);
            }

            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json(['message' => 'Kata laluan semasa tidak betul'], 422);
            }

            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return response()->json(['success' => true, 'message' => 'Tetapan berjaya dikemaskini']);
    }

    /**
     * GET /api/member/qr
     * QR Code untuk verifikasi keahlian ahli sendiri
     */
    public function memberQr(Request $request)
    {
        $user = $request->user();

        $manpower = DetailManpower::where('id_user', $user->id)->first();

        if (!$manpower) {
            return response()->json(['success' => false, 'message' => 'Maklumat ahli tidak dijumpai'], 404);
        }

        $baseUrl = rtrim(config('app.frontend_url', 'https://ekomuniti.my'), '/');

        return response()->json([
            'success'       => true,
            'key_reference' => $manpower->key_reference,
            'qr_data'       => "{$baseUrl}/ahli/{$manpower->key_reference}",
        ]);
    }
}
