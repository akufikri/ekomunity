@extends('home')
@section('title-dashboard', 'Manpower')
@section('title','Summery Qualification')

@section('breadcrumb')
<li class="breadcrumb-item active"><a href="/summaryQualification">Summary Qualification</a></li>
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

@include('employee.redbar.function_summary_qualification')
<div class="card card-primary card-outline" style="border-top: 3px solid dark">
    <div class="card-header">
        <h3 class="card-title text-primary my-header">Add Summary Qualification</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('summaryQualification.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
    		@if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>
                        {{ $message }}
                        <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                    </p>
                </div>
            @endif
            
            <div class="row">
                <div class="col-md-9">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Level of Education</label>
                            <div class="col-sm-8">
                                <select class="form-control searchTypeSchool input_id_type_school form-control-lg" id="id_type_school" name="id_type_school" required autofocus></select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Institute/University</label>
                            <div class="col-sm-8" id="div_school">
                                <select class="form-control searchSchool input_id_school form-control-lg" id="id_school" name="id_school" required autofocus readonly></select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Qualification</label>
                            <div class="col-sm-8">
                                <select class="form-control select2 select_qualification form-control-lg" name="id_qualification" required autofocus>
							        <option selected disabled value="">Select Choice</option>
							        @foreach(\App\Models\Qualification::get() as $qual)
							        <option value="{{$qual->id_qualification}}" {{(old('id_qualification')==$qual->id_qualification)? 'selected':''}}>
							            {{ $qual->qualification}}
							        </option>
							        @endforeach
							    </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Field of Study</label>
                            <div class="col-sm-8">
                                <select class="form-control select2 select_study form-control-lg" name="id_study" required autofocus>
							        <option selected disabled value="">Select Choice</option>
							        @foreach(\App\Models\Study::get() as $std)
							        <option value="{{$std->id_study}}" {{(old('id_study')==$std->id_study)? 'selected':''}}>
							            {{ $std->study}}
							        </option>
							        @endforeach
							    </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Graduation Date</label>
                            <div class="col-sm-8">
                                <input type="date" name="graduation_date" class="form-control" placeholder="Graduation Date" required autofocus>
								@error('name')
								<div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
								@enderror
                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Certificate</label>
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
                <input type="submit" value="Save" class="btn btn-sm btn-success">
            </div>
        </form>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script>
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