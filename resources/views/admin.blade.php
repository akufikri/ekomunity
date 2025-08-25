@extends('home')
@section('title-dashboard', 'Admin')
@section('title', 'Admin')

@section('breadcrumb')
    <li class="breadcrumb-item active"><a>Dashboard</a></li>
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
        @if (Auth::user()->id_level == 1)
            <div class="col-12 col-sm-12 col-md-12 pl-12">
            @elseif(Auth::user()->id_level == 4)
                <div class="col-12 col-sm-9 col-md-9 pl-9">
        @endif
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

            <div class="info-box-content">
                <span class="info-box-text" style="font-size:12px;">Ahli proses daftar</span>
                <span class="info-box-number">
                    {{ $ahli_belum_complete_daftar }} Ahli
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    </div>

    <div class="row">
        <div class="col-12 col-sm-6 col-md-3 pl-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text" style="font-size:12px;">Jumlah Persatuan</span>
                    <span class="info-box-number">
                        {{ $persatuan }} Persatuan
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3 p-0">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text" style="font-size:12px;">Jumlah pendaftaran ahli keseluruhan</span>
                    <span class="info-box-number">{{ $ahli_dalam_persatuan }} Ahli</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-6 col-md-3 pl-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text" style="font-size:12px;">Jumlah Ahli Terus</span>
                    <span class="info-box-number">{{ $ahli_terus }} Ahli</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        @if (Auth::user()->id_level == 1)
            <div class="col-12 col-sm-6 col-md-3 p-0 pr-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text" style="font-size:12px;">Jumlah Yuran Dibayar</span>
                        <span class="info-box-number">RM {{ $yuran_dibayar }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        @endif
    </div>

    <div class="row">
        <div class="col-12 col-sm-6 col-md-3 pl-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text" style="font-size:12px;">Peniaga Lelaki</span>
                    <span class="info-box-number">
                        {{ $perniaga_lelaki }} Ahli
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3 p-0">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text" style="font-size:12px;">Peniaga Perempuan</span>
                    <span class="info-box-number">{{ $perniaga_perempuan }} Ahli</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-6 col-md-3 pl-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text" style="font-size:12px;">Tidak Berdaftar</span>
                    <span class="info-box-number">{{ $tidak_berdaftar }} Peniaga</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        @if (Auth::user()->id_level == 1)
            <div class="col-12 col-sm-6 col-md-3 p-0 pr-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text" style="font-size:12px;">Belum Membayar Yuran</span>
                        <span class="info-box-number">{{ $belum_membayar_yuran }} Orang</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        @endif
    </div>

    <div class="row">

        <!-- /.col (LEFT) -->
        <div class="col-md-2">
            <div class="form-group">
                <!--<label for="exampleInputEmail1">Filter</label>-->
                <select class="form-control form-control-sm filter" name="filter" id="filter" required autofocus>
                    <option selected value="Daily">Harian</option>
                    <option value="Monthly">Bulanan</option>
                    <option value="Yearly">Tahunan</option>
                </select>
            </div>
        </div>
        <div class="col-md-12">

            <!-- BAR CHART -->
            <div class="card card-danger card-outline" style="border-top: 3px solid dark">
                <div class="card-header">
                    <h3 class="card-title my-header" style="color: #383444">Graf Registrasi Ahli</h3>

                    <!--<div class="card-tools">-->
                    <!--  <button type="button" class="btn btn-tool" data-card-widget="collapse">-->
                    <!--    <i class="fas fa-minus"></i>-->
                    <!--  </button>-->
                    <!--  <button type="button" class="btn btn-tool" data-card-widget="remove">-->
                    <!--    <i class="fas fa-times"></i>-->
                    <!--  </button>-->
                    <!--</div>-->
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="barChart"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->



        </div>
        <!-- /.col (RIGHT) -->
    </div>

    {{-- SENARAI AHLI --}}
    <div class="row" id="view">
        <div class="col-12">
            <div class="card card-danger card-outline" style="border-top: 3px solid dark">
                <div class="card-header">
                    <h3 class="card-title text-danger my-header">Recent Registration</h3>
                    {{-- <div class="card-tools">
                            <a href="#" data-toggle="modal" title="Add" data-target="#addShareholders"  class="btn btn-sm btn-success pull-right">
                                <i class="fa fa-plus nav-icon"></i>
                                &nbsp; Add
                            </a>
                        </div> --}}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="container mt-2 my-table">
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    {{ $message }}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                                </div><br>
                            @endif
                            @if ($message = Session::get('failed'))
                                <div class="alert alert-danger">
                                    {{ $message }}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                                </div><br>
                            @endif
                            <div class="table-responsive">

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Filter</label>
                                            <select class="custom-select filter-recent"
                                                style="height: 31px; font-size: small;">
                                                <option value="today" selected>Today</option>
                                                <option value="week">This Week</option>
                                                <option value="month">This Month</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <table class="table table-bordered table-sm nowrap" id="datatable-crud-recent-ahli">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th>Name </th>
                                            <th>IC/Passport </th>
                                            <th>No. Telefon </th>
                                            <th>Emel </th>
                                            <th>Daerah </th>
                                            <th>Tamu Desa </th>
                                            <th>Tarikh Daftar </th>
                                            <th>Masa Daftar </th>
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
    {{-- SENARAI AHLI --}}

    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <div class="col-md-12 pl-3">

            <div class="row">

                <div class="col-md-6 pr-0">
                    <!-- USERS LIST -->
                    <div class="card card-danger card-outline" style="border-top: 3px solid dark">
                        <div class="card-header">
                            <h3 class="card-title my-header text-danger">Senarai Cawangan Terkini </h3>

                            {{-- <div class="card-tools">
                      <span class="badge badge-danger">8 New Members</span>
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                      </button>
                    </div> --}}
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <ul class="users-list clearfix">

                                @foreach ($senarai_ahli as $d)
                                    <li>
                                        <img src="/Profil/{{ isset($d->photo) ? $d->photo : 'user.png' }}"
                                            style="min-height:100px; max-height:100px" width="100px" height="100px"
                                            alt="User Image">
                                        <a class="users-list-name"
                                            href="#">{{ isset($d->fullname) ? $d->fullname : '-' }}</a>
                                        <span
                                            class="users-list-date">{{ date('d-m-Y', strtotime($d->created_at)) }}</span>
                                    </li>
                                @endforeach

                                <!-- /.users-list -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer text-center">
                            <a class="text-danger" href="/senaraiAhli?status=Overall">Lihat semua Cawangan</a>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!--/.card -->
                </div>

                <div class="col-md-6">
                    <!-- USERS LIST -->
                    <div class="card card-danger card-outline" style="border-top: 3px solid dark">
                        <div class="card-header">
                            <h3 class="card-title my-header text-danger">Senarai Persatuan Terkini </h3>

                            {{-- <div class="card-tools">
                      <span class="badge badge-danger">8 New Members</span>
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                      </button>
                    </div> --}}
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <ul class="users-list clearfix">
                                @foreach ($senarai_persatuan as $d)
                                    <li>
                                        <img src="/CompanyLogo/{{ isset($d->company->logo_picture) ? $d->company->logo_picture : 'user.png' }}"
                                            style="min-height:100px; max-height:100px" width="100px" height="100px"
                                            alt="User Image">
                                        <a class="users-list-name"
                                            href="#">{{ isset($d->company->full_company_name) ? $d->company->full_company_name : '-' }}</a>
                                        <span
                                            class="users-list-date">{{ date('d-m-Y', strtotime($d->created_at)) }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            <!-- /.users-list -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer text-center">
                            <a class="text-danger" href="/senaraiPersatuan?status=Overall">Lihat semua Persatuan</a>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!--/.card -->
                </div>
            </div>
            <!-- /.row -->


        </div>
        <!-- /.col -->

    </div>
    <!-- /.row -->


    <script>
        $(function() {

            var filter = "today";

            $(".filter-recent").on("change", function() {
                filter = this.value;
                console.log('ini');
                loadDataRecentRegisterAhli(filter)

            })

            loadStats('Daily');


            loadDataRecentRegisterAhli();


            $(".filter").on("change", function() {
                var filter_stats = this.value;
                loadStats(filter_stats);

            });

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
                        loadDataRecentRegisterAhli()
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

        })

        function loadStats(filter) {
            $.ajax({
                url: "/getStatsRegisterAhli?filter=" + filter,
                type: 'GET',
                success: function(response) {
                    var areaChartData = response;

                    // Gunakan warna custom
                    areaChartData.datasets.forEach(dataset => {
                        dataset.backgroundColor = '#383444';
                        dataset.borderColor = '#383444';
                        dataset.pointBackgroundColor = '#383444';
                        dataset.pointBorderColor = '#383444';
                    });

                    var areaChartOptions = {
                        maintainAspectRatio: false,
                        responsive: true,
                        legend: {
                            display: false
                        },
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    display: false
                                }
                            }],
                            yAxes: [{
                                gridLines: {
                                    display: false
                                }
                            }]
                        }
                    }

                    var barChartCanvas = $('#barChart').get(0).getContext('2d');

                    // Buat line chart
                    var areaChart = new Chart(barChartCanvas, {
                        type: 'line',
                        data: areaChartData,
                        options: areaChartOptions
                    });

                    // Tukar data untuk bar chart
                    var barChartData = $.extend(true, {}, areaChartData);
                    var temp0 = areaChartData.datasets[0];
                    var temp1 = areaChartData.datasets[1];

                    barChartData.datasets[0] = temp1;
                    barChartData.datasets[1] = temp0;

                    // Optional: tambahkan background solid khusus untuk bar chart
                    barChartData.datasets.forEach(dataset => {
                        dataset.backgroundColor = '#383444';
                        dataset.borderColor = '#383444';
                    });

                    var barChartOptions = {
                        responsive: true,
                        maintainAspectRatio: false,
                        datasetFill: false
                    }

                    // Render bar chart
                    var barChart = new Chart(barChartCanvas, {
                        type: 'bar',
                        data: barChartData,
                        options: barChartOptions
                    });
                }
            });
        }


        function loadDataRecentRegisterAhli(filter = "today") {

            $('#datatable-crud-recent-ahli').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                scrollX: true,
                ajax: {
                    url: "/getRecentRegisterAhli?filter=" + filter,
                    type: 'GET'
                },
                columns: [

                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'user.fullname'
                    },
                    {
                        data: 'ic_number'
                    },
                    {
                        data: 'user.phone_number'
                    },
                    {
                        data: 'user.email'
                    },
                    {
                        data: 'city.city'
                    },
                    {
                        data: 'village_guest'
                    },
                    {
                        data: 'created_date'
                    },
                    {
                        data: 'created_time'
                    },
                    {
                        data: 'id_detail_manpower'
                    },
                ],
                columnDefs: [{
                        "targets": 5,
                        "data": "city.city",
                        "render": function(data, type, row) {
                            var text = row.id_city != null ? row.city.city : '-';

                            return text;
                        }
                    },
                    {
                        "targets": 6,
                        "data": "village_guest",
                        "render": function(data, type, row) {
                            var text = row.id_village_guests != null ? row.village_guest : '-';

                            return text;
                        }
                    },
                    {
                        "targets": 9,
                        "data": "user.is_verified",
                        "render": function(data, type, row) {
                            var btn = row.user.is_verified != "1" ?
                                '<div><button class="btn btn-sm btn-danger btn-verify-email" data-id="' +
                                row.user.id + '" style="width:100%">Verifikasi Emel</button></div>' : '-';
                            return btn;
                        }
                    },
                ],
                order: [
                    [0, 'asc']
                ]
            });

        }
    </script>
@endsection
