@extends('layouts.backend.master')

@section('title', 'Password')

@section('header_scripts')
@stop

@section('content')
<div ng-app="securityApp" ng-controller="securityCtrl as frm">
    <div class="col-12 mb-3">
        <div class="card bg-boxshadow full-height">
            <div class="card-body">
                <h4 class="card-title">Password</h4>
                <form class="ng-pristine ng-valid-email ng-invalid ng-invalid-required" name="updatePasswordFrm" ng-submit="frm.updatePassword(updatePasswordFrm.$valid)" autocomplete="off">
                    <p class="lead semi-bold m-b-15">please double check before saving</p>
                    <hr>
                    <div class="form-group m-b-15">
                        <label for="currentPassword">Current Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" placeholder="Current Password" name="current_password" id="current_password" ng-model="frm.current_password" required>
                    </div>
                    <div class="form-group m-b-15">
                        <label for="usernameOremail">New Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" placeholder="New Password" name="password" id="password" ng-model="frm.password" required>
                    </div>
                    <div class="form-group m-b-15">
                        <label for="quantity">Confirm New Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" placeholder="Confirm New Password" name="password_confirmation" id="password_confirmation" ng-model="frm.password_confirmation" required>
                    </div>
                    <button type="submit" ng-disabled="updatePasswordFrm.$invalid" id="update_password_btn" class="btn btn-md btn-danger m-r-5 m-b-15">Update</button>
                </form>
            </div>
        </div>
    </div>    
</div>
@endsection

@section('footer_scripts')
<script type="text/javascript">
	(function () {

        var securityApp = angular.module('securityApp', ['angular.filter']);
        securityApp.controller('securityCtrl', function ($scope, $http, $sce) {

            var vm = this;

            vm.updatePassword = function () {

                $http({
                    method: 'POST',
                    url: '/security/password',
                    data: JSON.stringify({
                        current_password: vm.current_password,
                        password: vm.password,
                        password_confirmation: vm.password_confirmation
                    })
                }).success(function (data) {
                    if (data.result==1){
                        alert(data.message);
                        setTimeout('window.location.reload();', 1000);
                    }
                }).error(function (data) {

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