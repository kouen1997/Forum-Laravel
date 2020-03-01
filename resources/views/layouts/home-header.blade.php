@if(Request::is('/'))
<nav class="navbar navbar-expand-lg navbar-dark navbar-over absolute-top" id="menu">
	<div class="container">
		<a class="navbar-brand" href="{{ url('/') }}"><img src="{{ URL::asset('logo.png') }}" width="80"></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu-content" aria-controls="menu-content" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="menu-content">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="{{ url('/') }}" role="button">
						Home <span class="sr-only">(current)</span>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ url('/properties/sale') }}" role="button">
						For Sale
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ url('/properties/rent') }}" role="button">
						For Rent
					</a>
				</li>
				@auth
				<li class="nav-item">
					<a class="nav-link" href="{{ url('/dashboard') }}" role="button">
						Dashboard
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ url('/associate') }}" role="button">
						Associate
					</a>
				</li>
				@else
				@endauth
			</ul>
			<ul class="navbar-nav ml-auto">
				@auth
				<li class="nav-item dropdown user-account">
					<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="user-image" style="background-image:url('{{ URL::asset('homebook.png') }}');"></span> Hi, {{ Auth::user()->username }}
					</a>
					<div class="dropdown-menu">
						<a href="{{ url('/profile') }}" class="dropdown-item">My Profile</a>
						<a href="{{ url('/listings') }}" class="dropdown-item">My Listing</a>
						<a href="{{ url('/dashboard') }}" class="dropdown-item">Dashboard</a>
						<a href="{{ url('/associate') }}" class="dropdown-item">Associate</a>
						
						<a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
							Logout
						</a>
						<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
						{!! csrf_field() !!}
						</form>
					</div>
				</li>
				@else
				<li class="nav-item user-account">
					<a class="nav-link" href="{{ url('/login') }}">
						Login
					</a>
				</li>
				@endauth
				<li class="nav-item"><a class="nav-link nav-btn" href="{{ url('/profile/property/add') }}"><span><i class="fa fa-plus" aria-hidden="true"></i> Add listing</span></a></li>
			</ul>
		</div>
	</div>
</nav>
@else
<nav class="navbar navbar-expand-lg navbar-dark" id="menu">
	<div class="container">
		<a class="navbar-brand" href="{{ url('/') }}"><img src="{{ URL::asset('logo.png') }}" width="50"></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu-content" aria-controls="menu-content" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="menu-content">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="{{ url('/') }}" role="button">
						Home <span class="sr-only">(current)</span>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ url('/properties/sale') }}" role="button">
						For Sale
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ url('/properties/rent') }}" role="button">
						For Rent
					</a>
				</li>
				@auth
				<li class="nav-item">
					<a class="nav-link" href="{{ url('/dashboard') }}" role="button">
						Dashboard
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ url('/associate') }}" role="button">
						Associate
					</a>
				</li>
				@else
				@endauth
			</ul>
			<ul class="navbar-nav ml-auto">
				@auth
				<li class="nav-item dropdown user-account">
					<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="user-image" style="background-image:url('{{ URL::asset('homebook.png') }}');"></span> Hi, {{ Auth::user()->username }}
					</a>
					<div class="dropdown-menu">
						<a href="{{ url('/profile') }}" class="dropdown-item">My Profile</a>
						<a href="{{ url('/listings') }}" class="dropdown-item">My Listing</a>
						<a href="{{ url('/dashboard') }}" class="dropdown-item">Dashboard</a>
						<a href="{{ url('/associate') }}" class="dropdown-item">Associate</a>
						
						<a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
							Logout
						</a>
						<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
						{!! csrf_field() !!}
						</form>
					</div>
				</li>
				@else
				<li class="nav-item user-account">
					<a class="nav-link" href="{{ url('/login') }}">
						Login
					</a>
				</li>
				@endauth
				<li class="nav-item"><a class="nav-link nav-btn" href="{{ url('/profile/property/add') }}"><span><i class="fa fa-plus" aria-hidden="true"></i> Add listing</span></a></li>
			</ul>
		</div>
	</div>
</nav>
@endif
@if(Request::is('/'))
<div class="home-search">
	<div class="main search-form v5">
		<div class="container">
			<div class="row justify-content-md-center">
				<div class="col-lg-6">
					<div class="heading">
						<h2>Gateway to your Dream Home</h2>
						<h3>With over 10 years of experience in real estate, we can take care of all of your needs in your search for a new home.</h3>
					</div>
				</div>
				<div class="col-lg-4">
					<form action="{{ url('/properties') }}" method="GET">
						<div class="form-group">
							<select name="property_type" class="form-control form-control-lg ui-select" required="">
								<option value="" selected disabled>Property Type</option>
								<option value="Condominium">Condominium</option>
                                <option value="Commercial">Commercial</option>
                                <option value="Apartment">Apartment</option>
                                <option value="Foreclosures">Foreclosures</option>
                                <option value="House">House</option>
                                <option value="Land">Land</option>
                                <option value="House and Lot">House and Lot</option>
                                <option value="Office">Office</option>
                                <option value="Farm">Farm</option>
                                <option value="Beach">Beach</option>
                                <option value="Building">Building</option>
                                <option value="Resort">Resort</option>
							</select>
						</div>
						<div class="row form-group justify-content-md-center">
							<div class="col-6">
								<input type="number" name="from" class="form-control form-control-lg" placeholder="Price (From)" required="">
							</div>
							<div class="col-6">
								<input type="number" name="to" class="form-control form-control-lg" placeholder="Price (To)" required="">
							</div>
						</div>
						<div class="form-group">
							<input type="text" name="address" class="form-control form-control-lg" placeholder="City, Address">
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-lg btn-primary btn-block">Search</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endif