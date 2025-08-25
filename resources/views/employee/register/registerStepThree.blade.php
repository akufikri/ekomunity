@extends('login.template')
@section('title-dashboard', 'Ahli')
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
						<form action="/register_ahli/step_three_update" method="POST" enctype="multipart/form-data">
                            @csrf
							<h4 class="font-weight-700 titleku">MAKLUMAT PENDIDIKAN</h4>
							
							<div class="form-group">
							    <label class="font-weight-700 labelku">Taraf Pendidikan </label>
                                <select class="form-control form-control4 form-control-lg select2" name="status_education">
                			        <option selected disabled value="">Pilih Taraf Pendidikan</option>
                			        @foreach($status_education as $d)
                			        <option value="{{ $d->id_status_education }}">
                			            {{ $d->status_education }}
                			        </option>
                			        @endforeach
                			    </select>
							</div>

                            <div class="form-group">
							    <label class="font-weight-700 labelku">Bidang </label>
                                <select class="form-control form-control4 form-control-lg select2" name="bidang">
                			        <option selected disabled value="">Pilih Bidang </option>
                			        @foreach($study as $d)
                			        <option value="{{ $d->id_study }}">
                			            {{ $d->study }}
                			        </option>
                			        @endforeach
                			    </select>
							</div>
							
							<div class="form-group">
                                <h4 class="font-weight-700 titleku">Sijil Kemahiran <span style="color: #b91c1c;" ><i>* jika ada</i></span></h4>
                                <p class="font-weight-600"><i>*Masukan sijil kemahiran yang pernah diikuti beserta dengan tahun partisipasi</i></p>
								{{-- <label class="font-weight-700 labelku">Sijil Kemahiran <span style="color: #b91c1c;" >* Jika ada</span> </label> --}}
								{{-- <input id="sijil_kemahiran" type="text" class="form-control-lg form-control @error('sijil_kemahiran') is-invalid @enderror" name="sijil_kemahiran" value="{{ old('sijil_kemahiran') }}" placeholder="Sijil Kemahiran" required autocomplete="sijil_kemahiran" autofocus> --}}

                                <div class="row">
                                    <div class="col-md-7 pr-0">
                                        <label class="font-weight-700 labelku">Sijil Kemahiran</label>
                                    </div>
                                    <div class="col-md-3 pr-0">
                                        <label class="font-weight-700 labelku">Tahun</label>
                                    </div>
                                </div>

                                <div class="row after-add-more">
                                    <div class="col-md-7 pr-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control-lg form-control" name="sijil_kemahiran[]" placeholder="" autocomplete="" autofocus>
                                        </div>
                                    </div>
                                    <div class="col-md-3 pr-0">
                                        <div class="form-group">
                                            <input type="number" class="form-control-lg form-control" name="sijil_kemahiran_tahun[]" placeholder="" autocomplete="" autofocus>
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
                                        <div class="col-md-7 pr-0">
                                            <div class="form-group">
                                                <input type="text" class="form-control-lg form-control" name="sijil_kemahiran[]" placeholder="" autocomplete="" autofocus>
                                            </div>
                                        </div>
                                        <div class="col-md-3 pr-0">
                                            <div class="form-group">
                                                <input type="text" class="form-control-lg form-control" name="sijil_kemahiran_tahun[]" placeholder="" autocomplete="" autofocus>
                                            </div>
                                        </div>
                                        <div class="col-md-2" style="align-self: center;">
                                            <div class="form-group">
                                                <button class="btn btn-danger remove" type="button"><i class="fa fa-remove"></i></button>
                                            </div>
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

        $('.select2').select2();

        $("#btnsubmitku").click(function () {
            
            // var statusEducation = $('select[name=status_education]').val();
            // var bidang = $('select[name=bidang]').val();

            // if(statusEducation == null){
            //     alert("Taraf pendidikan wajib dipilih.");
            //     return false;
            // }

            // if(bidang == null){
            //     alert("Bidang wajib dipilih.");
            //     return false;
            // }

            return true;
        });
    });
    
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
@endsection    