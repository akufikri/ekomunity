@extends('home')
@section('title-dashboard', 'Company')
@section('content')

@section('breadcrumb')

<li class="breadcrumb-item active"><a>Maklumat Jawatankuasa</a></li>
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

<div class="row" id="view">

    <input type="text" name="auth_user" value="{{Auth::user()->sub_company}}" hidden>
    <div class="col-12">
        <div class="card card-danger card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title text-danger my-header">Maklumat Jawatankuasa</h3>
                @if(Auth::user()->sub_company == null)
                <div class="card-tools">
                    <a href="#" data-toggle="modal" title="Add" data-target="#addShareholders"  class="btn btn-sm btn-success pull-right">
                        <i class="fa fa-plus nav-icon"></i>
                        &nbsp; Add
                    </a>
                </div>
                @endif
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
                                        <th>Jawatan </th>
                                        <th>Nama </th>
                                        <th>Email </th>
                                        <th>Tarikh Lantikan</th>
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

        <!--ADD NEW SHAREHOLDERS-->
        <div class="modal fade" id="addShareholders" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Jawatankuasa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body my-table">
                        <!-------->
                        <form action="{{URL::to('/maklumatJawatanKuasa/store')}}#view" method="POST" enctype="multipart/form-data">
                          @csrf
                          <div class="form-group">
                            <label for="exampleInputEmail1">Jawatan</label>
                            <select class="form-control form-control-sm" name="id_position" id="id_position" required autofocus>
                              <option selected disabled value="">Pilih Jawatan</option>
                              @foreach($position as $data)
                              <option value="{{$data->id_position}}" {{(old('id_position')==$data->id_position)? '':''}}>
                                {{$data->position}}
                              </option>
                              @endforeach
                            </select>
                          </div>
                          
                          <div class="form-group">
                            <label for="exampleInputEmail1">Nama</label>
                            <select class="form-control form-control-sm" name="id_user" id="id_user" required autofocus>
                              <option selected disabled value="">Pilih Nama</option>
                              @foreach($ahli as $data)
                              <option value="{{$data->manpower->user->id}}">
                                {{$data->manpower->user->fullname}}
                              </option>
                              @endforeach
                            </select>
                          </div>
                          
                          <div class="form-group">
                            <label for="exampleInputEmail1">Tarikh Lantikan</label>
                            <div class="input-group">
                              <input type="datetime-local" name ="date_appointment" id="date_appointment" class="form-control" required>
                            </div>
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
                        <h5 class="modal-title" id="exampleModalLabel">Update Jawatankuasa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body my-table">
                        <!-------->
                        <form action="{{URL::to('/shareholders')}}#view" class="form-update-data" method="POST" enctype="multipart/form-data">
                          @csrf
                          <div class="form-group">
                            <label for="exampleInputEmail1">Jawatan</label>
                            <input type="hidden" name ="id" id="id" class="form-control" required>
                            <select class="form-control form-control-sm" name="id_position" id="id_position" required autofocus>
                              <option selected disabled value="">Pilih Jawatan</option>
                              @foreach($position as $data)
                              <option value="{{$data->id_position}}" {{(old('id_position')==$data->id_position)? '':''}}>
                                {{$data->position}}
                              </option>
                              @endforeach
                            </select>
                          </div>
                          
                          <div class="form-group">
                            <label for="exampleInputEmail1">Nama</label>
                            <select class="form-control form-control-sm" name="id_user" id="id_user" required autofocus>
                              <option selected disabled value="">Pilih Nama</option>
                              @foreach($ahli as $data)
                              <option value="{{$data->manpower->user->id}}"}}>
                                {{$data->manpower->user->fullname}}
                              </option>
                              @endforeach
                            </select>
                          </div>
                          
                          <div class="form-group">
                            <label for="exampleInputEmail1">Tarikh Lahir</label>
                            <div class="input-group">
                              <input type="datetime-local" name ="date_appointment" id="date_appointment" class="form-control" required>
                            </div>
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

        var auth_user = $('input[name=auth_user]').val();

    $('#datatable-crud').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        scrollX: true,
        ajax: {
                url: "/maklumatJawatanKuasa",
                type: 'GET'
            },
        columns: [
            
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'position.position' },
            { data: 'user.fullname' },
            { data: 'user.email' },
            { data: 'date_appointment' },
            { data: 'date_create' },
        ],
        columnDefs: [
                {
                    "targets" : 6,
                    "visible" : auth_user != "" ? false : true,
                    "data": "id_company_shareholders",
                    "render" : function (data, type, row) {//class="btn btn-primary btn-sm"
                        var btn = //'<a href="/learn/detail/'+row.id_company_shareholders+'" data-toggle="modal" data-target="#addPosition" class="btn btn-primary btn-sm"><i class="fa fa-info-circle nav-icon"></i></a>'+
                        '<a href="/update_position/'+row.id_company_shareholders+'" id="editData" data-id="'+row.id_manpower_position+'"  data-toggle="modal" data-target="#updateShareholders" class="btn btn-warning btn-sm" ><i class="fa fa-edit nav-icon"></i></a> '+
                        '<a href="" id="deleteData" data-id="'+row.id_manpower_position+'" class="btn btn-danger btn-sm"><i class="fa fa-trash nav-icon"></i></a>'
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
                url: "{{ route('company.viewShareholdersTemp') }}#view",
                type: 'GET'
            },
        columns: [
            
            { data: 'DT_RowIndex' },
            { data: 'name' },
            { data: 'number_id' },
            { data: 'total' },
            { data: 'percentage'},
            { data: 'position_user' },
            { data: 'status' },
            { data: 'create_date' },
            { data: 'action' },
            { data: '' , className: 'text-center' },
        ],
        columnDefs: [
                {
                    "targets" : 9,
                    "data": "id_company_shareholders",
                    "render" : function (data, type, row) {//class="btn btn-primary btn-sm"
                        var btn = //'<a href="/learn/detail/'+row.id_company_shareholders+'" data-toggle="modal" data-target="#addPosition" class="btn btn-primary btn-sm"><i class="fa fa-info-circle nav-icon"></i></a>'+
                        '<a href="" id="deleteDataTemp" data-id="'+row.id_temp_company_shareholders+'" class="btn btn-danger btn-sm" ><i class="fa fa-trash nav-icon"></i></a>'
                        return btn; //settings_position/'+row.id_position+'/edit
                    }
                },
            ],
        order: [[0, 'asc']]
    });
    
    }


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
                url: "/maklumatJawatanKuasa/edit/"+id, //settings_position/'+row.id_position+'/edit
                type: 'GET',
                data: {},
                success: function (response){
                    $("#success").html(response.message)

                    if (response.data != null) {
                        data = response.data
                        var form = $('.form-update-data');
                        form.find('input[name=id]').val(data.id_manpower_position);
                        form.find('select[name=id_position]').val(data.id_position);
                        form.find('select[name=id_user]').val(data.id_user);
                        form.find('input[name=date_appointment]').val(data.date_appointment);
            
                        $('#updateShareholders').modal('show');
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
                url = '/maklumatJawatanKuasa/update/'+id+'#view';
            var post_data = {
                is_ajax: true,
                _token: input_token.val(),
                
                id_position:ini.find('select[name=id_position]').val(),
                id_user:ini.find('select[name=id_user]').val(),
                date_appointment:ini.find('input[name=date_appointment]').val(),
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
                input_token.val(result.newToken);
                if (result.data != null) {
                    $('#updateShareholders').modal('hide');
                    // initData(param)
                    // successAlert(message);
                    
                    loadData()
                    // loadDataTemp()
                    // location.href = "maklumatJawatanKuasa"
                    swal(
                        'Success!',
                        result.success,
                        'success'
                    )
                    
                } else {
                    // failedAlert(message);
                }
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
                url: "/maklumatJawatanKuasa/delete/"+id+'#view', 
                type: 'POST',
                data: {
                    _token: token,
                        id: id
                },
                success: function (response){
                    $("#success").html(response.message)
                    loadData()
                    loadDataTemp()
                    // location.href = "companyListofShareholders"
                    swal(
                        'Success!',
                        'Jawatankuasa Deleted Successfully!',
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
                url: "/deleteTempCompanyShareholders/"+id+'#view', 
                type: 'DELETE',
                data: {
                    _token: token,
                        id: id
                },
                success: function (response){
                    $("#success").html(response.message)
                    loadData()
                    loadDataTemp()
                    location.href = "companyListofShareholders"
                    swal(
                        'Success!',
                        'Temp Shareholders Deleted Successfully!',
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

