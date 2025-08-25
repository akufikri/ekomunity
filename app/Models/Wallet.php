<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table = 'tb_wallet';

    protected $fillable = [
        'id_user',
        'payment_name',
        'code',
        'api_key',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
