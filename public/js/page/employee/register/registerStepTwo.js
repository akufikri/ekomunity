$(function () {
    $("#btnsubmitku").on(function () {

         var negeri = $('select[name=negeri]').val()

         if(negeri == null){
             alert("Negeri wajib dipilih.");
             return false;
         }

         var bandar = $('select[name=bandar]').val()

         if(bandar == null){
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

    
    $(document).on('change', '#negeri', function() {

        var current_select = $('#negeri').find(":selected").val();
        tempState.val(current_select);

        triggerSelectBandar(tempState);
        triggerSelectParliament(tempState);
        getCityByState(current_select);
        getParliamentByState(current_select);

    });

    $(document).on('change', '#parliament', function() {

        var current_select = $('#parliament').find(":selected").val();
        tempParliament.val(current_select);

        triggerSelectDun(tempParliament);
        getDunByParliament(current_select);

    });

    $(document).on('submit', '.form-register', function(e) {
        e.preventDefault();

        var queryString = window.location.search;
        var urlParams = new URLSearchParams(queryString);

        // $("#email").val(urlParams.get("email"))
        
        var e_modal_wait = $("#modalWait");
        showLoading(e_modal_wait);

        var form = $(this)
        var input_token = $('input[name=_token]')
        var registered_by_persatuan = urlParams.get("registered_by_persatuan");
        var ref = urlParams.get("ref");


        $.ajax({
            url: "/register_ahli/step_two_update",
            type: "POST",
            data: {
                _token: input_token.val(),
                address: form.find('textarea[name=alamat_perhubungan]').val(),
                negeri: form.find('select[name=negeri]').val(),
                bandar: form.find('select[name=bandar]').val(),
                parliament: form.find('select[name=parliament]').val(),
                dun: form.find('select[name=dun]').val(),
                poskod: form.find('input[name=poskod]').val(),
                registered_by_persatuan : registered_by_persatuan,
                ref: ref,
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

                if(urlParams.get("daftar_persatuan")){
                    window.location = "/register_ahli/invoice"+queryString;
                } if(urlParams.get("registered_by_persatuan")){
                    window.location = "/senaraiAhli";
                } else {
                    window.location = "/home";
                }
                // window.location = "/success_register"+queryString;

            } else {
                swal(
                    'Warning!',
                    result.message,
                    'warning'
                )
            }

        }).fail();

    });

});

function triggerSelectBandar(param) {
    console.log('test bandar '+param.val())
    if(param.val() == "") {
        $("select[name=bandar]").attr('disabled','true');
        $("select[name=bandar]").css("background", "#d3d3d35c");
    } else {
        $("select[name=bandar]").removeAttr("disabled");
        $("select[name=bandar]").css("background", "#f9faff");
    }
}

function triggerSelectParliament(param) {
    console.log('test parliament '+param.val())
    if(param.val() == "") {
        $("select[name=parliament]").attr('disabled','true');
        $("select[name=parliament]").css("background", "#d3d3d35c");
    } else {
        $("select[name=parliament]").removeAttr("disabled");
        $("select[name=parliament]").css("background", "#f9faff");
    }
}

function triggerSelectDun(param) {
    if(param.val() == "") {
        $("select[name=dun]").attr('disabled','true');
        $("select[name=dun]").css("background", "#d3d3d35c");
    } else {
        $("select[name=dun]").removeAttr("disabled");
        $("select[name=dun]").css("background", "#f9faff");
    }
}

function getCityByState(id) {
    $.ajax({
        url: '/getCity',
        type: "GET",
        data: {
            id_state: id,
        },
    })
    .done(function (result) {
        
        var selectbandar = $("#bandar");
        selectbandar.find('option').remove();
        
        var optionDefault = $("<option />");
        optionDefault.html("Pilih Bandar");
        optionDefault.attr("disabled", true);
        optionDefault.attr('selected','selected');
        selectbandar.append(optionDefault);

        $(result).each(function () {
            var option = $("<option />");
        
            option.html(this.city);
            option.val(this.id_city);

            //Add the Option element to DropDownList.
            selectbandar.append(option);
        });
       
    })
    .fail();
}

function getParliamentByState(id) {
    $.ajax({
        url: '/getParliament',
        type: "GET",
        data: {
            id_state: id,
        },
    })
    .done(function (result) {
        
        var selectparliament = $("#parliament");
        selectparliament.find('option').remove();

        var optionDefault = $("<option />");
        optionDefault.html("Pilih Parlimen");
        optionDefault.attr("disabled", true);
        optionDefault.attr('selected','selected');
        selectparliament.append(optionDefault);

        $(result).each(function () {
            
            var option = $("<option />");

            option.html(this.parliament);
            option.val(this.id);

            //Add the Option element to DropDownList.
            selectparliament.append(option);
        });
       
    })
    .fail();
}

function getDunByParliament(id) {
    $.ajax({
        url: '/getDun',
        type: "GET",
        data: {
            id_parliament: id,
        },
    })
    .done(function (result) {
        
        var selectdun = $("#dun");
        selectdun.find('option').remove();

        var optionDefault = $("<option />");
        optionDefault.html("Pilih DUN");
        optionDefault.attr("disabled", true);
        optionDefault.attr('selected','selected');
        selectdun.append(optionDefault);

        $(result).each(function () {
            var option = $("<option />");

            option.html(this.dun);
            option.val(this.id);

            //Add the Option element to DropDownList.
            selectdun.append(option);
        });
       
    })
    .fail();
}

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      $('#image').attr('src', e.target.result).width(100).height(74);
    };

    reader.readAsDataURL(input.files[0]);
  }
}