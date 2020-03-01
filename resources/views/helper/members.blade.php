@extends('layouts.backend.master')

@section('title', 'Members | Helper')

@section('header_scripts')
<link href="{{ URL::asset('theme/v1/plugins/DataTables/media/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('theme/v1/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css') }}" rel="stylesheet" />
@stop

@section('content')
<div ng-app="membersApp" ng-controller="MembersCtrl as frm">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item active">Members</li>
    </ol>
    <h1 class="page-header">Members</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Search</h4>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6 p-3">
                    <div class="input-group input-group-md">
                        <input type="text" class="form-control" placeholder="Search by username" ng-model="username">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-danger" ng-click="frm.searchMemberUsername()"><i class="fa fa-search"></i> Search</button>
                        </span>
                    </div>
                </div>
                <div class="col-md-6 p-3">
                    <div class="input-group input-group-md">
                        <input type="text" class="form-control" placeholder="Search by name" ng-model="name">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-danger" ng-click="frm.searchMemberName()"><i class="fa fa-search"></i> Search</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Members</h4>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <div id="loading">
                    <h3 class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait...</h3>
                </div>
                <table class="table table-striped table-bordered" id="content-table" width="100%" style="display: none">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Sponsor</th>
                            <th>Total Referrals</th>
                            <th>Available Codes</th>
                            <th>Accounts</th>
                            <th>Status</th>
                            <th>Date Joined</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="member in data.members" class="middle">
                            <td></td>
                            <td class="">
                            @{{member.first_name}} @{{member.last_name}} <br>
                            <small><strong>( @{{member.username}} )</strong></small>
                            </td>
                            <td>@{{member.sponsor.first_name}} @{{member.sponsor.last_name}}<br>
                            <small><strong>( @{{member.sponsor.username}} )</strong></small>
                            </td>
                            <td>@{{member.sponsored.length}}</td>
                            <td>@{{member.code_unused.length}}</td>
                            <td>
                                <b>Paid:</b> @{{member.paid_account.length}}
                                <br>
                                <b>Free:</b> @{{member.free_account.length}}
                            </td>
                            <td>
                                <span ng-if="member.active==1">
                                    <strong class="text-success" ng-if="member.paid_account.length>0||member.free_account.length>0">ACTIVE</strong>
                                    <strong class="text-success" ng-if="member.paid_account.length<0||member.free_account.length<0">ACTIVE <br><small>no account</small></strong>
                                </span>
                                <span ng-if="member.active != 1">
                                    <strong class="text-danger">INACTIVE</strong>
                                </span>
                            </td>
                            <td>@{{member.created_at}} </td>
                            <td>
                                <a href="{{ url('/helper/members') }}/@{{ member.id }}" class="btn btn-lime btn-sm" target="_blank">View</a>
                                <a href="{{ url('/helper/ban') }}/@{{ member.id }}" class="btn btn-danger btn-sm" ng-if="member.banned==0">Ban</a>
                                <a href="{{ url('/helper/retrieve') }}/@{{ member.id }}" class="btn btn-warning btn-sm" ng-if="member.banned==1">Retrieve</a>
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
<script src="{{ URL::asset('theme/v1/plugins/DataTables/media/js/jquery.dataTables.js') }}"></script>
<script src="{{ URL::asset('theme/v1/plugins/DataTables/media/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('theme/v1/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('theme/v1/js/demo/table-manage-responsive.demo.min.js') }}"></script>
<script type="text/javascript">
	(function () {

        $("#content-table").hide();

        var membersApp = angular.module('membersApp', ['angular.filter']);
        membersApp.controller('MembersCtrl', function ($scope, $http, $sce) {

            var vm = this;

            var search = '';

            function getUrlVars() {
                var vars = {};
                var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
                vars[key] = value;
                });
                return vars;
            }

            if (typeof getUrlVars()["username"] != 'undefined') {
                search = '?username='+getUrlVars()["username"];
            }

            if (typeof getUrlVars()["name"] != 'undefined') {
                search = '?name='+getUrlVars()["name"];
            }

            vm.searchMemberUsername = function () {
                search = '?username=' + $scope.username;
                getdata();
            }

            vm.searchMemberName = function () {
                search = '?name=' + $scope.name;
                getdata();
            }

            getdata();
            function getdata() {

                $("#content-table").dataTable().fnDestroy();
                $('#loading').show();
                $("#content-table").hide();

                $http.get('/helper/members-data'+search).success(function (data) {

                    $scope.data = data;

                    angular.element(document).ready( function () {


                        var t = $('#content-table').DataTable( {
                            lengthChange: false,
                            info: false,
                            autoWidth: true,
                            responsive: true,
                            filter: false,
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


            vm.retrieve = function (id) {
               
               var ans = confirm("Are you sure want to retrieve this user?");
               
               if (ans){

                   $http({
                       method: 'POST',
                       url: '/helper/retrieve',
                       data: JSON.stringify({
                          user_id: id
                       })
                   }).success(function (data) {
                       if (data.result==1){

                           toastr.info(data.message);

                           getdata();
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
               }
           };

           vm.ban = function (id) {
              
               var ans = confirm("Are you sure want to ban this user?");
               
               if (ans){

                   $http({
                       method: 'POST',
                       url: '/helper/ban',
                       data: JSON.stringify({
                          user_id: id
                       })
                   }).success(function (data) {
                       if (data.result==1){

                           toastr.info(data.message);

                           getdata();
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
               }
           };

        });
    })();

</script>

@stop