<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogCertificate extends Model
{
    protected $primaryKey = 'id_log_certificate'; 
    
    protected $table = "tb_log_certificate";
    
    public function user(){
        return $this->belongsTo('App\Models\User','id_user','id');
    }
    
    public function level(){
        return $this->belongsTo('App\Models\Level','id_level','id_level');
    }
    
    public function detailCompany(){
        return $this->belongsTo('App\Models\DetailCompany','id_user','id_user');
    }
    
}
