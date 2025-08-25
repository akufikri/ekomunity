@extends('home')
@section('title-dashboard', 'Ahli')
@section('title', 'Edit Produk')

@section('breadcrumb')
    <?php $user = Auth::user()->id; ?>
    <li class="breadcrumb-item active"><a href="/produk">Produk</a></li>
    <li class="breadcrumb-item active">Edit Produk</li>

@endsection

@section('content')

    <style>
        .title {
            font-size: 1.25rem;
            font-weight: bold;
        }

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

        .my-table {
            font-size: 14px;
            margin-bottom: 0px;
        }

        input[type="text"] {
            font-size: 13px;
        }

        input[type="number"] {
            font-size: 13px;
        }

        .labelku {
            font-size: 15px;
        }
    </style>

    <div class="card card-danger card-outline" style="border-top: 3px solid dark">
        <div class="card-header">
            <h3 class="text-danger my-header">Produk</h3>
        </div>
        <div class="card-body">
            <form action="/maklumatProduk/update" method="POST" enctype="multipart/form-data">
                @csrf
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>
                            {{ $message }}
                            <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                        </p>
                    </div>
                @endif

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Adakah produk ini produk buatan / keluaran
                                sendiri?</label>
                            <div class="form-check">
                                <input type="checkbox" name="check_yes" class="form-check-input" id="check_yes" checked
                                    disabled>
                                <label class="form-check-label" for="exampleCheck1">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" name="check_no" class="form-check-input" value="emel"
                                    id="check_no" disabled>
                                <label class="form-check-label" for="exampleCheck1">Tidak</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="hidden" name="id" value="{{$product->id}}" id="">
                            <label class="font-weight-700 labelku">Nama Produk</label>
                            <input type="text" value="{{$product->product_name}}" class="form-control form-control-lg" placeholder=""
                                name="product_name" required autofocus>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Kategori Produk</label>
                            <select name="product_category" class="form-control form-control-lg1" required autofocus>
                                <option disabled value="">Pilih Kategori Produk</option>
                                @foreach ($categoryProduct as $d)
                                    <option value="{{ $d->id_category_product }}" {{ (($d->id_category_product == $product->id_category_product) ? 'selected' : '') }}>{{ $d->category_product }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="font-weight-700 labelku">Keterangan Produk</label>
                            <textarea class="form-control" name="product_description" rows="3" cols="50">{{$product->product_description}}</textarea>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <div>
                                <label class="font-weight-700 labelku">Gambar Produk </label>
                            </div>

                            <div class="mb-3">
                                <img id="image" src="/product/{{$product->product_image}}" width="100px" alt="Upload Image">
                            </div>
                            <input type="file" id="img" name="img" onchange="readURL(this);" accept="image/*">

                        </div>
                    </div>
                    <div class="col-md-12" style="justify-content: center;">
                        <a class="btn btn-md col-md-4"
                            style="padding: 10px;margin-right: 0px;color: darkred;background: #f1f1f1;float: left;"
                            href="/maklumatProduk">Batal</a>
                        {{-- <a class="btn btn-md btn-danger col-md-6"  style="padding: 10px;margin: 0px;float: left;"
                            href="">Simpan</a><br><br> --}}
                        <input type="submit" id="" value="Simpan" style="padding: 10px;margin: 0px;float: left;" class="btn btn-md btn-danger col-md-4">
                        <a class="btn btn-md col-md-2"
                            style="padding: 10px;margin-right: 0px;color: white;background: darkred;float: right;"
                            href="/maklumatProduk/destroy/{{ $product->id }}"><i class="fa fa-trash"></i>&nbsp;&nbsp;Padam Produk</a><br><br>
                        
                    </div>
                </div>

            </form>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <script>
        $(function() {

        })

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#image').attr('src', e.target.result).width(100).height(74);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

@endsection
