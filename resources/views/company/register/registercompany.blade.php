@extends('login.template')
@section('title-dashboard', 'Company')
@section('title', 'Register')
@section('content')
    <style>
        .btnku {
            background-color: white !important;
            color: #383444 !important;
            border: 2px solid #383444 !important;
        }

        .btnku:hover {
            background-color: #383444 !important;
            color: white !important;
        }

        /*==========*/
        .form-control-lg {
            height: calc(2.875rem + 2px) !important;
            padding: 1rem .8rem !important;
            font-size: 13px !important;
            line-height: 1.5 !important;
            border-radius: .3rem !important;
        }

        .labelku {
            font-size: 15px;
        }

        .titleku {
            font-size: 18px;
        }

        /*div.btn-group.bootstrap-select.form-control.form-control4.form-control-lg{*/
        /*    background: white !important;*/
        /*}*/
        .form-control4 {
            background: #fff none repeat scroll 0 0 !important;
            border: 0 none;
            box-shadow: 0px 0px 0px 0 rgb(0 0 0 / 0%) !important;
            font-size: 16px;
            height: 50px;
            padding: 0 20px;
        }

        .bootstrap-select .dropdown-toggle {
            background-color: #f9faff !important;
        }

        .btn-group>.btn:first-child {
            margin-left: -10px;
        }

        .button-md {
            padding: 10px 18px;
            font-size: 16px;
            font-weight: 500;
        }
    </style>

    <div class="section-full content-inner shop-account">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3 class="font-weight-700 m-t0 m-b20 titleku">PENDAFTARAN PERSATUAN</h3>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-danger">
                            <p>
                                {{ $message }}
                                <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                            </p>
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 m-b30">
                    <div class="p-a30 border-1  max-w500 m-auto">
                        <div class="tab-content">
                            <form action="{{ route('company.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <h4 class="font-weight-700 titleku">MAKLUMAT PERIBADI</h4>
                                <p class="font-weight-600">Jika anda sudah berdaftar sila <a href="{{ route('login') }}"><b
                                            style="color: #383444;"> Log Masuk</b></a>
                                </p>
                                <div>
                                    <input hidden type="number" value="{{ Request::input('price') }}"
                                        name="price_subscribe" id="">
                                    <input hidden type="number" value="{{ Request::input('expired') }}"
                                        name="year_subscribe" id="">
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-700 labelku">Nama Wakil <span style="color: #383444;">*</span>
                                    </label>
                                    <input id="nama_penuh" type="text"
                                        class="form-control-lg form-control @error('nama_penuh') is-invalid @enderror"
                                        name="nama_penuh" value="{{ old('nama_penuh') }}" placeholder="Nama Penuh" required
                                        autocomplete="nama_penuh" autofocus>

                                    @error('nama_penuh')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-700 labelku">Nama Komuniti <span
                                            style="color: #383444;">*</span> </label>
                                    <input id="nama_pertubuhan" type="text"
                                        class="form-control-lg form-control @error('nama_pertubuhan') is-invalid @enderror"
                                        name="nama_pertubuhan" value="{{ old('nama_pertubuhan') }}"
                                        placeholder="Nama Persatuan" required autocomplete="nama_pertubuhan" autofocus>

                                    @error('nama_pertubuhan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label class="font-weight-700 labelku">Emel Wakil <span style="color: #383444;">*</span>
                                    </label>
                                    <input id="email" type="email"
                                        class="form-control-lg form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" placeholder="Your Email Id" required
                                        autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-700 labelku">No. Telefon Wakil<span
                                            style="color: #383444;">*</span> </label>
                                    <?php $country = App\Models\Country::where('id_country', '>', '0')->get(); ?>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select class="form-control form-control4 form-control-lg" name="dial_code"
                                                autofocus>
                                                <option selected disabled value="">Kod Negara</option>
                                                @foreach ($country as $countries)
                                                    <option value="{{ $countries->country_code }}"
                                                        {{ old('country_code') == $countries->country_code ? 'selected' : '' }}>
                                                        +{{ $countries->country_code }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-8 pl-0">
                                            <input id="phone_number"
                                                style="padding-top: 12px !important; margin-top: 12px !important;"
                                                type="number"
                                                class="form-control-lg form-control @error('phone_number') is-invalid @enderror"
                                                name="phone_number" placeholder ="No. Telefon Wakil" required>

                                            @error('phone_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-700 labelku">Kata Laluan <span
                                            style="color: #383444;">*</span> </label>
                                    <input id="password" type="password"
                                        class="form-control-lg form-control @error('password') is-invalid @enderror"
                                        name="password" placeholder="Type Password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-700 labelku">Sahkan Kata Laluan <span
                                            style="color: #383444;">*</span> </label>
                                    <input id="password-confirm" type="password" class="form-control-lg form-control"
                                        name="password_confirmation" placeholder = "Confirm Password" required
                                        autocomplete="new-password">
                                </div>
                                <div class="form-group">
                                    <br>
                                    <input type="checkbox" id="checkbox" name="checkbox" value="" required
                                        autocomplete="checkbox">
                                    &nbsp;&nbsp;Dengan mendaftar, Anda bersetuju dengan <a href=""
                                        data-toggle="modal" data-target="#exampleModal">terma, syarat </a> dan <a
                                        href="" data-toggle="modal" data-target="#exampleModal">Akta pelindungan
                                        privasi </a>
                                </div>
                                <div id="btnsubmitku" class="text-left">
                                    <button class="site-button button-md outline outline-2 btnku btn btn-md"
                                        type="submit">Daftar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: white">
                    <p class="modal-title" style="color: black;" id="exampleModalLabel">Terms & Conditions</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
                $term = App\Models\Term::where('id_level', 3)->get();
                ?>
                <div class="modal-body" style="overflow: auto; height: 400px; padding: 10px;">
                    @foreach ($term as $terms)
                        <p style="font-size:10px; text-align:justify;">{{ $terms->term_conditions }}</p>
                    @endforeach
                </div>
                <div class="modal-footer" style="height: 50px;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $("#btnsubmitku").click(function() {
                var password = $("#password").val();
                var confirmPassword = $("#password-confirm").val();
                if (password !== confirmPassword) {
                    alert("Passwords not match.");
                    return false;
                }
                return true;
            });
        });
    </script>
@endsection
