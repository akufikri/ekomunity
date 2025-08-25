@extends('home')
@section('title-dashboard', 'Status Log')
@section('content')

@section('breadcrumb')

<li class="breadcrumb-item active"><a>Status Log</a></li>
@endsection

<style>
    .select2-container--default .select2-selection--single {
    border: 1px solid #ced4da;
    height: calc(2.875rem + 2px) !important;
    padding: .8rem .6rem 2.1rem .6rem;
    font-size: 13px;
    line-height: 1.5;
    border-radius: .3rem;
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
        height: calc(2.875rem + 2px);
        padding: 1rem .8rem;
        font-size: 13px;
        line-height: 1.5;
        border-radius: .3rem;
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
        text-align: center;
        margin-bottom: 0px;
    }
    .my-table {
        font-size: 14px;
        margin-bottom: 0px;
    }
    
    input[type="text"]
    {
        font-size:14px;
    }
    
    input[type="number"]
    {
        font-size:14px;
    }
    
</style>

<div class="row" id="view">
    <div class="col-12">
        <div class="card card-danger card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title text-danger my-header">Status Log</h3>
                <div class="card-tools">
                    {{-- <a href="#" data-toggle="modal" title="Add" data-target="#addShareholders"  class="btn btn-sm btn-success pull-right">
                        <i class="fa fa-plus nav-icon"></i>
                        &nbsp; Add
                    </a> --}}
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="container mt-2 my-table">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                    {{ $message }}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                            </div><br>
                        @endif
                        @if ($message = Session::get('failed'))
                            <div class="alert alert-danger">
                                    {{ $message }}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                            </div><br>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm nowrap" id="datatable-crud">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Nama Persatuan </th>
                                        <th>User Level </th>
                                        <th>Status </th>
                                        <th>Comment(s) </th>
                                        <th>Created Date </th>
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

@php
    $data_temp_shareholders = \App\Models\TempCompanyShareHolders::where('id_user', Auth::user()->id)
    ->where('id_request_update', '0')->get();@endphp
@if(!$data_temp_shareholders->isEmpty())
<div class="row" id="view">
    <div class="col-12">
        <div class="card card-primary card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title text-primary my-header">List of Update Data</h3>
                <div class="card-tools">
                    <a href="{{URL::to('clearRequestUpdateCompany/SHAREHOLDERS')}}#view" title="Cancel Update" class="btn btn-sm btn-danger" >Cancel Update</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="container mt-2 my-table">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                    {{ $message }}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                            </div><br>
                        @endif
                        @if ($message = Session::get('failed'))
                            <div class="alert alert-danger">
                                    {{ $message }}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                            </div><br>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm nowrap" id="datatable-crud-temp">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Name of Individual/Company </th>
                                        <th>Individual's IC/ Passport / Company ROC Number </th>
                                        <th>Total Shares</th>
                                        <th>Percentage (%)</th>
                                        <th>Director's / Shareholder's Status</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                        <th>Remove</th>
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
@endif

        <!--ADD NEW SHAREHOLDERS-->
        <div class="modal fade" id="addShareholders" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Status Log</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body my-table">
                        <!-------->
                        <form action="{{URL::to('/senaraiAhli/store')}}#view" method="POST" enctype="multipart/form-data">
                          @csrf
                          <div class="form-group">
                            <label for="exampleInputEmail1">Name </label>
                            <div class="input-group">
                              <input type="text" name ="fullname" id="fullname" class="form-control" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">IC/Passport</label>
                            <div class="input-group">
                              <input type="text" name ="ic_number" id="ic_number" class="form-control" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">No. Telefon</label>
                            <div class="input-group">
                              <input type="number" name ="phone_number" id="phone_number" class="form-control" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">Emel</label>
                            <div class="input-group">
                              <input type="email" name ="email" id="email" class="form-control" required>
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="font-weight-700 labelku">Status Bumiputera <span style="color: #b91c1c;" >*</span> </label>
                            <select class="form-control form-control4 form-control-lg" name="native_statue" required autofocus>
                                <option selected disabled value="">Pilih Status Bumiputera</option>
                                <option value="Bumiputera">Bumiputera</option>
                                <option value="Non Bumiputera">Non Bumiputera</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Invoice <span style="color: #b91c1c;" >*</span> </label>
                            <select class="form-control form-control4 form-control-lg" name="invoice" required autofocus>
                                <option selected disabled value="">Pilih Invoice</option>
                                <option value="UNPAID">UNPAID</option>
                                <option value="PAID">PAID</option>
                            </select>
                        </div>
                        <br>
                        <div class="" style="text-align:right;">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                        <input type="submit" value="Save" class="btn btn-sm btn-success">
                    </div>
                    </div>
                </form>
            </div>
        </div>
        </div>
        </div>
        <!-- END ADD NEW SHAREHOLDERS-->
        
        <!--UPDATE SHAREHOLDERS-->
        <div class="modal fade" id="updateShareholders" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Senarai Ahli</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body my-table">
                        <!-------->
                        <form action="{{URL::to('/senaraiAhli/update')}}#view" class="form-update-data" method="POST" enctype="multipart/form-data">
                          @csrf
                          <div class="form-group">
                             <input type="hidden" class="form-control" name="id" id="id">
                            <label for="exampleInputEmail1">Name </label>
                            <div class="input-group">
                              <input type="text" name ="fullname" id="fullname" class="form-control" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">IC/Passport</label>
                            <div class="input-group">
                              <input type="text" name ="ic_number" id="ic_number" class="form-control" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">No. Telefon</label>
                            <div class="input-group">
                              <input type="number" name ="phone_number" id="phone_number" class="form-control" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">Emel</label>
                            <div class="input-group">
                              <input type="email" name ="email" id="email" class="form-control" required>
                            </div>
                          </div>
                         
                          <div class="form-group">
                            <label class="font-weight-700 labelku">Status Bumiputera <span style="color: #b91c1c;" >*</span> </label>
                            <select class="form-control form-control4 form-control-lg" name="native_status" required autofocus>
                                <option selected disabled value="">Pilih Status Bumiputera</option>
                                <option value="Bumiputera">Bumiputera</option>
                                <option value="Non Bumiputera">Non Bumiputera</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Invoice <span style="color: #b91c1c;" >*</span> </label>
                            <select class="form-control form-control4 form-control-lg" name="invoice" required autofocus>
                                <option selected disabled value="">Pilih Invoice</option>
                                <option value="UNPAID">UNPAID</option>
                                <option value="PAID">PAID</option>
                            </select>
                        </div>
                          <br>
                        <div class="" style="text-align: right">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                        <input type="submit" value="Save" class="btn btn-sm btn-success">
                    </div>
                    </div>
                </form>
            </div>
        </div>
        </div>
        </div>
        <!-- END UPDATE SHAREHOLDERS-->
        
        <!--DELETE HISTORY-->
        <div class="modal fade" id="deleteHistory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">DELETE this Equity Breakdown</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-------->
                        Are you sure to delete this Equity Breakdown?
                        <!--------->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger">Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END DELETE HISTORY-->

        <div class="modal fade" id="detailApprovalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
            <form action="" class="form-detail-data" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detail Approval</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body my-table">
                    
                        <div class="row" id="view">
    
                            <div class="col-12">
                                <div class="card card-danger card-outline">
           
                                    @csrf
                                    
                                    @if ($message = Session::get('success'))
                                        <div class="alert alert-success">
                                                {{ $message }}
                                                <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12 content-data">
                                                
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                    <div class="form-group">
                        <label for="exampleInputEmail1">Approval Note</label>
                        <textarea class="form-control form-control-sm" name="approval_note" id="" rows="3" readonly></textarea>
                    </div>
                    <div class="form-group">
                        <label for="description">Approval</label>
                        <input type="text" class="form-control" id="approval" name="approval" placeholder="Approval" readonly>
                    </div>
                </div>
                </div>
            </form>
            </div>
        </div>

        <div class="modal fade" id="approvalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
            <form action="" class="form-approval-data" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Approval</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body my-table">
                    
                        <div class="row" id="view">
    
                            <div class="col-12">
                                <div class="card card-danger card-outline">
           
                                    @csrf
                                    
                                    @if ($message = Session::get('success'))
                                        <div class="alert alert-success">
                                                {{ $message }}
                                                <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12 content-data">
                                                
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                    <div class="form-group">
                        <input type="hidden" class="form-control" id="id_log_certificate" name="id_log_certificate" placeholder="id" hidden>
                        <label for="exampleInputEmail1">Approval Note</label>
                        <textarea class="form-control form-control-sm" name="approval_note" id="" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Approval</label>
                        <select class="form-control form-control-sm" id="approval" name="approval">
                            <option value="APPROVED">Approve</option>
                            <option value="REJECTED">Reject</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                    <input type="submit" id="approval" value="Approval" class="btn btn-sm btn-success">
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
<script type="text/javascript">

$(document).ready( function () {
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    loadData()
    loadDataTemp()
});

function loadData(){

    const queryString = window.location.search;
    console.log(queryString);

    $('#datatable-crud').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        scrollX: true,
        ajax: {
                url: "/logCertificate"+queryString,
                type: 'GET'
            },

        columns: [
            { data: 'DT_RowIndex' },
            { data: 'company_name' },
            { data: 'user_level' },
            { data: 'status' },
            { data: 'note' },
            { data: 'create_date' },
            { data: 'id_log_certificate', className: 'text-center' },
        ],
        columnDefs: [
                {
                    "targets" : 6,
                    "data": "id_log_certificate",
                    "render" : function (data, type, row) {//class="btn btn-primary btn-sm"
                    var btn = '<a href="#" id="detailApproval" data-id="'+row.id_log_certificate+'" data-target="#detailApprovalModal" data-toggle="modal" class="btn btn-primary btn-sm"><i class="fa fa-info-circle nav-icon"></i></a> '+
                        '<a href="#" id="updateApproval" data-id="'+row.id_log_certificate+'" data-approval="Approve" data-toggle="modal" data-target="#approvalPayment" class="btn btn-success btn-sm"><i class="fa fa-check-circle nav-icon"></i></a> '+
                        '<a href="#" id="updateApproval" data-id="'+row.id_log_certificate+'" data-approval="Reject" data-toggle="modal" data-target="#updateCountry" class="btn btn-danger btn-sm"><i class="fa fa-times nav-icon"></i></a>'

                        if (row.status == "APPROVED") {

                        btn = '<a href="#" id="detailApproval" data-id="'+row.id_log_certificate+'" data-target="#detailApprovalModal" data-toggle="modal" class="btn btn-primary btn-sm"><i class="fa fa-info-circle nav-icon"></i></a> '+
                        '<a href="#" id="updateApproval" data-id="'+row.id_log_certificate+'" data-approval="Reject" data-toggle="modal" data-target="#updateCountry" class="btn btn-danger btn-sm"><i class="fa fa-times nav-icon"></i></a>'

                        } else if (row.status == "REJECTED") {

                        btn = '<a href="#" id="detailApproval" data-id="'+row.id_log_certificate+'" data-target="#detailApprovalModal" data-toggle="modal" class="btn btn-primary btn-sm"><i class="fa fa-info-circle nav-icon"></i></a> '+
                        '<a href="#" id="updateApproval" data-id="'+row.id_log_certificate+'" data-approval="Approve" data-toggle="modal" data-target="#approvalPayment" class="btn btn-success btn-sm"><i class="fa fa-check-circle nav-icon"></i></a> '

                        }
                        
                        // '<a href="/learn/detail/'+row.id_qualification+'" class="btn btn-danger btn-sm"><i class="fa fa-trash nav-icon"></i></a>'
                        return btn;
                    }
                },
            ],
        order: [[0, 'asc']]
    });
    
    }
    
    function loadDataTemp(){
    $('#datatable-crud-temp').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        scrollX: true,
        ajax: {
                url: "{{ route('company.viewShareholdersTemp') }}#view",
                type: 'GET'
            },
        columns: [
            
            { data: 'DT_RowIndex' },
            { data: 'name' },
            { data: 'number_id' },
            { data: 'total' },
            { data: 'percentage'},
            { data: 'position_user' },
            { data: 'status' },
            { data: 'create_date' },
            { data: 'action' },
            { data: '' , className: 'text-center' },
        ],
        columnDefs: [
                {
                    "targets" : 9,
                    "data": "id_company_shareholders",
                    "render" : function (data, type, row) {//class="btn btn-primary btn-sm"
                        var btn = //'<a href="/learn/detail/'+row.id_company_shareholders+'" data-toggle="modal" data-target="#addPosition" class="btn btn-primary btn-sm"><i class="fa fa-info-circle nav-icon"></i></a>'+
                        '<a href="" id="deleteDataTemp" data-id="'+row.id_temp_company_shareholders+'" class="btn btn-danger btn-sm" ><i class="fa fa-trash nav-icon"></i></a>'
                        return btn; //settings_position/'+row.id_position+'/edit
                    }
                },
            ],
        order: [[0, 'asc']]
    });
    
    }

    $("body").on("click","#detailApproval",function(e){
 
        e.preventDefault();
        var id = $(this).data("id");
        var token = $("meta[name='csrf-token']").attr("content");
        var url = e.target;
        $.ajax(
        {
            url: "/logCertificate",
            type: 'GET',
            data: {
                id_log_certificate: id,
            },
            success: function (response){
                $("#success").html(response.message)

                var data = response

                console.log(data)

                var view = $('.content-data')

                var set_data = '<div class="col-lg-12">'+
                                    '<div class="row">'+
                                        '<div class="col-lg-6">'+
                                            '<label class="filldata text-muted font-italic label_form_judul" for="">Nama Pertubuhan</label><br>'+
                                            '<label class="filldata" id="label_form" for="">'+ data.user.company.full_company_name +'</label>'+
                                        '</div>'+
                                        '<div class="col-lg-6">'+
                                            '<label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Alamat Perhubungan</label><br>'+
                                            '<label class="filldata" for="" id="label_form">'+ data.user.company.address +'</label>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="row">'+
                                        '<div class="col-lg-6">'+
                                            '<label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">No Pendaftaran Pertubuhan</label><br>'+
                                            '<label class="filldata" for="" id="label_form">'+ data.user.company.company_registration +'</label>'+
                                        '</div>'+
                                        '<div class="col-lg-6">'+
                                            '<label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Poskod</label><br>'+
                                            '<label class="filldata" for="" id="label_form">'+ data.user.company.postcode +'</label>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="row">'+
                                        '<div class="col-lg-6">'+
                                            '<label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">No Telefon Pejabat</label><br>'+
                                            '<label class="filldata" for="" id="label_form">'+ data.user.company.phone_office +'</label>'+
                                        '</div>'+
                                        '<div class="col-lg-6">'+
                                            '<label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Daerah/Bandar</label><br>'+
                                            '<label class="filldata" for="" id="label_form">'+ data.user.company.city.city +'</label>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="row">'+
                                        '<div class="col-lg-6">'+
                                            '<label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">No Fax</label><br>'+
                                            '<label class="filldata" for="" id="label_form">'+ data.user.company.fax_number +'</label>'+
                                        '</div>'+
                                        '<div class="col-lg-6">'+
                                            '<label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Negeri</label><br>'+
                                            '<label class="filldata" for="" id="label_form">'+ data.user.company.state.state +'</label>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="vl"></div>'+
                                    '<div class="row">'+
                                        '<div class="col-lg-6">'+
                                            '<label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">No Telefon </label><br>'+
                                            '<label class="filldata" for="" id="label_form">'+ data.user.phone_number +'</label>'+
                                        '</div>'+
                                        '<div class="col-lg-6">'+
                                            '<label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Laman Sasawang Rasmi</label><br>'+
                                            '<label class="filldata" for="" id="label_form">'+ data.user.company.company_website +'</label>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="row">'+
                                        '<div class="col-lg-6">'+
                                            '<label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Email</label><br>'+
                                            '<label class="filldata" for="" id="label_form">'+ data.user.email +'</label>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'

                view.html(set_data)
                
                var form = $('.form-detail-data')
                form.find('input[name="approval_note"]').val(data.note)
                form.find('input[name="approval"]').val(data.status)

                $('#detailApprovalModal').modal('show');
                
            }
        });
        return false;
    });

    $("body").on("click","#updateApproval",function(e){
            if(!confirm("Do you really want to do this?")) {
                return false;
            }
            e.preventDefault();
            var id = $(this).data("id");
            var approval = $(this).data("approval");
            var token = $("meta[name='csrf-token']").attr("content");
            var url = e.target;
            $.ajax(
            {
                url: "/logCertificate",
                type: 'GET',
                data: {
                    id_log_certificate: id,
                },
                success: function (response){
                    $("#success").html(response.message)

                    if (approval == "Reject") {
                        $('select[name=approval]').val("Rejected").change();
                    }

                    // if (response.data) {

                        var data = response

                        console.log(data)

                        var view = $('.content-data')

                        var set_data = '<div class="col-lg-12">'+
                                            '<div class="row">'+
                                                '<div class="col-lg-6">'+
                                                    '<label class="filldata text-muted font-italic label_form_judul" for="">Nama Pertubuhan</label><br>'+
                                                    '<label class="filldata" id="label_form" for="">'+ data.user.company.full_company_name +'</label>'+
                                                '</div>'+
                                                '<div class="col-lg-6">'+
                                                    '<label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Alamat Perhubungan</label><br>'+
                                                    '<label class="filldata" for="" id="label_form">'+ data.user.company.address +'</label>'+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="row">'+
                                                '<div class="col-lg-6">'+
                                                    '<label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">No Pendaftaran Pertubuhan</label><br>'+
                                                    '<label class="filldata" for="" id="label_form">'+ data.user.company.company_registration +'</label>'+
                                                '</div>'+
                                                '<div class="col-lg-6">'+
                                                    '<label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Poskod</label><br>'+
                                                    '<label class="filldata" for="" id="label_form">'+ data.user.company.postcode +'</label>'+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="row">'+
                                                '<div class="col-lg-6">'+
                                                    '<label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">No Telefon Pejabat</label><br>'+
                                                    '<label class="filldata" for="" id="label_form">'+ data.user.company.phone_office +'</label>'+
                                                '</div>'+
                                                '<div class="col-lg-6">'+
                                                    '<label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Daerah/Bandar</label><br>'+
                                                    '<label class="filldata" for="" id="label_form">'+ data.user.company.city.city +'</label>'+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="row">'+
                                                '<div class="col-lg-6">'+
                                                    '<label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">No Fax</label><br>'+
                                                    '<label class="filldata" for="" id="label_form">'+ data.user.company.fax_number +'</label>'+
                                                '</div>'+
                                                '<div class="col-lg-6">'+
                                                    '<label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Negeri</label><br>'+
                                                    '<label class="filldata" for="" id="label_form">'+ data.user.company.state.state +'</label>'+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="vl"></div>'+
                                            '<div class="row">'+
                                                '<div class="col-lg-6">'+
                                                    '<label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">No Telefon </label><br>'+
                                                    '<label class="filldata" for="" id="label_form">'+ data.user.phone_number +'</label>'+
                                                '</div>'+
                                                '<div class="col-lg-6">'+
                                                    '<label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Laman Sasawang Rasmi</label><br>'+
                                                    '<label class="filldata" for="" id="label_form">'+ data.user.company.company_website +'</label>'+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="row">'+
                                                '<div class="col-lg-6">'+
                                                    '<label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Email</label><br>'+
                                                    '<label class="filldata" for="" id="label_form">'+ data.user.email +'</label>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'

                        view.html(set_data)
                        
                        var form = $('.form-approval-data');
                        // $("#image").attr("src", "data:image/png;base64," + response);
                        form.find('input[name=id_log_certificate]').val(data.id_log_certificate);
                        // form.find('select[name=approval]').val(data.is_active);
            
                        $('#approvalModal').modal('show');
                    // } else {
                    //     // failedAlert('Not Found');
                    // }
                }
            });
            return false;
        });

    $(document).on('submit', '.form-approval-data', function(e){
            e.preventDefault();
            var ini = $(this),  input_token = $('input[name=_token]'),
                id = ini.find('input[name=id_log_certificate]').val(),
                url = '/approvalCertificate';
            var post_data = {
                is_ajax: true,
                _token: input_token.val(),
                id_log_certificate: ini.find('input[name=id_log_certificate]').val(),
                approval: ini.find('select[name=approval]').val(),
                approval_note: ini.find('textarea[name=approval_note]').val(),
            };
            
            // var e_modal_wait = $("#modalWait");
            // showLoading(e_modal_wait);
        
            $.ajax({
                url: url,
                type: "POST",
                data: post_data
            })
            .done(function (result) {
                // var message = result.message;
                // hideLoading(e_modal_wait);
                if (result.data != null) {
                    $('#approvalModal').modal('hide');
                    // initData(param)
                    // successAlert(message);
                    
                    loadData()
                    swal(
                        'Success!',
                        'Approval Successfully!',
                        'success'
                    )

                    // setTimeout(
                    // function() 
                    // {
                    //     document.location.href = "/logCertificate?status=Approved"
                    // }, 3000);
                    
                    
                } else {
                    // failedAlert(message);
                }
                input_token.val(result.newToken);
            })
            .fail(function(xhr, error) {

            });
            
        });


    // Start Ajax Edit data
    $("body").on("click","#editData",function(e){
            if(!confirm("Do you really want to do this?")) {
                return false;
            }
            e.preventDefault();
            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
            var url = e.target;
            $.ajax(
            {
                url: "/senaraiAhli/edit/"+id, //settings_position/'+row.id_position+'/edit
                type: 'GET',
                data: {
                    _token: token,
                        id: id
                },
                success: function (response){
                    $("#success").html(response.message)

                    if (response.data != null) {
                        data = response.data
                        var form = $('.form-update-data');
                        form.find('input[name=id]').val(data.id_detail_manpower);
                        form.find('input[name=fullname]').val(data.user.fullname);
                        form.find('input[name=ic_number]').val(data.ic_number);
                        form.find('input[name=phone_number]').val(data.user.phone_number);
                        form.find('input[name=email]').val(data.user.email);
                        form.find('select[name=native_status]').val(data.native_status);
                        form.find('select[name=invoice]').val(data.invoice);
            
                        $('#updateShareholders').modal('show');
                    } else {
                        // failedAlert('Not Found');
                    }
                }
            });
            return false;
        });
    // End Ajax Edit data
    
    // Start Ajax Update data
    $(document).on('submit', '.form-update-data', function(e){
            e.preventDefault();
            var ini = $(this),  input_token = $('input[name=_token]'),
                id = ini.find('input[name=id]').val(),
                url = '/senaraiAhli/update/'+id+'#view';
            var post_data = {
                is_ajax: true,
                _token: input_token.val(),
                
                fullname:ini.find('input[name=fullname]').val(),
                ic_number:ini.find('input[name=ic_number]').val(),
                phone_number:ini.find('input[name=phone_number]').val(),
                email:ini.find('input[name=email]').val(),
                native_status:ini.find('select[name=native_status]').val(),
                invoice:ini.find('select[name=invoice]').val(),

            };
            
            // var e_modal_wait = $("#modalWait");
            // showLoading(e_modal_wait);
        
            $.ajax({
                url: url,
                type: "post",
                data: post_data
            })
            .done(function (result) {
                // var message = result.message;
                // hideLoading(e_modal_wait);
                if (result.data != null) {
                    $('#updateShareholders').modal('hide');
                    // initData(param)
                    // successAlert(message);
                    
                    loadData()
                    loadDataTemp()
                    // location.href = "companyListofShareholders"
                    swal(
                        'Success!',
                        result.success,
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
        
    // Start Ajax Delete data
    $("body").on("click","#deleteData",function(e){
            if(!confirm("Do you really want to do this?")) {
                return false;
            }
            e.preventDefault();
            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
            var url = e.target;
            $.ajax(
            {
                url: "/senaraiAhli/delete/"+id+'#view', 
                type: 'DELETE',
                data: {
                    _token: token,
                        id: id
                },
                success: function (response){
                    $("#success").html(response.message)
                    loadData()
                    loadDataTemp()
                    // location.href = "companyListofShareholders"
                    swal(
                        'Success!',
                        'Senarai Ahli Deleted Successfully!',
                        'success'
                    )
                }
            });
            return false;
        });
    // End Ajax Delete data
    
    // Start Ajax Delete data temp
    $("body").on("click","#deleteDataTemp",function(e){
            if(!confirm("Do you really want to do this?")) {
                return false;
            }
            e.preventDefault();
            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
            var url = e.target;
            $.ajax(
            {
                url: "/deleteTempCompanyShareholders/"+id+'#view', 
                type: 'DELETE',
                data: {
                    _token: token,
                        id: id
                },
                success: function (response){
                    $("#success").html(response.message)
                    loadData()
                    loadDataTemp()
                    location.href = "companyListofShareholders"
                    swal(
                        'Success!',
                        'Temp Shareholders Deleted Successfully!',
                        'success'
                    )
                }
            });
            return false;
        });
    // End Ajax Delete data temp


$('#price').on('refresh load propertychange change click keyup input paste',(function (event) {
    $(this).val(function (index, value) {
        s= '' + value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      return  s;
    });
}));
$('#price1').on('refresh load propertychange change click keyup input paste',(function (event) {
    $(this).val(function (index, value) {
        s= '' + value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      return  s;
    });
}));
</script>
@endsection

