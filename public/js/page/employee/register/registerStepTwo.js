$(document).ready(function () {
    $("#btnsubmitku").on("click", function () {
        const negeri = $("select[name=negeri]").val();
        if (!negeri) {
            alert("Negeri wajib dipilih.");
            return false;
        }

        const bandar = $("select[name=bandar]").val();
        if (!bandar) {
            alert("Bandar wajib dipilih.");
            return false;
        }

        return true;
    });

    $(".select2").select2();

    const tempState = $("#temp_id_state");
    const tempParliament = $("#temp_id_parliament");

    triggerSelectBandar(tempState);
    triggerSelectParliament(tempState);
    triggerSelectDun(tempParliament);

    $(document).on("change", "#negeri", function () {
        const selectedState = $(this).val();
        tempState.val(selectedState);

        triggerSelectBandar(tempState);
        triggerSelectParliament(tempState);

        getCityByState(selectedState);
        getParliamentByState(selectedState);
    });

    $(document).on("change", "#parliament", function () {
        const selectedParliament = $(this).val();
        tempParliament.val(selectedParliament);

        triggerSelectDun(tempParliament);
        getDunByParliament(selectedParliament);
    });

    $(document).on("submit", ".form-register", function (e) {
        e.preventDefault();

        const urlParams = new URLSearchParams(window.location.search);
        const modalWait = $("#modalWait");
        showLoading(modalWait);

        const form = $(this);
        const token = $("input[name=_token]");

        const registered_by_persatuan =
            urlParams.get("daftar_persatuan") ||
            urlParams.get("registered_by_persatuan") ||
            "";

        const ref =
            urlParams.get("code") ||
            urlParams.get("ref") ||
            "";

        $.ajax({
            url: "/register_ahli/step_two_update",
            type: "POST",
            data: {
                _token: token.val(),
                address: form.find("textarea[name=alamat_perhubungan]").val(),
                negeri: form.find("select[name=negeri]").val(),
                bandar: form.find("select[name=bandar]").val(),
                parliament: form.find("select[name=parliament]").val(),
                dun: form.find("select[name=dun]").val(),
                poskod: form.find("input[name=poskod]").val(),
                registered_by_persatuan,
                ref
            }
        })
        .done(function (result) {
            hideLoading(modalWait);
            token.val(result.newToken);

            if (result.isSuccess) {
                swal("Success!", result.message, "success");

                const paramsToKeep = [
                    "daftar_persatuan",
                    "code",
                    "ref",
                    "registered_by_persatuan"
                ];

                const newParams = new URLSearchParams();
                paramsToKeep.forEach(param => {
                    const value = urlParams.get(param);
                    if (value) newParams.append(param, value);
                });

                const finalUrl = "/register_ahli/invoice" + 
                    (newParams.toString() ? "?" + newParams.toString() : "");

                console.log("[DEBUG] Redirecting to:", finalUrl);
                console.log("[DEBUG] Parameters carried over:", Object.fromEntries(newParams.entries()));

                // window.location.href = finalUrl;
            } else {
                swal("Warning!", result.message, "warning");
            }
        })
        .fail(function (xhr, status, error) {
            hideLoading(modalWait);
            console.error("[ERROR] AJAX Failed:", error);
            swal("Error!", "Terjadi kesalahan sistem. Sila cuba lagi.", "error");
        });
    });
});

function triggerSelectBandar(state) {
    toggleSelect(state, "bandar");
}

function triggerSelectParliament(state) {
    toggleSelect(state, "parliament");
}

function triggerSelectDun(parliament) {
    toggleSelect(parliament, "dun");
}

function toggleSelect(input, selectName) {
    const select = $(`select[name=${selectName}]`);
    if (!input.val()) {
        select.attr("disabled", true).css("background", "#d3d3d35c");
    } else {
        select.removeAttr("disabled").css("background", "#f9faff");
    }
}

function getCityByState(id) {
    $.get("/getCity", { id_state: id })
        .done(function (result) {
            const select = $("#bandar").empty();
            appendDefaultOption(select, "Pilih Bandar");

            result.forEach(item => {
                select.append(new Option(item.city, item.id_city));
            });
        })
        .fail(() => console.error("Gagal memuat bandar."));
}

function getParliamentByState(id) {
    $.get("/getParliament", { id_state: id })
        .done(function (result) {
            const select = $("#parliament").empty();
            appendDefaultOption(select, "Pilih Parlimen");

            result.forEach(item => {
                select.append(new Option(item.parliament, item.id));
            });
        })
        .fail(() => console.error("Gagal memuat parlimen."));
}

function getDunByParliament(id) {
    $.get("/getDun", { id_parliament: id })
        .done(function (result) {
            const select = $("#dun").empty();
            appendDefaultOption(select, "Pilih DUN");

            result.forEach(item => {
                select.append(new Option(item.dun, item.id));
            });
        })
        .fail(() => console.error("Gagal memuat DUN."));
}

function appendDefaultOption(select, text) {
    select.append(new Option(text, "", true, true)).prop("disabled", true);
}

function readURL(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            $("#image")
                .attr("src", e.target.result)
                .width(100)
                .height(74);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
