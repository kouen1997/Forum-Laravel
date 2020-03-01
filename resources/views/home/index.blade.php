@extends('layouts.master')

@section('title', 'Home')

@section('header_scripts')
@stop

@section('content')

<div id="content" class="pt0 pb0">

	@include('home.inc.recent-properties')

	@include('home.inc.services')

	@include('home.inc.featured')

	@include('home.inc.developers')

	@include('home.inc.news')
	
	@include('home.inc.stats')

</div>

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
<script>
	var swiper = new Swiper('.swiper-container', {
		loop: true,
		centeredSlides: true,
			autoplay: {
			delay: 5000,
			disableOnInteraction: false,
		},
		pagination: {
			el: '.swiper-pagination',
			clickable: true,
		},
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},
	});
</script> 
@stop
