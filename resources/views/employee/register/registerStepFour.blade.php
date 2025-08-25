@extends('login.template')
@section('title-dashboard', 'Manpower')
@section('title', 'Register')
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
				<h3 class="font-weight-700 m-t0 m-b20 titleku">Pendaftaran Ahli</h3>
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
						<form action="/register_ahli/step_four_update" method="POST" enctype="multipart/form-data">
                            @csrf
							<h4 class="font-weight-700 titleku">MAKLUMAT PERNIAGAAN</h4>

                            <div class="form-group">
							    <label class="font-weight-700 labelku">Pihak Berkuasa Tempatan <span style="color: #b91c1c;" >*</span> </label>
                                <input type="hidden" name="id_pegawai_daerah" value="{{ $user->manpower->id_pegawai_daerah }}">
                                <select class="form-control form-control4 form-control-lg select2" name="pegawai_daerah" id="pegawai_daerah" required autofocus>
                			        <option selected disabled value="">Pilih Pihak Berkuasa Tempatan</option>
                			        @foreach($pegawai_daerah as $d)
                			        <option value="{{ $d->id }}">{{ $d->fullname }}</option>
                			        @endforeach
                			    </select>
							</div>

                            <div class="form-group">
							    <label class="font-weight-700 labelku">Persatuan </label>
                                <input type="hidden" name="id_persatuan" value="{{ $user->manpower->id_detail_company }}">
                                <select class="form-control form-control4 form-control-lg select2" name="persatuan[]" multiple="multiple" id="id_persatuan" autofocus>
                                    <option value="0">Tiada Persatuan</option>
                			        @foreach($persatuan as $d)
                			        <option value="{{ $d->company->id_detail_company }}">{{ $d->company->full_company_name }}</option>
                			        @endforeach
                			    </select>
							</div>
							
							<div class="form-group">
								<label class="font-weight-700 labelku">Nama Perniagaan </label>
								<input id="nama_perniagaan" type="text" class="form-control-lg form-control @error('nama_perniagaan') is-invalid @enderror" name="nama_perniagaan" value="{{ $user->manpower->name_of_business }}" placeholder="Nama Perniagaan" autocomplete="nama_perniagaan" autofocus>

                                @error('nama_perniagaan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>
							
							<div class="form-group">
							    <label class="font-weight-700 labelku">Jenis Pendaftaran Perniagaan <span style="color: #b91c1c;" >*</span> </label>
                                <input type="hidden" name="id_jenis_pendaftaran_perniagaan" value="{{ $user->manpower->business_type }}">
                                <select class="form-control form-control4 form-control-lg btn-jenis-pendaftaran-perniagaan select2" id="jenis_pendaftaran_perniagaan" name="jenis_pendaftaran_perniagaan" required autofocus>
                			        <option selected disabled value="">Pilih Jenis Pendaftaran Perniagaan</option>
                			        @foreach($business_type as $d)
                			        <option value="{{ $d->id_business_type }}">
                			            {{ $d->business_type }}
                			        </option>
                			        @endforeach
                			    </select>
							</div>

							<div class="form-group">
								<label class="font-weight-700 labelku">No Lesen Berniaga </label>
								<input id="no_lesen_berniaga" type="text" class="form-control-lg form-control @error('no_lesen_berniaga') is-invalid @enderror" name="no_lesen_berniaga" value="{{ $user->manpower->business_license_no }}" placeholder="No Lesen Berniaga" autocomplete="no_lesen_berniaga" autofocus>

                                @error('no_lesen_berniaga')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>
							
							<div class="form-group">
								<label class="font-weight-700 labelku">Alamat Perniagaan </label>
								
                                <div class="row">
                                    <div class="col-md-10 pr-0">
                                        <input id="alamat_perniagaan" type="text" class="form-control-lg form-control @error('alamat_perniagaan') is-invalid @enderror" name="alamat_perniagaan" value="{{ $user->manpower->business_address }}" placeholder="Alamat Perniagaan" autocomplete="alamat_perniagaan" autofocus>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="form-control" onclick="loadMap()"><i class="fa fa-map-marker"></i></button>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input id="place_latitude" name="place_latitude" type="text" class="form-control-lg form-control place-latitude" value="{{ $user->manpower->business_lat }}" placeholder="Latitude" autocomplete="" autofocus readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <input id="place_longitude" name="place_longitude" type="text" class="form-control-lg form-control place-longitude" value="{{ $user->manpower->business_lng }}" placeholder="Longitude" autocomplete="" autofocus readonly>
                                    </div>
                                </div>

							</div>
							
							<div class="form-group">
							    <label class="font-weight-700 labelku">Kategori Perniagaan </label>
                                <input type="hidden" name="id_aktiviti_perniagaan" value="{{ $user->manpower->business_activity }}">
                                <select class="form-control form-control4 form-control-lg select2" name="aktiviti_perniagaan" id="aktiviti_perniagaan" autofocus>
                			        <option selected disabled value="">Pilih Kategori Perniagaan</option>
                			        @foreach($business_activity as $d)
                			        <option value="{{ $d->id_business_activity }}">
                			            {{ $d->business_activity }}
                			        </option>
                			        @endforeach
                			    </select>
							</div>

                            <div class="form-group">
							    <label class="font-weight-700 labelku">Jenis Kategori Perniagaan </label>
                                <input type="hidden" name="id_jenis_kategori_perniagaan" value="{{ $user->manpower->sub_business_activity }}">
                                <select class="form-control form-control4 form-control-lg select2" id="jenis_kategori_perniagaan" name="jenis_kategori_perniagaan[]" multiple="multiple" autofocus>
                			        @foreach($sub_business_activity as $d)
                			        <option value="{{ $d->id_sub_business_activity }}">
                			            {{ $d->sub_business_activity }}
                			        </option>
                			        @endforeach
                			    </select>
							</div>

                            <div class="form-group">
							    <label class="font-weight-700 labelku">Kategori Produk </label>
                                <input type="hidden" name="id_kategori_produk" value="{{ $user->manpower->category_product }}">
                                <select class="form-control form-control4 form-control-lg kategori-produk-select2" id="kategori_produk" name="kategori_produk[]" multiple="multiple" autofocus>
                			        @foreach($category_product as $d)
                			        <option value="{{ $d->id_category_product }}">
                			            {{ $d->category_product }}
                			        </option>
                			        @endforeach
                			    </select>
							</div>

                            <div class="form-group">
							    <div>
							        <label class="font-weight-700 labelku">Logo Perniagaan </label>
							    </div>
								<div class="mb-3">
								    <img id="image_perniagaan" src="/images/upload_image.png" width="100px" alt="Upload Image">
								</div>
								<input type="file" id="img_perniagaan" name="img_perniagaan" onchange="readURLImagePerniagaan(this);" accept="image/*">
								
							</div>
							
							<div class="form-group">
							    <div>
							        <label class="font-weight-700 labelku">Gambar Produk </label>
							    </div>
								<div class="mb-3">
								    <img id="image_produk" src="/images/upload_image.png" width="100px" alt="Upload Image">
								</div>
								<input type="file" id="img_produk" name="img_produk" onchange="readURLImageProduk(this);" accept="image/*">
								
							</div>

                            <div class="form-group">
							    <label class="font-weight-700 labelku">Pendapatan Tahunan </label>
                                <input type="hidden" name="id_pendapatan_tahunan" value="{{ $user->manpower->business_income }}">
                                <select class="form-control form-control4 form-control-lg select2" name="pendapatan_tahunan" id="pendapatan_tahunan" autofocus>
                			        <option selected disabled value="">Pilih Pendapatan Tahunan</option>
                			        @foreach($business_income as $d)
                			        <option value="{{ $d->id_business_income }}">
                			            {{ $d->business_income }}
                			        </option>
                			        @endforeach
                			    </select>
							</div>

                            {{-- <div class="form-group">
							    <label class="font-weight-700 labelku">Kategori Produk <span style="color: #b91c1c;" >*</span> </label>
                                <select class="form-control form-control4 form-control-lg kategori-produk-select2" name="kategori_produk[]" multiple="multiple" required autofocus>
                			    </select>
							</div> --}}
				
							<div class="form-group">
								<label class="font-weight-700 labelku">No Telefon Perniagaan </label>
								<input id="no_telefon_perniagaan" type="text" class="form-control-lg form-control @error('no_telefon_perniagaan') is-invalid @enderror" name="no_telefon_perniagaan" value="{{ $user->manpower->business_phone }}" placeholder="No Telefon Perniagaan" autocomplete="no_telefon_perniagaan" autofocus>

                                @error('no_telefon_perniagaan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>
							
							<div class="form-group">
								<label class="font-weight-700 labelku">Emel Syarikat </label>
								<input id="emel" type="text" class="form-control-lg form-control @error('emel') is-invalid @enderror" name="emel" value="{{ $user->manpower->business_email }}" placeholder="Emel" autocomplete="emel" autofocus>

                                @error('emel')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>
						
                            <div class="form-group">
								<label class="font-weight-700 labelku">Website Syarikat </label>
								<input id="website_syarikat" type="text" class="form-control-lg form-control @error('website_syarikat') is-invalid @enderror" name="website_syarikat" value="{{ $user->manpower->website }}" placeholder="Webiste Syarikat" autocomplete="website_syarikat" autofocus>

                                @error('website_syarikat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>

                            <h4 class="font-weight-700 titleku">PAUTAN MEDIA SOSIAL</h4>
							<p class="font-weight-600"><i>*Pautkan link profil media sosial pertubuhan anda</i></p>
							
							<div class="row after-add-more">
                                <div class="col-md-4 pr-0">
                                    <div class="form-group">
                                        <input type="text" class="form-control-lg form-control" name="medsos[]" placeholder="Media Sosial" autocomplete="" autofocus>
                                    </div>
                                </div>
                                <div class="col-md-6 pr-0">
                                    <div class="form-group">
                                        <input type="text" class="form-control-lg form-control" name="pautan[]" placeholder="Pautan" autocomplete="" autofocus>
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

                            <div class="row copy invisible d-none">
                                <div class="control-group row">
                                    <div class="col-md-4 pr-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control-lg form-control" name="medsos[]" placeholder="Media Sosial" autocomplete="" autofocus>
                                        </div>
                                    </div>
                                    <div class="col-md-6 pr-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control-lg form-control" name="pautan[]" placeholder="Pautan" autocomplete="" autofocus>
                                        </div>
                                    </div>
                                    <div class="col-md-2" style="align-self: center;">
                                        <div class="form-group">
                                            <button class="btn btn-danger remove" type="button"><i class="fa fa-remove"></i></button>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
							
							<div id="btnsubmitku" class="text-left">
								<button class="site-button button-md outline outline-2 btnku btn btn-md" type="submit">Simpan</button>
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

        // var idPersatuan = $('input[name=id_persatuan]').val()
        // $("#persatuan").val(idPersatuan).change();

        

        var idPersatuan = $('input[name=id_persatuan]').val()
        console.log("id:"+idPersatuan)
        if(idPersatuan!=null && idPersatuan!=""){
            var idPersatuan = JSON.parse(idPersatuan)
            console.log("id parse:"+idPersatuan)
            $("#id_persatuan").val(idPersatuan).change();
        }

        var idPegawaiDaerah = $('input[name=id_pegawai_daerah]').val()
        $("#pegawai_daerah").val(idPegawaiDaerah).change();

        var idJenisPendaftaranPerniagaan = $('input[name=id_jenis_pendaftaran_perniagaan]').val()
        $("#jenis_pendaftaran_perniagaan").val(idJenisPendaftaranPerniagaan).change();

        var idJenisKategoriPerniagaan = $('input[name=id_jenis_kategori_perniagaan]').val()
        if(idJenisKategoriPerniagaan!=null && idJenisKategoriPerniagaan!=""){
            var idJenisKategoriPerniagaan = JSON.parse(idJenisKategoriPerniagaan)
            $("#jenis_kategori_perniagaan").val(idJenisKategoriPerniagaan).change();
        }

        var idKategoriProduk = $('input[name=id_kategori_produk]').val()
        if(idKategoriProduk!=null && idKategoriProduk!=""){
            var idKategoriProduk = JSON.parse(idKategoriProduk)
            $("#kategori_produk").val(idKategoriProduk).change();
        }

        var idPendapatanTahunan = $('input[name=id_pendapatan_tahunan]').val()
        $("#pendapatan_tahunan").val(idPendapatanTahunan).change();
        
        var idAktivitiPerniagaan = $('input[name=id_aktiviti_perniagaan]').val()
        $("#aktiviti_perniagaan").val(idAktivitiPerniagaan).change();

        $('.select2').select2()
        $('.kategori-produk-select2').select2()

        var current_select = $('#jenis_pendaftaran_perniagaan').find(":selected").val();
            
        console.log(current_select)

        if(current_select == 1) {
            $("input[name=no_lesen_berniaga]").attr('disabled','true');
            $("input[name=no_lesen_berniaga]").css("background", "#d3d3d35c");

            // ✅ Remove required attribute
            $("input[name=no_lesen_berniaga]").prop('required',false);


        } else {
            $("input[name=no_lesen_berniaga]").removeAttr("disabled");
            $("input[name=no_lesen_berniaga]").css("background", "#f9faff");

            // ✅ Set required attribute
            $("input[name=no_lesen_berniaga]").prop('required',true);
            
        }

        $(document).on('change', '.btn-jenis-pendaftaran-perniagaan', function() {

        var current_select = $('#jenis_pendaftaran_perniagaan').find(":selected").val();

        if(current_select == 1) {
            $("input[name=no_lesen_berniaga]").attr('disabled','true');
            $("input[name=no_lesen_berniaga]").css("background", "#d3d3d35c");

            // ✅ Remove required attribute
            $("input[name=no_lesen_berniaga]").prop('required',false);


        } else {
            $("input[name=no_lesen_berniaga]").removeAttr("disabled");
            $("input[name=no_lesen_berniaga]").css("background", "#f9faff");

            // ✅ Set required attribute
            $("input[name=no_lesen_berniaga]").prop('required',true);
            
        }

        })

        $("#btnsubmitku").click(function () {

            var pegawaiDaerah = $('select[name=pegawai_daerah]').val()

            if(pegawaiDaerah == null){
                alert("Pihak Berkuasa Tempatan wajib dipilih.");
                return false;
            }

            var jenisPendaftaranPerniagaan = $('select[name=jenis_pendaftaran_perniagaan]').val()

            if(jenisPendaftaranPerniagaan == null){
                alert("Jenis Pendaftaran Perniagaan wajib dipilih.");
                return false;
            }

            // var aktivitiPerniagaan = $('select[name=aktiviti_perniagaan]').val()

            // if(aktivitiPerniagaan == null){
            //     alert("Kategori Perniagaan wajib dipilih.");
            //     return false;
            // }

            // var jenisKategoriPerniagaan = $('#jenis_kategori_perniagaan').val()

            // console.log(jenisKategoriPerniagaan)

            // if(jenisKategoriPerniagaan.length === 0){
            //     alert("Jenis Kategori Perniagaan wajib dipilih.");
            //     return false;
            // }

            // var kategoriProduk = $('#kategori_produk').val()

            // if(kategoriProduk.length === 0){
            //     alert("Kategori Produk wajib dipilih.");
            //     return false;
            // }

            // var pendapatanTahunan = $('select[name=pendapatan_tahunan]').val()

            // if(pendapatanTahunan == null){
            //     alert("Pendapatan Tahunan wajib dipilih.");
            //     return false;
            // }

            return true;
        });
        
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
   
    
    function readURLImagePerniagaan(input) {
        if (input.files && input.files[0]) {
        var reader = new FileReader();
    
        reader.onload = function (e) {
            $('#image_perniagaan').attr('src', e.target.result).width(100).height(74);
        };
    
        reader.readAsDataURL(input.files[0]);
        }
    }
        
    function readURLImageProduk(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
    
        reader.onload = function (e) {
          $('#image_produk').attr('src', e.target.result).width(100).height(74);
        };
    
        reader.readAsDataURL(input.files[0]);
      }
    }
    
</script>
@include('employee.register.mapbox')
@endsection    