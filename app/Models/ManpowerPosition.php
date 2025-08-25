<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ManpowerPosition extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id_manpower_position';

    protected $table = "tb_manpower_position";

    protected $fillable = [
        'id_position','date_appointment'
    ];

    public function user() {
        return $this->belongsTo('\App\Models\User', 'id_user', 'id');
    }

    public function company() {
        return $this->belongsTo('\App\Models\User', 'id_company', 'id');
    }

    public function position() {
        return $this->belongsTo('\App\Models\Position', 'id_position', 'id_position');
    }

}
