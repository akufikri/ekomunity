@extends('home')
@section('title-dashboard', 'Company')
@section('content')

@section('breadcrumb')

<li class="breadcrumb-item active"><a>List Field of Business</a></li>
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
</style>
@include('company.redbar.function_field_of_bussiness')        
<div class="row" id="view">
    <div class="col-12">
        <div class="card card-primary card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title text-primary my-header">List Field of Business</h3>
                <div class="card-tools">
                    <a href="#" data-toggle="modal" data-target="#addSegment" title="Add"  class="btn btn-sm btn-success pull-right">
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
                                        <th>Field of Business</th>
                                        <th>Other</th>
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
 $data_temp_segment = \App\Models\TempCompanySegment::where('id_user', $user->id)
 ->where('id_request_update', '0')->get();
@endphp
@if(!$data_temp_segment->isEmpty())
<div class="row" id="view">
    <div class="col-12">
        <div class="card card-primary card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title text-primary my-header">List of Update Data</h3>
                <div class="card-tools">
                    <a href="{{URL::to('clearRequestUpdateCompany/SEGMENT')}}#view" title="Cancel Update" class="btn btn-sm btn-danger" >Cancel Update</a>
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
                                        <th>Field of Business</th>
                                        <th>Other</th>
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
        
        <!--ADD NEW SEGMENT-->
        <div class="modal fade" id="addSegment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Field of Business</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body my-table">
                        <!-------->
                    <form action="{{URL::to('/createCompanySegment')}}#view" method="POST" class="form-add-data" enctype="multipart/form-data">
                          @csrf
                          <div class="form-group">
                              <input type="hidden" name="id" id="id">
                            <label for="exampleInputEmail1">Field of Business</label>
                            <select class="form-control form-control-sm segment_add" name="segment_add" id="segment_add" required autofocus>
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
                        <!--------->
                    </div>
                        <div class="modal-footer">
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
        <!-- START UPDATE SEGMENT-->
        <div class="modal fade" id="updateSegment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Field of Business</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-------->
                        <form action="{{URL::to('/companySegment/')}}#view" class="form-update-data" method="POST" enctype="multipart/form-data">
                          @csrf
                          <div class="form-group">
                             <input type="hidden" class="form-control" id="id" name="id" placeholder="id">
                            <label for="exampleInputEmail1">Field of Business</label>
                            
                           <!-- <select class="form-control form-control-sm segment" name="segment" id="segment" required autofocus>
                              <option selected disabled value="">Select Segment</option>
                              @foreach(\App\Models\Segment::get() as $data)
                              <option value="{{$data->id_segment}}" {{(old('id_segment')==$data->id_segment)? 'selected' :''}}>
                                {{$data->segment}}
                              </option>
                              @endforeach
                            </select>-->
                            
                            <select class="form-control form-control-sm segmentupdate" name="segment" id="segment" required autofocus>
                              <option selected disabled value="">Select Field of Business</option>
                              @foreach(\App\Models\Segment::get() as $data)
                              <option value="{{$data->id_segment}}" {{(old('id_segment')==$data->id_segment)? 'selected':''}}>
                                {{$data->segment}}
                              </option>
                              @endforeach
                            </select>
                          </div>
                          
                          
                          <div class="form-group" >
                            <label for="exampleInputEmail1">Others</label>
                            <div class="input-group">
                              <input type="text" name ="others_segment" id="others_segment" class="form-control" disabled>
                              
                            </div>
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
        </div>
        </div>
        <!-- END UPDATE SEGMENT-->
        
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
                url: "{{ route('company.viewSegment') }}#view",
                type: 'GET'
            },
        columns: [
            { data: 'DT_RowIndex' },
            { data: 'segment_name' },
            { data: 'others_segment' },
            { data: 'create_date' },
        ],
        columnDefs: [
                {
                    "targets" : 4,
                    "data": "c",
                    "render" : function (data, type, row) {//class="btn btn-primary btn-sm"
                        var btn = //'<a href="/learn/detail/'+row.id_company_segment+'" data-toggle="modal" data-target="#addPosition" class="btn btn-primary btn-sm"><i class="fa fa-info-circle nav-icon"></i></a>'+
                        '<a href="/update_position/'+row.id_company_segment+'" title="Edit" id="editData" data-id="'+row.id_company_segment+'"  data-toggle="modal" data-target="#updatePosition" class="btn btn-warning btn-sm" ><i class="fa fa-edit nav-icon"></i></a>'+
                        '<a href="" id="deleteData" data-id="'+row.id_company_segment+'" title="Delete" class="btn btn-danger btn-sm" ><i class="fa fa-trash nav-icon"></i></a>'
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
                url: "{{ route('company.viewSegmentTemp') }}#view",
                type: 'GET'
            },
        columns: [
            { data: 'DT_RowIndex' },
            { data: 'segment_name' },
            { data: 'others_segment' },
            { data: 'create_date' },
            { data: 'action' },
            { data: '' , className: 'text-center' },
        ],
        columnDefs: [
                {
                    "targets" : 5,
                    "data": "c",
                    "render" : function (data, type, row) {//class="btn btn-primary btn-sm"
                        var btn = //'<a href="/learn/detail/'+row.id_company_segment+'" data-toggle="modal" data-target="#addPosition" class="btn btn-primary btn-sm"><i class="fa fa-info-circle nav-icon"></i></a>'+
                        '<a href="" id="deleteDataTemp" data-id="'+row.id_temp_company_segment+'" title="Delete" class="btn btn-danger btn-sm"><i class="fa fa-trash nav-icon"></i></a>'
                        return btn; //settings_position/'+row.id_position+'/edit
                    }
                },
            ],
        order: [[0, 'asc']]
    });
    
    }

    $('select.segment_add').change(function(){
        
        // alert($('select.segment_add').val());
        
        var form = $('.form-add-data');
        
        if($('select.segment_add').val() === '0')
        // form.find('input[name=others_segment]').val($('select.segment').val());
        form.find('input[name=others_segment_add]').attr('disabled', false);
        else
        // form.find('input[name=others_segment]').val('');
        form.find('input[name=others_segment_add]').val('').attr('disabled', true);

    });
    
    $('select.segmentupdate').change(function(){
        
        // alert($('select.segmentupdate').val());
        
        var form = $('.form-update-data');
        
        if($('select.segmentupdate').val() === '0')
        // form.find('input[name=others_segment]').val($('select.segment').val());
        form.find('input[name=others_segment]').val('').attr('disabled', false);
        else    
        // form.find('input[name=others_segment]').val('');
        form.find('input[name=others_segment]').val('').attr('disabled', true);

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
                url: "/companySegment/"+id+"/edit",
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
                        form.find('input[name=id]').val(data.id_company_segment);
                        form.find('select[name=segment]').val(data.id_segment);
                        form.find('input[name=others_segment]').val(data.others_segment);
            
                        $('#updateSegment').modal('show');
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
                url = '/companySegment/'+id+'#view';
            var post_data = {
                is_ajax: true,
                _token: input_token.val(),
                segment: ini.find('select[name=segment]').val(),
                others_segment: ini.find('input[name=others_segment]').val(),
                
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
                    $('#updateSegment').modal('hide');
                    // initData(param)
                    // successAlert(message);
                    
                    loadData()
                    loadDataTemp()
                    location.href = "companySegment"
                    swal(
                        'Success!',
                        'Update Segment Successfully!',
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
                url: "/companySegment/"+id+'#view', 
                type: 'DELETE',
                data: {
                    _token: token,
                        id: id
                },
                success: function (response){
                    $("#success").html(response.message)
                    location.href = "companySegment"
                    loadData()
                    loadDataTemp()
                    swal(
                        'Success!',
                        'Segment Deleted Successfully!',
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
                url: "/deleteTempCompanySegment/"+id+'#view', 
                type: 'DELETE',
                data: {
                    _token: token,
                        id: id
                },
                success: function (response){
                    $("#success").html(response.message)
                    location.href = "companySegment"
                    loadData()
                    loadDataTemp()
                    swal(
                        'Success!',
                        'Temp Segment Deleted Successfully!',
                        'success'
                    )
                }
            });
            return false;
        });
    // End Ajax Delete data

</script>





<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->
<!--<script>-->
<!--$('#price').on('refresh load propertychange change click keyup input paste',(function (event) {-->
<!--    $(this).val(function (index, value) {-->
<!--        s= '' + value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");-->
<!--      return  s;-->
<!--    });-->
<!--}));-->
<!--$('#price1').on('refresh load propertychange change click keyup input paste',(function (event) {-->
<!--    $(this).val(function (index, value) {-->
<!--        s= '' + value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");-->
<!--      return  s;-->
<!--    });-->
<!--}));-->
<!--</script>-->
@endsection

