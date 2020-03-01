@extends('layouts.backend.master')

@section('title', 'Transfer Codes | Helper')

@section('header_scripts')
<link href="{{ URL::asset('assets/backend/css/default-assets/data-table.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/sweet-alert/sweetalert.min.css') }}" rel="stylesheet">
@stop

@section('content')
<div ng-app="transferCodesApp" ng-controller="transferCodesCtrl as frm">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card bg-boxshadow mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Codes History</h5>
                        <div class="ibox-content">
                            <ul class="nav nav-tabs">
                                <li class="nav-items">
                                    <a href="#default-tab-1" data-toggle="tab" class="nav-link active show">
                                        <span class="d-sm-none">History</span>
                                        <span class="d-sm-block d-none">History</span>
                                    </a>
                                </li>
                                <li class="nav-items">
                                    <a href="#default-tab-2" data-toggle="tab" class="nav-link show">
                                        <span class="d-sm-none">Transfer</span>
                                        <span class="d-sm-block d-none">Transfer</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="default-tab-1">
                                    <div id="loading">
                                        <h3 class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait...</h3>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered" id="content-table" style="display: none;">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Details</th>    
                                                    <th>Code</th>   
                                                    <th>Date Transferred</th> 
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="default-tab-2">
                                    <form class="ng-pristine ng-valid-email ng-invalid ng-invalid-required" name="transferCodeFrm" ng-submit="frm.submitTransferCode(transferCodeFrm.$valid)" autocomplete="off">
                                        <div class="row p-4 m-t-20">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="codeType">Code Type <span class="text-danger">*</span></label>
                                                    <select name="code_type" ng-model="frm.code_type" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" required>
                                                        <option value="PAID" selected>PAID</option>
                                                        <option value="FREE">FREE</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="input-normal">Quantity <span class="text-danger">*</span></label><br>
                                                    <select name="quantity" ng-model="frm.quantity" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" required="">
                                                        @for($x=1; $x < 501; $x++)
                                                            <option value="{{ $x}}">{{ $x}}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="input-normal">Username <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" name="username" ng-model="frm.username" placeholder="Username" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="input-normal">Security Pin <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" name="pin" ng-model="frm.pin" maxlength="6" placeholder="Security Pin" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12 m-t-15 text-center">
                                                <button type="submit" ng-disabled="transferCodeFrm.$invalid" id="transfer_code_btn" class="btn btn-danger">Transfer</button> 
                                            </div>
                                        </div>
                                    </form>
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
<script src="{{ URL::asset('assets/backend/js/default-assets/data-table.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/sweet-alert/sweetalert.min.js') }}"></script>
<script type="text/javascript">
    (function () {

        var transferCodesApp = angular.module('transferCodesApp', ['angular.filter']);
        transferCodesApp.controller('transferCodesCtrl', function ($scope, $http, $sce) {

            var vm = this;

            getdata();
            function getdata() {

                $("#content-table").dataTable().fnDestroy();
                $("content-table").hide();  
                $('#loading').show(); 

                angular.element(document).ready( function () {

                    var t = $('#content-table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '/helper/transfer-codes-data',
                            data: function (data) {

                                for (var i = 0, len = data.columns.length; i < len; i++) {
                                    if (! data.columns[i].search.value) delete data.columns[i].search;
                                    if (data.columns[i].searchable === true) delete data.columns[i].searchable;
                                    if (data.columns[i].orderable === true) delete data.columns[i].orderable;
                                    if (data.columns[i].data === data.columns[i].name) delete data.columns[i].name;
                                }
                                delete data.search.regex;
                            }
                        },
                        lengthChange: false,
                        info: false,
                        autoWidth: false,
                        columns: [
                            {data: 'DT_RowIndex', orderable: false, searchable: false},
                            {data: 'message', name: 'message', orderable: true, searchable: true},
                            {data: 'code', name: 'code', orderable: true, searchable: true},
                            {data: 'date', name: 'created_at'}
                        ],
                        order: [[3, 'desc']],
                        "initComplete": function(settings, json) { 
                               $('#loading').delay( 300 ).hide(); 
                               $("#content-table").delay( 300 ).show(); 
                        } 
                    });

                 });

            }

            vm.submitTransferCode = function () {
                
                swal({
                    title: "Are you sure want to transfer this code?",
                    type: "warning",
                    html: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    showCancelButton: true,
                },
                function() {

                    $scope.btndisabled = true;
                    $("#transfer_code_btn").hide();

                    $http({
                        method: 'POST',
                        url: '/helper/transfer-codes',
                        data: JSON.stringify({
                           code_type: vm.code_type,
                           username: vm.username,
                           quantity: vm.quantity,
                           pin: vm.pin
                        })
                    }).success(function (data) {
                        if (data.result==1){

                            toastr.info(data.message);

                            setTimeout(window.location.href = '/helper/transfer-codes', 10000);
                        } else {
                            $("#transfer_code_btn").show();
                            $scope.btndisabled = false;
                            toastr.warning(data.message);
                        
                        }
                    }).error(function (data) {

                        $("#transfer_code_btn").show();
                        $scope.btndisabled = false;

                        if(data.result == 0){

                            toastr.info(data.message);

                        } else {
                            
                            angular.forEach(data.errors, function(message, key){

                                toastr.warning(message);

                            });
                        }
                    });
                    
                });
            };

        });
    })();

</script>

@stop