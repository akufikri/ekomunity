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
				<h3 class="font-weight-700 m-t0 m-b20 titleku">Pembayaran Keahlian </h3>
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
				<div class="p-a30 border-1  max-w800 m-auto">
					<div class="tab-content">
						<form action="/register_ahli/create_payment" method="POST" enctype="multipart/form-data">
                            @csrf
							<h4 class="font-weight-700 titleku">BAYAR DENGAN CASH</h4>

							<div class="form-group">
							    <div>
							        <label class="font-weight-700 labelku">Muat naik bukti pembayaran  <span style="color: #b91c1c;" >*</span> </label>
							    </div>
                                <input type="text" name="ref" hidden>
								<div class="mb-3">
								    <img id="image" src="/images/upload_image.png" width="100px" alt="Upload Image">
								</div>
								<input type="file" id="img" name="img" onchange="readURL(this);" accept="image/*" required>
								
							</div>
							@if(Auth::user()->id_level != '1')
							<p class="font-weight-600"><i>Pembayaran akan dilakukan pengecekan oleh admin, selama waktu tersebut akun anda akan ditangguhkan</i></p>
							@else
                            <br>
                            @endif
							<div id="btnsubmitku" class="text-right">
						    	<button style="width:100%" class="site-button button-md outline outline-2 btnku btn btn-xl d-block" type="submit">Hantar Permohonan</button>
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

        var queryString = window.location.search;
        var urlParams = new URLSearchParams(queryString);

        $('input[name=ref]').val(urlParams.get('ref'));

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