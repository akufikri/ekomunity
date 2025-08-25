<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmploymentHistory extends Model
{
    protected $primaryKey = 'id_employment_history'; 
    
    protected $table = "tb_employment_history";
    
    public function findData($id)
    {
        return static::find($id);
    }
    
    public function deleteData($id)
    {
        return static::find($id)->delete();
    }

    public function position(){
        return $this->belongsTo('App\Models\Position','id_position','id_position');
    }
    
    public function segment(){
        return $this->belongsTo('App\Models\Segment','id_segment','id_segment');
    }
    
    public function user(){
        return $this->belongsTo('App\Models\User','id_user','id');
    }
    
}
