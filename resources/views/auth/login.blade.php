@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="container">
	<div class="row justify-content-md-center">
		  <div class="col col-md-12 col-lg-10 col-xl-8">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">Login</li>
			</ol>
			</nav>
		<div class="page-header">
		<h1>Please sign in or register</h1>
		</div>
	  </div>
	</div>
</div>

<div id="content">
	<div class="container">
		<div class="row justify-content-md-center align-items-center">
			<div class="col col-md-6  col-lg-5 col-xl-4">
				<ul class="nav nav-tabs tab-lg" role="tablist">
					<li role="presentation" class="nav-item"><a class="nav-link active" href="{{ url('/login') }}">Sign In</a></li>
					<li role="presentation" class="nav-item"><a class="nav-link" href="{{ url('/register') }}">Register</a></li>
				</ul>
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="login">
						<form method="POST" action="{{ url('/login') }}">
							{!! csrf_field() !!}
			
							@if(session('success'))
							<div class="alert alert-success" role="alert">
							{!! session('success') !!}
							</div>
							@endif

							@if(session('banned'))
							<div class="alert alert-danger" role="alert">
							{!! session('banned') !!}
							</div>
							@endif

							@if(session('danger'))
							<div class="alert alert-warning" role="alert">
							{!! session('danger') !!}
							</div>
							@endif

							@if ($errors->has('g-recaptcha-response'))
							<div class="alert alert-warning" role="alert">
								{{ $errors->first('g-recaptcha-response') }}
							</div>
							@endif

							<div class="form-group">
								<label for="email">Username</label>
								<input type="text" name="username" id="username" class="form-control form-control-lg" placeholder="Username" autofocus>
							</div>
							<div class="form-group">
								<label for="password">Password</label>
								<input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Password">
							</div>
							<div class="form-group">
								{!! NoCaptcha::display() !!}
							</div>
							<p class="text-lg-right"><a href="forgot-password.html">Forgot Password</a></p>
							<button type="submit" class="btn btn-primary btn-lg">Sign In</button>
						</form>
					</div>
				</div>
				<div></div>
			</div>
			<div class="col-md-6 col-lg-5 col-xl-4">
				<div class="socal-login-buttons"><p>HomeBook is an Affiliate Marketing Company which focuses on Real Estate. You may use it for FREE but being a Basic or Premium Member will open up more services for you to avail.</p></div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('footer_scripts')
{!! NoCaptcha::renderJs() !!}
@stop
