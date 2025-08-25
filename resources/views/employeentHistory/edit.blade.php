@extends('home')
@section('title-dashboard', 'Manpower')
@section('title','Employment Detail Manpower')

@section('breadcrumb')
<? $user = Auth::user()->id; ?>
<li class="breadcrumb-item active"><a href="/employmentDetail/{{$user}}">Employment Detail</a></li>
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
</style>

@include('employee.redbar.function_employment_details')
<div class="card card-primary card-outline" style="border-top: 3px solid dark">
    <div class="card-header">
        <h3 class="text-primary my-header">Edit Employment Detail</h3>
    </div>
    <div class="card-body">
        <form action="{{URL::to('employmentDetail/update/'.$data->id.'')}}" method="POST" enctype="multipart/form-data">
            @csrf
            
    		@if ($message = Session::get('success'))
                <div class="alert alert-success">
                        {{ $message }}
                        <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                </div>
            @endif
            
            <div class="row">
                <div class="col-md-12">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="" class="col-sm-4" id="label_form">Work Type</label>
                            <div class="col-sm-8" id="div_country">
                                <select class="form-control searchWorkType input_id_work_type form-control-lg1" id="id_work_type" name="id_work_type"></select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-4" id="label_form">Current Work Status</label>
                            <div class="col-sm-8">
                                <select name="current_work_status" value='{{ $data->manpower->current_work_status }}' class="form-control form-control-lg1" required autofocus>
                    				<option id="label_form" selected disabled value="">Current Work Status</option>
                    				<option id="label_form" value="EMPLOYED" {{$data->manpower->current_work_status == "EMPLOYED" ? 'selected':''}}>EMPLOYED</option>
                    				<option id="label_form" value="UNEMPLOYED" {{$data->manpower->current_work_status == "UNEMPLOYED" ? 'selected':''}}>UNEMPLOYED</option>
                        		</select>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script>
    <?
        $work_id = $data->manpower->id_work_type;
        echo "var work_id = '$work_id';";
        $name_work = isset($data->manpower->work->work_type)?$data->manpower->work->work_type:"";
        echo "var name_work = '$name_work';";
    ?>
    
    searchWorkType = $('.searchWorkType');
    var $option = $('<option selected="selected"></option>').val(work_id).text(name_work);
    searchWorkType.append($option).trigger('change');
    
    $(".searchWorkType").select2({
    placeholder: "Please Select",
    ajax: {
        url: "/getWorkType",
        dataType: "json",
        delay: 250,
        processResults: function (data) {
            return {
                results: $.map(data, function (item) {
                        item_text =  item.work_type;
                        return {
                            text: item_text,
                            id: item.id_work_type
                        };
                })
            };
        },
        cache: false
    }
    });
</script>

@endsection