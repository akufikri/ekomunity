<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $primaryKey = 'id_position'; 
    
    protected $table = "tb_position";
    
}
