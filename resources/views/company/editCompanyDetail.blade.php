@extends('home')
@section('title-dashboard', 'Persatuan')
@section('title','Persatuan Detail')

@section('breadcrumb')

<li class="breadcrumb-item active"><a href="{{URL::previous()}}">Maklumat Cawangan</a></li>
<li class="breadcrumb-item active">Edit</li>

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
        padding-bottom: 8px; font-size: 13px;
    }
    .my-button {
        font-size: 15px;
    }

    .my-button-upload {
        height: 35px;
        font-size: 11px;
    }
    .my-header {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 0px;
    }
</style>
<div class="card card-danger card-outline" style="border-top: 3px solid dark" id="viewEdit">
    <div class="card-header text-danger text-center" >
        <h3 class="card-title my-header">Edit Maklumat Cawangan</h3>
    </div>
    <div class="card-body">
        <form action="{{URL::to('companyDetail/update/'.$data->id.'')}}" method="POST" enctype="multipart/form-data">
            @csrf

    		@if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>
                        {{ $message }}
                        <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                    </p>
                </div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div>
                        <label class="font-weight-700 labelku">Gambar Persatuan</label>
                    </div>
                    <div class="mb-3">
                        <img id="image" src="/CompanyLogo/{{ $data->company->logo_picture }}" width="100px" alt="Logo Persatuan">
                    </div>
                    <input type="file" id="img" name="img" onchange="readURL(this);" accept="image/*">

                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-700 labelku">ToyyibPay</label>
                        <textarea class="form-control" name="billplz_data" rows="3" cols="50" readonly>Category Code: {{$data->company->collection_id}}&#13;&#10;Secret Key: {{$data->company->secret_key}}&#13;&#10;</textarea><br>
                        <button type="button" data-toggle="modal" href="#" data-id="" data-target="#billplzModal" class="btn btn-sm btn-info my-button form-control form-control-lg" style="padding: 0px;">Setting</button>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-700 labelku">Nama Pertubuhan</label>
                        <input type="text" value="{{isset($data->company->full_company_name)?$data->company->full_company_name:""}}" class="form-control form-control-lg" placeholder="" name="full_company_name" required autofocus>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-700 labelku">Alamat Perhubungan</label>
                        <input type="text" value="{{isset($data->company->address)?$data->company->address:""}}" class="form-control form-control-lg" placeholder="" name="address" required autofocus>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-700 labelku">Poskod</label>
                        <input type="text" value="{{isset($data->company->postcode)?$data->company->postcode:""}}" class="form-control form-control-lg" placeholder="" name="postcode" required autofocus>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-700 labelku">No Pendaftaran Pertubuhan</label>
                        <input type="text" value="{{isset($data->company->company_registration)?$data->company->company_registration:""}}" class="form-control form-control-lg" placeholder="" name="company_registration" required autofocus>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-700 labelku">Negeri</label>
                        <select name="id_state" value='{{ $data->company->id_state }}' class="form-control form-control-lg1" required autofocus>
            				<option disabled value="">Pilih Negeri</option>
            				@foreach($state as $d)
            				<option value="{{ $d->id_state }}" {{ $data->company->id_state == $d->id_state ? 'selected':''}}>{{ $d->state }}</option>
            				@endforeach
                		</select>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-700 labelku">No Telefon Pejabat</label>
                        <input type="text" value="{{isset($data->company->phone_office)?$data->company->phone_office:""}}" class="form-control form-control-lg" placeholder="" name="phone_office" required autofocus>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-700 labelku">Daerah/Bandar</label>
                        <select name="id_city" value='{{ $data->company->id_city }}' class="form-control form-control-lg1" required autofocus>
            				<option disabled value="">Pilih Daerah</option>
            				@foreach($city as $d)
            				<option value="{{ $d->id_city }}" {{ $data->company->id_city == $d->id_city ? 'selected':''}}>{{ $d->city }}</option>
            				@endforeach
                		</select>
                    </div>
                </div>



                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-700 labelku">No Fax</label>
                        <input type="text" value="{{isset($data->company->fax_number)?$data->company->fax_number:""}}" class="form-control form-control-lg" placeholder="" name="fax_number" autofocus>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-700 labelku">Laman Sesawang Rasmi</label>
                        <input type="text" value="{{isset($data->fullname)?$data->fullname:""}}" class="form-control form-control-lg" placeholder="" name="company_website" required autofocus>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-700 labelku">No Telefon </label>
                        <input type="text" value="{{isset($data->phone_number)?$data->phone_number:""}}" class="form-control form-control-lg" placeholder="" name="fullname" autofocus>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-700 labelku">Kostum Nama Pautan</label>
                        <input type="text" value="" class="form-control form-control-lg" placeholder="" name="fullname" autofocus>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-700 labelku">Emel</label>
                        <input type="text" value="{{isset($data->email)?$data->email:""}}" class="form-control form-control-lg" placeholder="" name="fullname" required autofocus>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-700 labelku">Yuran</label>
                        <input type="text" value="{{isset($data->company->joining_fee)?$data->company->joining_fee:""}}" class="form-control form-control-lg" placeholder="" name="joining_fee" required autofocus>
                    </div>
                </div>

            </div>
            @if(1==2)
            <div class="row">
                <div class="col-md-9">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="#" class="col-sm-2 col-form-label">Company Name</label>
                            <div class="col-sm-10">
                                <input type="text" value="{{isset($data->company->full_company_name)?$data->company->full_company_name:""}}" class="form-control" name="full_company_name" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-2 col-form-label">Old Company Registration Number</label>
                            <div class="col-sm-10">
                                <input type="text" value="{{isset($data->company->company_registration_old_number)?$data->company->company_registration_old_number:""}}" class="form-control" name="company_registration_old_number" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-2 col-form-label">New Company Registration Number</label>
                            <div class="col-sm-10">
                                <input type="number" value="{{isset($data->company->company_registration_new_number)?$data->company->company_registration_new_number:""}}" class="form-control" name="company_registration_new_number" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-2 col-form-label">Address</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="address" rows="3" cols="50" required autofocus>{{isset($data->company->address)?$data->company->address:""}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-2 col-form-label">Country</label>
                            <div class="col-sm-10" id="div_country">
                                <select class="form-control  searchCountry input_id_country" id="id_country" name="id_country" style="width: 100%;"></select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-2 col-form-label">State</label>
                            <div class="col-sm-10" id="div_state">
                                <select class="form-control searchState input_id_state" id="id_state" name="id_state" readonly></select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-2 col-form-label">City</label>
                            <div class="col-sm-10" id="div_city">
                                <select class="form-control searchCity input_id_city" id="id_city" name="id_city" readonly></select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-2 col-form-label">PostCode</label>
                            <div class="col-sm-10">
                                <input type="number" value="{{isset($data->company->postcode)?$data->company->postcode:""}}" class="form-control" name="postcode" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" value="{{isset($data->email)?$data->email:""}}" class="form-control" name="email" required autofocus readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-2 col-Porm- Obel">Phone Office</label>
                            <div class="col-sm-10">
                                <input type="number" value="{{isset($data->company->phone_office)?$data->company->phone_office:""}}" class="form-control" name="phone_office" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-2 col-Porm- Obel">Fax Number</label>
                            <div class="col-sm-10">
                                <input type="number" value="{{isset($data->company->fax_number)?$data->company->fax_number:""}}" class="form-control" name="fax_number" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-2 col-form-label">Company Website</label>
                            <div class="col-sm-10">
                                <input type="text" value="{{isset($data->company->company_website)?$data->company->company_website:""}}" class="form-control" name="company_website" required autofocus>
                            </div>
                        </div>
                    </div>
                </div>
                <div></div>

                <div class="col-md-3">
                    <div class="text-center">
                        <label for="">Company Logo</label><br>
                        @if($data->company->logo_picture == null)
                        <img src="/images/add.png" alt="avatar" width="100" height="100" class="brand-image img-circle elevation-3" style="opacity: .8">
                        @else
                        <img src="{{asset('CompanyLogo/'.$data->company->logo_picture.'')}}" alt="avatar" width="100" height="100" class="brand-image img-circle elevation-3" style="opacity: .8">
                        @endif
                        <br><br>
                        <h6>Choose your company logo</h6>
                        <input id="logo_picture" type="file" name="logo_picture" class="form-control" accept="image/*">

                    </div><br><br>
                    <div class="text-center">
                        <label for="">Organization Chart</label><br>
                        @if($data->company->company_organization_chart == null)
                        <img src="/images/organizations.png" alt="avatar" width="150" height="150">
                        @else
                        <img src="{{asset('OrganizationChart/'.$data->company->company_organization_chart.'')}}" alt="avatar" width="150" height="150">
                        @endif
                        <br><br>
                        <h6>Choose your organization chart...</h6>
                        <input id="company_organization_chart" type="file" name="company_organization_chart" class="form-control" accept="image/*, application/pdf">

                    </div>
                </div>
            </div>
            @endif
            <div class="card-footer">
                <a href="{{URL::to('companyDetail/'.Auth::user()->id)}}" title="Back" class="btn btn-sm btn-danger my-button">Cancel</a>
                <input type="submit" value="Save" title="Save" class="btn btn-sm btn-success">
            </div>
        <form></form>
    </div>
</div>

<div class="modal fade" id="billplzModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="" method="POST" class="form-billplz" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="exampleModalLabel">Maklumat ToyyibPay (Gerbang Pembayaran)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body my-table">
                    <div class="form-group">
                        <input type="hidden" name="id" value="{{$data->company->id_detail_company}}">
                        <label for="#">Category Code <span style="color: #b91c1c;" >*</span></label>
                        <input type="text" class="form-control" id="collection_id" value="{{$data->company->collection_id}}" name="collection_id" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label for="#">Secret Key <span style="color: #b91c1c;" >*</span></label>
                        <input type="text" class="form-control" id="secret_key" value="{{$data->company->secret_key}}" name="secret_key" placeholder="" required>
                    </div>
                    {{-- <div class="form-group">
                        <label for="#">Signature Payment <span style="color: #b91c1c;" >*</span></label>
                        <input type="text" class="form-control" id="signature_payment" value="{{$data->company->signature_payment}}" name="signature_payment" placeholder="" required>
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                    <input id="btnsubmitku" type="submit" value="Save" class="btn btn-sm btn-success">
                </div>
            </div>
        </form>
    </div>
</div>

@include('layouts.modals')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script type="text/javascript" src="/js/page/company/editCompanyDetail.js"></script>

@endsection
