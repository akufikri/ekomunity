@extends('login.template')
@section('title-dashboard', 'Manpower')
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
                    <h3 class="font-weight-700 m-t0 m-b20 titleku">Pendaftaran Ahli</h3>
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
                            @auth
                                <input type="text" name="auth" value="{{ Auth::user()->id_level }}" hidden>
                            @endauth
                            <form action="" method="POST" class="form-register" enctype="multipart/form-data">
                                @csrf
                                <h4 class="font-weight-700 titleku">MAKLUMAT PERIBADI</h4>
                                @if (!Auth::user())
                                    <p class="font-weight-600">Sudah mempunyai akaun?
                                        <a href="{{ route('login') }}"><b style="color: #383444;"> Log Masuk</b></a>
                                    </p>
                                @endif

                                <div class="form-group">
                                    <label class="font-weight-700 labelku" id="title_foreign"></label>
                                    <input id="no_kad" type="number"
                                        class="form-control-lg form-control @error('no_kad') is-invalid @enderror"
                                        name="no_kad" value="{{ old('no_kad') }}" placeholder="No Kad" required autofocus>
                                    @error('no_kad')
                                        <span class="invalid-feedback"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-700 labelku">Nama Penuh <span
                                            style="color: #383444;">*</span></label>
                                    <input id="nama_penuh" type="text"
                                        class="form-control-lg form-control @error('nama_penuh') is-invalid @enderror"
                                        name="nama_penuh" value="{{ old('nama_penuh') }}" placeholder="Nama Penuh" required>
                                    @error('nama_penuh')
                                        <span class="invalid-feedback"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-700 labelku">No. telefon <span
                                            style="color: #383444;">*</span></label>
                                    <?php $country = App\Models\Country::where('id_country', '>', '0')->get(); ?>
                                    <div class="row">
                                        @if (false)
                                            <div class="col-md-4">
                                                <select class="form-control form-control4 form-control-lg" name="dial_code"
                                                    required>
                                                    <option selected disabled value="">Kod Negara</option>
                                                    @foreach ($country as $countries)
                                                        <option value="{{ $countries->country_code }}"
                                                            {{ old('country_code') == $countries->country_code ? 'selected' : '' }}>
                                                            +{{ $countries->country_code }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                        <div class="col-md-2 pr-0">
                                            <input id="dial_code"
                                                style="padding-top: 12px !important; margin-top: 12px !important; text-align: center;"
                                                type="text"
                                                class="form-control-lg form-control @error('dial_code') is-invalid @enderror"
                                                name="dial_code" value="+60" required readonly>
                                        </div>
                                        <div class="col-md-10">
                                            <input id="no_telefon"
                                                style="padding-top: 12px !important; margin-top: 12px !important;"
                                                type="number"
                                                class="form-control-lg form-control @error('no_telefon') is-invalid @enderror"
                                                name="no_telefon" placeholder="No. telefon" required>
                                            @error('no_telefon')
                                                <span class="invalid-feedback"
                                                    role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-700 labelku">Emel <span
                                            style="color: #383444;">*</span></label>
                                    <input id="email" type="email"
                                        class="form-control-lg form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" placeholder="Isi Emel Anda" required>
                                    @error('email')
                                        <span class="invalid-feedback"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                {{-- <div class="form-group">
                                    <label class="font-weight-700 labelku">Bahagian <span
                                            style="color: #383444;">*</span></label>
                                    <select name="id_bahagian" id="id_bahagian"
                                        class="form-control form-control4 form-control-lg">
                                        <option selected>--- Pilih Bahagian ---</option>
                                        @foreach ($getBahagian as $item)
                                            <option value="{{ $item->id_city }}">{{ $item->city }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-700 labelku">Cawangan <span
                                            style="color: #383444;">*</span></label>
                                    <select name="id_cawangan" id="id_cawangan"
                                        class="form-control form-control4 form-control-lg">
                                        <option selected>--- Pilih Cawangan ---</option>
                                        @foreach ($data as $item)
                                            <option value="{{ $item->user->id }}">({{ $item->user->kod_cawangan ?? 'N/A' }}) {{ $item->user->fullname ?? '-' }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div> --}}

                                {{-- <div class="form-group">
                                    <label class="font-weight-700 labelku">Bahagian <span
                                            style="color: #383444;">*</span></label>
                                    <select name="id_bahagian" id="id_bahagian"
                                        class="form-control form-control4 form-control-lg select2">
                                        <option selected>--- Pilih Bahagian ---</option>
                                        @foreach ($getBahagian as $item)
                                            <option value="{{ $item->id_city }}">{{ $item->city }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-700 labelku">Cawangan <span
                                            style="color: #383444;">*</span></label>
                                    <select name="id_cawangan" id="id_cawangan"
                                        class="form-control form-control4 form-control-lg select2">
                                        <option selected>--- Pilih Cawangan ---</option>
                                    </select>
                                </div> --}}

                                {{-- <div class="form-group" id="bahagian_wrapper" style="display:none;">
                                    <label class="font-weight-700 labelku">Bahagian</label>
                                    <input type="text" class="form-control" 
                                        name="bahagian_display" id="bahagian_display"
                                        disabled placeholder="Penampang / Bobi">
                                </div> --}}

                                <div class="form-group">
                                    <label class="font-weight-700 labelku">Kata Laluan <span
                                            style="color: #383444;">*</span></label>
                                    <input id="password" type="password"
                                        class="form-control-lg form-control @error('password') is-invalid @enderror"
                                        name="password" placeholder="Type Password" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-700 labelku">Pengesahan Kata Laluan <span
                                            style="color: #383444;">*</span></label>
                                    <input id="password-confirm" type="password" class="form-control-lg form-control"
                                        name="password_confirmation" placeholder="Isi Semula Kata Laluan Anda" required
                                        autocomplete="new-password">
                                </div>

                                {{-- <div class="form-group">
                                    <label class="font-weight-700 labelku">Nama Pencadang <span
                                            style="color: #383444;">*</span></label>
                                    <input id="nama_pencadang" type="text"
                                        class="form-control-lg form-control @error('nama_pencadang') is-invalid @enderror"
                                        name="nama_pencadang" value="{{ old('nama_pencadang') }}"
                                        placeholder="Nama Pencadang" required>
                                    @error('nama_pencadang')
                                        <span class="invalid-feedback"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div> --}}
                                {{-- 
                                <div class="form-group">
                                    <label class="font-weight-700 labelku">Nama Peyokong <span
                                            style="color: #383444;">*</span></label>
                                    <input id="nama_peyokong" type="text"
                                        class="form-control-lg form-control @error('nama_peyokong') is-invalid @enderror"
                                        name="nama_peyokong" value="{{ old('nama_peyokong') }}"
                                        placeholder="Nama Peyokong" required>
                                    @error('nama_peyokong')
                                        <span class="invalid-feedback"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div> --}}

                                <!-- Radio Mualaf -->
                                {{-- <div class="form-group">
                                    <label class="font-weight-700 labelku">
                                        Saya seorang Mualaf? <span style="color: #383444;">*</span>
                                    </label>
                                    <div class="form-check">
                                        <input id="mualaf_ya" type="radio" class="form-check-input" name="mualaf"
                                            value="1" {{ old('mualaf') == '1' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="mualaf_ya">Ya</label>
                                    </div>
                                    <div class="form-check">
                                        <input id="mualaf_tidak" type="radio" class="form-check-input" name="mualaf"
                                            value="0" {{ old('mualaf') == '0' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="mualaf_tidak">Tidak</label>
                                    </div>
                                </div>

                                <div class="form-group" id="group_tarikh_pengislaman" style="display: none;">
                                    <label class="font-weight-700 labelku">Tarikh Pengislaman</label>
                                    <input id="tarikh_pengislaman" type="date" name="tarikh_pengislaman"
                                        class="form-control-lg form-control" value="{{ old('tarikh_pengislaman') }}">
                                </div> --}}

                                <div class="form-group">
                                    <br>
                                    <input type="checkbox" id="checkbox" name="checkbox" value="" required>
                                    &nbsp;&nbsp;Dengan mendaftar, Anda bersetuju dengan
                                    <a href="" data-toggle="modal" data-target="#exampleModal">terma, syarat</a>
                                    dan
                                    <a href="" data-toggle="modal" data-target="#exampleModal">Akta pelindungan
                                        privasi</a>
                                </div>

                                <div id="btnsubmitku" class="text-left">
                                    <input class="site-button button-md outline outline-2 btnku btn btn-md" type="submit"
                                        value="Daftar">
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

    @include('layouts.modals')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script>
        $(function() {
            var queryString = window.location.search;
            var urlParams = new URLSearchParams(queryString);

            var authLevel = $("input[name=auth]").val();
            var isForeign = urlParams.get("is_foreign");
            var code = urlParams.get("code");

            // Dynamic label and placeholder update based on is_foreign parameter
            if (isForeign === "true") {
                $("#title_foreign").html(
                    'Passport <span style="color: #383444;">*</span>'
                );
                $("#no_kad").attr("placeholder", "Passport").attr("type", "text");
            } else {
                $("#title_foreign").html(
                    'No Kad Pengenalan (IC) <span style="color: #383444;">*</span>'
                );
                $("#no_kad").attr("placeholder", "No Kad").attr("type", "number");
            }

            $("#email").val(urlParams.get("email"));
            if (urlParams.get("email")) {
                $("#email").attr("readonly", true).css("background", "#d3d3d35c");
            }

            $("#btnsubmitku").click(function() {
                var password = $("#password").val();
                var confirmPassword = $("#password-confirm").val();
                if (password !== confirmPassword) {
                    alert("Passwords do not match.");
                    return false;
                }
                return true;
            });

            // ===== AJAX Submit Form =====
            $(document).on("submit", ".form-register", function(e) {
                e.preventDefault();
                var e_modal_wait = $("#modalWait");
                showLoading(e_modal_wait);

                var form = $(this);
                var input_token = $("input[name=_token]");
                var isForeignBool = isForeign === "true" ? 1 : 0;

                $.ajax({
                        url: "/register_ahli" + queryString,
                        type: "POST",
                        data: {
                            _token: input_token.val(),
                            email: form.find("input[name=email]").val(),
                            no_kad: form.find("input[name=no_kad]").val(),
                            dial_code: form.find("input[name=dial_code]").val(),
                            nama_penuh: form.find("input[name=nama_penuh]").val(),
                            no_telefon: form.find("input[name=no_telefon]").val(),
                            password: form.find("input[name=password]").val(),
                            is_foreign: isForeignBool,
                            code: code
                        },
                    })
                    .done(function(result) {
                        hideLoading(e_modal_wait);
                        input_token.val(result.newToken);

                        if (result.isSuccess) {
                            swal("Success!", result.message, "success");
                            if (authLevel == 2) {
                                window.location =
                                    "/register_ahli/step_two?registered_by_persatuan=true&ref=" +
                                    result.data;
                            } else {
                                window.location = "/success_register" + queryString;
                            }
                        } else {
                            swal("Warning!", result.message, "warning");
                        }
                    })
                    .fail();
            });
        });
    </script>
@endsection
