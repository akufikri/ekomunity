@extends('login.template')
@section('title-dashboard', 'Ahli')
@section('title', 'Payment')
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
        .form-control-lg {
            height: calc(2.875rem + 2px) !important;
            padding: 1rem .8rem !important;
            font-size: 13px !important;
            line-height: 1.5 !important;
            border-radius: .3rem !important;
        }

        .labelku {
            font-size: 15px;
        }

        .titleku {
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

        .separator {
            display: flex;
            align-items: center;
            text-align: center;
        }

        .separator::before,
        .separator::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #000;
        }

        .separator:not(:empty)::before {
            margin-right: .25em;
        }

        .modal-header {
            background: #5d0f0f;
            padding: 15px 25px;
        }

        .separator:not(:empty)::after {
            margin-left: .25em;
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
                            <form action="" class="form-payment" method="GET" enctype="multipart/form-data">
                                <h4 class="font-weight-700 titleku">PEMBAYARAN</h4>
                                <p class="font-weight-600"><i>Pilih kaedah pembayaran keahlian</i></p>

                                <hr>

                                <h4 class="font-weight-700 titleku">TAGIHAN</h4>

                                <table>
                                    <thead>
                                        <th>Barang</th>
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

                                <table>
                                    <thead>
                                        <th>Total</th>
                                        <th width="20%" style="text-align:center;">RM {{ $setting_subscribe->price }}
                                        </th>
                                    </thead>
                                </table>

                                {{-- <div class="text-right">
						    	<input style="width:100%" class="site-button button-md outline outline-2 btnku btn btn-xl d-block" type="submit" value="Bayar dengan cash"><br>
							</div> --}}
                            </form>
                            @if ($setting_subscribe->price != '0')
                                <div class="text-right">
                                    <a href=""><button style="width:100%" onclick="window.location.href='/create_bill_subscribe_ahli?id={{ $encrypt }}'"
                                            class="site-button button-md outline outline-2 btnku btn btn-xl d-block">Bayar via Payment Gateway</button></a>
                                </div>
                            @endif
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: white">
                    <p class="modal-title" style="color: black;" id="exampleModalLabel">Terms & Conditions</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
                $term = App\Models\Term::where('id_level', 3)->get();
                ?>
                <div class="modal-body" style="overflow: auto; height: 400px; padding: 10px;">
                    @foreach ($term as $terms)
                        <p style="font-size:10px; text-align:justify;">{{ $terms->term_conditions }}</p>
                    @endforeach
                </div>
                <div class="modal-footer" style="height: 50px;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!--DETAIL PAYMENT-->
    <div class="modal" id="detailPayment">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <form action="" method="POST" class="form-update-data" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel">Link Payment</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body my-table">
                        <div class="form-group content-payment">

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--END DETAIL PAYMENT-->

    @include('layouts.modals')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="/js/page/employee/register/payment.js"></script>
@endsection
