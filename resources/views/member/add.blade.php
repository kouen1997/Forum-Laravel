@extends('layouts.backend.master')

@section('title', 'Add Account')

@section('header_scripts')
@stop

@section('content')
<div ng-app="addAccountApp" ng-controller="AddAccountCtrl as frm">
    <div class="col-12 mb-3">
        <div class="card bg-boxshadow full-height">
            <div class="card-body">
                <h4 class="card-title">Add account</h4>
                <form class="ng-pristine ng-valid-email ng-invalid ng-invalid-required" name="addAccountFrm" ng-submit="frm.submitAddAccount(addAccountFrm.$valid)" autocomplete="off">
                    <p class="lead semi-bold m-b-15">please double check before adding</p>
                    <hr>
                    <div class="row row-space-10">
                        <div class="col-md-6">
                            <div class="form-group m-b-10">
                                <label>Activation Code <span class="text-danger">*</span></label>
                                <select name="activation_code" id="activation_code" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" ng-model="frm.activation_code" required>
                                    <option disabled selected>Choose your code</option>
                                    <option ng-repeat="code in data.codes" ng-value="code.code">@{{code.code}}</option>
                                </select>
                            </div>
                            <div class="form-group m-b-10">
                                <label>Account name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" name="account_name" placeholder="Auto generate account name base on username" readonly required>
                            </div>
                            <div class="form-group m-b-10">
                                <label>HomeBook ID # <span class="text-danger">*</span></label>
                                <input type="text" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" name="placement" ng-model="frm.placement" placeholder="Placement account name (from your sponsor)" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group m-b-10">
                                <label>No. of Package <span class="text-danger">*</span></label>
                                <select name="account_qty" ng-model="frm.account_qty" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" required>
                                    <option value="1" selected>1 - (Premium Bronze)</option>
                                    <option value="7">7  - (Premium Silver)</option>
                                </select>
                            </div>
                            <div class="form-group m-b-10">
                                <label>Position <span class="text-danger">*</span></label>
                                <select name="position" ng-model="frm.position" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" required>
                                    <option value="LEFT">Left</option>
                                    <option value="RIGHT">Right</option>
                                </select>
                            </div>
                            <div class="form-group m-b-20">
                                <label>Security Pin <span class="text-danger">*</span></label>
                                <input type="text" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" name="pin" ng-model="frm.pin" maxlength="6" placeholder="Security Pin" required>
                            </div>
                        </div>
                    </div>
                    @if($user->account()->count() < 15 )
                        <?php
                            $settings = getSettings('activation');
                        ?>
                        @if($settings == "true")
                            <button type="submit" ng-disabled="addAccountFrm.$invalid" id="add_account_btn" class="btn btn-md btn-primary m-r-5 m-b-15">Add</button>
                        @else
                            <button type="button" class="btn btn-block btn-warning" data-toggle="tooltip" data-placement="top" data-original-title="Account activation is not available at this moment, Check again later." >Unavailable</button>
                        @endif
                    @else
                    <p class="lead">
                        You have the highest package(15 packages).
                    </p>
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

        var addAccountApp = angular.module('addAccountApp', ['angular.filter']);
        addAccountApp.controller('AddAccountCtrl', function ($scope, $http, $sce) {

            var vm = this;

            $http.get('/account/accounts-data').success(function (data) {
                $scope.data = data;
            });

            vm.submitAddAccount = function () {

                $('#add_account_btn').prop('disabled', true);

                $http({
                    method: 'POST',
                    url: '/account/activation',
                    data: JSON.stringify({
                       activation_code: vm.activation_code,
                       account_qty: vm.account_qty,
                       placement: vm.placement,
                       position: vm.position,
                       pin: vm.pin
                    })
                }).success(function (data) {
                    if (data.result==1){

                        alert(data.message);

                        setTimeout(window.location.href = '/listing', 10000);

                        ;
                    }else{
                    
                    }
                }).error(function (data) {

                $('#add_account_btn').prop('disabled', false);

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