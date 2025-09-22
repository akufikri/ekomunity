$(function () {

    var queryString = window.location.search;
    var urlParams = new URLSearchParams(queryString);

    // $("#email").val(urlParams.get("email"))
        
    $(document).on('submit', '.form-invoice', function(e) {
        e.preventDefault();
        var e_modal_wait = $("#modalWait");
        showLoading(e_modal_wait);
        window.location = "/register_ahli/payment"+queryString;
    });
});