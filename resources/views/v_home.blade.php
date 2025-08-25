@extends('landingpage.template.v_template')

@section('content')
		<!-- Section Banner -->
		<div class="dez-bnr-inr dez-bnr-inr-md" style="background-image:url({{asset('landingpage/')}}/images/main-slider/slide2.jpeg);">
            <div class="container">
                <div class="dez-bnr-inr-entry align-m ">
					<div class="find-job-bx" style="text-align: center !important;">
						<p class="site-button button-sm">The secret of change is to focus all of your energy not on fighting the old, but on building the new.</p>
						<h2>Action Creates <span class="text-primary">Energy</span>. We Create <span class="text-primary">Action</span>. <br>Be Part Of <span class="text-primary">The Action Today</span></h2>
						<!--<form class="dezPlaceAni">-->
							<div class="row justify-content-center">
								<!--<div class="col-lg-4 col-md-6">-->
								<!--	<div class="form-group">-->
								<!--		<label>Job Title, Keywords, or Phrase</label>-->
								<!--		<div class="input-group">-->
								<!--			<input type="text" class="form-control" placeholder="">-->
								<!--			<div class="input-group-append">-->
								<!--			  <span class="input-group-text"><i class="fa fa-search"></i></span>-->
								<!--			</div>-->
								<!--		</div>-->
								<!--	</div>-->
								<!--</div>-->
								<!--<div class="col-lg-3 col-md-6">-->
								<!--	<div class="form-group">-->
								<!--		<label>City, State or ZIP</label>-->
								<!--		<div class="input-group">-->
								<!--			<input type="text" class="form-control" placeholder="">-->
								<!--			<div class="input-group-append">-->
								<!--			  <span class="input-group-text"><i class="fa fa-map-marker"></i></span>-->
								<!--			</div>-->
								<!--		</div>-->
								<!--	</div>-->
								<!--</div>-->
								<!--<div class="col-lg-3 col-md-6">-->
								<!--	<div class="form-group">-->
								<!--		<select>-->
								<!--			<option>Select Sector</option>-->
								<!--			<option>Construction</option>-->
								<!--			<option>Corodinator</option>-->
								<!--			<option>Employer</option>-->
								<!--			<option>Financial Career</option>-->
								<!--			<option>Information Technology</option>-->
								<!--			<option>Marketing</option>-->
								<!--			<option>Quality check</option>-->
								<!--			<option>Real Estate</option>-->
								<!--			<option>Sales</option>-->
								<!--			<option>Supporting</option>-->
								<!--			<option>Teaching</option> -->
								<!--		</select>-->
								<!--	</div>-->
								<!--</div>-->
								@if (Route::has('register'))

								   <div class="col-lg-4 col-md-6" style="margin-top: 20px; margin-right: 20px; margin-left: 20px;">
									<a href="{{ url('register_manpower/create') }}" class="site-button" style="color: white !important; height:60px; font-size:25px;">Manpower Registration</a>
    								</div>

    								<div class="col-lg-4 col-md-6" style="margin-top: 20px; margin-right: 20px; margin-left: 20px;">
    									<a href="{{ url('register_company/create') }}" class="site-button" style="color: white !important; height:60px; font-size:25px;">Company Registration</a>
    								</div>


								@endif
							</div>
						<!--</form>-->
					</div>
				</div>
            </div>
        </div>
		<!-- Section Banner END -->

		<!-- Call To Action -->
		<div class="section-full p-tb70 overlay-black-dark text-white text-center bg-img-fix" style="background-image:url({{asset('landingpage/')}}/images/main-slider/slide2.jpeg);">
			<div class="container">
				<div class="section-head text-center text-white">
					<h2 class="m-b5">SOGID</h2>
					<h5 class="fw4">Our Purpose</h5>
				</div>
				<div class="blog-carousel-center owl-carousel owl-none">
					<div class="item">
						<div class="testimonial-5">
							<div class="testimonial-text">
								<p>
								    1.	To ensure local participation in the industry<br><br>
								</p>
							</div>
							<!--<div class="testimonial-detail clearfix">-->
							<!--	<div class="testimonial-pic radius shadow">-->
							<!--		<img src="images/testimonials/pic1.jpg" width="100" height="100" alt="">-->
							<!--	</div>-->
							<!--	<strong class="testimonial-name">David Matin</strong> -->
							<!--	<span class="testimonial-position">Student</span> -->
							<!--</div>-->
						</div>
					</div>
					<div class="item">
						<div class="testimonial-5">
							<div class="testimonial-text">
								<p>
								    2.	To protect State Government interests<br><br>
								</p>
							</div>
							<!--<div class="testimonial-detail clearfix">-->
							<!--	<div class="testimonial-pic radius shadow">-->
							<!--		<img src="images/testimonials/pic2.jpg" width="100" height="100" alt="">-->
							<!--	</div>-->
							<!--	<strong class="testimonial-name">David Matin</strong> -->
							<!--	<span class="testimonial-position">Student</span> -->
							<!--</div>-->
						</div>
					</div>
					<div class="item">
						<div class="testimonial-5">
							<div class="testimonial-text">
								<p>3.	Directory/Database for Sabah O&G Downstream, Upstream, and Midstream</p>
							</div>
							<!--<div class="testimonial-detail clearfix">-->
							<!--	<div class="testimonial-pic radius shadow">-->
							<!--		<img src="images/testimonials/pic3.jpg" width="100" height="100" alt="">-->
							<!--	</div>-->
							<!--	<strong class="testimonial-name">David Matin</strong> -->
							<!--	<span class="testimonial-position">Student</span> -->
							<!--</div>-->
						</div>
					</div>
					<div class="item">
						<div class="testimonial-5">
							<div class="testimonial-text">
								<p>4.	To Protect the local OGSE Companies<br><br></p>
							</div>
							<!--<div class="testimonial-detail clearfix">-->
							<!--	<div class="testimonial-pic radius shadow">-->
							<!--		<img src="images/testimonials/pic3.jpg" width="100" height="100" alt="">-->
							<!--	</div>-->
							<!--	<strong class="testimonial-name">David Matin</strong> -->
							<!--	<span class="testimonial-position">Student</span> -->
							<!--</div>-->
						</div>
					</div>
					<div class="item">
						<div class="testimonial-5">
							<div class="testimonial-text">
								<p>5.	To advice on OGSE competency, building competitiveness & local participation</p>
							</div>
							<!--<div class="testimonial-detail clearfix">-->
							<!--	<div class="testimonial-pic radius shadow">-->
							<!--		<img src="images/testimonials/pic3.jpg" width="100" height="100" alt="">-->
							<!--	</div>-->
							<!--	<strong class="testimonial-name">David Matin</strong> -->
							<!--	<span class="testimonial-position">Student</span> -->
							<!--</div>-->
						</div>
					</div>
					<div class="item">
						<div class="testimonial-5">
							<div class="testimonial-text">
								<p>6.	To advance the local OGSE industry<br><br></p>
							</div>
							<!--<div class="testimonial-detail clearfix">-->
							<!--	<div class="testimonial-pic radius shadow">-->
							<!--		<img src="images/testimonials/pic3.jpg" width="100" height="100" alt="">-->
							<!--	</div>-->
							<!--	<strong class="testimonial-name">David Matin</strong> -->
							<!--	<span class="testimonial-position">Student</span> -->
							<!--</div>-->
						</div>
					</div>
				</div>

			</div>
		</div>
		<!-- Call To Action END -->

@endsection
