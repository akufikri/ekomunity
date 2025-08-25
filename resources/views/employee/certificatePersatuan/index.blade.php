@extends('home')
@section('title-dashboard', 'Ahli')

@section('title', 'Sijil Cawangan')

@section('breadcrumb')

    <li class="breadcrumb-item active">Sijil Cawangan</li>

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
            @forelse($data as $d)
                <div class="card card-danger card-outline" style="border-top: 3px solid dark">
                    <div class="card-header">
                        <h3 class="card-title my-header"><img src="/CompanyLogo/{{ $d->company->logo_picture }}" alt=""
                                width="50" height="50"> {{ $d->company->full_company_name }}</h3>
                        <div class="card-tools">
                            <a href="/sijilPersatuanView/{{ $d->encrypt }}" target="_blank" title="View"
                                class="btn btn-sm btn-info" title="View">View</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card card-danger card-outline" style="border-top: 3px solid dark">
                    <div class="card-header">
                        <h3 class="card-title my-header"><img src="{{ asset('landingpage/images/logo-usia.png') }}" alt="" width="50"
                                height="50">Anda belum didaftarkan ke mana-mana cawangan</h3>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
