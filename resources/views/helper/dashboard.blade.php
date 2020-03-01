@extends('layouts.backend.master')

@section('title', 'Dashboard | Helper')

@section('content')
<div ng-app="dashboardApp" ng-controller="DashboardCtrl as frm">
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
			<div class="col-12 col-sm-4 col-xl-4 mb-3">
				<div class="card widget-new-content p-3 bg-white bg-boxshadow full-height">
					<div class="widget---stats d-flex align-items-center mb-15">
						<div class="widget---content-text">
							<h6>Open Tickets</h6>
							<p class="mb-0">&nbsp;</p>
						</div>
						<h6 class="mb-0 text-primary"><span ng-bind="data.open"></span></h6>
					</div>
					<div class="progress h-5">
						<div class="progress-bar w-100 bg-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-4 col-xl-4 mb-3">
				<div class="card widget-new-content p-3 bg-white bg-boxshadow full-height">
					<div class="widget---stats d-flex align-items-center mb-15">
						<div class="widget---content-text">
							<h6>Completed Tickets</h6>
							<p class="mb-0">&nbsp;</p>
						</div>
						<h6 class="mb-0 text-primary"><span ng-bind="data.completed"></span></h6>
					</div>
					<div class="progress h-5">
						<div class="progress-bar w-100 bg-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-4 col-xl-4 mb-3">
				<div class="card widget-new-content p-3 bg-white bg-boxshadow full-height">
					<div class="widget---stats d-flex align-items-center mb-15">
						<div class="widget---content-text">
							<h6>Master Fund</h6>
							<p class="mb-0">&nbsp;</p>
						</div>
						<h6 class="mb-0 text-primary"><span ng-bind="data.total_fund | number:2"></span></h6>
					</div>
					<div class="progress h-5">
						<div class="progress-bar w-100 bg-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-sm-4 col-xl-4 mb-3">
				<div class="card widget-new-content p-3 bg-white bg-boxshadow full-height">
					<div class="widget---stats d-flex align-items-center mb-15">
						<div class="widget---content-text">
							<h6>Codes</h6>
							<p class="mb-0">&nbsp;</p>
						</div>
						<h6 class="mb-0 text-primary">Paid: <span ng-bind="data.total_paid_codes"></span> | Free: <span ng-bind="data.total_free_codes"></span></h6>
					</div>
					<div class="progress h-5">
						<div class="progress-bar w-100 bg-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-4 col-xl-4 mb-3">
				<div class="card widget-new-content p-3 bg-white bg-boxshadow full-height">
					<div class="widget---stats d-flex align-items-center mb-15">
						<div class="widget---content-text">
							<h6>Transferred Codes</h6>
							<p class="mb-0">&nbsp;</p>
						</div>
						<h6 class="mb-0 text-primary"><span class="text-danger" ng-bind="data.total_codes_transferred"></span></h6>
					</div>
					<div class="progress h-5">
						<div class="progress-bar w-100 bg-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-4 col-xl-4 mb-3">
				<div class="card widget-new-content p-3 bg-white bg-boxshadow full-height">
					<div class="widget---stats d-flex align-items-center mb-15">
						<div class="widget---content-text">
							<h6>Transferred Master Fund</h6>
							<p class="mb-0">&nbsp;</p>
						</div>
						<h6 class="mb-0 text-primary"><span class="text-danger">&#8369;<span ng-bind="data.total_fund_transferred | number:2"></span></span></h6>
					</div>
					<div class="progress h-5">
						<div class="progress-bar w-100 bg-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
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
        var dashboardApp = angular.module('dashboardApp', ['angular.filter']);
        dashboardApp.controller('DashboardCtrl', function ($scope, $http, $sce) {
            $http.get('/helper-data').success(function (data) {

                $scope.data = data;

            });
        });
    })();
</script>

@stop