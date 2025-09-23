<?php

namespace App\Http\Middleware;

use App\Models\DetailCompany;
use Closure;
use Carbon\Carbon;

class RegistrationCompleted
{
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        // dd($user);
        // return response()->json($user);

        if ($user->id_level == '2') {

            if ($user->sub_company != null) {
                $detail = \App\Models\DetailCompany::where('id_user', $user->sub_company)->first();
            } else {
                $detail = \App\Models\DetailCompany::where('id_user', $user->id)->first();
            }

            if (!$detail) {
                return response([
                    'error' => [
                        'code' => 'INSUFFICIENT_ROLE',
                        'description' => 'You are not authorized to access this resource.'
                    ]
                ], 401);
            }

            if ($detail->step_registration == 1) {
                return redirect()->to('/register_company/step_two');
            }

            if ($detail->step_registration == 2 && $detail->status_approval != "APPROVED") {
                return redirect()->to('/register_company/waiting_approval');
            }
        } else if ($user->id_level == '3') {
            $detail = \App\Models\DetailManpower::where('id_user', $user->id)->first();

            // return response()->json($detail);

            if (!$detail) {
                return response([
                    'error' => [
                        'code' => 'INSUFFICIENT_ROLE',
                        'description' => 'You are not authorized to access this resource.'
                    ]
                ], 401);
            }
            // dd($user);
            if ($detail->step_registration == 1) {
                if ($user->registered_by) {
                    $dCompany = DetailCompany::where('id_user', $user->registered_by)->first();
                    if ($dCompany) {
                        return redirect()->to('/register_ahli/step_two?daftar_persatuan=true&code=' . $dCompany->key_reference);
                    }
                    return redirect()->to('/register_ahli/step_two');
                }
                // return redirect()->to('/register_company/step_two');
                return redirect()->to('/register_ahli/step_two');
            }
            // else if($detail->step_registration == 2) {
            //     return redirect()->to('/register_ahli/step_three');
            // } 
            // else if($detail->step_registration == 3) {
            //     return redirect()->to('/register_ahli/step_four');
            // } else if($detail->step_registration == 4) {
            //     return redirect()->to('/register_ahli/step_five');
            // } else if($detail->step_registration == 5) {
            //     return redirect()->to('/register_ahli/step_six');
            // } 
            // else if($detail->step_registration == 6 && $detail->business_license_no == NULL && $detail->business_type != 1) {
            //     return redirect()->to('/register_ahli/step_four');
            // } 
            else if ($detail->subscribe_status == 'EXPIRED') {

                $payment = \App\Models\Payment::where('id_user', $user->id)->where('paid', '0')->whereDate('due_at', Carbon::today())->orderBy('id', 'DESC')->first();
                if ($payment) {
                    return redirect()->to('/register_ahli/verification_payment');
                }

                return redirect()->to('/register_ahli/invoice');
            } else if ($detail->subscribe_status == 'WAITING') {
                return redirect()->to('/register_ahli/waiting_payment_approval');
            } else if (($detail->step_registration == 2 || $detail->step_registration == 3 || $detail->step_registration == 4 || $detail->step_registration == 5 || $detail->step_registration == 6) && $detail->is_subscribe == 'FALSE' && ($detail->subscribe_status == 'UNPAID' || $detail->subscribe_status == 'REJECTED')) {
                return redirect()->to('/register_ahli/invoice');
            } else if (($detail->step_registration == 2 || $detail->step_registration == 3 || $detail->step_registration == 4 || $detail->step_registration == 5 || $detail->step_registration == 6) && $detail->is_subscribe == 'FALSE' && $detail->subscribe_status == 'WAITING') {
                return redirect()->to('/register_ahli/waiting_payment_approval');
            }
        }

        return $next($request);
    }
}
