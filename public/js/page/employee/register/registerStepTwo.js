$(function() {
    $("#btnsubmitku").on("click", function() {
        // <-- Perbaikan: tambahkan "click"

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
        var current_select = $("#negeri")
            .find(":selected")
            .val();
        tempState.val(current_select);

        triggerSelectBandar(tempState);
        triggerSelectParliament(tempState);
        getCityByState(current_select);
        getParliamentByState(current_select);
    });

    $(document).on("change", "#parliament", function() {
        var current_select = $("#parliament")
            .find(":selected")
            .val();
        tempParliament.val(current_select);

        triggerSelectDun(tempParliament);
        getDunByParliament(current_select);
    });

    $(document).on("submit", ".form-register", function(e) {
        e.preventDefault();

        var queryString = window.location.search;
        var urlParams = new URLSearchParams(queryString);

        var e_modal_wait = $("#modalWait");
        showLoading(e_modal_wait);

        var form = $(this);
        var input_token = $("input[name=_token]");

        // ✅ Perbaikan di sini
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

                    // ✅ Redirect dengan mengekalkan parameter
                    const paramsToKeep = [
                        "daftar_persatuan",
                        "code",
                        "ref",
                        "registered_by_persatuan"
                    ];
                    const newParams = new URLSearchParams();

                    paramsToKeep.forEach(param => {
                        const value = urlParams.get(param);
                        if (value !== null) {
                            newParams.append(param, value);
                        }
                    });

                    const newQueryString = newParams.toString();
                    window.location =
                        "/register_ahli/invoice" +
                        (newQueryString ? "?" + newQueryString : "");
                } else {
                    swal("Warning!", result.message, "warning");
                }
            })
            .fail(function() {
                hideLoading(e_modal_wait);
                swal(
                    "Error!",
                    "Terjadi kesalahan sistem. Sila cuba lagi.",
                    "error"
                );
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
