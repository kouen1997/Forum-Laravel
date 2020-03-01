@extends('layouts.dashboard.master')

@section('title', 'Video Tutorial')

@section('header_scripts')
<style type="text/css">
    .fa{
        color: #bdbdbd;
    }
</style>
@stop

@section('content')
<main role="main" class="pt-5 py-3 pl-5 pr-5 desk-padding bg-light-2">
    
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 mb-4">
            <div class="p-3 bg-white shadow-light">
                <h5 class="pb-2 mb-0">Video Tutorial</h5>
                @if(count($videos) > 0)
                    <div class="row">
                        @foreach($videos as $video)
                            <div class="col-xl-6 col-lg-6 col-md-6 mb-4">
                                <b><a href="{{ url('/video/tutorial/view/'.$video->slug) }}">{{ $video->title }}</a></b>
                                <div class="media text-muted pt-3">
                                    <br>
                                    <iframe width="100%" height="360" src="https://www.youtube.com/embed/{{ $video->video_link }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else

                    <div class="alert alert-danger"> No video tutorial data found </div>

                @endif

            </div>
            <div style="padding-top: 1em; float: right;"> 
                {!! $videos->render() !!}
            </div>

        </div>
    </div>
</main>
@endsection

@section('footer_scripts')

@stop

 