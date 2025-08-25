<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyWorkers extends Model
{
    protected $primaryKey = 'id_company_workers'; 
    
    protected $table = "tb_company_workers";
    
    public function user(){
        return $this->belongsTo('App\Models\User','id_user','id');
    }
    
    public function segment(){
        return $this->belongsTo('App\Models\Segment','id_segment','id_segment');
    }
    
    public function country(){
        return $this->belongsTo('App\Models\Country','id_country','id_country');
    }
    
    public function position(){
        return $this->belongsTo('App\Models\Position','id_position','id_position');
    }
    
    public function status(){
        return $this->belongsTo('App\Models\StatusNative','id_status','id_status_native');
    }
    
}
