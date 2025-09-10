<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = 'tb_package';

    protected $fillable = [
        'title',
        'benefit',
        'is_premium',
        'price',
        'status',
        'valid_until'
    ];

    protected $casts = [
        'benefit' => 'array', // otomatis parse JSON <-> array
        'is_premium' => 'boolean',
        'valid_until' => 'date',
    ];
}
