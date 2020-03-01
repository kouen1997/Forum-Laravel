@extends('layouts.master')

@section('title', 'HomeBook')

@section('header_scripts')
<style>
	.parallax-search .form-group .nice-select:hover {
		color: #656565;
	}
	.parallax-search .form-group .nice-select i {
		color: #656565;
	}
	.parallax-search .form-group .list li:hover {
		background: #656565;
	}
	.parallax-search .form-group .btn {
		background: #0098ef;
	}
</style>
@stop

@section('content')
<!-- STAR HEADER SEARCH -->
<section id="hero-area" class="parallax-search overlay main-search-inner search-2" data-stellar-background-ratio="0.5">
		<div class="hero-main">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="hero-inner">
							<!-- Welcome Text -->
							<div class="welcome-text">
								<h1>Gateway To Your Dream Home</h1>
							</div>
							<!--/ End Welcome Text -->
							<!-- Search Form -->
							<div class="trip-search">
								<form class="form">
									<!-- Form Lookin for -->
									<div class="form-group looking">
										<div class="first-select wide">
											<div class="main-search-input-item">
												<input type="text" placeholder="What are you looking for?" value="">
											</div>
										</div>
									</div>
									<!--/ End Form Lookin for -->
									<!-- Form Location -->
									<div class="form-group location">
										<div class="nice-select form-control wide" tabindex="0"><span class="current"><i class="fa fa-map-marker"></i>Location</span>
											<ul class="list">
												<li data-value="1" class="option selected ">New York</li>
												<li data-value="2" class="option">Los Angeles</li>
												<li data-value="3" class="option">Chicago</li>
												<li data-value="3" class="option">Philadelphia</li>
												<li data-value="3" class="option">San Francisco</li>
												<li data-value="3" class="option">Miami</li>
												<li data-value="3" class="option">Houston</li>
											</ul>
										</div>
									</div>
									<!--/ End Form Location -->
									<!-- Form Categories -->
									<div class="form-group categories">
										<div class="nice-select form-control wide" tabindex="0"><span class="current"><i class="fa fa-list" aria-hidden="true"></i>Property Status</span>
											<ul class="list">
												<li data-value="1" class="option selected ">For Sale</li>
												<li data-value="2" class="option">For Rent</li>
												<li data-value="3" class="option">Sold</li>
												<li data-value="3" class="option">Featured Properties</li>
											</ul>
										</div>
									</div>
									<!--/ End Form Categories -->
									<!-- Form Button -->
									<div class="form-group button">
										<button type="submit" class="btn">Search</button>
									</div>
									<!--/ End Form Button -->
								</form>
							</div>
							<!--/ End Search Form -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- END HEADER SEARCH -->

	<!-- START SECTION RECENTLY PROPERTIES -->
	<section class="recently portfolio">
		<div class="container-fluid">
			<div class="section-title">
				<h3>Recently</h3>
				<h2>Properties</h2>
			</div>
			<div class="row portfolio-items">
				<div class="item col-lg-3 col-md-6 col-xs-12 landscapes">
					<div class="project-single">
						<div class="project-inner project-head">
							<div class="project-bottom">
								<h4><a href="properties-details.html">View Property</a><span class="category">Real Estate</span></h4>
							</div>
							<div class="button-effect">
								<a href="properties-details.html" class="btn"><i class="fa fa-link"></i></a>
								<a href="https://www.youtube.com/watch?v=2xHQqYRcrx4" class="btn popup-video popup-youtube"><i class="fas fa-video"></i></a>
								<a class="img-poppu btn" href="{{ URL::asset('assets/images/feature-properties/fp-1.jpg') }}" data-rel="lightcase:myCollection:slideshow"><i class="fa fa-photo"></i></a>
							</div>
							<div class="homes">
								<!-- homes img -->
								<a href="properties-details.html" class="homes-img">
									<div class="homes-tag button alt featured">Featured</div>
									<div class="homes-tag button alt sale">For Sale</div>
									<div class="homes-price">Family Home</div>
									<img src="{{ URL::asset('assets/images/feature-properties/fp-1.jpg') }}" alt="home-1" class="img-responsive">
								</a>
							</div>
						</div>
						<!-- homes content -->
						<div class="homes-content">
							<!-- homes address -->
							<h3>Real House Luxury Villa</h3>
							<p class="homes-address mb-3">
								<a href="properties-details.html">
									<i class="fa fa-map-marker"></i><span>Est St, 77 - Central Park South, NYC</span>
								</a>
							</p>
							<!-- homes List -->
							<ul class="homes-list clearfix">
								<li>
									<i class="fa fa-bed" aria-hidden="true"></i>
									<span>6 Bedrooms</span>
								</li>
								<li>
									<i class="fa fa-bath" aria-hidden="true"></i>
									<span>3 Bathrooms</span>
								</li>
								<li>
									<i class="fa fa-object-group" aria-hidden="true"></i>
									<span>720 sq ft</span>
								</li>
								<li>
									<i class="fas fa-warehouse" aria-hidden="true"></i>
									<span>2 Garages</span>
								</li>
							</ul>
							<!-- Price -->
							<div class="price-properties">
								<h3 class="title mt-3">
                                <a href="properties-details.html">$ 230,000</a>
                                </h3>
								<div class="compare">
									<a href="#" title="Compare">
										<i class="fas fa-exchange-alt"></i>
									</a>
									<a href="#" title="Share">
										<i class="fas fa-share-alt"></i>
									</a>
									<a href="#" title="Favorites">
										<i class="fa fa-heart-o"></i>
									</a>
								</div>
							</div>
							<div class="footer">
								<a href="agent-details.html">
									<i class="fa fa-user"></i> Jhon Doe
								</a>
								<span>
                                <i class="fa fa-calendar"></i> 2 months ago
                            </span>
							</div>
						</div>
					</div>
				</div>
				<div class="item col-lg-3 col-md-6 col-xs-12 people">
					<div class="project-single">
						<div class="project-inner project-head">
							<div class="project-bottom">
								<h4><a href="properties-details.html">View Property</a><span class="category">Real Estate</span></h4>
							</div>
							<div class="button-effect">
								<a href="properties-details.html" class="btn"><i class="fa fa-link"></i></a>
								<a href="https://www.youtube.com/watch?v=2xHQqYRcrx4" class="btn popup-video popup-youtube"><i class="fas fa-video"></i></a>
								<a class="img-poppu btn" href="{{ URL::asset('assets/images/feature-properties/fp-2.jpg') }}" data-rel="lightcase:myCollection:slideshow"><i class="fa fa-photo"></i></a>
							</div>
							<div class="homes">
								<!-- homes img -->
								<a href="properties-details.html" class="homes-img">
									<div class="homes-tag button alt featured">Featured</div>
									<div class="homes-tag button sale rent">For Rent</div>
									<div class="homes-price">Family Home</div>
									<img src="{{ URL::asset('assets/images/feature-properties/fp-2.jpg') }}" alt="home-1" class="img-responsive">
								</a>
							</div>
						</div>
						<!-- homes content -->
						<div class="homes-content">
							<!-- homes address -->
							<h3>Real House Luxury Villa</h3>
							<p class="homes-address mb-3">
								<a href="properties-details.html">
									<i class="fa fa-map-marker"></i><span>Est St, 77 - Central Park South, NYC</span>
								</a>
							</p>
							<!-- homes List -->
							<ul class="homes-list clearfix">
								<li>
									<i class="fa fa-bed" aria-hidden="true"></i>
									<span>6 Bedrooms</span>
								</li>
								<li>
									<i class="fa fa-bath" aria-hidden="true"></i>
									<span>3 Bathrooms</span>
								</li>
								<li>
									<i class="fa fa-object-group" aria-hidden="true"></i>
									<span>720 sq ft</span>
								</li>
								<li>
									<i class="fas fa-warehouse" aria-hidden="true"></i>
									<span>2 Garages</span>
								</li>
							</ul>
							<!-- Price -->
							<div class="price-properties">
								<h3 class="title mt-3">
                                <a href="properties-details.html">$ 230,000</a>
                                </h3>
								<div class="compare">
									<a href="#" title="Compare">
										<i class="fas fa-exchange-alt"></i>
									</a>
									<a href="#" title="Share">
										<i class="fas fa-share-alt"></i>
									</a>
									<a href="#" title="Favorites">
										<i class="fa fa-heart-o"></i>
									</a>
								</div>
							</div>
							<div class="footer">
								<a href="agent-details.html">
									<i class="fa fa-user"></i> Jhon Doe
								</a>
								<span>
                                <i class="fa fa-calendar"></i> 2 months ago
                            </span>
							</div>
						</div>
					</div>
				</div>
				<div class="item col-lg-3 col-md-6 col-xs-12 people landscapes no-pb pbp-3">
					<div class="project-single no-mb mbp-3">
						<div class="project-inner project-head">
							<div class="project-bottom">
								<h4><a href="properties-details.html">View Property</a><span class="category">Real Estate</span></h4>
							</div>
							<div class="button-effect">
								<a href="properties-details.html" class="btn"><i class="fa fa-link"></i></a>
								<a href="https://www.youtube.com/watch?v=2xHQqYRcrx4" class="btn popup-video popup-youtube"><i class="fas fa-video"></i></a>
								<a class="img-poppu btn" href="{{ URL::asset('assets/images/feature-properties/fp-3.jpg') }}" data-rel="lightcase:myCollection:slideshow"><i class="fa fa-photo"></i></a>
							</div>
							<div class="homes">
								<!-- homes img -->
								<a href="properties-details.html" class="homes-img">
									<div class="homes-tag button alt featured">Featured</div>
									<div class="homes-tag button alt sale">For Sale</div>
									<div class="homes-price">Family Home</div>
									<img src="{{ URL::asset('assets/images/feature-properties/fp-3.jpg') }}" alt="home-1" class="img-responsive">
								</a>
							</div>
						</div>
						<!-- homes content -->
						<div class="homes-content">
							<!-- homes address -->
							<h3>Real House Luxury Villa</h3>
							<p class="homes-address mb-3">
								<a href="properties-details.html">
									<i class="fa fa-map-marker"></i><span>Est St, 77 - Central Park South, NYC</span>
								</a>
							</p>
							<!-- homes List -->
							<ul class="homes-list clearfix">
								<li>
									<i class="fa fa-bed" aria-hidden="true"></i>
									<span>6 Bedrooms</span>
								</li>
								<li>
									<i class="fa fa-bath" aria-hidden="true"></i>
									<span>3 Bathrooms</span>
								</li>
								<li>
									<i class="fa fa-object-group" aria-hidden="true"></i>
									<span>720 sq ft</span>
								</li>
								<li>
									<i class="fas fa-warehouse" aria-hidden="true"></i>
									<span>2 Garages</span>
								</li>
							</ul>
							<!-- Price -->
							<div class="price-properties">
								<h3 class="title mt-3">
                                <a href="properties-details.html">$ 230,000</a>
                                </h3>
								<div class="compare">
									<a href="#" title="Compare">
										<i class="fas fa-exchange-alt"></i>
									</a>
									<a href="#" title="Share">
										<i class="fas fa-share-alt"></i>
									</a>
									<a href="#" title="Favorites">
										<i class="fa fa-heart-o"></i>
									</a>
								</div>
							</div>
							<div class="footer">
								<a href="agent-details.html">
									<i class="fa fa-user"></i> Jhon Doe
								</a>
								<span>
                                <i class="fa fa-calendar"></i> 2 months ago
                            </span>
							</div>
						</div>
					</div>
				</div>
				<div class="item col-lg-3 col-md-6 col-xs-12 people landscapes no-pb">
					<div class="project-single no-mb">
						<div class="project-inner project-head">
							<div class="project-bottom">
								<h4><a href="properties-details.html">View Property</a><span class="category">Real Estate</span></h4>
							</div>
							<div class="button-effect">
								<a href="properties-details.html" class="btn"><i class="fa fa-link"></i></a>
								<a href="https://www.youtube.com/watch?v=2xHQqYRcrx4" class="btn popup-video popup-youtube"><i class="fas fa-video"></i></a>
								<a class="img-poppu btn" href="{{ URL::asset('assets/images/feature-properties/fp-4.jpg') }}" data-rel="lightcase:myCollection:slideshow"><i class="fa fa-photo"></i></a>
							</div>
							<div class="homes">
								<!-- homes img -->
								<a href="properties-details.html" class="homes-img">
									<div class="homes-tag button alt featured">Featured</div>
									<div class="homes-tag button sale rent">For Rent</div>
									<div class="homes-price">Family Home</div>
									<img src="{{ URL::asset('assets/images/feature-properties/fp-4.jpg') }}" alt="home-1" class="img-responsive">
								</a>
							</div>
						</div>
						<!-- homes content -->
						<div class="homes-content">
							<!-- homes address -->
							<h3>Real House Luxury Villa</h3>
							<p class="homes-address mb-3">
								<a href="properties-details.html">
									<i class="fa fa-map-marker"></i><span>Est St, 77 - Central Park South, NYC</span>
								</a>
							</p>
							<!-- homes List -->
							<ul class="homes-list clearfix">
								<li>
									<i class="fa fa-bed" aria-hidden="true"></i>
									<span>6 Bedrooms</span>
								</li>
								<li>
									<i class="fa fa-bath" aria-hidden="true"></i>
									<span>3 Bathrooms</span>
								</li>
								<li>
									<i class="fa fa-object-group" aria-hidden="true"></i>
									<span>720 sq ft</span>
								</li>
								<li>
									<i class="fas fa-warehouse" aria-hidden="true"></i>
									<span>2 Garages</span>
								</li>
							</ul>
							<!-- Price -->
							<div class="price-properties">
								<h3 class="title mt-3">
                                <a href="properties-details.html">$ 230,000</a>
                                </h3>
								<div class="compare">
									<a href="#" title="Compare">
										<i class="fas fa-exchange-alt"></i>
									</a>
									<a href="#" title="Share">
										<i class="fas fa-share-alt"></i>
									</a>
									<a href="#" title="Favorites">
										<i class="fa fa-heart-o"></i>
									</a>
								</div>
							</div>
							<div class="footer">
								<a href="agent-details.html">
									<i class="fa fa-user"></i> Jhon Doe
								</a>
								<span>
                                <i class="fa fa-calendar"></i> 2 months ago
                            </span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- END SECTION RECENTLY PROPERTIES -->

	<!-- STAR SECTION WELCOME -->
	<section class="welcome">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-12 col-xs-12">
					<div class="welcome-title">
						<h2>WELCOME TO <span>HOMEBOOK.PH</span></h2>
						<h4>GATEWAY TO YOUR DREAM HOME</h4>
					</div>
					<div class="welcome-services">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-xs-12 ">
								<div class="w-single-services">
									<div class="services-img img-1">
										<img src="{{ URL::asset('assets/images/1.png') }}" width="32" alt="">
									</div>
									<div class="services-desc">
										<h6>Buy Property</h6>
										<p>We have the best properties
											<br> elit, sed do eiusmod tempe</p>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-xs-12 ">
								<div class="w-single-services">
									<div class="services-img img-2">
										<img src="{{ URL::asset('assets/images/2.png') }}" width="32" alt="">
									</div>
									<div class="services-desc">
										<h6>Rent Property</h6>
										<p>We have the best properties
											<br> elit, sed do eiusmod tempe</p>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-xs-12 ">
								<div class="w-single-services no-mb mbx">
									<div class="services-img img-3">
										<img src="{{ URL::asset('assets/images/3.png') }}" width="32" alt="">
									</div>
									<div class="services-desc">
										<h6>Real Estate Kit</h6>
										<p>We have the best properties
											<br> elit, sed do eiusmod tempe</p>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-xs-12 ">
								<div class="w-single-services no-mb">
									<div class="services-img img-4">
										<img src="{{ URL::asset('assets/images/4.png') }}" width="32" alt="">
									</div>
									<div class="services-desc">
										<h6>Sell Property</h6>
										<p>We have the best properties
											<br> elit, sed do eiusmod tempe</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-12 col-xs-12">
					<div class="wprt-image-video w50">
						<img alt="image" src="{{ URL::asset('assets/images/blog/b-1.jpg') }}">
						<a class="icon-wrap popup-video popup-youtube" href="https://www.youtube.com/watch?v=2xHQqYRcrx4">
							<i class="fa fa-play"></i>
						</a>
						<div class="iq-waves">
							<div class="waves wave-1"></div>
							<div class="waves wave-2"></div>
							<div class="waves wave-3"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- END SECTION WELCOME -->

	<!-- START SECTION SERVICES -->
	<section class="services-home bg-white">
		<div class="container">
			<div class="section-title">
				<h3>Property</h3>
				<h2>Services</h2>
			</div>
			<div class="row">
				<div class="col-lg-3 col-md-12 m-top-0 m-bottom-40">
					<div class="service bg-light-2 border-1 border-light box-shadow-1 box-shadow-2-hover">
						<div class="media">
							<i class="fa fa-home bg-base text-white rounded-100 box-shadow-1 p-top-5 p-bottom-5 p-right-5 p-left-5"></i>
						</div>
						<div class="agent-section p-top-35 p-bottom-30 p-right-25 p-left-25">
							<h4 class="m-bottom-15 text-bold-700">House and Lots</h4>
							<p>Nonec pede justo fringilla vel aliquet nec vulputate eget arcu in enim justo rhoncus ut imperdiet venenatis vitae justo.</p>
							<a class="text-base text-base-dark-hover text-size-13" href="properties-full-list.html">Read More <i class="fa fa-long-arrow-right"></i></a>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-12 m-top-40 m-bottom-40">
					<div class="service bg-light-2 border-1 border-light box-shadow-1 box-shadow-2-hover">
						<div class="media">
							<i class="fas fa-building bg-base text-white rounded-100 box-shadow-1 p-top-5 p-bottom-5 p-right-5 p-left-5"></i>
						</div>
						<div class="agent-section p-top-35 p-bottom-30 p-right-25 p-left-25">
							<h4 class="m-bottom-15 text-bold-700">Apartments</h4>
							<p>Nonec pede justo fringilla vel aliquet nec vulputate eget arcu in enim justo rhoncus ut imperdiet venenatis vitae justo.</p>
							<a class="text-base text-base-dark-hover text-size-13" href="properties-full-list.html">Read More <i class="fa fa-long-arrow-right"></i></a>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-12 m-top-40 m-bottom-40 commercial">
					<div class="service bg-light-2 border-1 border-light box-shadow-1 box-shadow-2-hover">
						<div class="media">
							<i class="fas fa-warehouse bg-base text-white rounded-100 box-shadow-1 p-top-5 p-bottom-5 p-right-5 p-left-5"></i>
						</div>
						<div class="agent-section p-top-35 p-bottom-30 p-right-25 p-left-25">
							<h4 class="m-bottom-15 text-bold-700">Condominium</h4>
							<p>Nonec pede justo fringilla vel aliquet nec vulputate eget arcu in enim justo rhoncus ut imperdiet venenatis vitae justo.</p>
							<a class="text-base text-base-dark-hover text-size-13" href="properties-full-list.html">Read More <i class="fa fa-long-arrow-right"></i></a>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-12 m-top-40 m-bottom-40 commercial">
					<div class="service bg-light-2 border-1 border-light box-shadow-1 box-shadow-2-hover">
						<div class="media">
							<i class="fas fa-warehouse bg-base text-white rounded-100 box-shadow-1 p-top-5 p-bottom-5 p-right-5 p-left-5"></i>
						</div>
						<div class="agent-section p-top-35 p-bottom-30 p-right-25 p-left-25">
							<h4 class="m-bottom-15 text-bold-700">Commercial</h4>
							<p>Nonec pede justo fringilla vel aliquet nec vulputate eget arcu in enim justo rhoncus ut imperdiet venenatis vitae justo.</p>
							<a class="text-base text-base-dark-hover text-size-13" href="properties-full-list.html">Read More <i class="fa fa-long-arrow-right"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- END SECTION SERVICES -->

	<!-- START SECTION FEATURED PROPERTIES -->
	<section class="featured portfolio">
		<div class="container">
			<div class="row">
				<div class="section-title col-md-5">
					<h3>Featured</h3>
					<h2>Properties</h2>
				</div>
			</div>
			<div class="row portfolio-items">
				<div class="item col-lg-4 col-md-6 col-xs-12 landscapes sale">
					<div class="project-single">
						<div class="project-inner project-head">
							<div class="project-bottom">
								<h4><a href="properties-details.html">View Property</a><span class="category">Real Estate</span></h4>
							</div>
							<div class="button-effect">
								<a href="properties-details.html" class="btn"><i class="fa fa-link"></i></a>
								<a href="https://www.youtube.com/watch?v=2xHQqYRcrx4" class="btn popup-video popup-youtube"><i class="fas fa-video"></i></a>
								<a class="img-poppu btn" href="{{ URL::asset('assets/images/feature-properties/fp-1.jpg') }}" data-rel="lightcase:myCollection:slideshow"><i class="fa fa-photo"></i></a>
							</div>
							<div class="homes">
								<!-- homes img -->
								<a href="properties-details.html" class="homes-img">
									<div class="homes-tag button alt featured">Featured</div>
									<div class="homes-tag button alt sale">For Sale</div>
									<div class="homes-price">Family Home</div>
									<img src="{{ URL::asset('assets/images/feature-properties/fp-1.jpg') }}" alt="home-1" class="img-responsive">
								</a>
							</div>
						</div>
						<!-- homes content -->
						<div class="homes-content">
							<!-- homes address -->
							<h3>Real House Luxury Villa</h3>
							<p class="homes-address mb-3">
								<a href="properties-details.html">
									<i class="fa fa-map-marker"></i><span>Est St, 77 - Central Park South, NYC</span>
								</a>
							</p>
							<!-- homes List -->
							<ul class="homes-list clearfix">
								<li>
									<i class="fa fa-bed" aria-hidden="true"></i>
									<span>6 Bedrooms</span>
								</li>
								<li>
									<i class="fa fa-bath" aria-hidden="true"></i>
									<span>3 Bathrooms</span>
								</li>
								<li>
									<i class="fa fa-object-group" aria-hidden="true"></i>
									<span>720 sq ft</span>
								</li>
								<li>
									<i class="fas fa-warehouse" aria-hidden="true"></i>
									<span>2 Garages</span>
								</li>
							</ul>
							<!-- Price -->
							<div class="price-properties">
								<h3 class="title mt-3">
                                <a href="properties-details.html">$ 230,000</a>
                                </h3>
								<div class="compare">
									<a href="#" title="Compare">
										<i class="fas fa-exchange-alt"></i>
									</a>
									<a href="#" title="Share">
										<i class="fas fa-share-alt"></i>
									</a>
									<a href="#" title="Favorites">
										<i class="fa fa-heart-o"></i>
									</a>
								</div>
							</div>
							<div class="footer">
								<a href="agent-details.html">
									<i class="fa fa-user"></i> Jhon Doe
								</a>
								<span>
                                <i class="fa fa-calendar"></i> 2 months ago
                            </span>
							</div>
						</div>
					</div>
				</div>
				<div class="item col-lg-4 col-md-6 col-xs-12 people rent">
					<div class="project-single">
						<div class="project-inner project-head">
							<div class="project-bottom">
								<h4><a href="properties-details.html">View Property</a><span class="category">Real Estate</span></h4>
							</div>
							<div class="button-effect">
								<a href="properties-details.html" class="btn"><i class="fa fa-link"></i></a>
								<a href="https://www.youtube.com/watch?v=2xHQqYRcrx4" class="btn popup-video popup-youtube"><i class="fas fa-video"></i></a>
								<a class="img-poppu btn" href="{{ URL::asset('assets/images/feature-properties/fp-2.jpg') }}" data-rel="lightcase:myCollection:slideshow"><i class="fa fa-photo"></i></a>
							</div>
							<div class="homes">
								<!-- homes img -->
								<a href="properties-details.html" class="homes-img">
									<div class="homes-tag button alt featured">Featured</div>
									<div class="homes-tag button sale rent">For Rent</div>
									<div class="homes-price">Family Home</div>
									<img src="{{ URL::asset('assets/images/feature-properties/fp-2.jpg') }}" alt="home-1" class="img-responsive">
								</a>
							</div>
						</div>
						<!-- homes content -->
						<div class="homes-content">
							<!-- homes address -->
							<h3>Real House Luxury Villa</h3>
							<p class="homes-address mb-3">
								<a href="properties-details.html">
									<i class="fa fa-map-marker"></i><span>Est St, 77 - Central Park South, NYC</span>
								</a>
							</p>
							<!-- homes List -->
							<ul class="homes-list clearfix">
								<li>
									<i class="fa fa-bed" aria-hidden="true"></i>
									<span>6 Bedrooms</span>
								</li>
								<li>
									<i class="fa fa-bath" aria-hidden="true"></i>
									<span>3 Bathrooms</span>
								</li>
								<li>
									<i class="fa fa-object-group" aria-hidden="true"></i>
									<span>720 sq ft</span>
								</li>
								<li>
									<i class="fas fa-warehouse" aria-hidden="true"></i>
									<span>2 Garages</span>
								</li>
							</ul>
							<!-- Price -->
							<div class="price-properties">
								<h3 class="title mt-3">
                                <a href="properties-details.html">$ 230,000</a>
                                </h3>
								<div class="compare">
									<a href="#" title="Compare">
										<i class="fas fa-exchange-alt"></i>
									</a>
									<a href="#" title="Share">
										<i class="fas fa-share-alt"></i>
									</a>
									<a href="#" title="Favorites">
										<i class="fa fa-heart-o"></i>
									</a>
								</div>
							</div>
							<div class="footer">
								<a href="agent-details.html">
									<i class="fa fa-user"></i> Jhon Doe
								</a>
								<span>
                                <i class="fa fa-calendar"></i> 2 months ago
                            </span>
							</div>
						</div>
					</div>
				</div>
				<div class="item col-lg-4 col-md-6 col-xs-12 people landscapes sale">
					<div class="project-single">
						<div class="project-inner project-head">
							<div class="project-bottom">
								<h4><a href="properties-details.html">View Property</a><span class="category">Real Estate</span></h4>
							</div>
							<div class="button-effect">
								<a href="properties-details.html" class="btn"><i class="fa fa-link"></i></a>
								<a href="https://www.youtube.com/watch?v=2xHQqYRcrx4" class="btn popup-video popup-youtube"><i class="fas fa-video"></i></a>
								<a class="img-poppu btn" href="{{ URL::asset('assets/images/feature-properties/fp-3.jpg') }}" data-rel="lightcase:myCollection:slideshow"><i class="fa fa-photo"></i></a>
							</div>
							<div class="homes">
								<!-- homes img -->
								<a href="properties-details.html" class="homes-img">
									<div class="homes-tag button alt featured">Featured</div>
									<div class="homes-tag button alt sale">For Sale</div>
									<div class="homes-price">Family Home</div>
									<img src="{{ URL::asset('assets/images/feature-properties/fp-3.jpg') }}" alt="home-1" class="img-responsive">
								</a>
							</div>
						</div>
						<!-- homes content -->
						<div class="homes-content">
							<!-- homes address -->
							<h3>Real House Luxury Villa</h3>
							<p class="homes-address mb-3">
								<a href="properties-details.html">
									<i class="fa fa-map-marker"></i><span>Est St, 77 - Central Park South, NYC</span>
								</a>
							</p>
							<!-- homes List -->
							<ul class="homes-list clearfix">
								<li>
									<i class="fa fa-bed" aria-hidden="true"></i>
									<span>6 Bedrooms</span>
								</li>
								<li>
									<i class="fa fa-bath" aria-hidden="true"></i>
									<span>3 Bathrooms</span>
								</li>
								<li>
									<i class="fa fa-object-group" aria-hidden="true"></i>
									<span>720 sq ft</span>
								</li>
								<li>
									<i class="fas fa-warehouse" aria-hidden="true"></i>
									<span>2 Garages</span>
								</li>
							</ul>
							<!-- Price -->
							<div class="price-properties">
								<h3 class="title mt-3">
                                <a href="properties-details.html">$ 230,000</a>
                                </h3>
								<div class="compare">
									<a href="#" title="Compare">
										<i class="fas fa-exchange-alt"></i>
									</a>
									<a href="#" title="Share">
										<i class="fas fa-share-alt"></i>
									</a>
									<a href="#" title="Favorites">
										<i class="fa fa-heart-o"></i>
									</a>
								</div>
							</div>
							<div class="footer">
								<a href="agent-details.html">
									<i class="fa fa-user"></i> Jhon Doe
								</a>
								<span>
                                <i class="fa fa-calendar"></i> 2 months ago
                            </span>
							</div>
						</div>
					</div>
				</div>
				<div class="item col-lg-4 col-md-6 col-xs-12 people landscapes rent no-pb">
					<div class="project-single no-mb">
						<div class="project-inner project-head">
							<div class="project-bottom">
								<h4><a href="properties-details.html">View Property</a><span class="category">Real Estate</span></h4>
							</div>
							<div class="button-effect">
								<a href="properties-details.html" class="btn"><i class="fa fa-link"></i></a>
								<a href="https://www.youtube.com/watch?v=2xHQqYRcrx4" class="btn popup-video popup-youtube"><i class="fas fa-video"></i></a>
								<a class="img-poppu btn" href="{{ URL::asset('assets/images/feature-properties/fp-4.jpg') }}" data-rel="lightcase:myCollection:slideshow"><i class="fa fa-photo"></i></a>
							</div>
							<div class="homes">
								<!-- homes img -->
								<a href="properties-details.html" class="homes-img">
									<div class="homes-tag button alt featured">Featured</div>
									<div class="homes-tag button sale rent">For Rent</div>
									<div class="homes-price">Family Home</div>
									<img src="{{ URL::asset('assets/images/feature-properties/fp-4.jpg') }}" alt="home-1" class="img-responsive">
								</a>
							</div>
						</div>
						<!-- homes content -->
						<div class="homes-content">
							<!-- homes address -->
							<h3>Real House Luxury Villa</h3>
							<p class="homes-address mb-3">
								<a href="properties-details.html">
									<i class="fa fa-map-marker"></i><span>Est St, 77 - Central Park South, NYC</span>
								</a>
							</p>
							<!-- homes List -->
							<ul class="homes-list clearfix">
								<li>
									<i class="fa fa-bed" aria-hidden="true"></i>
									<span>6 Bedrooms</span>
								</li>
								<li>
									<i class="fa fa-bath" aria-hidden="true"></i>
									<span>3 Bathrooms</span>
								</li>
								<li>
									<i class="fa fa-object-group" aria-hidden="true"></i>
									<span>720 sq ft</span>
								</li>
								<li>
									<i class="fas fa-warehouse" aria-hidden="true"></i>
									<span>2 Garages</span>
								</li>
							</ul>
							<!-- Price -->
							<div class="price-properties">
								<h3 class="title mt-3">
                                <a href="properties-details.html">$ 230,000</a>
                                </h3>
								<div class="compare">
									<a href="#" title="Compare">
										<i class="fas fa-exchange-alt"></i>
									</a>
									<a href="#" title="Share">
										<i class="fas fa-share-alt"></i>
									</a>
									<a href="#" title="Favorites">
										<i class="fa fa-heart-o"></i>
									</a>
								</div>
							</div>
							<div class="footer">
								<a href="agent-details.html">
									<i class="fa fa-user"></i> Jhon Doe
								</a>
								<span>
                                <i class="fa fa-calendar"></i> 2 months ago
                            </span>
							</div>
						</div>
					</div>
				</div>
				<div class="item col-lg-4 col-md-6 col-xs-12 people sale no-pb">
					<div class="project-single no-mb">
						<div class="project-inner project-head">
							<div class="project-bottom">
								<h4><a href="properties-details.html">View Property</a><span class="category">Real Estate</span></h4>
							</div>
							<div class="button-effect">
								<a href="properties-details.html" class="btn"><i class="fa fa-link"></i></a>
								<a href="https://www.youtube.com/watch?v=2xHQqYRcrx4" class="btn popup-video popup-youtube"><i class="fas fa-video"></i></a>
								<a class="img-poppu btn" href="{{ URL::asset('assets/images/feature-properties/fp-5.jpg') }}" data-rel="lightcase:myCollection:slideshow"><i class="fa fa-photo"></i></a>
							</div>
							<div class="homes">
								<!-- homes img -->
								<a href="properties-details.html" class="homes-img">
									<div class="homes-tag button alt featured">Featured</div>
									<div class="homes-tag button alt sale">For Sale</div>
									<div class="homes-price">Family Home</div>
									<img src="{{ URL::asset('assets/images/feature-properties/fp-5.jpg') }}" alt="home-1" class="img-responsive">
								</a>
							</div>
						</div>
						<!-- homes content -->
						<div class="homes-content">
							<!-- homes address -->
							<h3>Real House Luxury Villa</h3>
							<p class="homes-address mb-3">
								<a href="properties-details.html">
									<i class="fa fa-map-marker"></i><span>Est St, 77 - Central Park South, NYC</span>
								</a>
							</p>
							<!-- homes List -->
							<ul class="homes-list clearfix">
								<li>
									<i class="fa fa-bed" aria-hidden="true"></i>
									<span>6 Bedrooms</span>
								</li>
								<li>
									<i class="fa fa-bath" aria-hidden="true"></i>
									<span>3 Bathrooms</span>
								</li>
								<li>
									<i class="fa fa-object-group" aria-hidden="true"></i>
									<span>720 sq ft</span>
								</li>
								<li>
									<i class="fas fa-warehouse" aria-hidden="true"></i>
									<span>2 Garages</span>
								</li>
							</ul>
							<!-- Price -->
							<div class="price-properties">
								<h3 class="title mt-3">
                                <a href="properties-details.html">$ 230,000</a>
                                </h3>
								<div class="compare">
									<a href="#" title="Compare">
										<i class="fas fa-exchange-alt"></i>
									</a>
									<a href="#" title="Share">
										<i class="fas fa-share-alt"></i>
									</a>
									<a href="#" title="Favorites">
										<i class="fa fa-heart-o"></i>
									</a>
								</div>
							</div>
							<div class="footer">
								<a href="agent-details.html">
									<i class="fa fa-user"></i> Jhon Doe
								</a>
								<span>
                                <i class="fa fa-calendar"></i> 2 months ago
                            </span>
							</div>
						</div>
					</div>
				</div>
				<div class="item col-lg-4 col-md-6 it2 col-xs-12 web rent no-pb">
					<div class="project-single no-mb last">
						<div class="project-inner project-head">
							<div class="project-bottom">
								<h4><a href="properties-details.html">View Property</a><span class="category">Real Estate</span></h4>
							</div>
							<div class="button-effect">
								<a href="properties-details.html" class="btn"><i class="fa fa-link"></i></a>
								<a href="https://www.youtube.com/watch?v=2xHQqYRcrx4" class="btn popup-video popup-youtube"><i class="fas fa-video"></i></a>
								<a class="img-poppu btn" href="{{ URL::asset('assets/images/feature-properties/fp-6.jpg') }}" data-rel="lightcase:myCollection:slideshow"><i class="fa fa-photo"></i></a>
							</div>
							<div class="homes">
								<!-- homes img -->
								<a href="properties-details.html" class="homes-img">
									<div class="homes-tag button alt featured">Featured</div>
									<div class="homes-tag button sale rent">For Rent</div>
									<div class="homes-price">Family Home</div>
									<img src="{{ URL::asset('assets/images/feature-properties/fp-6.jpg') }}" alt="home-1" class="img-responsive">
								</a>
							</div>
						</div>
						<!-- homes content -->
						<div class="homes-content">
							<!-- homes address -->
							<h3>Real House Luxury Villa</h3>
							<p class="homes-address mb-3">
								<a href="properties-details.html">
									<i class="fa fa-map-marker"></i><span>Est St, 77 - Central Park South, NYC</span>
								</a>
							</p>
							<!-- homes List -->
							<ul class="homes-list clearfix">
								<li>
									<i class="fa fa-bed" aria-hidden="true"></i>
									<span>6 Bedrooms</span>
								</li>
								<li>
									<i class="fa fa-bath" aria-hidden="true"></i>
									<span>3 Bathrooms</span>
								</li>
								<li>
									<i class="fa fa-object-group" aria-hidden="true"></i>
									<span>720 sq ft</span>
								</li>
								<li>
									<i class="fas fa-warehouse" aria-hidden="true"></i>
									<span>2 Garages</span>
								</li>
							</ul>
							<!-- Price -->
							<div class="price-properties">
								<h3 class="title mt-3">
                                <a href="properties-details.html">$ 230,000</a>
                                </h3>
								<div class="compare">
									<a href="#" title="Compare">
										<i class="fas fa-exchange-alt"></i>
									</a>
									<a href="#" title="Share">
										<i class="fas fa-share-alt"></i>
									</a>
									<a href="#" title="Favorites">
										<i class="fa fa-heart-o"></i>
									</a>
								</div>
							</div>
							<div class="footer">
								<a href="agent-details.html">
									<i class="fa fa-user"></i> Jhon Doe
								</a>
								<span>
                                <i class="fa fa-calendar"></i> 2 months ago
                            </span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- END SECTION FEATURED PROPERTIES -->

	<!-- START SECTION POPULAR PLACES -->
	<section class="popular-places">
		<div class="container">
			<div class="section-title">
				<h3>Most Popular</h3>
				<h2>Places</h2>
			</div>
			<div class="row">
				<div class="col-md-12">
				</div>
				<div class="col-lg-4 col-md-6">
					<!-- Image Box -->
					<a href="properties-right-sidebar.html" class="img-box hover-effect">
						<img src="{{ URL::asset('assets/images/popular-places/1.jpg') }}" class="img-responsive" alt="">
						<!-- Badge -->
						<div class="listing-badges">
							<span class="featured">Featured</span>
						</div>
						<div class="img-box-content visible">
							<h4>New York City </h4>
							<span>203 Properties</span>
						</div>
					</a>
				</div>
				<div class="col-lg-8 col-md-6">
					<!-- Image Box -->
					<a href="properties-right-sidebar.html" class="img-box hover-effect">
						<img src="{{ URL::asset('assets/images/popular-places/2.jpg') }}" class="img-responsive" alt="">
						<div class="img-box-content visible">
							<h4>Los Angeles</h4>
							<span>307 Properties</span>
						</div>
					</a>
				</div>
				<div class="col-lg-8 col-md-6">
					<!-- Image Box -->
					<a href="properties-right-sidebar.html" class="img-box hover-effect no-mb">
						<img src="{{ URL::asset('assets/images/popular-places/3.jpg') }}" class="img-responsive" alt="">
						<div class="img-box-content visible">
							<h4>San Francisco </h4>
							<span>409 Properties</span>
						</div>
					</a>
				</div>
				<div class="col-lg-4 col-md-6">
					<!-- Image Box -->
					<a href="properties-right-sidebar.html" class="img-box hover-effect no-mb x3">
						<img src="{{ URL::asset('assets/images/popular-places/4.jpg') }}" class="img-responsive" alt="">
						<!-- Badge -->
						<div class="listing-badges">
							<span class="featured">Featured</span>
						</div>
						<div class="img-box-content visible">
							<h4>Miami</h4>
							<span>507 Properties</span>
						</div>
					</a>
				</div>
			</div>
		</div>
	</section>
	<!-- END SECTION POPULAR PLACES -->

	<!-- STAR SECTION PARTNERS -->
	<div class="partners">
		<div class="container">
			<div class="section-title">
				<h3>Accredited</h3>
				<h2>Developers</h2>
			</div>
			<div class="owl-carousel style2">
				<div class="owl-item"><img src="{{ URL::asset('assets/images/partners/1.png') }}" alt=""></div>
				<div class="owl-item"><img src="{{ URL::asset('assets/images/partners/2.png') }}" alt=""></div>
				<div class="owl-item"><img src="{{ URL::asset('assets/images/partners/3.png') }}" alt=""></div>
				<div class="owl-item"><img src="{{ URL::asset('assets/images/partners/4.png') }}" alt=""></div>
				<div class="owl-item"><img src="{{ URL::asset('assets/images/partners/5.png') }}" alt=""></div>
				<div class="owl-item"><img src="{{ URL::asset('assets/images/partners/6.png') }}" alt=""></div>
				<div class="owl-item"><img src="{{ URL::asset('assets/images/partners/7.png') }}" alt=""></div>
				<div class="owl-item"><img src="{{ URL::asset('assets/images/partners/8.png') }}" alt=""></div>
				<div class="owl-item"><img src="{{ URL::asset('assets/images/partners/9.png') }}" alt=""></div>
				<div class="owl-item"><img src="{{ URL::asset('assets/images/partners/10.png') }}" alt=""></div>
			</div>
		</div>
	</div>
	<!-- END SECTION PARTNERS -->

	<!-- START SECTION COUNTER UP -->
	<section class="counterup">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-6 col-xs-12">
					<div class="countr">
						<i class="fa fa-home" aria-hidden="true"></i>
						<div class="count-me">
							<p class="counter text-left">300</p>
							<h3>Sold Properties</h3>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-xs-12">
					<div class="countr">
						<i class="fa fa-list" aria-hidden="true"></i>
						<div class="count-me">
							<p class="counter text-left">400</p>
							<h3>Listings</h3>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-xs-12">
					<div class="countr mb-0">
						<i class="fa fa-users" aria-hidden="true"></i>
						<div class="count-me">
							<p class="counter text-left">250</p>
							<h3>HomeBook Associates</h3>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- END SECTION COUNTER UP -->
@endsection