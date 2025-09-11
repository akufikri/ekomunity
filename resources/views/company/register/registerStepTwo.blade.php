@extends('login.template')
@section('title-dashboard', 'Company')
@section('title', 'Register')
@section('content')
    <style>
        .is-invalid .select2-container--default .select2-selection--single {
            border-color: #dc3545;
        }

        .btnku {
            background-color: white !important;
            color: #b91c1c !important;
            border: 2px solid #b91c1c !important;
        }

        .btnku:hover {
            background-color: #b91c1c !important;
            color: white !important;
        }

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
                    <h3 class="font-weight-700 m-t0 m-b20 titleku">Pendaftaran Komuniti</h3>
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
                            <form action="/register_company/step_two_update" method="POST" enctype="multipart/form-data">
                                @csrf
                                <h4 class="font-weight-700 titleku">MAKLUMAT Komuniti</h4>
                                <p class="font-weight-600">Sudah punya akun? <a href="{{ route('login') }}"><b
                                            style="color: #b91c1c;"> Log Masuk</b></a></p>

                                <div class="form-group">
                                    <div>
                                        <label class="font-weight-700 labelku">Logo Komuniti <span
                                                style="color: #b91c1c;">*</span> </label>
                                    </div>
                                    <div class="mb-3">
                                        <img id="image_logo_persatuan" src="/images/upload_image.png" width="100px"
                                            alt="Upload Image">
                                    </div>
                                    <input type="file" id="img_logo_persatuan" name="img_logo_persatuan"
                                        onchange="readURLImageLogoPersatuan(this);" accept="image/*" required>

                                </div>

                                <div class="form-group">
                                    <div>
                                        <label class="font-weight-700 labelku">Sijil Komuniti <span
                                                style="color: #b91c1c;">*</span> </label>
                                    </div>
                                    <div class="mb-3">
                                        <img id="image_sijil_persatuan" src="/images/upload_image.png" width="100px"
                                            alt="Upload Image">
                                    </div>
                                    <input type="file" id="img_sijil_persatuan" name="img_sijil_persatuan"
                                        onchange="readURLImageSijilPersatuan(this);" accept="image/*" required>

                                </div>

                                <div class="array-pegawai-daerah">

                                </div>

                                <div class="form-group">
                                    <label class="font-weight-700 labelku">No. Pendaftaran Komuniti <span
                                            style="color: #b91c1c;">*</span> </label>
                                    <input id="company_registration" type="text"
                                        class="form-control-lg form-control @error('company_registration') is-invalid @enderror"
                                        name="company_registration" value="{{ old('company_registration') }}"
                                        placeholder="No. Pendaftaran Komuniti" autocomplete="company_registration"
                                        autofocus>

                                    @error('company_registration')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-700 labelku">Alamat Perhubungan <span
                                            style="color: #b91c1c;">*</span> </label>
                                    <textarea id="address" type="address" class="form-control-lg form-control @error('address') is-invalid @enderror"
                                        name="address" required autocomplete="address"></textarea>

                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group selectNegeri">
                                    <label class="font-weight-700 labelku">Negeri <span style="color: #b91c1c;">*</span>
                                    </label>
                                    <select class="form-control form-control4 form-control-lg select2" name="state"
                                        id="state" autofocus>
                                        <option selected disabled value="">Pilih Negeri</option>
                                        @foreach ($state as $d)
                                            <option value="{{ $d->id_state }}">{{ $d->state }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-700 labelku">Daerah/Bandar <span
                                            style="color: #b91c1c;">*</span> </label>
                                    <select class="form-control form-control4 form-control-lg select2" name="city"
                                        autofocus>
                                        <option selected disabled value="">Pilih Bandar</option>
                                        @foreach ($city as $d)
                                            <option value="{{ $d->id_city }}">{{ $d->city }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-700 labelku">Poskod <span style="color: #b91c1c;">*</span>
                                    </label>
                                    <input id="postcode" type="number"
                                        class="form-control-lg form-control @error('postcode') is-invalid @enderror"
                                        name="postcode" value="{{ old('postcode') }}" placeholder="Poskod" required
                                        autocomplete="postcode" autofocus>

                                    @error('postcode')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-700 labelku">No. Telefon Komuniti<span
                                            style="color: #b91c1c;">*</span> </label>
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
                                            <input id="phone_office"
                                                style="padding-top: 12px !important; margin-top: 12px !important;"
                                                type="number"
                                                class="form-control-lg form-control @error('phone_office') is-invalid @enderror"
                                                name="phone_office" placeholder ="No. telefon" required
                                                autocomplete="new-password">

                                            @error('phone_office')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-700 labelku">Emel Komuniti<span
                                            style="color: #b91c1c;">*</span> </label>
                                    <input id="email_company" type="email_company"
                                        class="form-control-lg form-control @error('email_company') is-invalid @enderror"
                                        name="email_company" value="{{ old('email_company') }}"
                                        placeholder="Your Email Id" required autocomplete="email_company">

                                    @error('email_company')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-700 labelku">Laman Sesawang </label>
                                    <input id="company_website" type="text"
                                        class="form-control-lg form-control @error('company_website') is-invalid @enderror"
                                        name="company_website" value="{{ old('company_website') }}"
                                        placeholder="Laman Sesawang" autocomplete="company_website" autofocus>

                                    @error('company_website')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="tanggal_lantikan" class="font-weight-700 labelku">Tarikh lantikan</label>
                                    <input class="form-control-lg form-control" type="date" name="tanggal_lantikan"
                                        id="tanggal_lantikan">
                                </div>
                                <div class="form-group">
                                    <label for="tempoh_lantik" class="font-weight-700 labelku">Tempoh Lantikan</label>
                                    <select name="tempoh_lantikan" id="tempoh_lantikan"
                                        class="form-control form-control-lg form-control4">
                                        <option value="1">1 tahun</option>
                                        <option value="2">2 tahun</option>
                                        <option value="3">3 tahun</option>
                                        <option value="4">4 tahun</option>
                                        <option value="5">5 tahun</option>
                                    </select>
                                </div>

                                <h4 class="font-weight-700 titleku">PAUTAN MEDIA SOSIAL</h4>
                                <p class="font-weight-600"><i>*Pautkan link profil media sosial pertubuhan anda</i></p>

                                <div class="row after-add-more">
                                    <div class="col-md-4 pr-0">
                                        <div class="form-group">
                                            <input id="medsos" type="text" class="form-control-lg form-control"
                                                name="medsos[]" placeholder="Media Sosial" autocomplete="" autofocus>
                                        </div>
                                    </div>
                                    <div class="col-md-6 pr-0">
                                        <div class="form-group">
                                            <input id="pautan" type="text" class="form-control-lg form-control"
                                                name="pautan[]" placeholder="Pautan" autocomplete="" autofocus>
                                        </div>
                                    </div>
                                    <div class="col-md-2" style="align-self: center;">
                                        <div class="form-group">
                                            <button class="btn btn-success add-more" type="button">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row copy invisible d-none">
                                    <div class="control-group row">
                                        <div class="col-md-4 pr-0">
                                            <div class="form-group">
                                                <input id="medsos" type="text" class="form-control-lg form-control"
                                                    name="medsos[]" placeholder="Media Sosial" autocomplete="" autofocus>
                                            </div>
                                        </div>
                                        <div class="col-md-6 pr-0">
                                            <div class="form-group">
                                                <input id="pautan" type="text" class="form-control-lg form-control"
                                                    name="pautan[]" placeholder="Pautan" autocomplete="" autofocus>
                                            </div>
                                        </div>
                                        <div class="col-md-2" style="align-self: center;">
                                            <div class="form-group">
                                                <button class="btn btn-danger remove" type="button"><i
                                                        class="fa fa-remove"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div id="btnsubmitku" class="text-left">
                                    <button class="site-button button-md outline outline-2 btnku btn btn-md"
                                        type="submit">Simpan</button>
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
    <script type="text/javascript" src="/js/my-custom.js"></script>
    <script type="text/javascript">
        $(function() {
            $('.select2').select2();

            $("#btnsubmitku").click(function() {
                console.log('tes')

                var pd = $('.pd-multiple');
                var state = $('select[name=state]');
                var city = $('select[name=city]');
                var dial_code = $('select[name=dial_code]');

                if (pd.val().length === 0) {
                    alert('Pihak Berkuasa Tempatan wajib dipilih!')
                } else if (state.val() == null) {
                    alert('Negeri wajib dipilih!')
                } else if (city.val() == null) {
                    alert('Bandar wajib dipilih!')
                } else if (dial_code.val() == null) {
                    alert('Dial Code wajib dipilih!')
                }
            });
        });

        function readURLImageLogoPersatuan(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#image_logo_persatuan').attr('src', e.target.result).width(100).height(74);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURLImageSijilPersatuan(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#image_sijil_persatuan').attr('src', e.target.result).width(100).height(74);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
