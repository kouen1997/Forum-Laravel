@extends('layouts.backend.master')

@section('title', 'Transfer Codes')

@section('header_scripts')
<link href="{{ URL::asset('assets/plugins/sweet-alert/sweetalert.min.css') }}" rel="stylesheet">
@stop

@section('content')
<div ng-app="transferCodesApp" ng-controller="transferCodesCtrl as frm">
    <div class="col-12 mb-3">
        <div class="card bg-boxshadow full-height">
            <div class="card-body">
                <h4 class="card-title">Transfer Codes</h4>
                <form class="ng-pristine ng-valid-email ng-invalid ng-invalid-required" name="transferCodeFrm" ng-submit="frm.submitTransferCode(transferCodeFrm.$valid)" autocomplete="off">
                    <legend class="m-b-25">please double check before transfer</legend>
                    <div class="form-group m-b-15">
                        <label for="codeType">Code Type <span class="text-danger">*</span></label>
                        <select name="code_type" ng-model="frm.code_type" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" required>
                            <option value="PAID" selected>PAID</option>
                            <option value="FREE">FREE</option>
                        </select>
                    </div>
                    <div class="form-group m-b-15">
                        <label for="usernameOremail">Username or Email address <span class="text-danger">*</span></label>
                        <input type="text" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" name="username" ng-model="frm.username" required>
                    </div>
                    <div class="form-group m-b-15">
                        <label for="quantity">Quantity <span class="text-danger">*</span></label>
                        <select name="quantity" ng-model="frm.quantity" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" required="">
                        @for($x=1; $x < 301; $x++)
                            <option value="{{ $x}}">{{ $x}}</option>
                        @endfor
                        </select>
                    </div>
                    <div class="form-group m-b-15">
                        <label for="pin">Security Pin <span class="text-danger">*</span></label>
                        <input type="text" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" name="pin" ng-model="frm.pin" maxlength="6" required>
                    </div>
                    <button type="submit" ng-disabled="transferCodeFrm.$invalid" id="transfer_code_btn" class="btn btn-md btn-primary m-r-5 m-b-15">Transfer</button>
                </form>
            </div>
        </div>
    </div>    
</div>
@endsection

@section('footer_scripts')
<script src="{{ URL::asset('assets/plugins/sweet-alert/sweetalert.min.js') }}"></script>
<script type="text/javascript">
	(function () {

        var transferCodesApp = angular.module('transferCodesApp', ['angular.filter']);
        transferCodesApp.controller('transferCodesCtrl', function ($scope, $http, $sce) {

            var vm = this;

            vm.submitTransferCode = function () {
                console.log(vm.code_type);

                swal({
                    title: "Are you sure want to transfer this code?",
                    type: "warning",
                    html: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    showCancelButton: true,
                },
                function() {

                    $scope.btndisabled = true;
                        $("#transfer_code_btn").hide();

                        $http({
                            method: 'POST',
                            url: '/transfer-codes',
                            data: JSON.stringify({
                                code_type: vm.code_type,
                                username: vm.username,
                                quantity: vm.quantity,
                                pin: vm.pin
                            })
                        }).success(function (data) {
                            if (data.result==1){

                                alert(data.message);

                                setTimeout(window.location.href = '/transfer-codes', 10000);
                            } else {
                                $("#transfer_code_btn").show();
                                $scope.btndisabled = false;
                                alert(data.message);
                            
                            }
                        }).error(function (data) {

                            $("#transfer_code_btn").show();
                            $scope.btndisabled = false;

                            if(data.result == 0){

                                alert(data.message);

                            } else {
                                
                                angular.forEach(data.errors, function(message, key){

                                    alert(message);

                                });
                            }
                        });
                });
            
            };

        });
    })();

</script>

@stop