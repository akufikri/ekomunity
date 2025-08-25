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
				<h3 class="font-weight-700 m-t0 m-b20 titleku">Pendaftaran Peribadi</h3>
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
						<form action="" class="form-register" method="POST" enctype="multipart/form-data">
                            @csrf
							<h4 class="font-weight-700 titleku">Samb. MAKLUMAT PERIBADI</h4>

							<div class="form-group">
								<label class="font-weight-700 labelku">Alamat Perhubungan </label>
								<textarea id="alamat_perhubungan" type="alamat_perhubungan" class="form-control-lg form-control @error('alamat_perhubungan') is-invalid @enderror" name="alamat_perhubungan" autocomplete="alamat_perhubungan"></textarea>

                                @error('alamat_perhubungan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>

							<div class="form-group selectNegeri">
							    <label class="font-weight-700 labelku">Negeri <span style="color: #b91c1c;" >*</span> </label>
                                <input type="hidden" name="temp_id_state" id="temp_id_state">
                                <select class="form-control form-control4 form-control-lg select2" name="negeri" id="negeri" autofocus required>
                			        <option selected disabled value="">Pilih Negeri</option>
                			        @foreach($state as $d)
                			        <option value="{{ $d->id_state }}">{{ $d->state }}</option>
                			        @endforeach
                			    </select>
							</div>

							<div class="form-group">
							    <label class="font-weight-700 labelku">Daerah/Bandar <span style="color: #b91c1c;" >*</span> </label>
                                <select class="form-control form-control4 form-control-lg select2" name="bandar" id="bandar" autofocus required>
                			        <option selected disabled value="">Pilih Bandar</option>

                			    </select>
							</div>

                            <div class="form-group">
                                <input type="hidden" name="temp_id_parliament" id="temp_id_parliament">
							    <label class="font-weight-700 labelku">Parlimen <span style="color: #b91c1c;" >*</span> </label>
                                <select class="form-control form-control4 form-control-lg select2" name="parliament" id="parliament" autofocus required>
                			        <option selected disabled value="">Pilih Parlimen</option>

                			    </select>
							</div>

                            <div class="form-group">
							    <label class="font-weight-700 labelku">DUN <span style="color: #b91c1c;" >*</span> </label>
                                <select class="form-control form-control4 form-control-lg select2" name="dun" id="dun" autofocus required>
                			        <option selected disabled value="">Pilih DUN</option>

                			    </select>
							</div>

							<div class="form-group">
								<label class="font-weight-700 labelku">Poskod </label>
								<input id="poskod" type="number" class="form-control-lg form-control @error('poskod') is-invalid @enderror" name="poskod" value="{{ old('poskod') }}" placeholder="Poskod" autocomplete="poskod" autofocus>

                                @error('poskod')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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

@include('layouts.modals')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="/js/page/employee/register/registerStepTwo.js"></script>
@endsection
