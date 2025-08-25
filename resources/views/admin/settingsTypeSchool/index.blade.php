@extends('home')
@section('title-dashboard', 'Admin')
@section('title', 'Admin')

@section('breadcrumb')

<li class="breadcrumb-item active">Settings Type School</li>

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
        <div class="card card-primary card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title text-primary my-header">Setting Type School</h3>
                <div class="card-tools">
                    <a href="#" data-toggle="modal" data-target="#addTypeSchool" class="btn btn-sm btn-success pull-right">
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
                                        <th>Type School</th>
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

<!--ADD Type School-->
<div class="modal fade" id="addTypeSchool" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{route('settings_schooltype.create')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add State</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body my-table">
                    <div class="form-group">
                        <label for="#">Type School</label>
                        <input type="text" class="form-control" id="type_school" name="type_school" placeholder="Type School" required>
                    </div>
                    <div class="form-group">
                        <label for="#">Description</label>
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
<!--END ADD Type School-->

<div class="modal" id="ShowTypeSchoolModal">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Type School</h4>
                <button type="button" class="close modelClose" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="ShowTypeSchoolModalBody">
                    
                </div>
            </div>
            
        </div>
    </div>
</div>

<div class="modal" id="EditTypeSchoolModal">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Type School Edit</h4>
                <button type="button" class="close modelClose" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body my-table">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                    <strong>Success!</strong>Type School was Updated successfully.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="EditTypeSchoolModalBody">
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-dark modelClose" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-sm btn-success" id="SubmitEditTypeSchoolForm">Update</button>
            </div>
        </div>
    </div>
</div>

<script src="//code.jquery.com/jquery-2.0.0.js"></script>
<script src="/js/jquery.validate.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
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
                url: "{{ route('settings_schooltype.index') }}",
                type: 'GET'
            },
            columns: [
                { data: 'DT_RowIndex' },
                { data: 'type_school' },
                { data: 'description' },
                { data: 'is_active' },
                { data: 'create_date' },
                { data: '', className: 'text-center' },
            ],
            columnDefs: [
                {
                    "targets" : 5,
                    "data" : "c",
                    "render": function(data, type, row){
                    var btn = '<button type="button" class="btn btn-primary btn-sm" id="getShowTypeSchoolData" data-id="'+row.id_type_school+'"><i class="fas fa-info-circle"></i></i></button>'+
                            '<button type="button" class="btn btn-warning btn-sm" id="getEditTypeSchoolData" data-id="'+row.id_type_school+'"><i class="fa fa-edit nav-icon"></button>'
                
                    return btn;
                    }
                },
            ],
            order: [[0, 'asc']]
        });
        
        $('#SubmitEditTypeSchoolForm').click(function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "list_setting_schoolType/"+id,
                method: 'PUT',
                data: {
                    type_school: $('#showTypeSchool').val(),
                    description: $('#showDescription').val(),
                    is_active: $('#showStatus').val(),
                },
                success: function(result) {
                    if(result.errors) {
                        $('.alert-danger').html('');
                        $.each(result.errors, function(key, value) {
                            $('.alert-danger').show();
                            $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                        });
                    } else {
                        $('.alert-danger').hide();
                        $('.alert-success').show();
                        $('#datatable-crud').DataTable().ajax.reload();
                    }
                }
            });
        });
    }
    
    $('.modelClose').on('click', function(){
            $('#ShowTypeSchoolModal').hide();
        });
        var id;
        $('body').on('click', '#getShowTypeSchoolData', function(e) {
    
            $('.alert-danger').html('');
            $('.alert-danger').hide();
            id = $(this).data('id');
            $.ajax({
                url: "list_setting_schoolType/"+id,
                method: 'GET',
                
                success: function(result) {
                    console.log(result);
                    $('#ShowTypeSchoolModalBody').html(result.html);
                    $('#ShowTypeSchoolModal').show();
                }
            });
        });
        
    $('.modelClose').on('click', function(){
            $('#EditTypeSchoolModal').hide();
        });
        var id;
        $('body').on('click', '#getEditTypeSchoolData', function(e) {
    
            $('.alert-danger').html('');
            $('.alert-danger').hide();
            id = $(this).data('id');
            $.ajax({
                url: "list_setting_schoolType/"+id+"/edit",
                method: 'GET',
                
                success: function(result) {
                    console.log(result);
                    $('#EditTypeSchoolModalBody').html(result.html);
                    $('#EditTypeSchoolModal').show();
                }
            });
        });
    
</script>

@endsection

