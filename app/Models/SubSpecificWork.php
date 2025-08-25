<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubSpecificWork extends Model
{
    protected $primaryKey = 'id_swec_sub_specific_work';
    
    protected $table = "tb_swec_sub_specific_work";
    
    public function work_category(){
        return $this->belongsTo('App\Models\WorkCategory','id_swec_work_category','id_swec_work_category');
    }
    
    public function sub_work_category(){
        return $this->belongsTo('App\Models\SubWorkCategory','id_swec_sub_work_category','id_swec_sub_work_category');
    }
    
    public function specific_work(){
        return $this->belongsTo('App\Models\SpecificWork','id_swec_specific_work','id_swec_specific_work');
    }
    
    
    
    // public function segment(){
    //     return $this->belongsTo('App\Models\Segment','id_segment','id_segment');
    // }
    
}
