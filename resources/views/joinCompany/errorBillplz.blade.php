@extends('login.template')
@section('title-dashboard', 'Ahli')
@section('title', 'Pembayaran')
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
                            <div class="mb-3" style="text-align:center">
								    <img id="image" src="/images/mdi_cod.png" width="100px" alt="Upload Image">
							</div>
							<h4 class="font-weight-700 titleku" style="text-align:center">Kaedah Pembayaran mempunyai masalah teknikal</h4>
							<p class="font-weight-600" style="text-align:center">Sila Hubungi Setiausaha Persatuan atau Bayar Keahlian dengan tunai</p>
							
							<div id="btnsubmitku" class="text-right">
                                <a href="/payment_cash?id={{ $ref }}"><button style="width:100%" class="site-button button-md outline outline-2 btnku btn btn-xl d-block" type="submit">Bayar Sekarang (Cash)</button></a><br>
                            </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
@endsection    