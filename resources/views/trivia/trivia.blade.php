@extends('layouts.dashboard.master')

@section('title', 'Trivia')

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
        
        <div class="col-xl-9 col-lg-9 col-md-7 mb-4">
            <div class="p-3 bg-white shadow-light">
                <h5 class="pb-2 mb-0">Trivia</h5>
                @if(count($trivias) > 0)

                    @foreach($trivias as $trivia)

                        <div class="media text-muted pt-3">
                            <p class="media-body pb-3 mb-0 medium lh-125">
                                <strong class="d-block text-gray-dark"><a href="{{ url('/trivia/view/'.$trivia->slug) }}">{{ $trivia->title }}</a> 

                                </strong>

                                <small>{{ $trivia->created_at->diffforHumans() }}</small>
                                <span class="pull-right"><i class="fa fa-eye" style="color:#bdbdbd;"></i> {{ $trivia->views->count() }}
                            </p>
                        </div>

                    @endforeach

                    
                @else

                    <div class="alert alert-danger"> No trivia data found </div>

                @endif

            </div>
            <div style="padding-top: 1em; float: right;"> 
                {!! $trivias->links() !!}
            </div>

        </div>
        @if(count($trivias) > 0)
            <div class="col-xl-3 col-lg-3 col-md-3 mb-4">
                <div class="p-3 bg-white shadow-light">

                    <h6>Most Viewed</h6>
                    @if(count($mostViewed) > 0)

                        @foreach($mostViewed as $mostV)

                            <div class="media text-muted pt-3">
                                <p class="media-body pb-3 mb-0 medium lh-125">
                                    <strong class="d-block text-gray-dark"><a href="{{ url('/trivia/view/'.$mostV->trivia->slug) }}">{{ $mostV->trivia->title }}</a>
                                    </strong>
                                    <small>{{ $mostV->trivia->created_at->diffforHumans() }}</small>
                                    <span class="pull-right"><i class="fa fa-eye" style="color:#bdbdbd;"></i> {{ $mostV->trivia->views->count() }}
                                </p>
                            </div>

                        @endforeach

                        
                    @else

                        <div class="alert alert-danger"> No trivia data found </div>

                    @endif
                </div> 
            </div>
        @endif
    </div>
</main>

@endsection

@section('footer_scripts')

@stop

 