<header class="top-header-area d-flex align-items-center justify-content-between">
	<div class="left-side-content-area d-flex align-items-center">
		<!-- Mobile Logo -->
		<div class="mobile-logo mr-3 mr-sm-4">
			<a href="{{ url('/account') }}"><img src="{{ URL::asset('homebook.png') }}" alt="HomeBookPH"></a>
		</div>
		<!-- Triggers -->
		<div class="ecaps-triggers mr-1 mr-sm-3">
			<div class="menu-collasped" id="menuCollasped">
				<i class="ti-align-right"></i>
			</div>
			<div class="mobile-menu-open" id="mobileMenuOpen">
				<i class="ti-align-right"></i>
			</div>
		</div>
	</div>
	<div class="right-side-navbar d-flex align-items-center justify-content-end">
		<!-- Mobile Trigger -->
		<div class="right-side-trigger" id="rightSideTrigger">
			<i class="ti-align-left"></i>
		</div>
		<!-- Top Bar Nav -->
		<ul class="right-side-content d-flex align-items-center">
			<li class="nav-item">
				<span>{{ Auth::user()->username }}</span>
			</li>
			<li class="nav-item dropdown">
				<button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ URL::asset('homebook.png') }}" alt=""></button>
				<div class="dropdown-menu dropdown-menu-right">
					<!-- User Profile Area -->
					<div class="user-profile-area">
						<div class="user-profile-heading">
							<!-- Thumb -->
							<div class="profile-thumbnail">
								<img src="{{ URL::asset('homebook.png') }}" alt="avatar">
							</div>
							<!-- Profile Text -->
							<div class="profile-text">
								<h6>{{ Auth::user()->first_name .' '. Auth::user()->last_name }}</h6>
								<span>{{ Auth::user()->username }}</span>
							</div>
						</div>
						<a href="{{ url('/profile') }}" class="dropdown-item"><i class="ti-user text-default" aria-hidden="true"></i> My profile</a>
						<a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
							<i class="ti-unlink text-warning" aria-hidden="true"></i> Sign-out
						</a>
						<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
						{!! csrf_field() !!}
						</form>
					</div>
				</div>
			</li>
		</ul>
	</div>
</header>