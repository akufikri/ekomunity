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
            url: "/setting_certificate",
            type: 'GET'
        },
    columns: [
        { data: 'DT_RowIndex'},
        { data: 'logo_1'},
        { data: 'logo_2'},
        { data: 'sign_picture'},
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
                "targets" : 6,
                "data": "c",
                "render" : function (data, type, row) {
                    var btn ='<div>'+row.valid_time+' Year </div>'
                    
                    return btn; 
                }
            },
            {
                "targets" : 7,
                "data": "c",
                "render" : function (data, type, row) {
                    var btn =   '<button type="button" class="btn btn-info btn-sm" id="getShowArticleData" data-id="'+row.id_detail_company+'"><i class="fas fa-info-circle"></i></i></button> '+
                                '<button type="button" class="btn btn-warning btn-sm" id="getEditArticleData" data-id="'+row.id_detail_company+'"><i class="fa fa-edit nav-icon"></button>'
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
    
$('.modelClose').on('click', function(){
        $('#ShowCertificateModal').hide();
    });

    // Start Ajax Update data
$(document).on('submit', '.form-update-data', function(e){


    var formData = new FormData(this);

    console.log(formData);

    e.preventDefault();
    var ini = $(this),  input_token = $('input[name=_token]'),
        id = ini.find('input[name=id_detail_company]').val(),
        url = '/update_certificate_persatuan/'+id;
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
            $('#EditArticleModal').hide();
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


$('.modelClose').on('click', function(){
    $('#EditArticleModal').hide();
});

$('body').on('click', '#getEditArticleData', function(e) {

$('.alert-danger').html('');
$('.alert-danger').hide();
var id = $(this).data('id');
$.ajax({
    url: "edit_persatuan/"+id,
    method: 'GET',
    
    success: function(result) {
        data = result.data
        var form = $('.form-update-data');
        form.find('input[name=id_detail_company]').val(data.id_detail_company);
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
    url: "show_persatuan/"+id,
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
    id = ini.find('input[name=id_detail_company]').val(),
    url = '/update_certificate_persatuan/'+id;
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
        $('#EditArticleModal').hide();
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
