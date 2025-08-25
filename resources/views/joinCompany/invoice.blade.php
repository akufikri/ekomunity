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
				<h3 class="font-weight-700 m-t0 m-b20 titleku">Invois Join Persatuan </h3>
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
							<h4 class="font-weight-700 titleku">INVOIS</h4>
                            <h4 class="font-weight-700 titleku">Detail Pendaftar</h4>

                            <p class="font-weight-600">Pastikan nama dan detail yang tercantum sesuai dengan data anda</p>
							<hr>

                            <h6 class="labelku">Nama Persatuan</h6>
							<p class="">{{ $data->company->full_company_name }}</p>
							
							<h6 class="labelku">Nama Penuh</h6>
							<p class="">{{ $data->manpower->user->fullname }}</p>
							
							<h6 class="labelku">Emel</h6>
							<p class="">{{ $data->manpower->user->email }}</p>

                            <h6 class="labelku">No. Telefon</h6>
							<p class="">{{ $data->manpower->user->phone_number }}</p>
							
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
							        <td style="text-align:start;">Yuran Persatuan</td>
							        <td>1X</td>
							        <td style="text-align:center;">RM {{ $data->joining_fee == null ? '0' : $data->joining_fee }}</td>
							        <td style="text-align:center;">RM {{ $data->joining_fee == null ? '0' : $data->joining_fee }}</td>
							    </tbody>
							</table>
							
							<hr>
							
							<table>
							    <thead>
							        <th>Total</th>
							        <th width="20%" style="text-align:center;">RM {{ $data->joining_fee == null ? '0' : $data->joining_fee }}</th>
							    </thead>
							</table>
							
							<div id="btnsubmitku" class="text-right">
                                @if($data->joining_fee == null || $data->joining_fee == '0')
                                <a href="/payment_cash?id={{ $data->id }}"><button style="width:100%" class="site-button button-md outline outline-2 btnku btn btn-xl d-block" type="submit">Daftar dengan percuma</button></a><br>
                                @else
                                <a href="/payment_cash?id={{ $data->id }}"><button style="width:100%" class="site-button button-md outline outline-2 btnku btn btn-xl d-block" type="submit">Bayar Sekarang (Cash)</button></a><br>
						    	@if($data->company->collection_id != null && $data->company->secret_key != null)
                                <a href="/create_bill_join_company?id={{$data->id}}"><button style="width:100%" class="site-button button-md outline outline-2 btnku btn btn-xl d-block" type="submit">Bayar Sekarang via Payment Gateway</button></a>
                                @endif
                                @endif
                            </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript"></script>
@endsection    