@extends('layouts.master')

@section('title', 'Orders')

@section('header_scripts')
<link href="{{ URL::asset('theme/v1/plugins/DataTables/media/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('theme/v1/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css') }}" rel="stylesheet" />
@stop

@section('content')

<div ng-app="productInventoryApp" ng-controller="ProductInventoryCtrl as frm">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item active">Orders</li>
    </ol>
    <h1 class="page-header">Orders</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Order List</h4>
        </div>
        <div class="panel-body">                    
            <div class="table-responsive">
                <div id="loading">
                    <h3 class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait, the data is loading ...</h3>
                </div>
                <table class="table table-striped table-bordered" id="content-table" width="100%" style="display: none">
                    <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>Order Summary</th>
                            <th>Delivery Info</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="order in data.orders" class="middle text-center">
                            <td></td>
                            <td width="30%">
                                <div class="row">
                                    <div class="col-md-12" ng-repeat="order_product in order.products">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <img ng-src="@{{order_product.product.image}}" class="img img-responsive img-thumbnail" style="height: 50px;margin:0 auto;">  
                                            </div>
                                        </div>
                                        <div class="row m-t-10">
                                            <div class="col-md-12">
                                                <b>X @{{order_product.quantity}}</b><br>
                                                <b>Total Price: </b> ₱ @{{ order_product.price *  order_product.quantity}}<br>
                                                <b>Product Package: </b> <span class="text-danger">@{{ order_product.product.name}}</span><br>
                                                <b>Product Type: </b> <span class="text-danger">@{{ order_product.product.type}}</span>
                                            </div>
                                        </div>
                                        <hr>                            
                                    </div>
                                    <div class="col-md-12">
                                        <p>
                                            <b>MEMBER NAME:</b> @{{order.user.full_name}}<br>
                                            <b>USERNAME:</b> @{{order.user.username}}<br>
                                            <b>ORDER DATE:</b> @{{order.created_at}}<br>
                                            <b>TOTAL ORDER PRICE:</b> ₱ @{{order.total_price}}<br><br>
                                            <b>ORDER TYPE:</b> <span class="text-danger">@{{order.order_type}}</span>
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td width="25%">
                                <p ng-show="order.mode=='DELIVERY'">
                                    <b>Name: </b> @{{ order.name}}<br>
                                    <b>Contact Number:</b> @{{ order.contact_number}}<br>
                                    <b>Address:</b> @{{ order.delivery_address }}
                                </p>
                                <p ng-show="order.mode=='PICKUP'">
                                    <strong class="text-danger">FOR PICKUP</strong>
                                </p>
                            </td>
                            <td>
                                <span class="label label-sm label-danger" ng-show="order.status=='CANCELLED'">@{{order.status}}</span>
                                <span class="label label-sm label-warning" ng-show="order.status=='PENDING'">@{{order.status}}</span>
                                <span class="label label-sm label-warning" ng-show="order.status=='PROCESSING'">@{{order.status}}</span>
                                <span class="label label-sm label-primary" ng-show="order.status=='PAID'">@{{order.status}}</span>
                                <span class="label label-sm label-success" ng-show="order.status=='DELIVERED'">@{{order.status}}</span>
                            </td>
                            <td>
                                <small id="order_processing_@{{order.id}}" style="display:none">Processing... <i class="fa fa-spinner fa-spin"></i></small>
                                <select class="form-control form-control-sm form-control-round" name="order_status_@{{order.id}}" ng-model="frm.order_status[order.id]" id="order_status_@{{order.id}}"  ng-change="frm.changeOrderStatus(order.id)" ng-init="frm.order_status[order.id]=order.status">
                                    <option ng-value="PENDING">PENDING</option>
                                    <option ng-value="PROCESSING">PROCESSING</option>
                                    <option ng-value="CANCELLED">CANCELLED</option>
                                    <option ng-value="PAID">PAID</option>
                                    <option ng-value="DELIVERED">DELIVERED</option>
                                </select>
                                
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

        var productInventoryApp = angular.module('productInventoryApp', ['angular.filter']);
        productInventoryApp.controller('ProductInventoryCtrl', function ($scope, $http, $sce) {

            var vm = this;

            getdata();
            function getdata() {

                $("#content-table").dataTable().fnDestroy();
                $('#loading').show();
                $("#content-table").hide();

                $http.get('/helper/product-inventory/orders-data').success(function (data) {
                    $scope.data = data;

                    angular.element(document).ready( function () {


                        var t = $('#content-table').DataTable( {
                            lengthChange: false,
                            info: false,
                            autoWidth: true,
                            responsive: false,
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

            vm.changeOrderStatus = function (id) {

               
                $('#order_status_'+id).hide();
                $('#order_processing_'+id).show();

                $http({
                    method: 'POST',
                    url: '/helper/product-inventory/orders/status',
                    data: JSON.stringify({
                       id : id,
                       status: vm.order_status[id]
                    })
                }).success(function (data) {
                    $('#order_status_'+id).show();
                    $('#order_processing_'+id).hide();

                    if (data.result==1){
                        
                        toastr.info(data.message);

                        //getdata();
                    }

                }).error(function (data) {
                    $('#order_status_'+id).show();
                    $('#order_processing_'+id).hide();
                  
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