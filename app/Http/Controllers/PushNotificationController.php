<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kutia\Larafirebase\Messages\FirebaseMessage;

use Notification;
use App\Notifications\SendPushNotification;

class PushNotificationController extends Controller
{

    public function setToken(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        $token = $request->fcm_token;

        $user->fcm_token = $token;

        $user->save();
        
        return response()->json([
            'message' => 'Successfully Updated FCM Token'
        ]);
    }

    public function sendPushNotification1(Request $request)
    {
        $FcmToken = $request->fcm_token;

        $firebase = (new Factory)
            ->withServiceAccount(__DIR__.'/../../../config/firebase_credentials.json');

        $messaging = $firebase->createMessaging();

        $message = CloudMessage::fromArray([
            'token' => $FcmToken,
            'notification' => [
                'title' => $request->title,
                'body' => $request->body
            ],
        ]);

        $messaging->send($message);

        return response()->json(['message' => 'Push notification sent successfully']);
    }

    public function sendPushNotification(Request $request){
        // $request->validate([
        //     'title'=>'required',
        //     'message'=>'required'
        // ]);
    
        try{
            $fcmTokens = User::whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
    
            Notification::send(null,new SendPushNotification($request->title,$request->body,$request->fcm_token));
    
            /* or */
    
            //auth()->user()->notify(new SendPushNotification($title,$message,$fcmTokens));
    
            /* or */
    
            // Larafirebase::withTitle($request->title)
            //     ->withBody($request->body)
            //     ->sendMessage($request->fcm_token);

            return response()->json(['message' => 'Push notification sent successfully']);

    
            // return redirect()->back()->with('success','Notification Sent Successfully!!');
    
        }catch(\Exception $e){
            report($e);
            return redirect()->back()->with('error','Something goes wrong while sending notification.');
        }
    }

    public function sendPushNotification5(Request $request){

        Notification::send(null,new SendPushNotification($request->title,$request->body,$request->fcm_token));

        return response()->json(['message' => 'Push notification sent successfully']);


    }


}