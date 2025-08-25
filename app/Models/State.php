<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $primaryKey = 'id_state'; 
    
    protected $table = "tb_state";
    
    public function country(){
        return $this->belongsTo('App\Models\Country','id_country','id_country');
    }
    
}
