<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorLicenses extends Model
{
    protected $primaryKey = 'id_vendor_licenses'; 
    
    protected $table = "tb_vendor_licenses";
    
}
