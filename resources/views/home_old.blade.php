
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    
    
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('template_dashboard/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- IonIcons -->
    <link rel="stylesheet" href="/css/ionicons.min.css">
    <!--My Style-->
    <link rel="stylesheet" href="/css/custom.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('template_dashboard/dist/css/adminlte.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        @include('layouts.navbar')
        <aside class="main-sidebar elevation-4 sidebar-light-maroon">
            <a href="#" class="brand-link">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <img src="{{asset('landingpage_new/')}}/OGSE_files/logo.png" alt="AdminLTE Logo" class="brand-text" style="width: 100px;">
                <!--<span class=" font-weight-blue">OGSE</span>-->
            </a>
        @include('layouts.sidebar')
        </aside>
        <div class="content-wrapper">
            <div class="content-header" style="height: 50px;">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h3 class="m-0 text-dark">@yield('pageheader')</h3> 
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <?php
                                    use Carbon\Carbon;
                                ?>
                                <?php
                                    $now = Carbon::now();
                                ?>
                                <li class="breadcrumb-item"><a href="{{URL::to('home?year='.$now->year.'')}}">Home</a></li>
                                @yield('breadcrumb')
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    
                    @yield('content')
                </div>
            </section>
        </div>
        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.1.0-rc
            </div>
            <strong>Copyright &copy; 2021 <a href="#">Idolegacy Sdn Bhd</a>.</strong> All rights reserved.
        </footer>
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
    
    <script src="/js/jquery.js"></script>  
    <script src="/js/jquery.form.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    
     <!--AdminLTE App -->
    <script src="{{asset('template_dashboard/dist/js/adminlte.min.js')}}"></script>
    
    <!--jgn dihapus dulu ya-->
    <!-- jQuery -->
    <!--<script src="{{asset('template_dashboard/plugins/jquery/jquery.min.js')}}"></script>-->
    <!-- Bootstrap 4 -->
    <!--<script src="{{asset('template_dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>-->
    
    <!--<script src="{{asset('template_dashboard/dist/js/demo.js')}}"></script>-->
    @stack('custom-js')
</body>
</html>
