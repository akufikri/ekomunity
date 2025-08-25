<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JoinCompany extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id'; 
    
    protected $table = "tb_request_join_company";
    
    public function manpower(){
        return $this->belongsTo('App\Models\DetailManpower','id_detail_manpower');
    }
    
    public function company(){
        return $this->belongsTo('App\Models\DetailCompany','id_detail_company');
    }

    public function payment(){
        return $this->hasOne('App\Models\LogPaymentJoinCompany', 'id_request_join_company')->latestOfMany();
    }
    
}
