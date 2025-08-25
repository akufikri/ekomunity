<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempCompanySwecCode extends Model
{
    protected $primaryKey = 'id_temp_swec_company'; 
    
    protected $table = "tb_temp_swec_company";
    
    public function user(){
        return $this->belongsTo('App\Models\User','id_user','id');
    }
    
    public function work_category(){
        return $this->belongsTo('App\Models\WorkCategory','id_work_category','id_swec_work_category');
    }
    
    public function sub_work_category(){
        return $this->belongsTo('App\Models\SubWorkCategory','id_sub_work_category','id_swec_sub_work_category');
    }
    
    public function specific_work(){
        return $this->belongsTo('App\Models\SpecificWork','id_specific_work','id_swec_specific_work');
    }
    
    public function sub_specific_work(){
        return $this->belongsTo('App\Models\SubSpecificWork','id_sub_specific_work','id_swec_sub_specific_work');
    }
    
}
