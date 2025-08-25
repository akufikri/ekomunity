$(function() {

    searchCountry = $('.searchCountry');
    var $option = $('<option selected="selected"></option>').val(0).text("Choose Your Country..");
    searchCountry.append($option).trigger('change');
    
    searchState = $('.searchState');
    var $option = $('<option selected="selected"></option>').val(0).text("Select Your Country First!");
    searchState.append($option).trigger('change');
    
    searchCity = $('.searchCity');
    var $option = $('<option selected="selected"></option>').val(0).text("Select Your Country First!");
    searchCity.append($option).trigger('change');
    
    searchCompanyType = $('.searchCompanyType');
    var $option = $('<option selected="selected"></option>').val(0).text("Choose Your Company Type..");
    searchCompanyType.append($option).trigger('change');
    
    $(".searchCountry").select2({
    placeholder: "Please Select",
    ajax: {
        url: "/getCountry",
        dataType: "json",
        delay: 250,
        processResults: function (data) {
            return {
                results: $.map(data, function (item) {
                        item_text =  item.country_name;
                        return {
                            text: item_text,
                            id: item.id_country
                        };
                })
            };
        },
        cache: false
    }
    }).on('change', function (e) {
        id_country = this.value;
        $('.searchState').prop('disabled', false);
        $('.searchCity').prop('disabled', false);
        
        $('#div_city').load(location.href+" #div_city>*", "");
        $('#div_state').load(location.href+" #div_state>*", function(){
            $(".searchState").select2({
                placeholder: "Please Select",
                ajax: {
                    url: '/getState?id_country=' + id_country,
                    dataType: "json",
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                    item_text =  item.state;
                                    return {
                                        text: item_text,
                                        id: item.id_state
                                    };
                            })
                        };
                    },
                    cache: false
                }
                }).on('change', function (e) {
                    id_state = this.value;
                    $('.searchCity').prop('disabled', false);
                    $('#div_city').load(location.href+" #div_city>*", function(){
                        $(".searchCity").select2({
                        placeholder: "Please Select",
                        ajax: {
                            url: '/getCity?id_state=' +  id_state,
                            dataType: "json",
                            delay: 250,
                            processResults: function (data) {
                                return {
                                    results: $.map(data, function (item) {
                                            item_text =  item.city;
                                            return {
                                                text: item_text,
                                                id: item.id_city
                                            };
                                    })
                                };
                            },
                            cache: false
                        }
                        }).on('change', function (e) {});
                        
                    });
                });
        });
    });
    
    $(".searchCompanyType").select2({
    placeholder: "Please Select",
    ajax: {
        url: "/getCompanyType",
        dataType: "json",
        delay: 250,
        processResults: function (data) {
            return {
                results: $.map(data, function (item) {
                        item_text =  item.company_type;
                        return {
                            text: item_text,
                            id: item.id_company_type
                        };
                })
            };
        },
        cache: false
    }
    })

    $(document).on('submit', '.form-billplz', function(e){
        e.preventDefault();

        var e_modal_wait = $("#modalWait");
        showLoading(e_modal_wait);

        var ini = $(this),  input_token = $('input[name=_token]'),
            id = ini.find('input[name=id]').val(),
            url = '/update_billplz_persatuan';
        var post_data = {
            is_ajax: true,
            _token: input_token.val(),
            id: ini.find('input[name=id]').val(),
            secret_key: ini.find('input[name=secret_key]').val(),
            collection_id: ini.find('input[name=collection_id]').val()
            // signature_payment: ini.find('input[name=signature_payment]').val(),

        };
    
        $.ajax({
            url: url,
            type: "POST",
            data: post_data
        })
        .done(function (result) {
            // var message = result.message;
            hideLoading(e_modal_wait);
            if (result.isSuccess) {
                $('#billPlzModal').modal('hide');

                location.reload()
                
                swal(
                    'Success!',
                    result.message,
                    'success'
                )        
                
            } else {

                swal(
                    'Fail!',
                    result.message,
                    'error'
                ) 
            }
            input_token.val(result.newToken);
        })
        .fail(function(xhr, error) {

        });
        
    });

})

function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
  
      reader.onload = function (e) {
        $('#image').attr('src', e.target.result).width(100).height(74);
      };
  
      reader.readAsDataURL(input.files[0]);
    }
  }