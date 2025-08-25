<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Direktori extends Model
{
    protected $table = 'tb_direktori';

    protected $fillable = [
        'slug','name','jawatan','email','cawangan', 'no_phone'
    ];
}
