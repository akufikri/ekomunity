<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessIncome extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_business_income'; 
    
    protected $table = "tb_business_income";
}
