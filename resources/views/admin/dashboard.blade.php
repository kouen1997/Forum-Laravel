@extends('layouts.backend.master')

@section('title', 'Dashboard')

@section('content')
<div ng-app="dashboardApp" ng-controller="DashboardCtrl as frm">
	
    @if(Auth::user()->id == 1)
    <div class="container-fluid">

        <div class="row align-items-center">
            <div class="col-6">
                <div class="dashboard-header-title mb-3">
                    <h6 class="mb-0">Admin Dashboard</h6>
                </div>
            </div>
            <div class="col-6">
                <div class="dashboard-infor-mation d-flex flex-wrap align-items-center mb-3">
                    <div class="dashboard-clock">
                        <div id="dashboardDate"></div>
                        <ul class="d-flex align-items-center justify-content-end">
                            <li id="hours"></li>
                            <li>:</li>
                            <li id="min"></li>
                            <li>:</li>
                            <li id="sec"></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-sm-12 col-xl-12 mb-3">
                <!-- Widget Content -->
                <div class="card widget-new-content p-3 bg-white bg-boxshadow full-height">
                    <!-- Widget Stats -->
                    <div class="widget---stats d-flex align-items-center mb-15">
                        <div class="widget---content-text">
                            <h6>Members</h6>
                            <p class="mb-0">&nbsp;</p>
                        </div>
                        <h6 class="mb-0 text-dark"><span ng-bind="data.total_users | number:0">0</span></h6>
                    </div>
                    <div class="progress h-5">
                        <div class="progress-bar w-100 bg-dark" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('footer_scripts')
<script type="text/javascript">
  	(function () {
        var dashboardApp = angular.module('dashboardApp', ['angular.filter']);
        dashboardApp.controller('DashboardCtrl', function ($scope, $http, $sce) {
            $http.get('/admin-data').success(function (data) {
                $scope.data = data;
            });
        });
    })();
</script>
@stop