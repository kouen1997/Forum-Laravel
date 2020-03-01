<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="keywords" content="homebook, book, real estate, homes for sale, estate homes, home for sale, luxury, real, estate, luxury homes, homes, homes for sale, home sale, estate, sale" />
    <meta name="description" content="Homebook - Find an apartment, condo, office space, house, and lot for sale or for rent in top locations.">
    <meta name="author" content="HomeBook">
    <meta name="_token" content="{!! csrf_token() !!}">
    <meta property="og:site_name" content="HomeBook" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://homebook.ph" />
    <meta property="og:title" content="HomeBook" />
    <meta property="og:description" content="Homebook - Find an apartment, condo, office space, house, and lot for sale or for rent in top locations."/>
    <meta property="twitter:card" content="summary">
    <meta property="twitter:title" content="HomeBook">
    <meta property="twitter:description" content="Homebook - Find an apartment, condo, office space, house, and lot for sale or for rent in top locations.">
    <meta property="twitter:domain" content="homebook.ph">
    <title>@yield('title') | HomeBook</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('homebook.png') }}">
    <link href="https://fonts.googleapis.com/css?family=Libre+Franklin:100,200,300,400,500,700" rel="stylesheet">
    <link href="{{ URL::asset('assets/frontend/lib/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/frontend/lib/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/frontend/lib/animate.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/frontend/lib/selectric/selectric.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/frontend/lib/swiper/css/swiper.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/frontend/lib/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/frontend/lib/Magnific-Popup/magnific-popup.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('assets/frontend/lib/photoswipe/photoswipe.css') }}"> 
    <link rel="stylesheet" href="{{ URL::asset('assets/frontend/lib/photoswipe/default-skin/default-skin.css') }}">
    <link href="{{ URL::asset('assets/frontend/css/style.css') }}" rel="stylesheet">

    @yield('header_scripts')
</head>
<body>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
            appId      : '2346459405608937',
            xfbml      : true,
            version    : 'v4.0'
            });
            FB.AppEvents.logPageView();
        };
        
        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <noscript>JavaScript is off. Please enable to view full site.</noscript>

    <div id="main">

        @include('layouts.home-header')

        @yield('content')

        <button class="btn btn-primary btn-circle" id="to-top"><i class="fa fa-angle-up"></i></button>
        <footer id="footer" class="bg-light footer-light">
            <div class="container container-1000">
                <div class="row">
                    <div class="col-lg-3">
                        <p><img src="{{ URL::asset('logo.png') }}" width="80"></p>
                        <address class="mb-3">
                        <strong>HomeBookPH</strong><br>
                    Manila,<br>
                    Philippines<br>
                    <abbr title="Phone">P:</abbr> (123) 456-7890
                    </address>
                        <div class="footer-social mb-4"><a href="#" class="ml-2 mr-2"><span class="fa fa-twitter"></span></a> <a href="#" class="ml-2 mr-2"><span class="fa fa-facebook"></span></a> <a href="#" class="ml-2 mr-2"><span class="fa fa-instagram"></span></a></div>
                    </div>
                    <div class="col-lg-3 col-sm-4">
                        <div class="footer-links">
                            <ul class="list-unstyled">
                                <li class="list-title"><a href="#">Services</a></li>
                                <li><a href="#">Travel and Tours</a></li>
                                <li><a href="#">Title Transfer</a></li>
                                <li><a href="#">Home Loan Assistance</a></li>
                                <li><a href="#">Property Appraisal</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-4">
                        <div class="footer-links">
                            <ul class="list-unstyled">
                                <li class="list-title"><a href="#">Features</a></li>
                                <li><a href="#">Trivia Corner</a></li>
                                <li><a href="#">Video Tutorial</a></li>
                                <li><a href="#">Forum</a></li>
                                <li><a href="#">Architectural</a></li>
                                <li><a href="#">Interior Design</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-sm-4">
                        <div class="footer-links">
                            <ul class="list-unstyled">
                              <li class="list-title"><a href="#">HomeBook</a></li>
                            </ul>
                            <p>HomeBook is an Affiliate Marketing Company which focuses on Real Estate. You may use it for FREE but being a Basic or Premium Member will open up more services for you to avail.</p>
                        </div>
                    </div>
                </div>
                <div class="footer-credits d-lg-flex justify-content-lg-between align-items-center">
                    <div>Powered by <strong>OneSystemsPH</strong></div>
        
                    <div>&copy; {{ date('Y') }} HomeBook - All Rights Reserved.</div>
                </div>
            </div>
        </footer>
    </div>
    
    <script src="{{ URL::asset('assets/frontend/lib/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ URL::asset('assets/frontend/lib/popper.min.js') }}"></script>
    <script src="{{ URL::asset('assets/frontend/lib/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('assets/frontend/lib/selectric/jquery.selectric.js') }}"></script>
    <script src="{{ URL::asset('assets/frontend/lib/swiper/js/swiper.min.js') }}"></script>
    <script src="{{ URL::asset('assets/frontend/lib/aos/aos.js') }}"></script>
    <script src="{{ URL::asset('assets/frontend/lib/Magnific-Popup/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ URL::asset('assets/frontend/lib/sticky-sidebar/ResizeSensor.min.js') }}"></script>
    <script src="{{ URL::asset('assets/frontend/lib/sticky-sidebar/theia-sticky-sidebar.min.js') }}"></script>
    <script src="{{ URL::asset('assets/frontend/lib/photoswipe/photoswipe.min.js') }}"></script>
    <script src="{{ URL::asset('assets/frontend/lib/photoswipe/photoswipe-ui-default.min.js') }}"></script>
    <script src="{{ URL::asset('assets/frontend/lib/lib.js') }}"></script>

    <script src="{{ URL::asset('assets/plugins/toastr/toastr.min.js') }}" ></script>
    <script type="text/javascript">
        toastr.options.closeMethod = 'fadeOut';
        toastr.options.closeEasing = 'swing';
        toastr.options.preventDuplicates = true;
        toastr.options.closeButton = true;
        //toastr.options.escapeHtml = true;
    </script>

    <script src="{{ URL::asset('assets/plugins/angular/angular.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/angular/angular.filter.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/angular/angular-animate.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/angular/angular-aria.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/angular/angular-messages.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/angular/angular-material.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/angular/angular-sanitize.js') }}"></script>

    <script type="text/javascript" id="cookieinfo"
        src="//cookieinfoscript.com/js/cookieinfo.min.js"
        data-cookie="CookieInfoScript"
        data-close-text="Got it!">
    </script>

    @yield('footer_scripts')
</body>
</html>