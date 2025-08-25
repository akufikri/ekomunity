@extends('home')
@section('title-dashboard', 'Admin')
@section('title','Admin')

@section('breadcrumb')

<li class="breadcrumb-item active">Religion</li>

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
                <h3 class="card-title text-danger my-header">Religion</h3>
                <div class="card-tools">
                    <a href="#" data-toggle="modal" data-target="#addReligion"  class="btn btn-sm btn-success pull-right">
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
                                        <th>Religion</th>
                                        <th>Description</th>
                                        <th>Status</th>
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

<!--ADD Religion-->
<div class="modal fade" id="addReligion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="/create_religion" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Religion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body my-table">
                    <div class="form-group">
                        <label for="religion">Religion</label>
                        <input type="text" class="form-control" id="religion" name="religion" placeholder="Religion" required>
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
<!--END ADD Religion-->

<!--UPDATE Religion-->
        <div class="modal fade" id="updateReligion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <form action="" class="form-update-data" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Religion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body my-table">
                    <div class="form-group">
                        <label for="religion">Religion</label>
                        <input type="hidden" class="form-control" id="id_religion" name="id_religion" placeholder="id" hidden>
                        <input type="text" class="form-control" id="religion" name="religion" placeholder="Religion" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Description" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Status</label>
                        <select class="form-control form-control-sm" id="status" name="status">
                          <option>ENABLE</option>
                          <option>DISABLE</option>
                        </select>
                    </div>
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                        <input type="submit" id="update" value="Save" class="btn btn-sm btn-success">
                    </div>
                </div>
            </form>
            </div>
        </div>
<!-- END UPDATE Religion-->

<!--DETAIL Religion-->
        <div class="modal fade" id="detailReligion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <form action="" class="form-update-data" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detail Religion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body my-table">
                    <div class="form-group">
                        <label for="religion">Religion</label>
                        <input type="hidden" class="form-control" id="id_religion" name="id_religion" placeholder="id" hidden>
                        <input type="text" class="form-control" id="religion" name="religion" placeholder="Religion" readonly>
                    </div>
                   
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Description" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Status</label>
                        <select class="form-control form-control-sm" id="status" name="status" disabled>
                          <option>ENABLE</option>
                          <option>DISABLE</option>
                        </select>
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
});

function loadData(){
    $('#datatable-crud').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        destroy: true,
        ajax: {
                url: "{{ route('settings_religion.index') }}",
                type: 'GET'
            },
        columns: [
            { data: 'DT_RowIndex' },
            { data: 'religion' },
            { data: 'description' },
            { data: 'is_active' },
            { data: 'create_date' },
            { data: '', className: 'text-center' },
        ],
        columnDefs: [
                {
                    "targets" : 3,
                    "data": "is_active",
                    "render" : function (data, type, row) {//class="btn btn-primary btn-sm"
                        var btn = row.is_active == "ENABLE" ? '<div><button class=" btn btn-sm btn-success" style="width:100%">Enable</button></div>' : '<div><button class="btn btn-sm btn-danger" style="width:100%">Disable</button></div>'
                        // '<a href="" id="deleteData" data-id="'+row.id_position+'" class="btn btn-danger btn-sm"><i class="fa fa-trash nav-icon"></i></a>'
                        return btn; //settings_position/'+row.id_position+'/edit
                    }
                },
                {
                    "targets" : 5,
                    "data": "c",
                    "render" : function (data, type, row) {//class="btn btn-primary btn-sm"
                        var btn = '<a href="#" data-toggle="modal" id="detailData" data-id="'+row.id_religion+'" data-target="#detailReligion" class="btn btn-primary btn-sm"><i class="fa fa-info-circle nav-icon"></i></a> '+
                        '<a href="#" id="editData" data-id="'+row.id_religion+'" data-toggle="modal" data-target="#updateReligion" class="btn btn-warning btn-sm"><i class="fa fa-edit nav-icon"></i></a>'
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
                url: "/settings_religion/"+id+"/edit",
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
                        form.find('input[name=id_religion]').val(data.id_religion);
                        form.find('input[name=religion]').val(data.religion);
                        form.find('input[name=description]').val(data.description);
                        form.find('select[name=status]').val(data.is_active);
            
                        $('#updateReligion').modal('show');
                    } else {
                        // failedAlert('Not Found');
                    }
                }
            });
            return false;
        });
    // End Ajax Edit data
    
    // Start Ajax Detail data
    $("body").on("click","#detailData",function(e){
 
            e.preventDefault();
            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
            var url = e.target;
            $.ajax(
            {
                url: "/settings_religion/"+id+"/edit",
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
                        form.find('input[name=id_religion]').val(data.id_religion);
                        form.find('input[name=religion]').val(data.religion);
                        form.find('input[name=description]').val(data.description);
                        form.find('select[name=status]').val(data.is_active);
            
                        $('#detailReligion').modal('show');
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
                id = ini.find('input[name=id_religion]').val(),
                url = '/update_religion/'+id;
            var post_data = {
                is_ajax: true,
                _token: input_token.val(),
                religion: ini.find('input[name=religion]').val(),
                description: ini.find('input[name=description]').val(),
                status: ini.find('select[name=status]').val(),
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
                input_token.val(result.newToken)
                if (result.data != null) {
                    $('#updateReligion').modal('hide');
                    // initData(param)
                    // successAlert(message);
                    
                    loadData()
                    swal(
                        'Success!',
                        'Update Religion Successfully!',
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
      
});
</script>

@endsection