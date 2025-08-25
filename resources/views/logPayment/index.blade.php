@extends('home')
@section('title-dashboard', 'Admin')
@section('title','Admin')

@section('breadcrumb')

<li class="breadcrumb-item active">Log Payment</li>

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
                <h3 class="card-title text-danger my-header">Log Payment</h3>
                {{-- <div class="card-tools">
                    <a href="#" data-toggle="modal" data-target="#addCountry"  class="btn btn-sm btn-success pull-right">
                        <i class="fa fa-plus nav-icon"></i>
                        &nbsp; Add
                    </a>
                </div> --}}
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
                                        <th>Proof Payment</th>
                                        <th>User</th>
                                        <th>Day</th>
                                        <th>Month</th>
                                        <th>Year</th>
                                        <th>Payment Type</th>
                                        <th>Approval</th>
                                        <th>Approved At</th>
                                        <th>Approved By</th>
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

<!--ADD COUNTRY-->
<div class="modal fade" id="addCountry" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="/create_country" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Country</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body my-table">
                    <div class="form-group">
                        <label for="country_name">Country Name</label>
                        <input type="text" class="form-control" id="country_name" name="country_name" placeholder="Country Name" required>
                    </div>
                    <div class="form-group">
                        <label for="country_code">Country Code</label>
                        <input type="text" class="form-control" id="country_code" name="country_code" placeholder="Country Code" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Description" required>
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
<!--END ADD COUNTRY-->

<!--UPDATE Country-->
        <div class="modal fade" id="approvalPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <form action="" class="form-update-data" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Approval Payment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body my-table">
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="id_log_payment_manpower" name="id_log_payment_manpower" placeholder="id" hidden>
                        <img src="" id="proof_payment" class="proof_payment" name="proof_payment" width="300px" height="300px" alt="">
                        <button type="button" id="download" class="btn btn-sm btn-info" data-dismiss="modal">Download</button>
                    </div>
                    <div class="form-group">
                        <label for="country_code">User</label>
                        <input type="text" class="form-control" id="user" name="user" placeholder="User" readonly>
                    </div>
                    <div class="form-group">
                        <label for="description">Payment Type</label>
                        <input type="text" class="form-control" id="payment_type" name="payment_type" placeholder="Payment Type" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Approval Note</label>
                        <textarea class="form-control form-control-sm" name="approval_note" id="" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Approval</label>
                        <select class="form-control form-control-sm" id="approval" name="approval">
                          <option>Approve</option>
                          <option>Reject</option>
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
<!-- END UPDATE Country-->

<!--DETAIL Country-->
        <div class="modal fade" id="detailApprovalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
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
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="id_log_payment_manpower" name="id_log_payment_manpower" placeholder="id" hidden>
                        <img src="" name="proof_payment" width="300px" height="300px" alt="">
                    </div>
                    <div class="form-group">
                        <label for="country_code">User</label>
                        <input type="text" class="form-control" id="user" name="user" placeholder="User" readonly>
                    </div>
                    <div class="form-group">
                        <label for="description">Payment Type</label>
                        <input type="text" class="form-control" id="payment_type" name="payment_type" placeholder="Payment Type" readonly>
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
<!-- END UPDATE Country-->

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

    $('#download').click(function(e) {          
        var url = $('#proof_payment').prop('src');    
        e.preventDefault();          
        
        var a = document.createElement('A');
        a.href = url;
        a.download = url.substr(url.lastIndexOf('/') + 1);
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    });  

});

function loadData(){

    const queryString = window.location.search;
    console.log(queryString);

    $('#datatable-crud').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        destroy: true,
        ajax: {
                url: "/logPayment"+queryString,
                type: 'GET'
            },
        columns: [
            { data: 'DT_RowIndex' },
            { data: 'payment_proof' },
            { data: 'user.fullname' },
            { data: 'day' },
            { data: 'month' },
            { data: 'year' },
            { data: 'payment_type' },
            { data: 'approval' },
            { data: 'approval_date' },
            { data: 'approval_by_name' },
            { data: 'create_date' },
            { data: 'id_log_payment_manpower', className: 'text-center' },
        ],
        columnDefs: [
                {
                    "targets" : 1,
                    "visible" : true,
                    "className": "dt-center",
                    "data": "payment_proof",
                    "render" : function (data, type, row) {//class="btn btn-primary btn-sm"
                        return '<img src="/ImagePaymentProof/'+row.payment_proof+'" width="50%" height="50%" alt="'+row.payment_proof+'">'                         
                    }
                },
                {
                    "targets" : 7,
                    "data": "approval",
                    "render" : function (data, type, row) {//class="btn btn-primary btn-sm"
                        var btn = '<div><button class=" btn btn-sm btn-warning" style="width:100%">Waiting</button></div>'
                        if (row.approval == "WAITING") {
                            btn = '<div><button class=" btn btn-sm btn-warning" style="width:100%">Waiting</button></div>'
                        } else if (row.approval == "APPROVED") {
                            btn = '<div><button class=" btn btn-sm btn-success" style="width:100%">Approved</button></div>'
                        } else if (row.approval == "REJECTED") {
                            btn = '<div><button class=" btn btn-sm btn-danger" style="width:100%">Rejected</button></div>'
                        } else {
                            '<div><button class=" btn btn-sm btn-info" style="width:100%">Not Status</button></div>'
                        }

                        // var btn = row.approval == "WAITING" ? '<div><button class=" btn btn-sm btn-warning" style="width:100%">Waiting</button></div>' : '<div><button class="btn btn-sm btn-danger" style="width:100%">Disable</button></div>'
                        // '<a href="" id="deleteData" data-id="'+row.id_position+'" class="btn btn-danger btn-sm"><i class="fa fa-trash nav-icon"></i></a>'
                        return btn; //settings_position/'+row.id_position+'/edit
                    }
                },
                {
                    "targets" : 11,
                    "data": "id_log_payment_manpower",
                    "render" : function (data, type, row) {//class="btn btn-primary btn-sm"

                        var btn = '<a href="#" id="detailApproval" data-id="'+row.id_log_payment_manpower+'" data-target="#detailApprovalModal" data-toggle="modal" class="btn btn-primary btn-sm"><i class="fa fa-info-circle nav-icon"></i></a> '+
                        '<a href="#" id="updateApprovalPayment" data-id="'+row.id_log_payment_manpower+'" data-approval="Approve" data-toggle="modal" data-target="#approvalPayment" class="btn btn-success btn-sm"><i class="fa fa-check-circle nav-icon"></i></a> '+
                        '<a href="#" id="updateApprovalPayment" data-id="'+row.id_log_payment_manpower+'" data-approval="Reject" data-toggle="modal" data-target="#updateCountry" class="btn btn-danger btn-sm"><i class="fa fa-times nav-icon"></i></a>'

                        if (row.approval == "APPROVED") {

                        btn = '<a href="#" id="detailApproval" data-id="'+row.id_log_payment_manpower+'" data-target="#detailApprovalModal" data-toggle="modal" class="btn btn-primary btn-sm"><i class="fa fa-info-circle nav-icon"></i></a> '+
                        '<a href="#" id="updateApprovalPayment" data-id="'+row.id_log_payment_manpower+'" data-approval="Reject" data-toggle="modal" data-target="#updateCountry" class="btn btn-danger btn-sm"><i class="fa fa-times nav-icon"></i></a>'

                        } else if (row.approval == "REJECTED") {

                        btn = '<a href="#" id="detailApproval" data-id="'+row.id_log_payment_manpower+'" data-target="#detailApprovalModal" data-toggle="modal" class="btn btn-primary btn-sm"><i class="fa fa-info-circle nav-icon"></i></a> '+
                        '<a href="#" id="updateApprovalPayment" data-id="'+row.id_log_payment_manpower+'" data-approval="Approve" data-toggle="modal" data-target="#approvalPayment" class="btn btn-success btn-sm"><i class="fa fa-check-circle nav-icon"></i></a> '

                        }
                        
                        // '<a href="/learn/detail/'+row.id_qualification+'" class="btn btn-danger btn-sm"><i class="fa fa-trash nav-icon"></i></a>'
                        return btn;
                    }
                },
            ],
        order: [[0, 'asc']]
    });
}

$(document).ready(function(){
    // Start Ajax Edit data
    $("body").on("click","#updateApprovalPayment",function(e){
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
                url: "/logPayment",
                type: 'GET',
                data: {
                    _token: token,
                    id: id,
                    responseJson: 1
                },
                success: function (response){
                    $("#success").html(response.message)

                    if (approval == "Reject") {
                        $('select[name=approval]').val("Reject").change();
                    }

                    // if (response.data) {
                        data = response.data[0]
                        var form = $('.form-update-data');
                        // $("#image").attr("src", "data:image/png;base64," + response);
                        form.find('input[name=id_log_payment_manpower]').val(data.id_log_payment_manpower);
                        form.find('img[name=proof_payment]').attr("src", "/ImagePaymentProof/" + data.payment_proof);
                        form.find('input[name=user]').val(data.user.fullname);
                        form.find('input[name=payment_type]').val(data.payment_type);
                        // form.find('select[name=approval]').val(data.is_active);
            
                        $('#approvalPayment').modal('show');
                    // } else {
                    //     // failedAlert('Not Found');
                    // }
                }
            });
            return false;
        });
    // End Ajax Edit data
    
    // Start Ajax Detail data
    $("body").on("click","#detailApproval",function(e){
 
            e.preventDefault();
            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
            var url = e.target;
            $.ajax(
            {
                url: "/logPayment",
                type: 'GET',
                data: {
                    _token: token,
                    id: id,
                    responseJson: 1
                },
                success: function (response){
                    $("#success").html(response.message)

                    data = response.data[0]
                    var form = $('.form-detail-data');
                    // $("#image").attr("src", "data:image/png;base64," + response);
                    form.find('input[name=id_log_payment_manpower]').val(data.id_log_payment_manpower);
                    form.find('img[name=proof_payment]').attr("src", "/ImagePaymentProof/" + data.payment_proof);
                    form.find('input[name=user]').val(data.user.fullname);
                    form.find('input[name=payment_type]').val(data.payment_type);
                    form.find('textarea[name=approval_note]').val(data.approval_note);
                    form.find('select[name=approval]').val(data.user.approval);
                    // form.find('select[name=approval]').val(data.is_active);
        
                    $('#detailApprovalModal').modal('show');
                   
                }
            });
            return false;
        });
    // End Ajax Edit data
    
    // Start Ajax Update data
    $(document).on('submit', '.form-update-data', function(e){
            e.preventDefault();
            var ini = $(this),  input_token = $('input[name=_token]'),
                id = ini.find('input[name=id_log_payment_manpower]').val(),
                url = '/approvalPayment/'+id;
            var post_data = {
                is_ajax: true,
                _token: input_token.val(),
                id_log_payment_manpower: ini.find('input[name=id_log_payment_manpower]').val(),
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
                    $('#approvalPayment').modal('hide');
                    // initData(param)
                    // successAlert(message);
                    
                    loadData()
                    swal(
                        'Success!',
                        'Approval Successfully!',
                        'success'
                    )
                    
                } else {
                    // failedAlert(message);
                }
                input_token.val(result.newToken);
            })
            .fail(function(xhr, error) {

            });
            
        });
    // End Ajax Update data
      
});
</script>

@endsection