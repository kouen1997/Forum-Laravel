@extends('layouts.dashboard.master')

@section('title', 'Dashboard')

@section('header_scripts')
@stop

@section('content')
<main role="main" class="pt-5 py-3 pl-5 pr-5 desk-padding bg-light-2">
    <h3 class="display-4 border-bottom mb-3"></h3>
    <div class="row">

        @include('dashboard.inc.main')
        
        @include('dashboard.inc.sidebar')

    </div>
</main>
@endsection