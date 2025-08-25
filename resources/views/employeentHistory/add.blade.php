@extends('home')
@section('title-dashboard', 'Manpower')
@section('title','Employment History')

@section('breadcrumb')
<? $user = Auth::user()->id; ?>
<li class="breadcrumb-item active"><a href="/employmentDetail/{{$user}}">Employment History</a></li>
<li class="breadcrumb-item active">Add</li>

@endsection

@section('content')

<style>
    .title {
        font-size: 1.25rem; 
        font-weight: bold;
    }
    .select2-container--default .select2-selection--single {
    border: 1px solid #ced4da;
    height: calc(2.5rem + 2px) !important;
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

@include('employee.redbar.function_employment_details')
<div class="card card-primary card-outline" style="border-top: 3px solid dark">
    <div class="card-header">
        <h3 class="card-title text-primary my-header">Add Employment History</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('employeentHistory.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
    		@if ($message = Session::get('success'))
                <div class="alert alert-success">
                        {{ $message }}
                        <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                </div>
            @endif
            
            <div class="row">
                <div class="col-md-9">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Company</label>
                            <div class="col-sm-8">
                                <input type="text" name="company" class="form-control" placeholder="Company" required autofocus>
								@error('name')
								<div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
								@enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Position</label>
                            <div class="col-sm-8">
                                <select class="form-control searchPosition input_id_position form-control-lg" id="id_position" name="id_position" style="width: 100%" required></select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Field of Work</label>
                            <div class="col-sm-8">
                                <select class="form-control searchField input_id_segment" id="id_segment" name="id_segment" style="width: 100%" required></select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">From Date</label>
                            <div class="col-sm-8">
                                <input type="date" name="from_date" class="form-control" placeholder="From Date" required autofocus>
								@error('name')
								<div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
								@enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">To Date</label>
                            <div class="col-sm-8">
                                <input type="date" name="to_date" class="form-control" placeholder="To Date" required autofocus>
								@error('name')
								<div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
								@enderror
                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Certificate</label>
                            <div class="col-sm-8">
                                <input  name="certificate" type="file" accept='application/pdf' accept='image/*' class="form-control ">
								
                            </div>
                        </div>
                    </div>
                </div>
                <div></div>
            </div>
            <div class="card-footer">
                <a href="/employmentDetail/{{$user}}" class="btn btn-sm btn-dark">Back</a>	
                <input type="submit" value="Save" class="btn btn-sm btn-success">
            </div>
        </form>
    </div>
</div>

<script src="//code.jquery.com/jquery-2.0.0.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script type="text/javascript">

    $(".searchPosition").select2({
        placeholder: "Position",
        ajax: {
            url: "/getPosition",
            dataType: "json",
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                            item_text =  item.position;
                            return {
                                text: item_text,
                                id: item.id_position
                            };
                    })
                };
            },
            cache: false
        }
    }).on('change', function (e) {
        
    });
    
    $(".searchField").select2({
        placeholder: "Field of Work",
        ajax: {
            url: "/getSegment",
            dataType: "json",
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                            item_text =  item.segment;
                            return {
                                text: item_text,
                                id: item.id_segment
                            };
                    })
                };
            },
            cache: false
        }
    }).on('change', function (e) {
        
    });
</script>

@endsection