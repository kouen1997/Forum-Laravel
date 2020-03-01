@extends('layouts.backend.master')

@section('title', 'Associate')

@section('header_scripts')
<link href="{{ URL::asset('assets/plugins/sweet-alert/sweetalert.min.css') }}" rel="stylesheet">
@stop

@section('content')
<div ng-app="dashboardApp" ng-controller="DashboardCtrl as frm">

    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-6">
                <div class="dashboard-header-title mb-3">
                    <h6 class="mb-0">Welcome back!</h6>
                    <p class="mb-0">Affiliate Marketing Company which focuses on Real Estate.</p>
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
                <div class="widget-social-content p-3 bg-primary full-height">
                    <h6 class="text-white">Direct Commission</h6>
                    <h5 class="text-white mb-0">&#8369;<span ng-bind="data.earnings.sponsored_bonus | number:0"></span></h5>
                    <div class="widget-social-icon">
                        <i class="fa fa-star-o" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-4 col-xl-4 mb-3">
                <div class="widget-social-content p-3 primary-color full-height">
                    <h6 class="text-white">Team Bldg. Commission</h6>
                    <h5 class="text-white mb-0">&#8369;<span ng-bind="data.earnings.total_pairing_bonus | number:0"></span></h5>
                    <div class="widget-social-icon">
                        <i class="fa fa-handshake-o" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-4 col-xl-4 mb-3">
                <div class="widget-social-content p-3 bg-danger full-height">
                    <h6 class="text-white">HomeBook Gold</h6>
                    <h5 class="text-white mb-0"><span ng-bind="data.summary.homebook_gold | number:0"></span></h5>
                    <div class="widget-social-icon">
                        <i class="fa fa-cubes" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-xl-6 mb-3">
                <div class="widget-content-style bg-success full-height">
                    <div class="row align-items-center p-3">
                        <div class="col-4">
                            <i class="ti-stats-up"></i>
                        </div>
                        <div class="col-8 text-right">
                            <span class="text-white">Successful Soles Closed(0.25%)</span>
                            <h2 class="mb-0 widget-content-text text-white">&#8369;0</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-6 mb-3">
                <div class="widget-content-style bg-purple full-height">
                    <div class="row align-items-center p-3">
                        <div class="col-4">
                            <i class="ti-shine"></i>
                        </div>
                        <div class="col-8 text-right">
                            <span class="text-white">Share Link Rewards</span>
                            <h2 class="mb-0 widget-content-text text-white">&#8369;<span ng-bind="data.summary.share_reward | number:0"></span></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-4 mb-3">
                <div class="card bg-boxshadow full-height">
                    <div class="card-header bg-transparent user-area d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">Summary</h5>
                    </div>
                    <div class="card-body">
                        <ul class="total-earnings-list">
                            <li>
                                <div class="author-info d-flex align-items-center">
                                    <div class="author-img mr-3">
                                        <img src="{{ URL::asset('homebook.png') }}" alt="">
                                    </div>
                                    <div class="author-text">
                                        <p class="mb-0">Total Earnings</p>
                                    </div>
                                </div>
                                <span class="badge badge-outline-info badge-pill">&#8369;<span ng-bind="data.earnings.total_earnings | number:0"></span></span>
                            </li>
                            <li>
                                <div class="author-info d-flex align-items-center">
                                    <div class="author-img mr-3">
                                        <img src="{{ URL::asset('homebook.png') }}" alt="">
                                    </div>
                                    <div class="author-text">
                                        <p class="mb-0">Total E-Wallet Balance</p>
                                    </div>
                                </div>
                                <span class="badge badge-outline-success badge-pill">&#8369;<span ng-bind="data.earnings.available_wallet | number:0"></span></span>
                            </li>
                            <li>
                                <div class="author-info d-flex align-items-center">
                                    <div class="author-img mr-3">
                                        <img src="{{ URL::asset('homebook.png') }}" alt="">
                                    </div>
                                    <div class="author-text">
                                        <p class="mb-0">Total Withdrawal</p>
                                    </div>
                                </div>
                                <span class="badge badge-outline-danger badge-pill">&#8369;<span ng-bind="data.earnings.total_withdrawal | number:0"></span></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 mb-3">
                <div class="card bg-boxshadow full-height">
                    <div class="card-header bg-transparent user-area d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">Referral Links</h5>
                    </div>
                    <div class="card-body">
                        <div class="e-caps-list-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6>Affiliate Link</h6>
                                <span>{{ url('/?ref=').Auth::user()->username }}</span>
                            </div>
                            <div class="text-right ml-3">
                                <button data-clipboard-text="{{ url('/?ref=').Auth::user()->username }}" class="btn btn-sm btn-warning mb-1 btn-aff-link">copy</button>
                            </div>
                        </div>
                        <div class="e-caps-list-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6>Share Reward Link</h6>
                                <span>Click START, Select Property you want and click Share!</span>
                            </div>
                            <div class="text-right ml-3">
                                <a href="{{ url('/properties') }}" target="_blank" class="btn btn-sm btn-warning mb-1">start</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 mb-3">
                <div class="card bg-boxshadow full-height">
                    <div class="card-header bg-transparent user-area d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">Summary</h5>
                    </div>
                    <div class="card-body">
                        <ul class="total-earnings-list">
                            <li>
                                <div class="author-info d-flex align-items-center">
                                    <div class="author-img mr-3">
                                        <img src="{{ URL::asset('homebook.png') }}" alt="">
                                    </div>
                                    <div class="author-text">
                                        <p class="mb-0">Total Available Codes</p>
                                    </div>
                                </div>
                                <span class="badge badge-outline-info badge-pill"><span ng-bind="data.summary.paid_codes_count | number:0">0</span></span>
                            </li>
                            <li>
                                <div class="author-info d-flex align-items-center">
                                    <div class="author-img mr-3">
                                        <img src="{{ URL::asset('homebook.png') }}" alt="">
                                    </div>
                                    <div class="author-text">
                                        <p class="mb-0">Total Accounts</p>
                                    </div>
                                </div>
                                <span class="badge badge-outline-info badge-pill"><span ng-bind="data.summary.accounts_count | number:0">0</span></span>
                            </li>
                            <li>
                                <div class="author-info d-flex align-items-center">
                                    <div class="author-img mr-3">
                                        <img src="{{ URL::asset('homebook.png') }}" alt="">
                                    </div>
                                    <div class="author-text">
                                        <p class="mb-0">Total Shared Links</p>
                                    </div>
                                </div>
                                <span class="badge badge-outline-info badge-pill"><span ng-bind="data.summary.watch_count | number:0">0</span></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
    
</div>
@endsection

@section('footer_scripts')
<script src="{{ URL::asset('assets/plugins/sweet-alert/sweetalert.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/hopscotch/0.3.1/js/hopscotch.min.js"></script>
<script type="text/javascript">
  	(function () {
        var dashboardApp = angular.module('dashboardApp', ['angular.filter']);
        dashboardApp.controller('DashboardCtrl', function ($scope, $http, $sce) {
            $http.get('/account-data').success(function (data) {
                $scope.data = data;
            });
        });
    })();
</script>

<script>

    var clipboardAff = new ClipboardJS('.btn-aff-link');

</script>

<script type="text/javascript">
	$(document).on('click', '#move_to_wallet', function (e) {
        e.preventDefault();
        var movable = $(this).data('movable');
        var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
        swal({
                title: "Are you sure want to move "+movable+" points to your main e-wallet?" ,
                type: "info",
                html: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes!",
                showCancelButton: true,
            },
            function() {

                $.ajax({
                   type:'POST',
                   url:'/rewards/points-walletmove',
                   data:{_token: CSRF_TOKEN},
                   dataType: 'JSON',
                   success:function(data){
                    if (data.result == 1){
                        swal({
                            title: data.message ,
                            type: "success",
                            html: true,
                        },
                        function() {
                            setTimeout(window.location.href = '/associate', 1000);
                        });
                    } else {
                        swal({
                            title: data.message ,
                            type: "error"
                        });
                    }
                   }

            });
        });
    });
</script>
@stop