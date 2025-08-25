@extends('login.template')
@section('title-dashboard', 'Ahli')
@section('title', 'Invoice')
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
				<div class="p-a30 border-1  max-w800 m-auto">
					<div class="tab-content">
							<h4 class="font-weight-700 titleku">Invois</h4>
							<hr>

							<h4 class="font-weight-700 titleku">Price Details</h4>

							<table>
							    <thead>
							        <th>Barang</th>
							        <th width="10%">Jumlah</th>
							        <th width="20%" style="text-align:center;">Harga</th>
							        <th width="20%" style="text-align:center;">Total</th>
							    </thead>
							    <tbody>
							        <td style="text-align:start;">Kad keahlian USIA</td>
							        <td>1X</td>
							        <td style="text-align:center;">RM {{ $data->price_company_card }}</td>
							        <td style="text-align:center;">RM {{ $data->price_company_card }}</td>
							    </tbody>
							</table>

							<hr>

							<table>
							    <thead>
							        <th>Total</th>
							        <th width="20%" style="text-align:center;">RM {{ $data->price_company_card }}</th>
							    </thead>
							</table>

							<div id="btnsubmitku" class="text-right">
						    	<a href="/create_bill_company_card?id_user={{$auth->id}}"><button style="width:100%" class="site-button button-md outline outline-2 btnku btn btn-xl d-block" type="submit">Bayar Sekarang</button></a>
							</div>
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
