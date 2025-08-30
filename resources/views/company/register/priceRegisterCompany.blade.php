@extends('login.template')
@section('title-dashboard', 'Company')
@section('title', 'Register')
@section('content')
    <style>
        .btnku {
            background-color: white !important;
            color: #383444 !important;
            border: 2px solid #383444 !important;
        }

        .btnku:hover {
            background-color: #383444 !important;
            color: white !important;
        }

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
                    <h3 class="font-weight-700 m-t0 m-b20 titleku">PILIH PACKAGES</h3>
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
            <div class="row" id="packages-container">
                <!-- Card akan diinject disini -->
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: "/packages/getData",
                dataType: "JSON",
                success: function(res) {
                    if (res.success) {
                        let html = '';

                        res.data.forEach(pkg => {
                            let priceText = pkg.price == 0 ? "FREE!" : `RM ${pkg.price}`;

                            let benefits = '';
                            pkg.benefit.forEach(b => {
                                benefits += `
                                    <li>
                                        <i class="fa ${b.is_include ? 'fa-check text-success' : 'fa-times text-danger'}"></i>
                                        ${b.name}
                                    </li>
                                `;
                            });

                            html += `
                                <div class="col-md-4 m-b30">
                                    <div class="p-a30 border-1 max-w500 m-auto text-center">
                                        <div class="container">
                                            <h4>${pkg.title}</h4>
                                            <h2>${priceText}</h2>
                                            <ul class="text-left" style="margin-top:15px;">
                                                ${benefits}
                                            </ul>
                                            <button class="btn btnku mt-3 btn-choose-package"
                                                data-id="${pkg.id}"
                                                data-price="${pkg.price}"
                                                data-expired="${pkg.expired}">
                                                ${pkg.is_premium ? 'Upgrade Sekarang' : 'Gabung Sekarang'}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });

                        $("#packages-container").html(html);

                        // klik button
                        $(".btn-choose-package").on("click", function() {
                            let id = $(this).data("id");
                            let price = parseInt($(this).data("price"), 10); // pastikan integer
                            let expired = parseInt($(this).data("expired"),
                            10); // kalau expired juga angka

                            window.location.href =
                                `/register_company/create?id=${id}&price=${price}&expired=${expired}`;
                        });
                    }
                }
            });
        });
    </script>
@endsection
