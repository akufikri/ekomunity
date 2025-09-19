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

    // ===== AJAX Submit Form =====
    $(document).on("submit", ".form-register", function (e) {
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
                is_foreign: isForeignBool
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
});
