@extends('home')
@section('title-dashboard', 'Admin')
@section('title','Home')

@section('breadcrumb')

<!--<li class="breadcrumb-item active"></li>-->

@endsection

@section('content')

<style>
    .title {
        font-size: 1.25rem; 
        font-weight: bold;
    }
    .select2-container--default .select2-selection--single {
    border: 1px solid #ced4da;
    height: calc(2.875rem + 2px) !important;
    padding: 1.2rem 1rem 2.5rem 1rem;
    font-size: 1.25rem;
    line-height: 1.5;
    border-radius: .3rem;
    }
    .form-control-lg2 {
    border: 1px solid #ced4da;
    height: calc(2.875rem + 2px) !important;
    padding: 1.2rem 1rem 2.5rem 1rem;
    font-size: 1.25rem;
    line-height: 1.5;
    border-radius: .3rem;
    }
    .form-control-lg{
        height: calc(2.875rem + 2px);
        padding: 2rem 1.2rem;
        font-size: 1.25rem;
        line-height: 1.5;
        border-radius: .3rem;
    }
    .form-control-lgku{
        height: calc(2.875rem + 2px);
        padding: 2rem 1.2rem;
        font-size: 1.25rem;
        line-height: 1.5;
        border-radius: .3rem;
    }
    .filldata {
    font-weight: normal !important;
    }
    #label_form {
        padding-bottom: 8px; font-size: 15px;
    }
    .label_form_judul {
        font-size: 13px !important;
        margin-bottom: 0px;
    }
    .my-button {
        font-size: 15px;
    }
    .my-header {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 0px;
    }
    .my-table {
        font-size: 14px;
        margin-bottom: 0px;
    }
    
    input[type="text"]
    {
        font-size:14px;
    }
    
    input[type="number"]
    {
        font-size:14px;
    }
</style>

@php

    $data_temp_detail_company = \App\Models\TempDetailCompany::where('id_user', $data->id_user)
    ->where('id_request_update', $data->id_request_update)->orderBy('id_temp_detail_company','desc')->first();
    
    $data_temp_shareholders = \App\Models\TempCompanyShareHolders::where('id_user', $data->id_user)
    ->where('id_request_update', $data->id_request_update)->get();
    
    $data_temp_segment = \App\Models\TempCompanySegment::where('id_user', $data->id_user)
    ->where('id_request_update', $data->id_request_update)->get();
    
    $data_temp_swec_code = \App\Models\TempCompanySwecCode::where('id_user', $data->id_user)
    ->where('id_request_update', $data->id_request_update)->get();
    
    $data_temp_project_key_client = \App\Models\TempCompanyProject::where('id_user', $data->id_user)
    ->where('id_request_update', $data->id_request_update)
    ->where('id_source','1')->get();
    
    $data_temp_project_outsource = \App\Models\TempCompanyProject::where('id_user', $data->id_user)
    ->where('id_request_update', $data->id_request_update)
    ->where('id_source','2')->get();
    
    $data_temp_workers = \App\Models\TempCompanyWorkers::where('id_user', $data->id_user)
    ->where('id_request_update', $data->id_request_update)->get();
    
@endphp

@if($data_temp_detail_company)
<!--START COMPANY DETAIL-->
<div class="row">
    <div class="col-12">
        
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Company Detail</h3>
            </div>
            @csrf
            
    		@if ($message = Session::get('success'))
                <div class="alert alert-success">
                        {{ $message }}
                        <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                </div>
            @endif
            @if ($message = Session::get('success_approve'))
                <div class="alert alert-success">
                        {{ $message }}
                        <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                </div>
            @endif
            @if ($message = Session::get('success_reject'))
                <div class="alert alert-danger">
                    <p>
                        {{ $message }}
                        <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                    </p>
                </div>
            @endif
            <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul" for="">Company Name</label><br>
                                    <label class="filldata" id="label_form" for="">{{isset($company->company->full_company_name)?$company->company->full_company_name:"Data has not been filled"}}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Company Type</label><br>
                                    <label class="filldata" for="" id="label_form">{{isset($company->company_type)?$company->company_type:"Data has not been filled"}}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Old Company Registration Number</label><br>
                                    <label class="filldata" for="" id="label_form">{{isset($company->company->company_registration_old_number)?$company->company->company_registration_old_number:"Data has not been filled"}}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">New Company Registration Number</label><br>
                                    <label class="filldata" for="" id="label_form">{{isset($company->company->company_registration_new_number)?$company->company->company_registration_new_number:"Data has not been filled"}}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Phone Office</label><br>
                                    <label class="filldata" for="" id="label_form">{{isset($company->company->phone_office)?$company->company->phone_office:"Data has not been filled"}}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Fax Number</label><br>
                                    <label class="filldata" for="" id="label_form">{{isset($company->company->fax_number)?$company->company->fax_number:"Data has not been filled"}}</label>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Postcode</label><br>
                                    <label class="filldata" for="" id="label_form">{{isset($company->company->postcode)?$company->company->postcode:"Data has not been filled"}}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Country</label><br>
                                    <label class="filldata" for="" id="label_form">{{isset($company->company->country->country_name)?$company->company->country->country_name:"Data has not been filled"}}</label>
                                </div>
                            </div>
                            <div class="vl"></div>
                            <div class="row">
                                
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">State</label><br>
                                    <label class="filldata" for="" id="label_form">{{isset($company->company->state->state)?$company->company->state->state:"Data has not been filled"}}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">City</label><br>
                                    <label class="filldata" for="" id="label_form">{{isset($company->company->city->city)?$company->company->city->city:"Data has not been filled"}}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Email</label><br>
                                    <label class="filldata" for="" id="label_form">{{$company->email}}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Website</label><br>
                                    <label class="filldata" for="" id="label_form">{{isset($company->company->company_website)?$company->company->company_website:"Data has not been filled"}}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Address</label><br>
                                    <label class="filldata" for="" id="label_form">{{isset($company->company->address)?$company->company->address:"Data has not been filled"}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12"><hr></div>
                        <div class="col-lg-12">
                        <h3 class="text-primary my-header">Attachment</h3><br>
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="filldata text-muted font-italic" style="margin-bottom: 0px;" for="">Company Logo</label><br>
                                <label class="filldata" for="" id="label_form">{{ $company->company->logo_picture }}</label>
                                <sup class="primary"><a href="../CompanyLogo/{{ $company->company->logo_picture }}" target="_blank"><i class="fas fa-download"></i></a></sup>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="filldata text-muted font-italic" style="margin-bottom: 0px;" for="">Organization Chart</label><br>
                                <label class="filldata" for="" id="label_form">{{ $company->company->company_organization_chart }}</label>
                                <sup class="primary"><a href="../OrganizationChart/{{ $company->company->company_organization_chart }}" target="_blank"><i class="fas fa-download"></i></a></sup>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="filldata text-muted font-italic" style="margin-bottom: 0px;" for="">Suruhanjaya Syarikat Malaysia (SSM) certificate</label><br>
                                <label class="filldata" for="" id="label_form">{{ $company->company->company_ssm_certificate }}</label>
                                <sup class="primary"><a href="../CompanySsmCertificate/{{ $company->company->company_ssm_certificate }}" target="_blank"><i class="fas fa-download"></i></a></sup>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="filldata text-muted font-italic" style="margin-bottom: 0px;" for="">Suruhanjaya Syarikat Malaysia (SSM) Section 14</label><br>
                                <label class="filldata" for="" id="label_form">{{ $company->company->company_ssm_section_14 }}</label>
                                <sup class="primary"><a href="../CompanySsmSection14/{{ $company->company->company_ssm_section_14 }}" target="_blank"><i class="fas fa-download"></i></a></sup>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="filldata text-muted font-italic" style="margin-bottom: 0px;" for="">Choose your Suruhanjaya Syarikat Malaysia (SSM) Section 17</label><br>
                                <label class="filldata" for="" id="label_form">{{ $company->company->company_ssm_section_17 }}</label>
                                <sup class="primary"><a href="../CompanySsmSection17/{{ $company->company->company_ssm_section_17 }}" target="_blank"><i class="fas fa-download"></i></a></sup>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="filldata text-muted font-italic" style="margin-bottom: 0px;" for="">Choose your Trading License</label><br>
                                <label class="filldata" for="" id="label_form">{{ $company->company->company_ssm_trading_license }}</label>
                                <sup class="primary"><a href="../CompanySsmTradingLicense/{{ $company->company->company_ssm_trading_license }}" target="_blank"><i class="fas fa-download"></i></a></sup>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="filldata text-muted font-italic" style="margin-bottom: 0px;" for="">Choose your Suruhanjaya Syarikat Malaysia (SSM) Company Information</label><br>
                                <label class="filldata" for="" id="label_form">{{ $company->company->company_ssm_company_information }}</label>
                                <sup class="primary"><a href="../CompanySsmCompanyInformation/{{ $company->company->company_ssm_company_information }}" target="_blank"><i class="fas fa-download"></i></a></sup>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
<!--END COMPANY DETAIL-->

<!--START TEMP COMPANY DETAIL-->
<div class="row">
    <div class="col-12">
        
        <div class="card">
            <div class="card-header">
                <h3 class="card-title ">List of Update Data (Company Detail)</h3>
            </div>
            @csrf
            
    		@if ($message = Session::get('success'))
                <div class="alert alert-success">
                        {{ $message }}
                        <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                </div>
            @endif
            @if ($message = Session::get('success_approve'))
                <div class="alert alert-success">
                        {{ $message }}
                        <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                </div>
            @endif
            @if ($message = Session::get('success_reject'))
                <div class="alert alert-danger">
                        {{ $message }}
                        <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                </div>
            @endif
            <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul" for="">Company Name</label><br>
                                    <label class="filldata" id="label_form" for="">{{isset($temp_company->temp_company->full_company_name)?$temp_company->temp_company->full_company_name:"Data has not been filled"}}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Company Type</label><br>
                                    <label class="filldata" for="" id="label_form">{{isset($temp_company->company_type)?$temp_company->company_type:"Data has not been filled"}}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Old Company Registration Number</label><br>
                                    <label class="filldata" for="" id="label_form">{{isset($temp_company->temp_company->company_registration_old_number)?$temp_company->temp_company->company_registration_old_number:"Data has not been filled"}}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">New Company Registration Number</label><br>
                                    <label class="filldata" for="" id="label_form">{{isset($temp_company->temp_company->company_registration_new_number)?$temp_company->temp_company->company_registration_new_number:"Data has not been filled"}}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Phone Office</label><br>
                                    <label class="filldata" for="" id="label_form">{{isset($temp_company->temp_company->phone_office)?$temp_company->temp_company->phone_office:"Data has not been filled"}}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Fax Number</label><br>
                                    <label class="filldata" for="" id="label_form">{{isset($temp_company->temp_company->fax_number)?$temp_company->temp_company->fax_number:"Data has not been filled"}}</label>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Postcode</label><br>
                                    <label class="filldata" for="" id="label_form">{{isset($temp_company->temp_company->postcode)?$temp_company->temp_company->postcode:"Data has not been filled"}}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Country</label><br>
                                    <label class="filldata" for="" id="label_form">{{isset($temp_company->country)?$temp_company->country:"Data has not been filled"}}</label>
                                </div>
                            </div>
                            <div class="vl"></div>
                            <div class="row">
                                
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">State</label><br>
                                    <label class="filldata" for="" id="label_form">{{isset($temp_company->state)?$temp_company->state:"Data has not been filled"}}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">City</label><br>
                                    <label class="filldata" for="" id="label_form">{{isset($temp_company->city)?$temp_company->city:"Data has not been filled"}}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Email</label><br>
                                    <label class="filldata" for="" id="label_form">{{$temp_company->email}}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Website</label><br>
                                    <label class="filldata" for="" id="label_form">{{isset($temp_company->temp_company->company_website)?$temp_company->temp_company->company_website:"Data has not been filled"}}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Address</label><br>
                                    <label class="filldata" for="" id="label_form">{{isset($temp_company->temp_company->address)?$temp_company->temp_company->address:"Data has not been filled"}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12"><hr></div>
                        <div class="col-lg-12">
                        <h3 class="text-primary my-header">Attachment</h3><br>
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="filldata text-muted font-italic" style="margin-bottom: 0px;" for="">Company Logo</label><br>
                                <label class="filldata" for="" id="label_form">{{ $temp_company->logo_picture }}</label>
                                <sup class="primary"><a href="../CompanyLogo/{{ $temp_company->logo_picture }}" target="_blank"><i class="fas fa-download"></i></a></sup>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="filldata text-muted font-italic" style="margin-bottom: 0px;" for="">Organization Chart</label><br>
                                <label class="filldata" for="" id="label_form">{{ $temp_company->company_organization_chart }}</label>
                                <sup class="primary"><a href="../OrganizationChart/{{ $temp_company->company_organization_chart }}" target="_blank"><i class="fas fa-download"></i></a></sup>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="filldata text-muted font-italic" style="margin-bottom: 0px;" for="">Suruhanjaya Syarikat Malaysia (SSM) certificate</label><br>
                                <label class="filldata" for="" id="label_form">{{ $temp_company->company_ssm_certificate }}</label>
                                <sup class="primary"><a href="../CompanySsmCertificate/{{ $temp_company->company_ssm_certificate }}" target="_blank"><i class="fas fa-download"></i></a></sup>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="filldata text-muted font-italic" style="margin-bottom: 0px;" for="">Suruhanjaya Syarikat Malaysia (SSM) Section 14</label><br>
                                <label class="filldata" for="" id="label_form">{{ $temp_company->company_ssm_section_14 }}</label>
                                <sup class="primary"><a href="../CompanySsmSection14/{{ $temp_company->company_ssm_section_14 }}" target="_blank"><i class="fas fa-download"></i></a></sup>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="filldata text-muted font-italic" style="margin-bottom: 0px;" for="">Choose your Suruhanjaya Syarikat Malaysia (SSM) Section 17</label><br>
                                <label class="filldata" for="" id="label_form">{{ $temp_company->company_ssm_section_17 }}</label>
                                <sup class="primary"><a href="../CompanySsmSection17/{{ $temp_company->company_ssm_section_17 }}" target="_blank"><i class="fas fa-download"></i></a></sup>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="filldata text-muted font-italic" style="margin-bottom: 0px;" for="">Choose your Trading License</label><br>
                                <label class="filldata" for="" id="label_form">{{ $temp_company->company_ssm_trading_license }}</label>
                                <sup class="primary"><a href="../CompanySsmTradingLicense/{{ $temp_company->company_ssm_trading_license }}" target="_blank"><i class="fas fa-download"></i></a></sup>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="filldata text-muted font-italic" style="margin-bottom: 0px;" for="">Choose your Suruhanjaya Syarikat Malaysia (SSM) Company Information</label><br>
                                <label class="filldata" for="" id="label_form">{{ $temp_company->company_ssm_company_information }}</label>
                                <sup class="primary"><a href="../CompanySsmCompanyInformation/{{ $temp_company->company_ssm_company_information }}" target="_blank"><i class="fas fa-download"></i></a></sup>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
<!--END TEMP COMPANY DETAIL-->
@endif

@if(!$data_temp_shareholders->isEmpty())
<!--START SHAREHOLDERS-->
<div class="row">
    <div class="col-12">
        <div class="card card-primary card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title">List of Shareholders</h3>

            </div>
            <div class="card-body my-table">
                <div class="row">
                    <div class="container mt-2">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>
                                    {{ $message }}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                                </p>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm nowrap" id="datatable-crud-shareholders">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Name of Individual/Company </th>
                                        <th>Individual's IC/ Passport / Company ROC Number </th>
                                        <th>Total Share</th>
                                        <th>Percentage (%)</th>
                                        <th>Individual's position / Director's Status</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END SHAREHOLDERS-->

<!--START TEMP SHAREHOLDERS-->
<div class="row" id="view">
    <div class="col-12">
        <div class="card card-primary card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title text-danger">List of Update Data (Shareholders)</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="container mt-2 my-table">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                    {{ $message }}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                            </div><br>
                        @endif
                        @if ($message = Session::get('failed'))
                            <div class="alert alert-danger">
                                    {{ $message }}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                            </div><br>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm nowrap" id="datatable-crud-shareholders-temp">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Name of Individual/Company </th>
                                        <th>Individual's IC/ Passport / Company ROC Number </th>
                                        <th>Total Shares</th>
                                        <th>Percentage (%)</th>
                                        <th>Director's / Shareholder's Status</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END TEMP SHAREHOLDERS-->
<hr><br>
@endif

@if(!$data_temp_segment->isEmpty())
<!--START SEGMENT-->
<div class="row">
    <div class="col-12">
        <div class="card card-primary card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title">Field of Business</h3>
              
            </div>
            <div class="card-body my-table">
                <div class="row">
                    <div class="container mt-2 ">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>
                                    {{ $message }}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                                </p>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm nowrap" id="datatable-crud-segment">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Field of Business</th>
                                        <th>Other</th>
                                        <th>Created Date</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END SEGMENT-->

<!--START TEMP SEGMENT-->
<div class="row" id="view">
    <div class="col-12">
        <div class="card card-primary card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title text-danger">List of Update Data (Field of Business)</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="container mt-2 my-table">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                    {{ $message }}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm nowrap" id="datatable-crud-segment-temp">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Field of Business</th>
                                        <th>Other</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END TEMP SEGMENT-->
<hr><br>
@endif

@if(!$data_temp_workers->isEmpty())
<!--START LIST OF WORKERS-->
<div class="row">
    <div class="col-12">
        <div class="card card-primary card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title">List of Workers</h3>
            </div>
            <div class="card-body my-table">
                <div class="row">
                    <div class="container mt-2">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                    {{ $message }}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm nowrap" id="datatable-crud-workers">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Name</th>
                                        <th>IC/Passport</th>
                                        <th>Nationality</th>
                                        <th>Position</th>
                                        <th>Bumiputera Status</th>
                                        <th>Field of Work</th> <!--Field of Work adalah Segment-->
                                        <th>Others</th>
                                        <th>Certificate</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END LIST OF WORKERS-->

<!--START TEMP LIST OF WORKERS-->
<div class="row">
    <div class="col-12">
        <div class="card card-primary card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title text-danger">List of Update Data (List of Workers)</h3>
            </div>
            <div class="card-body my-table">
                <div class="row">
                    <div class="container mt-2">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                    {{ $message }}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm nowrap" id="datatable-crud-workers-temp">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Name</th>
                                        <th>IC/Passport</th>
                                        <th>Nationality</th>
                                        <th>Position</th>
                                        <th>Bumiputera Status</th>
                                        <th>Field of Work</th> <!--Field of Work adalah Segment-->
                                        <th>Others</th>
                                        <th>Certificate</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END TEMP LIST OF WORKERS-->
<hr><br>
@endif

@if(!$data_temp_project_key_client->isEmpty())
<!--START KEY CLIENT PROJECT-->
<div class="row">
    <div class="col-12">
        <div class="card card-primary card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title">Key Client & Project</h3>
    
            </div>
            <div class="card-body my-table">
                <div class="row">
                    <div class="container mt-2">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>
                                    {{ $message }}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                                </p>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm nowrap" id="datatable-crud-key-client-project">
                                <thead>
                                    <tr>
                                
                                        <th width="5%">No</th>
                                          <th>Country</th>
                                          <th>Field of Business</th>
                                          <th>Client</th>
                                          <th>Project Name</th>
                                          <th>Start Date</th>
                                          <th>Completion Date</th>
                                          <th>Project Value</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END KEY CLIENT PROJECT-->

<!--START TEMP KEY CLIENT PROJECT-->
<div class="row">
    <div class="col-12">
        <div class="card card-primary card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title text-danger">List of Update Data (Key Client & Project)</h3>
    
            </div>
            <div class="card-body my-table">
                <div class="row">
                    <div class="container mt-2">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                    {{ $message }}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm nowrap" id="datatable-crud-key-client-project-temp">
                                <thead>
                                    <tr>
                                
                                        <th width="5%">No</th>
                                          <th>Country</th>
                                          <th>Field of Business</th>
                                          <th>Client</th>
                                          <th>Project Name</th>
                                          <th>Start Date</th>
                                          <th>Completion Date</th>
                                          <th>Project Value</th>
                                          <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END KEY CLIENT PROJECT-->
<hr><br>
@endif

@if(!$data_temp_project_outsource->isEmpty())
<!--START OUTSOURCE PROJECT-->
<div class="row">
    <div class="col-12">
        <div class="card card-primary card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title">List of Out Source Project</h3>
            </div>
            <div class="card-body my-table">
                <div class="row">
                    <div class="container mt-2">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>
                                    {{ $message }}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                                </p>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm nowrap" id="datatable-crud-outsource-project">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Country</th>
                                        <th>Client</th>
                                        <th>Field of Business</th>
                                        <th>Project Name</th>
                                        <th>Start Date</th>
                                        <th>Completion Date</th>
                                        <th>Project Value (nominal RM)</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END OUTSOURCE PROJECT-->

<!--START TEMP OUTSOURCE PROJECT-->
<div class="row">
    <div class="col-12">
        <div class="card card-primary card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title text-danger">List of Update Data (List of Out Source Project)</h3>
            </div>
            <div class="card-body my-table">
                <div class="row">
                    <div class="container mt-2">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>
                                    {{ $message }}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                                </p>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm nowrap" id="datatable-crud-outsource-project-temp">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Country</th>
                                        <th>Client</th>
                                        <th>Field of Business</th>
                                        <th>Project Name</th>
                                        <th>Start Date</th>
                                        <th>Completion Date</th>
                                        <th>Project Value (nominal RM)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END TEMP OUTSOURCE PROJECT-->
<hr><br>
@endif

@if(!$data_temp_swec_code->isEmpty())
<!--START SWEC CODE-->
<div class="row">
    <div class="col-12">
        <div class="card card-primary card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title">List of SWEC Code</h3>
            </div>
            <div class="card-body my-table">
                <div class="row">
                    <div class="container mt-2">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>
                                    {{ $message }}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                                </p>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm nowrap" id="datatable-crud-swec-code">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Service</th>
                                        <th>Code </th>
                                        <th>Created Date</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END SWEC CODE-->

<!--START TEMP SWEC CODE-->
<div class="row" id="view">
    <div class="col-12">
        <div class="card card-primary card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title text-danger">List of Update Data (SWEC Code)</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="container mt-2 my-table">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                    {{ $message }}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm nowrap" id="datatable-crud-swec-code-temp">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Service</th>
                                        <th>Code </th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END TEMP SWEC CODE-->
@endif

<!--BUTTON APPROVE & REJECT-->
<div class="card" @if($data->status_approval =='WAITING') show @else hidden @endif>
    <div class="card-header">
        <div class="card-tools">
            <a href="#" data-toggle="modal" data-target="#addApprove" class="btn btn-sm btn-success pull-right">
                <i class="fa fa-check nav-icon"></i>
                &nbsp; Approve
            </a>
            <a href="#" data-toggle="modal" data-target="#addReject"  class="btn btn-sm btn-danger pull-right">
                <i class="fa fa-times nav-icon"></i>
                &nbsp; Reject
            </a>
        </div>
    </div>
</div>
<!--END BUTTON APPROVE AND REJECT-->

<!--ADD NEW APPROVE-->
        <div class="modal fade" id="addApprove" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-------->
                   <!--approveRequestUpdateCompany/21/65-->
                    <form action="/approveRequestUpdateCompany/{{$data->id_user}}/{{$data->id_request_update}}" method="POST" class="form-add-data" enctype="multipart/form-data">
                          @csrf
                          <input type="hidden" name="id_user_company" id="id_user_company" value="{{ $data->id_user_company }}">
                          <div class="form-group">
                            <label for="exampleFormControlTextarea1">Note</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" name="note" rows="3"></textarea>
                          </div>
                        <!--------->
                    </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <input type="submit" value="Yes" class="btn btn-success">
                    </div>
                    </div>
                </form>
            </div>
        </div>
        </div>
        </div>
<!--ADD NEW APPROVE-->

<!--ADD NEW Reject-->
        <div class="modal fade" id="addReject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Are you sure to Reject?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-------->
                   
                    <form action="{{URL::to('/rejectCertificate')}}" method="POST" class="form-add-data" enctype="multipart/form-data">
                          @csrf
                          <input type="hidden" name="id_user_company" id="id_user_company" value="{{ $data->id_user_company }}">
                          <div class="form-group">
                            <label for="exampleFormControlTextarea1">Note</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" name="note" rows="3"></textarea>
                          </div>
                        <!--------->
                    </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <input type="submit" value="Yes" class="btn btn-danger">
                    </div>
                    </div>
                </form>
            </div>
        </div>
        </div>
        </div>
<!--ADD NEW Reject-->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script src="//code.jquery.com/jquery-2.0.0.js"></script>
<script src="/js/jquery.validate.min.js"></script>
<script type="text/javascript">

$(document).ready( function () {
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    loadDataEquity()
    loadDataShareholders()
    loadDataShareholdersTemp()
    loadDataSegment()
    loadDataSegmentTemp()
    loadDataKeyClientProject()
    loadDataKeyClientProjectTemp()
    loadDataOutSource()
    loadDataOutSourceTemp()
    loadDataSwecCode()
    loadDataSwecCodeTemp()
    loadDataWorkers()
    loadDataWorkersTemp()
});


    function loadDataEquity(){
    $('#datatable-crud-equity').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        scrollX: true,
        ajax: {
                url: "{{ route('company.viewCompanyEquityBreakdown') }}",
                type: 'GET'
            },
        columns: [
            { data: 'DT_RowIndex' },
            { data: 'status' },
            { data: 'total' },
            { data: 'percentage' },
            { data: 'create_date' },
        ],

        order: [[0, 'asc']]
    });
    
    }
    
    function loadDataShareholders(){
    $('#datatable-crud-shareholders').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        scrollX: true,
        ajax: {
                url: "/companyListofShareholdersAdmin/{{ $data->id_user}}",
                type: 'GET'
            },
        columns: [
            
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'name', name: 'name' },
            { data: 'number_id', name: 'number_id' },
            { data: 'total', name: 'total' },
            { data: 'percentage'},
            { data: 'position_user', name: 'position' },
            { data: 'status', name: 'status_native' },
            { data: 'create_date', name: 'create_date' },
        ],
        order: [[0, 'asc']]
    });
    
    }
    
    function loadDataShareholdersTemp(){
    $('#datatable-crud-shareholders-temp').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        scrollX: true,
        ajax: {
                url: "/companyListofShareholdersTempAdmin/{{$data->id_user}}/{{$data->id_request_update}}#view",
                type: 'GET'
            },
        columns: [
            
            { data: 'DT_RowIndex' },
            { data: 'name' },
            { data: 'number_id' },
            { data: 'total' },
            { data: 'percentage'},
            { data: 'position_user' },
            { data: 'status' },
            { data: 'create_date' },
            { data: 'action' },
        ],
        order: [[0, 'asc']]
    });
    
    }
    
    function loadDataSegment(){
    $('#datatable-crud-segment').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        scrollX: true,
        ajax: {
                url: "/companySegmentAdmin/{{ $data->id_user }}",
                type: 'GET'
            },
        columns: [
            { data: 'DT_RowIndex' },
            { data: 'segment_name' },
            { data: 'others_segment' },
            { data: 'create_date' },
        ],
        order: [[0, 'asc']]
    });
    
    }
    
    function loadDataSegmentTemp(){
    $('#datatable-crud-segment-temp').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        scrollX: true,
        ajax: {
                url: "/companySegmentTempAdmin/{{$data->id_user}}/{{$data->id_request_update}}#view",
                type: 'GET'
            },
        columns: [
            { data: 'DT_RowIndex' },
            { data: 'segment_name' },
            { data: 'others_segment' },
            { data: 'create_date' },
            { data: 'action' },
        ],
        order: [[0, 'asc']]
    });
    
    }

    function loadDataKeyClientProject(){
    $('#datatable-crud-key-client-project').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        scrollX: true,
        ajax: {
                url: "/companyKeyClientProjectAdmin/{{ $data->id_user }}",
                type: 'GET'
            },
        columns: [
            // ==
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'country_name_rafi', name: 'country_name' },
            { data: 'segment_name_rafi', name: 'segment' },
            { data: 'client', name: 'client' },
            { data: 'project_name', name: 'project_name' },
            { data: 'start_date', name: 'start_date' },
            { data: 'completion_date', name: 'completion_date' },
            { data: 'project_value', name: 'project_value' },
        ],
        order: [[0, 'asc']]
    });
    
    }
    
    function loadDataKeyClientProjectTemp(){
    $('#datatable-crud-key-client-project-temp').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        scrollX: true,
        ajax: {
                url: "/companyKeyClientProjectTempAdmin/{{ $data->id_user }}/{{$data->id_request_update}}#view",
                type: 'GET'
            },
        columns: [
            // ==
            { data: 'DT_RowIndex' },
            { data: 'country_name_rafi' },
            { data: 'segment_name_rafi' },
            { data: 'client' },
            { data: 'project_name' },
            { data: 'start_date' },
            { data: 'completion_date' },
            { data: 'project_value' },
            { data: 'action' }
        ],
        order: [[0, 'asc']]
    });
    
    }

    function loadDataOutSource(){
    $('#datatable-crud-outsource-project').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        scrollX: true,
        ajax: {
                url: "/companyOutSourceProjectAdmin/{{ $data->id_user }}",
                type: 'GET'
            },
        columns: [
            { data: 'DT_RowIndex' },
            { data: 'country_name' },
            { data: 'client' },
            { data: 'segment_name' },
            { data: 'project_name' },
            { data: 'start_date' },
            { data: 'completion_date' },
            { data: 'project_value' },
        ],
        order: [[0, 'asc']]
    });
    
    }
    
    function loadDataOutSourceTemp(){
    $('#datatable-crud-outsource-project-temp').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        scrollX: true,
        ajax: {
                url: "/companyOutSourceProjectTempAdmin/{{ $data->id_user }}/{{$data->id_request_update}}#view",
                type: 'GET'
            },
        columns: [
            { data: 'DT_RowIndex' },
            { data: 'country_name' },
            { data: 'client' },
            { data: 'segment_name' },
            { data: 'project_name' },
            { data: 'start_date' },
            { data: 'completion_date' },
            { data: 'project_value' },
            { data: 'action' },
        ],
        order: [[0, 'asc']]
    });
    
    }

    function loadDataSwecCode(){
    $('#datatable-crud-swec-code').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        scrollX: true,
        ajax: {
                url: "/companySwecCodeAdmin/{{ $data->id_user }}",
                type: 'GET'
            },
        columns: [
            
            { data: 'DT_RowIndex' },
            { data: 'service' },
            { data: 'code' },
            { data: 'create_date' },
        ],
        order: [[0, 'asc']]
    });
    
    }
    
    function loadDataSwecCodeTemp(){
    $('#datatable-crud-swec-code-temp').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        scrollX: true,
        ajax: {
                url: "/companySwecCodeTempAdmin/{{$data->id_user}}/{{$data->id_request_update}}",
                type: 'GET'
            },
        columns: [
            
            { data: 'DT_RowIndex' },
            { data: 'service' },
            { data: 'code' },
            { data: 'create_date' },
            { data: 'action' },
        ],
        order: [[0, 'asc']]
    });
    
    }

    function loadDataWorkers(){
    $('#datatable-crud-workers').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        scrollX: true,
        ajax: { 
                url: "/companyWorkersAdmin/{{ $data->id_user }}",
                type: 'GET'
            },
        columns: [
            { data: 'DT_RowIndex' },
            { data: 'name' },
            { data: 'ic_number' },
            { data: 'country_name' },
            { data: 'position_name' },
            { data: 'status_native' },
            { data: 'segment_name' },
            { data: 'others_segment' },
            { data: 'certificate', className: 'text-center' },
            { data: 'create_date' },
        ],
        columnDefs: [
                {
                    "targets" : 8 ,
                    "data": "certificate",
                    "render" : function (data, type, row) {
                          return '<a href="/CertificateOfWork/'+row.certificate+'" target="_blank" class="btn-edit-data btn btn-sm btn-primary">' +
                                    '<i class="fas fa-file-download fa-lg" width="50%"></i>' + 
                                  '</a>';
                        }
                },
            ],
        order: [[0, 'asc']]
    });
    
    }
    
    function loadDataWorkersTemp(){
    $('#datatable-crud-workers-temp').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        scrollX: true,
        ajax: { 
                url: "/companyWorkersTempAdmin/{{ $data->id_user }}/{{$data->id_request_update}}#view",
                type: 'GET'
            },
        columns: [
            { data: 'DT_RowIndex' },
            { data: 'name' },
            { data: 'ic_number' },
            { data: 'country_name' },
            { data: 'position_name' },
            { data: 'status_native' },
            { data: 'segment_name' },
            { data: 'others_segment' },
            { data: 'certificate', className: 'text-center' },
            { data: 'create_date' },
            { data: 'action' },
        ],
        columnDefs: [
                {
                    "targets" : 8 ,
                    "data": "certificate",
                    "render" : function (data, type, row) {
                          return '<a href="/CertificateOfWork/'+row.certificate+'" target="_blank" class="btn-edit-data btn btn-sm btn-primary">' +
                                    '<i class="fas fa-file-download fa-lg" width="50%"></i>' + 
                                  '</a>';
                        }
                },
            ],
        order: [[0, 'asc']]
    });
    
    }




</script>

@endsection