<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GerbangPembayaran extends Model
{
    protected $table = 'tb_gerbang_pembayaran';

    protected $fillable = [
        'price_pusat',
        'price_cawangan',
        'price_ketua_bahagian'
    ];
    
}
