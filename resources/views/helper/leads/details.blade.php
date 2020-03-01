@extends('layouts.backend.master')

@section('title', 'View Lead')

@section('header_scripts')
@stop

@section('content')
<div ng-app="propertyApp" ng-controller="PropertyCtrl as frm">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card mb-3 bg-boxshadow">
                    <div class="card-body p-3">
                        <div class="call-to-action-1-area">
                            <div class="call-to-action-text-1">
                                <p><h3><a href="{{ url('/property/'.$detail->property->slug) }}" target="_blank">{{ $detail->property->title }}</a></h3>Info:</p><br />
                                <h5>Name: <span>{{ $detail->name }}</span></h5>
                                <h5>Email: <span>{{ $detail->email }}</span></h5>
                                <h5>Phone: <span>{{ $detail->phone }}</span></h5><br />
                                <p>Message:</p>
                                <p>{{ $detail->message }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card mb-3 bg-boxshadow">
                    <div class="card-body p-3">
                        <h5 class="card-title">Add a Note</h5>
                        <form method="POST" action="{{ url('helper/leads/'.$detail->id) }}" autocomplete="off" class="forms-sample">
                            {!! csrf_field() !!}
                            @if(session('success'))
                            <div class="alert alert-success" role="alert">
                            {!! session('success') !!}
                            </div>
                            @endif

                            @if(session('danger'))
                            <div class="alert alert-warning" role="alert">
                            {!! session('danger') !!}
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
                                <label>Your Note*</label>
                                <textarea name="note" class="form-control" rows="4" placeholder="Your note here." required="">{{ $detail->note }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Status*</label>
                                <select class="form-control" name="status" required="">
                                    <option value="" selected disabled>Choose</option>
                                    <option value="PENDING" {{ $detail->status === 'PENDING' ? 'selected' : '' }}>PENDING</option>
                                    <option value="TO FOLLOW" {{ $detail->status === 'TO FOLLOW' ? 'selected' : '' }}>TO FOLLOW</option>
                                    <option value="COMPLETED" {{ $detail->status === 'COMPLETED' ? 'selected' : '' }}>COMPLETED</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer_scripts')
<script type="text/javascript">
  	(function () {
        var propertyApp = angular.module('propertyApp', ['angular.filter']);
        propertyApp.controller('PropertyCtrl', function ($scope, $http, $sce) {
            
            var vm = this;

        });
    })();
</script>
@stop