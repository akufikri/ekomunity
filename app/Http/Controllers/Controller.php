<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Support\Facades\Crypt;

use App\Models\Inbox;
use App\Models\InboxRecipient;
use App\Models\PublishedCertificate;
use App\Models\DetailCompany;
use App\Models\DetailManpower;
use App\Models\Certifikat;
use App\Models\JoinCompany;
use App\Models\State;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function commitResponse($message, $isSuccess = false, $data = null)
    {

        $result = [
            'newToken' => csrf_token(),
            'isSuccess' => $isSuccess,
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($result);
    }

    public function adjustPhoneNumberMy($phone)
    {
        if (substr($phone, 0, 3) == "600") {
            $phone = substr($phone, 2);
            $phone = "6$phone";
        } else if (substr($phone, 0, 2) == "60") {
            $phone = $phone;
        } else if (substr($phone, 0, 1) == "0") {
            $phone = "6$phone";
        } else if (substr($phone, 0, 1) != "0") {
            $phone = "60$phone";
        } else {
            $phone = $phone;
        }

        return $phone;
    }

    public function sendEmailVerification($id_user, $daftar_persatuan = null, $code = null)
    {

        $user = \App\Models\User::where('id', $id_user)->first();

        if (!$user) {
            return false;
        }

        $from = env("MAIL_USERNAME", "info@g3pns.com");
        $user_name = $user->fullname;
        $user_email = isset($user->email) ? $user->email : 'mail@mail.com';

        $msg = "Terima Kasih kerana mendaftar! Teruskan proses pendaftaran dengan klik butang dibawah untuk sahkan emel anda.";

        if ($user->id_level == 3) {
            $msg = "Selamat datang! Untuk meneruskan proses pendaftaran anda, tekan butang dibawah untuk sahkan emel anda.";
        }

        $subject = "Sahkan emel anda";
        // $user->markEmailAsVerified();

        if ($daftar_persatuan) {
            $verify_url = "/verify_email?id=$user->id&daftar_persatuan=$daftar_persatuan&code=$code";
        } else {
            $verify_url = "/verify_email?id=$user->id";
        }

        $data = array(
            'data' => $user,
            'msg' => $msg,
            'name' => $user_name,
            'verify_url' => $verify_url,
        );
        $mail = \Mail::send('email.user_verify', $data, function ($message) use ($user_name, $user_email, $from, $subject) {
            $message->to($user_email, $user_email)->subject($subject);
            $message->from($from, "USIA");
        });

        return true;
    }

    public function sendEmailInvoice($id_user)
    {

        $user = \App\Models\User::where('id', $id_user)->first();
        $detail = \App\Models\DetailManpower::where('id_user', $user->id)->first();
        $setting_subscribe = \App\Models\SettingSubscribe::where('subscribe_for', 'REGISTER AHLI')->where('is_active', 'ENABLE')->first();

        $from = env("MAIL_USERNAME", "info@g3pns.com");
        $user_name = $user->fullname;
        $user_email = isset($user->email) ? $user->email : 'mail@mail.com';

        $subject = "Invoice";

        $data = array(
            'user' => $user,
            'detail' => $detail,
            'setting_subscribe' => $setting_subscribe,
            'url_payment' => env('APP_URL') . "/payment"
        );
        $mail = \Mail::send('email.invoice', $data, function ($message) use ($user_name, $user_email, $from, $subject) {
            $message->to($user_email, $user_email)->subject($subject);
            $message->from($from, "DATAPPK");
        });

        return true;
    }

    public function sendNewPassword($id_user, $password)
    {

        $user = \App\Models\User::where('id', $id_user)->first();

        $from = env("MAIL_USERNAME", "info@g3pns.com");
        $user_name = $user->fullname;
        $user_email = isset($user->email) ? $user->email : 'mail@mail.com';

        $msg = $password;

        $subject = "Reset Password";

        $data = array(
            'data' => $user,
            'msg' => $msg,
            'name' => $user_name,
        );
        $mail = \Mail::send('email.reset_password', $data, function ($message) use ($user_name, $user_email, $from, $subject) {
            $message->to($user_email, $user_email)->subject($subject);
            $message->from($from, "DATAPPK");
        });

        return true;
    }

    public function sendEmailApproveJoinCompany($id_join_company)
    {

        $join_company = \App\Models\JoinCompany::where('id', $id_join_company)->first();
        $manpower = \App\Models\DetailManpower::where('id_detail_manpower', $join_company->id_detail_manpower)->first();
        $company = \App\Models\DetailCompany::where('id_detail_company', $join_company->id_detail_company)->first();
        $user = \App\Models\User::where('id', $manpower->id_user)->first();


        $from = env("MAIL_USERNAME", "info@g3pns.com");
        $user_name = $user->fullname;
        $user_email = isset($user->email) ? $user->email : 'mail@mail.com';

        $subject = "Pemberitahuan Perniaga";

        $encrypt = Crypt::encryptString($id_join_company);

        $data = array(
            'name' => $user_name,
            'company' => $company->full_company_name,
            'joining_fee' => $join_company->joining_fee,
            'button_url' => env('APP_URL') . "/invoice_join_persatuan/$encrypt",
        );
        $mail = \Mail::send('email.approve_join_company', $data, function ($message) use ($user_name, $user_email, $from, $subject) {
            $message->to($user_email, $user_email)->subject($subject);
            $message->from($from, "DATAPPK");
        });

        $recipient = [$manpower->id_user];
        $this->submitInbox($company->id_user, $recipient, "Pemberitahuan Perniaga", "Permohonan anda mendaftar di Persatuan $company->full_company_name TELAH DISAHKAN oleh pentadbir persatuan. Yuran dikenakan adalah RM$join_company->joining_fee setahun. Sila membuat pembayaran.", Inbox::$approveJoinCompany);

        return true;
    }

    public function sendEmailRejectJoinCompany($id_join_company)
    {

        $join_company = \App\Models\JoinCompany::where('id', $id_join_company)->first();
        $manpower = \App\Models\DetailManpower::where('id_detail_manpower', $join_company->id_detail_manpower)->first();
        $company = \App\Models\DetailCompany::where('id_detail_company', $join_company->id_detail_company)->first();
        $user = \App\Models\User::where('id', $manpower->id_user)->first();


        $from = env("MAIL_USERNAME", "info@g3pns.com");
        $user_name = $user->fullname;
        $user_email = isset($user->email) ? $user->email : 'mail@mail.com';

        $subject = "Pemberitahuan Perniaga";
        // $user->markEmailAsVerified();

        if ($company->phone_office != null) {
            $direct_wa = "https://api.whatsapp.com/send/?phone=$company->phone_office&type=phone_number&app_absent=0";
        } else {
            $direct_wa = null;
        }

        $data = array(
            'name' => $user_name,
            'company' => $company->full_company_name,
            'button_url' => $direct_wa,
        );
        $mail = \Mail::send('email.reject_join_company', $data, function ($message) use ($user_name, $user_email, $from, $subject) {
            $message->to($user_email, $user_email)->subject($subject);
            $message->from($from, "DATAPPK");
        });

        $recipient = [$manpower->id_user];
        $this->submitInbox($company->id_user, $recipient, "Pemberitahuan Perniaga", "Harap maaf, Permohonan anda mendaftar di Persatuan $company->full_company_name TIDAK DISAHKAN oleh pentadbir persatuan. Sila hubungi Setiausaha Persatuan.", Inbox::$rejectJoinCompany);

        return true;
    }

    public function sendEmailRequestJoinCompany($id_join_company)
    {

        $join_company = \App\Models\JoinCompany::where('id', $id_join_company)->first();
        $manpower = \App\Models\DetailManpower::where('id_detail_manpower', $join_company->id_detail_manpower)->first();
        $company = \App\Models\DetailCompany::where('id_detail_company', $join_company->id_detail_company)->first();
        $user = \App\Models\User::where('id', $manpower->id_user)->first();
        $user_company = \App\Models\User::where('id', $company->id_user)->first();


        $from = env("MAIL_USERNAME", "info@g3pns.com");
        $user_name = $user->fullname;

        $company_email = isset($user_company->email) ? $user_company->email : 'mail@mail.com';

        $subject = "Notis Datappk";
        // $user->markEmailAsVerified();

        $data = array(
            'company' => $company->full_company_name,
            'manpower' => $user_name,
            'button_url' => env('APP_URL') . '/log_pendaftar_persatuan',
        );
        $mail = \Mail::send('email.request_join_company', $data, function ($message) use ($user_name, $company_email, $from, $subject) {
            $message->to($company_email, $company_email)->subject($subject);
            $message->from($from, "DATAPPK");
        });

        $recipient = [$company->id_user];
        $this->submitInbox($manpower->id_user, $recipient, "Notis Datappk", "Ada permohonan mendaftar di Persatuan $company->full_company_name oleh $user_name. Sila sahkan pendaftaran.", Inbox::$requestJoinCompany);

        return true;
    }

    public function sendEmailJemputanJoinCompany($id_join_company)
    {

        $join_company = \App\Models\JoinCompany::where('id', $id_join_company)->first();
        $manpower = \App\Models\DetailManpower::where('id_detail_manpower', $join_company->id_detail_manpower)->first();
        $company = \App\Models\DetailCompany::where('id_detail_company', $join_company->id_detail_company)->first();
        $user = \App\Models\User::where('id', $manpower->id_user)->first();
        $user_company = \App\Models\User::where('id', $company->id_user)->first();


        $from = env("MAIL_USERNAME", "info@g3pns.com");
        $user_name = $user->fullname;

        $email = isset($user->email) ? $user->email : 'mail@mail.com';

        $subject = "Jemputan Ahli";

        $data = array(
            'company' => $company->full_company_name,
            'manpower' => $user_name,
            'yuran' => $company->joining_fee,
            'approve_url' => env('APP_URL') . "/approve_join_by_email/$join_company->id",
            'reject_url' => env('APP_URL') . "/reject_join_by_email/$join_company->id",
        );
        $mail = \Mail::send('email.jemputan_ahli', $data, function ($message) use ($user_name, $email, $from, $subject) {
            $message->to($email, $email)->subject($subject);
            $message->from($from, "DATAPPK");
        });

        $recipient = [$manpower->id_user];
        $this->submitInbox($company->id_user, $recipient, "Jemputan Ahli", "Persatuan $company->full_company_name menjemput anda untuk menyertai dengan yuran RM$company->joining_fee setahun.", Inbox::$requestJoinCompany);

        return true;
    }

    public function submitInbox($sender, $recipient, $title, $message, $trigger_inbox, $id_join_company = null)
    {

        $inbox = new Inbox();
        $inbox->sender = $sender;
        $inbox->title = $title;
        $inbox->message = $message;
        $inbox->trigger_inbox = $trigger_inbox;
        $inbox->id_join_company = $id_join_company;
        $inbox->save();

        foreach ($recipient as $r) {

            $recipient = new InboxRecipient();
            $recipient->id_inbox = $inbox->id;
            $recipient->recipient = $r;
            $recipient->save();
        }

        return true;
    }

    public function sendEmailNoticeAhliRegistered($id_user)
    {

        $user = \App\Models\User::where('id', $id_user)->first();
        $detail = \App\Models\DetailManpower::where('id_user', $user->id)->first();
        $app_config = \App\Models\AppConfig::first();
        $city = \App\Models\City::where('id_city', $detail->id_city)->first();

        $count_uncompleted = \App\Models\DetailManpower::where('step_registration', '<', \App\Models\DetailManpower::$stepRegistration)->get()->count();

        $pejabat_daerah = '-';

        if ($detail->id_pegawai_daerah != null) {
            $user_pejabat = \App\Models\User::where('id', $detail->id_pegawai_daerah)->where('id_level', '4')->first();

            if ($user) {
                $pejabat_daerah = $user_pejabat->fullname;
            }
        }

        $from = env("MAIL_USERNAME", "info@g3pns.com");
        $user_name = $user->fullname;

        $user_email = isset($app_config->email) ? $app_config->email : 'mail@mail.com';

        $subject = "Pendaftaran Ahli Datappk baharu!";

        $data = array(
            'tarikh_pendaftaran' => $user->created_at,
            'nama_ahli' => $user_name,
            'nric' => $detail->ic_number,
            'pembayaran_ahli' => 0,
            'daerah' => $city->city,
            'pejabat_daerah' => $pejabat_daerah,
            'nama_perniagaan' => $detail->name_of_business,
            'jumlah_pendaftar' => $count_uncompleted,
            'button_url' => env('APP_URL'),
        );
        $mail = \Mail::send('email.notice_ahli_registered', $data, function ($message) use ($user_name, $user_email, $from, $subject) {
            $message->to($user_email, $user_email)->subject($subject);
            $message->from($from, "DATAPPK");
        });

        return true;
    }

    public function generateCertificateNumber($id_user, $type, $id_persatuan = null)
    {

        $published = PublishedCertificate::where('id_user', $id_user)->orderBy('id_published_certificate', 'DESC')->first();
        $valid_time = "1";

        if (!$published) {
            $publish = new PublishedCertificate();
            $running_number = PublishedCertificate::orderBy('id_published_certificate', 'desc')->first();

            if ($running_number) {
                $add_number = ((int)$running_number->number_certificate) + 1;
                $next_number = str_pad($add_number, 6, '0', STR_PAD_LEFT);
            } else {
                $next_number = str_pad(1, 6, '0', STR_PAD_LEFT);
            }

            $newDateTime = Carbon::now()->addYear(1);

            if ($type == "PERSATUAN") {
                $detail = DetailCompany::where('id_user', $id_user)->first();
            } else if ($type == "AHLI") {
                $detail = DetailManpower::where('id_user', $id_user)->first();
            }

            if ($type == "PERSATUAN" || $type == "AHLI") {
                $detail->number_certificate = $next_number;
                $detail->valid_time_certificate = $valid_time;
                $detail->certificate_expired_date = $newDateTime;
                $detail->save();
            }

            $publish->id_user = $id_user;
            $publish->number_certificate = $next_number;
            $publish->expire_date = $newDateTime;
            $publish->save();
        }

        $published = PublishedCertificate::where('id_user', $id_user)->orderBy('id_published_certificate', 'DESC')->first();

        if ($published) {

            if ($type == "PERSATUAN") {
                $detail = DetailCompany::where('id_user', $id_user)->first();

                if ($detail->number_certificate == null || $detail->number_certificate == "") {
                    $detail->number_certificate = $published->number_certificate;
                    $detail->save();
                }
            } else if ($type == "AHLI") {
                $detail = DetailManpower::where('id_user', $id_user)->first();

                if ($detail->number_certificate == null || $detail->number_certificate == "") {
                    $detail->number_certificate = $published->number_certificate;
                    $detail->save();
                }
            }
        }

        $prefix = "A";
        if ($type == "PERSATUAN") {
            $prefix = "P";
            $detail = DetailCompany::where('id_user', $id_user)->first();
        } else if ($type == "AHLI" || $type == "AHLI_PERSATUAN") {
            $prefix = "A";
            $detail = DetailManpower::where('id_user', $id_user)->first();
        }

        // $abbreviation = $detail->state->abbreviation;
        $abbreviation = "EKO";
        $created_at = date('Ymd', strtotime($detail->created_at));

        $generate_number = $abbreviation . "/" . $created_at . "/" . $prefix . $published->number_certificate;

        if ($type == "AHLI_PERSATUAN") {

            $detail = DetailManpower::where('id_user', $id_user)->first();
            $join = JoinCompany::where('id_detail_manpower', $detail->id_detail_manpower)->orderBy('id', 'desc')->first();

            $created_at = date('Ymd', strtotime($join->created_at));

            $published_persatuan = PublishedCertificate::where('id_user', $id_persatuan)->orderBy('id_published_certificate', 'DESC')->first();

            if (!$published_persatuan) {
                $published_persatuan = new PublishedCertificate();
                $running_number = PublishedCertificate::orderBy('id_published_certificate', 'desc')->first();

                if ($running_number) {
                    $add_number = ((int)$running_number->number_certificate) + 1;
                    $next_number = str_pad($add_number, 6, '0', STR_PAD_LEFT);
                } else {
                    $next_number = str_pad(1, 6, '0', STR_PAD_LEFT);
                }

                $newDateTime = Carbon::now()->addYear(1);

                $detail = DetailCompany::where('id_user', $id_persatuan)->first();

                $detail->valid_time_certificate = $valid_time;
                $detail->certificate_expired_date = $newDateTime;
                $detail->save();

                $published_persatuan->id_user = $id_user;
                $published_persatuan->number_certificate = $next_number;
                $published_persatuan->expire_date = $newDateTime;
                $published_persatuan->save();
            }


            $generate_number = $abbreviation . "/P" . $published_persatuan->number_certificate . "/" . $created_at . "/A" . $published->number_certificate;
        }

        return $generate_number;
    }
}
