@extends('home')
@section('title-dashboard', 'Ahli')
@section('title','Edit Maklumat Pendidikan')

@section('breadcrumb')
<?php $user = Auth::user()->id; ?>
<li class="breadcrumb-item active"><a href="/personalDetail/{{$user}}">Maklumat Pendidikan</a></li>
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
    
    .labelku{
        font-size: 15px;
    }
</style>

<div class="card card-danger card-outline" style="border-top: 3px solid dark">
    <div class="card-header">
        <h3 class="text-danger my-header">Edit Maklumat Pendidikan</h3>
    </div>
    <div class="card-body">
        <form action="{{URL::to('maklumatPendidikan/update/'.$data->id.'')}}" method="POST" enctype="multipart/form-data">
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
               
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-700 labelku">Taraf Pendidikan</label>
                        <select name="id_status_education" class="form-control form-control-lg1" required autofocus>
            				<option disabled value="" selected>Pilih Taraf Pendidikan</option>
            				@foreach($status_education as $d)
            				<option value="{{ $d->id_status_education }}" {{ $data->manpower->id_status_education == $d->id_status_education ? 'selected':''}}>{{ $d->status_education }}</option>
            				@endforeach
                		</select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-700 labelku">Bidang</label>
                        <select name="education_field" class="form-control form-control-lg1" required autofocus>
            				<option disabled value="" selected>Pilih Bidang</option>
            				@foreach($study as $d)
            				<option value="{{ $d->id_study }}" {{ $data->manpower->education_field == $d->id_study? 'selected':''}}>{{ $d->study}}</option>
            				@endforeach
                		</select>
                    </div>
                </div>
            </div>
            
            <br>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-700 labelku">Sijil kemahiran</label>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-700 labelku">Tahun</label>
                    </div>
                </div>
            </div>
            
            <?php
                $skills_certificate = json_decode($data->manpower->skills_certificate);
                $skills_certificate_year = json_decode($data->manpower->skills_certificate_year);
            ?>
            
            @if(isset($skills_certificate))
            @foreach($skills_certificate as $i => $value)
            @if($i == 0)
            <div class="row after-add-more">
                <div class="col-md-6 pr-0">
                    <div class="form-group">
                        <input type="text" class="form-control-lg1 form-control" name="sijil_kemahiran[]" placeholder="" value="{{$value}}" autocomplete="" autofocus>
                    </div>
                </div>
                <div class="col-md-4 pr-0">
                    <div class="form-group">
                        <input type="number" class="form-control-lg1 form-control" name="sijil_kemahiran_tahun[]" placeholder="" value="{{$skills_certificate_year[$i]}}" autocomplete="" autofocus>
                    </div>
                </div>
                <div class="col-md-2" style="align-self: center;">
                    <div class="form-group">
                        <button class="btn btn-success add-more" type="button">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            @else
            <div class="control-group row">
                <div class="col-md-6 pr-0">
                    <div class="form-group">
                        <input type="text" class="form-control-lg1 form-control" name="sijil_kemahiran[]" placeholder="" value="{{$value}}" autocomplete="" autofocus>
                    </div>
                </div>
                <div class="col-md-4 pr-0">
                    <div class="form-group">
                        <input type="number" class="form-control-lg1 form-control" name="sijil_kemahiran_tahun[]" placeholder="" value="{{$skills_certificate_year[$i]}}" autocomplete="" autofocus>
                    </div>
                </div>
                <div class="col-md-2" style="align-self: center;">
                    <div class="form-group">
                        <button class="btn btn-danger remove" type="button">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
            @else
            <div class="row after-add-more">
                <div class="col-md-6 pr-0">
                    <div class="form-group">
                        <input type="text" class="form-control-lg1 form-control" name="sijil_kemahiran[]" placeholder="" autocomplete="" autofocus>
                    </div>
                </div>
                <div class="col-md-4 pr-0">
                    <div class="form-group">
                        <input type="number" class="form-control-lg1 form-control" name="sijil_kemahiran_tahun[]" placeholder="" autocomplete="" autofocus>
                    </div>
                </div>
                <div class="col-md-2" style="align-self: center;">
                    <div class="form-group">
                        <button class="btn btn-success add-more" type="button">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endif
            
            <div class="row copy invisible d-none">
                <div class="control-group row">
                    <div class="col-md-6 pr-0">
                        <div class="form-group">
                            <input type="text" class="form-control-lg1 form-control" name="sijil_kemahiran[]" placeholder="" autocomplete="" autofocus>
                        </div>
                    </div>
                    <div class="col-md-4 pr-0">
                        <div class="form-group">
                            <input type="text" class="form-control-lg1 form-control" name="sijil_kemahiran_tahun[]" placeholder="" autocomplete="" autofocus>
                        </div>
                    </div>
                    <div class="col-md-2" style="align-self: center;">
                        <div class="form-group">
                            <button class="btn btn-danger remove" type="button"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                </div>
                
            </div>
            
            <div class="card-footer">
                <a href="/employmentDetail/{{$user}}" title="Back" class="btn btn-md btn-danger my-button">Cancel</a>	
                <input type="submit" value="Save" title="Save" class="btn btn-md btn-success">
            </div>
        </form>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script type="text/javascript" src="/js/my-custom.js"></script>
<script>
    
    <?
        $country_id = $data->manpower->id_country;
        echo "var country_id = '$country_id';";
        $name_country = isset($data->manpower->country->country_name)?$data->manpower->country->country_name:"";
        echo "var name_country = '$name_country';";
        
        $state_id = $data->id_state;
        echo "var state_id = '$state_id';";
        $state_name = isset($data->manpower->state->state);
        echo "var state_name = '$state_name';";
        
        $city_id = $data->id_city;
        echo "var city_id = '$city_id';";
        $city_name = isset($data->manpower->city->city);
        echo "var city_name = '$city_name';";
    ?>
    
    searchCountry = $('.searchCountry');
    var $option = $('<option selected="selected"></option>').val(0).text("Choose your Country");
    searchCountry.append($option).trigger('change');
    
    searchState = $('.searchState');
    var $option = $('<option selected="selected"></option>').val(0).text("Select Your Country First!");
    searchState.append($option).trigger('change');
    
    searchCity = $('.searchCity');
    var $option = $('<option selected="selected"></option>').val(0).text("Select Your Country First!");
    searchCity.append($option).trigger('change');
    
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
    }).on('change', function (e) {
        id_country = this.value;
        $('.searchState').prop('disabled', false);
        $('.searchCity').prop('disabled', false);
        
        $('#div_city').load(location.href+" #div_city>*", "");
        $('#div_state').load(location.href+" #div_state>*", function(){
	        $(".searchState").select2({
                placeholder: "Please Select",
                ajax: {
                    url: '/getState?id_country=' + id_country,
                    dataType: "json",
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                    item_text =  item.state;
                                    return {
                                        text: item_text,
                                        id: item.id_state
                                    };
                            })
                        };
                    },
                    cache: false
                }
                }).on('change', function (e) {
                    id_state = this.value;
                    $('.searchCity').prop('disabled', false);
                    $('#div_city').load(location.href+" #div_city>*", function(){
                        $(".searchCity").select2({
                        placeholder: "Please Select",
                        ajax: {
                            url: '/getCity?id_state=' +  id_state,
                            dataType: "json",
                            delay: 250,
                            processResults: function (data) {
                                return {
                                    results: $.map(data, function (item) {
                                            item_text =  item.city;
                                            return {
                                                text: item_text,
                                                id: item.id_city
                                            };
                                    })
                                };
                            },
                            cache: false
                        }
                        }).on('change', function (e) {});
                        
                    });
                });
        });
    });
    
    /**
 * charCode [48,57] 	Numbers 0 to 9
 * keyCode 46  			"delete"
 * keyCode 9  			"tab"
 * keyCode 13  			"enter"
 * keyCode 116 			"F5"
 * keyCode 8  			"backscape"
 * keyCode 37,38,39,40	Arrows
 * keyCode 10			(LF)
 */
function validate_int(myEvento) {
  if ((myEvento.charCode >= 48 && myEvento.charCode <= 57) || myEvento.keyCode == 9 || myEvento.keyCode == 10 || myEvento.keyCode == 13 || myEvento.keyCode == 8 || myEvento.keyCode == 116 || myEvento.keyCode == 46 || (myEvento.keyCode <= 40 && myEvento.keyCode >= 37)) {
    dato = true;
  } else {
    dato = false;
  }
  return dato;
}

function phone_number_mask() {
//   var myMask = "(___) ____-__-____";
  var myMask = "______-__-____";
  var myCaja = document.getElementById("ic_number");
  var myText = "";
  var myNumbers = [];
  var myOutPut = ""
  var theLastPos = 1;
  myText = myCaja.value;
  //get numbers
  for (var i = 0; i < myText.length; i++) {
    if (!isNaN(myText.charAt(i)) && myText.charAt(i) != " ") {
      myNumbers.push(myText.charAt(i));
    }
  }
  //write over mask
  for (var j = 0; j < myMask.length; j++) {
    if (myMask.charAt(j) == "_") { //replace "_" by a number 
      if (myNumbers.length == 0)
        myOutPut = myOutPut + myMask.charAt(j);
      else {
        myOutPut = myOutPut + myNumbers.shift();
        theLastPos = j + 1; //set caret position
      }
    } else {
      myOutPut = myOutPut + myMask.charAt(j);
    }
  }
  document.getElementById("ic_number").value = myOutPut;
  document.getElementById("ic_number").setSelectionRange(theLastPos, theLastPos);
}

document.getElementById("ic_number").onkeypress = validate_int;
document.getElementById("ic_number").onkeyup = phone_number_mask;
    
</script>

@endsection