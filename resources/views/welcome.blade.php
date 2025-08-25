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
	<link rel="icon" href="#" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="#" />
	
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
		<!-- Section Banner -->
		<div class="dez-bnr-inr dez-bnr-inr-md" style="background-image:url({{asset('landingpage/')}}/images/main-slider/slide2.jpeg);">
            <div class="container">
                <div class="dez-bnr-inr-entry align-m ">
					<div class="find-job-bx">
						<p class="site-button button-sm">Find Jobs, Employment & Career Opportunities</p>
						<h2>Search Between More Them <br/> <span class="text-primary">50,000</span> Open Jobs.</h2>
						<form class="dezPlaceAni">
							<div class="row">
								<div class="col-lg-4 col-md-6">
									<div class="form-group">
										<label>Job Title, Keywords, or Phrase</label>
										<div class="input-group">
											<input type="text" class="form-control" placeholder="">
											<div class="input-group-append">
											  <span class="input-group-text"><i class="fa fa-search"></i></span>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-3 col-md-6">
									<div class="form-group">
										<label>City, State or ZIP</label>
										<div class="input-group">
											<input type="text" class="form-control" placeholder="">
											<div class="input-group-append">
											  <span class="input-group-text"><i class="fa fa-map-marker"></i></span>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-3 col-md-6">
									<div class="form-group">
										<select>
											<option>Select Sector</option>
											<option>Construction</option>
											<option>Corodinator</option>
											<option>Employer</option>
											<option>Financial Career</option>
											<option>Information Technology</option>
											<option>Marketing</option>
											<option>Quality check</option>
											<option>Real Estate</option>
											<option>Sales</option>
											<option>Supporting</option>
											<option>Teaching</option> 
										</select>
									</div>
								</div>
								<div class="col-lg-2 col-md-6">
									<button type="submit" class="site-button btn-block">Find Job</button>
								</div>
							</div>
						</form>
					</div>
				</div>
            </div>
        </div>
		<!-- Section Banner END -->
        <!-- About Us -->
		<div class="section-full job-categories content-inner-2 bg-white" style="background-image:url({{asset('landingpage/')}}/images/pattern/pic1.html);">
			<div class="container">
				<div class="section-head d-flex head-counter clearfix">
					<div class="mr-auto">
						<h2 class="m-b5">Popular Categories</h2>
						<h6 class="fw3">20+ Catetories work wating for you</h6>
					</div>
					<div class="head-counter-bx">
						<h2 class="m-b5 counter">1800</h2>
						<h6 class="fw3">Jobs Posted</h6>
					</div>
					<div class="head-counter-bx">
						<h2 class="m-b5 counter">4500</h2>
						<h6 class="fw3">Tasks Posted</h6>
					</div>
					<div class="head-counter-bx">
						<h2 class="m-b5 counter">1500</h2>
						<h6 class="fw3">Freelancers</h6>
					</div>
				</div>
				<div class="row sp20">
					<div class="col-lg-3 col-md-6 col-sm-6">
						<div class="icon-bx-wraper">
							<div class="icon-content">
								<div class="icon-md text-primary m-b20"><i class="ti-location-pin"></i></div>
								<a href="#" class="dez-tilte">Design, Art & Multimedia</a>
								<p class="m-a0">198 Open Positions</p>
								<div class="rotate-icon"><i class="ti-location-pin"></i></div> 
							</div>
						</div>				
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6">
						<div class="icon-bx-wraper">
							<div class="icon-content">
								<div class="icon-md text-primary m-b20"><i class="ti-wand"></i></div>
								<a href="#" class="dez-tilte">Education Training</a>
								<p class="m-a0">198 Open Positions</p>
								<div class="rotate-icon"><i class="ti-wand"></i></div> 
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6">
						<div class="icon-bx-wraper">
							<div class="icon-content">
								<div class="icon-md text-primary m-b20"><i class="ti-wallet"></i></div>
								<a href="#" class="dez-tilte">Accounting / Finance</a>
								<p class="m-a0">198 Open Positions</p>
								<div class="rotate-icon"><i class="ti-wallet"></i></div> 
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6">
						<div class="icon-bx-wraper">
							<div class="icon-content">
								<div class="icon-md text-primary m-b20"><i class="ti-cloud-up"></i></div>
								<a href="#" class="dez-tilte">Human Resource</a>
								<p class="m-a0">198 Open Positions</p>
								<div class="rotate-icon"><i class="ti-cloud-up"></i></div> 
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6">
						<div class="icon-bx-wraper">
							<div class="icon-content">
								<div class="icon-md text-primary m-b20"><i class="ti-bar-chart"></i></div>
								<a href="#" class="dez-tilte">Telecommunications</a>
								<p class="m-a0">198 Open Positions</p>
								<div class="rotate-icon"><i class="ti-bar-chart"></i></div> 
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6">
						<div class="icon-bx-wraper">
							<div class="icon-content">
								<div class="icon-md text-primary m-b20"><i class="ti-tablet"></i></div>
								<a href="#" class="dez-tilte">Restaurant / Food Service</a>
								<p class="m-a0">198 Open Positions</p>
								<div class="rotate-icon"><i class="ti-tablet"></i></div> 
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6">
						<div class="icon-bx-wraper">
							<div class="icon-content">
								<div class="icon-md text-primary m-b20"><i class="ti-camera"></i></div>
								<a href="#" class="dez-tilte">Construction / Facilities</a>
								<p class="m-a0">198 Open Positions</p>
								<div class="rotate-icon"><i class="ti-camera"></i></div> 
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6">
						<div class="icon-bx-wraper">
							<div class="icon-content">
								<div class="icon-md text-primary m-b20"><i class="ti-panel"></i></div>
								<a href="#" class="dez-tilte">Health</a>
								<p class="m-a0">198 Open Positions</p>
								<div class="rotate-icon"><i class="ti-panel"></i></div> 
							</div>
						</div>
					</div>
					<div class="col-lg-12 text-center m-t30">
						<button class="site-button radius-xl">All Categories</button>
					</div>
				</div>
			</div>
		</div>
		<!-- About Us END -->
		<!-- Call To Action -->
		<div class="section-full content-inner bg-gray">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 section-head text-center">
						<h2 class="m-b5">Featured Cities</h2>
						<h6 class="fw4 m-b0">20+ Featured Cities Added Jobs</h5>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-3 col-sm-6 col-md-6 m-b30">
						<div class="city-bx align-items-end  d-flex" style="background-image:url({{asset('landingpage/')}}/images/city/pic1.jpg)">
							<div class="city-info">
								<h5>Iraq</h5>
								<span>765 Jobs</span>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6 col-md-6 m-b30">
						<div class="city-bx align-items-end  d-flex" style="background-image:url({{asset('landingpage/')}}/images/city/pic2.jpg)">
							<div class="city-info">
								<h5>Argentina</h5>
								<span>352 Jobs</span>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6 col-md-6 m-b30">
						<div class="city-bx align-items-end  d-flex" style="background-image:url({{asset('landingpage/')}}/images/city/pic3.jpg)">
							<div class="city-info">
								<h5>Indonesia</h5>
								<span>893 Jobs</span>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6 col-md-6 m-b30">
						<div class="city-bx align-items-end  d-flex" style="background-image:url({{asset('landingpage/')}}/images/city/pic4.jpg)">
							<div class="city-info">
								<h5>Gambia</h5>
								<span>502 Jobs</span>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6 col-md-6 m-b30">
						<div class="city-bx align-items-end  d-flex" style="background-image:url({{asset('landingpage/')}}/images/city/pic5.jpg)">
							<div class="city-info">
								<h5>India</h5>
								<span>765 Jobs</span>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6 col-md-6 m-b30">
						<div class="city-bx align-items-end  d-flex" style="background-image:url({{asset('landingpage/')}}/images/city/pic6.jpg)">
							<div class="city-info">
								<h5>Thailand</h5>
								<span>352 Jobs</span>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6 col-md-6 m-b30">
						<div class="city-bx align-items-end  d-flex" style="background-image:url({{asset('landingpage/')}}/images/city/pic7.jpg)">
							<div class="city-info">
								<h5>Banjul</h5>
								<span>893 Jobs</span>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6 col-md-6 m-b30">
						<div class="city-bx align-items-end  d-flex" style="background-image:url({{asset('landingpage/')}}/images/city/pic8.jpg)">
							<div class="city-info">
								<h5>Spain</h5>
								<span>502 Jobs</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Call To Action END -->
		<!-- Our Job -->
		<div class="section-full bg-white content-inner-2">
			<div class="container">
				<div class="d-flex job-title-bx section-head">
					<div class="mr-auto">
						<h2 class="m-b5">Recent Jobs</h2>
						<h6 class="fw4 m-b0">20+ Recently Added Jobs</h5>
					</div>
					<div class="align-self-end">
						<a href="#" class="site-button button-sm">Browse All Jobs <i class="fa fa-long-arrow-right"></i></a>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-9">
						<ul class="post-job-bx">
							<li>
								<a href="#">
									<div class="d-flex m-b30">
										<div class="job-post-company">
											<span><img src="{{asset('landingpage/')}}/images/logo/icon1.png"/></span>
										</div>
										<div class="job-post-info">
											<h4>Digital Marketing Executive</h4>
											<ul>
												<li><i class="fa fa-map-marker"></i> Sacramento, California</li>
												<li><i class="fa fa-bookmark-o"></i> Full Time</li>
												<li><i class="fa fa-clock-o"></i> Published 11 months ago</li>
											</ul>
										</div>
									</div>
									<div class="d-flex">
										<div class="job-time mr-auto">
											<span>Full Time</span>
										</div>
										<div class="salary-bx">
											<span>$1200 - $ 2500</span>
										</div>
									</div>
									<span class="post-like fa fa-heart-o"></span>
								</a>
							</li>
							<li>
								<a href="#">
									<div class="d-flex m-b30">
										<div class="job-post-company">
											<span><img src="{{asset('landingpage/')}}/images/logo/icon1.png"/></span>
										</div>
										<div class="job-post-info">
											<h4>Digital Marketing Executive</h4>
											<ul>
												<li><i class="fa fa-map-marker"></i> Sacramento, California</li>
												<li><i class="fa fa-bookmark-o"></i> Full Time</li>
												<li><i class="fa fa-clock-o"></i> Published 11 months ago</li>
											</ul>
										</div>
									</div>
									<div class="d-flex">
										<div class="job-time mr-auto">
											<span>Full Time</span>
										</div>
										<div class="salary-bx">
											<span>$1200 - $ 2500</span>
										</div>
									</div>
									<span class="post-like fa fa-heart-o"></span>
								</a>
							</li>
							<li>
								<a href="#">
									<div class="d-flex m-b30">
										<div class="job-post-company">
											<span><img src="{{asset('landingpage/')}}/images/logo/icon1.png"/></span>
										</div>
										<div class="job-post-info">
											<h4>Digital Marketing Executive</h4>
											<ul>
												<li><i class="fa fa-map-marker"></i> Sacramento, California</li>
												<li><i class="fa fa-bookmark-o"></i> Full Time</li>
												<li><i class="fa fa-clock-o"></i> Published 11 months ago</li>
											</ul>
										</div>
									</div>
									<div class="d-flex">
										<div class="job-time mr-auto">
											<span>Full Time</span>
										</div>
										<div class="salary-bx">
											<span>$1200 - $ 2500</span>
										</div>
									</div>
									<span class="post-like fa fa-heart-o"></span>
								</a>
							</li>
							<li>
								<a href="#">
									<div class="d-flex m-b30">
										<div class="job-post-company">
											<span><img src="{{asset('landingpage/')}}/images/logo/icon1.png"/></span>
										</div>
										<div class="job-post-info">
											<h4>Digital Marketing Executive</h4>
											<ul>
												<li><i class="fa fa-map-marker"></i> Sacramento, California</li>
												<li><i class="fa fa-bookmark-o"></i> Full Time</li>
												<li><i class="fa fa-clock-o"></i> Published 11 months ago</li>
											</ul>
										</div>
									</div>
									<div class="d-flex">
										<div class="job-time mr-auto">
											<span>Full Time</span>
										</div>
										<div class="salary-bx">
											<span>$1200 - $ 2500</span>
										</div>
									</div>
									<span class="post-like fa fa-heart-o"></span>
								</a>
							</li>
							<li>
								<a href="#">
									<div class="d-flex m-b30">
										<div class="job-post-company">
											<span><img src="{{asset('landingpage/')}}/images/logo/icon1.png"/></span>
										</div>
										<div class="job-post-info">
											<h4>Digital Marketing Executive</h4>
											<ul>
												<li><i class="fa fa-map-marker"></i> Sacramento, California</li>
												<li><i class="fa fa-bookmark-o"></i> Full Time</li>
												<li><i class="fa fa-clock-o"></i> Published 11 months ago</li>
											</ul>
										</div>
									</div>
									<div class="d-flex">
										<div class="job-time mr-auto">
											<span>Full Time</span>
										</div>
										<div class="salary-bx">
											<span>$1200 - $ 2500</span>
										</div>
									</div>
									<span class="post-like fa fa-heart-o"></span>
								</a>
							</li>
							<li>
								<a href="#">
									<div class="d-flex m-b30">
										<div class="job-post-company">
											<span><img src="{{asset('landingpage/')}}/images/logo/icon1.png"/></span>
										</div>
										<div class="job-post-info">
											<h4>Digital Marketing Executive</h4>
											<ul>
												<li><i class="fa fa-map-marker"></i> Sacramento, California</li>
												<li><i class="fa fa-bookmark-o"></i> Full Time</li>
												<li><i class="fa fa-clock-o"></i> Published 11 months ago</li>
											</ul>
										</div>
									</div>
									<div class="d-flex">
										<div class="job-time mr-auto">
											<span>Full Time</span>
										</div>
										<div class="salary-bx">
											<span>$1200 - $ 2500</span>
										</div>
									</div>
									<span class="post-like fa fa-heart-o"></span>
								</a>
							</li>
						</ul>
						<div class="m-t30">
							<div class="d-flex">
								<a class="site-button button-sm mr-auto" href="#"><i class="ti-arrow-left"></i> Prev</a>
								<a class="site-button button-sm" href="#">Next <i class="ti-arrow-right"></i></a>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="sticky-top">
							<div class="candidates-are-sys m-b30">
								<div class="candidates-bx">
									<div class="testimonial-pic radius"><img src="{{asset('landingpage/')}}/images/testimonials/pic3.jpg" alt="" width="100" height="100"></div>
									<div class="testimonial-text">
										<p>I just got a job that I applied for via careerfy! I used the site all the time during my job hunt.</p>
									</div>
									<div class="testimonial-detail"> <strong class="testimonial-name">Person 3</strong> <span class="testimonial-position">Nevada, USA</span> </div>
								</div>
							</div>
							<div class="quote-bx">
								<div class="quote-info">
									<h4>Make a Difference with Your Online Resume!</h4>
									<p>Your resume in minutes with JobBoard resume assistant is ready!</p>
									<a href="#" class="site-button">Create an Account</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Our Job END -->	
		<!-- Call To Action -->
		<div class="section-full p-tb70 overlay-black-dark text-white text-center bg-img-fix" style="background-image: url({{asset('landingpage/')}}/images/background/bg4.jpg);">
			<div class="container">
				<div class="section-head text-center text-white">
					<h2 class="m-b5">What are they saying</h2>
					<h5 class="fw4">Few words from employee</h5>
				</div>
				<div class="blog-carousel-center owl-carousel owl-none">
					<div class="item">
						<div class="testimonial-5">
							<div class="testimonial-text">
								<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry...</p>
							</div>
							<div class="testimonial-detail clearfix">
								<div class="testimonial-pic radius shadow">
									<img src="{{asset('landingpage/')}}/images/testimonials/pic1.jpg" width="100" height="100" alt="">
								</div>
								<strong class="testimonial-name">Person 1</strong> 
								<span class="testimonial-position">Web Developer</span> 
							</div>
						</div>
					</div>
					<div class="item">
						<div class="testimonial-5">
							<div class="testimonial-text">
								<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry...</p>
							</div>
							<div class="testimonial-detail clearfix">
								<div class="testimonial-pic radius shadow">
									<img src="{{asset('landingpage/')}}/images/testimonials/pic2.jpg" width="100" height="100" alt="">
								</div>
								<strong class="testimonial-name">Person 2</strong> 
								<span class="testimonial-position">QA Engineer</span> 
							</div>
						</div>
					</div>
					<div class="item">
						<div class="testimonial-5">
							<div class="testimonial-text">
								<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry...</p>
							</div>
							<div class="testimonial-detail clearfix">
								<div class="testimonial-pic radius shadow">
									<img src="{{asset('landingpage/')}}/images/testimonials/pic3.jpg" width="100" height="100" alt="">
								</div>
								<strong class="testimonial-name">Person 3</strong> 
								<span class="testimonial-position">Founder Startup</span> 
							</div>
						</div>
					</div>
				</div>
			</div>
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