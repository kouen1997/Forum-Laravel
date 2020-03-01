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
				<li class="nav-item"><a class="nav-link nav-btn" href="{{ url('/') }}"><span><i class="fa fa-plus" aria-hidden="true"></i> Add listing</span></a></li>
			</ul>
		</div>
	</div>
</nav>