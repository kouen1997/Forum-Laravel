<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark shadow-sm" id="header">
	<div class="container">
	  <a href="#" class="navbar-brand">
		<!-- Logo Image -->
		<img src="{{ URL::asset('assets/dashboard/img/logo-no-text.png') }}" width="45" alt="" class="d-inline-block align-middle mr-2">
		<!-- Logo Text -->
		<span class="font-weight-bold">HomeBook</span>
	  </a>
  
	  <button type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler custom-navbar-toggler"><span class="navbar-toggler-icon"></span></button>
  
	  <div id="navbarSupportedContent" class="collapse navbar-collapse">
		
		<div id="header-primary" class="Header-primary">
			<ul class="navbar-nav ml-auto text-center Header-controls">
				<li class="nav-item active"><a class="nav-link" target="" href="{{ url('/') }}" title="Home">HOME</a></li>

				<li class="nav-item"><a class="nav-link" target="_blank" href="{{ url('/dashboard') }}" title="Dashboard">DASHBOARD</a></li>

				<li class="nav-item"><a class="nav-link" target="_blank" href="{{ url('/forum') }}" title="Dashboard">FORUM</a></li>

                <li class="nav-item"><a class="nav-link" target="_blank" href="{{ url('/trivia') }}" title="Dashboard">TRIVIA</a></li>

                <li class="nav-item"><a class="nav-link" target="_blank" href="{{ url('/video/tutorial') }}" title="Dashboard">VIDEO TUTORIAL</a></li>
			</ul>
		</div>
		
		<ul class="navbar-nav ml-auto text-center">
		  <li class="nav-item active"><a href="{{ url('/profile') }}" class="nav-link">{{ Auth::user()->username }} <span class="sr-only">(current)</span></a></li>
		</ul>
	  </div>
	</div>
</nav>