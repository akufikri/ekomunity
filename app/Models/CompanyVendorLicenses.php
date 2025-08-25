<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyVendorLicenses extends Model
{
    protected $primaryKey = 'id_company_vendor_licenses'; 
    
    protected $table = "tb_company_vendor_licenses";
    
    public function user(){
        return $this->belongsTo('App\Models\User','id_user','id');
    }
    
    public function company_license(){
        return $this->belongsTo('App\Models\VendorLicenses','id_vendor_licenses','id_vendor_licenses');
    }

    
}
