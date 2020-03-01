@extends('layouts.backend.master')

@section('title', 'Generate')

@section('content')
<div ng-app="generateCodeApp" ng-controller="generateCodeCtrl as frm">
    <div class="col-12 mb-3">
        <div class="card bg-boxshadow full-height">
            <div class="card-body">
                <h4 class="card-title">Generate Codes</h4>
                <form class="ng-pristine ng-valid-email ng-invalid ng-invalid-required" name="generateCodesFrm" ng-submit="frm.generateCodes(generateCodesFrm.$valid)" autocomplete="off">
                    <div class="col-md-6">
                        <div class="form-group m-b-10">
                            <label>Code Type<span class="text-danger">*</span></label>
                            <select name="code_type" ng-model="frm.code_type" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" required>
                                <option value="PAID" selected>PAID</option>
                                <option value="FREE">FREE</option>
                            </select>
                        </div>
                        <div class="form-group m-b-10">
                            <label>No. of codes to generate<span class="text-danger">*</span></label>
                            <select name="quantity" ng-model="frm.quantity" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" required>
                                <option value="100" selected>100</option>
                                <option value="300">300</option>
                                <option value="500">500</option>
                                <option value="1000">1000</option>
                                <option value="3000">3000</option>
                                <option value="5000">5000</option>
                                <option value="10000">10000</option>
                                <option value="20000">20000</option>
                                <option value="30000">30000</option>
                                <option value="50000">50000</option>
                                <option value="100000">100000</option>
                            </select>
                        </div>
                        <button type="submit" ng-disabled="generateCodesFrm.$invalid" id="generate_codes_btn" class="btn btn-danger">Generate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer_scripts')
<script>
    (function () {
        var generateCodeApp = angular.module('generateCodeApp', ['angular.filter']);
        generateCodeApp.controller('generateCodeCtrl', function ($scope, $http, $sce) {

            var vm = this;

            vm.generateCodes = function () {
               
                $('#generate_codes_btn').prop('disabled', true);
                $('#generate_codes_btn').html('Generating <i class="fa fa-spinner fa-spin"></i>');

                $http({
                    method: 'POST',
                    url: '/admin/generate-codes',
                    data: JSON.stringify({
                        code_type: vm.code_type,
                        quantity: vm.quantity
                    })
                }).success(function (data) {
                    $('#generate_codes_btn').prop('disabled', false);
                    $('#generate_codes_btn').html('Generate Codes');
                    if (data.result == 1){

                        alert(data.message);

                    } else {
                        alert("Something went wrong. Please try again!");
                    }
                }).error(function (data) {

                    $('#generate_codes_btn').prop('disabled', false);
                    $('#generate_codes_btn').html('Generate Codes');

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