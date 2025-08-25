<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquityBreakdown extends Model
{
    protected $primaryKey = 'id_company_equity_breakdown'; 
    
    protected $table = "tb_company_equity_breakdown";
    
    public function user(){
        return $this->belongsTo('App\Models\User','id_user','id');
    }
    
    public function statusNative(){
        return $this->belongsTo('App\Models\StatusNative','id_status_native','id_status_native');
    }
    
}
