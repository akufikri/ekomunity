<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $primaryKey = 'id_term_conditions'; 
    
    protected $table = "tb_term_conditions";
    
    // public function state(){
    //     return $this->belongsTo('App\Models\State', 'id_state', 'id_state');
    // }
    
    public function level(){
        return $this->belongsTo('App\Models\Level', 'id_level', 'id_level');
    }
}
