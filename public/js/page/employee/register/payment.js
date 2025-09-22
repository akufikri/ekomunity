$(function () {


    var queryString = window.location.search;
    var urlParams = new URLSearchParams(queryString);

    // $("#email").val(urlParams.get("email"))
        
    $(document).on('submit', '.form-payment', function(e) {
        e.preventDefault();
        
        var e_modal_wait = $("#modalWait");
        showLoading(e_modal_wait);
        
        if(urlParams.get("daftar_persatuan")) {
            window.location = "/register_ahli/payment_cash"+queryString;
        } else {
            window.location = "/register_ahli/payment_cash";
        }

        

    });
      

    $(document).on('click', '.btn-generate-payment', function(e){
        e.preventDefault();

        var id_user = $(this).data('id') 

        console.log(id_user);
        
        var ini = $(this),  input_token = $('input[name=_token]'),   url = '/create_bill?id_user='+id_user;
        
        var post_data = {
            is_ajax: true,
            _token: input_token.val(),
        };
        
        $.ajax({
            url: url,
            type: "post",
            data: post_data
        })
        .done(function (result) {
            // hideLoading(e_modal_wait);
            input_token.val(result.newToken);
            if (result.httpcode == 200) {
                // var message = result.message || 'Success';
                // infoAlert(message);

                var view = '<div class="form-group">'+
                    '<h6>Success Generate Payment, click link on below to continue !!!</h6>'+
                    '<a href="'+result.response.url+'">'+result.response.url+' target="_blank"</a>'+
                    '</div>'

                $('.content-payment').html(view)

                $('#detailPayment').show()

                window.open(result.response.url, result.response.url);
                // loadThis(params);
                
            } else {
                // var message = result.message || 'Api connection problem';
                // failedAlert(message);
                // loadThis(params);
            }
            input_token.val(result.newToken);
        })
        .fail(ajax_fail);
        
    });
    

    
});