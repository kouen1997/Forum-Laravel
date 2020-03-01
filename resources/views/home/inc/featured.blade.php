<div class="feature-box centered gray">
    <div>
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col col-lg-12 col-xl-10">
                    <div class="item-listing grid">
                        <div class="main-title"><span>Featured Properties</span></div>
                        <div class="main-title-description">You can now dream and discover properties</div>
                        <div class="row">
                            @if($featured_properties)
                            @foreach($featured_properties as $featured)
                            <div class="col-md-6">
                                <div class="item">
                                    <div class="item-image">
                                        <a href="{{ url('/property/'.$featured->slug) }}">
                                            <div class="img-fluid">
                                                <img src="{{ $featured->photos->first()['filename'] }}" alt="{{ $featured->title }}" class="featured-property-img">
                                            </div>
                                            <div class="item-meta">
                                                <div class="item-price">&#8369;{{ number_format($featured->price,0) }} <small>{{ $featured->floor_area }} sq m</small> </div>
                                            </div>
                                            <div class="item-badges">
                                                <div class="item-badge-left">{{ $featured->offer_type }}</div>
                                                <div class="item-badge-right">{{ $featured->property_type }}</div>
                                            </div>
                                        </a>
                                        @auth
                                        <input type="hidden" value="{{ url('/property/'.$featured->slug.'/?ref='.Auth::user()->username) }}" id="share-link">
                                        <a onclick="share_property()" href="#" class="save-item" title="Share" id="shareBtn">
                                        @else
                                        <input type="hidden" value="{{ url('/property/'.$featured->slug) }}" id="share-link">
                                        <a onclick="share_property()" href="#" class="save-item" title="Share" id="shareBtn">
                                        @endauth
                                            <i class="fa fa-share"></i>
                                        </a>
                                    </div>
                                    <div class="item-info">
                                        <h3 class="item-title" title="{{ $featured->title }}"><a href="{{ url('/property/'.$featured->slug) }}">{{ str_limit(strip_tags($featured->title), $limit = 30, $end = '...') }}</a></h3>
                                        <div class="item-location"><i class="fa fa-map-marker"></i> <span title="{{ $featured->address }}">{{ str_limit(strip_tags($featured->address), $limit = 30, $end = '...') }}</span></div>
                                        <div class="item-details-i">
                                            <span class="bedrooms" data-toggle="tooltip" title="{{ $featured->bedrooms }} Bedrooms">{{ $featured->bedrooms }} <i class="fa fa-bed"></i> Bedrooms &middot; </span>
                                            <span class="bathrooms" data-toggle="tooltip" title="{{ $featured->baths }} Bathrooms">{{ $featured->baths }} <i class="fa fa-bath"></i> Bathrooms </span>
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