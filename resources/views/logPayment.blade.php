@extends('home')
@section('title-dashboard', 'Log Pembayaran Ahli')
@section('content')

@section('breadcrumb')

<li class="breadcrumb-item active"><a>Log Pembayaran Ahli</a></li>
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
<style>

    body{
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    
    .img-circle {
        border-radius: 50%;
    }

    .cardnew{
        border-radius: 20px;
        top: 20%;
        text-align: left;
        left: 30%;
        margin-top: 20px;
        background: white;
        width: 580px;
        height: 530px;
        padding: 30px;
    }

    .sub-cardnew{
        box-shadow: .5px .5px lightgray;
        border-radius: 15px;
        height: 30px;
        width: 98%;
        padding-left: 5px;
        padding-right: 5px;
        margin-left: 20px;
        margin-right: 10px;
        margin-top: 15px;
        border:.1px solid rgb(202, 202, 202);
    }

    .fl{
        float: left;
    }

    .fr{
        float: right;
    }

    .ml-10{
        margin-left:10px;
    }

    .ml-20{
        margin-left:20px;
    }

    .mt-5{
        margin-top:5px;
    }

    .mt-10{
        margin-top:10px;
    }

    .mt-20{
        margin-top:20px;
    }

    .mt-30{
        margin-top:30px;
    }

    .mt-40{
        margin-top:40px;
    }

    .mt-50{
        margin-top:50px;
    }
</style>

<div class="row" id="view">
    <input type="hidden" class="form-control" id="id_level" name="id_level" value="{{$user->id_level}}" placeholder="id" hidden>

    <div class="col-12">
        <div class="card card-danger card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title text-danger my-header">Log Pembayaran Ahli</h3>
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
                                        <th>Nama</th>
                                        <th>Emel</th>
                                        <th>No. IC</th>
                                        <th>Yuran</th>
                                        <th>Status Approve</th>
                                        <th>Tarikh Approve</th>
                                        <th>Pembayaran</th>
                                        <th>Created At</th>
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
            <div class="modal-dialog modal-lg" role="document">
            <form action="" class="form-approval-data" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Approval Pembayaran</h5>
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


                                    <div class="card-body my-table">
                                        <div class="row">
                                            <div class="col-lg-12 content-data">
                                                
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="hidden" class="form-control" id="id" name="id" placeholder="id" hidden>
                            <input type="hidden" class="form-control" id="id_request_join_company" name="id_request_join_company" placeholder="id_request_join_company" hidden>
                            <label for="exampleInputEmail1">Approval Note</label>
                            <textarea class="form-control form-control-sm" name="approval_note" id="" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Approval</label>
                            <select class="form-control form-control-sm" id="approval" name="approval">
                                <option value="Approve">Approve</option>
                                <option value="Reject">Reject</option>
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

@include('layouts.modals')

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

    var id = $('input[name=id_level]').val()

    const queryString = window.location.search;
    console.log(queryString);

    $('#datatable-crud').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        scrollX: true,
        ajax: {
                url: "/log_pembayaran"+queryString,
                type: 'GET'
            },
        columns: [
            { data: 'DT_RowIndex' },
            { data: 'fullname' },
            { data: 'email' },
            { data: 'ic_number' },
            { data: 'amount' },
            { data: 'approval' },
            { data: 'approval_date' },
            { data: 'payment_type' },
            { data: 'created_date' },
        ],
        columnDefs: [
                {
                    "targets" : 5,
                    "data": "approval",
                    "render" : function (data, type, row) {
                        var btn = '<div><button class=" btn btn-sm btn-warning" style="width:100%">Waiting</button></div>'
                        if(row.approval == "APPROVED") {
                            btn = '<div><button class=" btn btn-sm btn-success" style="width:100%">Approved</button></div>'
                        } else if (row.approval == "REJECTED") {
                            btn = '<div><button class=" btn btn-sm btn-danger" style="width:100%">Rejected</button></div>'
                        }
                        return btn;
                    }
                },
                
            ],
        order: [[0, 'asc']]
    });
    
    }

    $("body").on("click","#detailApproval",function(e){

        var e_modal_wait = $("#modalWait");
        showLoading(e_modal_wait);
 
        e.preventDefault();
        var id = $(this).data("id");
        var token = $("meta[name='csrf-token']").attr("content");
        var url = e.target;
        $.ajax(
        {
            url: "/log_pembayaran_ahli?id="+id,
            type: 'GET',
            data: {},
            success: function (response){
                $("#success").html(response.message)

                hideLoading(e_modal_wait);

                var data = response

                console.log(data)

                var view = $('.content-data')

                var set_data = '<div class="col-lg-12">'+
                                    '<div class="row">'+
                                        '<div class="col-lg-6">'+
                                            '<label class="filldata text-muted font-italic label_form_judul" for="">Nama</label><br>'+
                                            '<label class="filldata" id="label_form" for="">'+ data.user.fullname +'</label>'+
                                        '</div>'+
                                        '<div class="col-lg-6">'+
                                            '<label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Emel</label><br>'+
                                            '<label class="filldata" for="" id="label_form">'+ data.user.email +'</label>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="row">'+
                                        '<div class="col-lg-6">'+
                                            '<label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">No. IC</label><br>'+
                                            '<label class="filldata" for="" id="label_form">'+ data.manpower.ic_number +'</label>'+
                                        '</div>'+
                                        '<div class="col-lg-6">'+
                                            '<label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Yuran</label><br>'+
                                            '<label class="filldata" for="" id="label_form">RM'+ data.amount +'</label>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="row">'+
                                        '<div class="col-lg-6">'+
                                            '<label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Status Approve</label><br>'+
                                            '<label class="filldata" for="" id="label_form">'+ data.approval +'</label>'+
                                        '</div>'+
                                        '<div class="col-lg-6">'+
                                            '<label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Pembayaran</label><br>'+
                                            '<label class="filldata" for="" id="label_form">'+ data.payment_type +'</label>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="row">'+
                                        '<div class="col-lg-6">'+
                                            '<label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Bukti Pembayaran</label><br>'+
                                            '<img class="mb-2 mt-2" src="/ImagePaymentProof/'+ data.payment_proof +'" style="max-width:150px; max-height:100px" alt=""><br>'+
                                            '<a href="/ImagePaymentProof/'+ data.payment_proof +'" target="_blank"><button type="button" class="btn btn-sm btn-info">View</button></a>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="vl"></div>'+
                                   
                
                                '</div>'

                view.html(set_data)
                
                var form = $('.form-approval-data')
                form.find('input[name="id"]').val(data.id)
                form.find('input[name="id_request_join_company"]').val(data.id_request_join_company)
                form.find('input[name="approval_note"]').val(data.note)
                form.find('input[name="approval"]').val(data.status)

                $('#detailApprovalModal').modal('show');
                
            }
        });
        return false;
    });

    $(document).on('click', '#approve_join', function(e){
            e.preventDefault();

            var e_modal_wait = $("#modalWait");
            showLoading(e_modal_wait);
            
            var id = $('input[name=id_request_join]').val()
                    
            $.ajax({
                url: 'approve_join/'+id,
                type: "GET",
                data: {}
            })
            .done(function (result) {
                // var message = result.message;
                hideLoading(e_modal_wait);
                if (result.isSuccess) {
                    $('#detailApprovalModal').modal('hide');
                    // initData(param)
                    // successAlert(message);
                    
                    loadData()
                    swal(
                        'Success!',
                        result.message,
                        'success'
                    )
                    
                    
                } else {
                    alert(result.message)
                }
                input_token.val(result.newToken);
            })
            .fail(function(xhr, error) {

            });
            
    });

    $(document).on('click', '#reject_join', function(e){
            e.preventDefault();

            var e_modal_wait = $("#modalWait");
            showLoading(e_modal_wait);
            
            var id = $('input[name=id_request_join]').val()
                    
            $.ajax({
                url: 'reject_join/'+id,
                type: "GET",
                data: {}
            })
            .done(function (result) {
                // var message = result.message;
                hideLoading(e_modal_wait);
                if (result.isSuccess) {
                    $('#detailApprovalModal').modal('hide');
                    // initData(param)
                    // successAlert(message);
                    
                    loadData()
                    swal(
                        'Success!',
                        result.message,
                        'success'
                    )
                    
                    
                } else {
                    alert(result.message)
                }
                input_token.val(result.newToken);
            })
            .fail(function(xhr, error) {

            });
            
    });

    $(document).on('submit', '.form-approval-data', function(e){
            e.preventDefault();

            var e_modal_wait = $("#modalWait");
            showLoading(e_modal_wait);

            var ini = $(this),  input_token = $('input[name=_token]'),
                id = ini.find('input[name=id]').val(),
                url = '/approvalPaymentJoinPersatuan/'+id;
            var post_data = {
                is_ajax: true,
                _token: input_token.val(),
                id: ini.find('input[name=id_request_join_company]').val(),
                approval: ini.find('select[name=approval]').val(),
                approval_note: ini.find('textarea[name=approval_note]').val(),
            };
            
            //var e_modal_wait = $("#modalWait");
            //showLoading(e_modal_wait);
        
            $.ajax({
                url: url,
                type: "POST",
                data: post_data
            })
            .done(function (result) {
                // var message = result.message;
                hideLoading(e_modal_wait);
                if (result.data != null) {
                    $('#detailApprovalModal').modal('hide');
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


