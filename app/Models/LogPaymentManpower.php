<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogPaymentManpower extends Model
{
    protected $primaryKey = 'id_log_payment_manpower'; 
    
    protected $table = "tb_log_payment_manpower";

    protected $fillable = [
        'id_user',
        'id_detail_manpower',
        'day',
        'month',
        'year',
        'amount',
        'payment_proof',
        'payment_type',
        'approval',
        'approval_note',
        'approval_date',
        'approval_by',
        'created_by',
        'category'
    ];

    public function user() {
        return $this->belongsTo('\App\Models\User', 'id_user', 'id');
    }

    public function approvalBy() {
        return $this->belongsTo('\App\Models\User', 'approval_by', 'id');
    }
    public function detailManpower() {
        return $this->belongsTo(DetailManpower::class, 'id_detail_manpower');
    }
}
