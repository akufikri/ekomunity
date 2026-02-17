<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use SoftDeletes;
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_level',
        'fullname',
        'email',
        'phone_number',
        'email_verified_at',
        'is_verified',
        'password',
        'registered_by',
        'status_approval',
        'no_ros',
        'kod_bahagian',
        'kod_cawangan',
        'status_ros',
        'id_city',
        'photo_profile'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'id_city', 'id_city');
    }

    public function manpower()
    {
        return $this->belongsTo('App\Models\DetailManpower', 'id', 'id_user');
    }

    public function worker()
    {
        return $this->belongsTo('App\Models\CompanyWorkers', 'id', 'id_user');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\DetailCompany', 'id', 'id_user');
    }

    public function level()
    {
        return $this->belongsTo('App\Models\Level', 'id_level', 'id_level');
    }

    public function temp_company()
    {
        return $this->belongsTo('App\Models\TempDetailCompany', 'id', 'id_user');
    }

    public function userLevel()
    {
        return $this->id_level;
    }
    public function getUserRole($route)
    {
        $role = $this->userLevel();
        return $role;
    }
    public function hasRole($roles, $route)
    {
        $this->have_role = $this->getUserRole($route);

        if (is_array($roles)) {
            foreach ($roles as $need_role) {
                if ($this->checkIfUserHasRole($need_role)) {
                    return true;
                }
            }
        } else {
            return $this->checkIfUserHasRole($roles);
        }
        return false;
    }
    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\CustomVerifyEmail);
    }
    
}
