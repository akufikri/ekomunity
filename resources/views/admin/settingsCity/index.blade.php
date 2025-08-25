@extends('home')
@section('title-dashboard', 'Admin')
@section('title','Admin')

@section('breadcrumb')

<li class="breadcrumb-item active"><a>Data Bahagian</a></li>
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
                <h3 class="card-title text-danger my-header">Data Bahagian</h3>
                <div class="card-tools">
                    <a href="#" data-toggle="modal" data-target="#addCity" class="btn btn-sm btn-success pull-right">
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
                                    {{$message}}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm nowrap" id="datatable-crud">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>State</th>
                                        <th>City</th>
                                        <th>Description</th>
                                        <th>Latitude</th>
                                        <th>Longitude</th>
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

<!--Data Bahagian-->
<div class="modal fade" id="addCity" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="/create_city" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Data Bahagian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body my-table">
                    <div class="form-group" >
                        <label for="exampleInputEmail1">From State <span style="color: #b91c1c;">*</span></label></label>
                        <select class="form-control form-control-sm" name="id_state" id="id_state" required autofocus>
                          <option selected disabled value="">Select State</option>
                          @foreach(\App\Models\State::get() as $data)
                          <option value="{{$data->id_state}}" {{(old('id_state')==$data->id_state)? :''}}>
                            {{$data->state}}
                          </option>
                          @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="#">City Name <span style="color: #b91c1c;">*</span></label></label>
                        <input type="text" class="form-control" id="city" name="city" placeholder="City Name" required>
                    </div>
                    {{-- <div class="form-group">
                        <label for="#">Perwakilan PPK Daerah</label>
                        <input type="text" class="form-control" id="representation" name="representation" placeholder="Perwakilan PPK Daerah">
                    </div> --}}
                    {{-- <div class="form-group">
                        <label for="#">Nama Persatuan</label>
                        <input type="text" class="form-control" id="association" name="association" placeholder="Nama Persatuan">
                    </div> --}}
                    {{-- <div class="form-group">
                        <label for="#">Description 1</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Description 1">
                    </div>
                    <div class="form-group">
                        <label for="#">Description 2</label>
                        <input type="text" class="form-control" id="description2" name="description2" placeholder="Description 2">
                    </div> --}}
                    {{-- <div class="form-group">
                        <label for="#">No. Telefon</label>
                        <input type="number" class="form-control" id="phone_number" name="phone_number" placeholder="No. Telefon">
                    </div> --}}
                    <div class="form-group">
                        <label for="#">Pin Location <span style="color: #b91c1c;">*</span></label></label>
                        <button type="button" class="form-control btn btn-sm btn-info" onclick="loadMap()">Click here to open the map</button>
                    </div>
                    <div class="form-group">
                        <label for="#">Latitude <span style="color: #b91c1c;">*</span></label></label>
                        <input type="text" class="form-control place-latitude" id="place_latitude" name="place_latitude" placeholder="Latitude" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="#">Longitude <span style="color: #b91c1c;">*</span></label></label>
                        <input type="text" class="form-control place-longitude" id="place_longitude" name="place_longitude" placeholder="Longitude" readonly required>
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
<!--END Data Bahagian-->

<!--UPDATE CITY-->
<div class="modal fade" id="updateCity" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="" method="POST" class="form-update-data" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Data Bahagian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body my-table">
                    <div class="form-group" >
                        <input type="hidden" id="id_city" name="id_city">
                        <label for="exampleInputEmail1">From State <span style="color: #b91c1c;">*</span></label></label>
                        <select class="form-control form-control-sm" name="id_state" id="id_state" required autofocus>
                          <option selected disabled value="">Select State</option>
                          @foreach(\App\Models\State::get() as $data)
                          <option value="{{$data->id_state}}" {{(old('id_state')==$data->id_state)? :''}}>
                            {{$data->state}}
                          </option>
                          @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="#">City Name <span style="color: #b91c1c;">*</span></label></label>
                        <input type="text" class="form-control" id="city" name="city" placeholder="City Name" required>
                    </div>
                    {{-- <div class="form-group">
                        <label for="#">Perwakilan PPK Daerah</label>
                        <input type="text" class="form-control" id="representation" name="representation" placeholder="Perwakilan PPK Daerah">
                    </div>
                    <div class="form-group">
                        <label for="#">Nama Persatuan</label>
                        <input type="text" class="form-control" id="association" name="association" placeholder="Nama Persatuan">
                    </div>
                    <div class="form-group">
                        <label for="#">Description 1</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Description">
                    </div>
                    <div class="form-group">
                        <label for="#">Description 2</label>
                        <input type="text" class="form-control" id="description2" name="description2" placeholder="Description 2">
                    </div>
                    <div class="form-group">
                        <label for="#">No. Telefon</label>
                        <input type="number" class="form-control" id="phone_number" name="phone_number" placeholder="No. Telefon">
                    </div> --}}
                    <div class="form-group">
                        <label for="#">Pin Location <span style="color: #b91c1c;">*</span></label></label>
                        <button type="button" class="form-control btn btn-sm btn-info" onclick="loadMap()">Click here to open the map</button>
                    </div>
                    <div class="form-group">
                        <label for="#">Latitude <span style="color: #b91c1c;">*</span></label></label>
                        <input type="text" class="form-control place-latitude" id="place_latitude" name="place_latitude" placeholder="Latitude" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="#">Longitude <span style="color: #b91c1c;">*</span></label></label>
                        <input type="text" class="form-control place-longitude" id="place_longitude" name="place_longitude" placeholder="Longitude" readonly required>
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
                    <input type="submit" value="Save" class="btn btn-sm btn-success">
                </div>
            </div>
        </form>
    </div>
</div>
<!--END UPDATE CITY-->

<!--DETAIL CITY-->
<div class="modal fade" id="detailCity" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="" method="POST" class="form-update-data" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Data Bahagian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body my-table">
                    <div class="form-group" >
                        <label for="exampleInputEmail1">From State</label>
                        <select class="form-control form-control-sm" name="id_state" id="id_state" required disabled>
                          <option selected disabled value="">Select State</option>
                          @foreach(\App\Models\State::get() as $data)
                          <option value="{{$data->id_state}}" {{(old('id_state')==$data->id_state)? :''}}>
                            {{$data->state}}
                          </option>
                          @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="#">City Name</label>
                        <input type="text" class="form-control" id="city" name="city" placeholder="City Name" readonly>
                    </div>
                    {{-- <div class="form-group">
                        <label for="#">Perwakilan PPK Daerah</label>
                        <input type="text" class="form-control" id="representation" name="representation" placeholder="Perwakilan PPK Daerah" readonly>
                    </div>
                    <div class="form-group">
                        <label for="#">Nama Persatuan</label>
                        <input type="text" class="form-control" id="association" name="association" placeholder="Nama Persatuan" readonly>
                    </div>
                    <div class="form-group">
                        <label for="#">Description 1</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Description" readonly>
                    </div>
                    <div class="form-group">
                        <label for="#">Description 2</label>
                        <input type="text" class="form-control" id="description2" name="description2" placeholder="Description 2" readonly>
                    </div>
                    <div class="form-group">
                        <label for="#">No. Telefon</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="No. Telefon" readonly>
                    </div> --}}
                    <div class="form-group">
                        <label for="#">Latitude</label>
                        <input type="text" class="form-control place-latitude" id="place_latitude" name="place_latitude" placeholder="Latitude" readonly>
                    </div>
                    <div class="form-group">
                        <label for="#">Longitude</label>
                        <input type="text" class="form-control place-longitude" id="place_longitude" name="place_longitude" placeholder="Longitude" readonly>
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
<!--END DETAIL CITY-->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script src="//code.jquery.com/jquery-2.0.0.js"></script>
<script src="/js/jquery.validate.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $.ajaxSetup({
            headers:{
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
            ajax:{
                url: "{{ route('settings_city.index') }}",
                type: 'GET'
            },
            columns: [
                { data: 'DT_RowIndex'},
                { data: 'state_name'},
                { data: 'city_name'},
                { data: 'description'},
                { data: 'latitude'},
                { data: 'longitude'},
                { data: 'is_active'},
                { data: 'create_date'},
                { data: '', className: 'text-center'},
            ],
            columnDefs: [
                {
                    "targets" : 6,
                    "data": "is_active",
                    "render" : function (data, type, row) {//class="btn btn-primary btn-sm"
                        var btn = row.is_active == "ENABLE" ? '<div><button class=" btn btn-sm btn-success" style="width:100%">Enable</button></div>' : '<div><button class="btn btn-sm btn-danger" style="width:100%">Disable</button></div>'
                        // '<a href="" id="deleteData" data-id="'+row.id_position+'" class="btn btn-danger btn-sm"><i class="fa fa-trash nav-icon"></i></a>'
                        return btn; //settings_position/'+row.id_position+'/edit
                    }
                },
                {
                   "targets": 8,
                   "data": "",
                   "render": function(data, type, row){
                       var btn = '<a href="#" id="detailData" data-id="'+row.id_city+'" data-toggle="modal" data-target="#detailCity" class="btn btn-primary btn-sm"><i class="fa fa-info-circle nav-icon"></i></a>'+
                       '<a href="#" data-toggle="modal" id="editData" data-id="'+row.id_city+'" data-target="#updateCity" class="btn btn-warning btn-sm"><i class="fa fa-edit nav-icon"></i></a>'
                       
                       return btn;
                   }
                },
            ],
            order:[[0, 'asc']]
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
                url: "/settings_city/"+id+"/edit",
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
                        form.find('input[name=id_city]').val(data.id_city);
                        form.find('select[name=id_state]').val(data.id_state);
                        form.find('input[name=city]').val(data.city);
                        form.find('input[name=representation]').val(data.representation);
                        form.find('input[name=association]').val(data.association);
                        form.find('input[name=description]').val(data.description);
                        form.find('input[name=description2]').val(data.description2);
                        form.find('input[name=phone_number]').val(data.phone_number);
                        form.find('input[name=place_latitude]').val(data.latitude);
                        form.find('input[name=place_longitude]').val(data.longitude);
                        form.find('select[name=status]').val(data.is_active);
            
                        $('#updateCity').modal('show');
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
                url: "/settings_city/"+id+"/edit",
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
                        form.find('select[name=id_state]').val(data.id_state);
                        form.find('input[name=city]').val(data.city);
                        form.find('input[name=representation]').val(data.representation);
                        form.find('input[name=association]').val(data.association);
                        form.find('input[name=description]').val(data.description);
                        form.find('input[name=description2]').val(data.description2);
                        form.find('input[name=phone_number]').val(data.phone_number);
                        form.find('input[name=place_latitude]').val(data.latitude);
                        form.find('input[name=place_longitude]').val(data.longitude);
                        form.find('select[name=status]').val(data.is_active);
            
                        $('#detailCity').modal('show');
                    } else {
                        // failedAlert('Not Found');
                    }
                }
            });
            return false;
        });
    // End Ajax Detail data
        
    // Start Ajax Update data
    $(document).on('submit', '.form-update-data', function(e){
            e.preventDefault();
            var ini = $(this),  input_token = $('input[name=_token]'),
                id = ini.find('input[name=id_city]').val(),
                url = '/update_city/'+id;
            var post_data = {
                is_ajax: true,
                _token: input_token.val(),
                id_state: ini.find('select[name=id_state]').val(),
                city: ini.find('input[name=city]').val(),
                representation: ini.find('input[name=representation]').val(),
                association: ini.find('input[name=association]').val(),
                description: ini.find('input[name=description]').val(),
                description2: ini.find('input[name=description2]').val(),
                phone_number: ini.find('input[name=phone_number]').val(),
                place_latitude: ini.find('input[name=place_latitude]').val(),
                place_longitude: ini.find('input[name=place_longitude]').val(),
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
                    $('#updateCity').modal('hide');
                    // initData(param)
                    // successAlert(message);
                    
                    loadData()
                    Swal.fire({
                        icon: "success",
                        title: 'Success!',
                        text: "Update City Successfully!",
                        showConfirmButton: true,
                    });
                    
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
@include('employee.register.mapbox')
@endsection