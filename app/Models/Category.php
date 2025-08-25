<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'tb_categories_post';

    protected $fillable = [
        'name',
        'description'
    ];

    public function blogPost()
    {
        return $this->hasMany(Blogpost::class, 'id_category');
    }
}
