<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'tb_transaction';

    protected $fillable = [
        'order_id',
        'payment_gateway',
        'id_user',
        'name',
        'phone_number',
        'email',
        'collections',
        'amount',
        'status',
        'paid_at',
        'url'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
