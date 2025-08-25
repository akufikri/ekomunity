$(document).ready( function () {
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    loadData()
});

function loadData(){
$('#datatable-crud').DataTable({
    processing: true,
    serverSide: true,
    destroy: true,
    scrollX: true,
    ajax: {
            url: "/list_setting_certificate",
            type: 'GET'
        },
    columns: [
        { data: 'DT_RowIndex'},
        { data: 'logo_1'},
        { data: 'logo_2'},
        { data: 'sign_picture'},
        { data: 'state'},
        { data: 'sign_name'},
        { data: 'sign_position'},
        { data: 'valid_time'},
    ],
    columnDefs: [
            {
                "targets" : 1,
                "data": "img",
                "render" : function ( data, type, row) {
                    return '<img height="100px" width="100px" src="/SettingsCertificate/'+row.logo_1+'"/>';
                }
            },
            {
                "targets" : 2,
                "data": "img",
                "render" : function ( data, type, row) {
                    return '<img height="100px" width="100px" src="/SettingsCertificate/'+row.logo_2+'"/>';
                }
            },
            {
                "targets" : 3,
                "data": "img",
                "render" : function ( data, type, row) {
                    return '<img height="100px" width="100px" src="/SettingsCertificate/'+row.sign_picture+'"/>';
                }
            },
            {
                "targets" : 7,
                "data": "c",
                "render" : function (data, type, row) {
                    var btn ='<div>'+row.valid_time+' Year </div>'
                    
                    return btn; 
                }
            },
            {
                "targets" : 8,
                "data": "c",
                "render" : function (data, type, row) {
                    var btn =   '<button type="button" data-toggle="modal" data-target="#ShowCertificateModal" class="btn btn-info btn-sm" id="getShowArticleData" data-id="'+row.id_settings_certificate+'"><i class="fas fa-info-circle"></i></i></button> '+
                                '<button type="button" data-toggle="modal" data-target="#EditArticleModal" class="btn btn-warning btn-sm" id="getEditArticleData" data-id="'+row.id_settings_certificate+'"><i class="fa fa-edit nav-icon"></button>'
                    return btn; 
                }
            },
        ],
    order: [[0, 'asc']]
});

}

$('.modelClose').on('click', function(){
        $('#EditArticleModal').hide();
});

$('body').on('click', '#getEditArticleData', function(e) {

    $('.alert-danger').html('');
    $('.alert-danger').hide();
    var id = $(this).data('id');
    $.ajax({
        url: "list_setting_certificate/"+id+"/edit",
        method: 'GET',
        
        success: function(result) {
            data = result.data
            var form = $('.form-update-data');
            form.find('input[name=id_settings_certificate]').val(data.id_settings_certificate);
            form.find('input[name=sign_name]').val(data.sign_name);
            form.find('input[name=sign_position]').val(data.sign_position);
            form.find('input[name=valid_time]').val(data.valid_time);
            form.find('img[name=logoCompany]').attr('src','SettingsCertificate/'+data.logo_1);
            form.find('img[name=emblemCertificate]').attr('src','SettingsCertificate/'+data.logo_2);
            form.find('img[name=signPicture]').attr('src','SettingsCertificate/'+data.sign_picture);

            $('#EditArticleModal').show();
        }
    });
});
    
$('.modelClose').on('click', function(){
        $('#ShowCertificateModal').hide();
    });
$('body').on('click', '#getShowArticleData', function(e) {

    $('.alert-danger').html('');
    $('.alert-danger').hide();
    var id = $(this).data('id');
    $.ajax({
        url: "list_setting_certificate/"+id,
        method: 'GET',
        
        success: function(result) {
            data = result.data
            var form = $('.form-update-data');
            form.find('input[name=sign_name]').val(data.sign_name);
            form.find('input[name=sign_position]').val(data.sign_position);
            form.find('input[name=valid_time]').val(data.valid_time);
            form.find('img[name=logoCompany]').attr('src','SettingsCertificate/'+data.logo_1);
            form.find('img[name=emblemCertificate]').attr('src','SettingsCertificate/'+data.logo_2);
            form.find('img[name=signPicture]').attr('src','SettingsCertificate/'+data.sign_picture);

            $('#ShowCertificateModal').show();
        }
    });
});

    // Start Ajax Update data
$(document).on('submit', '.form-update-data', function(e){


    var formData = new FormData(this);

    console.log(formData);

    e.preventDefault();
    var ini = $(this),  input_token = $('input[name=_token]'),
        id = ini.find('input[name=id_settings_certificate]').val(),
        url = '/update_certificate/'+id;
    // var post_data = {
    //     is_ajax: true,
    //     _token: input_token.val(),
    //     sign_name: ini.find('input[name=sign_name]').val(),
    //     sign_position: ini.find('input[name=sign_position]').val(),
    //     valid_time: ini.find('input[name=valid_time]').val(),
        
    // };
    
    // var e_modal_wait = $("#modalWait");
    // showLoading(e_modal_wait);

    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
    })
    .done(function (result) {
        // var message = result.message;
        // hideLoading(e_modal_wait);
        if (result.data != null) {
            // $('#EditArticleModal').modal('hide');
            $('#EditArticleModal').modal('hide');
            // initData(param)
            // successAlert(message);
            
            loadData()
            swal(
                'Success!',
                'Update Settings Certificate Successfully!',
                'success'
            )
            
        } else {
            // failedAlert(message);
        }
        input_token.val(result.newToken);
    })
    .fail(ajax_fail);
    
});
// End Ajax Update data

    // $('#SubmitEditArticleForm').click(function(e) {
    //     e.preventDefault();
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
        
    //     $.ajax({
    //         url: "list_setting_certificate/"+id,
    //         method: 'PUT',
    //         data: {
    //             sign_name: $('#editSignName').val(),
    //             valid_time: $('#editValidTime').val(),
    //             sign_position: $('#editSignPosition').val(),
    //             logo_1: $('#EditLogo_1').val($('#EditLogo_1').attr('src', e.target.result)),
    //             logo_2: $('#logo_2').val(),
    //             sign_picture: $('#sign_picture').val(),
    //         },
    //         success: function(result) {
    //             if(result.errors) {
    //                 $('.alert-danger').html('');
    //                 $.each(result.errors, function(key, value) {
    //                     $('.alert-danger').show();
    //                     $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
    //                 });
    //             } else {
    //                 $('.alert-danger').hide();
    //                 $('.alert-success').show();
    //                 $('#datatable-crud').DataTable().ajax.reload();
    //                 setInterval(function(){ 
    //                     $('.alert-success').hide();
    //                     $('#EditArticleModal').hide();
    //                 }, 2000);
    //             }
    //         }
    //     });
    // });