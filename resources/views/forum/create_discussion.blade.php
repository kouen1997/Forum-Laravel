@extends('layouts.app')

@section('title', 'Forum')

@section('header_scripts')

@stop

@section('content')
<div >
<main role="main" class="pt-5 py-3 pl-5 pr-5 desk-padding bg-light-2">
    
    <div class="row">
        <div class="col-xl-2 col-lg-2 col-md-2 mb-4">
            Filters
        </div>
        <div class="col-xl-8 col-lg-8 col-md-8 mb-4">
            <div class="p-3 bg-white shadow-light">
                <h5 class="pb-2 mb-0">Start Discussion</h5>

                <form method="post" action="{{ url('/post/forum') }}">
		        {{ csrf_field() }}
		>                
		            <div class="form-group">
		                <label for="title">Title</label>
		                <input type="text" name="title" ng-model="form.title()" class="form-control" placeholder="Title">
		            </div>
		            <div class="form-group">
		              <label for="title">Title</label>
		              <textarea id="content" name="content" placeholder="Write Discussion..." rows="10" cols="80" class="form-control" required></textarea>
		            </div>
		            <div class="form-group">
		                <button type="button" id="create_forum_btn" class="btn btn-primary">Post</button>
		            </div>
		        </form>
             </div>
        </div>
        <div class="col-xl-2 col-lg-2 col-md-2 mb-4">
            <a class="btn btn-info" href="{{ url('/write/forum') }}">Start a Discussion</a>
            <div class="my-4 p-3 bg-white shadow-light">

                <h6>Most Viewed</h6>
                <div class="media text-muted pt-3">
                    <img data-src="holder.js/32x32?theme=thumb&amp;bg=007bff&amp;fg=007bff&amp;size=1" alt="32x32" class="mr-2 rounded" style="width: 32px; height: 32px;" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2232%22%20height%3D%2232%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2032%2032%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_16c6ca06b56%20text%20%7B%20fill%3A%23007bff%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A2pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_16c6ca06b56%22%3E%3Crect%20width%3D%2232%22%20height%3D%2232%22%20fill%3D%22%23007bff%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2211.828125%22%20y%3D%2216.965625%22%3E32x32%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true">
                    <p class="media-body pb-3 mb-0 medium lh-125 border-bottom border-gray">
                        <strong class="d-block text-gray-dark">@username</strong>
                        Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>
</div>
@endsection

@section('footer_scripts')
<script>
      (function () {

        var HomeBookApp = angular.module('HomeBookApp', ['angular.filter']);
        HomeBookApp.controller('HomeBookCtrl', function ($scope, $http, $sce) {


          });
      })();
  </script>

@stop
