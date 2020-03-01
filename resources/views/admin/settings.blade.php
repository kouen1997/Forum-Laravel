@extends('layouts.master')

@section('title', 'Settings')

@section('header_scripts')

@stop

@section('content')
<div ng-app="settingsApp" ng-controller="settingsCtrl as frm">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item active">Settings</li>
    </ol>
    <h1 class="page-header">Settings</h1>
    <div class="panel">
        <div class="panel-body">
            <div class="card card-topline-aqua">
                <div class="card-body no-padding">
                    <form class="ng-pristine ng-valid-email ng-invalid ng-invalid-required" name="settingsFrm" ng-submit="frm.submitSettings(settingsFrm.$valid)" autocomplete="off">
                        <div class="row p-4">
                            <div class="form-group col-md-3">
                                <label for="input-normal">Buy Codes</label><br>
                                <select name="buy_code" id="buy_code" ng-model="frm.buy_code" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" ng-init="frm.buy_code='{{getSettings('buy_code')}}'" required="">
                                    <option ng-selected="{{getSettings('buy_code')}}==false" value="false">DISABLED</option>
                                    <option ng-selected="{{getSettings('buy_code')}}==true" value="true">ENABLED</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="input-normal">Activation</label><br>
                                <select name="activation" id="activation" ng-model="frm.activation" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" ng-init="frm.activation='{{getSettings('activation')}}'" required="">
                                    <option ng-selected="{{getSettings('activation')}}==false" value="false">DISABLED</option>
                                    <option ng-selected="{{getSettings('activation')}}==true" value="true">ENABLED</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="input-normal">Eloading</label><br>
                                <select name="eloading" id="eloading" ng-model="frm.eloading" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" ng-init="frm.eloading='{{getSettings('eloading')}}'" required="">
                                    <option ng-selected="{{getSettings('eloading')}}==false" value="false">DISABLED</option>
                                    <option ng-selected="{{getSettings('eloading')}}==true" value="true">ENABLED</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="input-normal">KYC</label><br>
                                <select name="kyc" id="kyc" ng-model="frm.kyc" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" ng-init="frm.kyc='{{getSettings('kyc')}}'" required="">
                                    <option ng-selected="{{getSettings('kyc')}}==false" value="false">DISABLED</option>
                                    <option ng-selected="{{getSettings('kyc')}}==true" value="true">ENABLED</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="input-normal">BDO Encashment</label><br>
                                <select name="bdo_payout" id="bdo_payout" ng-model="frm.bdo_payout" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" ng-init="frm.bdo_payout='{{getSettings('bdo_payout')}}'" required="">
                                    <option ng-selected="{{getSettings('bdo_payout')}}==false" value="false">DISABLED</option>
                                    <option ng-selected="{{getSettings('bdo_payout')}}==true" value="true">ENABLED</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="input-normal">CTBC Encashment</label><br>
                                <select name="ctbc_payout" id="ctbc_payout" ng-model="frm.ctbc_payout" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" ng-init="frm.ctbc_payout='{{getSettings('ctbc_payout')}}'" required="">
                                    <option ng-selected="{{getSettings('ctbc_payout')}}==false" value="false">DISABLED</option>
                                    <option ng-selected="{{getSettings('ctbc_payout')}}==true" value="true">ENABLED</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="input-normal">Yazz Encashment</label><br>
                                <select name="yazz_payout" id="yazz_payout" ng-model="frm.yazz_payout" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" ng-init="frm.yazz_payout='{{getSettings('yazz_payout')}}'" required="">
                                    <option ng-selected="{{getSettings('yazz_payout')}}==false" value="false">DISABLED</option>
                                    <option ng-selected="{{getSettings('yazz_payout')}}==true" value="true">ENABLED</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="input-normal">Truemoney Encashment</label><br>
                                <select name="truemoney_payout" id="truemoney_payout" ng-model="frm.truemoney_payout" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" ng-init="frm.truemoney_payout='{{getSettings('truemoney_payout')}}'" required="">
                                    <option ng-selected="{{getSettings('truemoney_payout')}}==false" value="false">DISABLED</option>
                                    <option ng-selected="{{getSettings('truemoney_payout')}}==true" value="true">ENABLED</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="input-normal">Paypal Encashment</label><br>
                                <select name="paypal_payout" id="paypal_payout" ng-model="frm.paypal_payout" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" ng-init="frm.paypal_payout='{{getSettings('paypal_payout')}}'" required="">
                                    <option ng-selected="{{getSettings('paypal_payout')}}==false" value="false">DISABLED</option>
                                    <option ng-selected="{{getSettings('paypal_payout')}}==true" value="true">ENABLED</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="input-normal">Remittance Encashment</label><br>
                                <select name="remittance_payout" id="remittance_payout" ng-model="frm.remittance_payout" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" ng-init="frm.remittance_payout='{{getSettings('remittance_payout')}}'" required="">
                                    <option ng-selected="{{getSettings('remittance_payout')}}==false" value="false">DISABLED</option>
                                    <option ng-selected="{{getSettings('remittance_payout')}}==true" value="true">ENABLED</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="input-normal">Dealer Encashment</label><br>
                                <select name="dealer_payout" id="dealer_payout" ng-model="frm.dealer_payout" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" ng-init="frm.dealer_payout='{{getSettings('dealer_payout')}}'" required="">
                                    <option ng-selected="{{getSettings('dealer_payout')}}==false" value="false">DISABLED</option>
                                    <option ng-selected="{{getSettings('dealer_payout')}}==true" value="true">ENABLED</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="input-normal">OFW Dealer Encashment</label><br>
                                <select name="ofw_dealer_payout" id="ofw_dealer_payout" ng-model="frm.ofw_dealer_payout" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" ng-init="frm.ofw_dealer_payout='{{getSettings('ofw_dealer_payout')}}'" required="">
                                    <option ng-selected="{{getSettings('ofw_dealer_payout')}}==false" value="false">DISABLED</option>
                                    <option ng-selected="{{getSettings('ofw_dealer_payout')}}==true" value="true">ENABLED</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="input-normal">Minimum Encashment</label><br>
                                <input type="text" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" name="minimum_encashment" ng-model="frm.minimum_encashment" ng-init="frm.minimum_encashment='{{getSettings('minimum_encashment')}}'"  required="">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="input-normal">Move to Wallet</label><br>
                                <input type="text" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" name="move_to_wallet" ng-model="frm.move_to_wallet" ng-init="frm.move_to_wallet='{{getSettings('move_to_wallet')}}'"  required="">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="input-normal">Ads Profit</label><br>
                                <input type="text" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" name="ads_profit" ng-model="frm.ads_profit" ng-init="frm.ads_profit='{{getSettings('ads_profit')}}'"  required="">
                            </div>
                            <div class="form-group col-md-12 m-t-15 text-center">
                                <button type="submit" id="settings_btn" class="btn btn-danger">
                                    Save     
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>             
</div>

@endsection

@section('footer_scripts')
<script type="text/javascript">
    (function () {
        var settingsApp = angular.module('settingsApp', ['angular.filter']);
        settingsApp.controller('settingsCtrl', function ($scope, $http, $sce) {
     
            var vm = this;

            vm.submitSettings = function () {

                $('#settings_btn').prop('disabled', true);
                $('#settings_btn').html('Saving <i class="fa fa-spinner fa-spin"></i>');

                $http({
                    method: 'POST',
                    url: '/admin/settings',
                    data: JSON.stringify({
                        buy_code: vm.buy_code,
                        activation: vm.activation,
                        eloading: vm.eloading,
                        kyc: vm.kyc,
                        bdo_payout: vm.bdo_payout,
                        ctbc_payout: vm.ctbc_payout,
                        yazz_payout: vm.yazz_payout,
                        truemoney_payout: vm.truemoney_payout,
                        paypal_payout: vm.paypal_payout,
                        remittance_payout: vm.remittance_payout,
                        dealer_payout: vm.dealer_payout,
                        ofw_dealer_payout: vm.ofw_dealer_payout,
                        minimum_encashment: vm.minimum_encashment,
                        move_to_wallet: vm.move_to_wallet,
                        ads_profit: vm.ads_profit
                    })
                }).success(function (data) {
                    $('#settings_btn').prop('disabled', false);
                    $('#settings_btn').html('Save');
                    if (data.result == 1){

                        toastr.info(data.message);

                    } else {
                        toastr.info("Something went wrong. Please try again!");
                    }
                }).error(function (data) {

                    $('#settings_btn').prop('disabled', false);
                    $('#settings_btn').html('Save');

                    if(data.result == 0){

                        toastr.info(data.message);

                    } else {
                        
                        angular.forEach(data.errors, function(message, key){

                            toastr.warning(message);

                        });
                    }
                });
               
            };

        });

    })();

</script>

@stop