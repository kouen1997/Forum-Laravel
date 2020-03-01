@extends('layouts.dashboard.master')

@section('title', $trivia->title)

@section('header_scripts')

@stop

@section('content')
    <main role="main" class="pt-5 py-3 pl-5 pr-5 desk-padding bg-light-2">
        
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 mb-4">
                <div class="p-3 bg-white shadow-light">
                    <h5 class="pb-2 mb-0">{{ $trivia->title }}</h5>
                    <small>{{ $trivia->created_at->diffforHumans() }}
                    <br>
                    TOTAL VIEWS: {{ $trivia->views->count() }}
                    </small>
                 </div>

                 <div class="p-3 bg-white shadow-light">
                    {!! $trivia->content !!}
                 </div>
            </div>
        </div>
    </main>
@endsection

@section('footer_scripts')

@stop
