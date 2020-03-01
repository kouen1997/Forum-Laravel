@extends('layouts.master')

@section('title', $property->title)

@section('header_scripts')
<meta name="og:site_name" content="HomeBook" />
<meta name="fb:app_id" content="2346459405608937" />
<meta name="og:type" content="website" />
<meta name="og:url" content="{{ url('/') }}" />
<meta name="og:title" content="HomeBookPH" />
<meta name="og:description" content="Homebook - Find an apartment, condo, office space, house, and lot for sale or for rent in top locations."/>

<meta property="fb:app_id"          content="2346459405608937" /> 
<meta property="og:type"            content="article" /> 
<meta property="og:url"             content="{{ url('/property/'.$property->slug) }}" /> 
<meta property="og:title"           content="{{ $property->title }}" /> 
<meta property="og:image"           content="{{ $property->photos->first()['filename'] }}" /> 
<meta property="og:description"    content="{{ strip_tags($property->description) }}" />

<meta name="twitter:title" content="{{ $property->title }}">
<meta name="twitter:description" content="{{ strip_tags($property->description) }}">
<meta name="twitter:image" content="{{ $property->photos->first()['filename'] }}">
<meta name="twitter:card" content="summary_large_image">
@stop

@section('content')
<div class="container">
	<div class="row justify-content-md-center">
			<div class="col col-md-12 col-lg-12 col-xl-10">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">{{ $property->title }}</li>
		  </ol>
		<div class="page-header bordered mb0">
		  <div class="row">
			<div class="col-md-8"> <a href="{{ url('/') }}" class="btn-return" title="Back"><i class="fa fa-angle-left"></i></a>
			  <h1>{{ $property->title }} <span class="label label-bordered">For <strong class="text-success">{{ $property->offer_type == 'Sell' ? 'Sale' : 'Rent' }}</strong></span> <small><i class="fa fa-map-marker"></i> {{ $property->address }}</small></h1>
			</div>
			<div class="col-md-4">
			  <div class="price">&#8369;{{ number_format($property->price,0) }} <small>{{ $property->floor_area }} sq m</small></div>
			</div>
		  </div>
		</div>
	  </div>
	</div>
</div>


@include('properties.inc.detail')
@include('properties.inc.sidebar')
			
@endsection

@section('footer_scripts')
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
	<!-- Background of PhotoSwipe. 
		 It's a separate element, as animating opacity is faster than rgba(). -->
	<div class="pswp__bg"></div>

	<!-- Slides wrapper with overflow:hidden. -->
	<div class="pswp__scroll-wrap">

		<!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
		<!-- don't modify these 3 pswp__item elements, data is added later on. -->
		<div class="pswp__container">
			<div class="pswp__item"></div>
			<div class="pswp__item"></div>
			<div class="pswp__item"></div>
		</div>

		<!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
		<div class="pswp__ui pswp__ui--hidden">

			<div class="pswp__top-bar">

				<!--  Controls are self-explanatory. Order can be changed. -->

				<div class="pswp__counter"></div>

				<button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

				<button class="pswp__button pswp__button--share" title="Share"></button>

				<button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

				<button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

				<!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR -->
				<!-- element will get class pswp__preloader--active when preloader is running -->
				<div class="pswp__preloader">
					<div class="pswp__preloader__icn">
						<div class="pswp__preloader__cut">
							<div class="pswp__preloader__donut"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
				<div class="pswp__share-tooltip"></div>
			</div>

			<button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
			</button>

			<button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
			</button>

			<div class="pswp__caption">
				<div class="pswp__caption__center"></div>
			</div>

		</div>

	</div>

</div>
<script>
    	var initPhotoSwipeFromDOM = function(gallerySelector) {
        var parseThumbnailElements = function(el) {
            console.log(el);
            var thumbElements = $(el).closest(main_gallery).find('figure'),
                numNodes = thumbElements.length,
                items = [],
                figureEl,
                linkEl,
                size,
                item;

            for (var i = 0; i < numNodes; i++) {

                figureEl = thumbElements[i]; // <figure> element

                // include only element nodes 
                if (figureEl.nodeType !== 1) {
                    continue;
                }

                linkEl = figureEl.children[0]; // <a> element

                size = linkEl.getAttribute('data-size').split('x');

                // create slide object
                item = {
                    src: linkEl.getAttribute('href'),
                    w: parseInt(size[0], 10),
                    h: parseInt(size[1], 10)
                };

                if (figureEl.children.length > 1) {
                    // <figcaption> content
                    item.title = figureEl.children[1].innerHTML;
                }

                if (linkEl.children.length > 0) {
                    // <img> thumbnail element, retrieving thumbnail url
                    item.msrc = linkEl.children[0].getAttribute('src');
                }

                item.el = figureEl; // save link to element for getThumbBoundsFn
                items.push(item);
            }

            return items;
        };

        // find nearest parent element
        var closest = function closest(el, fn) {
            return el && (fn(el) ? el : closest(el.parentNode, fn));
        };

        // triggers when user clicks on thumbnail
        var onThumbnailsClick = function(e) {
            e = e || window.event;
            e.preventDefault ? e.preventDefault() : e.returnValue = false;

            var eTarget = e.target || e.srcElement;

            // find root element of slide
            var clickedListItem = closest(eTarget, function(el) {
                return (el.tagName && el.tagName.toUpperCase() === 'FIGURE');
            });

            if (!clickedListItem) {
                return;
            }
            var clickedGallery = clickedListItem.parentNode,
                childNodes = $(clickedListItem).closest(main_gallery).find('figure'),
                numChildNodes = childNodes.length,
                nodeIndex = 0,
                index;

            for (var i = 0; i < numChildNodes; i++) {
                if (childNodes[i].nodeType !== 1) {
                    continue;
                }

                if (childNodes[i] === clickedListItem) {
                    index = nodeIndex;
                    break;
                }
                nodeIndex++;
            }
            if (index >= 0) {
                // open PhotoSwipe if valid index found
                openPhotoSwipe(index, clickedGallery);
            }
            return false;
        };

        var openPhotoSwipe = function(index, galleryElement, disableAnimation) {
            var pswpElement = document.querySelectorAll('.pswp')[0],
                gallery,
                options,
                items;

            items = parseThumbnailElements(galleryElement);

            // define options (if needed)
            options = {
                history: false,
                bgOpacity: 0.8,
                loop: false,
                barsSize: {
                    top: 0,
                    bottom: 'auto'
                },

                // define gallery index (for URL)
                galleryUID: $(galleryElement).closest(main_gallery).attr('data-pswp-uid'),

                getThumbBoundsFn: function(index) {
                    // See Options -> getThumbBoundsFn section of documentation for more info
                    var thumbnail = document.querySelectorAll(main_gallery + ' img')[index],
                        //var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
                        pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                        rect = thumbnail.getBoundingClientRect();

                    return {
                        x: rect.left,
                        y: rect.top + pageYScroll,
                        w: rect.width
                    };
                }

            };

            options.index = parseInt(index, 10);

            // exit if index not found
            if (isNaN(options.index)) {
                return;
            }

            if (disableAnimation) {
                options.showAnimationDuration = 0;
            }

            // Pass data to PhotoSwipe and initialize it
            gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
            gallery.init();
            gallery.shout('helloWorld', 'John' /* you may pass more arguments */ );

            var totalItems = gallery.options.getNumItemsFn();

            function syncPhotoSwipeWithOwl() {
                var currentIndex = gallery.getCurrentIndex();
                galleryTop.slideTo(currentIndex);
                if (currentIndex == (totalItems - 1)) {
                    $('.pswp__button--arrow--right').attr('disabled', 'disabled').addClass('disabled');
                } else {
                    $('.pswp__button--arrow--right').removeAttr('disabled');
                }
                if (currentIndex == 0) {
                    $('.pswp__button--arrow--left').attr('disabled', 'disabled').addClass('disabled');
                } else {
                    $('.pswp__button--arrow--left').removeAttr('disabled');
                }
            };
            gallery.listen('afterChange', function() {
                syncPhotoSwipeWithOwl();
            });
            syncPhotoSwipeWithOwl();
        };

        // loop through all gallery elements and bind events
        var galleryElements = document.querySelectorAll(gallerySelector);

        for (var i = 0, l = galleryElements.length; i < l; i++) {
            galleryElements[i].setAttribute('data-pswp-uid', i + 1);
            galleryElements[i].onclick = onThumbnailsClick;
        }
    };
var main_gallery = '.gallery-top';
var galleryTop = new Swiper(main_gallery, {
    spaceBetween: 10,
    lazy: {
        loadPrevNext: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    on: {
        init: function() {
            initPhotoSwipeFromDOM(main_gallery);
        },
    }
});
var galleryThumbs = new Swiper('.gallery-thumbs', {
    spaceBetween: 10,
    centeredSlides: true,
    slidesPerView: 5,
    touchRatio: 0.2,
    slideToClickedSlide: true,
});
galleryTop.controller.control = galleryThumbs;
galleryThumbs.controller.control = galleryTop;
</script>
@stop