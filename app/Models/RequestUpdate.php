<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestUpdate extends Model
{
    protected $primaryKey = 'id_request_update'; 
    
    protected $table = "tb_request_update";
    
    public function user(){
        return $this->belongsTo('App\Models\User','id_user','id');
    }
    
    public function detail_company(){
        return $this->belongsTo('App\Models\DetailCompany','id_user','id_user');
    }
    
}
