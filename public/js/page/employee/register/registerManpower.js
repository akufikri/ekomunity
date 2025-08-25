$(function () {
    var queryString = window.location.search;
    var urlParams = new URLSearchParams(queryString);

    var authLevel = $("input[name=auth]").val();
    var isForeign = urlParams.get("is_foreign");

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

    $("#btnsubmitku").click(function () {
        var password = $("#password").val();
        var confirmPassword = $("#password-confirm").val();
        if (password !== confirmPassword) {
            alert("Passwords do not match.");
            return false;
        }
        return true;
    });

    // ===== Fungsi show/hide Tarikh Pengislaman =====
    function toggleTarikhPengislaman() {
        if ($("#mualaf_ya").is(":checked")) {
            $("#group_tarikh_pengislaman").show();
            $("#tarikh_pengislaman").attr("required", true);
        } else {
            $("#group_tarikh_pengislaman").hide();
            $("#tarikh_pengislaman").attr("required", false);
            $("#tarikh_pengislaman").val("");
        }
    }
    toggleTarikhPengislaman();
    $('input[name="mualaf"]').change(toggleTarikhPengislaman);

    // ===== AJAX Submit Form =====
    $(document).on("submit", ".form-register", function (e) {
        e.preventDefault();
        var e_modal_wait = $("#modalWait");
        showLoading(e_modal_wait);

        var form = $(this);
        var input_token = $("input[name=_token]");
        var isForeignBool = isForeign === "true" ? 1 : 0;

        // Ambil value mualaf dan tarikh_pengislaman
        var mualafVal = $('input[name="mualaf"]:checked').val() || 0;
        var tarikhPengislamanVal = $("#tarikh_pengislaman").val() || null;

        $.ajax({
            url: "/register_ahli" + queryString,
            type: "POST",
            data: {
                _token: input_token.val(),
                id_cawangan: form.find("select[name=id_cawangan]").val(),
                nama_pencadang: form.find("input[name=nama_pencadang]").val(),
                nama_peyokong: form.find("input[name=nama_peyokong]").val(),
                email: form.find("input[name=email]").val(),
                no_kad: form.find("input[name=no_kad]").val(),
                dial_code: form.find("input[name=dial_code]").val(),
                nama_penuh: form.find("input[name=nama_penuh]").val(),
                no_telefon: form.find("input[name=no_telefon]").val(),
                password: form.find("input[name=password]").val(),
                is_foreign: isForeignBool,
                mualaf: mualafVal, // tambahkan field baru
                tarikh_pengislaman: tarikhPengislamanVal, // tambahkan field baru
            },
        })
            .done(function (result) {
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
    $("#bahagian_wrapper").hide();
    $(document).on("change", "#id_cawangan", function () {
        var idCawangan = $(this).val();

        if (idCawangan && idCawangan !== "--- Pilih Cawangan ---") {
            $.ajax({
                url: "/get_bahagian_with_ketua/" + idCawangan,
                type: "GET",
                success: function (res) {
                    if (res.success && res.data) {
                        $("#bahagian_display").val(
                            res.data.bahagian +
                                " / " +
                                res.data.name_ketua_bahagian
                        );

                        // tampilkan wrapper
                        $("#bahagian_wrapper").show();
                    } else {
                        $("#bahagian_display").val("N/A");
                        $("#bahagian_wrapper").show(); // tetap tampilkan, isi N/A
                    }
                },
                error: function () {
                    $("#bahagian_display").val("N/A");
                    $("#bahagian_wrapper").show();
                },
            });
        } else {
            // kalau user reset pilihan, sembunyikan lagi
            $("#bahagian_wrapper").hide();
            $("#bahagian_display").val("");
        }
    });

    // Inisialisasi Select2 untuk kedua dropdown
    $("#id_bahagian").select2({
        placeholder: "--- Pilih Bahagian ---",
        allowClear: true,
        width: "100%",
    });

    $("#id_cawangan").select2({
        placeholder: "--- Pilih Cawangan ---",
        allowClear: true,
        width: "100%",
    });

    $(document).on("change", "#id_bahagian", function () {
        var idBahagian = $(this).val();

        // Reset dropdown cawangan dengan cara yang benar untuk Select2
        $("#id_cawangan")
            .empty()
            .append('<option value="">--- Pilih Cawangan ---</option>');
        $("#id_cawangan").select2("val", ""); // Reset nilai Select2

        if (idBahagian) {
            $.ajax({
                url: "/get-cawangan/" + idBahagian,
                type: "GET",
                success: function (res) {
                    console.log("Response:", res); // Untuk debugging

                    if (res.success && res.data && res.data.length > 0) {
                        $.each(res.data, function (i, item) {
                            // Perbaikan: gunakan data yang tersedia dan handle null values
                            var kodCawangan = item.user.kod_cawangan || "N/A";
                            var namaUser = item.user.fullname || "-";
                            var companyName = item.full_company_name || "-";

                            // Tambah opsi dengan format yang lebih informatif
                            $("#id_cawangan").append(
                                `<option value="${item.user.id}">
                                (${kodCawangan}) ${namaUser} - ${companyName}
                            </option>`
                            );
                        });

                        // Refresh Select2 setelah menambah opsi
                        $("#id_cawangan").trigger("change");
                    } else {
                        $("#id_cawangan").append(
                            '<option value="">Tiada Cawangan</option>'
                        );
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", error);
                    console.log("Response:", xhr.responseText);
                    alert("Gagal memuat cawangan. Error: " + error);
                },
            });
        }
    });
});
