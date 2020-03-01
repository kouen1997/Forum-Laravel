@extends('layouts.backend.master')

@section('title', 'Edit Architectural Design')

@section('header_scripts')

@stop

@section('content')
<div ng-app="architecturaldesignApp" ng-controller="architecturaldesignCtrl as frm">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card bg-boxshadow mb-3">
                    <div class="card-body">
                        <h4 class="card-title">Edit Architectural Design</h4>

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
                            <form method="POST" action="{{ url('/edit/architectural_design') }}" autocomplete="off" accept-charset="utf-8" enctype="multipart/form-data" id="addForm">
                                {!! csrf_field() !!}
                                
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Name" @if(!empty($user->first_name) || !empty($user->last_name)) value="{{ $user->first_name.' '.$user->middle_name.' '.$user->last_name.' '.$user->suffix }}" readonly @endif required>

                                     <input type="hidden" class="form-control" name="id" placeholder="id" value="{{ $architectural_design->id }}">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" name="email" placeholder="Email" @if(!empty($user->email)) value="{{ $user->email }}" readonly @endif required>
                                </div>
                                <div class="form-group">
                                    <label for="mobile">Mobile #</label>
                                    <input type="text" class="form-control" name="mobile" placeholder="Contact" @if(!empty($architectural_design->contact)) value="{{ $architectural_design->contact }}" @endif required>
                                </div>
                                <div class="form-group">
                                    <label for="property_type">Property Type</label>
                                    <select class="form-control" name="property_type" required>
                                        <option value="" disabled>Choose</option>

                                        <option value="Condo" @if($architectural_design->property_type == "Condo") selected @endif>Condo</option>

                                        <option value="House & Lot" @if($architectural_design->property_type == "House & Lot") selected @endif>House & Lot</option>

                                        <option value="Lot Only" @if($architectural_design->property_type == "Lot Only") selected @endif>Lot Only</option>

                                        <option value="Commercial/Office" @if($architectural_design->property_type == "Commercial/Office") selected @endif>Commercial/Office</option>
                                    </select>
                                </div>
                                <button type="submit" id="edit_architectural_btn" class="btn btn-primary mt-30" type="submit">Edit Architectural Design</button>
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
        var architecturaldesignApp = angular.module('architecturaldesignApp', ['angular.filter']);
        architecturaldesignApp.controller('architecturaldesignCtrl', function ($scope, $http, $sce) {
            
            var vm = this;

            vm.EditArchitecturalDesign = function () {

                $('#edit_architectural_btn').prop('disabled', true);
                $('#edit_architectural_btn').html('Please wait... <i class="fa fa-spinner fa-spin"></i>');

                $http({
                    method: 'POST',
                    url: '/edit/architectural_design',
                    data: JSON.stringify({
                        id: vm.id,
                        mobile: vm.mobile,
                        property_type: vm.property_type
                    })
                }).success(function (data) {
                    if (data.result == 1){

                        alert(data.message);

                        setTimeout(window.location.href = '/architectural-design/add', 10000);

                    } else {

                        $('#edit_architectural_btn').prop('disabled', false);
                        $('#edit_architectural_btn').html('Add Architectural Design');
                        
                        alert(data.message);
                    }
                }).error(function (data) {

                    $('#edit_architectural_btn').prop('disabled', false);
                    $('#edit_architectural_btn').html('Add Architectural Design');

                    if(data.result == 0){

                        alert(data.message);

                    } else {
                        
                        angular.forEach(data.errors, function(message, key){

                            alert(message);

                        });
                    }
                });

            };
        });
    })();
</script>
@stop