<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailSetting extends Model
{
    protected $table = 'tb_email_setting';

    protected $fillable = [
        'notif_enabled',
        'notif_types',
        'sender_name',
        'sender_email',
        'admin_email',
    ];

    protected $casts = [
        'notif_enabled' => 'boolean',
        'notif_types' => 'array',
    ];
}
