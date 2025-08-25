<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $primaryKey = 'id_city'; 
    
    protected $table = "tb_city";
    
    public function state(){
        return $this->belongsTo('App\Models\State', 'id_state', 'id_state');
    }
}
