<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $primaryKey = 'id_school'; 
    
    protected $table = "tb_school";
    
    public function typeSch(){
        return $this->belongsTo('App\Models\TypeSchool','id_type_school','id_type_school');
    }
    
}
