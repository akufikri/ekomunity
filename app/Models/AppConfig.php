<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppConfig extends Model
{
    protected $primaryKey = 'id'; 
    
    protected $table = "tb_app_config";
    
}
