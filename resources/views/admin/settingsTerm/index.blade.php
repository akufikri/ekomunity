@extends('home')
@section('title-dashboard', 'Admin')
@section('title','Admin')

@section('breadcrumb')

<li class="breadcrumb-item active"><a>Terma & Syarat</a></li>
@endsection

@section('content')
<style>
/*table.dataTable td,table.dataTable th {*/
/*padding: 3px 10px !important;*/
/*width: 1px !important;*/
/*white-space: nowrap !important;*/
/*}*/

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

td .ini { 
    height: 70px;  
    width:100%; 
    overflow: hidden; 
    float:left}
</style>

<div class="row">
    <div class="col-12">
        <div class="card card-danger card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title text-danger my-header">Terma & Syarat</h3>
                <div class="card-tools">
                    <a href="#" data-toggle="modal" data-target="#addTerm" class="btn btn-sm btn-success pull-right">
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
                            <table class="table table-bordered table-sm" id="datatable-crud">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="5%">Level</th>
                                        <th width="60%">Term & Conditions</th>
                                        <th width="10%">Status</th>
                                        <th width="10%">Created At</th>
                                        <th width="10%">Action</th>
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

<div class="modal fade" id="addTerm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <form action="/create_term" class="" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Terma & Syarat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body my-table">
                <!-------->
                <div class="form-group">
                    <label for="exampleInputEmail1">Level</label>
                    <select class="form-control form-control-sm" id="id_level" name="id_level">
                      @foreach($level as $d)
                        <option value="{{ $d->id_level }}">{{ $d->description }}</option>
                      @endforeach
                    </select>
                  </div>
                  
                  <!--@foreach(\App\Models\Term::get() as $dataku)-->

                  <!--            <div class="form-group">-->
                  <!--              <label>Term Condition -->
                  <!--              @if ($dataku->id_level ==='2')-->
                  <!--              Company-->
                  <!--              @else-->
                  <!--              Manpower-->
                  <!--              @endif</label>-->
                  <!--              <textarea class="form-control" rows="10" id="term_conditions" name="term_conditions">{{$dataku->term_conditions}}</textarea>-->
                  <!--            </div>-->
                  <!--  @endforeach-->
                  <div class="form-group">
                    <label for="exampleInputEmail1">Terma & Syarat</label>
                    <textarea class="form-control" name="term_conditions" id="term_conditions" rows="12"></textarea>
                    <!--<input type="textarea" class="form-control" name="term_conditions" id="term_conditions" placeholder="term_conditions" required style="overflow:auto;">-->


                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Status</label>
                    <select class="form-control form-control-sm" id="status" name="status">
                      <option>ENABLE</option>
                      <option>DISABLE</option>
                    </select>
                </div>
                <!--------->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <input type="submit" id="update" value="Save" class="btn btn-success">
            </div>
        </div>
    </form>
    </div>
</div>


<!--UPDATE TERM-->
        <div class="modal fade" id="updateTerm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <form action="" class="form-update-data" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Terma & Syarat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body my-table">
                        <!-------->
                          <div class="form-group">
                            <label for="term">Level</label>
                            <input type="text" class="form-control" id="id" name="id" placeholder="id" hidden>
                            <input type="text" class="form-control" id="id_level" name="id_level" placeholder="id_level" required hidden>
                            <input type="text" class="form-control" id="" value="" name="level_name" placeholder="id_level" readonly>
                        
                          </div>
                          
                          <!--@foreach(\App\Models\Term::get() as $dataku)-->

                          <!--            <div class="form-group">-->
                          <!--              <label>Term Condition -->
                          <!--              @if ($dataku->id_level ==='2')-->
                          <!--              Company-->
                          <!--              @else-->
                          <!--              Manpower-->
                          <!--              @endif</label>-->
                          <!--              <textarea class="form-control" rows="10" id="term_conditions" name="term_conditions">{{$dataku->term_conditions}}</textarea>-->
                          <!--            </div>-->
                          <!--  @endforeach-->
                          <div class="form-group">
                            <label for="exampleInputEmail1">Terma & Syarat</label>
                            <textarea class="form-control" name="term_conditions" id="term_conditions" rows="12"></textarea>
                            <!--<input type="textarea" class="form-control" name="term_conditions" id="term_conditions" placeholder="term_conditions" required style="overflow:auto;">-->

    
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">Status</label>
                            <select class="form-control form-control-sm" id="status" name="status">
                              <option>ENABLE</option>
                              <option>DISABLE</option>
                            </select>
                          </div>
                        <!--------->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <input type="submit" id="update" value="Save" class="btn btn-success">
                    </div>
                </div>
            </form>
            </div>
        </div>
<!-- END UPDATE TERM-->

<!--View TERM-->
        <div class="modal fade" id="viewTermku" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <form action="" class="form-update-data" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">View Terma & Syarat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body my-table">
                        <!-------->
                          <div class="form-group">
                            <label for="term">Level</label>
                            <input type="text" class="form-control" id="id" name="id" placeholder="id" hidden>
                            <!--<input type="text" class="form-control" id="id_level" value="" name="id_level" placeholder="id_level" required>-->
                            <input type="text" class="form-control" id="" value="" name="level_name" placeholder="id_level" readonly>
                            
                          </div>
                          <!--@foreach(\App\Models\Term::get() as $dataku)-->

                          <!--            <div class="form-group">-->
                          <!--              <label>Term Condition -->
                          <!--              @if ($dataku->id_level ==='2')-->
                          <!--              Company-->
                          <!--              @else-->
                          <!--              Manpower-->
                          <!--              @endif</label>-->
                          <!--              <textarea class="form-control" rows="10" id="term_conditions" name="term_conditions">{{$dataku->term_conditions}}</textarea>-->
                          <!--            </div>-->
                          <!--  @endforeach-->
                          <div class="form-group">
                            <label for="exampleInputEmail1">Terma & Syarat</label>
                            <textarea class="form-control" name="term_conditions" id="term_conditions" rows="12" readonly></textarea>
                            <!--<input type="textarea" class="form-control" name="term_conditions" id="term_conditions" placeholder="term_conditions" required style="overflow:auto;">-->

    
                          </div>

                          <div class="form-group">
                            <label for="exampleInputEmail1">Status</label>
                            <select class="form-control form-control-sm" id="status" name="status" disabled>
                              <option>ENABLE</option>
                              <option>DISABLE</option>
                            </select>
                        </div>
                        <!--------->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <input type="submit" id="update" value="Save" class="btn btn-success">
                    </div>
                </div>
            </form>
            </div>
        </div>
<!-- END View TERM-->

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
                url: "{{ route('settings_term.index') }}",
                type: 'GET'
            },
        columns: [
            { data: 'DT_RowIndex'},
            { data: 'level.description'},
            { data: 'term_conditions'},
            { data: 'is_active'},
            { data: 'create_date'},
        ],
        columnDefs: [
                {
                    "targets" : 2,
                    "data": "c",
                    "render" : function (data, type, row) {//class="btn btn-primary btn-sm"
                        var btn = '<div class="ini">'+row.term_conditions+'<br><div>'
                        
                        return btn; 
                    }
                },
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
                        var btn = '<a href="/view_term/'+row.id_term_conditions+'" id="viewData" data-id="'+row.id_term_conditions+'"  data-toggle="modal" data-target="#viewTermku" class="btn btn-primary btn-sm"><i class="fa fa-info-circle nav-icon"></i></a> '+
                        '<a href="/update_term/'+row.id_term_conditions+'" id="editData" data-id="'+row.id_term_conditions+'"  data-toggle="modal" data-target="#updateTerm" class="btn btn-warning btn-sm"><i class="fa fa-edit nav-icon"></i></a>'
                        // '<a href="" id="deleteData" data-id="'+row.id_term_conditions+'" class="btn btn-danger btn-sm"><i class="fa fa-trash nav-icon"></i></a>'
                        return btn; //settings_term_conditions/'+row.id_term_conditions+'/edit
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
                url: "/settings_term/"+id+"/edit", //settings_term/'+row.id_term_conditions+'/edit
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
                        form.find('input[name=id]').val(data.id_term_conditions);
                        form.find('input[name=id_level]').val(data.id_level);
                        form.find('input[name=level_name]').val(data.level.description);
                        form.find('textarea[name=term_conditions]').val(data.term_conditions);
                        form.find('select[name=status]').val(data.is_active);
            
                        $('#updateTerm').modal('show');
                    } else {
                        // failedAlert('Not Found');
                    }
                }
            });
            return false;
        });
    // End Ajax Edit data
    
    //Start Ajax View Data
    $("body").on("click","#viewData",function(e){
            e.preventDefault();
            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
            var url = e.target;
            $.ajax(
            {
                url: "/settings_term/"+id+"/edit", //settings_term/'+row.id_term_conditions+'/edit
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
                        form.find('input[name=id]').val(data.id_term_conditions);
                        // form.find('input[name=id_level]').val(data.id_level);
                        form.find('input[name=level_name]').val(data.level.description);
                        form.find('textarea[name=term_conditions]').val(data.term_conditions);
                        form.find('select[name=status]').val(data.is_active);
            
                        $('#viewTermku').modal('show');
                    } else {
                        // failedAlert('Not Found');
                    }
                }
            });
            return false;
        });
    //End Ajax View Data
    
    // Start Ajax Update data
    $(document).on('submit', '.form-update-data', function(e){
            e.preventDefault();
            var ini = $(this),  input_token = $('input[name=_token]'),
                id = ini.find('input[name=id]').val(),
                url = '/update_term/'+id;
            var post_data = {
                is_ajax: true,
                _token: input_token.val(),
                id_level: ini.find('input[name=id_level]').val(),
                term_conditions: ini.find('textarea[name=term_conditions]').val(),
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
                    $('#updateTerm').modal('hide');
                    // initData(param)
                    // successAlert(message);
                    
                    loadData()
                    swal(
                        'Success!',
                        'Update Term Successfully!',
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
                url: "/settings_term/"+id, 
                type: 'DELETE',
                data: {
                    _token: token,
                        id: id
                },
                success: function (response){
                    $("#success").html(response.message)
                    loadData()
                    swal(
                        'Sucess!',
                        'Term Deleted Successfully!',
                        'success'
                    )
                }
            });
            return false;
        });
    // End Ajax Delete data
    });
</script>

@endsection