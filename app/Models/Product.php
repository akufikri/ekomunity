<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'id'; 
    
    protected $table = "tb_product_manpower";

    function categoryProduct(){
        return $this->belongsTo('App\Models\CategoryProduct', 'id_category_product', 'id_category_product');
    }

    function manpower(){
        return $this->belongsTo('App\Models\DetailManpower', 'id_detail_manpower', 'id_detail_manpower');
    }
}
