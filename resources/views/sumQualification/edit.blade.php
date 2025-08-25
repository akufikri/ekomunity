@extends('home')
@section('title-dashboard', 'Manpower')
@section('title','Summary Qualification')

@section('breadcrumb')
<li class="breadcrumb-item active"><a href="/summaryQualification">Summary Qualification</a></li>
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

@include('employee.redbar.function_summary_qualification')
<div class="card card-primary card-outline" style="border-top: 3px solid dark">
    <div class="card-header">
        <h3 class="card-title text-primary my-header">Edit Summary Qualification</h3>
    </div>
    <div class="card-body">
        <form action="{{URL::to('summaryQualification/update/'.$data->id_summary_qualification.'')}}" method="POST" enctype="multipart/form-data">
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
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Level of Education</label>
                            <div class="col-sm-8" id="div_type_school">
                                <select class="form-control searchTypeSchool input_id_type_school form-control-lg" id="id_type_school" name="id_type_school"></select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Institute/University</label>
                            <div class="col-sm-8" id="div_school">
                                <select class="form-control searchSchool input_id_school form-control-lg" id="id_school" name="id_school" required autofocus></select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Qualification</label>
                            <div class="col-sm-8" id="div_qualification">
                                <select class="form-control form-control-lg" name="id_qualification" required autofocus>
                                    <?php 
                                        $qualification = \App\Models\Qualification::where('id_qualification','>','0')->get() ;
                                        $selc = $data->qualification->id_qualification;
                                    ?>
                                    <option selected disabled>Select Choice</option>
                                     @foreach($qualification as $qual)
                                            <option value="{{ $qual->id_qualification }}" {{ $selc == $qual->id_qualification ? 'selected="selected"' : '' }}>{{ $qual->qualification }}</option>
                                      @endforeach 
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Field of Study</label>
                            <div class="col-sm-8" id="div_study">
                                <select class="form-control form-control-lg" name="id_study" required autofocus>
                                    <?php 
                                        $study = \App\Models\Study::where('id_study','>','0')->get() ;
                                        $selc = $data->study->id_study;
                                    ?>
                                    <option selected disabled>Select Choice</option>
                                     @foreach($study as $std)
                                            <option value="{{ $std->id_study }}" {{ $selc == $std->id_study ? 'selected="selected"' : '' }}>{{ $std->study }}</option>
                                      @endforeach 
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Graduation Date</label>
                            <div class="col-sm-8">
                                <input type="date" value="{{isset($data->graduation_date)?$data->graduation_date:""}}" class="form-control" name="graduation_date" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Certificate</label>
                            <div class="col-sm-8">
                                 <a href="/SUMMARY/{{$data->certificate}}" target="new">
                                <input class="form-control" type="text" value="{{$data->certificate}}" readonly>
								</a>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Change Certificate</label>
                            <div class="col-sm-8">
                                <input  name="certificate" type="file" class="form-control ">
								
                            </div>
                        </div>
                    </div>
                </div>
                <div></div>
            </div>
            <div class="card-footer">
                <a href="/summaryQualification" title="Back" class="btn btn-sm btn-dark">Back</a>	
                <input type="submit" value="Update" title="Update" class="btn btn-sm btn-success">
            </div>
        </form>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script>
    <?
        $school_id = $data->school->id_school;
        echo "var school_id = '$school_id';";
        $name_school = isset($data->school->school)?$data->school->school:"";
        echo "var name_school = '$name_school';";
    ?>
    
    searchSchool = $('.searchSchool');
    var $option = $('<option selected="selected"></option>').val(school_id).text(name_school);
    searchSchool.append($option).trigger('change');
    
    $(".searchTypeSchool").select2({
    placeholder: "Select Choice",
    ajax: {
        url: "/getTypeSchool",
        dataType: "json",
        delay: 250,
        processResults: function (data) {
            return {
                results: $.map(data, function (item) {
                        item_text =  item.type_school;
                        return {
                            text: item_text,
                            id: item.id_type_school
                        };
                })
            };
        },
        cache: false
    }
    }).on('change', function (e) {
        id_type_school = this.value;
        $('.searchSchool').prop('disabled', false);

        $('#div_school').load(location.href+" #div_school>*", function(){
	        $(".searchSchool").select2({
                placeholder: "Select Choice",
                ajax: {
                    url: '/getSchool?id_type_school=' + id_type_school,
                    dataType: "json",
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                    item_text =  item.school;
                                    return {
                                        text: item_text,
                                        id: item.id_school
                                    };
                            })
                        };
                    },
                    cache: false
                }
            });
        });
    });
</script>

@endsection