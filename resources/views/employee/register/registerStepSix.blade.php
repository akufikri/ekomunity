@extends('login.template')
@section('title-dashboard', 'Manpower')
@section('title', 'Servay')
@section('content')
<style>
    .btnku {
      background-color: white !important;
      color: #b91c1c !important;
      border: 2px solid #b91c1c !important;
    }

    .btnku:hover {
      background-color: #b91c1c !important;
      color: white !important;
    }
    /*==========*/
    .form-control-lg{
        height: calc(2.875rem + 2px) !important;
        padding: 1rem .8rem !important;
        font-size: 13px !important;
        line-height: 1.5 !important;
        border-radius: .3rem !important;
    }
    .labelku{
        font-size: 15px;
    }
    .titleku{
        font-size: 18px;
    }
    /*div.btn-group.bootstrap-select.form-control.form-control4.form-control-lg{*/
    /*    background: white !important;*/
    /*}*/
    .form-control4 {
        background: #fff none repeat scroll 0 0 !important;
        border: 0 none;
        box-shadow: 0px 0px 0px 0 rgb(0 0 0 / 0%) !important;
        font-size: 16px;
        height: 50px;
        padding: 0px 0px 0px 0px;
        margin: 0px 0px 0px 0px;
    }
    
    .bootstrap-select .dropdown-toggle {
    background-color: #f9faff !important;
    }
    .btn-group>.btn:first-child {
    margin-left: -10px;
    }
    .button-md {
    padding: 10px 18px;
    font-size: 16px;
    font-weight: 500;
    }
</style>

<div class="section-full content-inner shop-account">
    <div class="container">
        <div class="row">
			<div class="col-md-12 text-center">
				@if ($message = Session::get('success'))
                    <div class="alert alert-danger">
                        <p>
                            {{ $message }}
                            <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                        </p>
                    </div>
                @endif
			</div>
		</div>
        <div class="row">
			<div class="col-md-12 m-b30">
				<div class="p-a30 border-1  max-w500 m-auto">
					<div class="tab-content">
						<form action="/register_ahli/step_six_update" method="POST" enctype="multipart/form-data">
                            @csrf
							<h4 class="font-weight-700 titleku">Servay</h4>

                            <div class="form-group">
							    <label class="font-weight-700 labelku">Sokongan & Latihan <span style="color: #b91c1c;" >*</span> </label>
                                <p class="font-weight-600">Adakah anda berminat mengikuti program pembangunan keusahawanan mahupun latihan yang disediakan ?</p>
                                <div class="radio1-option">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radio1" value="Ya" id="flexRadioDefault1">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                          Ya
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radio1" value="Tidak" id="flexRadioDefault2">
                                        <label class="form-check-label" for="flexRadioDefault2">
                                          Tidak
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radio1" value="Pernah Mengikuti Program" id="flexRadioDefault2">
                                        <label class="form-check-label" for="flexRadioDefault2">
                                          Pernah Mengikuti Program
                                        </label>
                                    </div>
                                </div>
							</div>

                            <div class="pilih-pelatihan">
                                <div class="form-group">
                                    <label class="font-weight-700 labelku">Sila Pilih Agensi <span style="color: #b91c1c;" >*</span> </label>
                                    <select class="form-control form-control4 form-control-lg" name="agency_minat" autofocus>
                                        <option selected disabled value="">Pilih Agensi</option>
                                        @foreach($agency_pelatihan as $d)
                                        <option value="{{ $d->id_agency_pelatihan }}">{{ $d->agency_pelatihan }}</option>
                                        @endforeach
                                    </select>
                                </div>
    
                                <div class="form-group">
                                    <label class="font-weight-700 labelku">Tajuk Kelas <span style="color: #b91c1c;" >*</span> </label>
                                    <input id="tajuk_kelas" type="text" class="form-control-lg form-control" name="tajuk_kelas" placeholder="Tajuk Kelas" autocomplete="tajuk_kelas" autofocus>
                                </div>
                            </div>
							
							<div id="btnsubmitku" class="text-left">
								<button class="site-button button-md outline outline-2 btnku btn btn-md" type="submit">Next</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: white">
                <p class="modal-title" style="color: black;" id="exampleModalLabel">Terms & Conditions</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
                $term = App\Models\Term::where('id_level',3)->get();
            ?>
            <div class="modal-body" style="overflow: auto; height: 400px; padding: 10px;">
                @foreach($term as $terms)
                    <p style="font-size:10px; text-align:justify;">{{$terms->term_conditions}}</p>
                @endforeach
            </div>
            <div class="modal-footer" style="height: 50px;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="/js/my-custom.js"></script>
<script type="text/javascript">
    $(function () {

        // loadCategoryProduct()

        $('.pilih-pelatihan').hide()

        $('.select2').select2()
        $('.kategori-produk-select2').select2()

        $('.radio1-option').click(function() {
            var option = $('input[name="radio1"]:checked').val();
            console.log(option);

            if (option == "Pernah Mengikuti Program") {
                $('.pilih-pelatihan').show()
            } else {
                $('.pilih-pelatihan').hide()
            }

        });


        // $('.select2').on('select2:select', function (e) {
        //     console.log($('.select2').val())

        //     var id = $('.select2').val()

        //     loadCategoryProduct(JSON.stringify(id))
        // });

        // $('.select2').on('select2:unselect', function (e) {
        //     console.log($('.select2').val())

        //     var id = $('.select2').val()

        //     loadCategoryProduct(JSON.stringify(id))

        //     // loadCategoryProduct(JSON.stringify(id))
        // });

        $("#btnsubmitku").click(function () {
            var password = $("#password").val();
            var confirmPassword = $("#password-confirm").val();
            if (password !== confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }
            return true;
        });
        
        $(document).on('change', '.btn-jenis-pendaftaran-perniagaan', function() {

            var current_select = $('#jenis_pendaftaran_perniagaan').find(":selected").val();
            
            console.log(current_select)

            if(current_select == 1) {
                $("input[name=no_lesen_berniaga]").attr('disabled','true');
                $("input[name=no_lesen_berniaga]").css("background", "#d3d3d35c");

                // $("input[name=alamat_perniagaan]").attr('disabled','true');
                // $("input[name=alamat_perniagaan]").css("background", "#d3d3d35c");

                // $("select[name=aktiviti_perniagaan]").attr('disabled','true');
                // $("select[name=aktiviti_perniagaan]").css("background", "#d3d3d35c");

                // $("input[name=no_telefon_perniagaan]").attr('disabled','true');
                // $("input[name=no_telefon_perniagaan]").css("background", "#d3d3d35c");

                // $("input[name=emel]").attr('disabled','true');
                // $("input[name=emel]").css("background", "#d3d3d35c");

                // $("input[name=pautan_laman_sosial]").attr('disabled','true');
                // $("input[name=pautan_laman_sosial]").css("background", "#d3d3d35c");


            } else {
                $("input[name=no_lesen_berniaga]").removeAttr("disabled");
                $("input[name=no_lesen_berniaga]").css("background", "#f9faff");

                // $("input[name=alamat_perniagaan]").removeAttr("disabled");
                // $("input[name=alamat_perniagaan]").css("background", "#f9faff");

                // $("select[name=aktiviti_perniagaan]").removeAttr("disabled");
                // $("select[name=aktiviti_perniagaan]").css("background", "#f9faff");

                // $("input[name=no_telefon_perniagaan]").removeAttr("disabled");
                // $("input[name=no_telefon_perniagaan]").css("background", "#f9faff");

                // $("input[name=emel]").removeAttr("disabled");
                // $("input[name=emel]").css("background", "#f9faff");

                // $("input[name=pautan_laman_sosial]").removeAttr("disabled");
                // $("input[name=pautan_laman_sosial]").css("background", "#f9faff");
                
            }
        
        })
    });
    
    function loadCategoryProduct() {

            $('.kategori-produk-select2').select2({
                ajax: {
                    url: '/category_product/get_data',
                    dataType: 'json',
                    data: function (params) {
                        var query = {
                            search: params.term,
                            // type: 'public'
                        }

                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    },
                    processResults: function (result) {

                        var item = result.data

                        return {
                            // results: item
                            results: $.map(item, function(obj) {
                                return { id: obj.id_category_product, text: obj.category_product };
                            })
                        };
                    },
                },
            });

        }
   
    
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
    
        reader.onload = function (e) {
          $('#image').attr('src', e.target.result).width(100).height(74);
        };
    
        reader.readAsDataURL(input.files[0]);
      }
    }
    
</script>
@include('employee.register.mapbox')
@endsection    