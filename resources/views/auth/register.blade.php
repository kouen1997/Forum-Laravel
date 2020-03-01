@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div id="content">
	<div class="container">
		<div class="row justify-content-md-center align-items-center">
			<div class="col col-md-8 col-lg-8 col-xl-8">
				<ul class="nav nav-tabs tab-lg" role="tablist">
					<li role="presentation" class="nav-item"><a class="nav-link" href="{{ url('/login') }}">Sign In</a></li>
					<li role="presentation" class="nav-item"><a class="nav-link active" href="{{ url('/register') }}">Register</a></li>
				</ul>
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="login">
						<form method="POST" action="{{ url('/register') }}" autocomplete="off">
							{!! csrf_field() !!}

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

							@if ($errors->any())
							<div class="alert alert-warning" role="alert">
								@foreach ($errors->all() as $error)
								* {{ $error }}<br>
								@endforeach
							</div>
							@endif
							<div class="form-group">
								<label>First Name</label>
								<input class="form-control form-control-lg" type="text" name="first_name" value="{{ old('first_name') }}" placeholder="First name" required="" autofocus>
							</div>
							<div class="form-group">
								<label>Middle Name</label>
								<input class="form-control form-control-lg" type="text" name="middle_name" value="{{ old('middle_name') }}" placeholder="Middle name" required="">
							</div>
							<div class="form-group">
								<label>Last Name</label>
								<input class="form-control form-control-lg" type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Last name" required="">
							</div>
							<div class="form-group">
								<label>Username</label>
								<input class="form-control form-control-lg" type="text" name="username" value="{{ old('username') }}" placeholder="Username" required="">
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Email</label>
										<input class="form-control form-control-lg" type="text" name="email" value="{{ old('email') }}" placeholder="Email" required="">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Mobile No.</label>
										<input class="form-control form-control-lg" type="text" name="mobile" value="{{ old('mobile') }}" placeholder="Mobile no." required="">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Password</label>
										<input class="form-control form-control-lg" type="password" name="password" placeholder="Password" required="">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Password Confirmation</label>
										<input class="form-control form-control-lg" type="password" name="password_confirmation" placeholder="Confirm password" required="">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Pin</label>
										<input class="form-control form-control-lg" type="text" name="pin" value="{{ old('pin') }}" placeholder="Pin" required="">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Pin Confirmation</label>
										<input class="form-control form-control-lg" type="text" name="pin_confirmation" value="{{ old('pin_confirmation') }}" placeholder="Pin Confirmation" required="">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Sponsor</label>
								<?php
									$sponsor="homebookofficial";
									if(isset($_GET['ref'])){
										$sponsor = $_GET['ref'];
									}
								?>
								<input type="text" name="sponsor" id="sponsor" class="form-control form-control-lg" placeholder="Sponsor" value="{{$sponsor}}" required="" readonly="readonly">
							</div>
							<div class="form-group">
								{!! NoCaptcha::display() !!}
							</div>
							<div class="checkbox">
								<input type="checkbox" id="terms">
								<label for="terms">By registering I accept our Terms of Use and Privacy.</label>
							</div>
							<button type="submit" class="btn btn-primary btn-lg">Register</button>
						</form>
					</div>
				</div>
				<div></div>
			</div>
			<div class="col-md-4 col-lg-4 col-xl-4">
				<div class="socal-login-buttons"><p>HomeBook is an Affiliate Marketing Company which focuses on Real Estate. You may use it for FREE but being a Basic or Premium Member will open up more services for you to avail.</p></div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('footer_scripts')
{!! NoCaptcha::renderJs() !!}
@stop
