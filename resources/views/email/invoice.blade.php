@extends('email.template')
@section('content')

<head>
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
</head>

<body>
    <div class="section-full content-inner shop-account">
        <div class="container">
        <div class="row">
			<div class="col-md-12 text-center">
				<h3 class="font-weight-700 m-t0 m-b20 titleku">Invois Pendaftaran Portal USIA </h3>
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
						<form action="#" method="POST" enctype="multipart/form-data">
                            @csrf
							<h4 class="font-weight-700 titleku">INVOIS</h4>
							<p class="font-weight-600"><i>Invoice juga telah di hantarkan ke akaun emel anda {{ $user->email }}</i></p>
							<hr>
							<h4 class="font-weight-700 titleku">MAKLUMAT PRIBADI PENDAFTAR</h4>

							<h4 class="labelku">Nama Penuh</h4>
							<p class="">{{ $user->fullname }}</p>

							<h4 class="labelku">No. Telefon</h4>
							<p class="">{{ $user->phone_number }}</p>

							<h4 class="labelku">Emel</h4>
							<p class="">{{ $user->email }}</p>

							<hr>

							<h4 class="font-weight-700 titleku">PEMBAYARAN</h4>

							<table>
							    <thead>
							        <th style="text-align:start;">Barang</th>
							        <th width="10%">Jumlah</th>
							        <th width="20%" style="text-align:center;">Harga Unit</th>
							        <th width="20%" style="text-align:center;">Harga Total</th>
							    </thead>
							    <tbody>
							        <td style="text-align:start;">{{ $setting_subscribe->subscribe_name }}</td>
							        <td>1X</td>
							        <td style="text-align:center;">RM {{ $setting_subscribe->price }}</td>
							        <td style="text-align:center;">RM {{ $setting_subscribe->price }}</td>
							    </tbody>
							</table>

							<hr>

							<br>
							<div id="btnsubmitku" class="text-right">
						    	<button style="width:100%" class="site-button button-md outline outline-2 btnku btn btn-xl d-block" type="submit">Pilih Pembayaran Keahlian</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
    </div>
</body>
@endsection
