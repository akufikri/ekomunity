@extends('home')
@section('title-dashboard', 'Senarai Produk')
@section('title', 'Senarai Produk')

@section('breadcrumb')

    <li class="breadcrumb-item active">Senarai Produk</li>

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
            padding: 1.2rem 1rem 2.5rem 1rem;
            font-size: 1.25rem;
            line-height: 1.5;
            border-radius: .3rem;
        }

        .form-control-lg2 {
            border: 1px solid #ced4da;
            height: calc(2.875rem + 2px) !important;
            padding: 1.2rem 1rem 2.5rem 1rem;
            font-size: 1.25rem;
            line-height: 1.5;
            border-radius: .3rem;
        }

        .form-control-lg {
            height: calc(2.875rem + 2px);
            padding: 2rem 1.2rem;
            font-size: 1.25rem;
            line-height: 1.5;
            border-radius: .3rem;
        }

        .form-control-lgku {
            height: calc(2.875rem + 2px);
            padding: 2rem 1.2rem;
            font-size: 1.25rem;
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
            text-align: center;
            margin-bottom: 0px;
        }

        .my-table {
            font-size: 14px;
            margin-bottom: 0px;
        }

        input[type="text"] {
            font-size: 14px;
        }

        input[type="number"] {
            font-size: 14px;
        }

        input[type="file"] {
            font-size: 14px;
        }

        input[type="button"] {
            font-size: 14px;
        }
    </style>

    <div class="row">
        <input type="hidden" name="auth" value="{{ Auth::user()->id_level }}">
        <div class="col-12">
            <div class="card card-danger card-outline" style="border-top: 3px solid dark">
                <div class="card-header">
                    <h3 class="card-title my-header text-danger">Senarai Produk</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="container mt-2 my-table">
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    <p>
                                        {{ $message }}
                                        <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                                    </p>
                                </div>
                            @endif
                            <div class="table-responsive">

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Filter</label>
                                            <select class="custom-select filter" style="height: 31px; font-size: small;">
                                                <option value="" selected disabled>Pilih Daerah</option>
                                                @foreach ($city as $item)
                                                    <option value="{{ $item->id_city }}">{{ $item->city }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <table class="table table-bordered table-sm nowrap" id="datatable-crud">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th>Foto Produk</th>
                                            <th>Nama Produk</th>
                                            <th>Daerah</th>
                                            <th>Pemilik Produk</th>
                                            <th>No. Telefon Pemilik</th>
                                            <th>Address Kilang</th>
                                            <th>No. Sijil Halal</th>
                                            <th>No. Sijil GMP</th>
                                            <th>No. Sijil KKM </th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <script src="https://code.jquery.com/jquery-2.0.0.js"></script>
    <script src="/js/jquery.validate.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            loadData();

            var filter = 'all';

            $(".filter").on("change", function(){
                filter = this.value;
                loadData(filter)
             })


        });

        function loadData(filter = 'all') {
          

            var auth = $('input[name=auth]').val()

            $('#datatable-crud').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: {
                    url: "/senaraiProduk/getData?filter=" + filter,
                    type: 'GET'
                },
                columns: [{
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'product_image',
                    },
                    {
                        data: 'product_name'
                    },
                    {
                        data: 'manpower.city.city'
                    },
                    {
                        data: 'manpower.user.fullname'
                    },
                    {
                        data: 'manpower.user.phone_number'
                    },
                    {
                        data: 'manpower.factory_address'
                    },
                    {
                        data: 'manpower.halal_certificate_number'
                    },
                    {
                        data: 'manpower.gmp_certificate_number'
                    },
                    {
                        data: 'manpower.kkm_certificate_number'
                    },
                ],
                columnDefs: [{
                        "targets": 1,
                        "visible": true,
                        "className": "dt-center",
                        "data": "product_image",
                        "render": function(data, type, row) { //class="btn btn-primary btn-sm"
                            return '<img src="/product/' + row.product_image +
                                '" width="100px" height="100px" alt="no-image">'
                        }
                    },
                ],
                order: [
                    [0, 'asc']
                ]
            });
        }

        $("body").on("click", ".btn-verify-email", function(e) {

            var id = $(this).data("id");

            $.ajax({
                url: '/verify_email',
                type: 'GET',
                data: {
                    id: id,
                },
            }).success(function(result) {

                if (result.isSuccess) {
                    loadData()

                    Swal.fire({
                        icon: "success",
                        title: 'Success!',
                        text: "Verify Email Successfuly!",
                        showConfirmButton: true,
                    });

                }

            });
            return false;
        });

        // Start Ajax Edit data
        $("body").on("click", ".deleteData", function(e) {
            // if(!confirm("Do you really want to do this?")) {
            //     return false;
            // }
            e.preventDefault();
            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
            var url = e.target;
            $.ajax({
                url: "/users/" + id + "/edit",
                type: 'GET',
                data: {
                    _token: token,
                    id: id
                },
                success: function(response) {
                    $("#success").html(response.message)

                    if (response.data != null) {
                        data = response.data
                        var form = $('.form-delete-data');
                        form.find('input[name=id_user]').val(data.id);
                        // form.find('select[name=status]').val(data.is_active);

                        $('#deleteDataModal').modal('show');
                    } else {
                        // failedAlert('Not Found');
                    }
                }
            });
            return false;
        });
        // End Ajax Edit data

        // Start Ajax Delete data
        $(document).on('submit', '.form-delete-data', function(e) {
            e.preventDefault();
            var ini = $(this),
                input_token = $('input[name=_token]'),
                id = ini.find('input[name=id_user]').val(),
                url = '/senaraiPersatuan/delete/' + id;
            var post_data = {
                is_ajax: true,
                _token: input_token.val(),
                // status: ini.find('select[name=status]').val(),

            };

            // var e_modal_wait = $("#modalWait");
            // showLoading(e_modal_wait);

            $.ajax({
                    url: url,
                    type: "POST",
                    data: post_data
                })
                .done(function(result) {
                    // var message = result.message;
                    // hideLoading(e_modal_wait);
                    if (result.isSuccess) {
                        $('#deleteDataModal').modal('hide');
                        // initData(param)
                        // successAlert(message);

                        loadData()
                        // swal(
                        //     'Success!',
                        //     result.success,
                        //     'success'
                        // )

                        Swal.fire({
                            icon: "success",
                            title: 'Success!',
                            text: result.success,
                            showConfirmButton: true,
                        });

                    } else {

                        alert(result.message)

                        // failedAlert(message);
                    }
                    input_token.val(result.newToken);
                })
                .fail(ajax_fail);

        });
        // End Ajax Delete data

        // Start Ajax Edit data
        $("body").on("click", ".updatePassword", function(e) {
            if (!confirm("Do you really want to do this?")) {
                return false;
            }
            e.preventDefault();
            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
            var url = e.target;
            $.ajax({
                url: "/users/" + id + "/edit",
                type: 'GET',
                data: {
                    _token: token,
                    id: id
                },
                success: function(response) {
                    $("#success").html(response.message)

                    if (response.data != null) {
                        data = response.data
                        var form = $('.form-update-password');
                        form.find('input[name=id_user]').val(data.id);
                        // form.find('select[name=status]').val(data.is_active);

                        $('#updatePasswordModal').modal('show');
                    } else {
                        // failedAlert('Not Found');
                    }
                }
            });
            return false;
        });
        // End Ajax Edit data

        // Start Ajax Update data
        $(document).on('submit', '.form-update-password', function(e) {
            e.preventDefault();
            var ini = $(this),
                input_token = $('input[name=_token]'),
                id = ini.find('input[name=id_user]').val(),
                url = '/users/update_password/' + id;
            var post_data = {
                is_ajax: true,
                _token: input_token.val(),
                password: ini.find('input[name=password]').val(),
                confirm_password: ini.find('input[name=confirm_password]').val(),
                // status: ini.find('select[name=status]').val(),

            };

            // var e_modal_wait = $("#modalWait");
            // showLoading(e_modal_wait);

            $.ajax({
                    url: url,
                    type: "POST",
                    data: post_data
                })
                .done(function(result) {
                    // var message = result.message;
                    // hideLoading(e_modal_wait);
                    if (result.isSuccess) {
                        $('#updatePasswordModal').modal('hide');
                        // initData(param)
                        // successAlert(message);

                        loadData()
                        // swal(
                        //     'Success!',
                        //     'Update Password Successfuly!',
                        //     'success'
                        // )
                        Swal.fire({
                            icon: "success",
                            title: 'Success!',
                            text: "Update Password Successfuly!",
                            showConfirmButton: true,
                        });

                    } else {

                        alert(result.message)

                        // failedAlert(message);
                    }
                    input_token.val(result.newToken);
                })
                .fail(ajax_fail);

        });
        // End Ajax Update data
    </script>

@endsection('content')
