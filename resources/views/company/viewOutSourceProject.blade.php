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
        $visible = 'true';
        $class1 = 'show';
    }else{
        $company_approve = true;
        $class1 = 'show';
        $visible = 'true';
    }
}

@endphp

@section('breadcrumb')

<li class="breadcrumb-item active"><a>List of Out Source Project</a></li>
@endsection

<style>
    .title {
        font-size: 1.25rem; 
        font-weight: bold;
    }
    .select2-container--default .select2-selection--single {
    border: 1px solid #ced4da;
    height: calc(2.875rem + 2px) !important;
    padding: 1.2rem 1rem 2.5rem 1rem;
    font-size: 1.25rem;
    line-height: 1.5;
    border-radius: .3rem;
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

<div class="row" id="view">
    <div class="col-12">
        <div class="card card-primary card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title text-primary my-header">List of Out Source Project</h3>
                <div class="card-tools">
                    <a href="#" data-toggle="modal" data-target="#addProject" title="Add"  class="btn btn-sm btn-success pull-right">
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
                                        <th>Country</th>
                                        <th>Client</th>
                                        <th>Field of Business</th>
                                        <th>Others</th>
                                        <th>Project Name</th>
                                        <th>Start Date</th>
                                        <th>Completion Date</th>
                                        <th>Project Value</th>
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
 $data_temp_project_outsource = \App\Models\TempCompanyProject::where('id_user', $user->id)
->where('id_request_update', '0')
->where('id_source','2')->get();
@endphp
@if(!$data_temp_project_outsource->isEmpty())
<div class="row" id="view">
    <div class="col-12">
        <div class="card card-primary card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title text-primary my-header">List of Update Data</h3>
                <div class="card-tools">
                    <a href="{{URL::to('clearRequestUpdateCompany/OUTSOURCE_PROJECT')}}#view" title="Cancel Update" class="btn btn-sm btn-danger" >Cancel Update</a>
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
                                        <th>Country</th>
                                        <th>Client</th>
                                        <th>Field of Business</th>
                                        <th>Others</th>
                                        <th>Project Name</th>
                                        <th>Start Date</th>
                                        <th>Completion Date</th>
                                        <th>Project Value</th>
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
        
<!--ADD NEW PROJECT-->
<div class="modal fade" id="addProject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<form action="{{URL::to('/createOutSourceProject')}}" class="form-add-data" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Out Source Project</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body my-table">
            <!-------->
              <div class="form-group">
                <label for="exampleInputEmail1">Country</label>
                <select class="form-control form-control-sm" name="country" id="country" required autofocus>
                  <option selected disabled value="">Select Country</option>
                  @foreach(\App\Models\Country::get() as $data)
                  <option value="{{$data->id_country}}" {{(old('id_country')==$data->id_country)? :''}}>
                    {{$data->country_name}}
                  </option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Field of Business</label>
                <select class="form-control form-control-sm segment_add" name="segment" id="segment" required autofocus>
                  <option selected disabled value="">Select Field of Business</option>
                  @foreach(\App\Models\Segment::get() as $data)
                  <option value="{{$data->id_segment}}" {{(old('id_segment')==$data->id_segment)? :''}}>
                    {{$data->segment}}
                  </option>
                  @endforeach
                </select>
              </div>
              <div class="form-group" >
                <label for="exampleInputEmail1">Others</label>
                <div class="input-group">
                  <input type="text" name ="others_segment_add" id="others_segment_add" class="form-control" disabled>
                  
                </div>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Client</label>
                <input type="text" class="form-control" id="client" name="client" placeholder="Client" required>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Project Name</label>
                <input type="text" class="form-control" id="project_name" name="project_name" placeholder="Project Name" required>
              </div>
             <div class="form-group">
                <label for="#">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" placeholder="Start Date" required autofocus>
					@error('name')
					<div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
					@enderror
            </div>
            <div class="form-group">
                <label for="#">Completion Date</label>
                    <input type="date" name="completion_date" id="completion_date" class="form-control" placeholder="Completion Date" required autofocus>
					@error('name')
					<div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
					@enderror
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Project Value</label>
                <input type="number" class="form-control" id="project_value" name="project_value" placeholder="Project Value" required>
            </div>
             <div class="form-group">
                <label for="Letter offer">Letter offer</label>
                <input type="file" name="offer_later[]" accept=".doc,.docx,.txt,.pdf" class="form-control">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
            <input type="submit" value="Save" class="btn btn-sm btn-success">
        </div>
    </div>
</form>
</div>
</div>
<!-- END ADD NEW PROJECT-->

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
    $('#datatable-crud').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        scrollX: true,
        ajax: {
                url: "{{ route('company.viewOutSourceProject') }}",
                type: 'GET'
            },
        columns: [
            { data: 'DT_RowIndex' },
            { data: 'country_name' },
            { data: 'client' },
            { data: 'segment_name' },
            { data: 'others' },
            { data: 'project_name' },
            { data: 'start_date' },
            { data: 'completion_date' },
            { data: 'project_value' },
        ],
        columnDefs: [
                {
                    "targets" : 9,
                    "data": "id_company_project",
                    "render" : function (data, type, row) {//class="btn btn-primary btn-sm"
                        var btn = //'<a href="/learn/detail/'+row.id_company_project+'" data-toggle="modal" data-target="#updateProject" class="btn btn-primary btn-sm"><i class="fa fa-info-circle nav-icon"></i></a>'+
                        '<a href="/companyOutSourceProject/'+row.id_company_project+'/edit" title="Edit" class="btn btn-warning btn-sm"><i class="fas fa-user-edit"></i></button></a>'+
                        '<a href="" id="deleteData" data-id="'+row.id_company_project+'" title="Delete" class="btn btn-danger btn-sm"><i class="fa fa-trash nav-icon"></i></a>'
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
                url: "/companyOutSourceProjectTemp#view",
                type: 'GET'
            },
        columns: [
            { data: 'DT_RowIndex' },
            { data: 'country_name' },
            { data: 'client' },
            { data: 'segment_name' },
            { data: 'others' },
            { data: 'project_name' },
            { data: 'start_date' },
            { data: 'completion_date' },
            { data: 'project_value' },
            { data: 'action' },
            { data: '', className: 'text-center' },
        ],
        columnDefs: [
                {
                    "targets" : 10,
                    "data": "id_company_project",
                    "render" : function (data, type, row) {//class="btn btn-primary btn-sm"
                        var btn = //'<a href="/learn/detail/'+row.id_company_project+'" data-toggle="modal" data-target="#updateProject" class="btn btn-primary btn-sm"><i class="fa fa-info-circle nav-icon"></i></a>'+
                        '<a href="" id="deleteDataTemp" data-id="'+row.id_temp_company_project+'" title="Delete" class="btn btn-danger btn-sm"><i class="fa fa-trash nav-icon"></i></a>'
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
                url: "/companyOutSourceProject/"+id, 
                type: 'DELETE',
                data: {
                    _token: token,
                        id: id
                },
                success: function (response){
                    $("#success").html(response.message)
                    loadData()
                    loadDataTemp()
                    location.href = "companyOutSourceProject"
                    swal(
                        'Success!',
                        'Project Deleted Successfully!',
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
                url: "/deleteTempCompanyOutSourceProject/"+id+'#view', 
                type: 'DELETE',
                data: {
                    _token: token,
                        id: id
                },
                success: function (response){   
                    $("#success").html(response.message)
                    location.href = "companyOutSourceProject"
                    loadData()
                    loadDataTemp()
                    swal(
                        'Success!',
                        'Temp Company Project Deleted Successfully!',
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

