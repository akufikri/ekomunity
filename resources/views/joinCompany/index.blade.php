@extends('home')
@section('title-dashboard', 'Log Pendaftar Persatuan')
@section('content')

@section('breadcrumb')

<li class="breadcrumb-item active"><a>Log Pendaftar Persatuan</a></li>
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
<style>

    body{
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    
    .img-circle {
        border-radius: 50%;
    }

    .cardnew{
        border-radius: 20px;
        top: 20%;
        text-align: left;
        left: 30%;
        margin-top: 20px;
        background: white;
        width: 580px;
        height: 530px;
        padding: 30px;
    }

    .sub-cardnew{
        box-shadow: .5px .5px lightgray;
        border-radius: 15px;
        height: 30px;
        width: 98%;
        padding-left: 5px;
        padding-right: 5px;
        margin-left: 20px;
        margin-right: 10px;
        margin-top: 15px;
        border:.1px solid rgb(202, 202, 202);
    }

    .fl{
        float: left;
    }

    .fr{
        float: right;
    }

    .ml-10{
        margin-left:10px;
    }

    .ml-20{
        margin-left:20px;
    }

    .mt-5{
        margin-top:5px;
    }

    .mt-10{
        margin-top:10px;
    }

    .mt-20{
        margin-top:20px;
    }

    .mt-30{
        margin-top:30px;
    }

    .mt-40{
        margin-top:40px;
    }

    .mt-50{
        margin-top:50px;
    }
</style>

<div class="row" id="view">
    <input type="hidden" class="form-control" id="id_level" name="id_level" value="{{$user->id_level}}" placeholder="id">
    <input type="hidden" class="form-control" name="id" value="{{$user->id}}" placeholder="id">


    <div class="col-12">
        <div class="card card-danger card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title text-danger my-header">Log Pendaftar Persatuan</h3>
                <div class="card-tools">
                    {{-- <a href="#" data-toggle="modal" title="Add" data-target="#addShareholders"  class="btn btn-sm btn-success pull-right">
                        <i class="fa fa-plus nav-icon"></i>
                        &nbsp; Add
                    </a> --}}
                </div>
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
                                        <th>Nama</th>
                                        <th>Nama Perniagaan</th>
                                        <th>No. IC</th>
                                        <th>Daerah</th>
                                        <th>Tarikh Mohon</th>
                                        <th>Status Approve</th>
                                        <th>Tarikh Approve</th>
                                        <th>Pembayaran</th>
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
                        <h5 class="modal-title" id="exampleModalLabel">Add Status Log</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body my-table">
                        <!-------->
                        <form action="{{URL::to('/senaraiAhli/store')}}#view" method="POST" enctype="multipart/form-data">
                          @csrf
                          <div class="form-group">
                            <label for="exampleInputEmail1">Name </label>
                            <div class="input-group">
                              <input type="text" name ="fullname" id="fullname" class="form-control" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">IC/Passport</label>
                            <div class="input-group">
                              <input type="text" name ="ic_number" id="ic_number" class="form-control" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">No. Telefon</label>
                            <div class="input-group">
                              <input type="number" name ="phone_number" id="phone_number" class="form-control" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">Emel</label>
                            <div class="input-group">
                              <input type="email" name ="email" id="email" class="form-control" required>
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="font-weight-700 labelku">Status Bumiputera <span style="color: #b91c1c;" >*</span> </label>
                            <select class="form-control form-control4 form-control-lg" name="native_statue" required autofocus>
                                <option selected disabled value="">Pilih Status Bumiputera</option>
                                <option value="Bumiputera">Bumiputera</option>
                                <option value="Non Bumiputera">Non Bumiputera</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Invoice <span style="color: #b91c1c;" >*</span> </label>
                            <select class="form-control form-control4 form-control-lg" name="invoice" required autofocus>
                                <option selected disabled value="">Pilih Invoice</option>
                                <option value="UNPAID">UNPAID</option>
                                <option value="PAID">PAID</option>
                            </select>
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
                        <h5 class="modal-title" id="exampleModalLabel">Update Senarai Ahli</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body my-table">
                        <!-------->
                        <form action="{{URL::to('/senaraiAhli/update')}}#view" class="form-update-data" method="POST" enctype="multipart/form-data">
                          @csrf
                          <div class="form-group">
                             <input type="hidden" class="form-control" name="id" id="id">
                            <label for="exampleInputEmail1">Name </label>
                            <div class="input-group">
                              <input type="text" name ="fullname" id="fullname" class="form-control" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">IC/Passport</label>
                            <div class="input-group">
                              <input type="text" name ="ic_number" id="ic_number" class="form-control" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">No. Telefon</label>
                            <div class="input-group">
                              <input type="number" name ="phone_number" id="phone_number" class="form-control" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">Emel</label>
                            <div class="input-group">
                              <input type="email" name ="email" id="email" class="form-control" required>
                            </div>
                          </div>
                         
                          <div class="form-group">
                            <label class="font-weight-700 labelku">Status Bumiputera <span style="color: #b91c1c;" >*</span> </label>
                            <select class="form-control form-control4 form-control-lg" name="native_status" required autofocus>
                                <option selected disabled value="">Pilih Status Bumiputera</option>
                                <option value="Bumiputera">Bumiputera</option>
                                <option value="Non Bumiputera">Non Bumiputera</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Invoice <span style="color: #b91c1c;" >*</span> </label>
                            <select class="form-control form-control4 form-control-lg" name="invoice" required autofocus>
                                <option selected disabled value="">Pilih Invoice</option>
                                <option value="UNPAID">UNPAID</option>
                                <option value="PAID">PAID</option>
                            </select>
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

        <div class="modal fade" id="detailApprovalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="max-width: 100%; width: auto; display: table;">
            <form action="" class="form-detail-data" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    
                    <div class="modal-body my-table">
                    
                        <div class="row" id="view">
    
                            <div class="col-12">
                                <div class="">
           
                                    @csrf
                                    
                                    @if ($message = Session::get('success'))
                                        <div class="alert alert-success">
                                                {{ $message }}
                                                <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                                        </div>
                                    @endif
                                    <div class="">
                                        <div class="row">
                                            <div class="col-lg-12 content-data">
                                                
                                               
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Kembali</button>
                                        <input type="submit" id="reject_join" value="Tolak Ahli" class="btn btn-sm btn-danger">
                                        <input type="submit" id="approve_join" value="Terima Ahli" class="btn btn-sm btn-success">
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                </div>
            </form>
            </div>
        </div>

        <div class="modal fade" id="approvalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
            <form action="" class="form-approval-data" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Approval</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body my-table">
                    
                        <div class="row" id="view">
    
                            <div class="col-12">
                                <div class="card card-danger card-outline">
           
                                    @csrf
                                    
                                    @if ($message = Session::get('success'))
                                        <div class="alert alert-success">
                                                {{ $message }}
                                                <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12 content-data">
                                                
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                    <div class="form-group">
                        <input type="hidden" class="form-control" id="id_log_certificate" name="id_log_certificate" placeholder="id" hidden>
                        <label for="exampleInputEmail1">Approval Note</label>
                        <textarea class="form-control form-control-sm" name="approval_note" id="" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Approval</label>
                        <select class="form-control form-control-sm" id="approval" name="approval">
                            <option value="APPROVED">Approve</option>
                            <option value="REJECTED">Reject</option>
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

@include('layouts.modals')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script src="//code.jquery.com/jquery-2.0.0.js"></script>
<script src="/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/js/page/joinCompany/index.js"></script>
@endsection

