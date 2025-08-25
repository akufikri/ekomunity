<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubWorkCategory extends Model
{
    protected $primaryKey = 'id_swec_sub_work_category'; 
    
    protected $table = "tb_swec_sub_work_category";
    
    public function work_category(){
        return $this->belongsTo('App\Models\WorkCategory','id_swec_work_category','id_swec_work_category');
    }
    
}
