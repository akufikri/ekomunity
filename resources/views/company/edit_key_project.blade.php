@extends('home')
@section('title-dashboard', 'Company')
@section('title','List Key Client Project')

@section('breadcrumb')
<? $user = Auth::user()->id; ?>
<li class="breadcrumb-item active"><a href="/companyKeyClientProject#view">List Key Client Project</a></li>
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

<div class="card card-primary card-outline" style="border-top: 3px solid dark">
    <div class="card-header">
        <h3 class="card-title my-header text-primary">Edit Key Client Project</h3>
    </div>
    <div class="card-body">
        <form action="{{URL::to('companyKeyClientProject/update/'.$data->id_company_project.'')}}" method="POST" enctype="multipart/form-data">
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
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Country</label>
                            <div class="col-sm-8" id="div_coucntry">
                                <select class="form-control searchCountry input_id_country form-control-lg" id="id_country" name="id_country" style="width: 100%;" placeholder="Country" required autofocus></select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Field of Business</label>
                            <div class="col-sm-8" id="div_segment">
                                <select class="form-control searchSegment input_id_segment form-control-lg" id="id_segment" name="id_segment" style="width: 100%;" placeholder="Field of Work" required autofocus></select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Client</label>
                            <div class="col-sm-8">
                                <input type="text" value="{{isset($data->client)?$data->client:""}}" class="form-control" name="client" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Project Name</label>
                            <div class="col-sm-8">
                                <input type="text" value="{{isset($data->project_name)?$data->project_name:""}}" class="form-control" name="project_name" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Start Date</label>
                            <div class="col-sm-8">
                                <input type="date" value="{{isset($data->start_date)?$data->start_date:""}}" class="form-control" name="start_date" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Completion Date</label>
                            <div class="col-sm-8">
                                <input type="date" value="{{isset($data->completion_date)?$data->completion_date:""}}" class="form-control" name="completion_date" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Project Value</label>
                            <div class="col-sm-8">
                                <input type="number" value="{{isset($data->project_value)?$data->project_value:""}}" class="form-control" name="project_value" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Leter Offer</label>
                            <div class="col-sm-8">
                                @foreach($datas as $ofer)
                                <div class="clone hide">
                                    <div class="control-group1 input-group" style="margin-top:10px">
                                        <input type="text" name ="offer_later[]" value="{{$ofer}}" class="form-control"disabled>
                                    </div>
                                    <a href="{{ asset('CompanyProject/'.$ofer.'') }}" id="label_form" target="_blank">Open the pdf!</a>
                                </div>
                                <br>
                                @endforeach
                            </div>
                        </div>
                        <div class="input-group control-group increment" >
                            <label for="Certifikat" id="label_form">Change Leter Offer</label>
                            <div class="input-group">
                                <input type="file" name="offer_later[]" accept=".doc,.docx,.txt,.pdf" class="form-control" multiple>
                            </div>
                        </div>
                    </div>
                </div>
                <div></div>
            </div>
            <div class="card-footer">
                <a href="/companyKeyClientProject#view" class="btn btn-sm btn-dark">Back</a>	
                <input type="submit" value="Update" class="pull-right btn btn-sm btn-success">
            </div>
        </form>
    </div>
</div>

<style>
    .text-sm .select2-container--default .select2-selection--single .select2-selection__rendered, select.form-control-sm~.select2-container--default .select2-selection--single .select2-selection__rendered {
    margin-top: -.4rem;
    font-size: 17px;
}
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script>
    <?
        $segment_id = $data->segment->id_segment;
        echo "var segment_id = '$segment_id';";
        $name_segment = isset($data->segment->segment)?$data->segment->segment:"";
        echo "var name_segment = '$name_segment';";
        
        $country_id = $data->country->id_country;
        echo "var country_id = '$country_id';";
        $name_country = isset($data->country->country_name)?$data->country->country_name:"";
        echo "var name_country = '$name_country';";
    ?>
    
    searchSegment = $('.searchSegment');
    var $option = $('<option selected="selected"></option>').val(segment_id).text(name_segment);
    searchSegment.append($option).trigger('change');
    
    searchCountry = $('.searchCountry');
    var $option = $('<option selected="selected"></option>').val(country_id).text(name_country);
    searchCountry.append($option).trigger('change');
    
    $(".searchSegment").select2({
    placeholder: "Please Select",
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
    });
    
    $(".searchCountry").select2({
    placeholder: "Please Select",
    ajax: {
        url: "/getCountry",
        dataType: "json",
        delay: 250,
        processResults: function (data) {
            return {
                results: $.map(data, function (item) {
                        item_text =  item.country_name;
                        return {
                            text: item_text,
                            id: item.id_country
                        };
                })
            };
        },
        cache: false
    }
    });
    
</script>

@endsection