@extends('home')
@section('title-dashboard', 'Company')
@section('title', 'Senarai Cawangan')

@section('breadcrumb')
    <li class="breadcrumb-item active">Senarai Cawangan</li>
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
                    <h3 class="card-title my-header text-danger">Senarai Cawangan</h3>
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
                                <table class="table table-bordered table-sm nowrap" id="datatable-crud">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th>Logo Cawangan</th>
                                            <th>Nama Cawangan</th>
                                            <th>Nama Wakil</th>
                                            <th>No. Telefon Cawangan</th>
                                            <th>No. Telefon Wakil</th>
                                            <th>Emel Cawangan</th>
                                            <th>Emel Wakil</th>
                                            <th>Verifikasi </th>
                                            <th>Status</th>
                                            <th>Action</th>
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

    <!--UPDATE Password-->
    <div class="modal fade" id="updatePasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" method="POST" class="form-update-password" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body my-table">
                        <div class="form-group">
                            <input type="hidden" name="id_user">
                            <label for="#">Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="#">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                                placeholder="Confirm Password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                        <input id="btnsubmitku" type="submit" value="Save" class="btn btn-sm btn-success">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--END UPDATE Password-->

    <!--DELETE HISTORY-->
    <div class="modal fade" id="deleteDataModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" class="form-delete-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Move to Trash</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" name="id_user">

                        <!-------->
                        Are you sure to move to trash?
                        <!--------->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END DELETE HISTORY-->

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

            loadData()
        });

        function loadData() {
            const queryString = window.location.search;

            var auth = $('input[name=auth]').val()

            $('#datatable-crud').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: {
                    url: "/senaraiPersatuan" + queryString,
                    type: 'GET'
                },
                columns: [{
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'logo_picture',
                    },
                    {
                        data: 'full_company_name'
                    },
                    {
                        data: 'user.fullname'
                    },
                    {
                        data: 'phone_office'
                    },
                    {
                        data: 'user.phone_number'
                    },
                    {
                        data: 'email_company'
                    },
                    {
                        data: 'user.email'
                    },
                    {
                        data: 'user.is_verified'
                    },
                    {
                        data: 'user.status'
                    },
                    {
                        data: 'id_detail_company'
                    },
                ],
                columnDefs: [{
                        "targets": 1,
                        "visible": true,
                        "className": "dt-center",
                        "data": "logo_picture",
                        "render": function(data, type, row) { //class="btn btn-primary btn-sm"
                            return '<img src="/CompanyLogo/' + row.logo_picture +
                                '" width="100px" height="100px" alt="no-image">'
                        }
                    },
                    {
                        "targets": 8,
                        "visible": (auth == '4' || auth == '5' || auth == '6') ? false : true,
                        "data": "user.is_verified",
                        "render": function(data, type, row) {
                            var btn = row.user.is_verified == "1" ?
                                '<div><button class=" btn btn-sm btn-success" style="width:100%">Verified</button></div>' :
                                '<div><button class="btn btn-sm btn-danger btn-verify-email" data-id="' +
                                row.user.id + '" style="width:100%">Not Verified</button></div>'
                            return btn;
                        }
                    },
                    {
                        "targets": 10,
                        "visible": (auth == '4' || auth == '5' || auth == '6') ? false : true,
                        "data": "",
                        "render": function(data, type, row) { //class="btn btn-primary btn-sm"
                            var btn = //'<a href="/learn/detail/'+row.id_company_project+'" data-toggle="modal" data-target="#addProject" class="btn btn-primary btn-sm"><i class="fa fa-info-circle nav-icon"></i></a>'+
                                '<a href="/detailPersatuan/' + row.id_user +
                                '" class="btn btn-primary btn-sm"><i class="fa fa-info-circle nav-icon"></i></a> ' +
                                '<a href="/cetak_pdf/' + row.id_user +
                                '" target="_blank" class="btn btn-success btn-sm"><i class="fas fa-certificate"></i></i></a> ' +
                                '<a href="#" data-toggle="modal" data-id="' + row.id_user +
                                '" data-target="#updatePasswordModal" class="btn btn-danger btn-sm updatePassword"><i class="fa fa-key nav-icon"></i></a> ' +
                                '<a href="#" data-toggle="modal" data-id="' + row.id_user +
                                '" data-target="#deleteDataModal" class="btn btn-danger btn-sm deleteData"><i class="fa fa-trash nav-icon"></i></a>'

                            if (auth == '4') {
                                btn = '<a href="/detailPersatuan/' + row.id_user +
                                    '" class="btn btn-primary btn-sm"><i class="fa fa-info-circle nav-icon"></i></a> ' +
                                    '<a href="/cetak_pdf/' + row.id_user +
                                    '" target="_blank" class="btn btn-success btn-sm"><i class="fas fa-certificate"></i></i></a> '
                            }


                            return btn; //settings_position/'+row.id_position+'/edit
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
