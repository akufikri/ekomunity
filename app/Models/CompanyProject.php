<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProject extends Model
{
    protected $primaryKey = 'id_company_project'; 
    
    protected $table = "tb_company_project";
    
    public function user(){
        return $this->belongsTo('App\Models\User','id_user','id');
    }
    
    public function source(){
        return $this->belongsTo('App\Models\Source','id_source','id_source');
    }
    
    public function country(){
        return $this->belongsTo('App\Models\Country','id_country', 'id_country');
    }
    public function segment(){
        return $this->belongsTo('App\Models\Segment','id_segment', 'id_segment');
    }
    
    
}
