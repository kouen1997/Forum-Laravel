@extends('layouts.dashboard.master')

@section('title', $video->title)

@section('header_scripts')

@stop

@section('content')
    <main role="main" class="pt-5 py-3 pl-5 pr-5 desk-padding bg-light-2">
        
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 mb-4">
                <b>{{ $video->title }}</b>
                <br>
                <br>
	            {!! $video->content !!}
                <div class="media text-muted pt-3">
	                <iframe width="100%" height="600" src="https://www.youtube.com/embed/{{ $video->video_link }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	                <br>
	            </div>
            </div>
        </div>
    </main>
@endsection

@section('footer_scripts')

@stop
