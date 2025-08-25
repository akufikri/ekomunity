@extends('home')
@section('title-dashboard', 'Manpower')

@section('breadcrumb')
    <li class="breadcrumb-item active">Summary Qualification</li>
@endsection

@section('content')

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

@include('employee.redbar.function_summary_qualification')
<div class="row">
    <div class="col-12">
        <div class="card card-primary card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title my-header text-primary">Summary Qualification</h3>
                <div class="card-tools">
                    <a href="{{URL::to('/summaryQualification/create')}}" title="Add" class="btn btn-sm btn-success pull-right">
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
                            <table class="table table-bordered table-sm nowrap" id="datatable-crud2">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Institute/University</th>
                                        <th>Qualification</th>
                                        <th>Field of Study</th>
                                        <th>Graduation Date</th>
                                        <th>Attachment</th>
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

<div class="modal" id="ShowModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Summary Qualification</h4>
                <button type="button" class="close modelClose" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                    <strong>Success!</strong>Summary Qualification Updated successfully.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="ShowModalBody2">
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger modelClose" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="//code.jquery.com/jquery-2.0.0.js"></script>
<script src="/js/jquery.validate.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

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
        $('#datatable-crud2').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            scrollX: true,
            
            ajax: {
                    url: "{{ route('sumQualification.index') }}",
                    type: 'GET'
                },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'school', name: 'school' },
                { data: 'qualification', name: 'qualification' },
                { data: 'study', name: 'study' },
                { data: 'graduation_date', name: 'graduation_date' },
                { data: 'certificate', className: 'text-center' },
            ],
            "columnDefs" : [
                    {
                    "targets" : 5 ,
                    "data": "certificate",
                    "render" : function (data, type, row) {
                          return '<a href="/SUMMARY/'+row.certificate+'" title="Attachment" target="_blank" class="btn-edit-data btn btn-sm btn-primary">' +
                                    '<i class="fas fa-file-download fa-lg" width="50%"></i>' + 
                                  '</a>';
                        }
                    },
                     {
                        "targets" : 6,
                        "data": "Actions",
                        "render" : function (data, type, row) {
                            //  '<button type="button" class="btn btn-info btn-sm" id="getShowData3" title="Detail" data-id="'+row.id_summary_qualification+'"><i class="fas fa-info-circle"></i></i></button>'+
                                 return '<a href="/summaryQualification/'+row.id_summary_qualification+'/edit" title="Edit" class="btn btn-warning btn-sm"><i class="fas fa-user-edit"></i></button></a>'+
                                  '<button type="button" data-id="'+row.id_summary_qualification+'" title="Delete" class="btn btn-danger btn-sm" id="getDeleteId"><i class="fas fa-trash"></i></button>';
                        }
                    }
                   
                ],
            order: [[0, 'asc']]
        });
    }
    
    $('.modelClose').on('click', function(){
        $('#ShowModal2').hide();
    });
    var id;
        $('body').on('click', '#getShowData', function(e) {
            $('.alert-danger').html('');
            $('.alert-danger').hide();
            id = $(this).data('id');
            $.ajax({
                url: "/summaryQualification/"+id,
                method: 'GET',
                scrollY: false,
                success: function(result) {
                    console.log(result);
                    $('#ShowModalBody2').html(result.html);
                    $('#ShowModal2').show();
                }
            });
        });
        $(document).ready(function () {

        $("body").on("click","#getDeleteId",function(e){
            if(!confirm("Do you really want to do this?")) {
                return false;
            }
            e.preventDefault();
            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
            var url = e.target;
            $.ajax(
            {
                url: "/summaryQualification/"+id, 
                type: 'DELETE',
                data: {
                    _token: token,
                        id: id
                },
                success: function (response){
                    $("#success").html(response.message)
                    loadData()
                    swal(
                        'Success!',
                        'Summary Qualification Deleted Successfully!',
                        'success'
                    )
                }
            });
            return false;
        });
    }); 
    
       
</script>
@endsection