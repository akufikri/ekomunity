@extends('home')
@section('title-dashboard', 'Persatuan')
@section('title','Persatuan')

@section('breadcrumb')

<li class="breadcrumb-item active"><a>Settings Terma & Syarat</a></li>
@endsection

@section('content')

<style>
    .title {
        font-size: 1.25rem; 
        font-weight: bold;
    }
    .select2-container--default .select2-selection--single {
    border: 1px solid #ced4da;
    height: calc(2.4rem + 2px) !important;
    padding: .6rem .4rem .1rem .4rem;
    font-size: 13px;
    line-height: 1.2;
    border-radius: .1rem;
    }
    .form-control-lg2 {
    border: 1px solid #ced4da;
    height: calc(2.875rem + 2px) !important;
    padding: .8rem .6rem 2.1rem .6rem;
    font-size: 13px;
    line-height: 1.5;
    border-radius: .3rem;
    }
    .form-control-lg{
        height: calc(2.3rem + 2px);
        padding: .6rem .4rem;
        font-size: 13px;
        line-height: 1.3;
        border-radius: .1rem;
    }
    .form-control-lgku{
        height: calc(2.875rem + 2px);
        padding: 2rem 1.2rem;
        font-size: 13px;
        line-height: 1.5;
        border-radius: .3rem;
    }
    .filldata {
    font-weight: normal !important;
    }
    #label_form {
        padding-bottom: 8px; font-size: 15px;
    }
    .label_form_judul {
        font-size: 13px !important;
        margin-bottom: 0px;
    }
   .my-button {
        font-size: 15px;
    }
    .my-header {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 0px;
    }
    .my-table {
        font-size: 14px;
        margin-bottom: 0px;
    }
    
    input[type="text"]
    {
        font-size:13px;
    }
    
    input[type="number"]
    {
        font-size:13px;
    }
    
    input[type="date"]
    {
        font-size:13px;
    }
    
    input[type="file"]
    {
        font-size:13px;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card card-danger card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title text-danger my-header">Settings Terma & Syarat</h3>
            </div>
            <div class="card-body my-table">
                <div class="row">
                    <div class="container mt-2">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>
                                    {{ $message }}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                                </p>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm nowrap" id="datatable-crud">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Nama Persatuan</th>
                                        <th>Stamp Picture</th>
                                        <th>Sign Picture</th>
                                        <th>Sign Name</th>
                                        <th>Sign Position</th>
                                        <th>Yearly Fee</th>
                                        <th>Terma & Syarat</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="EditArticleModal">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <form action="" method="POST" class="form-update-data" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Terma & Syarat Edit</h4>
                    <button type="button" class="close modelClose" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body my-table">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                        <strong>Success!</strong>Article was added successfully.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="EditArticleModalBody">

                        <div class="row">
           
                            <div class="col-md-4">
                                <div class="form-group">
                                    <img id="editLogoCompany" name="emblemCertificate" src="SettingsCertificate/'.$data->logo_2.'" width="80%"><br>
                                    <label style="font-size: 12px" for="Emblem Certificate">Stamp Picture</label>
                                    <input type="file" id="img2" name="img2" onchange="readURL(this);" accept="image/*">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <img id="editLogoCompany" name="signPicture" src="SettingsCertificate/'.$data->sign_picture.'" width="80%"><br>
                                    <label style="font-size: 12px" for="Sign Picture">Sign Picture</label>
                                    <input type="file" id="img3" name="img3" onchange="readURL(this);" accept="image/*">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Sign Name">Sign Name:</label>
                            <input type="hidden" class="form-control" name="id_detail_company" >
                            <input type="text" class="form-control" name="sign_name" id="editSignName" required >
                        </div>
                        <div class="form-group">
                            <label for="Sign Position">Sign Position:</label>
                            <input type="text" class="form-control" name="sign_position" id="editSignPosition" required>                     
                        </div>
                        <div class="form-group">
                            <label for="Yearly Fee">Yearly Fee:</label>
                            <input type="text" class="form-control" name="joining_fee" id="editValidTime" required>                     
                        </div>

                        <div class="form-group">
                            <label for="Terma & Syarat:">Terma & Syarat:</label>
                            <textarea class="form-control" name="tnc" id="editTNC" rows="12"></textarea>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger modelClose" data-dismiss="modal">Close</button>
                    <input type="submit" value="Update" class="btn btn-sm btn-success" id="SubmitEditArticleForm">
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal" id="ShowCertificateModal">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <form action="" method="POST" class="form-update-data" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Setting Terma & Syarat</h4>
                    <button type="button" class="close modelClose" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body my-table">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="ShowCertificateModalBody">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <img id="editLogoCompany" name="emblemCertificate" src="SettingsCertificate/'.$data->logo_2.'" width="80%"><br>
                                    <label style="font-size: 12px" for="Emblem Certificate">Stamp Picture</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <img id="editLogoCompany" name="signPicture" src="SettingsCertificate/'.$data->sign_picture.'" width="80%"><br>
                                    <label style="font-size: 12px" for="Sign Picture">Sign Picture</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Sign Name">Sign Name:</label>
                            <input type="text" class="form-control" name="sign_name" id="editSignName" disabled value="">
                        </div>
                        <div class="form-group">
                            <label for="Sign Position">Sign Position:</label>
                            <input type="text" class="form-control" name="sign_position" id="editSignPosition" disabled value="">                     
                        </div>
                        <div class="form-group">
                            <label for="Yearly Fee">Yearly Fee:</label>
                            <input type="text" class="form-control" name="joining_fee" id="editValidTime" disabled value="">                     
                        </div>
                        <div class="form-group">
                            <label for="Terma & Syarat:">Terma & Syarat:</label>
                            <textarea class="form-control" name="tnc" id="editTNC" rows="12" disabled></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm modelClose" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script src="//code.jquery.com/jquery-2.0.0.js"></script>
<script src="/js/jquery.validate.min.js"></script>
{{-- <script type="text/javascript" src="js/page/company/settingsTermsConditions/index.js"></script> --}}

<script>

    // $('#summernote').summernote({
    //     placeholder: 'Sila isi terma dan syarat',
    //     tabsize: 2,
    //     height: 100
    // });

   $(document).ready( function () {

        loadData()
    });

function loadData(){
$('#datatable-crud').DataTable({
    processing: true,
    serverSide: true,
    destroy: true,
    scrollX: true,
    ajax: {
            url: "/setting_terms_conditions",
            type: 'GET'
        },
    columns: [
        { data: 'DT_RowIndex'},
        { data: 'full_company_name'},
        { data: 'logo_2'},
        { data: 'sign_picture'},
        { data: 'sign_name'},
        { data: 'sign_position'},
        { data: 'joining_fee'},
        { data: 'tnc'},
    ],
    columnDefs: [
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
                    var btn ='<div>RM'+row.joining_fee+'</div>'
                    
                    return btn; 
                }
            },
            {
                "targets" : 8,
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
        url = '/update_tnc_persatuan/'+id;

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
        form.find('input[name=joining_fee]').val(data.joining_fee);
        form.find('textarea[name=tnc]').val(data.tnc);
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
        form.find('textarea[name=tnc]').val(data.tnc);
        form.find('input[name=joining_fee]').val(data.joining_fee);
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

</script>

@endsection