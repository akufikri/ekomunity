<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempDetailCompany extends Model
{
    protected $primaryKey = 'id_temp_detail_company'; 
    
    protected $table = "tb_temp_detail_company";
    
    public function user(){
        return $this->belongsTo('App\Models\User','id_user','id');
    }
    
    public function country(){
        return $this->belongsTo('App\Models\Country','id_country','id_country');
    }
    public function state(){
        return $this->belongsTo('App\Models\State','id_state','id_state');
    }
    
    public function city(){
        return $this->belongsTo('App\Models\City','id_city','id_city');
    }
    
    public function company_type(){
        return $this->belongsTo('App\Models\CompanyType','id_company_type','id_company_type');
    }
    
}
