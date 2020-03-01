@extends('layouts.backend.master')

@section('title', 'Transfer Load Wallet | Helper')

@section('header_scripts')
<link href="{{ URL::asset('theme/v1/plugins/DataTables/media/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('theme/v1/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('theme/v1/plugins/sweet-alert/sweetalert.min.css') }}" rel="stylesheet">
@stop

@section('content')

<div ng-app="eloadingApp" ng-controller="EloadingCtrl as frm">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item active">Transfer Load Wallet</li>
    </ol>
    <h1 class="page-header">Transfer Load Wallet</h1>
    <div class="panel">
        <div class="panel-heading">
            <h4 class="panel-title text-dark">Transfer load wallet to members</h4>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 text-center">
                    <h3><strong>Current Load Wallet Balance</strong></h3>
                    <h1 class="m-b-5 text-danger">&#8369;{{ number_format($total_load_wallet) }}</h1>
                </div>
            </div>
            <hr>
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
                    <div class="table-responsive py-4">
                        <div id="loading-transfer">
                            <h3 class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait...</h3>
                        </div>
                        <table class="table table-striped table-bordered" id="content-table-transfer" width="100%">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th width="40%">Message</th>    
                                    <th>Total</th>   
                                    <th>Date Transferred</th>
                                    <th>Action</th>    
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="history in data.transfer_history" class="middle text-center">
                                    <td></td>
                                    <td>
                                        <span ng-if="history.transfer_by_user_id == {{$user->id}}">
                                            You have transferred <strong class="text-danger">&#8369;@{{ history.amount }}</strong> load wallet to @{{history.transfer_to.username}}
                                        </span>
                                        <span ng-if="history.transfer_to_user_id == {{$user->id}}">
                                            You have received <strong class="text-danger">&#8369;@{{ history.amount }}</strong> load wallet from  @{{history.transfer_by.username}}
                                        </span>
                                    </td>
                                    <td><strong class="text-danger">&#8369;@{{ history.total }}</strong></td>
                                    <td>@{{ history.created_at }}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" ng-click="frm.retrieveFund(history.id)" >Retrieve</button>
                                    </td>
                                </tr>
                          </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="default-tab-2">
                    <form class="ng-pristine ng-valid-email ng-invalid ng-invalid-required" name="transferFrm" ng-submit="frm.transferLoad(transferFrm.$valid)" autocomplete="off">
                        <div class="row p-4 m-t-20">
                            <div class="col-md-6 offset-md-3">
                                <div class="form-group">
                                    <label for="input-normal">Username or Email <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" placeholder="Username or Email" name="user" ng-model="frm.user" required="">
                                </div>
                            </div>
                            <div class="col-md-6 offset-md-3" >
                                <div class="form-group">
                                    <label for="input-normal">Amount <span class="text-danger">*</span></label>
                                     <input type="text" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" placeholder="Amount" name="amount" ng-model="frm.amount" maxlength="4" required="">
                                </div>
                            </div>
                            <div class="col-md-6 offset-md-3">
                                <div class="form-group">
                                    <label for="input-normal">Security Pin <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-require" placeholder="Security Pin" name="pin" ng-model="frm.pin" maxlength="6" required="">
                                </div>
                            </div>
                            <div class="col-md-12 m-t-15 text-center">
                                <button type="submit" ng-disabled="transferFrm.$invalid" id="transfer_load_btn" class="btn btn-danger">
                                    Transfer           
                                </button>
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

        $("#content-table").hide();

        var eloadingApp = angular.module('eloadingApp', ['angular.filter']);
        eloadingApp.controller('EloadingCtrl', function ($scope, $http, $sce) {

            var vm = this;

            getdata();
            function getdata() {

                $('#loading-eloading').show();
                $("#content-table-eloading").dataTable().fnDestroy();
                $("#content-table-eloading").hide();

                $('#loading-transfer').show();
                $("#content-table-transfer").dataTable().fnDestroy();
                $("#content-table-transfer").hide();

                $http.get('/helper/eloading-history-data').success(function (data) {

                    $scope.data = data;

                    angular.element(document).ready( function () {


                        var t = $('#content-table-eloading').DataTable( {
                            lengthChange: false,
                            info: false,
                            
                            responsive: true,
                             "initComplete": function(settings, json) {
                                $('#loading-eloading').hide();
                                $("#content-table-eloading").show();
                              }
                        } );

                        t.on( 'order.dt search.dt', function () {
                           t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                              cell.innerHTML = i + 1;
                              t.cell(cell).invalidate('dom'); 
                           } );
                        } ).draw();

                        var t = $('#content-table-transfer').DataTable( {
                            lengthChange: false,
                            info: false,
                            autoWidth: true,
                            responsive: true,
                             "initComplete": function(settings, json) {
                                $('#loading-transfer').hide();
                                $("#content-table-transfer").show();
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

            vm.retrieveFund = function (id) {

                var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
                swal({
                    title: "Retrieve Eloading Wallet",
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
                       url:'/helper/'+id+'/eloading-retrieve',
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

            vm.transferLoad = function () {
                
                swal({
                    title: "Are you sure want to transfer load wallet?",
                    type: "warning",
                    html: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    showCancelButton: true,
                },
                
                function() {
                
                    $('#transfer_load_btn').prop('disabled', true);
                    $('#transfer_load_btn').html('Transferring <i class="fa fa-spinner fa-spin"></i>');

                    $http({
                        method: 'POST',
                        url: '/helper/eloading-transfer',
                        data: JSON.stringify({
                           user: vm.user,
                           amount: vm.amount,
                           pin: vm.pin
                        })
                    }).success(function (data) {
                        console.log(data);
                        if (data.result == 1){

                            toastr.info(data.message);
                            setTimeout(window.location.href = '/helper/eloading-transfer', 30000);

                        } else {
                            $('#transfer_load_btn').prop('disabled', false);
                            $('#transfer_load_btn').html('Transfer');
                            toastr.info(data.message);
                        }
                    }).error(function (data) {
                        $('#transfer_load_btn').prop('disabled', false);
                        $('#transfer_load_btn').html('Transfer');
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