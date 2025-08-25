@extends('home')
@section('title-dashboard', 'Company')
@section('content')

@section('breadcrumb')
    <li class="breadcrumb-item active"><a>Senarai Ahli</a></li>
@endsection

@php
    $user = Auth::user();
@endphp

<style>
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 4px;
        min-height: 38px;
        /* sesuaikan dengan tinggi input lainnya */
        box-sizing: border-box;
    }

    .select2-container--default .select2-selection--multiple .select2-search__field {
        width: auto !important;
        min-width: 100px;
        box-sizing: border-box;
    }

    .select2-container .select2-selection--multiple {
        display: flex;
        flex-wrap: wrap;
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
</style>

<div class="row" id="view">

    @if ($user->id_level != '4')
        <div class="col-12">
            <div class="card card-white collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Filter</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="" class="form-filter-data" method="GET">
                        <!-- <div class="form-check">
                    <input type="checkbox" name="fullname" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Duplicate Name</label>
                </div> -->

                        <div class="form-group">
                            <label class="font-weight-700 labelku">Daerah <span style="color: #b91c1c;">*</span>
                            </label>
                            <select class="form-control form-control4 form-control-lg" style="padding: 0.8rem;"
                                name="id_city" required autofocus>
                                <option selected disabled value="">Pilih Daerah</option>
                                @foreach ($city as $d)
                                    <option value="{{ $d->id_city }}">{{ $d->city }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- <div class="form-check">
                    <input type="checkbox" name="ic_number" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">IC/Passport</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="phone_number" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">No Telefon</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="email" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Emel</label>
                </div> --}}
                        <div class="mt-3">
                            <button type="submit" class="btn btn-sm btn-secondary" data-dismiss="modal">Apply</button>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    @endif
    <input type="hidden" name="auth" value="{{ $user->id_level }}">
    <input type="hidden" name="auth_sub_company" value="{{ Auth::user()->sub_company }}">
    <div class="col-12">
        <div class="card card-danger card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title text-danger my-header">Senarai Ahli</h3>
                @if (Auth::user()->sub_company == null)
                    <div class="card-tools">
                        @if ($user->id_level == '1' || $user->id_level == '7')
                          <a class="btn btn-sm btn-info pull-right text-white" data-toggle="modal" data-target="#confirmDownloadModal">
                            <i class="fa fa-download nav-icon"></i>
                            &nbsp; Template
                        </a>

                            <a href="#" data-toggle="modal" data-target="#importModal"
                                class="btn btn-sm btn-info pull-right">
                                <i class="fa fa-plus nav-icon"></i>
                                &nbsp; Import
                            </a>
                        @elseif ($user->id_level == '2')
                            <a href="/register_ahli/create" title="Buat Akaun Ahli"
                                class="btn btn-sm btn-info pull-right">
                                <i class="fa fa-plus nav-icon"></i>
                                &nbsp; Buat Akaun Ahli
                            </a>
                            <a href="#" data-toggle="modal" title="Add" data-target="#addJemputan"
                                class="btn btn-sm btn-success pull-right">
                                <i class="fa fa-plus nav-icon"></i>
                                &nbsp; Hantar Jemputan
                            </a>
                        @endif
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
                        @elseif ($message = Session::get('warning'))
                            <div class="alert alert-warning">
                                {{ $message }}
                                <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                            </div>
                        @elseif ($message = Session::get('error'))
                            <div class="alert alert-danger">
                                {{ $message }}
                                <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                            </div>
                        @elseif ($message = Session::get('failed'))
                            <div class="alert alert-danger">
                                {{ $message }}
                                <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                            </div>
                        @endif

                        @if(session('import_errors'))
                            <div class="alert alert-danger">
                                <strong>Beberapa row gagal di-import:</strong>
                                <ul>
                                    @foreach(session('import_errors') as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                {{-- <a class="close" aria-hidden="true" data-dismiss="alert">x</a> --}}
                            </div>
                        @endif

                        <div class="table-responsive">

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Filter</label>
                                        <select class="custom-select filter" style="height: 31px; font-size: small;">
                                            <option value="today">Today</option>
                                            <option value="month" selected>This Month</option>
                                            <option value="year">This Year</option>
                                            <option value="all">All</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Search</label>
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control text-search">
                                            <span class="input-group-append">
                                                <button type="button"
                                                    class="btn btn-info btn-flat btn-sm btn-search">Search</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <table class="table table-bordered table-sm nowrap" id="datatable-crud">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Persatuan </th>
                                        <th>Name </th>
                                        <th>IC/Passport </th>
                                        <th>No. Telefon </th>
                                        <th>Emel </th>
                                        {{-- <th>Jenis Perniagaan </th> --}}
                                        {{-- <th>Aktiviti Perniagaan </th> --}}
                                        {{-- <th>Kad Perniagaan </th> --}}
                                        <th>Payment Date </th>
                                        <th>Verifikasi </th>
                                        <th>Bumiputera Status </th>
                                        <th>Invoice</th>
                                        {{-- <th>Registered By</th> --}}
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

<!--ADD Import-->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="/ahli_import" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Ahli</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body my-table">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Upload File</label><br>
                        <input type="file" id="file" name="file"
                            accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                    <input type="submit" value="Import" class="btn btn-sm btn-success">
                </div>
            </div>
        </form>
    </div>
</div>
<!--END ADD Import-->

<!--ADD NEW SHAREHOLDERS-->
<div class="modal fade" id="addJemputan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Jemput Ahli Baharu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body my-table">
                <!-------->
                <form action="" method="GET" enctype="multipart/form-data" class="form-jemput-ahli">
                    @csrf
                    <div class="form-group">
                        @if ($user->id_level == '2')
                            <input type="hidden" name="code" value="{{ $detail->key_reference }}">
                        @endif
                        <label for="exampleInputEmail1">Emel <span style="color: #b91c1c;">*</span></label>
                        <div class="input-group">
                            <input type="email" name ="email" id="email" class="form-control"
                                placeholder="Ex : ahmadnoorasyrul@gmail.com" required>
                        </div>
                    </div>
                    <br>
                    <div class="" style="text-align:right;">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                        <input type="submit" value="Hantar Jemputan" class="btn btn-sm btn-success">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<!-- END ADD NEW SHAREHOLDERS-->

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

<!--UPDATE SHAREHOLDERS-->
<div class="modal fade" id="updateShareholders" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Senarai Ahli</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body my-table">
                <!-------->
                <form action="{{ URL::to('/senaraiAhli/update') }}#view" class="form-update-data" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" class="form-control" name="id" id="id">
                        <label for="exampleInputEmail1">Name </label>
                        <div class="input-group">
                            <input type="text" name ="fullname" id="fullname" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">IC/Passport</label>
                        <div class="input-group">
                            <input type="text" name ="ic_number" id="ic_number" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">No. Telefon</label>
                        <div class="input-group">
                            <input type="number" name ="phone_number" id="phone_number" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Emel</label>
                        <div class="input-group">
                            <input type="email" name ="email" id="email" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-700 labelku">Status Bumiputera <span
                                style="color: #b91c1c;">*</span> </label>
                        <select class="form-control form-control4 form-control-lg" name="native_status" autofocus>
                            <option selected disabled value="">Pilih Status Bumiputera</option>
                            @foreach ($status_native as $d)
                                <option value="{{ $d->id_status_native }}">{{ $d->status_native }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-700 labelku">Invoice <span style="color: #b91c1c;">*</span> </label>
                        <select class="form-control form-control4 form-control-lg" name="invoice" autofocus>
                            <option selected disabled value="">Pilih Invoice</option>
                            <option value="UNPAID">UNPAID</option>
                            <option value="PAID">PAID</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-700 labelku">Jawatan <span style="color: #b91c1c;">*</span> </label>
                        <select class="form-control form-control4 form-control-lg" name="jawatan"
                            id="edit-position-select" autofocus>
                            <option selected disabled value="">Pilih Jawatan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-700 labelku">Status</label>
                        <select class="form-control form-control4 form-control-lg" name="status" autofocus>
                            <option selected disabled value="">Pilih Status</option>
                            <option value="APPROVE">APPROVE</option>
                            <option value="REJECT">REJECT</option>
                            <option value="PENDING">PENDING</option>
                        </select>
                    </div>
                    {{-- <div class="form-group">
                        <label class="font-weight-700 labelku">Reason</label>
                    </div> --}}
                    <br>
                    <div class="" style="text-align: right">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                        <input type="submit" value="Save" class="btn btn-sm btn-success">
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
<!-- END UPDATE SHAREHOLDERS-->

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

<!-- MODAL CONFIRM & INSTRUCTION USE TEMPLATE -->
<div class="modal fade" id="confirmDownloadModal" tabindex="-1" role="dialog" aria-labelledby="confirmDownloadLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="confirmDownloadLabel">Konfirmasi Download</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Body -->
      <div class="modal-body">
        <h6 class="mb-3">Tata cara penggunaan template:</h6>
        <ol class="text-sm">
          <li class="mb-2">
            <span class="badge badge-primary px-3">BIRU</span> 
            Bebas di isi, namun untuk <b>email</b>, <b>No IC/Passport</b>, <b>phone number</b> harus <u>unique</u>.
          </li>
          <li class="mb-2">
            <span class="badge badge-warning px-3">FLAX</span> 
            <b>Wajib di isi dengan format yang benar</b>, agar data tidak salah ketika di import.
          </li>
          <li>
            <b>NOTES:</b> Untuk status warga negara di isi dengan <b>FOREIGN</b> atau <b>NO FOREIGN</b>, 
            dan untuk style wording <b>Gender</b> dan <b>Marital status</b> gunakan format 
            <u>Capitalize</u> (Huruf depan huruf besar).
          </li>
        </ol>
      </div>

      <!-- Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <a href="{{ asset('template/Template Import Usia.xlsx') }}" class="btn btn-info text-white" id="confirmDownloadBtn">Mengerti</a>
      </div>
    </div>
  </div>
</div>

@include('layouts.modals')

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

        var filter = "month";
        var q = "";

        $(".filter").on("change", function() {
            filter = this.value;
            if (auth == 2) {
                loadDataAhliPersatuan(filter, q)
            } else {
                loadData(filter, q)
            }
        })

        $(".btn-search").on("click", function() {
            q = $(".text-search").val()
            if (auth == 2) {
                loadDataAhliPersatuan(filter, q)
            } else {
                loadData(filter, q)
            }
        })

        $("#btnsubmitku").click(function() {
            var password = $("#password").val();
            var confirmPassword = $("#confirm_password").val();
            if (password !== confirmPassword) {
                alert("Passwords not match.");
                return false;
            }
            return true;
        });

        $(document).on('change', '#business_activity', function() {

            var current_select = $('#business_activity').find(":selected").val();

            if (current_select == 0) {
                // ✅ Remove required attribute
                $("#village_guests").prop('disabled', false);

            } else {
                $("#village_guests").prop('disabled', true);
            }

        })

        var auth = $('input[name=auth]').val()


        if (auth == 2) {
            loadDataAhliPersatuan()
        } else {
            loadData()
        }

        // loadDataTemp()
    });

    function loadData(filter = "month", q = "") {
        const queryString = window.location.search;
        var auth = $('input[name=auth]').val();

        $('#datatable-crud').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            ordering: true,
            destroy: true,
            scrollX: true,
            lengthChange: true,
            pageLength: 10,
            lengthMenu: [
                [10, 50, 100, 250, 500],
                [10, 50, 100, 250, 500],
            ],
            paging: true,
            ajax: {
                url: "/senaraiAhli/getData" + queryString + "&filter=" + filter + "&q=" + q,
                type: 'GET',
                timeout: 60000,
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'persatuan',
                    defaultContent: '-'
                },
                {
                    data: 'user.fullname',
                    defaultContent: '-'
                },
                {
                    data: 'ic_number',
                    defaultContent: '-'
                },
                {
                    data: 'user.phone_number',
                    defaultContent: '-'
                },
                {
                    data: 'user.email',
                    defaultContent: '-'
                },
                {
                    data: 'payment_kad_digital',
                    defaultContent: '-'
                },
                {
                    data: 'user.is_verified',
                    defaultContent: '-'
                },
                {
                    data防衛省: 'status_native_text',
                    defaultContent: '-'
                },
                {
                    data: 'invoice',
                    defaultContent: '-'
                },
                {
                    data: 'id_detail_manpower',
                    defaultContent: '-'
                }
            ],
            columnDefs: [{
                    targets: 1, // Persatuan
                    visible: auth == '4' || auth == '5' || auth == '6' ? false : true,
                    render: function(data, type, row) {
                        return row.persatuan || 'Tiada Persatuan';
                    }
                },
                {
                    targets: 2, // Name
                    render: function(data, type, row) {
                        return row.user ? row.user.fullname : '-';
                    }
                },
                {
                    targets: 4, // No. Telefon
                    render: function(data, type, row) {
                        return row.user ? row.user.phone_number : '-';
                    }
                },
                {
                    targets: 5, // Email
                    render: function(data, type, row) {
                        return row.user ? row.user.email : '-';
                    }
                },
                {
                    targets: 6, // Payment Date
                    render: function(data, type, row) {
                        return row.payment_kad_digital ? row.payment_kad_digital : '-';
                    }
                },
                {
                    targets: 7, // Verifikasi
                    visible: auth == '4' || auth == '5' || auth == '6' ? false : true,
                    render: function(data, type, row) {
                        if (!row.user) {
                            return '<div><button class="btn btn-sm btn-secondary" style="width:100%">No User</button></div>';
                        }
                        return row.user.is_verified == "1" ?
                            '<div><button class="btn btn-sm btn-success" style="width:100%">Verified</button></div>' :
                            '<div><button class="btn btn-sm btn-danger btn-verify-email" data-id="' +
                            row.user.id +
                            '" style="width:100%">Not Verified</button></div>';
                    }
                },
                {
                targets: 9, // Invoice
                visible: false // hide kolom Invoice
                },
                {
                    targets: 10, // Action
                    render: function(data, type, row) {
                        var btn =
                            '<a href="" id="editData" data-id="' +
                            row.id_detail_manpower +
                            '" data-toggle="modal" data-target="#updateShareholders" class="btn btn-warning btn-sm"><i class="fa fa-edit nav-icon"></i></a> ' +
                            '<a href="/companyCard?id=' +
                            row.id_user +
                            '" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-id-card nav-icon"></i></a> ' +
                            '<a href="/cetak_pdf/' +
                            row.ref +
                            '" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-certificate nav-icon"></i></a> ' +
                            '<a href="#" data-toggle="modal" data-id="' +
                            row.id_user +
                            '" data-target="#updatePasswordModal" class="btn btn-danger btn-sm updatePassword"><i class="fa fa-key nav-icon"></i></a> ' +
                            '<a href="#" data-toggle="modal" data-id="' +
                            row.id_user +
                            '" data-target="#deleteDataModal" class="btn btn-danger btn-sm deleteData"><i class="fa fa-trash nav-icon"></i></a>';

                        if (row.subscribe_status == "EXPIRED") {
                            btn =
                                '<a href="/register_ahli/payment_cash?ref=' +
                                row.ref +
                                '" class="btn btn-info btn-sm"><i class="fa fa-credit-card nav-icon"></i> Renew</a> ' +
                                '<a href="#" data-toggle="modal" data-id="' +
                                row.id_user +
                                '" data-target="#updatePasswordModal" class="btn btn-danger btn-sm updatePassword"><i class="fa fa-key nav-icon"></i></a> ' +
                                '<a href="#" data-toggle="modal" data-id="' +
                                row.id_user +
                                '" data-target="#deleteDataModal" class="btn btn-danger btn-sm deleteData"><i class="fa fa-trash nav-icon"></i></a>';
                        }

                        if (auth == '4') {
                            btn =
                                '<a href="" id="editData" data-id="' +
                                row.id_detail_manpower +
                                '" data-toggle="modal" data-target="#updateShareholders" class="btn btn-warning btn-sm"><i class="fa fa-edit nav-icon"></i></a>';
                        }

                        return btn;
                    }
                }
            ],
            order: [
                [0, 'asc']
            ],
        });
    }

    function loadDataAhliPersatuan(filter = "month", q = "") {
        const queryString = window.location.search;
        var auth = $('input[name=auth]').val();
        var auth_sub_company = $('input[name=auth_sub_company]').val();

        $('#datatable-crud').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ordering: true,
            destroy: true,
            scrollX: false,
            lengthChange: true,
            pageLength: 10,
            lengthMenu: [
                [10, 50, 100, 250, 500],
                [10, 50, 100, 250, 500],
            ],
            paging: true,
            ajax: {
                url: "/senaraiAhli/getDataAhliPersatuan?" + queryString + "filter=" + filter + "&q=" + q,
                type: 'GET',
                timeout: 60000,
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'persatuan',
                    defaultContent: '-'
                },
                {
                    data: 'manpower.user.fullname',
                    defaultContent: '-'
                },
                {
                    data: 'manpower.ic_number',
                    defaultContent: '-'
                },
                {
                    data: 'manpower.user.phone_number',
                    defaultContent: '-'
                },
                {
                    data: 'manpower.user.email',
                    defaultContent: '-'
                },
                {
                    data: 'payment_date',
                    defaultContent: '-'
                },
                {
                    data: 'manpower.user.is_verified',
                    defaultContent: '-'
                },
                {
                    data: 'manpower.status_native_text',
                    defaultContent: '-'
                },
                // {
                //     data: 'invoice',
                //     defaultContent: '-'
                // },
                {
                    data: 'manpower.id_detail_manpower',
                    defaultContent: '-',
                    className: 'text-center'
                }
            ],
            columnDefs: [{
                    targets: 1, // Persatuan
                    // visible: auth == '4' || auth == '5' || auth == '6' ? false : true,
                    // render: function(data, type, row) {
                    //     return row.persatuan || '-';
                    // }
                    visible:false
                },
                {
                    targets: 2, // Name
                    render: function(data, type, row) {
                        return row.manpower && row.manpower.user ? row.manpower.user.fullname : '-';
                    }
                },
                {
                    targets: 4, // No. Telefon
                    render: function(data, type, row) {
                        return row.manpower && row.manpower.user ? row.manpower.user.phone_number : '-';
                    }
                },
                {
                    targets: 5, // Email
                    render: function(data, type, row) {
                        return row.manpower && row.manpower.user ? row.manpower.user.email : '-';
                    }
                },
                {
                    targets: 6, // Payment Date
                    render: function(data, type, row) {
                        return row.payment_date || '-';
                    }
                },
                {
                    targets: 7, // Verifikasi
                    visible: auth == '4' || auth == '2' ? false : true,
                    render: function(data, type, row) {
                        if (!row.manpower || !row.manpower.user) {
                            return '<div><button class="btn btn-sm btn-secondary" style="width:100%">No User</button></div>';
                        }
                        return row.manpower.user.is_verified == "1" ?
                            '<div><button class="btn btn-sm btn-success" style="width:100%">Verified</button></div>' :
                            '<div><button class="btn btn-sm btn-danger btn-verify-email" data-id="' +
                            row.manpower.user.id +
                            '" style="width:100%">Not Verified</button></div>';
                    }
                },
                {
                    targets: 9, // Invoice
                    visible: false // hide kolom Invoice
                },
                {
                    targets: 10, // Action
                    visible: auth_sub_company != '' ? false : true,
                    render: function(data, type, row) {
                        var btn =
                            '<a href="" id="editData" data-id="' +
                            row.manpower.id_detail_manpower +
                            '" data-toggle="modal" data-target="#updateShareholders" class="btn btn-warning btn-sm"><i class="fa fa-edit nav-icon"></i></a>';

                        if (auth == '4') {
                            btn =
                                '<a href="" id="editData" data-id="' +
                                row.manpower.id_detail_manpower +
                                '" data-toggle="modal" data-target="#updateShareholders" class="btn btn-warning btn-sm"><i class="fa fa-edit nav-icon"></i></a>';
                        }

                        return btn;
                    }
                }
            ],
            order: [
                [0, 'asc']
            ],
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
        }).done(function(result) {

            if (result.isSuccess) {
                loadData()
                // swal(
                //     'Success!',
                //     'Verify Email Successfuly!',
                //     'success'
                // )

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

    $("body").on("click", ".btn-activate-kad", function(e) {

        var id = $(this).data("id");

        $.ajax({
            url: '/activateCompanyCard',
            type: 'GET',
            data: {
                id_detail_manpower: id,
            },
        }).success(function(result) {

            if (result.isSuccess) {
                loadData()
                // swal(
                //     'Success!',
                //     'Activate Kad Perniagaan Successfuly!',
                //     'success'
                // )

                Swal.fire({
                    icon: "success",
                    title: 'Success!',
                    text: 'Activate Kad Perniagaan Successfuly!',
                    showConfirmButton: true,
                });
            }

        });
        return false;
    });

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

    $(document).on('submit', '.form-jemput-ahli', function(e) {
        e.preventDefault();
        var ini = $(this),
            code = ini.find('input[name=code]').val(),
            url = '/request_join/' + code;
        var post_data = {
            is_ajax: true,
            email: ini.find('input[name=email]').val(),
        };

        var e_modal_wait = $("#modalWait");
        showLoading(e_modal_wait);

        $.ajax({
                url: url,
                type: "GET",
                data: post_data
            })
            .done(function(result) {

                // var message = result.message;
                hideLoading(e_modal_wait);
                if (result.isSuccess) {
                    $('#addJemputan').modal('hide');

                    Swal.fire({
                        icon: "success",
                        title: 'Success!',
                        text: result.message,
                        showConfirmButton: true,
                    });

                    // swal(
                    //     'Success!',
                    //     result.message,
                    //     'success'
                    // )

                } else {

                    Swal.fire({
                        icon: "error",
                        title: 'Failed!',
                        text: result.message,
                        showConfirmButton: true,
                    });

                    // swal(
                    //     'Success!',
                    //     result.message,
                    //     'success'
                    // )
                }
            })
            .fail(ajax_fail);

    });

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

    // Start Ajax Delete data
    $(document).on('submit', '.form-delete-data', function(e) {
        e.preventDefault();
        var ini = $(this),
            input_token = $('input[name=_token]'),
            id = ini.find('input[name=id_user]').val(),
            url = '/senaraiAhli/delete/' + id;
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
    $("body").on("click", "#editData", function(e) {
        if (!confirm("Do you really want to do this?")) {
            return false;
        }
        e.preventDefault();
        var id = $(this).data("id");
        var token = $("meta[name='csrf-token']").attr("content");
        var url = e.target;
        $.ajax({
            url: "/senaraiAhli/edit/" + id, // URL untuk mendapatkan data user yang akan diedit
            type: 'GET',
            data: {
                _token: token,
                id: id
            },
            success: function(response) {
                $("#success").html(response.message);

                if (response.data != null) {
                    data = response.data;
                    var form = $('.form-update-data');
                    form.find('input[name=id]').val(data.id_detail_manpower);
                    form.find('select[name=persatuan]').val(data.id_detail_company);
                    form.find('input[name=fullname]').val(data.user.fullname);
                    form.find('input[name=ic_number]').val(data.ic_number);
                    form.find('input[name=phone_number]').val(data.user.phone_number);
                    form.find('input[name=email]').val(data.user.email);
                    form.find('select[name=native_status]').val(data.native_status);
                    form.find('select[name=business_activity]').val(data.business_activity);
                    form.find('select[name=invoice]').val(data.invoice);

                    // --- PENTING: Panggil getPosition() dengan ID posisi yang sudah ada ---
                    // Ambil id_position dari data yang diterima.
                    // Jika data.id_position adalah null, ini akan secara otomatis membuat `selectedPositionId` menjadi null
                    // dan memicu logika default "AHLI USIA" di fungsi getPosition().
                    let currentPositionId = data.id_position;
                    getPosition(currentPositionId);
                    // --- Akhir Penyesuaian ---


                    const hasState = response.data.has_state;

                    // initSubBusinessActivity(data); // Fungsi ini mungkin perlu memuat data sub-aktivitas
                    // initVillageGuest(data, hasState); // Fungsi ini mungkin perlu memuat data desa/tamu

                    $('#updateShareholders').modal('show');
                } else {
                    // failedAlert('Not Found');
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching user data for edit:", error);
                // Tambahkan pesan error ke pengguna
            }
        });
        return false;
    });
    // End Ajax Edit data

    // Start Ajax Update data
    $(document).on('submit', '.form-update-data', function(e) {
        e.preventDefault();
        var ini = $(this),
            input_token = $('input[name=_token]'),
            id = ini.find('input[name=id]').val(),
            url = '/senaraiAhli/update/' + id + '#view';

        var post_data = {
            is_ajax: true,
            _token: input_token.val(),

            persatuan: ini.find('select[name=persatuan]').val(),
            fullname: ini.find('input[name=fullname]').val(),
            ic_number: ini.find('input[name=ic_number]').val(),
            phone_number: ini.find('input[name=phone_number]').val(),
            email: ini.find('input[name=email]').val(),
            native_status: ini.find('select[name=native_status]').val(),
            business_activity: ini.find('select[name=business_activity]').val(),
            sub_business_activity: $('#sub_business_activity').val(),
            village_guests: $('#village_guests').val(),
            invoice: ini.find('select[name=invoice]').val(),
            status: ini.find('select[name=status]').val(),

            // --- PENYESUAIAN BARU UNTUK JAWATAN (POSITION) ---
            // Jika select jawatan punya ID 'edit-position-select':
            id_position: $('#edit-position-select').val(),
            // ATAU, jika select jawatan punya NAME 'jawatan' dan berada di dalam form ini:
            // id_position: ini.find('select[name=jawatan]').val(),
            // Pilih salah satu yang sesuai dengan HTML kamu.
            // --- AKHIR PENYESUAIAN ---
        };

        // var e_modal_wait = $("#modalWait");
        // showLoading(e_modal_wait);

        $.ajax({
                url: url,
                type: "post",
                data: post_data
            })
            .done(function(result) {
                // var message = result.message;
                // hideLoading(e_modal_wait);
                if (result.data != null) {
                    $('#updateShareholders').modal('hide');
                    // initData(param)
                    // successAlert(message);

                    loadData()
                    // loadDataTemp()
                    // location.href = "companyListofShareholders"
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
                    Swal.fire({
                        icon: "warning",
                        title: 'Warning!',
                        text: result.message,
                        showConfirmButton: true,
                    });
                }
                input_token.val(result.newToken);
            })
            .fail(function(xhr, error) {
                console.log("error : " + error)
            });

    });
    // End Ajax Update data

    // Start Filter Data
    $("body").on('submit', '.form-filter-data', function(e) {
        e.preventDefault();

        const queryString = window.location.search;
        console.log(queryString);

        var id_city = $(this).find('select[name=id_city]').val()

        var fullname = $(this).find('input[name=fullname]').is(':checked')

        // alert(fullname)

        var ic_number = $(this).find('input[name=ic_number]').is(':checked')
        var phone_number = $(this).find('input[name=phone_number]').is(':checked')
        var email = $(this).find('input[name=email]').is(':checked')

        var auth = $('input[name=auth]').val()

        $('#datatable-crud').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ordering: true,
            destroy: true,
            scrollX: true,
            lengthChange: true,
            pageLength: 10,
            lengthMenu: [
                [10, 50, 100, 250, 500],
                [10, 50, 100, 250, 500],
            ],
            paging: true,
            ajax: {
                url: "/senaraiAhli/getData" + queryString + "&id_city=" + id_city + "&fullname=" +
                    fullname + "&ic_number=" + ic_number + "&phone_number=" + phone_number + "&email=" +
                    email,
                type: 'GET',
                timeout: 60000,
            },
            columns: [

                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'persatuan'
                },
                {
                    data: 'manpower.user.fullname'
                },
                {
                    data: 'manpower.ic_number'
                },
                {
                    data: 'manpower.user.phone_number'
                },
                {
                    data: 'manpower.user.email'
                },
                // {
                //     data: 'business_type_text.business_type'
                // },
                {
                    data: 'manpower.kad_digital'
                },
                {
                    data: 'manpower.payment_kad_digital'
                },
                {
                    data: 'manpower.user.is_verified'
                },
                {
                    data: 'manpower.status_native_text'
                },
                {
                    data: 'invoice'
                },
                {
                    data: 'registered_by_name'
                },
                {
                    data: 'id_detail_manpower',
                    className: 'text-center'
                },

            ],
            columnDefs: [{
                    "targets": 1,
                    "data": "persatuan",
                    "visible": (auth == '4' || auth == '5' || auth == '6') ? false : true,
                    "render": function(data, type, row) {
                        return row.persatuan;
                    }
                },
                // {
                //     "targets": 6,
                //     "data": "business_type_text.business_type",
                //     "render": function(data, type, row) {
                //         var text = row.business_type_text == null ? 'Belum diisi' : row
                //             .business_type_text.business_type
                //         return text;
                //     }
                // },
                {
                    "targets": 7,
                    "data": "kad_digital",
                    "visible": (auth == '4' || auth == '5' || auth == '6') ? false : true,
                    "render": function(data, type, row) {
                        var btn = row.kad_digital == "TRUE" ?
                            '<div><button class=" btn btn-sm btn-success" style="width:100%">Active</button></div>' :
                            '<div><button class="btn btn-sm btn-danger btn-activate-kad" data-id="' +
                            row.id_detail_manpower +
                            '" style="width:100%">Activate</button></div>'
                        return btn;
                    }
                },
                {
                    "targets": 8,
                    "data": "manpower.payment_kad_digital",
                    "render": function(data, type, row) {
                        var text = row.manpower.payment_kad_digital == null ? '-' : row.manpower
                            .payment_kad_digital
                        return text;
                    }
                },
                {
                    "targets": 9,
                    "data": "user.is_verified",
                    "visible": (auth == '4' || auth == '5' || auth == '6') ? false : true,
                    "render": function(data, type, row) {
                        var btn = row.user.is_verified == "1" ?
                            '<div><button class=" btn btn-sm btn-success" style="width:100%">Verified</button></div>' :
                            '<div><button class="btn btn-sm btn-danger btn-verify-email" data-id="' +
                            row.user.id + '" style="width:100%">Not Verified</button></div>'
                        return btn;
                    }
                },
                {
                    "targets": 13,
                    "data": "id_detail_manpower",
                    "visible": (auth == '4' || auth == '5' || auth == '6') ? false : true,
                    "render": function(data, type, row) { //class="btn btn-primary btn-sm"
                        var btn = '<a href="" id="editData" data-id="' + row
                            .id_detail_manpower +
                            '"  data-toggle="modal" data-target="#updateShareholders" class="btn btn-warning btn-sm" ><i class="fa fa-edit nav-icon"></i></a>  ' +
                            '<a href="/companyCard?id=' + row.id_user +
                            '" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-id-card nav-icon"></i></a> ' +
                            '<a href="/cetak_pdf/' + row.ref +
                            '" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-certificate nav-icon"></i></a> ' +
                            '<a href="#" data-toggle="modal" data-id="' + row.id_user +
                            '" data-target="#updatePasswordModal" class="btn btn-danger btn-sm updatePassword"><i class="fa fa-key nav-icon"></i></a> ' +
                            '<a href="#" data-toggle="modal" data-id="' + row.id_user +
                            '" data-target="#deleteDataModal" class="btn btn-danger btn-sm deleteData"><i class="fa fa-trash nav-icon"></i></a>'

                        if (auth == '4') {
                            btn = '<a href="" id="editData" data-id="' + row
                                .id_detail_manpower +
                                '"  data-toggle="modal" data-target="#updateShareholders" class="btn btn-warning btn-sm" ><i class="fa fa-edit nav-icon"></i></a>  '
                        }

                        return btn; //settings_position/'+row.id_position+'/edit
                    }
                },
            ],
            order: [
                [0, 'asc']
            ],
        });

    });
    // End Filter Data

    // Start Ajax Delete data
    $("body").on("click", "#deleteData", function(e) {
        if (!confirm("Do you really want to do this?")) {
            return false;
        }
        e.preventDefault();
        var id = $(this).data("id");
        var token = $("meta[name='csrf-token']").attr("content");
        var url = e.target;
        $.ajax({
            url: "/senaraiAhli/delete/" + id + '#view',
            type: 'DELETE',
            data: {
                _token: token,
                id: id
            },
            success: function(response) {
                $("#success").html(response.message)
                loadData()
                // loadDataTemp()
                // location.href = "companyListofShareholders"
                // swal(
                //     'Success!',
                //     'Senarai Ahli Deleted Successfully!',
                //     'success'
                // )

                Swal.fire({
                    icon: "success",
                    title: 'Success!',
                    text: "Senarai Ahli Deleted Successfully!",
                    showConfirmButton: true,
                });
            }
        });
        return false;
    });
    // End Ajax Delete data


    $('#price').on('refresh load propertychange change click keyup input paste', (function(event) {
        $(this).val(function(index, value) {
            s = '' + value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(
                /(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return s;
        });
    }));
    $('#price1').on('refresh load propertychange change click keyup input paste', (function(event) {
        $(this).val(function(index, value) {
            s = '' + value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(
                /(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return s;
        });
    }));

    function getPosition(selectedPositionId = null) {
        $.ajax({
            type: "GET",
            url: "/api/getPosition",
            dataType: "json",
            success: function(res) {
                if (res.success && res.data) {
                    let options = '<option value="">-- Pilih Jawatan --</option>'; // Opsi default
                    let defaultAhliUsiaId = null; // Inisialisasi untuk menyimpan ID "AHLI USIA"

                    res.data.forEach(function(position) {
                        // Anda perlu tahu ID untuk 'AHLI USIA'.
                        // Jika 'AHLI USIA' adalah "Staff" dengan id_position: 3 seperti di data contoh:
                        if (position.position ===
                            "Staff") { // Ganti "Staff" jika "AHLI USIA" punya nama lain di API
                            defaultAhliUsiaId = position.id_position;
                        }
                        options +=
                            `<option value="${position.id_position}">${position.position}</option>`;
                    });

                    $('#edit-position-select').html(options);

                    // Setelah dropdown terisi, set nilai yang dipilih
                    if (selectedPositionId !== null) {
                        // Jika ada ID posisi dari data user yang sedang diedit, set itu
                        $('#edit-position-select').val(selectedPositionId);
                    } else {
                        // Jika tidak ada selectedPositionId (null/kosong), set ke default "AHLI USIA"
                        // Pastikan defaultAhliUsiaId sudah ditemukan dari data posisi
                        if (defaultAhliUsiaId !== null) {
                            $('#edit-position-select').val(defaultAhliUsiaId);
                        } else {
                            // Fallback jika 'AHLI USIA' tidak ditemukan di data, bisa pilih opsi pertama atau biarkan --Pilih Jawatan--
                            // Misalnya, Anda bisa memilih opsi pertama yang valid setelah "--Pilih Jawatan--"
                            // atau biarkan default "--Pilih Jawatan--"
                            $('#edit-position-select').val(
                                ""); // Biarkan default --Pilih Jawatan-- jika tidak ada yang cocok
                        }
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching positions:", error);
                // Anda bisa tambahkan pesan error ke pengguna di sini jika perlu
            }
        });
    }

    getPosition()
</script>
@endsection
