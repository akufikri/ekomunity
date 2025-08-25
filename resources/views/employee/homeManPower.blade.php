@extends('home')
@section('title-dashboard', 'Manpower')

@section('title','Personal Detail Manpower')

@section('breadcrumb')
<li class="breadcrumb-item active">Utama</li>
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

<div class="row">

    <div class="col-12">
        <div class="card card-danger card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title text-danger my-header">Maklumat Peribadi</h3>
                {{-- <div class="card-tools">
                    <a href="{{URL::to('personalDetail/'.Auth::user()->id.'/edit')}}" title="Edit" class="btn btn-sm btn-warning" title="Edit" >Edit</a>
                </div> --}}
            </div>
            
            @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                            {{ $message }}
                            <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                    </div>
            @endif
            
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Gambar Profile</label><br>
                                <img src="/Profil/{{ $data->photo }}" alt="Upload Photo" width="100" height="100">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Nama Penuh</label><br>
                                <label class="filldata" for="" id="label_form">{{$data->fullname}}</label>
                            </div>
                            <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Persatuan Dimasuki</label><br>
                                @foreach($joinCompany as $d)
                                <img src="/CompanyLogo/{{ isset($d->company->logo_picture) ? $d->company->logo_picture : 'user.png' }}" style="min-height:50px; max-height:50px" width="50px" height="50px" alt="{{ isset($d->company->full_company_name) ? $d->company->full_company_name : '-' }}" title="{{ isset($d->company->full_company_name) ? $d->company->full_company_name : '-' }}">
                                @endforeach
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Nomor Telefon</label><br>
                                <label class="filldata" for="" id="label_form">{{isset($data->phone_number)?$data->phone_number:"Data has not been filled"}}</label>
                            </div>
                            <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Emel</label><br>
                                <label class="filldata" for="" id="label_form">{{isset($data->email)?$data->email:"Data has not been filled"}}</label>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">No Kad Pengenalan</label><br>
                                <label class="filldata" for="" id="label_form">{{isset($data->manpower->ic_number)?$data->manpower->ic_number:"Data has not been filled"}}</label>
                            </div>
                            <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Bangsa</label><br>
                                <label class="filldata" for="" id="label_form">{{isset($data->manpower->nation->nation)?$data->manpower->nation->nation:"Data has not been filled"}}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Agama</label><br>
                                <label class="filldata" for="" id="label_form">{{isset($data->manpower->religion->religion)?$data->manpower->religion->religion:"Data has not been filled"}}</label>
                            </div>
                            <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Status Bumiputera</label><br>
                                <label class="filldata" for="" id="label_form">{{isset($data->manpower->native_status)?$data->manpower->status_native->status_native:"Data has not been filled"}}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Jantina</label><br>
                                <label class="filldata" for="" id="label_form">{{isset($data->manpower->gender) ? $data->manpower->gender_text->gender:"Data has not been filled"}}</label>
                            </div>
                            <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Alamat Perhubungan</label><br>
                                <label class="filldata" for="" id="label_form">{{isset($data->manpower->address)?$data->manpower->address:"Data has not been filled"}}</label>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Daerah/Bandar</label><br>
                                <label class="filldata" for="" id="label_form">{{isset($data->manpower->city->city)?$data->manpower->city->city:"Data has not been filled"}}</label>
                            </div>
                            <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Negeri</label><br>
                                <label class="filldata" for="" id="label_form">{{isset($data->manpower->state->state)?$data->manpower->state->state:"Data has not been filled"}}</label>
                            </div>
                            
                        </div>
    
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Poskod</label><br>
                                <label class="filldata" for="" id="label_form">{{isset($data->manpower->postcode)?$data->manpower->postcode:"Data has not been filled"}}</label>
                            </div>
                            
                        </div>
                        
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card card-danger card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title my-header text-danger">Maklumat Pendidikan</h3>
                {{-- <div class="card-tools">
                    <a href="{{URL::to('editMaklumatPendidikan/'.Auth::user()->id)}}" title="Edit" class="btn btn-sm btn-warning" title="Edit" >Edit</a>
                </div> --}}
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
                                <label class="filldata" for="" id="label_form">{{isset($data->manpower->status_education->status_education)?$data->manpower->status_education->status_education:""}}</label>
                            </div>
                            <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Bidang</label><br>
                                <label class="filldata" for="" id="label_form">{{isset($data->manpower->education_field)?$data->manpower->education_field:""}}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="filldata text-muted font-italic label_form_judul" style="margin-bottom: 0px;" for="">Sijil kemahiran/Kursus Perniagaan Tambahan</label><br>
                                <label class="filldata" for="" id="label_form">{{isset($data->manpower->skills_certificate)?$data->manpower->skills_certificate:"Data has not been filled"}}</label>
                            </div>
                            
                        </div>
            
                    </div>

                </div>
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
    
        loadData1()
    });
    
    function loadData1(){
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
                           return '<a href="/EMPLOY/'+row.certificate+'" class="btn-edit-data btn btn-sm btn-primary">' +
                                    '<i class="fas fa-file-download fa-lg" width="50%"></i>' + 
                                  '</a>';
                        }
                    },
                  
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
    
   
</script>


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
                          return '<a href="/SUMMARY/'+row.certificate+'" class="btn-edit-data btn btn-sm btn-primary">' +
                                    '<i class="fas fa-file-download fa-lg" width="50%"></i>' + 
                                  '</a>';
                        }
                    },
                   
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
    
       
</script>

<div class="modal" id="ShowModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Other Qualification</h4>
                <button type="button" class="close modelClose" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="ShowModalBody3">
                    
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
    
        loadData2()
    });
    
    function loadData2(){
        $('#datatable-crud4').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            scrollX: true,
            
            ajax: {
                    url: "{{ route('othQualification.index') }}",
                    type: 'GET'
                },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'organizer', name: 'organizer' },
                { data: 'qualification', name: 'qualification' },
                { data: 'other_date', name: 'other_date' },
                { data: 'certificate', className: 'text-center' },
            ],
            "columnDefs" : [
                    {
                    "targets" : 4 ,
                    "data": "certificate",
                    "render" : function (data, type, row) {
                          return '<a href="/SUMMARY/'+row.certificate+'" class="btn-edit-data btn btn-sm btn-primary">' +
                                    '<i class="fas fa-file-download fa-lg" width="50%"></i>' + 
                                  '</a>';
                        }
                    },
                   
                ],
            order: [[0, 'asc']]
        });
    }
    
    $('.modelClose').on('click', function(){
        $('#ShowModal3').hide();
    });
    var id;
        $('body').on('click', '#getShowData3', function(e) {
            $('.alert-danger').html('');
            $('.alert-danger').hide();
            id = $(this).data('id');
            $.ajax({
                url: "/otherQualification/"+id,
                method: 'GET',
                scrollY: false,
                success: function(result) {
                    console.log(result);
                    $('#ShowModalBody3').html(result.html);
                    $('#ShowModal3').show();
                }
            });
        });
     
</script>
@endsection