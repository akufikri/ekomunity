@extends('home')
@section('title-dashboard', 'Ahli')
@section('title','Edit Maklumat Perniagaan')

@section('breadcrumb')
<?php $user = Auth::user()->id; ?>
<li class="breadcrumb-item active"><a href="/personalDetail/{{$user}}">Maklumat Perniagaan</a></li>
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
        <h3 class="text-danger my-header">Edit Maklumat Perniagaan</h3>
    </div>
    <div class="card-body">
        <form action="{{URL::to('maklumatPerniagaan/update/'.$data->id.'')}}" method="POST" enctype="multipart/form-data">
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
    				    <div>
    				        <label class="font-weight-700 labelku">Logo Perniagaan </label>
    				    </div>
    					<div class="mb-3">
    					    <img id="image-picture_of_business" src="/BusinessImage/{{ $data->manpower->picture_of_business }}" width="100px" alt="Upload Image">
    					</div>
    					<input type="file" id="img" name="img_picture_of_business" onchange="readURLBusinessImage(this);" accept="image/*">
    					
    				</div>
    			</div>
    			<div class="col-md-6">
                    <div class="form-group">
    				    <div>
    				        <label class="font-weight-700 labelku">Gambar Produk </label>
    				    </div>
    					<div class="mb-3">
    					    <img id="image-picture_product" src="/BusinessProductImage/{{ $data->manpower->picture_product }}" width="100px" alt="Upload Image">
    					</div>
    					<input type="file" id="img" name="img_picture_product" onchange="readURLBusinessProductImage(this);" accept="image/*">
    					
    				</div>
    			</div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-700 labelku">Pihak Berkuasa Tempatan</label>
                        <select class="form-control form-control4 form-control-lg" name="pegawai_daerah" required autofocus>
        			        <option selected disabled value="">Pilih Pihak Berkuasa Tempatan</option>
        			        @foreach($pegawai_daerah as $d)
        			        <option value="{{ $d->id }}" {{ $data->manpower->id_pegawai_daerah == $d->id ? 'selected' : '' }}>
        			            {{ $d->fullname }}
        			        </option>
        			        @endforeach
        			    </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-700 labelku">Nama Perniagaan</label>
                        <input type="text" value="{{isset($data->manpower->name_of_business)?$data->manpower->name_of_business:""}}" class="form-control form-control-lg" placeholder="" name="name_of_business" autofocus>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-700 labelku">Jenis Pendaftaran Perniagaan</label>
                        <select class="form-control form-control4 form-control-lg" id="business_type" name="business_type" required autofocus>
        			        <option selected disabled value="">Jenis Pendaftaran Perniagaan</option>
        			        @foreach($business_type as $d)
        			        <option value="{{ $d->id_business_type }}" {{ $data->manpower->business_type == $d->id_business_type ? 'selected' : '' }}>
        			            {{ $d->business_type }}
        			        </option>
        			        @endforeach
        			    </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-700 labelku">No Lessen Berniaga</label>
                        <input type="text" value="{{isset($data->manpower->business_license_no)?$data->manpower->business_license_no:""}}" class="form-control form-control-lg" placeholder="" name="business_license_no" required autofocus>
                    </div>
                </div>
            
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-700 labelku">No Telefon Perniagaan</label>
                        <input type="text" value="{{isset($data->manpower->business_phone)?$data->manpower->business_phone:""}}" class="form-control form-control-lg" placeholder="" name="business_phone" required autofocus>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-700 labelku">Aktiviti Perniagaan</label>
                        <select class="form-control form-control4 form-control-lg" name="business_activity" id="business_activity" required autofocus>
        			        <option selected disabled value="">Pilih Aktiviti Perniagaan</option>
        			        @foreach($business_activity as $d)
        			        <option value="{{ $d->id_business_activity }}" {{ $data->manpower->business_activity == $d->id_business_activity ? 'selected' : '' }}>
        			            {{ $d->business_activity }}
        			        </option>
        			        @endforeach
        			    </select>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="font-weight-700 labelku">Tamu Desa</label>
                        @if ($manpower->id_state)
                        <select class="form-control form-control4 form-control-lg selectCustom" id="village_guests" name="village_guests[]" multiple="multiple" required autofocus>     
                            @foreach($village_guests as $d)
        			        <option value="{{ $d->id }}">
        			            {{ $d->village_guests }}
        			        </option>
        			        @endforeach
        			    </select>
                        @else
                        <input type="text" value="Sila Pilih Negeri di Maklumat Peribadi dahulu!" class="form-control form-control-lg" placeholder="" disabled>
                        @endif

                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="font-weight-700 labelku">Jenis kategori Perniagaan</label>
                        <select class="form-control form-control4 form-control-lg selectCustom" id="sub_business_activity" name="sub_business_activity[]" multiple="multiple" required autofocus>     
                            @foreach($sub_business_activity as $d)
        			        <option value="{{ $d->id_sub_business_activity }}">
        			            {{ $d->sub_business_activity }}
        			        </option>
        			        @endforeach
        			    </select>

                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-700 labelku">Emel</label>
                        <input type="text" value="{{isset($data->manpower->business_email)?$data->manpower->business_email:""}}" class="form-control form-control-lg" placeholder="" name="business_email" required autofocus>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-700 labelku">Pendapatan Tahunan</label>
                        <select class="form-control form-control4 form-control-lg" name="business_income" required autofocus>
        			        <option selected disabled value="">Pilih Pendapatan Tahunan</option>
        			        @foreach($business_income as $d)
        			        <option value="{{ $d->id_business_income}}" {{ $data->manpower->business_income == $d->id_business_income ? 'selected' : '' }}>
        			            {{ $d->business_income }}
        			        </option>
        			        @endforeach
        			    </select>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-700 labelku">Alamat Perniagaan</label>
                        <input type="text" value="{{isset($data->manpower->business_address)?$data->manpower->business_address:""}}" class="form-control form-control-lg" placeholder="" name="business_address" required autofocus>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-700 labelku">Website Syarikat</label>
                        <input type="text" value="{{isset($data->manpower->website)?$data->manpower->website:""}}" class="form-control form-control-lg" placeholder="" name="website" autofocus>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="button" style="width:100%;" onclick="loadMap()" value="PIN MAP LOCATION" title="PIN MAP LOCATION" class="btn btn-md btn-info">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-700 labelku">Latitude</label>
                        <input id="place_latitude" name="place_latitude" type="text" value="{{isset($data->manpower->business_lat)?$data->manpower->business_lat:""}}" class="form-control form-control-lg place-latitude" placeholder="" readonly autofocus>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-700 labelku">Longitude</label>
                        <input id="place_longitude" name="place_longitude" type="text" value="{{isset($data->manpower->business_lng)?$data->manpower->business_lng:""}}" class="form-control form-control-lg place-longitude" placeholder="" readonly autofocus>
                    </div>
                </div>
          
            </div>
            <div class="card-footer">
                <a href="/maklumatPerniagaan/{{$user}}" title="Back" class="btn btn-md btn-danger my-button">Cancel</a>	
                <input type="submit" value="Save" title="Save" class="btn btn-md btn-success">
            </div>
        </form>
    </div>
</div>
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  --}}


<script>    
    <?php

        $business_activity = $data->manpower->business_activity;
        echo "var business_activity = '$business_activity';";

        $sub_business_activity = $data->manpower->sub_business_activity;
        echo "var sub_business_activity = '$sub_business_activity';";

        $village_guests_select = $data->manpower->id_village_guests;
        echo "var village_guests_select = '$village_guests_select';";

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

    $(function () {
        $(".selectCustom").select2();


        if(village_guests_select != null && village_guests_select != ""){
            var temp = JSON.parse(village_guests_select)

            $("#village_guests").val(temp);
            $('#village_guests').trigger('change');
        }

        if(sub_business_activity != null && sub_business_activity != ""){
            var temp = JSON.parse(sub_business_activity)

            $("#sub_business_activity").val(temp);
            $('#sub_business_activity').trigger('change');
        }

        var current_select = $('#business_type').find(":selected").val();
            
        console.log(current_select)

        if(current_select == 1) {
            $("input[name=business_license_no]").attr('disabled','true');
            $("input[name=business_license_no]").css("background", "#d3d3d35c");

            // ✅ Remove required attribute
            $("input[name=business_license_no]").prop('required',false);


        } else {
            $("input[name=business_license_no]").removeAttr("disabled");
            $("input[name=business_license_no]").css("background", "#f9faff");

            // ✅ Set required attribute
            $("input[name=business_license_no]").prop('required',true);
            
        }

        $(document).on('change', '#business_type', function() {

            var current_select = $('#business_type').find(":selected").val();
                
            console.log(current_select)

            if(current_select == 1) {
                $("input[name=business_license_no]").attr('disabled','true');
                $("input[name=business_license_no]").css("background", "#d3d3d35c");

                // ✅ Remove required attribute
                $("input[name=business_license_no]").prop('required',false);


            } else {
                $("input[name=business_license_no]").removeAttr("disabled");
                $("input[name=business_license_no]").css("background", "#f9faff");

                // ✅ Set required attribute
                $("input[name=business_license_no]").prop('required',true);
                
            }

        })

        var current_select = $('#business_activity').find(":selected").val();
                
        console.log(current_select)

        if(current_select == 0) {
            // ✅ Remove required attribute
            $("#village_guests").prop('disabled',false);

        } else {
            $("#village_guests").prop('disabled',true);
        }

        $(document).on('change', '#business_activity', function() {

            var current_select = $('#business_activity').find(":selected").val();
                
            console.log(current_select)

            if(current_select == 0) {
                // ✅ Remove required attribute
                $("#village_guests").prop('disabled',false);

            } else {
                $("#village_guests").prop('disabled',true);
            }

        })

        function readURLBusinessImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
        
            reader.onload = function (e) {
            $('#image-picture_of_business').attr('src', e.target.result).width(100).height(74);
            };
        
            reader.readAsDataURL(input.files[0]);
        }
        }
        
        function readURLBusinessProductImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
        
            reader.onload = function (e) {
            $('#image-picture_product').attr('src', e.target.result).width(100).height(74);
            };
        
            reader.readAsDataURL(input.files[0]);
        }
        }
    })

</script>
@include('employee.register.mapbox')
@endsection