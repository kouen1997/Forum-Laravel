<div id="content">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col col-lg-12 col-xl-10">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <!--div class="sorting">
                            <div class="row justify-content-between">
                                <div class="col-sm-5 col-md-5 col-lg-4 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control ui-select">
                                            <option selected="selected">Most recent</option>
                                            <option>Highest price</option>
                                            <option>Lowest price</option>
                                            <option>Most reduced</option>
                                            <option>Most popular</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-5 col-lg-4 col-xl-3">
                                </div>
                            </div>
                        </div-->
                        <div class="clearfix"></div>
                        <div class="item-listing list">
							@if($properties)
							@foreach($properties as $property)
							<div class="item">
								<div class="row">
									<div class="col-lg-5">
										<div class="item-image">
											<a href="{{ url('/property/'.$property->slug) }}"><img src="{{ $property->photos->first()['filename'] }}" class="latest-property-img" alt="{{ $property->title }}">
												<div class="item-badges">
                                                    <div class="item-badge-left">{{ $property->offer_type }}</div>
                                                    <div class="item-badge-right">{{ $property->property_type }}</div>
												</div>
												<div class="item-meta">
													<div class="item-price">&#8369; {{ number_format($property->price,0) }}
														<small>{{ $property->floor_area }} sq m</small>
													</div>
												</div>
											</a>
											@auth
											<input type="hidden" value="{{ url('/property/'.$property->slug.'/?ref='.Auth::user()->username) }}" id="share-link">
											<a onclick="share_property()" href="#" class="save-item" title="Share" id="shareBtn">
											@else
											<input type="hidden" value="{{ url('/property/'.$property->slug) }}" id="share-link">
											<a onclick="share_property()" href="#" class="save-item" title="Share" id="shareBtn">
											@endauth
												<i class="fa fa-share"></i>
											</a>
										</div>
									</div>
									<div class="col-lg-7">
										<div class="item-info">
											<h3 class="item-title" title="{{ $property->title }}"><a href="{{ url('/property/'.$property->slug) }}">{{ str_limit(strip_tags($property->title), $limit = 30, $end = '...') }}</a></h3>
											<div class="item-location"><i class="fa fa-map-marker"></i> {{ str_limit(strip_tags($property->address), $limit = 30, $end = '...') }}</div>
											<div class="item-details-i"> 
												<span class="bedrooms" data-toggle="tooltip" title="{{ $property->bedrooms }} Bedrooms">
													{{ $property->bedrooms }} <i class="fa fa-bed"></i> Bedrooms &middot; 
												</span>
												<span class="bathrooms" data-toggle="tooltip" title="{{ $property->baths }} Bathrooms">
													{{ $property->baths }} <i class="fa fa-bath"></i> Bathrooms 
												</span>
											</div>
											<div class="item-details">
												<ul>
													<li>Sq M <span>{{ $property->floor_area }}</span></li>
													<li>Sub type <span>{{ $property->sub_type }}</span></li>
												</ul>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="added-on">Listed on {{ date('F j, Y', strtotime($property->created_at)) }} </div>
											</div>
											<div class="col-md-6">
												<a href="#" class="added-by">by {{ $property->name }}</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							@endforeach
							@endif
                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
								{{ $properties->links() }}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
	
