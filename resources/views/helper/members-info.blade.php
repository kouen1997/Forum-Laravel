@extends('layouts.backend.master')

@section('title', 'Member Profile | Helper')

@section('content')
<div ng-app="dashboardApp" ng-controller="DashboardCtrl as frm">
  <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>
      <li class="breadcrumb-item active">Member Profile</li>
  </ol>
  <h1 class="page-header">{{ $user->first_name.' '.$user->last_name }}'s Profile</h1>
  <div class="profile">
    <div class="profile-header">
      <div class="profile-header-cover"></div>
      <div class="profile-header-content">
        <div class="profile-header-img">
          <img src="{{ URL::asset('theme/v1/img/user/ecomnnect-logo-3.png') }}" alt="ecomnnect">
        </div>
        <div class="profile-header-info">
          <h4 class="m-t-10 m-b-5">{{ $user->first_name." ".$user->last_name }}</h4>
          <p class="m-b-10">{{ $user->username }}</p>
          @if($user->active ==1)
            @if($user->paid_account->count() < 7 && $user->paid_account->count() >= 1)
            <a href="#" class="btn btn-xs btn-lime">PREMIUM BRONZE</a>
            @elseif($user->paid_account->count() >= 7 && $user->paid_account->count() < 15)
            <a href="#" class="btn btn-xs btn-lime">PREMIUM SILVER</a>
            @elseif($user->paid_account->count() == 15)
            <a href="#" class="btn btn-xs btn-lime">PREMIUM GOLD</a>
            @endif
          @else
            <a href="#" class="btn btn-xs btn-danger">FREE</a>
          @endif
        </div>
      </div>
      <ul class="profile-header-tab nav nav-tabs">
        <li class="nav-item"><a href="#profile-about" class="nav-link active" data-toggle="tab">ABOUT</a></li>
        <li class="nav-item"><a href="#profile-update" class="nav-link" data-toggle="tab">UPDATE</a></li>
        <li class="nav-item"><a href="#profile-yazz" class="nav-link" data-toggle="tab">YAZZ CARD</a></li>
        <li class="nav-item"><a href="#profile-password" class="nav-link" data-toggle="tab">PASSWORD</a></li>
        <li class="nav-item"><a href="#profile-pin" class="nav-link" data-toggle="tab">PIN</a></li>
        @if($user->bdo)
        <li class="nav-item"><a href="#profile-bdo" class="nav-link" data-toggle="tab">BDO CHANGE ATTEMPT</a></li>
        @endif
      </ul>
      <!-- END profile-header-tab -->
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="profile-content">
          <div class="tab-content p-0">
            <div class="tab-pane fade show active" id="profile-about">
              <div class="table-responsive">
                <table class="table table-profile">
                  <thead>
                    <tr>
                      <th></th>
                      <th>
                        <h3>About</h3>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="highlight">
                      <td class="field">Referral Link</td>
                      <td><a href="#">{{ url('/?r=').$user->username }}</a></td>
                    </tr>
                    <tr class="divider">
                      <td colspan="2"></td>
                    </tr>
                    <tr>
                      <td class="field">Mobile</td>
                      <td><i class="fa fa-mobile fa-lg m-r-5"></i> {{ $user->mobile && $user->mobile !== NULL ? $user->mobile : 'none' }}</td>
                    </tr>
                    <tr>
                      <td class="field">Email</td>
                      <td><a href="#">{{ $user->email }}</a></td>
                    </tr>
                    <tr class="highlight">
                      <td class="field">My Accounts</td>
                      <td>{{ $user->account()->count() }}</td>
                    </tr>
                    <tr class="divider">
                      <td colspan="2"></td>
                    </tr>
                    <tr>
                      <td class="field">My Codes</td>
                      <td>{{ $user->code()->where('status','UNUSED')->count() }}</td>
                    </tr>
                    <tr>
                      <td class="field">My Referrals</td>
                      <td>{{ $user->sponsored()->count() }}</td>
                    </tr>
                    <tr>
                      <td class="field">Mobile no.</td>
                      <td>
                        {{ $user->mobile && $user->mobile !== NULL ? $user->mobile : '' }}
                      </td>
                    </tr>
                    <tr>
                      <td class="field">Birthdate</td>
                      <td>
                        {{ date('F j, Y', strtotime($user->birth_date)) }}
                      </td>
                    </tr>
                    <tr class="divider">
                      <td colspan="2"></td>
                    </tr>
                    <tr class="highlight">
                      <td class="field">&nbsp;</td>
                      <td class="p-t-10 p-b-10">
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="tab-pane fade" id="profile-update">
              <form class="ng-pristine ng-valid-email ng-invalid ng-invalid-required" name="updateInfoFrm" ng-submit="frm.updateInfo(updateInfoFrm.$valid)" autocomplete="off">
                <input type="hidden" name="user_id" value="{{$user->id}}">
                <div class="row p-4 m-t-15">
                  <div class="col-md-4">
                    <div class="form-group">
                        <label>First Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="First Name" name="first_name" id="first_name" ng-model="frm.first_name" ng-init="frm.first_name='{{ $user->first_name }}'" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                        <label>Middle Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Middle Name" name="middle_name" id="middle_name" ng-model="frm.middle_name" ng-init="frm.middle_name='{{ $user->middle_name }}'" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                        <label>Last Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Last Name" name="last_name" id="last_name" ng-model="frm.last_name" ng-init="frm.last_name='{{ $user->last_name }}'" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Email Address <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" placeholder="Email Address" name="email" id="email" ng-model="frm.email" ng-init="frm.email='{{ $user->email }}'" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Mobile Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Mobile Number" name="mobile" id="mobile" ng-model="frm.mobile" ng-init="frm.mobile='{{ $user->mobile }}'" required>
                    </div>
                  </div>
                  <div class="col-md-6 offset-md-3">
                    <div class="form-group">
                        <label>Birthdate <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" placeholder="Birthday" name="birth_date" format="mm-dd-yyyy" id="birth_date" ng-model="frm.birth_date" ng-init="frm.birth_date=birth_date" required >
                    </div>
                  </div>
                  <div class="col-md-12 m-t-15 text-center">
                    <button type="submit" ng-disabled="updateInfoFrm.$invalid" id="update_info_btn" class="btn btn-danger">Update</button>
                  </div>
                </div>
              </form>
            </div>
            <div class="tab-pane fade" id="profile-yazz">
              <form class="ng-pristine ng-valid-email ng-invalid ng-invalid-required" name="yazzAccountFrm" ng-submit="frm.yazzAccount(yazzAccountFrm.$valid)" autocomplete="off">
                <div class="row p-4">
                  <div class="col-md-12 text-center">
                    <div class="alert alert-warning">
                        <strong>Note:</strong> If YAZZ CARD will not be shipped, set <em>CARD PAYMENT</em> and <em>SHIPPING COST</em> as 0.
                    </div>
                  </div>
                  <div class="form-group col-md-6 offset-md-3 ">
                      <label for="input-normal">YAZZ Card Number <span class="text-danger">*</span></label>
                      <input type="text" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" name="card_number" ng-model="frm.card_number" ng-init="frm.card_number='{{$user->yazz->card_number}}'" placeholder="E.g. 521090575564952">
                  </div>
                  <div class="form-group col-md-6 offset-md-3">
                      <label for="input-normal">Card Payment</label>
                      <input type="number" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" name="card_payment" ng-model="frm.card_payment" ng-init="frm.card_payment=0">
                  </div>
                  <div class="form-group col-md-6 offset-md-3">
                      <label for="input-normal">Shipping Cost</label>
                      <input type="number" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" name="shipping_cost" ng-model="frm.shipping_cost" ng-init="frm.shipping_cost=0">
                  </div>
                  <div class="col-md-12 m-t-15 text-center">
                  @if($user->suspended == 0)
                    <button type="submit" ng-disabled="!frm.card_number" id="yazz_account_btn" class="btn btn-danger">Save</button> 
                  @else
                    <strong class="text-danger">Account is currently on hold.</strong>
                  @endif
                  </div>
                </div>
              </form>
            </div>
            <div class="tab-pane fade" id="profile-password">
              <form class="ng-pristine ng-valid-email ng-invalid ng-invalid-required" name="changePasswordFrm" ng-submit="frm.changePassword(changePasswordFrm.$valid)" autocomplete="off">
                <div class="row p-4">
                  <div class="col-md-6 offset-md-3">
                    <div class="form-group">
                        <label>New Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" placeholder="New Password" name="password" id="password" ng-model="frm.password" required>
                    </div>
                  </div>
                  <div class="col-md-6 offset-md-3">
                    <div class="form-group">
                        <label>Confirm New Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" placeholder="Confirm New Password" name="password_confirmation" id="password_confirmation" ng-model="frm.password_confirmation" required>
                    </div>
                  </div>
                  <div class="col-md-12 m-t-15 text-center">
                    <button type="submit" ng-disabled="changePasswordFrm.$invalid" id="save_password_btn" class="btn btn-danger">Save</button>
                  </div>
                </div>
              </form>
            </div>
            <div class="tab-pane fade" id="profile-pin">
              <form class="ng-pristine ng-valid-email ng-invalid ng-invalid-required" name="savePinFrm" ng-submit="frm.changePin(savePinFrm.$valid)" autocomplete="off">
                <div class="row p-4">
                  <div class="col-md-6 offset-md-3">
                    <div class="form-group">
                        <label>New Security Pin <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="New Security Pin" name="pin" id="pin" ng-model="frm.pin" required>
                    </div>
                  </div>
                  <div class="col-md-6 offset-md-3">
                    <div class="form-group">
                        <label>Confirm New Security Pin <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Confirm New Security Pin" name="pin_confirmation" id="pin_confirmation" ng-model="frm.pin_confirmation" required>
                    </div>
                  </div>
                  <div class="col-md-12 m-t-15 text-center">
                    <button type="submit" ng-disabled="savePinFrm.$invalid" id="save_pin_btn" class="btn btn-danger">Save</button>
                  </div>
                </div>
              </form>
            </div>
            @if($user->bdo)
            <div class="tab-pane fade" id="profile-bdo">
              <form class="ng-pristine ng-valid-email ng-invalid ng-invalid-required" name="changeMaxAttemptFrm" ng-submit="frm.changeMaxAttempt(changeMaxAttemptFrm.$valid)" autocomplete="off">
                <div class="row p-4">
                  <div class="col-md-12 text-center">
                    <div class="alert alert-warning">
                      <strong>Note:</strong> Max attempt is 3, <em>REDUCE</em> the max attempt to be able to edit the bdo account again.
                    </div>
                  </div>
                  <div class="col-md-6 offset-md-3">
                    <div class="form-group">
                        <label>Max Attempt</label>
                        <input type="number" class="form-control" placeholder="Attempt" name="max_attempt" id="max_attempt" ng-model="frm.max_attempt" ng-init="frm.max_attempt={{ $user->bdo->attempt }}" required>
                    </div>
                  </div>
                  <div class="col-md-12 m-t-15 text-center">
                    <button type="submit" ng-disabled="changeMaxAttemptFrm.$invalid" id="max_attempt_btn" class="btn btn-danger">Save</button>
                  </div>
                </div>
              </form>
            </div>
            @endif
          </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('footer_scripts')
<script type="text/javascript">
    (function () {
        var dashboardApp = angular.module('dashboardApp', ['angular.filter']);
        dashboardApp.controller('DashboardCtrl', function ($scope, $http, $sce) {

            var vm = this;

            var user_id = '{{$user->id}}';

            $scope.birth_date = new Date("{{$user->birth_date}}");

            $http.get('/helper/members/'+user_id+'/data').success(function (data) {
   
              $scope.data = data;

            });

            vm.updateInfo = function () {

              $http({
                    method: 'POST',
                    url: '/helper/members/'+user_id+'/profile',
                    data: JSON.stringify({
                       first_name: vm.first_name,
                       middle_name: vm.middle_name,
                       last_name: vm.last_name,
                       email: vm.email,
                       mobile: vm.mobile,
                       birth_date: vm.birth_date
                    })
                }).success(function (data) {
                    if (data.result==1){

                        toastr.info(data.message);
                    }
                }).error(function (data) {

                  if(data.result == 0){

                    toastr.info(data.message);

                    } else {

                      angular.forEach(data.errors, function(message, key){

                        toastr.warning(message);

                      });
                    }
                });
               
            };

            vm.changePassword = function () {

              $http({
                    method: 'POST',
                    url: '/helper/members/'+user_id+'/password',
                    data: JSON.stringify({
                       password: vm.password,
                       password_confirmation: vm.password_confirmation
                    })
                }).success(function (data) {
                    if (data.result==1){

                        toastr.info(data.message);
                    }
                }).error(function (data) {

                  if(data.result == 0){

                    toastr.info(data.message);

                    } else {

                      angular.forEach(data.errors, function(message, key){

                        toastr.warning(message);

                      });
                    }
                });
               
            };

            vm.changePin = function () {

              $http({
                    method: 'POST',
                    url: '/helper/members/'+user_id+'/pin',
                    data: JSON.stringify({
                       pin: vm.pin,
                       pin_confirmation: vm.pin_confirmation
                    })
                }).success(function (data) {
                    if (data.result==1){

                        toastr.info(data.message);
                    }
                }).error(function (data) {

                  if(data.result == 0){

                    toastr.info(data.message);

                    } else {

                      angular.forEach(data.errors, function(message, key){

                        toastr.warning(message);

                      });
                    }
                });
               
            };

            vm.yazzAccount = function () {

              $http({
                    method: 'POST',
                    url: '/helper/members/'+user_id+'/yazz_account',
                    data: JSON.stringify({
                       card_number: vm.card_number,
                       card_payment: vm.card_payment,
                       shipping_cost: vm.shipping_cost

                    })
                }).success(function (data) {
                    if (data.result==1){

                        toastr.info(data.message);
                    }
                }).error(function (data) {

                  if(data.result == 0){

                    toastr.warning(data.message);

                    } else {

                      angular.forEach(data.errors, function(message, key){

                        toastr.warning(message);

                      });
                    }
                });
               
            };

            vm.changeMaxAttempt = function () {

              $http({
                    method: 'POST',
                    url: '/helper/members/'+user_id+'/bdo_attempt',
                    data: JSON.stringify({
                       max_attempt: vm.max_attempt
                    })
                }).success(function (data) {
                    if (data.result==1){

                        toastr.info(data.message);
                    }
                }).error(function (data) {

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