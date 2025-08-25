@extends('home')
@section('title-dashboard', 'Admin')
@section('title','Admin')

@section('breadcrumb')

<li class="breadcrumb-item active"><a>Gerban Pembayaran</a></li>
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
                <h3 class="card-title text-danger my-header">Settings Gerbang Pembayaran</h3>
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
                                        <th>Jenis</th>
                                        <th>Harga</th>
                                        <th>Harga pusat</th>
                                        <th>Harga cawangan</th>
                                        <th>Harga ketua bahagian</th>
                                        <th>Keterangan</th>
                                        <th>Category Code</th>
                                        <th>Secret Key</th>
                                        <th>Status</th>
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

<div class="modal fade" tabindex="-1" role="dialog" id="EditArticleModal">
    <div class="modal-dialog modal-lg">
        <form action="" method="POST" class="form-update-data" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Gerbang Pembayaran</h4>
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subscribe_for">Jenis Yuran:</label>
                                    <input type="hidden" class="form-control" name="id_setting_subscribe">
                                    <input type="text" class="form-control" name="subscribe_for" id="subscribe_for" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="price">Harga Default:</label>
                                    <input type="number" step="0.01" class="form-control" name="price" id="price" required>                     
                                </div>
                                <div class="form-group">
                                    <label for="price_pusat">Harga Pusat:</label>
                                    <input type="number" step="0.01" class="form-control" name="price_pusat" id="price_pusat" required>                     
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price_cawangan">Harga Cawangan:</label>
                                    <input type="number" step="0.01" class="form-control" name="price_cawangan" id="price_cawangan" required>                     
                                </div>
                                <div class="form-group">
                                    <label for="price_ketua_bahagian">Harga Ketua Bahagian:</label>
                                    <input type="number" step="0.01" class="form-control" name="price_ketua_bahagian" id="price_ketua_bahagian" required>                     
                                </div>
                                <div class="form-group">
                                    <label for="subscribe_name">Keterangan:</label>
                                    <input type="text" class="form-control" name="subscribe_name" id="subscribe_name" required>                     
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="collection_id">Category Code:</label>
                                    <input type="text" class="form-control" name="collection_id" id="collection_id" required>                     
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="secret_key">Secret Key:</label>
                                    <input type="text" class="form-control" name="secret_key" id="secret_key" required>                     
                                </div>
                            </div>
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

<div class="modal fade" tabindex="-1" role="dialog" id="ShowCertificateModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Gerbang Pembayaran</h4>
                <button type="button" class="close modelClose" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body my-table">
                <div id="ShowCertificateModalBody">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jenis Yuran:</label>
                                <input type="text" class="form-control" id="show_subscribe_for" disabled>
                            </div>
                            <div class="form-group">
                                <label>Harga Default:</label>
                                <input type="text" class="form-control" id="show_price" disabled>                     
                            </div>
                            <div class="form-group">
                                <label>Harga Pusat:</label>
                                <input type="text" class="form-control" id="show_price_pusat" disabled>                     
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Harga Cawangan:</label>
                                <input type="text" class="form-control" id="show_price_cawangan" disabled>                     
                            </div>
                            <div class="form-group">
                                <label>Harga Ketua Bahagian:</label>
                                <input type="text" class="form-control" id="show_price_ketua_bahagian" disabled>                     
                            </div>
                            <div class="form-group">
                                <label>Keterangan:</label>
                                <input type="text" class="form-control" id="show_subscribe_name" disabled>                     
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Category Code:</label>
                                <input type="text" class="form-control" id="show_collection_id" disabled>                     
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Secret Key:</label>
                                <input type="text" class="form-control" id="show_secret_key" disabled>                     
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm modelClose" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script src="//code.jquery.com/jquery-2.0.0.js"></script>
<script src="/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/page/admin/settingsSubscribe/index.js"></script>
@endsection