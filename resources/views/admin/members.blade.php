@extends('layouts.master')

@section('title', 'Members')

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
        <ul class="nav nav-tabs">
			<li class="nav-items">
				<a href="#default-tab-1" data-toggle="tab" class="nav-link active show">
					<span class="d-sm-none">List</span>
					<span class="d-sm-block d-none">List</span>
				</a>
			</li>
			<li class="nav-items">
				<a href="#default-tab-2" data-toggle="tab" class="nav-link show">
					<span class="d-sm-none">Add</span>
					<span class="d-sm-block d-none">Add</span>
				</a>
			</li>
        </ul>
        <div class="tab-content">
			<div class="tab-pane fade active show" id="default-tab-1">
                <div class="table-responsive">
                    <div id="loading">
                        <h3 class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait...</h3>
                    </div>
                    <table class="table table-striped table-bordered" id="content-table" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Sponsor</th>
                                <th>Details</th>
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
                                <td>
                                    Paid Account: <strong class="text-dark">@{{member.paid_account.length}}</strong>
                                    <br>
                                    Free Account: <strong class="text-dark">@{{member.free_account.length}}</strong>
                                    <br>
                                    Referrals: <strong class="text-dark">@{{member.sponsored.length}}</strong>
                                    <br>
                                    Available Codes: <strong class="text-dark">@{{member.code_unused.length}}</strong>
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
                                    <a href="{{ url('/admin/members') }}/@{{ member.id }}" class="btn btn-lime btn-sm" target="_blank">view</a>
                                    <a href="{{ url('/admin/members/ban') }}/@{{ member.id }}" class="btn btn-danger btn-sm" ng-if="member.banned==0">ban</a>
                                    <a href="{{ url('/admin/members/retrieve') }}/@{{ member.id }}" class="btn btn-warning btn-sm" ng-if="member.banned==1">retrieve</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="default-tab-2">
                <form class="ng-pristine ng-valid-email ng-invalid ng-invalid-required" name="saveMemberFrm" ng-submit="frm.saveMember(saveMemberFrm.$valid)" autocomplete="off">
                    <div class="row p-4 m-t-20">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="First Name" name="first_name" id="first_name" ng-model="frm.first_name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Last Name" name="last_name" id="last_name" ng-model="frm.last_name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" placeholder="Email Address"  name="email" id="email" ng-model="frm.email" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Username" name="username" id="username" ng-model="frm.username" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Mobile Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Mobile Number" name="mobile" id="mobile" ng-model="frm.mobile" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" placeholder="Password" name="password" id="password" ng-model="frm.password" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sponsor <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Sponsor" name="sponsor" id="sponsor" ng-model="frm.sponsor" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="input-normal">Role <span class="text-danger">*</span></label>
                                <select name="role" id="role" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" ng-model="frm.role" required="">
                                <option disabled selected>Choose user role</option>
                                <option value="1">Member</option>
                                <option value="2">Helper</option>
                                <option value="3">Support</option>
                                <option value="4">Dealer</option>
                            </select>
                        </div>
                        <div class="col-md-6 offset-md-3">
                            <div class="form-group">
                                <label for="input-normal">Security Pin <span class="text-danger">*</span></label>
                                <input type="text" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" placeholder="Security Pin" name="pin" ng-model="frm.pin" maxlength="6" required>
                            </div>
                        </div>
                        <div class="col-md-12 m-t-15 text-center">
                            <button type="submit" ng-disabled="saveMemberFrm.$invalid" id="save_member_btn" class="btn btn-danger">Save</button>
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

                $http.get('/admin/members-data'+search).success(function (data) {

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

            vm.saveMember = function () {

                $('#save_member_btn').prop('disabled', true);
                $('#save_member_btn').html('Saving...<i class="fa fa-spinner fa-spin"></i>');

                $http({
                    method: 'POST',
                    url: '/admin/members/create',
                    data: JSON.stringify({
                        username: vm.username,
                        first_name: vm.first_name,
                        last_name: vm.last_name,
                        email: vm.email,
                        mobile: vm.mobile,
                        password: vm.password,
                        sponsor: vm.sponsor,
                        role: vm.role,
                        pin: vm.pin
                    })
                }).success(function (data) {
                    $('#save_member_btn').prop('disabled', false);
                    $('#save_member_btn').html('Save');
                    if (data.result == 1){

                        toastr.info(data.message);

                        setTimeout(window.location.href = '/admin/members', 10000);

                    } else {
                        toastr.info("Something went wrong. Please try again!");
                    }
                }).error(function (data) {

                    $('#save_member_btn').prop('disabled', false);
                    $('#save_member_btn').html('Save');

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