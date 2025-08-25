@extends('home')
@section('title-dashboard', 'Persatuan')
@section('title','Persatuan')

@section('breadcrumb')

<li class="breadcrumb-item active"><a>Settings Certificate</a></li>
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
                <h3 class="card-title text-danger my-header">Settings Certificate</h3>
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
                                        <th>Logo Company</th>
                                        <th>Emblem Certificate</th>
                                        <th>Sign Picture</th>
                                        <th>Sign Name</th>
                                        <th>Sign Position</th>
                                        <th>Valid Time</th>
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
                    <h4 class="modal-title">Certificate Edit</h4>
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
                                    <img id="editLogoCompany" name="logoCompany" src="SettingsCertificate/'.$data->logo_1.'" width="80%"><br>
                                    <label style="font-size: 12px" for="Logo Company">Logo Company</label>
                                    <input type="file" id="img" name="img" onchange="readURL(this);" accept="image/*">
                                </div>
                            </div>
                            <div class="col-md-4" hidden>
                                <div class="form-group">
                                    <img id="editLogoCompany" name="emblemCertificate" src="SettingsCertificate/'.$data->logo_2.'" width="80%"><br>
                                    <label style="font-size: 12px" for="Emblem Certificate">Emblem Certificate</label>
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
                            <label for="Valid Time">Valid Time:</label>
                            <input type="number" class="form-control" name="valid_time" id="editValidTime" required>                     
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
                    <h4 class="modal-title">Setting Certificate</h4>
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
                                    <img id="editLogoCompany" name="logoCompany" src="SettingsCertificate/'.$data->logo_1.'" width="80%"><br>
                                    <label style="font-size: 12px" for="Logo Company">Logo Company</label>
                                </div>
                            </div>
                            <div class="col-md-4" hidden>
                                <div class="form-group">
                                    <img id="editLogoCompany" name="emblemCertificate" src="SettingsCertificate/'.$data->logo_2.'" width="80%"><br>
                                    <label style="font-size: 12px" for="Emblem Certificate">Emblem Certificate</label>
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
                            <input type="text" class="form-control" name="sign_name" id="editSignName" disabled value="'.$data->sign_name.'">
                        </div>
                        <div class="form-group">
                            <label for="Sign Position">Sign Position:</label>
                            <input type="text" class="form-control" name="sign_position" id="editSignPosition" disabled value="'.$data->sign_position.'">                     
                        </div>
                        <div class="form-group">
                            <label for="Valid Time">Valid Time:</label>
                            <input type="text" class="form-control" name="valid_time" id="editValidTime" disabled value="'.$data->valid_time.' Year">                     
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
<script type="text/javascript" src="js/page/company/settingsCertificate/index.js"></script>
    

@endsection