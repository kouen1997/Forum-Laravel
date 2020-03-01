@extends('layouts.backend.master')

@section('title', 'Accounts')

@section('header_scripts')
<link href="{{ URL::asset('assets/backend/css/default-assets/data-table.css') }}" rel="stylesheet" />
@stop

@section('content')
<div ng-app="accountsApp" ng-controller="AccountsCtrl as frm">
    <div class="col-12 mb-3">
        <div class="card bg-boxshadow full-height">
            <div class="card-body">
                <h4 class="card-title">Accounts</h4>
                <div class="table-responsive">
                    <div id="loading">
                        <h3 class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait...</h3>
                    </div>
                    <table class="table table-striped table-bordered" id="content-table" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Account Name</th>
                                <th>Account Type</th>
                                <th>Waiting</th>
                                <th>Pairs</th>
                                <th>Code</th>
                                <th>Placement</th>
                                <th>Position</th>
                                <th>Date Added</th>
                                <th>Action</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="account in data.accounts" class="middle">
                                <td></td>
                                <td>@{{ account.account_name}}</td>
                                <td>
                                    <span ng-if="account.status=='PAID'"><strong class="text-success">PAID</strong></span>
                                    <span ng-if="account.status!='PAID'"><strong class="text-danger">FREE SLOT</strong></span>
                                </td>
                                <td>
                                    <strong>Left:</strong> @{{ account.waiting_left }}
                                    <br>
                                    <strong>Right:</strong> @{{ account.waiting_right }}
                                </td>
                                <td>
                                    <strong>Today:</strong> @{{ account.pairing_today }}
                                    <br>
                                    <strong>Total:</strong> @{{ account.pairing_total }}
                                
                                </td>
                                <td>@{{ account.activation_code}}</td>
                                <td>@{{ account.parent_account_name}}</td>
                                <td>@{{ account.position}}</td>
                                <td>@{{ account.created_at }}</td>
                                <td>
                                    <a href="/genealogy?account=@{{ account.account_name | date: 'MM-dd-yyyy h:mm a'}}" class="btn btn-info btn-sm">view genealogy</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer_scripts')
<script src="{{ URL::asset('assets/backend/js/default-assets/data-table.min.js') }}"></script>
<script type="text/javascript">
	(function () {

        $("#content-table").hide();

        var accountsApp = angular.module('accountsApp', ['angular.filter']);
        accountsApp.controller('AccountsCtrl', function ($scope, $http, $sce) {

            var vm = this;

            getdata();
            function getdata() {

                $("#content-table").dataTable().fnDestroy();
                $('#loading').show();
                $("#content-table").hide();

                $http.get('/account/accounts-data').success(function (data) {
                    $scope.data = data;

                    angular.element(document).ready( function () {


                        var t = $('#content-table').DataTable( {
                            lengthChange: false,
                            info: false,
                            autoWidth: true,
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
    })();
</script>
@stop