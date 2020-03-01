<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
    <link rel="stylesheet" href="{{ URL::asset('assets/backend/css/c3.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/backend/js/default-assets/vector-map/jquery-jvectormap-2.0.2.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/backend/style.css') }}">

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

    <div class="ecaps-page-wrapper sidebar-light">

        @include('layouts.backend.sidebar')

        <div class="ecaps-page-content">

            @include('layouts.backend.header')

            <div class="main-content">

                @yield('content')
                

                <footer class="footer-area d-flex align-items-center flex-wrap">
                    <div class="copywrite-text">
                        <p><a href="#" target="_blank">HomeBookPH</a> &copy; {{ date('Y') }} - All Rights Reserved.</p>
                    </div>
                    <!-- Footer Nav -->
                    <ul class="footer-nav d-flex align-items-center">
                        <li><a href="#">About</a></li>
                        <li><a href="#">Privacy</a></li>
                    </ul>
                </footer>

            </div>
            
        </div>
    </div>
    
    <script src="{{ URL::asset('assets/backend/js/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('assets/backend/js/popper.min.js') }}"></script>
    <script src="{{ URL::asset('assets/backend/js/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('assets/backend/js/ecaps.bundle.js') }}"></script>
    <script src="{{ URL::asset('assets/backend/js/default-assets/date-time.js') }}"></script>
    <script src="{{ URL::asset('assets/backend/js/default-assets/active.js') }}"></script>
    <script src="{{ URL::asset('assets/backend/js/d3.min.js') }}"></script>
    <script src="{{ URL::asset('assets/backend/js/c3.min.js') }}"></script>
    <script src="{{ URL::asset('assets/backend/js/default-assets/c3-chart-script.js') }}"></script>
    <script src="{{ URL::asset('assets/backend/js/charts/morris/raphael-min.js') }}"></script>
    <script src="{{ URL::asset('assets/backend/js/default-assets/sparkline-small.js') }}"></script>
    <script src="{{ URL::asset('assets/backend/js/default-assets/sparkline.min.js') }}"></script>

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

    @yield('footer_scripts')


</body>
</html>