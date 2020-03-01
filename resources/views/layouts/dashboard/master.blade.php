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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="{{ URL::asset('assets/dashboard/css/custom.css') }}">

    @yield('header_scripts')
</head>
<body class="d-flex flex-column">
    <noscript>
        <div class="alert">
            <div class="container">
                This site is best viewed in a modern browser with JavaScript enabled.
            </div>
        </div>
    </noscript>

    @include('layouts.dashboard.header')

    @yield('content')

    <footer class="bg-white">
        <div class="container pt-3 pl-5 pr-5 footer-bar">
          <div class="row py-4">
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0"><img src="{{ URL::asset('assets/dashboard/img/logo-text.png') }}" alt="" width="180" class="mb-3">
            </div>
            <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
              <h6 class="text-uppercase font-weight-bold mb-4">Services</h6>
              <ul class="list-unstyled mb-0">
                <li class="mb-2"><a href="#" class="text-muted">Travel and Tours</a></li>
                <li class="mb-2"><a href="#" class="text-muted">Title Transfer</a></li>
                <li class="mb-2"><a href="#" class="text-muted">Home Loan Assistance</a></li>
                <li class="mb-2"><a href="#" class="text-muted">Property Appraisal</a></li>
              </ul>
            </div>
            <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
              <h6 class="text-uppercase font-weight-bold mb-4">Features</h6>
              <ul class="list-unstyled mb-0">
                <li class="mb-2"><a href="#" class="text-muted">Trivia Corner</a></li>
                <li class="mb-2"><a href="#" class="text-muted">Video Tutorial</a></li>
                <li class="mb-2"><a href="#" class="text-muted">Forum</a></li>
                <li class="mb-2"><a href="#" class="text-muted">Architectural</a></li>
                <li class="mb-2"><a href="#" class="text-muted">Interior Design</a></li>
              </ul>
            </div>
            <div class="col-lg-4 col-md-6 mb-lg-0">
              <h6 class="text-uppercase font-weight-bold mb-4">HomeBook</h6>
              <p class="text-muted mb-4">HomeBook is an Affiliate Marketing Company which focuses on Real Estate. You may use it for FREE but being a Basic or Premium Member will open up more services for you to avail.</p>
              <ul class="list-inline mt-4">
                    <li class="list-inline-item"><a href="#" target="_blank" title="twitter"><i class="fa fa-twitter"></i></a></li>
                    <li class="list-inline-item"><a href="#" target="_blank" title="facebook"><i class="fa fa-facebook"></i></a></li>
                    <li class="list-inline-item"><a href="#" target="_blank" title="instagram"><i class="fa fa-instagram"></i></a></li>
                    <li class="list-inline-item"><a href="#" target="_blank" title="pinterest"><i class="fa fa-pinterest"></i></a></li>
                    <li class="list-inline-item"><a href="#" target="_blank" title="vimeo"><i class="fa fa-vimeo"></i></a></li>
                  </ul>
            </div>
          </div>
        </div>
    
        <!-- Copyrights -->
        <div class="bg-light py-2">
          <div class="container text-center">
            <p class="text-muted mb-0 py-2">&copy; {{ date('Y') }} HomeBook All rights reserved.</p>
          </div>
        </div>
    </footer>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

    <script src="{{ URL::asset('assets/plugins/toastr/toastr.min.js') }}" ></script>
    <script type="text/javascript">
        toastr.options.closeMethod = 'fadeOut';
        toastr.options.closeEasing = 'swing';
        toastr.options.preventDuplicates = true;
        toastr.options.closeButton = true;
        //toastr.options.escapeHtml = true;
    </script>

    <script src="{{ URL::asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/angular/angular.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/angular/angular.filter.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/angular/angular-animate.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/angular/angular-aria.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/angular/angular-messages.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/angular/angular-material.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/angular/angular-sanitize.js') }}"></script>

    <script>
        $(window).scroll(function() {     
            var scroll = $(window).scrollTop();
            if (scroll > 0) {
                $("#header").addClass("navbar-shadaw-active");
            }
            else {
                $("#header").removeClass("navbar-shadaw-active");
            }
        });
    </script>

    @yield('footer_scripts')
</body>
</html>