@extends('home')
@section('title-dashboard', 'Ahli')

@section('title', 'Maklumat Peribadi')

@section('breadcrumb')

    <li class="breadcrumb-item active">Maklumat Peribadi</li>

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
    <div class="row">
        <div class="col-12">
            <div class="card card-danger card-outline" style="border-top: 3px solid dark">
                <div class="card-header">
                    <h3 class="card-title text-danger my-header">Maklumat Peribadi</h3>
                    <div class="card-tools">
                        <a href="{{ URL::to('personalDetail/' . Auth::user()->id . '/edit') }}" title="Edit"
                            class="btn btn-sm btn-warning" title="Edit">Edit</a>
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
                                <div class="col-lg-12">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Gambar Profile</label><br>
                                    <img src="/Profil/{{ $data->photo }}" alt="Upload Profile" width="100"
                                        height="100">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Nama Penuh</label><br>
                                    <label class="filldata" for="" id="label_form">{{ $data->fullname }}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Persatuan Dimasuki</label><br>
                                    @foreach ($joinCompany as $d)
                                        <img src="/CompanyLogo/{{ isset($d->company->logo_picture) ? $d->company->logo_picture : 'user.png' }}"
                                            style="min-height:50px; max-height:50px" width="50px" height="50px"
                                            alt="{{ isset($d->company->full_company_name) ? $d->company->full_company_name : '-' }}"
                                            title="{{ isset($d->company->full_company_name) ? $d->company->full_company_name : '-' }}">
                                    @endforeach
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Nomor Telefon</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->phone_number) ? $data->phone_number : 'Data has not been filled' }}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Emel</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->email) ? $data->email : 'Data has not been filled' }}</label>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">No Kad Pengenalan</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->manpower->ic_number) ? $data->manpower->ic_number : 'Data has not been filled' }}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Bangsa</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->manpower->nation->nation) ? $data->manpower->nation->nation : 'Data has not been filled' }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Agama</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->manpower->religion->religion) ? $data->manpower->religion->religion : 'Data has not been filled' }}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Status Bumiputera</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->manpower->native_status) ? $data->manpower->status_native->status_native : 'Data has not been filled' }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Jantina</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->manpower->gender) ? $data->manpower->gender_text->gender : 'Data has not been filled' }}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Status</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->manpower->marital_status) ? $data->manpower->marital_status_text->marital_status : 'Data has not been filled' }}</label>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Daerah/Bandar</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->manpower->city->city) ? $data->manpower->city->city : 'Data has not been filled' }}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Negeri</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->manpower->state->state) ? $data->manpower->state->state : 'Data has not been filled' }}</label>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Parlimen</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->manpower->parliament->parliament) ? $data->manpower->parliament->parliament : 'Data has not been filled' }}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">DUN</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->manpower->dun->dun) ? $data->manpower->dun->dun : 'Data has not been filled' }}</label>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Poskod</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->manpower->postcode) ? $data->manpower->postcode : 'Data has not been filled' }}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Alamat Perhubungan</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($data->manpower->address) ? $data->manpower->address : 'Data has not been filled' }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Cawangan</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($manpower->cawangan->fullname) ? $manpower->cawangan->fullname : 'Data has not been filled' }}</label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;" for="">Ketua Bahagian</label><br>
                                    <label class="filldata" for=""
                                        id="label_form">{{ isset($manpower->ketuaBahagian->fullname) ? $manpower->ketuaBahagian->fullname : 'Data has not been filled' }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mt-3">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;">Status Mualaf</label><br>
                                    <label class="filldata" id="label_form">
                                        @if (isset($manpower->is_mualaf))
                                            {{ $manpower->is_mualaf == 1 ? 'Ya' : 'Tidak' }}
                                        @else
                                            Data has not been filled
                                        @endif
                                    </label>
                                </div>

                                <div class="col-lg-6 mt-3">
                                    <label class="filldata text-muted font-italic label_form_judul"
                                        style="margin-bottom: 0px;">Tarikh Pengislaman</label><br>
                                    <label class="filldata" id="label_form">
                                        {{ isset($manpower->tarikh_pengislaman) ? \Carbon\Carbon::parse($manpower->tarikh_pengislaman)->format('d/m/Y') : 'Data has not been filled' }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
