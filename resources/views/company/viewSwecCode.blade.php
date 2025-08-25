@extends('home')
@section('title-dashboard', 'Company')
@section('content')

@php

$company_approve = false;
$user = Auth::user();
if($user->id_level === '2'){
    $DetailCompany = \App\Models\DetailCompany::where('id_user', $user->id)->first();
    if(($DetailCompany->status_certificate_approval == 'REJECTED' || $DetailCompany->status_certificate_approval == 'EXPIRED' || $DetailCompany->certificate_expired_date == null || $DetailCompany->certificate_expired_date <= date('Y-m-d')) && ($DetailCompany->status_certificate_approval !== 'WAITING')){
        $company_approve = false;
        $class1 = 'show';
        $visible = 'true';
    }else{
        $company_approve = true;
        $class1 = 'show';
        $visible = 'true';
    }
}

@endphp

@section('breadcrumb')

<li class="breadcrumb-item active"><a>List of SWEC Code</a></li>
@endsection

<style>
    .title {
        font-size: 1.25rem; 
        font-weight: bold;
    }
    .select2-container--default .select2-selection--single {
    border: 1px solid #ced4da;
    height: calc(2.175rem + 2px) !important;
    padding: .6rem .6rem .6rem .6rem;
    font-size: .9rem;
    line-height: 1.5;
    border-radius: .3rem;
    }
    .form-unit .select2-container, .form-unit .select2-selection {
    width: 100% !important;
    font-size: 1.25rem;
    }
    .form-control-lg2 {
    border: 1px solid #ced4da;
    height: calc(2.875rem + 2px) !important;
    padding: 1.2rem 1rem 2.5rem 1rem;
    font-size: 1.25rem;
    line-height: 1.5;
    border-radius: .3rem;
    }
    .form-control-lg{
        height: calc(2.875rem + 2px);
        padding: 2rem 1.2rem;
        font-size: 1.25rem;
        line-height: 1.5;
        border-radius: .3rem;
    }
    .form-control-lgku{
        height: calc(2.875rem + 2px);
        padding: 2rem 1.2rem;
        font-size: 1.25rem;
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
    
    input[type="file"]
    {
        font-size:14px;
    }
    
    input[type="button"]
    {
        font-size:14px;
    }
    
</style>

@include('company.redbar.function_swec_code')
<div class="row" id="view">
    <div class="col-12">
        <div class="card card-primary card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title text-primary my-header">List of SWEC Code</h3>
                <div class="card-tools">
                    <a href="#" data-toggle="modal" data-target="#addSwecCode"  class="btn btn-sm btn-success pull-right">
                        <i class="fa fa-plus nav-icon"></i>
                        &nbsp; Add
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="container mt-2 my-table">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                    {{ $message }}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm nowrap" id="datatable-crud">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Service</th>
                                        <th>Code </th>
                                        <th>Created Date</th>
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
 $data_temp_swec_code = \App\Models\TempCompanySwecCode::where('id_user', $user->id)
 ->where('id_request_update', '0')->get();
@endphp
@if(!$data_temp_swec_code->isEmpty())
<div class="row" id="view">
    <div class="col-12">
        <div class="card card-primary card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title text-primary my-header">List of Update Data</h3>
                <div class="card-tools">
                    <a href="{{URL::to('clearRequestUpdateCompany/SWEC_CODE')}}#view" title="Cancel Update" class="btn btn-sm btn-danger" >Cancel Update</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="container mt-2 my-table">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                    {{ $message }}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm nowrap" id="datatable-crud-temp">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Service</th>
                                        <th>Code </th>
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

        <!--ADD NEW SWEC CODE-->
        <div class="modal fade" id="addSwecCode" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add SWEC Code</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body my-table">
                        <!-------->
                        <form action="{{URL::to('/createCompanySwecCode')}}" method="POST" enctype="multipart/form-data">
                          @csrf
                        
                          <div class="form-group">
                            <!--<label for="exampleInputEmail1">SWEC Code</label>-->
                            <select class="form-control form-control-sm select2" name="swec_code" id="swec_code" required autofocus style="width: 100%;">
                              <option selected disabled value="">Select Code</option>
                              @foreach($data_code as $datas)
                              <option value="{{$datas->id_code}}" {{(old('code')==$datas->code)? 'selected':''}}>
                                {{$datas->code}} - {{$datas->sub_specific_work}}
                              </option>
                              @endforeach
                            </select>
                          </div><br>
        
                        <div class="" style="text-align:right">
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

<!--push('custom-js')-->
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
    
    loadData();
    loadDataTemp();
    
    $('.select2').select2();
});

    function loadData(){
    $('#datatable-crud').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        scrollX: true,
        ajax: {
                url: "{{ route('company.viewSwecCode') }}",
                type: 'GET'
            },
        columns: [
            
            { data: 'DT_RowIndex' },
            { data: 'service' },
            { data: 'code' },
            { data: 'create_date' },
            { data: '' , className: 'text-center' },
        ],
        columnDefs: [
                {
                    "targets" : 4,
                    "data": "id_swec_company",
                    "render" : function (data, type, row) {//class="btn btn-primary btn-sm"
                        var btn = //'<a href="/learn/detail/'+row.id_company_shareholders+'" data-toggle="modal" data-target="#addPosition" class="btn btn-primary btn-sm"><i class="fa fa-info-circle nav-icon"></i></a>'+
                        '<a href="#" id="deleteData" data-id="'+row.id_swec_company+'" title="Delete" class="btn btn-danger btn-sm"><i class="fa fa-trash nav-icon"></i></a>'
                        return btn; //settings_position/'+row.id_position+'/edit
                    
                    
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
                url: "{{ route('company.viewSwecCodeTemp') }}",
                type: 'GET'
            },
        columns: [
            
            { data: 'DT_RowIndex' },
            { data: 'service' },
            { data: 'code' },
            { data: 'create_date' },
            { data: 'action' },
            { data: '', className: 'text-center' },
        ],
        columnDefs: [
                {
                    "targets" : 5,
                    "data": "id_swec_company",
                    "render" : function (data, type, row) {//class="btn btn-primary btn-sm"
                        var btn = '<a href="#" id="deleteDataTemp" data-id="'+row.id_temp_swec_company+'" title="Delete" class="btn btn-danger btn-sm"><i class="fa fa-trash nav-icon"></i></a>'
                        return btn; //settings_position/'+row.id_position+'/edit
                    
                    
                    }
                },
            ],
        order: [[0, 'asc']]
    });
    
    }
        
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
                url: "/companySwecCode/"+id, 
                type: 'DELETE',
                data: {
                    _token: token,
                        id: id
                },
                success: function (response){
                    $("#success").html(response.message)
                    loadData()
                    loadDataTemp()
                    location.href = "companySwecCode"
                    swal(
                        'Success!',
                        'Company SWEC Code Deleted Successfully!',
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
                url: "/deleteTempCompanySwecCode/"+id, 
                type: 'DELETE',
                data: {
                    _token: token,
                        id: id
                },
                success: function (response){
                    $("#success").html(response.message)
                    loadData()
                    loadDataTemp()
                    location.href = "companySwecCode"
                    swal(
                        'Success!',
                        'Temp Company SWEC Code Deleted Successfully!',
                        'success'
                    )
                }
            });
            return false;
        });
    // End Ajax Delete data

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
<!--endpush-->
@endsection
