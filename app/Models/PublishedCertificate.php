<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublishedCertificate extends Model
{
    protected $primaryKey = 'id_published_certificate'; 
    
    protected $table = "tb_published_certificate";

    protected $fillable = [
        'number_certificate',
        'id_user',
        'expire_date',
    ];
    
    public function user(){
        return $this->belongsTo('App\Models\User','id_user','id');
    }
    
}
