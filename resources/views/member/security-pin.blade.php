@extends('layouts.backend.master')

@section('title', 'Security Pin')

@section('header_scripts')
@stop

@section('content')
<div ng-app="securityApp" ng-controller="securityCtrl as frm">
    <div class="col-12 mb-3">
        <div class="card bg-boxshadow full-height">
            <div class="card-body">
                <h4 class="card-title">Pin</h4>
                <form class="ng-pristine ng-valid-email ng-invalid ng-invalid-required" name="savePinFrm" ng-submit="frm.savePin(savePinFrm.$valid)" autocomplete="off">
                    <p class="lead semi-bold m-b-15">please double check before saving, maximum of 2 changes. (<span class="text-danger">{{3 - $user->pin_attempt}} changes remaining</span>)</p>
                    <hr>
                    <div class="form-group m-b-15">
                        <label for="currentPassword">Current Password<span class="text-danger">*</span></label>
                        <input type="password" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" name="current_password" ng-model="frm.current_password" placeholder="Current password" required>
                    </div>
                    <div class="form-group m-b-15">
                        <label for="usernameOremail">New Security Pin <span class="text-danger">*</span></label>
                        <input type="text" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" name="pin" ng-model="frm.pin" placeholder="New security pin" required>
                    </div>
                    <div class="form-group m-b-15">
                        <label for="quantity">Confirm Security Pin <span class="text-danger">*</span></label>
                        <input type="text" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" name="pin_confirmation" ng-model="frm.pin_confirmation" placeholder="Confirm security pin" required>
                    </div>
                    @if($user->pin_attempt <= 2)
                    <button type="submit" ng-disabled="savePinFrm.$invalid" id="save_pin_btn" class="btn btn-md btn-danger m-r-5 m-b-15">Save</button>
                    @endif
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

            vm.savePin = function () {

                $http({
                method: 'POST',
                url: '/security/pin',
                data: JSON.stringify({
                    current_password: vm.current_password,
                    pin: vm.pin,
                    pin_confirmation: vm.pin_confirmation
                })
                }).success(function (data) {
                if (data.result==1){
                    alert(data.message);
                    setTimeout('window.location.reload();', 1000);
                }
                }).error(function (data) {

                if(data.result == 0){

                    alert(data.message);

                    setTimeout('window.location.reload();', 1000);

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