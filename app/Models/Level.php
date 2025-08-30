<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $primaryKey = 'id_level'; 
    
    protected $table = "tb_level";

    protected $fillable = [
        'level',
        'description',
        'is_active'
    ];
    
}
