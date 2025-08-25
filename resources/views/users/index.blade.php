@extends('home')
@section('title-dashboard', 'Admin')
@section('title', 'Admin')

@section('breadcrumb')

    <li class="breadcrumb-item active"><a>Ketua bahagian</a></li>
@endsection

@section('content')
    <style>
        .title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid #ced4da;
            height: calc(2.4rem + 2px) !important;
            padding: .6rem .4rem .1rem .4rem;
            font-size: 13px;
            line-height: 1.2;
            border-radius: .1rem;
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
            height: calc(2.3rem + 2px);
            padding: .6rem .4rem;
            font-size: 13px;
            line-height: 1.3;
            border-radius: .1rem;
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

        input[type="date"] {
            font-size: 13px;
        }

        input[type="file"] {
            font-size: 13px;
        }
    </style>

    <div class="row">
        <input type="hidden" name="auth" value="{{ Auth::user()->id_level }}">

        <div class="col-12">
            <div class="card card-danger card-outline" style="border-top: 3px solid dark">
                <div class="card-header">
                    @if ($id_level == '6')
                        <h3 class="card-title text-danger my-header">Wakil Negeri</h3>
                    @elseif($id_level == '4')
                        <h3 class="card-title text-danger my-header">Ketua bahagian</h3>
                    @elseif ($id_level == '2')
                        <h3 class="card-title text-danger my-header">Cawangan</h3>
                    @endif

                    @if (Auth::user()->id_level == '1' || Auth::user()->id_level == '6' || Auth::user()->id_level == '4')
                        <div class="card-tools">
                            <a href="#" data-toggle="modal" data-target="#addModal"
                                class="btn btn-sm btn-success pull-right">
                                <i class="fa fa-plus nav-icon"></i>
                                &nbsp; Add
                            </a>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="container mt-2 my-table">
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    {{ $message }}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm nowrap" id="datatable-crud">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th>Fullname</th>
                                            <th>Phone Number</th>
                                            <th>Email</th>
                                            <th>Level</th>
                                            @if ($id_level == '6')
                                                <th>Negeri</th>
                                            @elseif($id_level == '4')
                                                <th>Daerah</th>
                                                <th>No. ros</th>
                                                <th>Kod. bahagian</th>
                                                <th>Status ros</th>
                                            @elseif ($id_level == '2')
                                                <th>Bahagian</th>
                                                <th>Ketua Bahagian</th>
                                                <th>No. ros</th>
                                                <th>Kod. cawangan</th>
                                                <th>Status ros</th>
                                            @endif
                                            <th>Created At</th>
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

    <!--ADD CITY-->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="/users" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="filter_level" value="{{ $id_level }}">
                <div class="modal-content">
                    <div class="modal-header">
                        @if ($id_level == '6')
                            <h5 class="modal-title" id="exampleModalLabel">Add Ketua bahagian</h5>
                        @elseif($id_level == '4')
                            <h5 class="modal-title" id="exampleModalLabel">Add ketua bahagian</h5>
                        @elseif ($id_level == '2')
                            <h5 class="modal-title" id="exampleModalLabel">Add cawangan</h5>
                        @endif
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body my-table">
                        <div class="form-group">
                            <label for="#">Fullname</label>
                            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Fullname"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="#">Phone Number</label>
                            <input type="number" class="form-control" id="phone_number" name="phone_number"
                                placeholder="Phone Number" required>
                        </div>
                        <div class="form-group">
                            <label for="#">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                required>
                        </div>
                        @if ($id_level == '6')
                            <div class="form-group">
                                <label class="font-weight-700 labelku">Negeri <span style="color: #b91c1c;">*</span>
                                </label>
                                <select class="form-control form-control4 form-control-lg" name="state" required
                                    autofocus>
                                    <option selected disabled value="">Pilih Negeri</option>
                                    @foreach ($state as $d)
                                        <option value="{{ $d->id_state }}">{{ $d->state }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @elseif($id_level == '4')
                            <div class="form-group">
                                <label class="font-weight-700 labelku">Daerah <span style="color: #b91c1c;">*</span>
                                </label>
                                <select class="form-control form-control4 form-control-lg" name="city" required
                                    autofocus>
                                    <option selected disabled value="">Pilih Daerah</option>
                                    @foreach ($city as $d)
                                        <option value="{{ $d->id_city }}">{{ $d->city }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-700 labelku">No. Ros <span
                                        style="color: #b91c1c;">*</span></label>
                                <input type="text" name="no_ros" id="no_ros" class="form-control"
                                    placeholder="type here..">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-700 labelku">Kod bahagian <span
                                        style="color: #b91c1c;">*</span></label>
                                <input type="text" name="kod_bahagian" id="kod_bahagian" class="form-control"
                                    placeholder="type here..">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-700 labelku">Status Ros <span
                                        style="color: #b91c1c;">*</span></label>
                                <select name="status_ros" id="status_ros" class="form-control">
                                    <option selected>-- PILIH STATUS ROS --</option>
                                    <option value="berdaftar">Berdaftar ROS</option>
                                    <option value="belum_berdaftar">Belum Daftar ROS</option>
                                    <option value="penaja">Penaja</option>
                                </select>
                            </div>
                        @elseif ($id_level == '2')
                            @if (Auth::user()->id_level != 4)
                                <div class="form-group">
                                    <label class="font-weight-700 labelku">Bahagian <span
                                            style="color: #b91c1c;">*</span></label>
                                    <select class="form-control form-control4 form-control-lg" name="id_city" required
                                        autofocus>
                                        <option selected disabled value="">Pilih Bahagian</option>
                                        @foreach ($city as $d)
                                            <option value="{{ $d->id_city }}">{{ $d->city }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-700 labelku">No. Ros <span
                                            style="color: #b91c1c;">*</span></label>
                                    <input type="text" name="no_ros" id="no_ros" class="form-control"
                                        placeholder="type here..">
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-700 labelku">Kod cawangan <span
                                            style="color: #b91c1c;">*</span></label>
                                    <input type="text" name="kod_cawangan" id="kod_cawangan" class="form-control"
                                        placeholder="type here..">
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-700 labelku">Status Ros <span
                                            style="color: #b91c1c;">*</span></label>
                                    <select name="status_ros" id="status_ros" class="form-control">
                                        <option selected>-- PILIH STATUS ROS --</option>
                                        <option value="berdaftar">Berdaftar ROS</option>
                                        <option value="belum_berdaftar">Belum Daftar ROS</option>
                                        <option value="penaja">Penaja</option>
                                    </select>
                                </div>
                            @endif
                        @endif

                        <div class="form-group">
                            <label for="#">Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <label for="#">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                                placeholder="Confirm Password" required>
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
    <!--END ADD CITY-->

    <!--UPDATE CITY-->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" method="POST" class="form-update-data" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        @if ($id_level == '6')
                            <h5 class="modal-title" id="exampleModalLabel">Update Wakil Negeri</h5>
                        @elseif($id_level == '4')
                            <h5 class="modal-title" id="exampleModalLabel">Update Ketua Bahagian</h5>
                        @elseif ($id_level == '2')
                            <h5 class="modal-title" id="exampleModalLabel">Update Cawangan</h5>
                        @endif
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body my-table">
                        <div class="form-group">
                            <input type="hidden" name="id_user">
                            <label for="#">Fullname</label>
                            <input type="text" class="form-control" id="fullname" name="fullname"
                                placeholder="Fullname">
                        </div>
                        <div class="form-group">
                            <label for="#">Phone Number</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number"
                                placeholder="Phone Number">
                        </div>
                        <div class="form-group">
                            <label for="#">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Email">
                        </div>

                        @if ($id_level == '6')
                            <div class="form-group">
                                <label class="font-weight-700 labelku">Negeri <span style="color: #b91c1c;">*</span>
                                </label>
                                <select class="form-control form-control4 form-control-lg" name="state" required
                                    autofocus>
                                    <option selected disabled value="">Pilih Negeri</option>
                                    @foreach ($state as $d)
                                        <option value="{{ $d->id_state }}">{{ $d->state }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @elseif ($id_level == '2')
                            <div class="form-group">
                                <label class="font-weight-700 labelku">Bahagian <span
                                        style="color: #b91c1c;">*</span></label>
                                <select class="form-control form-control4 form-control-lg" name="id_city" required
                                    autofocus>
                                    <option selected disabled value="">Pilih Bahagian</option>
                                    @foreach ($city as $d)
                                        <option value="{{ $d->id_city }}">{{ $d->city }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-700 labelku">No. Ros <span
                                        style="color: #b91c1c;">*</span></label>
                                <input type="text" name="no_ros" id="no_ros" class="form-control"
                                    placeholder="type here..">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-700 labelku">Kod cawangan <span
                                        style="color: #b91c1c;">*</span></label>
                                <input type="text" name="kod_cawangan" id="kod_cawangan" class="form-control"
                                    placeholder="type here..">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-700 labelku">Status Ros <span
                                        style="color: #b91c1c;">*</span></label>
                                <select name="status_ros" id="status_ros" class="form-control">
                                    <option selected>-- PILIH STATUS ROS --</option>
                                    <option value="berdaftar">Berdaftar ROS</option>
                                    <option value="belum_berdaftar">Belum Daftar ROS</option>
                                    <option value="penaja">Penaja</option>
                                </select>
                            </div>
                        @elseif($id_level == '4')
                            <div class="form-group">
                                <label class="font-weight-700 labelku">Bahgian <span style="color: #b91c1c;">*</span>
                                </label>
                                <select class="form-control form-control4 form-control-lg" name="city" required
                                    autofocus>
                                    <option selected disabled value="">Pilih Bahgian</option>
                                    @foreach ($city as $d)
                                        <option value="{{ $d->id_city }}">{{ $d->city }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-700 labelku">No. Ros <span
                                        style="color: #b91c1c;">*</span></label>
                                <input type="text" name="no_ros" id="no_ros" class="form-control"
                                    placeholder="type here..">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-700 labelku">Kod bahagian <span
                                        style="color: #b91c1c;">*</span></label>
                                <input type="text" name="kod_bahagian" id="kod_bahagian" class="form-control"
                                    placeholder="type here..">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-700 labelku">Status Ros <span
                                        style="color: #b91c1c;">*</span></label>
                                <select name="status_ros" id="status_ros" class="form-control">
                                    <option selected>-- PILIH STATUS ROS --</option>
                                    <option value="berdaftar">Berdaftar ROS</option>
                                    <option value="belum_berdaftar">Belum Daftar ROS</option>
                                    <option value="penaja">Penaja</option>
                                </select>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                        <input id="btnsubmitku" type="submit" value="Save" class="btn btn-sm btn-success">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--END UPDATE CITY-->

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

    <!--DETAIL CITY-->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" method="POST" class="form-update-data" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        @if ($id_level == '6')
                            <h5 class="modal-title" id="exampleModalLabel">Detail Wakil Negeri</h5>
                        @elseif($id_level == '4')
                            <h5 class="modal-title" id="exampleModalLabel">Detail Ketua Bahagian</h5>
                        @elseif ($id_level == '2')
                            <h5 class="modal-title" id="exampleModalLabel">Detail Cawangan</h5>
                        @endif
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body my-table">
                        <div class="form-group">
                            <label for="#">Fullname</label>
                            <input type="text" class="form-control" id="fullname" name="fullname"
                                placeholder="Fullname" readonly>
                        </div>
                        <div class="form-group">
                            <label for="#">Phone Number</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number"
                                placeholder="Phone Number" readonly>
                        </div>
                        <div class="form-group">
                            <label for="#">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Email" readonly>
                        </div>
                        <div class="form-group">
                            <label for="#">Level</label>
                            <input type="text" class="form-control" id="level" name="level"
                                placeholder="Level" readonly>
                        </div>
                        {{-- <div class="form-group">
                        <label for="exampleInputEmail1">Status</label>
                        <select class="form-control form-control-sm" id="status" name="status" disabled>
                          <option>ENABLE</option>
                          <option>DISABLE</option>
                        </select>
                    </div> --}}
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--END DETAIL CITY-->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

    <script src="//code.jquery.com/jquery-2.0.0.js"></script>
    <script src="/js/jquery.validate.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-csrf-token"]').attr('content')
                }
            });

            loadData();
            handleSubmitPasswordCheck();
            handleEditData();
            handleUpdatePassword();
            handleDetailData();
            handleUpdateFormSubmit();
            handlePasswordFormSubmit();
        });

        function loadData() {
            const query = window.location;
            const url = new URL(query);
            const param = url.searchParams.get("id_level");
            const auth = $('input[name=auth]').val();

            const isLevel6 = param == 6;
            const isLevel4 = param == 4;
            const isLevel2 = param == 2;

            let columns = [{
                    data: 'DT_RowIndex'
                },
                {
                    data: 'fullname'
                },
                {
                    data: 'phone_number'
                },
                {
                    data: 'email'
                },
                {
                    data: 'level.description'
                }
            ];

            if (isLevel6) {
                columns.push({
                    data: 'state_name'
                });
            } else if (isLevel4) {
                columns.push({
                    data: 'city_name'
                });
                columns.push({
                    data: 'no_ros'
                });
                columns.push({
                    data: 'kod_bahagian'
                });
                columns.push({
                    data: 'status_ros',
                    render: function(data, type, row) {
                        if (!data) return "";
                        return data.replace(/_/g, " ").toUpperCase();
                    }
                });
            } else if (isLevel2) {
                // Tampilkan city/bahagian
                columns.push({
                    data: 'company.city.city',
                    defaultContent: "-"
                });
                // Tampilkan nama ketua bahagian
                columns.push({
                    data: 'nama_ketua_bahagian',
                    defaultContent: "-"
                });
                columns.push({
                    data: 'no_ros'
                });
                columns.push({
                    data: 'kod_cawangan'
                });
                columns.push({
                    data: 'status_ros',
                    render: function(data, type, row) {
                        if (!data) return "";
                        return data.replace(/_/g, " ").toUpperCase();
                    }
                });
            }

            columns.push({
                data: 'create_date'
            });
            columns.push({
                data: '',
                className: 'text-center'
            });

            const columnDefs = [{
                targets: columns.length - 1,
                data: "",
                visible: isLevel6 ? !(auth == '5') : !(auth == '5'),
                render: function(data, type, row) {
                    return `
                <a href="#" data-id="${row.id}" data-toggle="modal" data-target="#detailModal" class="btn btn-primary btn-sm detailData"><i class="fa fa-info-circle nav-icon"></i></a>
                <a href="#" data-id="${row.id}" data-toggle="modal" data-target="#updateModal" class="btn btn-warning btn-sm editData"><i class="fa fa-edit nav-icon"></i></a>
                <a href="#" data-id="${row.id}" data-toggle="modal" data-target="#updatePasswordModal" class="btn btn-danger btn-sm updatePassword"><i class="fa fa-key nav-icon"></i></a>
            `;
                }
            }];

            $('#datatable-crud').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                scrollX: true,
                ajax: {
                    url: `/users?id_level=${param}`,
                    type: 'GET'
                },
                columns,
                columnDefs,
                order: [
                    [0, 'asc']
                ]
            });
        }

        function handleEditData() {
            $("body").on("click", ".editData", function(e) {
                if (!confirm("Do you really want to edit this data?")) return false;

                e.preventDefault();
                const id = $(this).data("id");

                $.ajax({
                    url: `/users/${id}/edit`,
                    type: 'GET',
                    data: {
                        id
                    },
                    beforeSend: function() {
                        $('.editData').prop('disabled', true);
                    },
                    success: function(response) {
                        if (response.data) {
                            const data = response.data;
                            const form = $('.form-update-data');

                            form.find('input[name=id_user]').val(data.id);
                            form.find('input[name=fullname]').val(data.fullname);
                            form.find('input[name=phone_number]').val(data.phone_number);
                            form.find('input[name=email]').val(data.email);

                            // Set nilai untuk berbagai level
                            if (data.id_state) {
                                form.find('select[name=state]').val(data.id_state);
                            }
                            if (data.id_city) {
                                form.find('select[name=city]').val(data.id_city);
                                form.find('select[name=id_city]').val(data.id_city);
                            }
                            form.find("select[name=status_ros]").val(data.status_ros);
                            form.find("input[name=no_ros]").val(data.no_ros);
                            form.find("input[name=kod_bahagian]").val(data.kod_bahagian);

                            form.find("input[name=kod_cawangan]").val(data.kod_cawangan);

                            $('#updateModal').modal('show');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching user data:', error);
                        alert('Failed to fetch user data.');
                    },
                    complete: function() {
                        $('.editData').prop('disabled', false);
                    }
                });
            });
        }

        function handleSubmitPasswordCheck() {
            $("#btnsubmitku").click(function() {
                const password = $("#password").val();
                const confirmPassword = $("#confirm_password").val();

                if (password && confirmPassword && password !== confirmPassword) {
                    alert('Passwords do not match.');
                    return false;
                }
                return true;
            });
        }

        function handleUpdatePassword() {
            $("body").on("click", ".updatePassword", function(e) {
                if (!confirm("Do you really want to update password?")) return false;

                e.preventDefault();
                const id = $(this).data("id");

                $.ajax({
                    url: `/users/${id}/edit`,
                    type: 'GET',
                    data: {
                        id
                    },
                    success: function(response) {
                        if (response.data) {
                            const data = response.data;
                            const form = $('.form-update-password');
                            form.find('input[name=id_user]').val(data.id);
                            form.find('input[name=password]').val('');
                            form.find('input[name=confirm_password]').val('');
                            $('#updatePasswordModal').modal('show');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching user data:', error);
                        alert('Failed to update password.');
                    }
                });
            });
        }

        function handleDetailData() {
            $("body").on("click", ".detailData", function(e) {
                e.preventDefault();
                const id = $(this).data("id");

                $.ajax({
                    url: `/users/${id}/edit`,
                    type: 'GET',
                    data: {
                        id
                    },
                    success: function(response) {
                        if (response.data) {
                            const data = response.data;
                            const form = $('#detailModal .form-update-data');
                            form.find('input[name=fullname]').val(data.fullname);
                            form.find('input[name=phone_number]').val(data.phone_number);
                            form.find('input[name=email]').val(data.email);
                            form.find('input[name=level]').val(data.level.description);

                            // Tambahkan informasi lokasi dan ketua bahagian jika ada
                            if (data.state_name) {
                                form.find('input[name=state]').val(data.state_name);
                            }
                            if (data.city_name) {
                                form.find('input[name=city]').val(data.city_name);
                            }
                            if (data.nama_ketua_bahagian) {
                                form.find('input[name=ketua_bahagian]').val(data.nama_ketua_bahagian);
                            }

                            $('#detailModal').modal('show');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching user data:', error);
                    }
                });
            });
        }

        function handleUpdateFormSubmit() {
            $('.form-update-data').submit(function(e) {
                e.preventDefault();
                const form = $(this);
                const id = form.find('input[name=id_user]').val();
                $.ajax({
                    url: `/users/update/${id}`,
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        if (response.isSuccess) {
                            alert(response.message);
                            $('#updateModal').modal('hide');
                            loadData();
                        } else {
                            alert('Failed to update data.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error updating data:', error);
                        alert('Failed to update data.');
                    }
                });
            });
        }

        function handlePasswordFormSubmit() {
            $('.form-update-password').submit(function(e) {
                e.preventDefault();
                const form = $(this);
                const id = form.find('input[name=id_user]').val();
                const password = form.find('input[name=password]').val();
                const confirmPassword = form.find('input[name=confirm_password]').val();

                if (password !== confirmPassword) {
                    alert('Passwords do not match.');
                    return;
                }

                $.ajax({
                    url: `/users/update-password/${id}`,
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        if (response.isSuccess) {
                            alert(response.message);
                            $('#updatePasswordModal').modal('hide');
                        } else {
                            alert('Failed to update password.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error updating password:', error);
                        alert('Failed to update password.');
                    }
                });
            });
        }
    </script>
@endsection
