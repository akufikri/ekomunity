<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="robots" content="" />
    <meta name="description" content="JobBoard - HTML Template" />
    <meta property="og:title" content="Selamat Datang ke USIA" />
    <meta property="og:description"
        content="USIA - Portal rasmi Pertubuhan Islam Seluruh Sabah (USIA) adalah platform digital yang menjadi sumber utama maklumat tentang visi, misi, dan aktiviti terkini pertubuhan. Ia berfungsi untuk memperluas jangkauan dakwah USIA, menyediakan akses mudah kepada orang awam mengenai program pendidikan Islam dan acara keagamaan, serta menyalurkan berita dan penerbitan yang berkaitan dengan pembangunan Islam di Sabah. Secara ringkas, portal ini mencerminkan peranan berterusan USIA dalam menyatukan umat, mempertingkatkan ilmu pengetahuan, dan mempromosikan nilai-nilai Islam di seluruh negeri." />
    <meta property="og:image" content="JobBoard - HTML Template" />
    <meta name="format-detection" content="telephone=no">

    <!-- FAVICONS ICON -->
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('landingpage/images/logo/logo-ekomuniti.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <!-- PAGE TITLE HERE -->
    @if ($global_brand)
        <title>{{ $global_brand->name_brand }}</title>
    @else
        <title>Selamat Datang ke Coedev</title>
    @endif

    <!-- MOBILE SPECIFIC -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--[if lt IE 9]>
 <script src="js/html5shiv.min.js"></script>
 <script src="js/respond.min.js"></script>
 <![endif]-->

    <!-- STYLESHEETS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('landingpage/') }}/css/plugins.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('landingpage/') }}/css/style.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('landingpage/') }}/css/templete.css">
    <link class="skin" rel="stylesheet" type="text/css" href="{{ asset('landingpage/') }}/css/skin/skin-1.css">
    <link rel="stylesheet" href="{{ asset('landingpage/') }}/plugins/datepicker/css/bootstrap-datetimepicker.min.css" />
    <!-- Revolution Slider Css -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('landingpage/') }}/plugins/revolution/revolution/css/layers.css">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('landingpage/') }}/plugins/revolution/revolution/css/settings.css">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('landingpage/') }}/plugins/revolution/revolution/css/navigation.css">
    <!-- Revolution Navigation Style -->
</head>

<body id="bg">
    <div class="page-wraper">
        <div id="loading-area"></div>
        <!-- header -->
        <header class="site-header mo-left header fullwidth">
            <!-- main header -->
            @include('landingpage.template.v_navbar')
            <!-- main header END -->
        </header>
        <!-- header END -->
        <!-- Content -->
        <div class="page-content bg-white">
            {{-- <div class="dez-bnr-inr overlay-black-middle bg-pt"
                style="height:500px; background-image:url({{ asset('landingpage/') }}/images/main-slider/slide.jpeg);">
                <div class="container">
                    <div class="dez-bnr-inr-entry">
                        <h1 class="text-white">@yield('title')</h1>
                        <div class="breadcrumb-row">
                        	<ul class="list-inline">
                        		<li><a href="#">Home</a></li>
                        		<li>Register</li>
                        	</ul>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div style="overflow:hidden; width: 100%; height:339px">
                <img src="{{ asset('landingpage/') }}/images/main-slider/slide.jpeg" alt=""
                    style="width: 100%; height: 100%; object-fit:cover">
            </div>
            @yield('content')
        </div>
        <!-- Content END-->
        <!-- Footer -->
        <footer class="site-footer">
            @include('landingpage.template.v_footer')
        </footer>
        <!-- Footer END -->
        <button class="scroltop fa fa-chevron-up"></button>
    </div>
    <!-- JAVASCRIPT FILES ========================================= -->
    <script src="{{ asset('landingpage/') }}/js/jquery.min.js"></script><!-- JQUERY.MIN JS -->
    <script src="{{ asset('landingpage/') }}/plugins/wow/wow.js"></script><!-- WOW JS -->
    <script src="{{ asset('landingpage/') }}/plugins/bootstrap/js/popper.min.js"></script><!-- BOOTSTRAP.MIN JS -->
    <script src="{{ asset('landingpage/') }}/plugins/bootstrap/js/bootstrap.min.js"></script><!-- BOOTSTRAP.MIN JS -->
    <script src="{{ asset('landingpage/') }}/plugins/bootstrap-select/bootstrap-select.min.js"></script><!-- FORM JS -->
    <script src="{{ asset('landingpage/') }}/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script><!-- FORM JS -->
    <script src="{{ asset('landingpage/') }}/plugins/magnific-popup/magnific-popup.js"></script><!-- MAGNIFIC POPUP JS -->
    <script src="{{ asset('landingpage/') }}/plugins/counter/waypoints-min.js"></script><!-- WAYPOINTS JS -->
    <script src="{{ asset('landingpage/') }}/plugins/counter/counterup.min.js"></script><!-- COUNTERUP JS -->
    <script src="{{ asset('landingpage/') }}/plugins/imagesloaded/imagesloaded.js"></script><!-- IMAGESLOADED -->
    <script src="{{ asset('landingpage/') }}/plugins/masonry/masonry-3.1.4.js"></script><!-- MASONRY -->
    <script src="{{ asset('landingpage/') }}/plugins/masonry/masonry.filter.js"></script><!-- MASONRY -->
    <script src="{{ asset('landingpage/') }}/plugins/owl-carousel/owl.carousel.js"></script><!-- OWL SLIDER -->
    <script src="{{ asset('landingpage/') }}/plugins/rangeslider/rangeslider.js"></script><!-- Rangeslider -->
    <script src="{{ asset('landingpage/') }}/js/custom.js"></script><!-- CUSTOM FUCTIONS  -->
    <script src="{{ asset('landingpage/') }}/js/dz.carousel.js"></script><!-- SORTCODE FUCTIONS  -->
    <script src="{{ asset('landingpage/') }}/js/dz.ajax.js"></script><!-- CONTACT JS  -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="/js/my-custom.js"></script>

    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>


    <script type="text/javascript" src="/js/config-firebase.js"></script>


</body>


</html>
