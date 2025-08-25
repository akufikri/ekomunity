<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    protected $primaryKey = 'id_agency'; 
    
    protected $table = "tb_agency";
    
}
