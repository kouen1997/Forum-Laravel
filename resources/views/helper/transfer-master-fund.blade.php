@extends('layouts.backend.master')

@section('title', 'Transfer Master Fund | Helper')

@section('header_scripts')
<link href="{{ URL::asset('theme/v1/plugins/DataTables/media/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('theme/v1/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('theme/v1/plugins/sweet-alert/sweetalert.min.css') }}" rel="stylesheet">
@stop

@section('content')

<div ng-app="masterFundApp" ng-controller="MasterFundCtrl as frm">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item active">Transfer Master Fund</li>
    </ol>
    <h1 class="page-header">Transfer Master Fund</h1>
    <div class="panel">
        <div class="panel-heading">
            <h4 class="panel-title text-dark">Transfer master fund to members</h4>
        </div>
        <div class="panel-body">
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
                                    <th>Message</th>    
                                    <th>Amount Requested</th>   
                                    <th>Total Received</th>   
                                    <th>Date Transferred</th>
                                    <th>Action</th>  
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="default-tab-2">
                    <form class="ng-pristine ng-valid-email ng-invalid ng-invalid-required" name="transferMasterFundFrm" ng-submit="frm.submitTransferMasterFund(transferMasterFundFrm.$valid)" autocomplete="off">
                        <div class="row p-4 m-t-15">
                            <div class="col-md-6 offset-md-3">
                                <div class="form-group">
                                    <label for="input-normal">Username <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" placeholder="Username" name="username" ng-model="frm.username" required>
                                </div>
                            </div>
                            <div class="col-md-6 offset-md-3">
                                <div class="form-group">
                                    <label for="input-normal">Amount <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" placeholder="Amount" name="amount" ng-model="frm.amount" required>
                                </div>
                            </div>
                            <div class="col-md-6 offset-md-3">
                                <div class="form-group">
                                    <label for="input-normal">Security Pin <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" placeholder="Security Pin" name="pin" ng-model="frm.pin" maxlength="6" required>
                                </div>
                            </div>
                            <div class="col-md-12 m-t-15 text-center">
                                <button type="submit" ng-disabled="transferMasterFundFrm.$invalid" id="transfer_master_fund_btn" class="btn btn-danger">Transfer</button> 
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
<script src="{{ URL::asset('theme/v1/plugins/sweet-alert/sweetalert.min.js') }}"></script>
<script type="text/javascript">
    (function () {

        var masterFundApp = angular.module('masterFundApp', ['angular.filter']);
        masterFundApp.controller('MasterFundCtrl', function ($scope, $http, $sce) {

            var vm = this;

            getdata();
            function getdata() {

                $("#content-table").dataTable().fnDestroy();
                $("#content-table").hide();  
                $('#loading').show(); 

                angular.element(document).ready( function () {

                    var t = $('#content-table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '/helper/transfer-master-fund-data',
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
                            {data: 'amount', name: 'amount', orderable: true, searchable: true},
                            {data: 'total', name: 'total', orderable: true, searchable: true},
                            {data: 'date', name: 'created_at'},
                            {data: 'action', name: 'action'}
                        ],
                        order: [[4, 'desc']],
                        "initComplete": function(settings, json) { 
                               $('#loading').delay( 300 ).hide(); 
                               $("#content-table").delay( 300 ).show(); 
                        } 
                    });

                 });

            }

            vm.submitTransferMasterFund = function () {
                
                swal({
                    title: "Are you sure want to transfer master fund to this user?",
                    type: "warning",
                    html: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    showCancelButton: true,
                },
                
                function() {

                    $scope.btndisabled = true;
                    $("#transfer_master_fund_btn").hide();

                    $http({
                        method: 'POST',
                        url: '/helper/transfer-master-fund',
                        data: JSON.stringify({
                           username: vm.username,
                           amount: vm.amount,
                           pin: vm.pin
                        })
                    }).success(function (data) {
                        if (data.result==1){

                            toastr.info(data.message);

                            setTimeout(window.location.href = '/helper/transfer-master-fund', 10000);
                        } else {
                            $("#transfer_master_fund_btn").show();
                            $scope.btndisabled = false;
                            toastr.warning(data.message);
                        
                        }
                    }).error(function (data) {

                        $("#transfer_master_fund_btn").show();
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

            vm.retrieveFund = function (id) {

                var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
                swal({
                    title: "Retrieve Master Fund",
                    text: "Amount to be retrieve",
                    input: 'number',
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    animation: "slide-from-top",
                    inputPlaceholder: "Amount"
                },
                function(amount){

                    if(amount === false) return false;

                    if (amount === "") {
                      swal.showInputError("You need to write something!");
                      return false
                    }

                    if (!$.isNumeric(amount)) {
                      swal.showInputError("Amount must be a number!");
                      return false
                    }

                    $.ajax({
                       type:'POST',
                       url:'/helper/master-fund/'+id+'/retrieve',
                       data:{_token: CSRF_TOKEN, amount:amount},
                       dataType: 'JSON',
                       success:function(data){
                        if (data.result == 1){
                            swal({
                                title: data.message ,
                                type: "success",
                                html: true,
                            },
                            function() {
                                getdata();
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

            };

        });
    })();

</script>

@stop