<div id="content" class="item-single">
	<div class="container">
		<div class="row justify-content-md-center">
			<div class="col col-md-12 col-lg-12 col-xl-10">
				<div class="row row justify-content-md-center has-sidebar">
					<div class="col-md-7 col-lg-8">
						<div>
							<div class="item-gallery">
								<div class="swiper-container gallery-top" data-pswp-uid="1">
									<div class="swiper-wrapper lazyload">
										@foreach($property->photos as $photo)
										<div class="swiper-slide">
											<figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
												<a href="{{ $photo->filename }}" itemprop="contentUrl" data-size="2000x1414"> 
												@if($loop->first)
													<img src="{{ $photo->filename }}" class="img-fluid swiper-lazy" alt="{{ $property->title }}"> 
												@else
													<img data-src="{{ $photo->filename }}" src="{{ URL::asset('assets/frontend/img/spacer.png') }}" class="img-fluid swiper-lazy" alt="{{ $property->title }}"> 
												@endif
												</a>
											</figure>
										</div>
										@endforeach
									</div>
									<div class="swiper-button-next"></div>
									<div class="swiper-button-prev"></div>
								</div>
								<div class="swiper-container gallery-thumbs">
									<div class="swiper-wrapper">
										@foreach($property->photos as $photo)
										<div class="swiper-slide">
											<img src="{{ $photo->filename }}" class="img-fluid" alt="{{ $property->title }}">
										</div>
										@endforeach
									</div>
								</div>
							</div>
							<div>
								<ul class="item-features">
									<li><span>{{ $property->floor_area }} sq m</span> sq m </li>
									<li><span>{{ $property->bedrooms }}</span> Bedrooms </li>
									<li><span>{{ $property->baths }}</span> Bathrooms </li>
								</ul>
								<div class="item-description">
									<h3 class="headline">Property description</h3>
									<p>{!! $property->description !!}</p>
								</div>
								<!--h3 class="headline">Property Features</h3-->
								<!--ul class="checked_list feature-list">
									<li>Alarm</li>
									<li>Gym</li>
									<li>Internet</li>
									<li>Swimming Pool</li>
									<li>Window Covering</li>
								</ul-->
								@if($property->map != NULL)
								<div class="item-navigation">
									<ul class="nav nav-tabs v2" role="tablist">
										<li role="presentation">
											<a href="#map" aria-controls="map" role="tab" data-toggle="tab" class="active"><i class="fa fa-map"></i> 
												<span class="hidden-xs">Map &amp; Nearby</span>
											</a>
										</li>
									</ul>
									<div class="tab-content">
										<div role="tabpanel" class="tab-pane active" id="map">
											{!! $property->map !!}
										</div>
									</div>
								</div>
								@endif
							</div>
						</div>
					</div>
					<div class="col-md-5 col-lg-4">
						<div id="sidebar" class="sidebar-right">
							<div class="sidebar_inner">
								<div class="card shadow">
									<h5 class="subheadline mt-0  mb-0">For {{ $property->offer_type == 'Sell' ? 'Sale' : 'Rent' }}</h5>
									<div class="media">
										<div class="media-body">
											<h4 class="media-heading"><a href="#"> {{ $property->name }}</a></h4>
											<p>
												<a href="tel:{{ $property->mobile }}">
													<i class="fa fa-phone" aria-hidden="true"></i> Call: {{ $property->mobile }}
												</a>
											</p>
											<p>
												<a href="mailto:{{ $property->email }}">
													<i class="fa fa-inbox" aria-hidden="true"></i> Email: {{ $property->email }}
												</a>
											</p>
										</div>
									</div>
									<a href="#" class="btn btn-lg btn-primary btn-block" data-toggle="modal" data-target="#leadform">Request Details</a> 
								</div>
								<div id="feature-list" role="tablist">
									<div class="card">
										<div class="card-header" role="tab" id="headingOne">
											<h4 class="panel-title"> <a role="button" data-toggle="collapse" href="#specification" aria-expanded="true" aria-controls="specification"> Specifications <i class="fa fa-caret-down float-right"></i> </a> </h4>
										</div>
										<div id="specification" class="panel-collapse collapse show" role="tabpanel">
											<div class="card-body">
												<table class="table v1">
													<tr>
														<td>Bedrooms</td>
														<td>{{ $property->bedrooms }}</td>
													</tr>
													<tr>
														<td>Bathrooms</td>
														<td>{{ $property->baths }}</td>
													</tr>
													<tr>
														<td>Total Area</td>
														<td>{{ $property->floor_area }} sq m</td>
													</tr>
													<tr>
														<td>Floor</td>
														<td>{{ ($property->floor_number == 1 ? 'Ground Floor' : $property->floor_number)  }}</td>
													</tr>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade item-badge-rightm" id="leadform" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <div class="media">
			<div class="media-left"><img src="{{ $property->photos->first()['filename'] }}" width="60" class="img-rounded mt5" alt=""></div>
			<div class="media-body">
			  <h4 class="media-heading">Request details for {{ $property->title }}</h4>
			  {{ $property->address }} </div>
		  </div>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>
		<div class="modal-body">
		  <form action="{{ url('property/'.$property->id.'/inquire') }}" autocomplete="off" method="POST">
			{!! csrf_field() !!}
			<div class="form-group">
				<label>Your Name*</label>
				<input type="text" name="name" class="form-control" placeholder="Your Name*" required="">
			</div>
			<div class="form-group">
				<label>Your Email*</label>
				<input type="email" name="email" class="form-control" placeholder="Your Email*" required="">
			</div>
			<div class="form-group">
				<label>Your Phone Number*</label>
				<input type="tel" name="phone" class="form-control" placeholder="Your Phone Number*" required="">
			</div>
			<div class="form-group">
				<label>Message*</label>
				<textarea rows="4" name="message" class="form-control" placeholder="Please include any useful details, i.e. current status, availability for viewings, etc." required=""></textarea>
			</div>
			<div style="border-top: 1px solid #e9ecef;display: flex;-webkit-box-align: center;-ms-flex-align: center;align-items: center;-webkit-box-pack: end;justify-content: flex-end;padding: 1rem;">
				<button type="button" class="btn btn-link" data-dismiss="modal" style="margin-right: .25rem;">Cancel</button>
				<button type="submit" class="btn btn-primary" style="margin-left: .25rem;">Request Details</button>
			</div>
		  </form>
		</div>
	  </div>
	</div>
</div>