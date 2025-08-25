@extends('home')
@section('title-dashboard', 'Manpower')
@section('title','Other Qualification')

@section('breadcrumb')
<li class="breadcrumb-item active"><a href="/otherQualification">Other Qualification</a></li>
<li class="breadcrumb-item active">Edit</li>

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

<div class="card">
    <div class="card-header">
        <h3 class="card-title my-header text-primary">Edit Other Qualification</h3>
    </div>
    <div class="card-body">
        <form action="{{URL::to('otherQualification/update/'.$data->id_other_qualification.'')}}" method="POST" enctype="multipart/form-data">
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
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Institute/University</label>
                            <div class="col-sm-8">
                                <input type="text" value="{{isset($data->organizer)?$data->organizer:""}}" class="form-control" name="organizer" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Qualification</label>
                            <div class="col-sm-8">
                                <input type="text" value="{{isset($data->qualification)?$data->qualification:""}}" class="form-control" name="qualification" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Date</label>
                            <div class="col-sm-8">
                                <input type="date" value="{{isset($data->other_date)?$data->other_date:""}}" class="form-control" name="other_date" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Attachment</label>
                            <div class="col-sm-8">
                                 <a href="/SUMMARY/{{$data->certificate}}" target="new">
                                <input class="form-control" type="text" value="{{$data->certificate}}" readonly>
								</a>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Change Attachment</label>
                            <div class="col-sm-8">
                                <input  name="certificate" type="file" class="form-control ">
								
                            </div>
                        </div>
                    </div>
                </div>
                <div></div>
            </div>
            <div class="card-footer">
                <a href="/otherQualification" class="btn btn-sm btn-dark">Back</a>	
                <input type="submit" value="Update" class="btn btn-sm btn-success">
            </div>
        </form>
    </div>
</div>
@endsection