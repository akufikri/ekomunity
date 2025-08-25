<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollaborationAgency extends Model
{
    use HasFactory;

    protected $primaryKey = 'id'; 
    
    protected $table = "tb_collaboration_agency";
    
}
