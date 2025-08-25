<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SummaryQualification extends Model
{
    protected $primaryKey = 'id_summary_qualification'; 
    
    protected $table = "tb_summary_qualification";
    
    public function deleteData($id)
    {
        return static::find($id)->delete();
    }
    
    public function user(){
        return $this->belongsTo('App\Models\User','id_user','id');
    }
    
    public function school(){
        return $this->belongsTo('App\Models\School','id_school','id_school');
    }
    
    public function qualification(){
        return $this->belongsTo('App\Models\Qualification','id_qualification','id_qualification');
    }
    
    public function study(){
        return $this->belongsTo('App\Models\Study','id_study','id_study');
    }
    
}
