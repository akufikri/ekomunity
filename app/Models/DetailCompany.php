<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailCompany extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id_detail_company';
    protected $table = "tb_detail_company";

    protected $fillable = [
        'id_user',
        'id_city',
        'id_state',
        'id_country',
        'id_company_type',
        'id_pegawai_daerah',
        'id_bahagian',
        'company_registration',
        'full_company_name',
        'email_company',
        'address',
        'postcode',
        'phone_office',
        'fax_number',
        'company_website',
        'logo_picture',
        'license_picture',
        'auth_paid_up_capital',
        'paid_up_capital',
        'company_organization_chart',
        'company_ssm_certificate',
        'company_ssm_section_14',
        'company_ssm_section_17',
        'company_ssm_company_information',
        'company_ssm_trading_license',
        'status_approval',
        'status_certificate_approval',
        'valid_time_certificate',
        'certificate_expired_date',
        'number_certificate',
        'certificate_file',
        'view_certificate',
        'medsos',
        'medsos_link',
        'instagram',
        'facebook',
        'tiktok',
        'youtube',
        'step_registration',
        'key_reference',
        'joining_fee',
        'secret_key',
        'signature_payment',
        'collection_id',
        'status_approval_at',
        'status_approval_by',
        'logo_1',
        'logo_2',
        'sign_picture',
        'sign_name',
        'sign_position',
        'valid_time',
        'watermark_image',
        'tnc',
        'price_subscribe',
        'year_expired_subscribe',
        'valid_subscribe',
        'tempoh_lantikan',
        'slogan',
        'mengenai',
        'banner',
        'custom_link'
    ];

    static $stepRegistration = 2;

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user', 'id');
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'id_country', 'id_country');
    }

    public function state()
    {
        return $this->belongsTo('App\Models\State', 'id_state', 'id_state');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'id_city', 'id_city');
    }

    public function company_type()
    {
        return $this->belongsTo('App\Models\CompanyType', 'id_company_type', 'id_company_type');
    }

    public function status_native()
    {
        return $this->belongsTo('App\Models\StatusNative', 'native_status', 'id_status_native');
    }
}
