<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $primaryKey = 'id';
    
    protected $table = "tb_payment";
    
    protected $hidden = [
        'callback_url', 'metadata_id', 'metadata_description', 'created_at', 'updated_at'
    ];
    
    // public function company(){
    //     return $this->belongsTo('\App\Company', 'id_company');
    // }
    // public function company_user(){
    //     return $this->belongsTo('\App\UserCompany', 'id_user');
    // }
}
