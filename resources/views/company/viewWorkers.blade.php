@extends('home')
@section('title-dashboard', 'Company')
@section('content')

@section('breadcrumb')

<li class="breadcrumb-item active"><a>List of Workers</a></li>
@endsection

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

@include('company.redbar.function_list_of_workers')
<div class="row" id="view">
    <div class="col-12">
        <div class="card card-primary card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title text-primary my-header">List of Workers</h3>
                <div class="card-tools">
                    <a href="#" data-toggle="modal" data-target="#addWorkers"  class="btn btn-sm btn-success pull-right">
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
                                        <th>Name</th>
                                        <th>IC/Passport</th>
                                        <th>Nationality</th>
                                        <th>Position</th>
                                        <th>Bumiputera Status</th>
                                        <th>Field of Work</th> <!--Field of Work adalah Segment-->
                                        <th>Others</th>
                                        <th>Certificate</th>
                                        <th>Created At</th>
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
 $data_temp_workers = \App\Models\TempCompanyWorkers::where('id_user', $user->id)
 ->where('id_request_update', '0')->get();
@endphp
@if(!$data_temp_workers->isEmpty())
<div class="row" id="view">
    <div class="col-12">
        <div class="card card-primary card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title text-primary my-header">List of Update Data</h3>
                <div class="card-tools">
                    <a href="{{URL::to('clearRequestUpdateCompany/WORKERS')}}#view" title="Cancel Update" class="btn btn-sm btn-danger" >Cancel Update</a>
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
                                        <th>Name</th>
                                        <th>IC/Passport</th>
                                        <th>Nationality</th>
                                        <th>Position</th>
                                        <th>Bumiputera Status</th>
                                        <th>Field of Work</th> <!--Field of Work adalah Segment-->
                                        <th>Others</th>
                                        <th>Certificate</th>
                                        <th>Created At</th>
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

<!--ADD NEW LIST OF WORKERS-->
<div class="modal fade" id="addWorkers" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add List of Workers</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body my-table">
                <!-------->
            <form action="{{URL::to('/createCompanyWorkers')}}#view" method="POST" class="form-add-data" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                      <input type="hidden" name="id" id="id">
                    <div class="form-group" >
                    <label for="exampleInputEmail1">Name</label>
                        <div class="input-group">
                          <input type="text" name ="name" id="name" class="form-control">
                        </div>
                    </div>
                    <div class="form-group" >
                    <label for="exampleInputEmail1">IC/Passport</label>
                        <div class="input-group">
                          <input type="number" name ="ic_number" id="ic_number" class="form-control">
                        </div>
                    </div>
                  <div class="form-group" >
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
                  <div class="form-group" >
                        <label for="exampleInputEmail1">Position</label>
                        <select class="form-control form-control-sm" name="position" id="position" required autofocus>
                          <option selected disabled value="">Select Position</option>
                          @foreach(\App\Models\Position::get() as $data)
                          <option value="{{$data->id_position}}" {{(old('id_position')==$data->id_position)? :''}}>
                            {{$data->position}}
                          </option>
                          @endforeach
                        </select>
                  </div>
                  <div class="form-group" >
                        <label for="exampleInputEmail1">Bumiputera Status</label>
                        <select class="form-control  form-control-sm" name="status" id="status" required autofocus>
                          <option selected disabled value="">Select Status</option>
                          @foreach(\App\Models\StatusNative::get() as $data)
                          <option value="{{$data->id_status_native}}" {{(old('id_status_native')==$data->id_status_native)? :''}}>
                            {{$data->status_native}}
                          </option>
                          @endforeach
                        </select>
                  </div>
                  <div class="form-group" >
                        <label for="exampleInputEmail1">Field of Work</label>
                        <select class="form-control  form-control-sm segment_add" name="segment_add" id="segment_add" required autofocus>
                          <option selected disabled value="">Select Field of Work</option>
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
                    <div class="field_wrapper">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-10">
                                    <input class="form-control" placeholder="Certifikat" type="file" accept=".doc,.docx,.txt,.pdf" name="certificate[]" value="" required/>
                                </div>
                                <div class="col-md-2">
                                    <a class="btn btn-info" href="javascript:void(0);" id="add_button" title="Add field"><i class="fa fa-plus nav-icon"></i></a>
                                </div>           
                            </div>
                        </div>
                    </div>
                <!--------->
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
<!-- END ADD NEW SEGMENT-->

<!--DELETE SEGMENT-->
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

    $(document).ready(function(){
        var maxField = 10; 
        var addButton = $('#add_button'); 
        var wrapper = $('.field_wrapper');
        var fieldHTML = '<div class="form-group add"><div class="row">';
        fieldHTML=fieldHTML + '<div class="col-md-10"><input class="form-control" accept=".doc,.docx,.txt,.pdf" placeholder="Certifikat" type="file" name="certificate[]" /></div>';
        fieldHTML=fieldHTML + '<div class="col-md-2"><a href="javascript:void(0);" class="remove_button btn btn-danger"><i class="fa fa-minus nav-icon"></a></div>';
        fieldHTML=fieldHTML + '</div></div>'; 
        var x = 1;
        
        $(addButton).click(function(){
            if(x < maxField){ 
                x++; 
                $(wrapper).append(fieldHTML); 
            }
        });
         
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('').parent('').remove(); 
            x--; 
        });
    });

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
                url: "{{ route('company.viewWorkers') }}#view",
                type: 'GET'
            },
        columns: [
            { data: 'DT_RowIndex' },
            { data: 'name' },
            { data: 'ic_number' },
            { data: 'country_name' },
            { data: 'position_name' },
            { data: 'status_native' },
            { data: 'segment_name' },
            { data: 'others_segment' },
            { data: 'certificate'},
            { data: 'create_date' },
        ],
        columnDefs: [
                
                {
                    "targets" : 10,
                    "data": "",
                    "render" : function (data, type, row) {//class="btn btn-primary btn-sm"
                        var btn = //'<a href="/learn/detail/'+row.id_company_segment+'" data-toggle="modal" data-target="#addPosition" class="btn btn-primary btn-sm"><i class="fa fa-info-circle nav-icon"></i></a>'+
                        '<a href="/companyWorkers/'+row.id_company_workers+'/edit" title="Edit" class="btn btn-warning btn-sm"><i class="fas fa-user-edit"></i></button></a>'+
                        '<a href="#" id="deleteData" data-id="'+row.id_company_workers+'" class="btn btn-danger btn-sm" ><i class="fa fa-trash nav-icon"></i></a>'
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
                url: "/companyWorkersTemp#view",
                type: 'GET'
            },
        columns: [
            { data: 'DT_RowIndex' },
            { data: 'name' },
            { data: 'ic_number' },
            { data: 'country_name' },
            { data: 'position_name' },
            { data: 'status_native' },
            { data: 'segment_name' },
            { data: 'others_segment' },
            { data: 'certificate', className: 'text-center' },
            { data: 'create_date' },
            { data: 'action' },
            { data: '', className: 'text-center' },
        ],
        columnDefs: [
                {
                    "targets" : 8 ,
                    "data": "certificate",
                    "render" : function (data, type, row) {
                          return '<a href="/CertificateOfWork/'+row.certificate+'" target="_blank" class="btn-edit-data btn btn-sm btn-primary">' +
                                    '<i class="fas fa-file-download fa-lg" width="50%"></i>' + 
                                  '</a>';
                        }
                },
                {
                    "targets" : 11,
                    "data": "",
                    "render" : function (data, type, row) {//class="btn btn-primary btn-sm"
                        var btn = //'<a href="/learn/detail/'+row.id_company_segment+'" data-toggle="modal" data-target="#addPosition" class="btn btn-primary btn-sm"><i class="fa fa-info-circle nav-icon"></i></a>'+
                        '<a href="#" id="deleteDataTemp" data-id="'+row.id_temp_company_workers+'" class="btn btn-danger btn-sm" ><i class="fa fa-trash nav-icon"></i></a>'
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
                url: "/companyWorkers/"+id+"#view", 
                type: 'DELETE',
                data: {
                    _token: token,
                        id: id
                },
                success: function (response){
                    $("#success").html(response.message)
                    loadData()
                    loadDataTemp()
                    location.href = "companyWorkers"
                    swal(
                        'Success!',
                        'List of Workers Deleted Successfully!',
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
                url: "/deleteTempCompanyWorkers/"+id+"#view", 
                type: 'DELETE',
                data: {
                    _token: token,
                        id: id
                },
                success: function (response){
                    $("#success").html(response.message)
                    loadData()
                    loadDataTemp()
                    location.href = "companyWorkers"
                    swal(
                        'Success!',
                        'Temp List of Workers Deleted Successfully!',
                        'success'
                    )
                }
            });
            return false;
        });
    // End Ajax Delete data

</script>
@endsection

