<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blogpost extends Model
{
    protected $table = 'tb_blog_post';

    protected $fillable = [
        'title','slug','image','content','tags','status','id_category'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }
}
