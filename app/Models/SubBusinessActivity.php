<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubBusinessActivity extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_sub_business_activity'; 
    
    protected $table = "tb_sub_business_activity";

}
