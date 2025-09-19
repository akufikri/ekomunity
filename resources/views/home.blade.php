<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title-dashboard')</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('landingpage/') }}/images/logo-usia.png">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('template_dashboard/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <!-- v -->
    <link rel="stylesheet" href="{{ asset('template_dashboard/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- overlayScrollbars -->
    <!-- v -->
    <link rel="stylesheet"
        href="{{ asset('template_dashboard/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Theme style -->
    <!-- v -->
    <link rel="stylesheet" href="{{ asset('template_dashboard/dist/css/adminlte.min.css') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/template_dashboard/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @stack('custom-css')
</head>

<body class="hold-transition sidebar-mini layout-navbar-fixed layout-fixed">
    <!-- Site wrapper -->
    <div class="wrapper">
        @include('layouts.navbar', [
            'count' => App\Models\InboxRecipient::with('inbox')->where('recipient', Auth::user()->id)->where('is_read', 0)->get()->count(),
            'inbox' => App\Models\InboxRecipient::with('inbox')->where('recipient', Auth::user()->id)->orderBy('id', 'DESC')->get(),
        ])
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-light-maroon elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link" style="text-align-last: center;">
                @if ($global_brand && $global_brand->logo_url)
                    <img src="{{ $global_brand->logo_url }}" alt="{{ $global_brand->brand_name }}"
                        class="brand-text logo-mini" style="width: 50px;">
                @else
                    <img src="{{ asset('landingpage/images/logo/logo-ekomuniti.png') }}" alt="Coedev logo"
                        class="brand-text logo-mini" style="width: 50px;">
                @endif
                <!-- <span class="brand-text font-weight-light">AdminLTE 3</span> -->
            </a><br><br>

            @include('layouts.sidebar')
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>@yield('pageheader')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <?php
                                use Carbon\Carbon;
                                ?>
                                <?php
                                $now = Carbon::now();
                                ?>
                                <li class="breadcrumb-item"><a
                                        href="{{ URL::to('home?year=' . $now->year . '') }}">Home</a>
                                </li>

                                @yield('breadcrumb')
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="container-fluid">

                    @include('layouts.validationdata')

                    @yield('content')

                </div>


            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                {{-- <b>Version</b> 1.0 --}}
            </div>
            <strong>&copy; Pertubuhan Islam Seluruh Sabah. <a href="#"> Hasil kerjasama Coedev Technology Sdn
                    Bhd</a>.</strong>
        </footer>
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <script src="/js/jquery.js"></script>
    <script src="/js/jquery.form.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="/template_dashboard/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/template_dashboard/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="/template_dashboard/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="/template_dashboard/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="/template_dashboard/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('template_dashboard/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('template_dashboard/plugins/chart.js/Chart.min.js') }}"></script>
    <script src="/js/my-custom.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
    <script type="text/javascript" src="/js/config-firebase.js"></script>
    @stack('custom-js')
</body>

</html>
