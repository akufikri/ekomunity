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
				<h3 class="font-weight-700 m-t0 m-b20 titleku">Pendaftaran Ahli Datappk Baharu! </h3>
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
				<div class="p-a30 border-0  max-w800 m-auto">
					<div class="tab-content">
																										
							<table>
                                <tbody>
							        <td style="text-align:start;">Tarikh</td>
							        <td>:</td>
							        <td>{{$tarikh_pendaftaran}}</td>
							    </tbody>
							    <tbody>
							        <td style="text-align:start;">Nama Ahli</td>
							        <td>:</td>
							        <td>{{$nama_ahli}}</td>
							    </tbody>
                                <tbody>
							        <td style="text-align:start;">NRIC</td>
							        <td>:</td>
							        <td>{{$nric}}</td>
							    </tbody>
                                <tbody>
							        <td style="text-align:start;">Pembayaran Ahli</td>
							        <td>:</td>
							        <td>RM{{$pembayaran_ahli}}</td>
							    </tbody>
                                <tbody>
							        <td style="text-align:start;">Daerah</td>
							        <td>:</td>
							        <td>{{$daerah}}</td>
							    </tbody>
                                <tbody>
							        <td style="text-align:start;">Pejabat Daerah</td>
							        <td>:</td>
							        <td>{{$pejabat_daerah}}</td>
							    </tbody>
                                <tbody>
							        <td style="text-align:start;">Nama Perniagaan</td>
							        <td>:</td>
							        <td>{{$nama_perniagaan}}</td>
							    </tbody>
							    
							</table>
							
                            <h4 class="font-weight-600 titleku">Jumlah Pendaftaran Terkini : {{$jumlah_pendaftar}}</h4>

					</div>
				</div>
			</div>
		</div>
	</div>
    </div>
</body>
    
@endsection












