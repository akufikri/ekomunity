@extends('home')
@section('title-dashboard', 'Company')
@section('title','List of Workers
')

@section('breadcrumb')
<? $user = Auth::user()->id; ?>
<li class="breadcrumb-item active"><a href="/companyWorkers#view">List of Workers</a></li>
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
        <h3 class="card-title text-primary my-header">Edit List of Workers</h3>
    </div>
    <div class="card-body">
        <form action="{{URL::to('CompanyWorkers/fileCompanyWorkers/update/'.$data->id_company_workers.'')}}" method="POST" enctype="multipart/form-data">
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
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Name</label>
                            <div class="col-sm-8">
                                <input type="text" value="{{isset($data->name)?$data->name:""}}" class="form-control" name="name" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">IC/Passport</label>
                            <div class="col-sm-8">
                                <input type="text" value="{{isset($data->ic_number)?$data->ic_number:""}}" class="form-control" name="ic_number" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Country</label>
                            <div class="col-sm-8" id="div_country">
                                <select class="form-control searchCountry input_id_country form-control-lg" id="id_country" name="id_country" style="width: 100%;" placeholder="Country"></select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Position</label>
                            <div class="col-sm-8" id="div_position">
                                <select class="form-control searchPosition input_id_position form-control-lg" id="id_position" name="id_position" style="width: 100%;" placeholder="Position"></select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Bumiputera Status</label>
                            <div class="col-sm-8" id="div_native">
                                <select class="form-control searchNative input_id_status_native form-control-lg" id="id_status_native" name="id_status_native" style="width: 100%;" placeholder="Bumiputera Status"></select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label" id="label_form">Field of Work</label>
                            <div class="col-sm-8" id="div_segment">
                                <select class="form-control searchSegment input_id_segment form-control-lg" id="id_segment" name="id_segment" style="width: 100%;" placeholder="Field of Work"></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" id="label_form">Your Certificate</label> <small class="text-danger">(PDF)</small>
                            <input type="file" name="certificate[]" class="form-control certificate" placeholder="Your Certificate" accept="application/pdf" multiple><br>
                            
                            <input value="{{$data->id_company_workers}}" name="id_user" id="id_user" hidden>
                            <ol class="bg-white">
                            @forelse(json_decode($data->certificate) as $file)
                                <li class="p-2">
                                    <span>
                                        <a href="{{ asset('CertificateOfWork/'.$file.'') }}" target="new">{{$file}}</a>
                                        <a href="#" class="btn-remove-certificate" data-file="{{$file}}" data-id="{{$data->id_user}}">
                                            <i class="fa fa-times-circle mr-2" style="float: right;"></i>
                                        </a>
                                    </span>
                                </li>
                            @empty
                                <span>
                                    <b class="h4 mt-3" id="label_form">No Certificate uploaded</b>
                                </span>
                            @endforelse
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="/companyWorkers#view" class="btn btn-sm btn-dark">Back</a>	
                <input type="submit" value="Upload" class="pull-right btn-sm btn-info">
            </div>
        </form>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="removeWarning" role="dialog" aria-labelledby="failed">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="modal-body">
                    <br>
                    <p class="mt-4">
                        <span style="font-weight:bold" id="remove_msg">
                        </span>
                    </p>
                </div>
                <div class="modal-footer" id="remove_footer">
                </div>
            </div>
        </div>
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

    $(document).on('click', '.btn-remove-certificate', function(e){
        e.preventDefault();
        var ini = $(this), id = ini.data('id'), file = ini.data('file');
        var id_user = $('#id_user').val();
        var to = '/companyWorkers/remove_file/'+'?id_user='+id_user;
        var btn = '<a href="#" class="btn btn-transparent btn-md text-dark" style="font-weight:bold; font-size:15px" data-dismiss="modal">Close</a><a href="'+to+'" class="btn btn-danger btn-md text-light" style="font-weight:bold; font-size:15px">Delete</a>';
        
        mdl = $('#removeWarning');
        $('#remove_msg').html('File("'+file+'") will be deleted permanently! <br> Continue?');
        $('#remove_footer').html(btn);
        mdl.modal('show');
    });
    
    <?
        $position_id = $data->position->id_position;
        echo "var position_id = '$position_id';";
        $name_position = isset($data->position->position)?$data->position->position:"";
        echo "var name_position = '$name_position';";
        
        $segment_id = $data->segment->id_segment;
        echo "var segment_id = '$segment_id';";
        $name_segment = isset($data->segment->segment)?$data->segment->segment:"";
        echo "var name_segment = '$name_segment';";
        
        $country_id = $data->country->id_country;
        echo "var country_id = '$country_id';";
        $name_country = isset($data->country->country_name)?$data->country->country_name:"";
        echo "var name_country = '$name_country';";
        
        $native_id = $data->status->id_status_native;
        echo "var native_id = '$native_id';";
        $name_native = isset($data->status->status_native)?$data->status->status_native:"";
        echo "var name_native = '$name_native';";
    ?>
    
    searchPosition = $('.searchPosition');
    var $option = $('<option selected="selected"></option>').val(position_id).text(name_position);
    searchPosition.append($option).trigger('change');
    
    searchSegment = $('.searchSegment');
    var $option = $('<option selected="selected"></option>').val(segment_id).text(name_segment);
    searchSegment.append($option).trigger('change');
    
    searchCountry = $('.searchCountry');
    var $option = $('<option selected="selected"></option>').val(country_id).text(name_country);
    searchCountry.append($option).trigger('change');
    
    searchNative = $('.searchNative');
    var $option = $('<option selected="selected"></option>').val(native_id).text(name_native);
    searchNative.append($option).trigger('change');
    
    $(".searchPosition").select2({
    placeholder: "Please Select",
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
    });
    
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
    
    $(".searchNative").select2({
    placeholder: "Please Select",
    ajax: {
        url: "/getNative",
        dataType: "json",
        delay: 250,
        processResults: function (data) {
            return {
                results: $.map(data, function (item) {
                    item_text =  item.status_native;
                    return {
                        text: item_text,
                        id: item.id_status_native
                    };
                })
            };
        },
        cache: false
    }
    });
    
</script>

@endsection