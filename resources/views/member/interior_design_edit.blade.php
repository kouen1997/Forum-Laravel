@extends('layouts.backend.master')

@section('title', 'Edit Interior Design')

@section('header_scripts')

@stop

@section('content')
<div ng-app="InteriordesignApp" ng-controller="InteriordesignCtrl as frm">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card bg-boxshadow mb-3">
                    <div class="card-body">
                        <h4 class="card-title">Edit Interior Design</h4>

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
                            <form method="POST" action="{{ url('/interior-design/edit') }}" autocomplete="off" accept-charset="utf-8" enctype="multipart/form-data" id="addForm">
                                {!! csrf_field() !!}
                                
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Name" @if(!empty($user->first_name) || !empty($user->last_name)) value="{{ $user->first_name.' '.$user->middle_name.' '.$user->last_name.' '.$user->suffix }}" readonly @endif required>

                                    <input type="hidden" class="form-control" name="id" placeholder="id" value="{{ $interior_design->id }}">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" name="email" placeholder="Email" @if(!empty($user->email)) value="{{ $user->email }}" readonly @endif required>
                                </div>
                                <div class="form-group">
                                    <label for="mobile">Mobile #</label>
                                    <input type="text" class="form-control" name="mobile" placeholder="Contact" @if(!empty($interior_design->contact)) value="{{ $interior_design->contact }}" @endif required>
                                </div>
                                <div class="form-group">
                                    <label for="property_type">Property Type</label>
                                    <select class="form-control" name="property_type" required>
                                        <option value="" disabled>Choose</option>

                                        <option value="Condo" @if($interior_design->property_type == "Condo") selected @endif>Condo</option>

                                        <option value="House & Lot" @if($interior_design->property_type == "House & Lot") selected @endif>House & Lot</option>

                                        <option value="Lot Only" @if($interior_design->property_type == "Lot Only") selected @endif>Lot Only</option>

                                        <option value="Commercial/Office" @if($interior_design->property_type == "Commercial/Office") selected @endif>Commercial/Office</option>
                                    </select>
                                </div>
                                <button type="submit" id="edit_interior_btn" class="btn btn-primary mt-30" type="submit">Edit Interior Design</button>
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

            vm.editInteriorDesign = function () {

                $('#edit_interior_btn').prop('disabled', true);
                $('#edit_interior_btn').html('Please wait... <i class="fa fa-spinner fa-spin"></i>');

                $http({
                    method: 'POST',
                    url: '/interior-design/edit',
                    data: JSON.stringify({
                        id: vm.id,
                        mobile: vm.mobile,
                        property_type: vm.property_type,
                    })
                }).success(function (data) {
                    if (data.result == 1){

                        alert(data.message);

                        setTimeout(window.location.href = '/interior-design/add', 10000);

                    } else {

                        $('#edit_interior_btn').prop('disabled', false);
                        $('#edit_interior_btn').html('Add Interior Design');
                        
                        alert(data.message);
                    }
                }).error(function (data) {

                    $('#edit_interior_btn').prop('disabled', false);
                    $('#edit_interior_btn').html('Add Interior Design');

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