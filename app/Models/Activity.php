<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $table = 'tb_activities';

    protected $fillable = [
        'community_id',
        'title',
        'description',
        'date',
        'start_time',
        'end_time',
        'location',
        'address',
        'organizer',
        'type',
        'status',
        'max_attendees',
        'agenda',
    ];

    protected $casts = [
        'agenda' => 'array',
        'date' => 'date:Y-m-d',
    ];

    public function rsvps()
    {
        return $this->hasMany(Rsvp::class, 'activity_id');
    }

    public function communityUser()
    {
        return $this->belongsTo(\App\Models\User::class, 'community_id');
    }
}
