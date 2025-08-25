@extends('login.template')
@section('title-dashboard', 'Manpower')
@section('title', 'Semak Pendaftaran')
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
        padding: 0 20px;
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
				<h3 class="font-weight-700 m-t0 m-b20 titleku">Semakan keahlian USIA</h3>
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
						<form action="/semak_pendaftaran_result" method="GET" enctype="multipart/form-data">
                            @csrf
							<h4 class="font-weight-700 labelku">Sila masukkan nombor kad pengenalan untuk menyemak keahlian USIA anda</h4>
							{{-- <p class="font-weight-700 labelku">Belum mendaftar?<br>  Klik<a href="{{ url('register_ahli/create') }}" style="color: #b91c1c;"><b> Ahli</b></a> untuk Individu <br> Klik<a href="{{ url('register_company/create') }}" style="color: #b91c1c;"><b> Persatuan</b></a> jika Pengerusi / Setiausaha Persatuan <br> Klik <a href="{{ url('register_company/create') }}" style="color: #b91c1c;"><b> Koperasi</b></a> jika Setiausaha ALK</p> --}}

                            <div class="form-group">
								<label class="font-weight-700 labelku">No Kad Pengenalan <span style="color: #b91c1c;" >*</span> </label>
								<input id="no_kad" type="number" class="form-control-lg form-control @error('no_kad') is-invalid @enderror" name="no_kad" value="{{ old('no_kad') }}" placeholder="No Kad" required autocomplete="no_kad" autofocus>

                                @error('no_kad')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>

							<div id="btnsubmitku" class="text-left">
								<button class="site-button button-md outline outline-2 btnku btn btn-md" type="submit">Semak Keahlian</button>
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
<script type="text/javascript">

    $(function () {

        var urlParams = new URLSearchParams(window.location.search);
        console.log(urlParams.get("email"));

        $("#email").val(urlParams.get("email"))

        if(urlParams.get("email") != "" && urlParams.get("email") != null) {
            $("#email").attr('readonly','true');
            $("#email").css("background", "#d3d3d35c");
        }

        $("#btnsubmitku").click(function () {
            var password = $("#password").val();
            var confirmPassword = $("#password-confirm").val();
            if (password !== confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }
            return true;
        });

    });

</script>
@endsection
