<div class="feature-box centered gray">
    <div>
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col col-lg-12 col-xl-10">
                    <div class="item-listing grid">
                        <div class="main-title"><span>Latest Properties</span></div>
                        <div class="main-title-description">Check out some of our recent properties.</div>
                        <div class="row">
                            @if($properties)
                            @foreach($properties as $property)
                            <div class="col-md-4">
                                <div class="item">
                                    <div class="item-image">
                                        <a href="{{ url('/property/'.$property->slug) }}">
                                            <div class="img-fluid">
                                                <img src="{{ $property->photos->first()['filename'] }}" alt="{{ $property->title }}" class="latest-property-img">
                                            </div>
                                            <div class="item-meta">
                                                <div class="item-price">&#8369;{{ number_format($property->price,0) }} <small>{{ $property->floor_area }} sq m</small> </div>
                                            </div>
                                            <div class="item-badges">
                                                <div class="item-badge-left">{{ $property->offer_type }}</div>
                                                <div class="item-badge-right">{{ $property->property_type }}</div>
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
                                    <div class="item-info">
                                        <h3 class="item-title" title="{{ $property->title }}"><a href="{{ url('/property/'.$property->slug) }}">{{ str_limit(strip_tags($property->title), $limit = 30, $end = '...') }}</a></h3>
                                        <div class="item-location"><i class="fa fa-map-marker"></i> <span title="{{ $property->address }}">{{ str_limit(strip_tags($property->address), $limit = 30, $end = '...') }}</span></div>
                                        <div class="item-details-i">
                                            <span class="bedrooms" data-toggle="tooltip" title="{{ $property->bedrooms }} Bedrooms">{{ $property->bedrooms }} <i class="fa fa-bed"></i> Bedrooms &middot; </span>
                                            <span class="bathrooms" data-toggle="tooltip" title="{{ $property->baths }} Bathrooms">{{ $property->baths }} <i class="fa fa-bath"></i> Bathrooms </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>