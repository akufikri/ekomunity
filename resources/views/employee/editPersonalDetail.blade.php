@extends('home')
@section('title-dashboard', 'Ahli')
@section('title', 'Edit Maklumat Peribadi')

@section('breadcrumb')
    <?php $user = Auth::user()->id; ?>
    <li class="breadcrumb-item active"><a href="/personalDetail/{{ $user }}">Maklumat Pribadi</a></li>
    <li class="breadcrumb-item active">Edit</li>

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

        .my-table {
            font-size: 14px;
            margin-bottom: 0px;
        }

        input[type="text"] {
            font-size: 13px;
        }

        input[type="number"] {
            font-size: 13px;
        }

        .labelku {
            font-size: 15px;
        }
    </style>

    <div class="card card-danger card-outline" style="border-top: 3px solid dark">
        <div class="card-header">
            <h3 class="text-danger my-header">Edit Maklumat Peribadi</h3>
        </div>
        <div class="card-body">
            <form action="{{ URL::to('personalDetail/update/' . $data->id . '') }}" method="POST"
                enctype="multipart/form-data">
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
                    <div class="col-md-12">
                        <div class="form-group">
                            <div>
                                <label class="font-weight-700 labelku">Gambar Profile </label>
                            </div>
                            <div class="mb-3">
                                <img id="image" src="/Profil/{{ $data->photo }}" width="100px" alt="Upload Image">
                            </div>
                            <input type="file" id="img" name="img" onchange="readURL(this);" accept="image/*">

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Nama Penuh</label>
                            <input type="text" value="{{ isset($data->fullname) ? $data->fullname : '' }}"
                                class="form-control form-control-lg" placeholder="" name="fullname" required autofocus>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Nomor Telefon</label>
                            <input type="text" value="{{ isset($data->phone_number) ? $data->phone_number : '' }}"
                                class="form-control form-control-lg" placeholder="" name="phone_number" required autofocus>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Emel</label>
                            <input type="text" value="{{ isset($data->email) ? $data->email : '' }}"
                                class="form-control form-control-lg" placeholder="" name="email" required autofocus>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-700 labelku">No Kad Pengenalan</label>
                            <input type="text"
                                value="{{ isset($data->manpower->ic_number) ? $data->manpower->ic_number : '' }}"
                                class="form-control form-control-lg" placeholder="" name="ic_number" required autofocus>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Bangsa</label>
                            <select name="nation" value='{{ $data->manpower->id_agama }}'
                                class="form-control form-control-lg1" required autofocus>
                                <option disabled selected>Pilih Bangsa</option>
                                @foreach ($nation as $d)
                                    <option value="{{ $d->id_nation }}"
                                        {{ $data->manpower->id_nation == $d->id_nation ? 'selected' : '' }}>
                                        {{ $d->nation }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Agama</label>
                            <select name="religion" value='{{ $data->manpower->id_agama }}'
                                class="form-control form-control-lg1" required autofocus>
                                <option disabled selected>Pilih Agama</option>
                                @foreach ($religion as $d)
                                    <option value="{{ $d->id_religion }}"
                                        {{ $data->manpower->id_agama == $d->id_religion ? 'selected' : '' }}>
                                        {{ $d->religion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Status Bumiputera</label>
                            <select class="form-control form-control-lg1" name="native_status"
                                value="{{ $data->manpower->native_status }}" required autofocus>
                                <option selected disabled selected>Pilih Status Bumiputera</option>
                                @foreach ($status_native as $d)
                                    <option value="{{ $d->id_status_native }}"
                                        {{ $data->manpower->native_status == $d->id_status_native ? 'selected' : '' }}>
                                        {{ $d->status_native }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Jantina</label>
                            <select name="gender" value='{{ $data->manpower->gender }}'
                                class="form-control form-control-lg1" required autofocus>
                                <option disabled selected>Pilih Jantina</option>
                                @foreach ($gender as $d)
                                    <option value="{{ $d->id_gender }}"
                                        {{ $data->manpower->gender == $d->id_gender ? 'selected' : '' }}>
                                        {{ $d->gender }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Status</label>
                            <select name="marital_status" value='{{ $data->manpower->marital_status }}'
                                class="form-control form-control-lg1" required autofocus>
                                <option disabled selected>Pilih Status</option>
                                @foreach ($marital_status as $d)
                                    <option value="{{ $d->id_marital_status }}"
                                        {{ $data->manpower->marital_status == $d->id_marital_status ? 'selected' : '' }}>
                                        {{ $d->marital_status }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Negeri</label>
                            <input type="hidden" name="temp_id_state" value="{{ $data->manpower->id_state }}"
                                id="temp_id_state">
                            <select name="id_state" id="id_state" value='{{ $data->manpower->id_state }}'
                                class="form-control form-control-lg1" required autofocus>
                                <option disabled selected>Pilih Negeri</option>
                                @foreach ($state as $d)
                                    <option value="{{ $d->id_state }}"
                                        {{ $data->manpower->id_state == $d->id_state ? 'selected' : '' }}>
                                        {{ $d->state }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Daerah/Bandar</label>
                            <input type="hidden" name="temp_id_city" id="temp_id_city"
                                value="{{ $data->manpower->id_city }}">
                            <select name="id_city" id="id_city" class="form-control form-control-lg1" required
                                autofocus>
                                <option disabled selected>Pilih Daerah</option>
                                @foreach ($city as $d)
                                    <option value="{{ $d->id_city }}">{{ $d->city }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Poskod</label>
                            <input type="text"
                                value="{{ isset($data->manpower->postcode) ? $data->manpower->postcode : '' }}"
                                class="form-control form-control-lg" placeholder="" name="postcode" required autofocus>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Parlimen</label>
                            <input type="hidden" name="temp_id_parliament" id="temp_id_parliament"
                                value="{{ $data->manpower->id_parliament }}">
                            <select name="parliament" id="parliament" class="form-control form-control-lg1" required
                                autofocus>
                                <option disabled selected>Pilih Parlimen</option>
                                @foreach ($parliament as $d)
                                    <option value="{{ $d->id }}">{{ $d->parliament }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-700 labelku">DUN</label>
                            <input type="hidden" name="temp_id_dun" id="temp_id_dun"
                                value="{{ $data->manpower->id_dun }}">
                            <select name="dun" id="dun" class="form-control form-control-lg1" required
                                autofocus>
                                <option disabled selected>Pilih DUN</option>
                                @foreach ($dun as $d)
                                    <option value="{{ $d->id }}">{{ $d->dun }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Alamat Perhubungan</label>
                            <input type="text"
                                value="{{ isset($data->manpower->address) ? $data->manpower->address : '' }}"
                                class="form-control form-control-lg" placeholder="" name="address" required autofocus>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Cawangan</label>
                            <select name="id_cawangan" class="form-control">
                                <option selected disabled>Pilih cawangan</option>
                                @foreach ($cawangan as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $data->manpower->id_cawangan == $item->id ? 'selected' : '' }}>
                                        {{ $item->fullname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Nama pencadang</label>
                            <input type="text"
                                value="{{ isset($data->manpower->nama_pencadang) ? $data->manpower->nama_pencadang : '' }}"
                                class="form-control form-control-lg" placeholder="" name="nama_pencadang" required
                                autofocus>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Nama peyokong</label>
                            <input type="text"
                                value="{{ isset($data->manpower->nama_peyokong) ? $data->manpower->nama_peyokong : '' }}"
                                class="form-control form-control-lg" placeholder="" name="nama_peyokong" required
                                autofocus>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Status Mualaf</label>
                            <select name="mualaf" id="mualaf_select" class="form-control form-control-lg" required>
                                <option value="">-- Pilih --</option>
                                <option value="1"
                                    {{ isset($data->manpower->is_mualaf) && $data->manpower->is_mualaf == 1 ? 'selected' : '' }}>
                                    Ya</option>
                                <option value="0"
                                    {{ isset($data->manpower->is_mualaf) && $data->manpower->is_mualaf == 0 ? 'selected' : '' }}>
                                    Tidak</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group" id="group_tarikh_pengislaman"
                            style="{{ isset($data->manpower->is_mualaf) && $data->manpower->is_mualaf == 1 ? '' : 'display:none;' }}">
                            <label class="font-weight-700 labelku">Tarikh Pengislaman</label>
                            <input type="date" name="tarikh_pengislaman"
                                value="{{ isset($data->manpower->tarikh_pengislaman) ? $data->manpower->tarikh_pengislaman : '' }}"
                                class="form-control form-control-lg">
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Pautan Instagram</label>
                            <input type="text"
                                value="{{ isset($data->manpower->business_instagram) ? $data->manpower->business_instagram : '' }}"
                                class="form-control form-control-lg" placeholder="" name="business_instagram" autofocus>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Pautan Facebook</label>
                            <input type="text"
                                value="{{ isset($data->manpower->business_facebook) ? $data->manpower->business_facebook : '' }}"
                                class="form-control form-control-lg" placeholder="" name="business_facebook" autofocus>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Pautan Tiktok</label>
                            <input type="text"
                                value="{{ isset($data->manpower->business_tiktok) ? $data->manpower->business_tiktok : '' }}"
                                class="form-control form-control-lg" placeholder="" name="business_tiktok" autofocus>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Pautan Youtube</label>
                            <input type="text"
                                value="{{ isset($data->manpower->business_youtube) ? $data->manpower->business_youtube : '' }}"
                                class="form-control form-control-lg" placeholder="" name="business_youtube" autofocus>
                        </div>
                    </div>


                </div>
                <div class="card-footer">
                    <a href="/personalDetail/{{ $user }}" title="Back"
                        class="btn btn-md btn-danger my-button">Cancel</a>
                    <input type="submit" value="Save" title="Save" class="btn btn-md btn-success">
                </div>
            </form>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <script>
        $(function() {

            <?php
            $city_id = $data->manpower->id_city ?? '';
            echo "var city_id = '$city_id';";
            
            $city_name = isset($data->manpower->city->city) ? $data->manpower->city->city : '';
            echo "var city_name = '$city_name';";
            
            $parliament = $data->manpower->id_parliament ?? '';
            echo "var parliament = '$parliament';";
            
            $dun = $data->manpower->id_dun ?? '';
            echo "var dun = '$dun';";
            ?>

            var tempState = $("#temp_id_state");
            var tempCity = $("#temp_id_city");
            var tempParliament = $("#temp_id_parliament");
            var tempDun = $("#temp_id_dun");

            // Trigger city select berdasarkan state
            triggerSelectBandar(tempState);

            // Set event change untuk state
            $(document).on('change', '#id_state', function() {
                var current_select = $(this).val();
                tempState.val(current_select);

                triggerSelectBandar(tempState);
                getCityByState(current_select);
                getParliamentByState(current_select);
            });

            // Event change untuk parliament
            $(document).on('change', '#parliament', function() {
                var current_select = $(this).val();
                tempParliament.val(current_select);

                getDunByParliament(current_select);
            });

            // ===== Functions =====
            function triggerSelectBandar(param) {
                if (param.val() === "") {
                    $("select[name=id_city]").prop('disabled', true).css("background", "#d3d3d35c");
                } else {
                    $("select[name=id_city]").prop('disabled', false).css("background", "#f9faff");
                }
            }

            function getCityByState(id) {
                $.ajax({
                        url: '/getCity',
                        type: "GET",
                        data: {
                            id_state: id
                        },
                    })
                    .done(function(result) {
                        var selectbandar = $("#id_city");
                        selectbandar.empty();
                        selectbandar.append($('<option value="">Pilih Bandar</option>'));

                        $(result).each(function() {
                            var option = $('<option></option>').val(this.id_city).text(this.city);
                            selectbandar.append(option);
                        });

                        // Set value city jika ada sebelumnya
                        if (city_id) selectbandar.val(city_id);
                    });
            }

            function getParliamentByState(id) {
                $.ajax({
                        url: '/getParliament',
                        type: "GET",
                        data: {
                            id_state: id
                        },
                    })
                    .done(function(result) {
                        var selectparliament = $("#parliament");
                        selectparliament.empty();
                        selectparliament.append($('<option value="">Pilih Parlimen</option>'));

                        $(result).each(function() {
                            var option = $('<option></option>').val(this.id).text(this.parliament);
                            selectparliament.append(option);
                        });

                        // Set value parliament jika ada sebelumnya
                        if (parliament) selectparliament.val(parliament);
                        // Load DUN berdasarkan parliament
                        if (parliament) getDunByParliament(parliament);
                    });
            }

            function getDunByParliament(id) {
                $.ajax({
                        url: '/getDun',
                        type: "GET",
                        data: {
                            id_parliament: id
                        },
                    })
                    .done(function(result) {
                        var selectdun = $("#dun");
                        selectdun.empty();
                        selectdun.append($('<option value="">Pilih DUN</option>'));

                        $(result).each(function() {
                            var option = $('<option></option>').val(this.id).text(this.dun);
                            selectdun.append(option);
                        });

                        // Set value DUN jika ada sebelumnya
                        if (dun) selectdun.val(dun);
                    });
            }

            // ===== Load initial city, parliament, dun jika ada state =====
            if (tempState.val()) {
                getCityByState(tempState.val());
                getParliamentByState(tempState.val());
            }

            function toggleTarikhPengislaman() {
                var mualafVal = $('#mualaf_select').val();
                if (mualafVal === '1') {
                    $('#group_tarikh_pengislaman').show();
                    $('#group_tarikh_pengislaman input[name="tarikh_pengislaman"]').attr('required', true);
                } else {
                    $('#group_tarikh_pengislaman').hide();
                    $('#group_tarikh_pengislaman input[name="tarikh_pengislaman"]').attr('required', false).val('');
                }
            }

            // Panggil saat load page agar sesuai dengan value tersimpan
            toggleTarikhPengislaman();

            // Event listener ketika select berubah
            $('#mualaf_select').change(function() {
                toggleTarikhPengislaman();
            });

        });
    </script>

@endsection
