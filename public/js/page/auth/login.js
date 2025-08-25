$(document).ready(function() {

    const queryString = window.location.search;
    console.log(queryString);

    const urlParams = new URLSearchParams(queryString);


    $("input[name=param]").val(queryString);

    $(document).on('submit', '.form-login', function(e) {
        e.preventDefault();

        var e_modal_wait = $("#modalWait");
        showLoading(e_modal_wait);

        var form = $(this)
        var input_token = $('input[name=_token]')
        var fcm_token = $('input[name=fcm_token]')


        $.ajax({
            url: "/auth_login",
            type: "POST",
            data: {
                _token: input_token.val(),
                email: form.find('input[name=email]').val(),
                password: form.find('input[name=password]').val(),
                fcm_token: fcm_token.val(),
            },
        }).done(function (result) {

            hideLoading(e_modal_wait);

            input_token.val(result.newToken)

            if(result.isSuccess) {

                swal(
                    'Success!',
                    result.message,
                    'success'
                )

                var id_level = result.data.id_level;

                if(id_level == "1" || id_level == "4" || id_level == "5" || id_level == "6" || id_level == "7") {
                    window.location = "/home";
                }
                if(id_level == "2"){
                    window.location = "/homeCompany";
                }

                if(id_level == "3"){

                    if(urlParams.get('daftar_persatuan')) {
                        window.location = "/daftar_persatuan/"+urlParams.get('code');
                    } else {
                        window.location = "/homeManPower";
                    }

                }

            } else {
                swal(
                    'Failed!',
                    result.message,
                    'error'
                )
            }

        }).fail();

    });

})
