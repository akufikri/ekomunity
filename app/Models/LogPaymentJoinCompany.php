<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogPaymentJoinCompany extends Model
{
    protected $primaryKey = 'id'; 
    
    protected $table = "tb_log_payment_join_company";

    public function user() {
        return $this->belongsTo('\App\Models\User', 'id_user', 'id');
    }

    public function manpower(){
        return $this->belongsTo('App\Models\DetailManpower','id_detail_manpower');
    }

    public function approvalBy() {
        return $this->belongsTo('\App\Models\User', 'approval_by', 'id');
    }
    
    
}
