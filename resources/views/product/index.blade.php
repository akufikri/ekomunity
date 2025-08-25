@extends('home')
@section('title-dashboard', 'Ahli')

@section('title', 'Produk')

@section('breadcrumb')

    <li class="breadcrumb-item active">Produk</li>

@endsection

@section('content')

    <style>
        .select2-container--default .select2-selection--single {
            border: 1px solid #ced4da;
            height: calc(2.875rem + 2px) !important;
            padding: .8rem .6rem 2.1rem .6rem;
            font-size: 13px;
            line-height: 1.5;
            border-radius: .3rem;
        }

        .form-control-lg2 {
            border: 1px solid #ced4da;
            height: calc(2.875rem + 2px) !important;
            padding: .8rem .6rem 2.1rem .6rem;
            font-size: 13px;
            line-height: 1.5;
            border-radius: .3rem;
        }

        .form-control-lg {
            height: calc(2.875rem + 2px);
            padding: 1rem .8rem;
            font-size: 13px;
            line-height: 1.5;
            border-radius: .3rem;
        }

        .form-control-lgku {
            height: calc(2.875rem + 2px);
            padding: 2rem 1.2rem;
            font-size: 13px;
            line-height: 1.5;
            border-radius: .3rem;
        }

        .filldata {
            font-weight: normal !important;
        }

        #label_form {
            padding-bottom: 8px;
            font-size: 15px;
        }

        .label_form_judul {
            font-size: 13px !important;
            margin-bottom: 0px;
        }

        .my-button {
            font-size: 15px;
        }

        .my-header {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 0px;
        }
    </style>

    <div class="row">
        <div class="col-12">
            <div class="card card-danger card-outline" style="border-top: 3px solid dark">
                <div class="card-header">
                    <h3 class="card-title text-danger my-header">Produk</h3>
                </div>

                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        {{ $message }}
                        <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                    </div>
                @elseif ($message = Session::get('warning'))
                    <div class="alert alert-warning">
                        {{ $message }}
                        <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                    </div>
                @endif

                <div class="card-body">
                    @if($product->isEmpty())
                        <div class="row">
                            <div class="col-lg-12" style="text-align: center;">
                                <div class="alert alert-danger">
                                    Anda belum mempunyai produk
                                </div>
                                <img src="/landingpage/images/logo1.png" alt="Logo" class="" style="width: 280px;">
                            </div>
                            <div class="col-lg-12 mt-3" style="text-align: center;">
                                <a class="btn btn-md" style="color: #cf1e7b; background: #fff;" data-toggle="modal"
                                    data-target="#addModal" href="#">+ Tambah Produk</a><br><br>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            @foreach ($product as $item)
                                <div class="col-md-3 col-sm-6 col-12">
                                    <span class="info-box-text"><b>{{ $item->product_name }}</b></span>
                                    <div class="info-box mt-1" style="justify-content: center;">
                                        <a href="/maklumatProduk/show/{{ $item->id }}"><img
                                                src="/product/{{ $item->product_image }}" alt="{{ $item->product_name }}"
                                                height="200" width="200"></a>
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                            @endforeach

                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h3 class="card-title text-danger my-header">Tambah Produk lain</h3>
                            </div>
                            <div class="col-md-12">
                                <div class="info-box mt-3" style="justify-content: center;">

                                    <a href="" data-toggle="modal" data-target="#addModal"><img
                                            src="/images/upload_product.png" alt="upload product" width="100%"></a>
                                </div>
                                <!-- /.info-box -->
                            </div>
                        </div>
                    @endif


                </div>
            </div>

            <div class="card card-danger card-outline" style="border-top: 3px solid dark">
                <div class="card-header">
                    <h3 class="card-title text-danger my-header">Kilang Pemproses</h3>
                </div>
                @if ($manpower->factory_address != null)
                    <div class="card-body">
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Alamat</label>
                            <input type="text" value="{{ $manpower->factory_address }}"
                                class="form-control form-control-lg" placeholder="" name="" readonly>
                        </div>
                        <input type="button" id="" data-toggle="modal" data-target="#addressKilangModal"
                            value="Edit" style="padding: 10px;margin: 0px;float: left;"
                            class="btn btn-sm btn-danger col-md-2"><br><br>
                    </div>
                @else
                    <div class="card-body">
                        <p>Anda tidak mempunyai Kilang proses</p>
                        <input type="button" id="" data-toggle="modal" data-target="#kilangModal"
                            value="Kemaskini" style="padding: 10px;margin: 0px;float: left;"
                            class="btn btn-md btn-danger col-md-2"><br><br>
                    </div>
                @endif

            </div>

            <div class="card card-danger card-outline" style="border-top: 3px solid dark">
                <div class="card-header">
                    <h3 class="card-title text-danger my-header">Status Halal</h3>
                </div>
                @if ($manpower->halal_certificate != null)
                    <div class="card-body">
                        <div class="form-group">
                            <img src="/halalCertificate/{{$manpower->halal_certificate}}" alt="{{$manpower->halal_certificate}}" width="150">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-700 labelku">No. Sijil Halal</label>
                            <input type="text" value="{{ $manpower->halal_certificate_number }}"
                                class="form-control form-control-lg" placeholder="" name="" readonly>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Tarikh luput</label>
                            <input type="text" value="{{ $manpower->halal_certificate_date }}"
                                class="form-control form-control-lg" placeholder="" name="" readonly>
                        </div>
                        <input type="button" id="" data-toggle="modal" data-target="#submitHalalModal"
                            value="Edit" style="padding: 10px;margin: 0px;float: left;"
                            class="btn btn-sm btn-danger col-md-2"><br><br>
                    </div>
                @else
                <div class="card-body">
                    <p>Anda tidak mempunyai Status Halal</p>
                    <input type="button" id="" data-toggle="modal" data-target="#halalModal" value="Kemaskini"
                        style="padding: 10px;margin: 0px;float: left;" class="btn btn-sm btn-danger col-md-2"><br><br>


                </div>
                @endif
            </div>

            <div class="card card-danger card-outline" style="border-top: 3px solid dark">
                <div class="card-header">
                    <h3 class="card-title text-danger my-header">Status GMP</h3>
                </div>
                @if ($manpower->gmp_certificate != null)
                    <div class="card-body">
                        <div class="form-group">
                            <img src="/gmpCertificate/{{$manpower->gmp_certificate}}" alt="{{$manpower->gmp_certificate}}" width="150">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-700 labelku">No. Sijil GMP</label>
                            <input type="text" value="{{ $manpower->gmp_certificate_number }}"
                                class="form-control form-control-lg" placeholder="" name="" readonly>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Tarikh luput</label>
                            <input type="text" value="{{ $manpower->gmp_certificate_date }}"
                                class="form-control form-control-lg" placeholder="" name="" readonly>
                        </div>
                        <input type="button" id="" data-toggle="modal" data-target="#submitGmpModal"
                            value="Edit" style="padding: 10px;margin: 0px;float: left;"
                            class="btn btn-sm btn-danger col-md-2"><br><br>
                    </div>
                @else
                <div class="card-body">
                    <p>Anda tidak mempunyai Status GMP</p>
                    <input type="button" id="" data-toggle="modal" data-target="#gmpModal" value="Kemaskini"
                        style="padding: 10px;margin: 0px;float: left;" class="btn btn-sm btn-danger col-md-2"><br><br>


                </div>
                @endif
            </div>

            <div class="card card-danger card-outline" style="border-top: 3px solid dark">
                <div class="card-header">
                    <h3 class="card-title text-danger my-header">Status KKM</h3>
                </div>
                @if ($manpower->kkm_certificate != null)
                    <div class="card-body">
                        <div class="form-group">
                            <img src="/kkmCertificate/{{$manpower->kkm_certificate}}" alt="{{$manpower->kkm_certificate}}" width="150">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-700 labelku">No. Sijil KKM</label>
                            <input type="text" value="{{ $manpower->kkm_certificate_number }}"
                                class="form-control form-control-lg" placeholder="" name="" readonly>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Tarikh luput</label>
                            <input type="text" value="{{ $manpower->kkm_certificate_date }}"
                                class="form-control form-control-lg" placeholder="" name="" readonly>
                        </div>
                        <input type="button" id="" data-toggle="modal" data-target="#submitKkmModal"
                            value="Edit" style="padding: 10px;margin: 0px;float: left;"
                            class="btn btn-sm btn-danger col-md-2"><br><br>
                    </div>
                @else
                <div class="card-body">
                    <p>Anda tidak mempunyai Status KKM</p>
                    <input type="button" id="" data-toggle="modal" data-target="#kkmModal" value="Kemaskini"
                        style="padding: 10px;margin: 0px;float: left;" class="btn btn-sm btn-danger col-md-2"><br><br>


                </div>
                @endif
            </div>
        </div>

    </div>

    <!--ADD MODAL-->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Produk Baharu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body my-table" style="text-align: center;">

                    <img src="/images/info.png" alt="Logo" class="" style="width: 60px;">

                    <p class="mt-3"><b>Adakah anda mempunyai produk buatan / keluaran sendiri?</b><br>Produk berasal
                        dari jenama asli anda sendiri BUKAN dari hasil pajak peniaga lain</p>
                    <div class="row" style="justify-content: center;">
                        <a class="btn btn-md col-lg-5"
                            style="padding: 10px;margin: 20px;color: darkred;background: #eae4e4;float: left;"
                            href="#" data-dismiss="modal">Tidak</a>
                        <a class="btn btn-md btn-danger col-lg-5" style="padding: 10px;margin: 20px;float: left;"
                            href="/maklumatProduk/create">Ya</a><br><br>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--END ADD MODAL-->

    <!--KILANG MODAL-->
    <div class="modal fade" id="kilangModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Kilang Proses</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body my-table" style="">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Adakah anda mempunyai Kilang proses sendiri?
                            </label>
                        </div>
                        <div class="form-group" style="margin-top: 30px;">
                            <a class="btn btn-md" style="color: darkred;background: #eae4e4;float:left;width:48%;"
                                href="#" data-dismiss="modal">Tidak</a>
                            <a data-toggle="modal" href="#" data-target="#addressKilangModal"
                                class="btn btn-md btn-danger" style="width:48%;float: right;">Ya</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--END KILANG MODAL-->

    <!--ADDRESS KILANG MODAL-->
    <div class="modal fade" id="addressKilangModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Kilang Proses</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body my-table" style="">
                    <form action="/maklumatKilang/update" method="POST">
                        @csrf
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-700 labelku">Sila isi alamat dibawah
                                </label>
                                <textarea class="form-control" name="factory_address" rows="3" cols="50" required>{{ $manpower->factory_address }}</textarea>
                            </div>
                            <div class="form-group">
                                <input type="button" style="width:100%;color: white;background: #61DA71;"
                                    onclick="loadMap()" value="PIN MAP LOCATION" title="PIN MAP LOCATION"
                                    class="btn btn-md btn-info">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-700 labelku">Latitude</label>
                                <input id="place_latitude" name="place_latitude" type="text"
                                    value="{{ isset($manpower->factory_lat) ? $manpower->factory_lat : '' }}"
                                    class="form-control form-control-lg place-latitude" placeholder="" required readonly
                                    autofocus>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-700 labelku">Longitude</label>
                                <input id="place_longitude" name="place_longitude" type="text"
                                    value="{{ isset($manpower->factory_lng) ? $manpower->factory_lng : '' }}"
                                    class="form-control form-control-lg place-longitude" placeholder="" required readonly
                                    autofocus>
                            </div>
                            <div class="form-group" style="margin-top: 30px;">
                                <a class="btn btn-md" style="color: darkred;background: #eae4e4;float:left;width:48%;"
                                    href="#" data-dismiss="modal">Kembali</a>
                                <input type="submit" value="Simpan" title="Simpan" class="btn btn-md btn-danger"
                                    style="width:48%;float: right;">
                            </div>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>
    <!--END KILANG MODAL-->

    <!--HALAL MODAL-->
    <div class="modal fade" id="halalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Status Halal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body my-table" style="">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Adakah anda mempunyai sijil halal?
                            </label>
                            <p>Status Halal JAKIM merujuk kepada pengiktirafan atau pensijilan bahawa sesuatu produk,
                                perkhidmatan,
                                atau proses mematuhi syarat-syarat yang ditetapkan oleh syariat Islam.</p>

                        </div>
                        <div class="form-group" style="margin-top: 30px;">
                            <a class="btn btn-md" style="color: darkred;background: #eae4e4;float:left;width:48%;"
                                href="#" data-dismiss="modal">Tidak</a>
                            <a data-toggle="modal" href="#" data-target="#submitHalalModal"
                                class="btn btn-md btn-danger" style="width:48%;float: right;">Ya</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--END HALAL MODAL-->

    <!--SUBMIT HALAL MODAL-->
    <div class="modal fade" id="submitHalalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Maklumat Sijil Halal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body my-table" style="">
                    <form action="/maklumatHalal/update" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12">
                            <div class="form-group">
                                <div>
                                    <label class="font-weight-700 labelku">Muat naik Sijil Halal </label>
                                </div>

                                <div class="mb-3">
                                    <img id="image_halal" src="/halalCertificate/{{ $manpower->halal_certificate }}" width="100px"
                                        alt="Upload Image">
                                </div>
                                <input type="file" id="img_halal" name="img_halal" onchange="readURLHalal(this);"
                                    accept="image/*">

                            </div>

                            <div class="form-group">
                                <label class="font-weight-700 labelku">No. Sijil Halal</label>
                                <input type="text" value="{{ $manpower->halal_certificate_number }}" class="form-control form-control-lg" placeholder=""
                                    name="halal_certificate_number" required autofocus>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-700 labelku">Tarikh luput</label>
                                <input type="date" value="{{ $manpower->halal_certificate_date }}" class="form-control form-control-lg" placeholder=""
                                    name="halal_certificate_date" required autofocus>
                            </div>

                            <div class="form-group" style="margin-top: 30px;">
                                <a class="btn btn-md" style="color: darkred;background: #eae4e4;float:left;width:48%;"
                                    href="#" data-dismiss="modal">Kembali</a>
                                <input type="submit" value="Simpan" title="Simpan" class="btn btn-md btn-danger"
                                    style="width:48%;float: right;">
                            </div>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>
    <!--END SUBMIT HALAL MODAL-->

    <!--GMP MODAL-->
    <div class="modal fade" id="gmpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Status GMP</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body my-table" style="">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Adakah produk anda berdaftar di GMP?
                            </label>
                            <p>Good Manufacturing Services atau GMP Malaysia (Amalan Perkilangan Baik) ialah satu sistem
                                bagi
                                memastikan penghasilan produk yang terkawal dan konsisten mengikut standard kualiti yang
                                telah
                                ditetapkan. Ia wajib dipatuhi oleh pengilang produk famaseutikal/tradisional serta produk
                                kosmetik
                                berdaftar.</p>
                        </div>
                        <div class="form-group" style="margin-top: 30px;">
                            <a class="btn btn-md" style="color: darkred;background: #eae4e4;float:left;width:48%;"
                                href="#" data-dismiss="modal">Tidak</a>
                            <a data-toggle="modal" href="#" data-target="#submitGmpModal"
                                class="btn btn-md btn-danger" style="width:48%;float: right;">Ya</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--END GMP MODAL-->

    <!--SUBMIT GMP MODAL-->
    <div class="modal fade" id="submitGmpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Maklumat GMP</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body my-table" style="">
                    <form action="/maklumatGmp/update" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12">
                            <div class="form-group">
                                <div>
                                    <label class="font-weight-700 labelku">Muat naik Sijil GMP </label>
                                </div>

                                <div class="mb-3">
                                    <img id="image_gmp" src="/gmpCertificate/{{ $manpower->gmp_certificate }}" width="100px"
                                        alt="Upload Image">
                                </div>
                                <input type="file" id="img_gmp" name="img_gmp" onchange="readURLGmp(this);"
                                    accept="image/*">

                            </div>

                            <div class="form-group">
                                <label class="font-weight-700 labelku">No. Rujukan</label>
                                <input type="text" value="{{ $manpower->gmp_certificate_number }}" class="form-control form-control-lg" placeholder=""
                                    name="gmp_certificate_number" required autofocus>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-700 labelku">Tarikh luput</label>
                                <input type="date" value="{{ $manpower->gmp_certificate_date }}" class="form-control form-control-lg" placeholder=""
                                    name="gmp_certificate_date" required autofocus>
                            </div>

                            <div class="form-group" style="margin-top: 30px;">
                                <a class="btn btn-md" style="color: darkred;background: #eae4e4;float:left;width:48%;"
                                    href="#" data-dismiss="modal">Kembali</a>
                                <input type="submit" value="Simpan" title="Simpan" class="btn btn-md btn-danger"
                                    style="width:48%;float: right;">
                            </div>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>
    <!--END SUBMIT GMP MODAL-->

    <!--KKM MODAL-->
    <div class="modal fade" id="kkmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Status KKM</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body my-table" style="">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Adakah produk anda berdaftar di KKM?
                            </label>
                            <p>Produk / kosmetik di bawah status kawalan kawal selia NPRA tertakluk kepada perubahan
                                mengikut kemas
                                kini peraturan / keperluan</p>
                        </div>
                        <div class="form-group" style="margin-top: 30px;">
                            <a class="btn btn-md" style="color: darkred;background: #eae4e4;float:left;width:48%;"
                                href="#" data-dismiss="modal">Tidak</a>
                            <a data-toggle="modal" href="#" data-target="#submitKkmModal"
                                class="btn btn-md btn-danger" style="width:48%;float: right;">Ya</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--END KKM MODAL-->

    <!--SUBMIT KKM MODAL-->
    <div class="modal fade" id="submitKkmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Maklumat KKM</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body my-table" style="">
                    <form action="/maklumatKkm/update" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12">
                            <div class="form-group">
                                <div>
                                    <label class="font-weight-700 labelku">Muat naik Sijil KKM </label>
                                </div>

                                <div class="mb-3">
                                    <img id="image_kkm" src="/kkmCertificate/{{ $manpower->kkm_certificate }}" width="100px"
                                        alt="Upload Image">
                                </div>
                                <input type="file" id="img_kkm" name="img_kkm" onchange="readURLKkm(this);"
                                    accept="image/*">

                            </div>

                            <div class="form-group">
                                <label class="font-weight-700 labelku">No. Rujukan</label>
                                <input type="text" value="{{ $manpower->kkm_certificate_number }}" class="form-control form-control-lg" placeholder=""
                                    name="kkm_certificate_number" required autofocus>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-700 labelku">Tarikh luput</label>
                                <input type="date" value="{{ $manpower->kkm_certificate_date }}" class="form-control form-control-lg" placeholder=""
                                    name="kkm_certificate_date" required autofocus>
                            </div>

                            <div class="form-group" style="margin-top: 30px;">
                                <a class="btn btn-md" style="color: darkred;background: #eae4e4;float:left;width:48%;"
                                    href="#" data-dismiss="modal">Kembali</a>
                                <input type="submit" value="Simpan" title="Simpan" class="btn btn-md btn-danger"
                                    style="width:48%;float: right;">
                            </div>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>
    <!--END SUBMIT KKM MODAL-->

    <script>
        function readURLHalal(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
    
                reader.onload = function(e) {
                    $('#image_halal').attr('src', e.target.result).width(100).height(74);
                };
    
                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURLKkm(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
    
                reader.onload = function(e) {
                    $('#image_kkm').attr('src', e.target.result).width(100).height(74);
                };
    
                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURLGmp(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
    
                reader.onload = function(e) {
                    $('#image_gmp').attr('src', e.target.result).width(100).height(74);
                };
    
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    @include('employee.register.mapbox')
@endsection

