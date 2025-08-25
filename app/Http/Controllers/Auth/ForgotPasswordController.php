<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;


use App\Models\User;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function resetPassword(Request $request) {

        $user = User::where('email', $request->email_reset)->first();

        if(!$user) {
            return redirect()->back()->with('failed', 'Reset Password failed, email user not found');   
        }

        $generatePassword = Str::random(16);

        try {
            $this->sendNewPassword($user->id, $generatePassword);
            $user->password = Hash::make($generatePassword);
            $user->save();
            return redirect()->back()->with('success', 'Reset Password successfuly, check your email');
        } catch (\Throwable $th) {
            return redirect()->back()->with('failed', 'Reset Password failed, email sender can not send, please contact Admin!');   
        }

    }

}
