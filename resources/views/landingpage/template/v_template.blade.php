<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="" />
		<meta name="description" content="JobBoard - HTML Template" />
	<meta property="og:title" content="JobBoard - HTML Template" />
	<meta property="og:description" content="JobBoard - HTML Template" />
	<meta property="og:image" content="JobBoard - HTML Template" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON -->
	<link rel="icon" href="{{asset('landingpage/')}}/images/logo.png" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="{{asset('landingpage/')}}/images/logo.png" />
	
	<!-- PAGE TITLE HERE -->
	<title>G3PNS</title>
	
	<!-- MOBILE SPECIFIC -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!--[if lt IE 9]>
	<script src="js/html5shiv.min.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
	
	<!-- STYLESHEETS -->
	<link rel="stylesheet" type="text/css" href="{{asset('landingpage/')}}/css/plugins.css">
	<link rel="stylesheet" type="text/css" href="{{asset('landingpage/')}}/css/style.css">
	<link rel="stylesheet" type="text/css" href="{{asset('landingpage/')}}/css/templete.css">
	<link class="skin" rel="stylesheet" type="text/css" href="{{asset('landingpage/')}}/css/skin/skin-1.css">
	<link rel="stylesheet" href="{{asset('landingpage/')}}/plugins/datepicker/css/bootstrap-datetimepicker.min.css"/>
	<!-- Revolution Slider Css -->
	<link rel="stylesheet" type="text/css" href="{{asset('landingpage/')}}/plugins/revolution/revolution/css/layers.css">
	<link rel="stylesheet" type="text/css" href="{{asset('landingpage/')}}/plugins/revolution/revolution/css/settings.css">
	<link rel="stylesheet" type="text/css" href="{{asset('landingpage/')}}/plugins/revolution/revolution/css/navigation.css">
	<!-- Revolution Navigation Style -->
</head>
<body id="bg">
<div id="loading-area"></div>
<div class="page-wraper">
	<!-- header -->
    <header class="site-header mo-left header fullwidth">
		<!-- main header -->
        @include('landingpage.template.v_navbar')
        <!-- main header END -->
    </header>
    <!-- header END -->
    <!-- Content -->
    <div class="page-content">
        @yield('content')
	</div>
		<!-- Call To Action END -->
		<!-- Our Latest Blog -->
		<!--<div class="section-full content-inner-2 overlay-white-middle" style="background-image:url({{asset('landingpage/')}}/images/lines.png); background-position:bottom; background-repeat:no-repeat; background-size: 100%;">-->
		<!--	<div class="container">-->
		<!--		<div class="section-head text-black text-center">-->
		<!--			<h2 class="m-b0">Membership Plans</h2>-->
		<!--			<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy.</p>-->
		<!--		</div>-->
					<!-- Pricing table-1 Columns 3 with gap -->
		<!--			<div class="section-content box-sort-in button-example m-t80">-->
		<!--				<div class="pricingtable-row">-->
		<!--					<div class="row max-w1000 m-auto">-->
		<!--						<div class="col-sm-12 col-md-4 col-lg-4 p-lr0">-->
		<!--							<div class="pricingtable-wrapper style2 bg-white">-->
		<!--								<div class="pricingtable-inner">-->
		<!--									<div class="pricingtable-price"> -->
		<!--										<h4 class="font-weight-300 m-t10 m-b0">Basic</h4>-->
		<!--										<div class="pricingtable-bx"><span>Free</span></div>-->
		<!--									</div>-->
		<!--									<p>Lorem ipsum dolor sit amet adipiscing elit sed do eiusmod tempors labore et dolore magna siad enim aliqua</p>-->
		<!--									<div class="m-t20"> -->
		<!--										<a href="#" class="site-button radius-xl"><span class="p-lr30">Sign Up</span></a> -->
		<!--									</div>-->
		<!--								</div>-->
		<!--							</div>-->
		<!--						</div>-->
		<!--						<div class="col-sm-12 col-md-4 col-lg-4 p-lr0">-->
		<!--							<div class="pricingtable-wrapper style2 bg-primary text-white active">-->
		<!--								<div class="pricingtable-inner">-->
		<!--									<div class="pricingtable-price"> -->
		<!--										<h4 class="font-weight-300 m-t10 m-b0">Professional</h4>-->
		<!--										<div class="pricingtable-bx"> $ <span>29</span> /  Per Installation </div>-->
		<!--									</div>-->
		<!--									<p>Lorem ipsum dolor sit amet adipiscing elit sed do eiusmod tempors labore et dolore magna siad enim aliqua</p>-->
		<!--									<div class="m-t20"> -->
		<!--										<a href="#" class="site-button white radius-xl"><span class="p-lr30">Sign Up</span></a> -->
		<!--									</div>-->
		<!--								</div>-->
		<!--							</div>-->
		<!--						</div>-->
		<!--						<div class="col-sm-12 col-md-4 col-lg-4 p-lr0">-->
		<!--							<div class="pricingtable-wrapper style2 bg-white">-->
		<!--								<div class="pricingtable-inner">-->
		<!--									<div class="pricingtable-price"> -->
		<!--										<h4 class="font-weight-300 m-t10 m-b0">Extended</h4>-->
		<!--										<div class="pricingtable-bx"> $  <span>29</span> /  Per Installation </div>-->
		<!--									</div>-->
		<!--									<p>Lorem ipsum dolor sit amet adipiscing elit sed do eiusmod tempors labore et dolore magna siad enim aliqua</p>-->
		<!--									<div class="m-t20"> -->
		<!--										<a href="#" class="site-button radius-xl"><span class="p-lr30">Sign Up</span></a> -->
		<!--									</div>-->
		<!--								</div>-->
		<!--							</div>-->
		<!--						</div>-->
		<!--					</div>-->
		<!--				</div>-->
		<!--			</div>-->
		<!--	</div>-->
		<!--</div>-->
		<!-- Our Latest Blog -->
	</div>
	<!-- Footer -->
    <footer class="site-footer">
        @include('landingpage.template.v_footer')
    </footer>
    <!-- Footer END -->
    <!-- scroll top button -->
    <button class="scroltop fa fa-arrow-up" ></button>
</div>
<!-- JAVASCRIPT FILES ========================================= -->
<script src="{{asset('landingpage/')}}/js/jquery.min.js"></script><!-- JQUERY.MIN JS -->
<script src="{{asset('landingpage/')}}/plugins/wow/wow.js"></script><!-- WOW JS -->
<script src="{{asset('landingpage/')}}/plugins/bootstrap/js/popper.min.js"></script><!-- BOOTSTRAP.MIN JS -->
<script src="{{asset('landingpage/')}}/plugins/bootstrap/js/bootstrap.min.js"></script><!-- BOOTSTRAP.MIN JS -->
<script src="{{asset('landingpage/')}}/plugins/bootstrap-select/bootstrap-select.min.js"></script><!-- FORM JS -->
<script src="{{asset('landingpage/')}}/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script><!-- FORM JS -->
<script src="{{asset('landingpage/')}}/plugins/magnific-popup/magnific-popup.js"></script><!-- MAGNIFIC POPUP JS -->
<script src="{{asset('landingpage/')}}/plugins/counter/waypoints-min.js"></script><!-- WAYPOINTS JS -->
<script src="{{asset('landingpage/')}}/plugins/counter/counterup.min.js"></script><!-- COUNTERUP JS -->
<script src="{{asset('landingpage/')}}/plugins/imagesloaded/imagesloaded.js"></script><!-- IMAGESLOADED -->
<script src="{{asset('landingpage/')}}/plugins/masonry/masonry-3.1.4.js"></script><!-- MASONRY -->
<script src="{{asset('landingpage/')}}/plugins/masonry/masonry.filter.js"></script><!-- MASONRY -->
<script src="{{asset('landingpage/')}}/plugins/owl-carousel/owl.carousel.js"></script><!-- OWL SLIDER -->
<script src="{{asset('landingpage/')}}/plugins/rangeslider/rangeslider.js" ></script><!-- Rangeslider -->
<script src="{{asset('landingpage/')}}/js/custom.js"></script><!-- CUSTOM FUCTIONS  -->
<script src="{{asset('landingpage/')}}/js/dz.carousel.js"></script><!-- SORTCODE FUCTIONS  -->
<script src="{{asset('landingpage/')}}/js/recaptcha/api.js"></script> <!-- Google API For Recaptcha  -->
<script src="{{asset('landingpage/')}}/js/dz.ajax.js"></script><!-- CONTACT JS  -->
<script src="{{asset('landingpage/')}}/plugins/paroller/skrollr.min.js"></script><!-- PAROLLER -->


</body>

</html>