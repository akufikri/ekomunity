<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\Models\User;
use App\Models\Inbox;
use App\Models\InboxRecipient;
use App\Models\DetailManpower;
use App\Models\JoinCompany;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LoginUserController extends Controller
{

    public function redirectToGoogle()
    {

        return Socialite::driver('google')->redirect();

    }

    public function handleGoogleCallback()
    {
        try {

            $user = Socialite::driver('google')->user();

            $finduser = User::where('email', $user->email)->first();
            
            if($finduser){

                Auth::login($finduser);

                if($finduser->id_level == "1" || $finduser->id_level == "4") {
                    return redirect()->to('home'); 
                }
                if($finduser->id_level == "2"){
                    return redirect()->to('homeCompany'); 
                }
                
                if($finduser->id_level == "3"){

                    $manpower = DetailManpower::where('id_user', $finduser->id)->first();

                    if (isset($manpower)) {
                        if($manpower->key_reference == null || $manpower->key_reference == "") {
                                                
                            $key_reference = Str::random(6);
        
                            $cek = DetailManpower::where('key_reference', $key_reference)->first();
                            if($cek) {
                                $key_reference = Str::random(6);
                                $cek = DetailManpower::where('key_reference', $key_reference)->first();
                                if($cek) {
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

            }else{
                
                return redirect("/register_ahli/create?email=$user->email");  

            }

        } catch (Exception $e) {

            return redirect('auth/google');

        }

    }
   
    public function login(Request $request)
    {
        
        if(Auth::user()){
            Auth::logout();
        }
        
        $user = DB::table('users')->where('email', $request->email)->first();
        
        if(!$user){
            return $this->commitResponse('Login Failed! Incorrect Email');
        }
        
        
        if($user->is_verified != "1"){
            return $this->commitResponse('Please verify your email first!');
        }
        if (Auth::attempt(['email' => $request->email,'password' => $request->password])){
            
            $user = User::where('id', $user->id)->first();

            $user->fcm_token = $request->fcm_token;
            $user->save();

            if($user->id_level == "3") {
                $manpower = DetailManpower::where('id_user', $user->id)->first();

                if($manpower->key_reference == "" || $manpower->key_reference == null) {
                    $key_reference = Str::random(6);

                    $cek = DetailManpower::where('key_reference', $key_reference)->first();
                    if($cek) {
                        $key_reference = Str::random(6);
                        $cek = DetailManpower::where('key_reference', $key_reference)->first();
                        if($cek) {
                            $key_reference = Str::random(6);
                        }
                    }

                    $manpower->key_reference = $key_reference;
                    $manpower->save();
                }
        
                $join_company_expired = JoinCompany::select('id','id_detail_company','id_detail_manpower','expired_at')->with([
                    'company' => function ($query) {
                        $query->select('id_detail_company', 'full_company_name');
                    }
                ])->where('id_detail_manpower', $manpower->id_detail_manpower)->whereDate('expired_at', '<', now())->get();

                $join_company_almost_expired = JoinCompany::select('id','id_detail_company','id_detail_manpower','expired_at')->with([
                    'company' => function ($query) {
                        $query->select('id_detail_company', 'full_company_name');
                    }
                ])->where('id_detail_manpower', $manpower->id_detail_manpower)->whereRaw('DATEDIFF(expired_at,now()) = 7')->get();

                foreach ($join_company_expired as $d) {

                    $inbox_join_company_expired = InboxRecipient::whereHas('inbox', function($query) use($d) {
                        $query->where('trigger_inbox', Inbox::$expiredJoinCompany);
                        $query->where('id_join_company', $d->id);
                    })->where('recipient', $user->id)->orderBy('id', 'DESC')->first();

                    if(!$inbox_join_company_expired){
                        $company = isset($d->company->full_company_name) ? $d->company->full_company_name : '-';
                        $recipient = [$user->id];
        
                        $this->submitInbox($manpower->id_user, $recipient, "Keahlian Persatuan", "Keahlian Persatuan $company tamat.", Inbox::$expiredJoinCompany, $d->id);
                    } else {
                        continue;
                    }

                } 
                
                foreach ($join_company_almost_expired as $d) {

                    $inbox_join_company_almost_expired = InboxRecipient::whereHas('inbox', function($query) use($d) {
                        $query->where('trigger_inbox', Inbox::$almostExpiredJoinCompany);
                        $query->where('id_join_company', $d->id);
                    })->where('recipient', $user->id)->orderBy('id', 'DESC')->first();

                    if(!$inbox_join_company_almost_expired){
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
        
        if(Auth::user()){
            Auth::logout();
        }
        
        $user = User::where('email', $request->email)->first();
        
        if(!$user){

            return [
                'isSuccess' => false,
                'message' => 'Login Failed! Incorrect Email',
            ];
            
        }
        
        
        if($user->is_verified != "1"){

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
}