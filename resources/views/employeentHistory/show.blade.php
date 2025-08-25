@extends('home')
@section('title-dashboard', 'Ahli')
@section('title','Maklumat Pendidikan')

@section('breadcrumb')

<li class="breadcrumb-item active">Maklumat Pendidikan</li>

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
                <h3 class="card-title my-header text-danger">Maklumat Pendidikan</h3>
                <div class="card-tools">
                    <a href="{{URL::to('editMaklumatPendidikan/'.Auth::user()->id)}}" title="Edit" class="btn btn-sm btn-warning" title="Edit" >Edit</a>
                </div>
            </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            @endif
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Taraf Pendidikan</label><br>
                                <label class="filldata" for="" id="label_form">{{isset($data->manpower->status_education->status_education)?$data->manpower->status_education->status_education:"Data has not been filled"}}</label>
                            </div>
                            <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Bidang</label><br>
                                <label class="filldata" for="" id="label_form">{{isset($data->manpower->education_field)?$data->manpower->study->study:"Data has not been filled"}}</label>
                            </div>
                        </div>
                        
                        <?php
                            $skills_certificate = json_decode($data->manpower->skills_certificate);
                            $skills_certificate_year = json_decode($data->manpower->skills_certificate_year);
                        ?>
                        
                        @if(isset($skills_certificate))
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Sijil kemahiran</label><br>
                            </div>
                            
                            <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Tahun</label><br>
                            </div>
                            
                        </div>
                        
                        @foreach($skills_certificate as $i => $value)
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="filldata" for="" id="label_form">{{$value}}</label>
                            </div>
                            
                            <div class="col-lg-6">
                                <label class="filldata" for="" id="label_form">{{$skills_certificate_year[$i]}}</label>
                            </div>
                            
                        </div>
                        @endforeach

                        @endif
            
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="ShowEmployHisModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Employment History</h4>
                <button type="button" class="close modelClose" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                    <strong>Success!</strong>Employment History Updated successfully.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="ShowEmployHisModalBody">
                    
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>


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
                    url: "/getData",
                    type: 'GET'
                },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'company', name: 'company' },
                { data: 'position', name: 'position' },
                { data: 'segment', name: 'segment' },
                { data: 'from_date', name: 'from_date' },
                { data: 'to_date', name: 'to_date' },
                { data: 'certificate', className: 'text-center' },
            ],
            "columnDefs" : [
                    {
                    "targets" : 6 ,
                    "data": "certificate",
                    "render" : function (data, type, row) {
                           return '<a href="/EMPLOY/'+row.certificate+'" title="Attachment" class="btn-edit-data btn btn-sm btn-primary" target="_blank">' +
                                    '<i class="fas fa-file-download fa-lg" width="50%"></i>' + 
                                  '</a>';
                        }
                    },
                    {
                        "targets" : 7,
                        "data": "Actions",
                        "render" : function (data, type, row) {
                            // '<button type="button" class="btn btn-info btn-sm" title="Detail" id="getShowEmployHisData" data-id="'+row.id_employment_history+'"><i class="fas fa-info-circle"></i></i></button>'+
                           return '<a href="/employmentDetail/employment_history/'+row.id_employment_history+'/edit" title="Edit" class="btn btn-warning btn-sm"><i class="fas fa-user-edit"></i></button></a>'+
                                  '<button type="button" data-id="'+row.id_employment_history+'" title="Delete" class="btn btn-danger btn-sm" id="getDeleteId"><i class="fas fa-trash"></i></button>';
                        }
                    }
                ],
            order: [[0, 'asc']]
        });
    }
    
    $('.modelClose').on('click', function(){
        $('#ShowEmployHisModal').hide();
    });
    var id;
        $('body').on('click', '#getShowEmployHisData', function(e) {
            // e.preventDefault();
            $('.alert-danger').html('');
            $('.alert-danger').hide();
            id = $(this).data('id');
            $.ajax({
                url: "/employmentDetail/employment_history/"+id,
                method: 'GET',
                scrollY: false,
                success: function(result) {
                    console.log(result);
                    $('#ShowEmployHisModalBody').html(result.html);
                    $('#ShowEmployHisModal').show();
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
                url: "/employmentDetail/employment_history/"+id, 
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
                        'Employment History Deleted Successfully!',
                        'success'
                    )
                }
            });
            return false;
        });
    });    
</script>

@endsection

