<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certifikat extends Model
{
    protected $primaryKey = 'id_settings_certificate'; 
    
    protected $table = "tb_settings_certificate";
    
    public function findData($id)
    {
        return static::find($id);
    }
    
}
