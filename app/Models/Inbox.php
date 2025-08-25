<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    use HasFactory;

    protected $table = "tb_inbox";

    static $requestJoinCompany = "REQUEST_JOIN_COMPANY";
    static $approveJoinCompany = "APPROVE_JOIN_COMPANY";
    static $rejectJoinCompany = "REJECT_JOIN_COMPANY";
    static $almostExpiredJoinCompany = "ALMOST_EXPIRED_JOIN_COMPANY";
    static $expiredJoinCompany = "EXPIRED_JOIN_COMPANY";

    static $paymentCashJoinCompany = "PAYMENT_CASH_JOIN_COMPANY";
    static $approvePaymentJoinCompany = "APPROVE_PAYMENT_JOIN_COMPANY";
    static $rejectPaymentJoinCompany = "REJECT_PAYMENT_JOIN_COMPANY";

    static $paymentSuccessCardCompany = "PAYMENT_SUCCESS_CARD_COMPANY";

    static $resubmitRejection = "RESUBMIT_REJECTION";
}
