@extends('login.template')
@section('title-dashboard', 'Ahli')
@section('title', 'Register')
@section('content')
    <style>
        .btnku {
            background-color: white !important;
            color: #b91c1c !important;
            border: 2px solid #b91c1c !important;
        }

        .btnku:hover {
            background-color: #b91c1c !important;
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
            padding: 0px 0px 0px 0px;
            margin: 0px 0px 0px 0px;
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
                    <h3 class="font-weight-700 m-t0 m-b20 titleku">Pendaftaran Peribadi</h3>
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
                            <form action="" class="form-register" method="POST" enctype="multipart/form-data">
                                @csrf
                                <h4 class="font-weight-700 titleku">Samb. MAKLUMAT PERIBADI</h4>

                                <div class="form-group">
                                    <label class="font-weight-700 labelku">Alamat Perhubungan </label>
                                    <textarea id="alamat_perhubungan" type="alamat_perhubungan"
                                        class="form-control-lg form-control @error('alamat_perhubungan') is-invalid @enderror" name="alamat_perhubungan"
                                        autocomplete="alamat_perhubungan"></textarea>

                                    @error('alamat_perhubungan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group selectNegeri">
                                    <label class="font-weight-700 labelku">Negeri <span style="color: #b91c1c;">*</span>
                                    </label>
                                    <input type="hidden" name="temp_id_state" id="temp_id_state">
                                    <select class="form-control form-control4 form-control-lg select2" name="negeri"
                                        id="negeri" autofocus required>
                                        <option selected disabled value="">Pilih Negeri</option>
                                        @foreach ($state as $d)
                                            <option value="{{ $d->id_state }}">{{ $d->state }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-700 labelku">Daerah/Bandar <span
                                            style="color: #b91c1c;">*</span> </label>
                                    <select class="form-control form-control4 form-control-lg select2" name="bandar"
                                        id="bandar" autofocus required>
                                        <option selected disabled value="">Pilih Bandar</option>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <input type="hidden" name="temp_id_parliament" id="temp_id_parliament">
                                    <label class="font-weight-700 labelku">Parlimen <span style="color: #b91c1c;">*</span>
                                    </label>
                                    <select class="form-control form-control4 form-control-lg select2" name="parliament"
                                        id="parliament" autofocus required>
                                        <option selected disabled value="">Pilih Parlimen</option>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-700 labelku">DUN <span style="color: #b91c1c;">*</span>
                                    </label>
                                    <select class="form-control form-control4 form-control-lg select2" name="dun"
                                        id="dun" autofocus required>
                                        <option selected disabled value="">Pilih DUN</option>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-700 labelku">Poskod </label>
                                    <input id="poskod" type="number"
                                        class="form-control-lg form-control @error('poskod') is-invalid @enderror"
                                        name="poskod" value="{{ old('poskod') }}" placeholder="Poskod"
                                        autocomplete="poskod" autofocus>

                                    @error('poskod')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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

    @include('layouts.modals')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    {{-- <script type="text/javascript" src="{{ asset('js/page/employee/register/registerStepTwo.js') }}"></script> --}}
    <script>
        $(function() {

            $("#btnsubmitku").on("click", function() {
                var negeri = $("select[name=negeri]").val();
                if (negeri == null) {
                    alert("Negeri wajib dipilih.");
                    return false;
                }

                var bandar = $("select[name=bandar]").val();
                if (bandar == null) {
                    alert("Bandar wajib dipilih.");
                    return false;
                }

                return true;
            });

            $(".select2").select2();

            var tempState = $("#temp_id_state");
            var tempParliament = $("#temp_id_parliament");
            triggerSelectBandar(tempState);
            triggerSelectParliament(tempState);
            triggerSelectDun(tempParliament);

            $(document).on("change", "#negeri", function() {
                var current_select = $("#negeri").find(":selected").val();
                tempState.val(current_select);

                triggerSelectBandar(tempState);
                triggerSelectParliament(tempState);
                getCityByState(current_select);
                getParliamentByState(current_select);
            });

            $(document).on("change", "#parliament", function() {
                var current_select = $("#parliament").find(":selected").val();
                tempParliament.val(current_select);

                triggerSelectDun(tempParliament);
                getDunByParliament(current_select);
            });

            $(document).on("submit", ".form-register", function(e) {
                e.preventDefault();

                var queryString = window.location.search;
                var urlParams = new URLSearchParams(queryString);

                // Debug: Lihat apa parameter yang ada di URL sekarang
                console.log("[DEBUG] Current URL parameters:", Object.fromEntries(urlParams.entries()));

                var e_modal_wait = $("#modalWait");
                showLoading(e_modal_wait);

                var form = $(this);
                var input_token = $("input[name=_token]");

                // ✅ Ambil parameter dengan betul
                var registered_by_persatuan =
                    urlParams.get("daftar_persatuan") ||
                    urlParams.get("registered_by_persatuan") ||
                    "";
                var ref = urlParams.get("code") || urlParams.get("ref") || "";

                $.ajax({
                        url: "/register_ahli/step_two_update",
                        type: "POST",
                        data: {
                            _token: input_token.val(),
                            address: form.find("textarea[name=alamat_perhubungan]").val(),
                            negeri: form.find("select[name=negeri]").val(),
                            bandar: form.find("select[name=bandar]").val(),
                            parliament: form.find("select[name=parliament]").val(),
                            dun: form.find("select[name=dun]").val(),
                            poskod: form.find("input[name=poskod]").val(),
                            registered_by_persatuan: registered_by_persatuan,
                            ref: ref
                        }
                    })
                    .done(function(result) {
                        hideLoading(e_modal_wait);
                        input_token.val(result.newToken);

                        if (result.isSuccess) {
                            swal("Success!", result.message, "success");

                            // ✅ Senarai parameter yang ingin dikekalkan
                            const paramsToKeep = [
                                "daftar_persatuan",
                                "code",
                                "ref",
                                "registered_by_persatuan"
                            ];
                            const newParams = new URLSearchParams();

                            // ✅ Kumpulkan semula parameter
                            paramsToKeep.forEach(param => {
                                const value = urlParams.get(param);
                                if (value !== null && value !== "") {
                                    newParams.append(param, value);
                                }
                            });

                            // ✅ Bina URL
                            const newQueryString = newParams.toString();
                            const finalUrl = "/register_ahli/invoice" + (newQueryString ? "?" + newQueryString : "");

                            // ✅ DEBUG: Log URL akhir
                            console.log("[DEBUG] Redirecting to:", finalUrl);
                            console.log("[DEBUG] Parameters carried over:", Object.fromEntries(newParams
                                .entries()));

                            // ✅ Redirect dengan .href — LEBIH SELAMAT
                            window.location.href = finalUrl;

                        } else {
                            swal("Warning!", result.message, "warning");
                        }
                    })
                    .fail(function(xhr, status, error) {
                        hideLoading(e_modal_wait);
                        console.error("[ERROR] AJAX Failed:", error);
                        swal("Error!", "Terjadi kesalahan sistem. Sila cuba lagi.", "error");
                    });
            });
        });

        // Fungsi-fungsi helper

        function triggerSelectBandar(param) {
            if (param.val() == "") {
                $("select[name=bandar]")
                    .attr("disabled", "true")
                    .css("background", "#d3d3d35c");
            } else {
                $("select[name=bandar]")
                    .removeAttr("disabled")
                    .css("background", "#f9faff");
            }
        }

        function triggerSelectParliament(param) {
            if (param.val() == "") {
                $("select[name=parliament]")
                    .attr("disabled", "true")
                    .css("background", "#d3d3d35c");
            } else {
                $("select[name=parliament]")
                    .removeAttr("disabled")
                    .css("background", "#f9faff");
            }
        }

        function triggerSelectDun(param) {
            if (param.val() == "") {
                $("select[name=dun]")
                    .attr("disabled", "true")
                    .css("background", "#d3d3d35c");
            } else {
                $("select[name=dun]")
                    .removeAttr("disabled")
                    .css("background", "#f9faff");
            }
        }

        function getCityByState(id) {
            $.ajax({
                    url: "/getCity",
                    type: "GET",
                    data: {
                        id_state: id
                    }
                })
                .done(function(result) {
                    var selectbandar = $("#bandar");
                    selectbandar.empty();

                    var optionDefault = $("<option />")
                        .html("Pilih Bandar")
                        .attr("disabled", true)
                        .attr("selected", "selected");
                    selectbandar.append(optionDefault);

                    $(result).each(function() {
                        var option = $("<option />")
                            .html(this.city)
                            .val(this.id_city);
                        selectbandar.append(option);
                    });
                })
                .fail(function() {
                    console.error("Gagal memuat bandar.");
                });
        }

        function getParliamentByState(id) {
            $.ajax({
                    url: "/getParliament",
                    type: "GET",
                    data: {
                        id_state: id
                    }
                })
                .done(function(result) {
                    var selectparliament = $("#parliament");
                    selectparliament.empty();

                    var optionDefault = $("<option />")
                        .html("Pilih Parlimen")
                        .attr("disabled", true)
                        .attr("selected", "selected");
                    selectparliament.append(optionDefault);

                    $(result).each(function() {
                        var option = $("<option />")
                            .html(this.parliament)
                            .val(this.id);
                        selectparliament.append(option);
                    });
                })
                .fail(function() {
                    console.error("Gagal memuat parlimen.");
                });
        }

        function getDunByParliament(id) {
            $.ajax({
                    url: "/getDun",
                    type: "GET",
                    data: {
                        id_parliament: id
                    }
                })
                .done(function(result) {
                    var selectdun = $("#dun");
                    selectdun.empty();

                    var optionDefault = $("<option />")
                        .html("Pilih DUN")
                        .attr("disabled", true)
                        .attr("selected", "selected");
                    selectdun.append(optionDefault);

                    $(result).each(function() {
                        var option = $("<option />")
                            .html(this.dun)
                            .val(this.id);
                        selectdun.append(option);
                    });
                })
                .fail(function() {
                    console.error("Gagal memuat DUN.");
                });
        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $("#image")
                        .attr("src", e.target.result)
                        .width(100)
                        .height(74);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
