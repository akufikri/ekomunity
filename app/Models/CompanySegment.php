<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySegment extends Model
{
    protected $primaryKey = 'id_company_segment'; 
    
    protected $table = "tb_company_segment";
    
    public function segment(){
        return $this->belongsTo('App\Models\Segment','id_segment','id_segment');
    }
    
}
