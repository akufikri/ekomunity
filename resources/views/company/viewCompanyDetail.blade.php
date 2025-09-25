@extends('home')
@section('title-dashboard', 'Maklumat Komuniti')
@section('title', 'Maklumat Komuniti')

@section('breadcrumb')

    <li class="breadcrumb-item active">Maklumat Komuniti</li>

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

        .form-control-lg {
            height: calc(2.875rem + 2px);
            padding: 1rem .8rem;
            font-size: 13px;
            line-height: 1.5;
            border-radius: .3rem;
        }

        .form-control-lgku {
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
            padding-bottom: 8px;
            font-size: 15px;
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


    <div class="row" id="view">

        <div class="col-12">
            <div class="card card-danger card-outline">
                <div class="card-header">
                    <h3 class="card-title text-danger my-header">Maklumat Komuniti</h3>
                    @if (Auth::user()->sub_company == null)
                        <div class="card-tools">
                            <a href="{{ URL::to('companyDetail/' . Auth::user()->id . '/edit') }}#viewEdit" title="Edit"
                                class="btn btn-sm btn-warning" title="Edit">Edit</a>

                        </div>
                    @endif
                </div>

                <!--<div class="card-header">-->
                <!--    <h3 class="card-title text-primary my-header">List Vendor's License</h3>-->
                <!--    <div class="card-tools">-->
                <!--        <a href="#" data-toggle="modal" data-target="#addVendor" title="Add"  class="btn btn-sm btn-success pull-right">-->
                <!--            <i class="fa fa-plus nav-icon"></i>-->
                <!--            &nbsp; Add-->
                <!--        </a>-->
                <!--    </div>-->
                <!--</div>-->
                @csrf

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
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Gambar Persatuan</label><br>
                                    <img src="/CompanyLogo/{{ $data->company->logo_picture }}" alt="Upload Profile"
                                        width="100" height="100">
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">ToyyibPay</label><br>
                                    <textarea class="form-control" name="billplz_data" rows="3" cols="50" readonly>Category Code: {{ $data->company->collection_id }}&#13;&#10;Secret Key: {{ $data->company->secret_key }}&#13;&#10;</textarea><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul" for="">Nama
                                        Wakil</label><br>
                                    <label class="filldata" id="label_form"
                                        for="">{{ isset($data->fullname) ? $data->fullname : 'Data has not been filled' }}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Email Wakil</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->email) ? $data->email : 'Data has not been filled' }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul" for="">No
                                        Telefon Wakil </label><br>
                                    <label class="filldata" id="label_form"
                                        for="">{{ isset($data->phone_number) ? $data->phone_number : 'Data has not been filled' }}</label>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul" for="">Nama
                                        Pertubuhan</label><br>
                                    <label class="filldata" id="label_form"
                                        for="">{{ isset($data->company->full_company_name) ? $data->company->full_company_name : 'Data has not been filled' }}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Email</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->company->email_company) ? $data->company->email_company : 'Data has not been filled' }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">No Pendaftaran Pertubuhan</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->company->company_registration) ? $data->company->company_registration : 'Data has not been filled' }}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Poskod</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->company->postcode) ? $data->company->postcode : 'Data has not been filled' }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">No Telefon Pejabat</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->company->phone_office) ? $data->company->phone_office : 'Data has not been filled' }}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Daerah/Bandar</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->company->city->city) ? $data->company->city->city : 'Data has not been filled' }}</label>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">No Fax</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->company->fax_number) ? $data->company->fax_number : 'Data has not been filled' }}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Negeri</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->company->state->state) ? $data->company->state->state : 'Data has not been filled' }}</label>
                                </div>
                            </div>
                            <div class="vl"></div>
                            <div class="row">

                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">No Telefon </label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->phone_number) ? $data->phone_number : 'Data has not been filled' }}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Laman Sasawang Rasmi</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->company->company_website) ? $data->company->company_website : 'Data has not been filled' }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Yuran</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->company->joining_fee) ? 'RM' . $data->company->joining_fee : 'Data has not been filled' }}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Alamat Perhubungan</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->company->address) ? $data->company->address : 'Data has not been filled' }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Slogan</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->company->slogan) ? $data->company->slogan : 'Data has not been filled' }}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Mengenai</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->company->mengenai) ? $data->company->mengenai : 'Data has not been filled' }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Banner</label><br>
                                    <img src="/CompanyBanner/{{ $data->company->banner }}" alt="Upload Profile"
                                        width="100" height="100">
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Pautan</label><br>
                                    @if ($data->company->custom_link)
                                        <a href="{{ env('APP_URL') }}/{{ $data->company->custom_link }}">
                                            <i><u>{{ env('APP_URL') }}/{{ $data->company->custom_link }}</u></i>
                                        </a>
                                    @else
                                        <a href="{{ env('APP_URL') }}/persatuan/{{ $data->company->key_reference }}">
                                            <i><u>{{ env('APP_URL') }}/persatuan/{{ $data->company->key_reference }}</u></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $data_temp_detail_company = \App\Models\TempDetailCompany::where('id_user', Auth::user()->id)
            ->where('id_request_update', '0')
            ->orderBy('id_temp_detail_company', 'desc')
            ->first();
    @endphp
    @if ($data_temp_detail_company)
        <div class="row" id="view">

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-primary my-header">Company Detail Update</h3>
                        <div class="card-tools">
                            <a href="{{ URL::to('clearRequestUpdateCompany/DETAIL_COMPANY') }}#viewEdit"
                                title="Cancel Update" class="btn btn-sm btn-danger">Cancel Update</a>
                            <!--<a href="#" data-toggle="modal" data-target="#addVendor" title="Add"  class="btn btn-sm btn-success pull-right">-->
                            <!--    <i class="fa fa-plus nav-icon"></i>-->
                            <!--    &nbsp; Add-->
                            <!--</a>-->
                        </div>
                    </div>

                    <!--<div class="card-header">-->
                    <!--    <h3 class="card-title text-primary my-header">List Vendor's License</h3>-->
                    <!--    <div class="card-tools">-->
                    <!--        <a href="#" data-toggle="modal" data-target="#addVendor" title="Add"  class="btn btn-sm btn-success pull-right">-->
                    <!--            <i class="fa fa-plus nav-icon"></i>-->
                    <!--            &nbsp; Add-->
                    <!--        </a>-->
                    <!--    </div>-->
                    <!--</div>-->
                    @csrf

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
                                    <div class="col-lg-6">
                                        <label class="filldata text-muted font-italic label_form_judul"
                                            for="">Company Name</label><br>
                                        <label class="filldata" id="label_form"
                                            for="">{{ isset($temp_data->full_company_name) ? $temp_data->full_company_name : 'Data has not been filled' }}</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="filldata text-muted font-italic label_form_judul"
                                            style="margin-bottom: 0px;" for="">Company Type</label><br>
                                        <label class="filldata" for=""
                                            id="label_form">{{ isset($temp_data->company_type->company_type) ? $temp_data->company_type->company_type : 'Data has not been filled' }}</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="filldata text-muted font-italic label_form_judul"
                                            style="margin-bottom: 0px;" for="">Old Company Registration
                                            Number</label><br>
                                        <label class="filldata" for=""
                                            id="label_form">{{ isset($temp_data->company_registration_old_number) ? $temp_data->company_registration_old_number : 'Data has not been filled' }}</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="filldata text-muted font-italic label_form_judul"
                                            style="margin-bottom: 0px;" for="">New Company Registration
                                            Number</label><br>
                                        <label class="filldata" for=""
                                            id="label_form">{{ isset($temp_data->company_registration_new_number) ? $temp_data->company_registration_new_number : 'Data has not been filled' }}</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="filldata text-muted font-italic label_form_judul"
                                            style="margin-bottom: 0px;" for="">Phone Office</label><br>
                                        <label class="filldata" for=""
                                            id="label_form">{{ isset($temp_data->phone_office) ? $temp_data->phone_office : 'Data has not been filled' }}</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="filldata text-muted font-italic label_form_judul"
                                            style="margin-bottom: 0px;" for="">Fax Number</label><br>
                                        <label class="filldata" for=""
                                            id="label_form">{{ isset($temp_data->fax_number) ? $temp_data->fax_number : 'Data has not been filled' }}</label>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="filldata text-muted font-italic label_form_judul"
                                            style="margin-bottom: 0px;" for="">Postcode</label><br>
                                        <label class="filldata" for=""
                                            id="label_form">{{ isset($temp_data->postcode) ? $temp_data->postcode : 'Data has not been filled' }}</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="filldata text-muted font-italic label_form_judul"
                                            style="margin-bottom: 0px;" for="">Country</label><br>
                                        <label class="filldata" for=""
                                            id="label_form">{{ isset($temp_data->country->country_name) ? $temp_data->country->country_name : 'Data has not been filled' }}</label>
                                    </div>
                                </div>
                                <div class="vl"></div>
                                <div class="row">

                                    <div class="col-lg-6">
                                        <label class="filldata text-muted font-italic label_form_judul"
                                            style="margin-bottom: 0px;" for="">State</label><br>
                                        <label class="filldata" for=""
                                            id="label_form">{{ isset($temp_data->state->state) ? $temp_data->state->state : 'Data has not been filled' }}</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="filldata text-muted font-italic label_form_judul"
                                            style="margin-bottom: 0px;" for="">City</label><br>
                                        <label class="filldata" for=""
                                            id="label_form">{{ isset($temp_data->city->city) ? $temp_data->city->city : 'Data has not been filled' }}</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="filldata text-muted font-italic label_form_judul"
                                            style="margin-bottom: 0px;" for="">Email</label><br>
                                        <label class="filldata" for=""
                                            id="label_form">{{ $data->email }}</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="filldata text-muted font-italic label_form_judul"
                                            style="margin-bottom: 0px;" for="">Website</label><br>
                                        <label class="filldata" for=""
                                            id="label_form">{{ isset($temp_data->company_website) ? $temp_data->company_website : 'Data has not been filled' }}</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="filldata text-muted font-italic label_form_judul"
                                            style="margin-bottom: 0px;" for="">Address</label><br>
                                        <label class="filldata" for=""
                                            id="label_form">{{ isset($temp_data->address) ? $temp_data->address : 'Data has not been filled' }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <hr>
                            </div>
                            <div class="col-lg-12">
                                <h3 class="text-primary my-header">Attachment</h3><br>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="filldata text-muted font-italic" style="margin-bottom: 0px;"
                                            for="">Company Logo</label><br>
                                        <label class="filldata" for=""
                                            id="label_form">{{ $temp_data->logo_picture }}</label>
                                        <sup class="primary"><a href="../CompanyLogo/{{ $temp_data->logo_picture }}"
                                                target="_blank"><i class="fas fa-download"></i></a></sup>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="filldata text-muted font-italic" style="margin-bottom: 0px;"
                                            for="">Organization Chart</label><br>
                                        <label class="filldata" for=""
                                            id="label_form">{{ $temp_data->company_organization_chart }}</label>
                                        <sup class="primary"><a
                                                href="../OrganizationChart/{{ $temp_data->company_organization_chart }}"
                                                target="_blank"><i class="fas fa-download"></i></a></sup>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="filldata text-muted font-italic" style="margin-bottom: 0px;"
                                            for="">Suruhanjaya Syarikat Malaysia (SSM) certificate</label><br>
                                        <label class="filldata" for=""
                                            id="label_form">{{ $temp_data->company_ssm_certificate }}</label>
                                        <sup class="primary"><a
                                                href="../CompanySsmCertificate/{{ $temp_data->company_ssm_certificate }}"
                                                target="_blank"><i class="fas fa-download"></i></a></sup>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="filldata text-muted font-italic" style="margin-bottom: 0px;"
                                            for="">Suruhanjaya Syarikat Malaysia (SSM) Section 14</label><br>
                                        <label class="filldata" for=""
                                            id="label_form">{{ $temp_data->company_ssm_section_14 }}</label>
                                        <sup class="primary"><a
                                                href="../CompanySsmSection14/{{ $temp_data->company_ssm_section_14 }}"
                                                target="_blank"><i class="fas fa-download"></i></a></sup>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="filldata text-muted font-italic" style="margin-bottom: 0px;"
                                            for="">Choose your Suruhanjaya Syarikat Malaysia (SSM) Section
                                            17</label><br>
                                        <label class="filldata" for=""
                                            id="label_form">{{ $temp_data->company_ssm_section_17 }}</label>
                                        <sup class="primary"><a
                                                href="../CompanySsmSection17/{{ $temp_data->company_ssm_section_17 }}"
                                                target="_blank"><i class="fas fa-download"></i></a></sup>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="filldata text-muted font-italic" style="margin-bottom: 0px;"
                                            for="">Choose your Trading License</label><br>
                                        <label class="filldata" for=""
                                            id="label_form">{{ $temp_data->company_ssm_trading_license }}</label>
                                        <sup class="primary"><a
                                                href="../CompanySsmTradingLicense/{{ $temp_data->company_ssm_trading_license }}"
                                                target="_blank"><i class="fas fa-download"></i></a></sup>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="filldata text-muted font-italic" style="margin-bottom: 0px;"
                                            for="">Choose your Suruhanjaya Syarikat Malaysia (SSM) Company
                                            Information</label><br>
                                        <label class="filldata" for=""
                                            id="label_form">{{ $temp_data->company_ssm_company_information }}</label>
                                        <sup class="primary"><a
                                                href="../CompanySsmCompanyInformation/{{ $temp_data->company_ssm_company_information }}"
                                                target="_blank"><i class="fas fa-download"></i></a></sup>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
