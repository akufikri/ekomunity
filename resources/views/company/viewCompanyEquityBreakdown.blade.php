@extends('home')
@section('title-dashboard', 'Company')
@section('content')

@section('breadcrumb')

<li class="breadcrumb-item active"><a>Company Equity Breakdown</a></li>
@endsection

@php

$company_approve = false;
$user = Auth::user();
if($user->id_level === '2'){
    $DetailCompany = \App\Models\DetailCompany::where('id_user', $user->id)->first();
    if(($DetailCompany->status_certificate_approval == 'REJECTED' || $DetailCompany->status_certificate_approval == 'EXPIRED' || $DetailCompany->certificate_expired_date == null || $DetailCompany->certificate_expired_date <= date('Y-m-d')) && ($DetailCompany->status_certificate_approval !== 'WAITING')){
        $company_approve = false;
        $class1 = 'show';
    }else{
        $company_approve = false;
        $class1 = 'show';
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
    padding: .8rem .6rem 2.1rem .6rem;
    font-size: 1rem;
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
@include('company.redbar.function_pay-up_capital')
<div class="row" id="view">
          <div class="col-12">
            <!-- Default box -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title text-primary my-header">Company Equity Breakdown</h3>
              </div>
              @csrf
        		@if ($message = Session::get('success_update'))
                    <div class="alert alert-success">
                            {{ $message }}
                            <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                    </div>
                @endif
                @if ($message = Session::get('failed_update'))
                    <div class="alert alert-danger">
                        <p>
                            {{ $message }}
                            <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                        </p>
                    </div>
                @endif
              <div class="card-body">
                <div class="row">
                    <div class="col-md-12 my-table">
                        
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" for="">Authorize Paid Up Capital</label><br>
                                <label class="filldata" id="label_form" for="">{{isset($data->auth_paid_up_capital)?$data->auth_paid_up_capital:"Data has not been filled"}}</label>
                            </div>
                            <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Paid Capital</label><br>
                                <label class="filldata" for="" id="label_form">{{isset($data->paid_up_capital)?$data->paid_up_capital:"Data has not been filled"}}</label>
                            </div>
                        </div>
                        <a href="{{URL::to('companyEquityBreakdown/'.Auth::user()->id.'/edit')}}#viewEdit" class="btn btn-sm btn-warning my-button" title="Edit">Edit</a>
                      <br><hr>
                      
<div class="row">
    <div class="col-12">
        <div class="card" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title my-header text-primary">List Equity Breakdown</h3>
<!--                <div class="card-tools">
                    <a href="#" data-toggle="modal" data-target="#addEquity"  class="btn btn-sm btn-success pull-right">
                        <i class="fa fa-plus nav-icon"></i>
                        &nbsp; Add
                    </a>
                </div>-->
            </div>
            <div class="card-body">
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
                        @if ($message = Session::get('failed'))
                            <div class="alert alert-danger">
                                <p>
                                    {{ $message }}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                                </p>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm nowrap">
                                <thead>
                                    <tr>
                                        <th width="5%" style="text-align=center;">No</th>
                                        <th>Status</th>
                                        <th>Total Value of Share</th>
                                        <th>Percentage(%)</th>
                                        <!--<th>Action</th>-->
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td width="5%">1</td>
                                        <td>Bumiputera</td>
                                        <td>{{$data->bumiputera}}</td>
                                        <td>{{$data->percentage_bumiputera}}</td>
                                        <!--<th>Action</th>-->
                                    </tr>
                                <!--</tbody>-->
                                <!--<tbody>-->
                                    <tr>
                                        <td width="5%">2</td>
                                        <td>Non Bumiputera</td>
                                        <td>{{ $data->non_bumiputera }}</td>
                                        <td>{{ $data->percentage_non_bumiputera }}</td>
                                        <!--<th>Action</th>-->
                                    </tr>
                                <!--</tbody>-->
                                <!--<tbody>-->
                                    <tr>
                                        <td width="5%">3</td>
                                        <td>Foreign</td>
                                        <td>{{ $data->foreign }}</td>
                                        <td>{{ $data->percentage_foreign }}</td>
                                        <!--<th>Action</th>-->
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                      
                    </div>
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <!--<a href="/employmentDetailEdit" class="btn btn-sm btn-warning">Edit</a>-->
              </div>
              <!-- /.card-footer-->
            </div>
            <!-- /.card -->
          </div>
        </div>
        
        <!--ADD Equity Breakdown-->
        <div class="modal fade" id="addEquity" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Equity Breakdown</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-------->
                        <form action="{{route('company_list_equity.create')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                          <div class="form-group">
                            <label for="exampleInputEmail1">Status</label>
                            <select class="form-control form-control-sm" name="status" id="status" required autofocus>
                              <option selected disabled value="">Select Status</option>
                              @foreach(\App\Models\StatusNative::get() as $data)
                              <option value="{{$data->id_status_native}}" {{(old('id_status_native')==$data->id_status_native)? 'selected':''}}>
                                {{$data->status_native}}
                              </option>
                              @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">Total Value Per Share</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text">RM</span>
                              </div>
                              <input type="number" name ="total" id="total" class="form-control" required>
                            </div>
                        <!--------->
                    </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <input type="submit" value="Save" class="btn btn-success">
                    </div>
                    </div>
               </form>
            </div>
        </div>
            </div>
        </div>
        <!-- END ADD NEW HISTORY-->
        
        <!--Update Equity Breakdown-->
        <div class="modal fade" id="updateEquity" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Equity Breakdown</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-------->
                        <form action="{{URL::to('/companyListEquityBreakdown/')}}" class="form-update-data" method="POST" enctype="multipart/form-data">
                            @csrf
                          <div class="form-group">
                             <input type="hidden" name="id" id="id">
                            <label for="exampleInputEmail1">Status</label>
                            <select class="form-control form-control-sm" name="status" id="status" required autofocus>
                              <option selected disabled value="">Select Status</option>
                              @foreach(\App\Models\StatusNative::get() as $data)
                              <option value="{{$data->id_status_native}}" {{(old('id_status_native')==$data->id_status_native)? 'selected':''}}>
                                {{$data->status_native}}
                              </option>
                              @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">Total Value Per Share</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text">RM</span>
                              </div>
                              <input type="number" name ="total" id="total" class="form-control" required>
                            </div>
                        <!--------->
                    </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <input type="submit" value="Save" class="btn btn-success">
                    </div>
                    </div>
               </form>
            </div>
        </div>
            </div>
        </div>
        <!-- END Update NEW HISTORY-->
        
        <!--DELETE Equity Breakdown-->
        <div class="modal fade" id="deleteEquity" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
});


    function loadData(){
    $('#datatable-crud').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        scrollX: true,
        ajax: {
                url: "{{ route('company.viewCompanyEquityBreakdown') }}",
                type: 'GET'
            },
        columns: [
            { data: 'DT_RowIndex' },
            { data: 'status' },
            { data: 'total' },
            { data: 'percentage' },
            { data: 'create_date' },
        ],
        /*columnDefs: [
                {
                    "targets" : 5,
                    "data": "id_company_equity_breakdown",
                    "render" : function (data, type, row) {//class="btn btn-primary btn-sm"
                        var btn = //'<a href="/learn/detail/'+row.id_company_equity_breakdown+'" data-toggle="modal" data-target="#addPosition" class="btn btn-primary btn-sm"><i class="fa fa-info-circle nav-icon"></i></a>'+
                        '<a href="/companyEquityBreakdown/'+row.id_company_equity_breakdown+'" id="editData" data-id="'+row.id_company_equity_breakdown+'"  data-toggle="modal" data-target="#updateEquity" class="btn btn-warning btn-sm"><i class="fa fa-edit nav-icon"></i></a>'+
                        '<a href="" id="deleteData" data-id="'+row.id_company_equity_breakdown+'" class="btn btn-danger btn-sm"><i class="fa fa-trash nav-icon"></i></a>'
                        return btn; //settings_position/'+row.id_position+'/edit
                    }
                },
            ],*/
        order: [[0, 'asc']]
    });
    
    }
    
        $(document).ready(function () {
    
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
                // url: "/editCompanyEquityBreakdown/"+id+"/edit_list_equity",
                url: "/editCompanyEquityBreakdown/"+id,
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
                        form.find('input[name=id]').val(data.id_company_equity_breakdown);
                        form.find('select[name=status]').val(data.id_status_native);
                        form.find('input[name=total]').val(data.value_rm);
            
                        $('#updateEquity').modal('show');
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
                url = '/companyListEquityBreakdown/'+id;
            var post_data = {
                is_ajax: true,
                _token: input_token.val(),
     
                status:ini.find('select[name=status]').val(),
                total:ini.find('input[name=total]').val(),
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
                    $('#updateEquity').modal('hide');
                    // initData(param)
                    // successAlert(message);
                    
                    loadData()
                    swal(
                        'Remind!',
                        'Update Equity Successfully!',
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
                url: "/companyEquityBreakdown/"+id, 
                type: 'DELETE',
                data: {
                    _token: token,
                        id: id
                },
                success: function (response){
                    $("#success").html(response.message)
                    loadData()
                    swal(
                        'Remind!',
                        'Equity Deleted Successfully!',
                        'success'
                    )
                }
            });
            return false;
        });
    // End Ajax Delete data
    });




// $('#price').on('refresh load propertychange change click keyup input paste',(function (event) {
//     $(this).val(function (index, value) {
//         s= '' + value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
//       return  s;
//     });
// }));
// $('#price1').on('refresh load propertychange change click keyup input paste',(function (event) {
//     $(this).val(function (index, value) {
//         s= '' + value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
//       return  s;
//     });
// }));
</script>
@endsection

