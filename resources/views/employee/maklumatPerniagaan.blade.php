@extends('home')
@section('title-dashboard', 'Ahli')

@section('title','Maklumat Perniagaan')

@section('breadcrumb')

<li class="breadcrumb-item active">Maklumat Perniagaan</li>

@endsection

@section('content')

<style>
    .select2-container--default .select2-selection--single {
    border: 1px solid #ced4da;
    height: calc(2.875rem + 2px) !important;
    padding: .8rem .6rem 2.1rem .6rem;
    font-size: 13px;
    line-height: 1.5;
    border-radius: .3rem;
    }
    .form-control-lg2 {
    border: 1px solid #ced4da;
    height: calc(2.875rem + 2px) !important;
    padding: .8rem .6rem 2.1rem .6rem;
    font-size: 13px;
    line-height: 1.5;
    border-radius: .3rem;
    }
    .form-control-lg{
        height: calc(2.875rem + 2px);
        padding: 1rem .8rem;
        font-size: 13px;
        line-height: 1.5;
        border-radius: .3rem;
    }
    .form-control-lgku{
        height: calc(2.875rem + 2px);
        padding: 2rem 1.2rem;
        font-size: 13px;
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
</style>
<div class="row">
    <div class="col-12">
        <div class="card card-danger card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title text-danger my-header">Maklumat Perniagaan</h3>
                <div class="card-tools">
                    <a href="{{URL::to('editMaklumatPerniagaan/'.Auth::user()->id)}}" title="Edit" class="btn btn-sm btn-warning" title="Edit" >Edit</a>
                </div>
            </div>
            
            @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                            {{ $message }}
                            <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                    </div>
            @endif
            
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        
                        <div class="row">
                            @if($data->manpower->picture_of_business != null)
                            <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Logo Perniagaan</label><br>
                                <img class="mb-2 mt-2" src="/BusinessImage/{{ $data->manpower->picture_of_business }}" style="max-width:150px; max-height:100px" alt="">
                            </div>
                            @endif
                            @if($data->manpower->picture_product != null)
                            <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Gambar Produk</label><br>
                                <img class="mb-2 mt-2" src="/BusinessProductImage/{{ $data->manpower->picture_product }}" style="max-width:150px; max-height:100px" alt="">
                            </div>
                            @endif
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Pihak Berkuasa Tempatan</label><br>
                                <label class="filldata" for="" id="label_form">{{isset($data->manpower->id_pegawai_daerah)?$data->manpower->pegawai_daerah_text->fullname:"Data has not been filled"}}</label>
                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Nama Perniagaan</label><br>
                                <label class="filldata" for="" id="label_form">{{isset($data->manpower->name_of_business)?$data->manpower->name_of_business:"Data has not been filled"}}</label>
                            </div>
                            <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Jenis Pendaftaran Perniagaan</label><br>
                                <label class="filldata" for="" id="label_form">{{isset($data->manpower->business_type)?$data->manpower->business_type_text->business_type:"Data has not been filled"}}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">No Lessen Berniaga</label><br>
                                <label class="filldata" for="" id="label_form">{{isset($data->manpower->business_license_no)?$data->manpower->business_license_no:"Data has not been filled"}}</label>
                            </div>
                            <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Alamat Perniagaan</label><br>
                                <label class="filldata" for="" id="label_form">{{isset($data->manpower->business_address)?$data->manpower->business_address:"Data has not been filled"}}</label>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Aktiviti Perniagaan</label><br>
                                <label class="filldata" for="" id="label_form">{{isset($data->manpower->business_activity)?$data->manpower->business_activity_text->business_activity:"Data has not been filled"}}</label>
                            </div>
                            <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">No Telefon Perniagaan</label><br>
                                <label class="filldata" for="" id="label_form">{{isset($data->manpower->business_phone)?$data->manpower->business_phone:"Data has not been filled"}}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Emel</label><br>
                                <label class="filldata" for="" id="label_form">{{isset($data->manpower->business_email)?$data->manpower->business_email:"Data has not been filled"}}</label>
                            </div>
                            <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Website Syarikat</label><br>
                                <label class="filldata" for="" id="label_form">{{isset($data->manpower->website)?$data->manpower->website:"Data has not been filled"}}</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Pendapatan Tahunan</label><br>
                                <label class="filldata" for="" id="label_form">{{isset($data->manpower->business_income)?$data->manpower->business_income_text->business_income:"Data has not been filled"}}</label>
                            </div>
                            {{-- <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Pautan Laman Sosial</label><br>
                                <label class="filldata" for="" id="label_form">{{isset($data->manpower->business_sosmed)?$data->manpower->business_sosmed:"Data has not been filled"}}</label>
                            </div> --}}
                        </div>
                        
                        
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection