<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyType extends Model
{
    protected $primaryKey = 'id_company_type'; 
    
    protected $table = "tb_company_type";
    
}
