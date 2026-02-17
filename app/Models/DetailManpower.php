<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailManpower extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_detail_manpower'; 
    
    protected $table = "tb_detail_manpower";

    static $stepRegistration = 6;

    protected $fillable = [
        'id_user',
        'ic_number',
        'id_agama',
        'gender',
        'id_city',
        'id_state',
        'id_country',
        'id_parliament',
        'postcode',
        'id_nation',
        'native_status',
        'marital_status',
        'id_dun',
        'id_pegawai_daerah',
        'name_of_business',
        'business_address',
        'business_email',
        'business_phone',
        'business_activity',
        'sub_business_activity',
        'id_village_guests',
        'business_type',
        'business_income_daily',
        'business_income_weekly',
        'business_income_monthly',
        'business_income',
        'step_registration',
        'is_subscribe',
        'subscribe_status',
        'number_certificate',
        'valid_time_certificate',
        'certificate_expired_date',
        'key_reference',
        'id_cawangan',
        'approve_at_cawangan',
        'approve_at_ketua_bahagian',
        'approve_at_admin_pusat',
        'nama_pencadang',
        'nama_peyokong',
        'status_approval_cawangan',
        'status_approval_ketua_bahagian',
        'status_approval_admin_pusat',
        'reason_cawangan',
        'reason_ketua_bahagian',
        'reason_admin_pusat',
        'is_foreign',
        'id_approve_by_ketua_bahagian',
        'id_approve_by_admin_pusat',
        'rejection_reason_cawangan',
        'rejection_reason_ketua_bahagian',
        'rejection_reason_admin_pusat',
        'is_mualaf',
        'tarikh_pengislaman',
        'payment_kad_digital'
    ];
    
    // protected $dates = ['birth_date'];
    
    public function user(){
        return $this->belongsTo('App\Models\User','id_user','id');
    }
    
    public function country(){
        return $this->belongsTo('App\Models\Country','id_country','id_country');
    }
    
    public function state(){
        return $this->belongsTo('App\Models\State','id_state','id_state');
    }
    
    public function city(){
        return $this->belongsTo('App\Models\City','id_city','id_city');
    }

    public function parliament(){
        return $this->belongsTo('App\Models\Parliament', 'id_parliament');
    }

    public function dun(){
        return $this->belongsTo('App\Models\Dun', 'id_dun');
    }
    
    public function work(){
        return $this->belongsTo('App\Models\WorkType','id_work_type','id_work_type');
    }
    
    public function nation(){
        return $this->belongsTo('App\Models\Nation','id_nation','id_nation');
    }
    
    public function religion(){
        return $this->belongsTo('App\Models\Religion','id_agama','id_religion');
    }

    public function gender_relation(){
        return $this->belongsTo('App\Models\Gender','gender','id_gender');
    }

    public function company(){
        return $this->belongsTo('App\Models\DetailCompany','id_detail_company','id_detail_company');
    }
    
    public function status_education(){
        return $this->belongsTo('App\Models\StatusEducation','id_status_education','id_status_education');
    }

    public function study(){
        return $this->belongsTo('App\Models\Study','education_field','id_study');
    }
    
    public function business_activity_text(){
        return $this->belongsTo('App\Models\BusinessActivity','business_activity','id_business_activity');
    }

    public function business_type_text(){
        return $this->belongsTo('App\Models\BusinessType','business_type','id_business_type');
    }

    public function business_income_text(){
        return $this->belongsTo('App\Models\BusinessIncome','business_income','id_business_income');
    }

    public function gender_text(){
        return $this->belongsTo('App\Models\Gender','gender','id_gender');
    }

    public function marital_status_text(){
        return $this->belongsTo('App\Models\MaritalStatus','marital_status','id_marital_status');
    }

    public function status_native(){
        return $this->belongsTo('App\Models\StatusNative','native_status','id_status_native');
    }

    public function pegawai_daerah_text(){
        return $this->belongsTo('App\Models\User','id_pegawai_daerah','id');
    }

    public function cawangan()
    {
        return $this->belongsTo(User::class, 'id_cawangan');
    }

    public function ketuaBahagian()
    {
        return $this->belongsTo(User::class, 'id_approve_by_ketua_bahagian');
    }
}
