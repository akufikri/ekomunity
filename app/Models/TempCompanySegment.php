<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempCompanySegment extends Model
{
    protected $primaryKey = 'id_temp_company_segment'; 
    
    protected $table = "tb_temp_company_segment";
    
    public function user(){
        return $this->belongsTo('App\Models\User','id_user','id');
    }
    
    public function segment(){
        return $this->belongsTo('App\Models\Segment','id_segment','id_segment');
    }
    
}
