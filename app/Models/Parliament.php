<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parliament extends Model
{
    protected $primaryKey = 'id'; 
    
    protected $table = "tb_parliament";
    
    protected $fillable = ['id_state','code','parliament','description', 'is_active'];
    
}
