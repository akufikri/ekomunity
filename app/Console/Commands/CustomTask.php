<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DetailManpower;
use App\Models\User;
use App\Models\SettingSubscribe;
use Illuminate\Support\Facades\Mail;

class CustomTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Your task logic here
        // This could be sending emails, generating reports, etc.
        $data = DetailManpower::where('subscribe_status', 'APPROVED')->whereDate('certificate_expired_date', '<', now())->limit(100)->get();
        $setting_subscribe = SettingSubscribe::where('subscribe_for', 'REGISTER AHLI')->where('is_active', 'ENABLE')->first();


        if(!$data->isEmpty()){

            foreach($data as $d){
                $d->subscribe_status = "EXPIRED";
                $d->save();

                $user = User::where('id', $d->id_user)->first();

                $from = env("MAIL_USERNAME", "info@g3pns.com");
                $user_name = $user->fullname;
                $user_email = isset($user->email)?$user->email:'mail@mail.com';

                $subject = "Notis Keahlian Datappk";

                $data = array('data' => $user,
                        'name' => $user_name,
                        'fee' => $setting_subscribe->price,
                        'button_url' => env('APP_URL').'/login',
                        );
                $mail = Mail::send('email.ahli_expired', $data, function($message) use ($user_name, $user_email, $from, $subject) {
                            $message->to($user_email, $user_email)->subject($subject);
                            $message->from($from,"DATAPPK");
                        });

            }

            $this->info('Data expired found!');

        } else {
            $this->info('Data expired not found!');
        }


        $this->info('Custom task executed successfully!');
        // return 0;
    }
}
