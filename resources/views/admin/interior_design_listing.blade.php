@extends('layouts.backend.master')

@section('title', 'Interior Design')

@section('header_scripts')

@stop

@section('content')
<div ng-app="interiordesignApp" ng-controller="interiordesignCtrl as frm">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card bg-boxshadow mb-3">
                    <div class="card-body">
                        <h4 class="card-title">Interior Design List</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                               
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group input-group-md">
                                    <div class="col-sm-9">
                                        <input type="text" name="search" class="form-control" ng-model="frm.searchPropertyType" placeholder="Search Property Type">
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="btn btn-danger" ng-click="frm.searchProceed()"> <i class="fa fa-search"></i> Search</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-data">
                                    @include('admin.interior_design_data')
                                </div>
                            </div>
                        </div>
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
        var interiordesignApp = angular.module('interiordesignApp', ['angular.filter']);
        interiordesignApp.controller('interiordesignCtrl', function ($scope, $http, $sce, $compile) {

            var vm = this;

            $(document).on("click",'.pagination a',function(e){
                e.preventDefault();
                var page = $(this).attr('href').split('page=')[1];

                $http({
                    method: 'GET',
                    url: '/admin/pagination/interior-design/listing?page='+page,
                    headers: {
                        'Content-Type': undefined
                    }
                }).then(function successCallback(response) {

                    if (response.data.status == 'success'){

                        $('.table-data').html('<h3 class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait, the data is loading ...</h3>');

                        setTimeout(function () {
                            $('.table-data').html($compile(response.data.responseHtml)($scope));
                        }, 2000);
                    }

                }, function errorCallback(response) {
                   
                    if (response.data.status){

                        swal("","Something went wrong. Please try again!", "warning");
                         
                    } else {
                        var errors = [];
                        angular.forEach(response.data.errors, function(message, key){
                            errors.push(message[0]);
                        });
                    
                        swal("",errors.toString().split(",").join("\n \n"),"error");
                    }
                    
                });

            });

            vm.searchProceed = function(){

                $http({
                    method: 'POST',
                    url: '/admin/search/interior-design/listing',
                    data: JSON.stringify({
                        search: vm.searchPropertyType
                    })
                }).then(function successCallback(response) {

                    if (response.data.status == 'success'){

                        $('.table-data').html('<h3 class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait, the data is loading ...</h3>');

                        setTimeout(function () {
                            $('.table-data').html($compile(response.data.responseHtml)($scope));
                        }, 2000);
                    }

                }, function errorCallback(response) { 

                    if (response.data.status){

                        swal("","Something went wrong. Please try again!", "warning");
                         
                    } else {
                        var errors = [];
                        angular.forEach(response.data.errors, function(message, key){
                            errors.push(message[0]);
                        });
                    
                        swal("",errors.toString().split(",").join("\n \n"),"error");
                    }
                    
                });

            };

        });
    })();
</script>
@stop