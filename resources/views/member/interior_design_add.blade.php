@extends('layouts.backend.master')

@section('title', 'Add Interior Design')

@section('header_scripts')

@stop

@section('content')
<div ng-app="InteriordesignApp" ng-controller="InteriordesignCtrl as frm">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card bg-boxshadow mb-3">
                    <div class="card-body">
                        <h4 class="card-title">Add Interior Design</h4>

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

                        <div class="col-md-6 offset-md-3">
                            <form method="POST" action="{{ url('/interior-design/add') }}" autocomplete="off" accept-charset="utf-8" enctype="multipart/form-data">
                                {!! csrf_field() !!}
                                
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Name" @if(!empty($user->first_name) || !empty($user->last_name)) value="{{ $user->first_name.' '.$user->middle_name.' '.$user->last_name.' '.$user->suffix }}" readonly @endif required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" name="email" placeholder="Email" @if(!empty($user->email)) value="{{ $user->email }}" readonly @endif required>
                                </div>
                                <div class="form-group">
                                    <label for="mobile">Mobile #</label>
                                    <input type="text" class="form-control" name="mobile" placeholder="Contact" @if(!empty($user->mobile)) value="{{ $user->mobile }}" @endif required>
                                </div>
                                <div class="form-group">
                                    <label for="property_type">Property Type</label>
                                    <select class="form-control" name="property_type" required>
                                        <option value="" selected disabled>Choose</option>
                                        <option value="Condo">Condo</option>
                                        <option value="House & Lot">House & Lot</option>
                                        <option value="Lot Only">Lot Only</option>
                                        <option value="Commercial/Office">Commercial/Office</option>
                                    </select>
                                </div>
                                <button type="submit" id="add_interior_btn" class="btn btn-primary mt-30" type="submit">Add Interior Design</button>
                            </form>
                        </div>
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
        var InteriordesignApp = angular.module('InteriordesignApp', ['angular.filter']);
        InteriordesignApp.controller('InteriordesignCtrl', function ($scope, $http, $sce) {
            
            var vm = this;

        });
    })();
</script>
@stop