@extends('login.template')
@section('title')
    <h1 style="color: #fff">Selamat Datang</h1>
    <br>
    <h5 style="color: #fff">SISTEM PENDAFTARAN PENJAJA, PENIAGA KECIL DAN KOPERASI BERSEPADU - DATAPPK G3PNS</h5>
@endsection
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

    <style type="text/css">
        #customBtn {
            display: inline-block;
            background: white;
            color: #444;
            width: 190px;
            border-radius: 5px;
            border: thin solid #888;
            box-shadow: 1px 1px 1px grey;
            white-space: nowrap;
        }

        #customBtn:hover {
            cursor: pointer;
        }

        span.label {
            font-family: serif;
            font-weight: normal;
        }

        span.icon {
            background: url('/../images/google.png') transparent 5px 50% no-repeat;
            display: inline-block;
            vertical-align: middle;
            width: 42px;
            height: 42px;
        }

        span.buttonText {
            display: inline-block;
            vertical-align: middle;
            padding-left: 42px;
            padding-right: 42px;
            font-size: 14px;
            font-weight: bold;
            /* Use the Roboto font that is loaded in the <head> */
            font-family: 'Roboto', sans-serif;
        }
    </style>

    <!-- contact area -->
    <div class="section-full content-inner-2 shop-account">
        <!-- Product -->
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3 class="font-weight-700 m-t0 m-b20 titleku">Masuk Akaun Anda</h3>
                    @if (\Session::has('message'))
                        <div class="alert alert-success">
                            <p>
                                {!! \Session::get('message') !!}
                                <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                            </p>
                        </div>
                    @endif
                    @if (\Session::has('success'))
                        <div class="alert alert-success">
                            <p>
                                {!! \Session::get('success') !!}
                                <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                            </p>
                        </div>
                    @endif
                    @if (\Session::has('failed'))
                        <div class="alert alert-danger">
                            <p>
                                {!! \Session::get('failed') !!}
                                <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                            </p>
                        </div>
                    @endif
                </div>
            </div>
            <div>
                <div class="max-w500 m-auto m-b30">
                    <input type="hidden" name="param">
                    <input type="hidden" name="fcm_token">

                    <div class="p-a30 border-1 seth">
                        <div class="tab-content nav">
                            <form method="POST" action="" class="form-login tab-pane active col-12 p-a0">
                                @csrf
                                <h4 class="font-weight-700 labelku">{{ __('menu.log_in') }}</h4>
                                <p class="font-weight-700 labelku">Belum mendaftar?
                                    <br> Klik <a href="{{ url('register_ahli/create?is_foreign=false') }}"
                                        style="color: #383444;"><b> Ahli</b></a>
                                    untuk Individu
                                    <br>
                                    Klik <a href="{{ url('register_company/select_package') }}" style="color: #383444;"><b>
                                            Bina komuniti anda sekarang</b></a>
                                    <br>
                                    {{-- Klik <a href="{{ url('register_ahli/create?is_foreign=true') }}" style="color: #383444;"><b> Komuniti</b></a>
                                    bukan warga negara --}}
                                </p>

                                <div class="form-group">
                                    <label class="font-weight-700 labelku">{{ __('menu.email') }} <span
                                            style="color: #383444;">*</span>
                                    </label>
                                    <input id="email" type="email"
                                        class="form-control-lg form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" placeholder="Emel" required
                                        autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-700 labelku">{{ __('menu.password') }} <span
                                            style="color: #383444;">*</span> </label>
                                    <input id="password" type="password"
                                        class="form-control-lg form-control @error('password') is-invalid @enderror"
                                        name="password" placeholder="Kata Laluan" required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="text-left">
                                    <input type="submit" class="btn btn-md site-button m-r5 button-md"
                                        value="{{ __('menu.log_in') }}" style="background-color: #383444;"></input>
                                    <a href="#" data-target="#forgotModal" data-toggle="modal" class="m-l5"
                                        style="color: #383444;"><i class="fa fa-unlock-alt" style="color: #383444;"></i>
                                        Lupa Kata Laluan?</a>
                                </div>
                            </form>

                            <div id="gSignInWrapper" style="margin-top: 20px;">
                                <a href="{{ url('auth/google') }}"><span class="label">Sign in with:</span>
                                    <div id="customBtn" class="customGPlusSignIn">
                                        <span class="icon"></span>
                                        <span class="buttonText">Google</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Product END -->
    </div>

    <!-- contact area  END -->

    <!--Modal Auth-->
    <div class="modal fade" id="forgotModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #383444;">
                    <h5 class="modal-title" id="exampleModalLabel">Lupa Kata Laluan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body my-table">

                    <form method="POST" action="/resetPassword" class="tab-pane active col-12 p-a0">
                        @csrf
                        <p class="font-weight-700 labelku">Masukkan email yang terdaftar</p>

                        <div class="form-group">
                            <label class="font-weight-700 labelku">Emel <span style="color: #383444;">*</span> </label>
                            <input id="email_reset" type="email"
                                class="form-control-lg form-control @error('email_reset') is-invalid @enderror"
                                name="email_reset" value="{{ old('email_reset') }}" placeholder="Emel" required
                                autocomplete="email_reset" autofocus>

                            @error('email_reset')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="text-left">
                            <button class="btn btn-md text-white" style="background-color: #383444;">Reset
                                Kata Laluan</button>
                        </div>
                    </form>

                </div>
                <!--<div class="modal-footer">-->

                <!--</div>-->
            </div>
        </div>
    </div>
    <!--END Modal Auth-->

    @include('layouts.modals')


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script type="text/javascript" src="/js/page/auth/login.js"></script>
@endsection
