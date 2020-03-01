@extends('layouts.master')

@section('title', 'Order Dashboard')

@section('content')

<div ng-app="dashboardApp" ng-controller="DashboardCtrl as frm">
    <ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>
		<li class="breadcrumb-item active">Order Dashboard</li>
	</ol>
	<h1 class="page-header">Order Dashboard</h1>
	<div class="row">
		<div class="col-lg-4 col-md-4">
			<div class="widget widget-stats">
				<div class="stats-content">
					<div class="stats-title">Pending Orders</div>
					<div class="stats-number">@{{data.pending.count}} / &#8369;</span> <span id="value" ng-bind="data.pending.sum | number:0"></span></div>
					<div class="stats-progress progress">
						<div class="progress-bar" style="width: 100%;"></div>
					</div>
					<div class="stats-desc">total pending orders</div>
				</div>
			</div>
		</div>
		<div class="col-lg-4 col-md-4">
			<div class="widget widget-stats">
				<div class="stats-content">
					<div class="stats-title">Processing Orders</div>
					<div class="stats-number">@{{data.processing.count}} / &#8369;</span> <span id="value" ng-bind="data.processing.sum | number:0"></span></div>
					<div class="stats-progress progress">
						<div class="progress-bar" style="width: 100%;"></div>
					</div>
					<div class="stats-desc">total processing orders</div>
				</div>
			</div>
		</div>
		<div class="col-lg-4 col-md-4">
			<div class="widget widget-stats">
				<div class="stats-content">
					<div class="stats-title">Delivered Orders</div>
					<div class="stats-number">@{{data.delivered.count}} / &#8369;</span> <span id="value" ng-bind="data.delivered.sum | number:0"></span></div>
					<div class="stats-progress progress">
						<div class="progress-bar" style="width: 100%;"></div>
					</div>
					<div class="stats-desc">total delivered orders</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('footer_scripts')

<script type="text/javascript">
  	toastr.info('Please wait, the data are loading ...');

  	(function () {
        var dashboardApp = angular.module('dashboardApp', ['angular.filter']);
        dashboardApp.controller('DashboardCtrl', function ($scope, $http, $sce) {
            $http.get('/helper/product-inventory/dashboard-data').success(function (data) {
				
                $scope.data = data;

            });
        });
    })();
</script>

@stop