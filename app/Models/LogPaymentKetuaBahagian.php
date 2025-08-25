<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogPaymentKetuaBahagian extends Model
{
    use SoftDeletes;
    protected $table = 'tb_log_payment_ketua_bahagian';

    protected $fillable = [
        'id_payment',
        'id_user',
        'id_cawangan',
        'id_ketua_bahagian',
        'amount',
        'status',
        'status_approval',
        'resit',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function cawangan()
    {
        return $this->belongsTo(User::class, 'id_cawangan');
    }
    public function ketuaBahagian()
    {
        return $this->belongsTo(User::class, 'id_ketua_bahagian');
    }
    public function payment()
    {
        return $this->belongsTo(LogPaymentManpower::class, 'id_payment');
    }
}
