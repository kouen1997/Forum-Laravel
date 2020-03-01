@extends('layouts.master')

@section('title', 'Accounts')

@section('header_scripts')
<link href="{{ URL::asset('assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/datatables/plugins/responsive/responsive.dataTables.min.css') }}" rel="stylesheet">
@stop

@section('content')
<div ng-app="accountsApp" ng-controller="accountsCtrl as frm">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item active">Accounts</li>
    </ol>
    <h1 class="page-header">Accounts</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Search</h4>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6 offset-md-3 p-3">
                    <div class="input-group input-group-md">
                        <input type="text" class="form-control" placeholder="Search by account name , activation code or placement" ng-model="search">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-danger" ng-click="frm.searchMember()"><i class="fa fa-search"></i> Search</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Accounts</h4>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <div id="loading">
                    <h3 class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait...</h3>
                </div>
                <table class="table table-striped table-bordered text-center" id="content-table" width="100%" style="display: none">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Owner</th>
                            <th>Account Name</th>
                            <th>Code</th>
                            <th>Placement</th>
                            <th>Position</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="account in data.accounts" class="middle">
                            <td></td>
                            <td>@{{ account.user.first_name}} @{{ account.user.last_name}}<br>
                                <small>( @{{ account.user.username}} )</small>
                            </td>
                            <td><strong>@{{ account.account_name}}</strong></td>
                            <td>@{{ account.activation_code}}</td>
                            <td>@{{ account.parent_account_name}}</td>
                            <td>@{{ account.position}}</td>
                            <td>
                                <span ng-if="account.status == 'PAID'">
                                    <strong class="text-success">@{{ account.status}}</strong>
                                </span>
                                <span ng-if="account.status == 'FREE'">
                                    <strong class="text-danger">@{{ account.status}} SLOT</strong>
                                </span>
                            </td>
                            <td>@{{ account.created_at | mcDbDateFormatter | date:'MMM d, yyyy HH:mm:ss' }}</td>
                            <td>
                                <a href="/admin/network/genealogy?account=@{{ account.account_name}}" class="btn btn-danger btn-sm" target="_blank">genealogy</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer_scripts')
<script src="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.js') }}" ></script>
<script src="{{ URL::asset('assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap4.min.js') }}" ></script>
<script src="{{ URL::asset('assets/plugins/datatables/plugins/responsive/dataTables.responsive.min.js') }}" ></script>
<script type="text/javascript">
    (function () {
        var accountsApp = angular.module('accountsApp', ['angular.filter']);
        accountsApp.controller('accountsCtrl', function ($scope, $http, $sce) {
     
            var vm = this,
                search = '',
                user_id = '';

            function getUrlVars() {
                var vars = {};
                var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
                vars[key] = value;
                });
                return vars;
            }

            if (typeof getUrlVars()["search"] != 'undefined') {
                search = '?search='+getUrlVars()["search"];
            }

            if (typeof getUrlVars()["user_id"] != 'undefined') {
                user_id = '?user_id='+getUrlVars()["user_id"];
            }

            vm.searchMember = function () {
                search = '?search=' + $scope.search;
                getdata();
            }

            getdata();
            function getdata() {

                $("#content-table").dataTable().fnDestroy();
                $('#loading').show();
                $("#content-table").hide();

                $http.get('/admin/accounts-data'+search+user_id).success(function (data) {
                    $scope.data = data;

                    angular.element(document).ready( function () {


                        var t = $('#content-table').DataTable( {
                            lengthChange: false,
                            info: false,
                            autoWidth: false,
                            responsive: true,
                             "initComplete": function(settings, json) {
                                $('#loading').hide();
                                $("#content-table").show();
                              }
                        } );
                     
                        t.on( 'order.dt search.dt', function () {
                           t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                              cell.innerHTML = i + 1;
                              t.cell(cell).invalidate('dom'); 
                           } );
                        } ).draw();

                     });

                }); 
            }

        });

        accountsApp.filter('mcDbDateFormatter', function() {
            return function(dateSTR) {
                var o = dateSTR.replace(/-/g, "/"); // Replaces hyphens with slashes
                return Date.parse(o + " -0000"); // No TZ subtraction on this sample
            }
        });

    })();

</script>

@stop