@extends('layouts.backend.master')

@section('title', 'Codes | Helper')

@section('header_scripts')
<link href="{{ URL::asset('assets/backend/css/default-assets/data-table.css') }}" rel="stylesheet" />
@stop

@section('content')
<div ng-app="activationCodesApp" ng-controller="activationCodesCtrl as frm">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card bg-boxshadow mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Codes History</h5>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-md-6 p-3">
                                    <div class="input-group input-group-md">
                                        <input type="text" class="form-control" placeholder="Search by name, username" ng-model="search_user">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-danger" ng-click="frm.searchByUser()"><i class="fa fa-search"></i> Search</button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6 p-3">
                                    <div class="input-group input-group-md">
                                        <input type="text" class="form-control" placeholder="Search by activation code" ng-model="search_code">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-danger" ng-click="frm.searchByCode()"><i class="fa fa-search"></i> Search</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <posts-pagination></posts-pagination>
                            <div class="table-responsive">
                                <div id="loading">
                                    <h3 class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait...</h3>
                                </div>
                                <table class="table table-striped table-bordered" id="content-table" width="100%" style="display: none">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Code</th>
                                            <th>Code Type</th>
                                            <th>Status</th>
                                            <th>Account</th>
                                            <th>Used Date</th>
                                            <th>Owner</th>
                                            <th>Owned Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="code in data" class="middle">
                                            <td>@{{$index+1}}</td>
                                            <td>@{{code.code}}</td>
                                            <td>
                                                <strong class="text-danger" ng-if="code.code_type=='FREE'">FREE</strong>
                                                <strong class="text-success" ng-if="code.code_type!='FREE'">PAID</strong>
                                            </td>
                                            <td>
                                                <strong class="text-danger" ng-if="code.status=='USED'">USED</strong>
                                                <strong class="text-success"  ng-if="code.status!='USED'">UNUSED</strong>
                                            </td>
                                            <td>@{{code.account.account_name}}</td>
                                            <td>@{{code.used_at}}</td>
                                            <td>
                                                <span ng-if="code.user.id == NULL">ECOMNNECT ADMINISTRATOR</span>
                                                <span ng-if="code.user.id > 0">@{{code.user.username}} - @{{code.user.full_name}}</span>
                                            </td>
                                            <td>@{{code.owned_at}}</td>
                                            <td>
                                                <button id="retrieve_code_btn" ng-if="code.status == 'UNUSED' && code.user_id != '{{Auth::user()->id}}' && code.user_id != NULL  " class="btn btn-danger btn-sm" ng-click="frm.retriveCode(code.id,data)" ng-disabled="btndisabled == true" >Retrieve</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <posts-pagination></posts-pagination>
                        </div>
                    </div>
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
        var activationCodesApp = angular.module('activationCodesApp', ['angular.filter']);
        activationCodesApp.controller('activationCodesCtrl', [ '$http', '$scope', function($http, $scope){

            var vm = this;

            var midby = '',
                search_code = '',
                search_user = '';

            function getUrlVars() {
                var vars = {};
                var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
                vars[key] = value;
                });
                return vars;
            }

            if (typeof getUrlVars()["user_id"] != 'undefined') {
                midby = '&user_id='+getUrlVars()["user_id"];
                $scope.midby = getUrlVars()["user_id"];
            }

            if (typeof getUrlVars()["search_code"] != 'undefined') {
                search_code = '&search_code='+getUrlVars()["search_code"];
            }

            if (typeof getUrlVars()["search_user"] != 'undefined') {
                search_user = '&search_user='+getUrlVars()["search_user"];
            }

            vm.searchByCode = function () {
                search_code = '&search_code=' + $scope.search_code;
                getdata();
            }

            vm.searchByUser = function () {
                search_user = '&search_user=' + $scope.search_user;
                getdata();
            }

            vm.retriveCode = function (id) {
                var ans = confirm("Are you sure about this?");
                $scope.btndisabled = true;
                if (ans) {

                    $('#retrieve_code_btn').prop('disabled', true);
                    $('#retrieve_code_btn').html('Retrieving <i class="fa fa-spinner fa-spin"></i>');

                    $http({
                        method: 'POST',
                        url: '/helper/activation-codes/'+id+'/retrieve',
                        data: JSON.stringify({
                           status: status
                        })
                    }).success(function (data) {
                        if (data.result==1){

                            alert(data.message);

                            $('#retrieve_code_btn').prop('disabled', false);
                            $('#retrieve_code_btn').html('Retrieve');

                            getdata();

                            $scope.btndisabled = false;
                        }
                    }).error(function (data) {

                        $('#retrieve_code_btn').prop('disabled', false);
                        $('#retrieve_code_btn').html('Retrieve');

                        $scope.btndisabled = false;

                      if(data.result == 0){

                        alert(data.message);

                        } else {

                          angular.forEach(data.errors, function(message, key){

                            alert(message);

                          });
                        }
                    });

                }  else {

                    $('#retrieve_code_btn').prop('disabled', false);
                    $('#retrieve_code_btn').html('Retrieve');
                    $scope.btndisabled = false;
                }
            }

            $scope.data = [];
            $scope.totalPages = 0;
            $scope.currentPage = 1;
            $scope.range = [];


            vm.changepage = function (pageNumber) {
                getdata(pageNumber);
            }

            getdata();
            function getdata(pageNumber) {

                $("#content-table").dataTable().fnDestroy();
                $('#loading').show();
                $("#content-table").hide();

                if(pageNumber===undefined){
                    pageNumber = '1';
                }

                $http.get('/helper/activation-codes-data?page='+pageNumber+midby+search_user+search_code).success(function(response) {
                    console.log(response);
                    $scope.data        = response.codes.data;
                    $scope.totalPages   = response.codes.last_page;
                    $scope.currentPage  = response.codes.current_page;
                    $scope.total  = response.codes.total;

                    // Pagination Range
                    var pages = [];

                    for(var i=1;i<=response.codes.last_page;i++) {          
                        pages.push(i);
                    }

                    $scope.range = pages; 

                    angular.element(document).ready( function () {

                        var t = $('#content-table').DataTable( {
                            searching: false,
                            
                            info: false,
                            paging: false,
                            autoWidth: false,
                            filter: false,
                            "initComplete": function(settings, json) {
                                $('#loading').hide();
                                $("#content-table").show();
                            }
                        } );

                    });

                });

            };

        }]);


        activationCodesApp.directive('postsPagination', function(){  
           return{
              restrict: 'E',

              template: '<ul class="pagination justify-content-center" ng-if="total>10">'+
              '<li class="page-item disabled" ng-show="currentPage == 1"><a href="javascript:void(0)" class="page-link" ng-click="frm.changepage(1)">«</a></li>'+
                '<li class="page-item" ng-show="currentPage != 1"><a href="javascript:void(0)" class="page-link" ng-click="frm.changepage(1)">«</a></li>'+
                '<li class="page-item" ng-show="currentPage != 1"><a href="javascript:void(0)" class="page-link" ng-click="frm.changepage(currentPage-1)">‹ Prev</a></li>'+
                '<li class="page-item disabled" ng-show="currentPage == 1"><a href="javascript:void(0)" class="page-link" ng-click="frm.changepage(currentPage-1)">‹ Prev</a></li>'+
                '<li class="page-item" ng-show="currentPage != totalPages"><a href="javascript:void(0)" class="page-link" ng-click="frm.changepage(currentPage+1)">Next ›</a></li>'+
                '<li class="page-item" ng-show="currentPage != totalPages"><a href="javascript:void(0)" class="page-link" ng-click="frm.changepage(totalPages)">»</a></li>'+
              '</ul>'
           };
        });
    })();
</script>
@stop