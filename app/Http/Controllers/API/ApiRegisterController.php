<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiRegisterController extends Controller
{
    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_level' => ['required', 'integer'],
            'fullname' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'numeric'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = new User;
        $user->fullname = $request->fullname;
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->id_level = $request->id_level;
        $user->password = Hash::make($request->password);

        if ($request->id_level == 4) {
            $user->id_city = $request->id_city;
            $user->no_ros = $request->no_ros;
            $user->kod_bahagian = $request->kod_bahagian;
            $user->status_ros = $request->status_ros;
        }

        $user->save();

        try {
            event(new Registered($user));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send verification email: ' . $e->getMessage());
        }

        return response()->json([
            'message' => 'User registered successfully. Please check your email to verify your account.',
            'user' => $user
        ], 201);
    }
}
