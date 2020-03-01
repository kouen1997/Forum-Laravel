@extends('layouts.master')

@section('title', 'Search Properties')

@section('header_scripts')
@stop

@section('content')
<div class="container">
    <div class="search-form">
        <div class="card">
			<form action="{{ url('/properties') }}" method="GET">
				<div class="row">
					<div class="col-lg-3">
						<div class="form-group">
							<select name="property_type" class="form-control form-control-lg ui-select" required="" value="{{ old('property_type') }}">
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
					</div>
					<div class="col-lg-4">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<input type="number" name="from" class="form-control form-control-lg" placeholder="Price (From)" value="{{ old('from') }}" required="">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<input type="number" name="to" class="form-control form-control-lg" placeholder="Price (To)" value="{{ old('to') }}" required="">
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-5">
						<div class="row">
							<div class="col-sm-7">
								<div class="form-group">
									<input type="text" name="address" class="form-control form-control-lg" value="{{ old('address') }}" placeholder="City, Address">
								</div>
							</div>
							<div class="col-sm-5">
								<div class="form-group">
									<button type="submit" class="btn btn-lg btn-primary btn-block">Search</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col col-lg-12 col-xl-10">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Properties</li>
                </ol>
            </nav>
            <div class="page-header">
                <h1>Search properties</h1>
            </div>
        </div>
    </div>
</div>

@include('properties.inc.search')
@include('properties.inc.sidebar')

@endsection
@section('footer_scripts')
<script>
	function share_property1() {
		var property_link = document.getElementById("shareBtn").getAttribute("href");
		console.log(property_link);
		//FB.ui({
		//	method: 'share',
		//	href: property_link
		//}, function(response){
		//	console.log(response);
		//});
	}

	function share_property() {

		var property_link1 = document.getElementById("shareBtn").getAttribute("href");
		var property_link = document.getElementById('share-link').value;
		console.log(property_link);

		FB.ui({
			method: 'share_open_graph',
			action_type: 'og.shares',
			action_properties: JSON.stringify({
				object: property_link
			})
		}, function(response){
			if (response.error_code) {
				console.log(response);

				
			} else {
				console.log('published');

				@auth

				var CSRF_TOKEN = $('meta[name="_token"]').attr('content');

				$.ajax({
					type:'POST',
					url:'/share-link-reward',
					data:{_token: CSRF_TOKEN},
					dataType: 'JSON',
					success:function(data){
						if (data.result == 1){
							setTimeout(window.location.href = '/', 1000);
						} else {
							alert('Something went wrong.');
						}
					}
            	});

				@endauth
			}
		});
	}
</script>
@stop