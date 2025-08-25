<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyShareHolders extends Model
{
    protected $primaryKey = 'id_company_shareholders'; 
    
    protected $table = "tb_company_shareholders";
    
    public function user(){
        return $this->belongsTo('App\Models\User','id_user','id');
    }
    
    public function position_jabatan(){
        return $this->belongsTo('App\Models\PositionJabatan','id_position','id_position_jabatan');
    }

    public function status_native(){
        return $this->belongsTo('App\Models\StatusNative','id_status','id_status_native');
    }
    
}
