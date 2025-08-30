<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingBranding extends Model
{
    protected $table = 'tb_setting_branding';
    
    protected $fillable = [
        'name_brand',
        'logo',
        'logo_url',
        'description',
        'brand_color',
        'cta'
    ];
}
