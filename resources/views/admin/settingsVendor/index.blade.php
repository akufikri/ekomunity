@extends('home')
@section('title-dashboard', 'Admin')
@section('title','Admin')

@section('breadcrumb')

<li class="breadcrumb-item active"><a>Settings Vendor Licenses</a></li>
@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card card-primary card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title">Settings Vendor Licenses</h3>
                <div class="card-tools">
                    <a href="#" data-toggle="modal" data-target="#addVendor"  class="btn btn-sm btn-success pull-right">
                        <i class="fa fa-plus nav-icon"></i>
                        &nbsp; Add
                    </a>
                </div>
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
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm nowrap" id="datatable-crud">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Vendor Licenses</th>
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

<!--ADD VENDOR-->
        <div class="modal fade" id="addVendor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <form action="{{ route('settings_vendor.create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Vendor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                          <div class="form-group">
                            <label for="vendor">Vendor Licenses</label>
                            <input type="text" class="form-control" id="vendor_licenses" name="vendor_licenses" placeholder="Vendor Licenses Name" required>
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">Description</label>
                            <input type="text" class="form-control" id="description" name="description" placeholder="Description" required>
                          </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <input type="submit" value="Save" class="btn btn-success">
                    </div>
                </div>
            </form>
            </div>
        </div>
<!-- END ADD VENDOR-->

<!--UPDATE VENDOR-->
        <div class="modal fade" id="updateVendor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <form action="" class="form-update-data" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Vendor Licenses</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                          <div class="form-group">
                            <label for="vendor">Vendor Licenses</label>
                            <input type="text" class="form-control" id="id" name="id" placeholder="id" hidden>
                            <input type="text" class="form-control" id="vendor_licenses" name="vendor_licenses" placeholder="vendor_licenses" required>
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">Description</label>
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <input type="submit" id="update" value="Save" class="btn btn-success">
                    </div>
                </div>
            </form>
            </div>
        </div>

<!-- END UPDATE VENDOR-->

<!--VIEW VENDOR-->
        <div class="modal fade" id="viewVendor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <form action="" class="form-update-data" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">View Vendor Licenses</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                          <div class="form-group">
                            <label for="vendor">Vendor Licenses</label>
                            <input type="text" class="form-control" id="id" name="id" placeholder="id" hidden>
                            <input type="text" class="form-control" id="vendor_licenses" name="vendor_licenses" placeholder="vendor_licenses" disabled>
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">Description</label>
                            <input type="text" class="form-control" id="description" name="description" placeholder="Description" disabled>
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">Status</label>
                            <input type="text" class="form-control" id="status" name="status" placeholder="status" disabled>
                          </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Back</button>
                    </div>
                </div>
            </form>
            </div>
        </div>

<!-- END VIEW VENDOR-->

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
                url: "{{ route('settings_vendor.index') }}",
                type: 'GET'
            },
        columns: [
            { data: 'DT_RowIndex'},
            { data: 'vendor_licenses'},
            { data: 'description'},
            { data: 'is_active'},
            { data: 'create_date'},
        ],
        columnDefs: [
                {
                    "targets" : 5,
                    "data": "c",
                    "render" : function (data, type, row) {//class="btn btn-primary btn-sm"
                        var btn = '<a href="/view_vendor/'+row.id_vendor_licenses+'" id="viewData" data-toggle="modal" data-target="#viewVendor" class="btn btn-primary btn-sm"><i class="fa fa-info-circle nav-icon"></i></a>'+
                        '<a href="/update_vendor/'+row.id_vendor_licenses+'" id="editData" data-id="'+row.id_vendor_licenses+'"  data-toggle="modal" data-target="#updateVendor" class="btn btn-warning btn-sm"><i class="fa fa-edit nav-icon"></i></a>'
                        // '<a href="" id="deleteData" data-id="'+row.id_vendor_licenses+'" class="btn btn-danger btn-sm"><i class="fa fa-trash nav-icon"></i></a>'
                        return btn; //settings_vendor/'+row.id_vendor_licenses+'/edit
                    }
                },
            ],
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
                url: "/settings_vendor/"+id+"/edit", //settings_vendor/'+row.id_vendor+'/edit
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
                        form.find('input[name=id]').val(data.id_vendor_licenses);
                        form.find('input[name=vendor_licenses]').val(data.vendor_licenses);
                        form.find('input[name=description]').val(data.description);
                        form.find('select[name=status]').val(data.is_active);
            
                        $('#updateVendor').modal('show');
                    } else {
                        // failedAlert('Not Found');
                    }
                }
            });
            return false;
        });
    // End Ajax Edit data
    
    // Start Ajax View data
    $("body").on("click","#viewData",function(e){
            // if(!confirm("Do you really want to do this?")) {
            //     return false;
            // }
            e.preventDefault();
            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
            var url = e.target;
            $.ajax(
            {
                url: "/settings_vendor/"+id+"/edit", //settings_vendor/'+row.id_vendor+'/edit
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
                        form.find('input[name=id]').val(data.id_vendor_licenses);
                        form.find('input[name=vendor_licenses]').val(data.vendor_licenses);
                        form.find('input[name=description]').val(data.description);
                        form.find('select[name=status]').val(data.is_active);
            
                        $('#viewVendor').modal('show');
                    } else {
                        // failedAlert('Not Found');
                    }
                }
            });
            return false;
        });
    // End Ajax View data
    
    // Start Ajax Update data
    $(document).on('submit', '.form-update-data', function(e){
            e.preventDefault();
            var ini = $(this),  input_token = $('input[name=_token]'),
                id = ini.find('input[name=id]').val(),
                url = '/update_vendor/'+id;
            var post_data = {
                is_ajax: true,
                _token: input_token.val(),
                vendor_licenses: ini.find('input[name=vendor_licenses]').val(),
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
                    $('#updateVendor').modal('hide');
                    // initData(param)
                    // successAlert(message);
                    
                    loadData()
                    swal(
                        'Success!',
                        'Update Vendor Successfully!',
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
    // $("body").on("click","#deleteData",function(e){
    //         if(!confirm("Do you really want to do this?")) {
    //             return false;
    //         }
    //         e.preventDefault();
    //         var id = $(this).data("id");
    //         var token = $("meta[name='csrf-token']").attr("content");
    //         var url = e.target;
    //         $.ajax(
    //         {
    //             url: "/settings_vendor/"+id, 
    //             type: 'DELETE',
    //             data: {
    //                 _token: token,
    //                     id: id
    //             },
    //             success: function (response){
    //                 $("#success").html(response.message)
    //                 loadData()
    //                 swal(
    //                     'Success!',
    //                     'Vendor Deleted Successfully!',
    //                     'success'
    //                 )
    //             }
    //         });
    //         return false;
    //     });
    // End Ajax Delete data
    });
</script>

@endsection