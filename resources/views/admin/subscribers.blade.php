@extends('layouts.master')

@section('title', 'Subscribers')

@section('header_scripts')
<link href="{{ URL::asset('theme/v1/plugins/DataTables/media/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('theme/v1/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css') }}" rel="stylesheet" />
@stop

@section('content')
<div ng-app="subscribersApp" ng-controller="subscribersCtrl as frm">
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item active">Subscribers</li>
</ol>
<h1 class="page-header">Subscribers</h1>

    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">List of your Referrals</h4>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <div id="loading">
                    <h3 class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait...</h3>
                </div>
                <table class="table table-striped table-bordered" id="content-table" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Mobile no.</th>
                            <th>Status</th>
                            <th>Date Registered</th>
                            <th>Action</th>
                        </tr>
                    </thead>
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
<script>
	(function () {

        $("#content-table").hide();

        var subscribersApp = angular.module('subscribersApp', ['angular.filter']);
        subscribersApp.controller('subscribersCtrl', function ($scope, $http, $sce) {

            var vm = this;

            getdata();
            function getdata() {

                $("#content-table").dataTable().fnDestroy(); 
                $('#loading').show();
                $("#content-table").hide();
                
                angular.element(document).ready( function () {

                    var tbl = $('#content-table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '/admin/network/subscribers-data',
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
                        columnDefs: [
                            {
                                render: function (data, type, full, meta) {
                                    return "<div>" + data + "</div>";
                                },
                                targets: [0]
                            }
                         ],
                        columns: [
                            {data: 'DT_RowIndex', name: 'id', orderable: true, searchable: false},
                            {data: 'name', name: 'first_name', orderable: false, searchable: false},
                            {data: 'username', name: 'username', orderable: true, searchable: true},
                            {data: 'mobile', name: 'mobile', orderable: false, searchable: false},
                            {data: 'status', name: 'status', orderable: false, searchable: false},
                            {data: 'date', name: 'date', orderable: true, searchable: false},
                            {data: 'action', name: 'action', orderable: false, searchable: false}
                        ],
                        order: [[5, 'desc']],
                        "initComplete": function(settings, json) { 
                               $('#loading').delay( 300 ).hide(); 
                               $("#content-table").delay( 300 ).show(); 
                        } 
                    });

                });
            }

            vm.activateRetailer = function (id) {

                $('#btn_active_retailer_'+id).prop('disabled', true);
                $('#btn_active_retailer_'+id).html('Activating <i class="fa fa-spinner fa-spin"></i>');

                $http({
                    method: 'POST',
                    url: '/subscribers',
                    data: JSON.stringify({
                        user_id: id
                    })
                }).success(function (data) {
                    if (data.result == 1){
                        toastr.info(data.message);

                        setTimeout(window.location.href = '/subscribers', 10000);

                    } else {
                        $('#btn_active_retailer_'+id).prop('disabled', false);
                        toastr.info("Something went wrong. Please try again!");
                    }
                }).error(function (data) {
                    $('#btn_active_retailer_'+id).prop('disabled', false);
                    if(data.result == 0){

                        toastr.info(data.message);

                    } else {
                        
                        angular.forEach(data.errors, function(message, key){

                            toastr.warning(message);

                        });
                    }
                });

            }

        });
    })();

</script>
<script>
	$(document).ready(function() {
		TableManageResponsive.init();
	});
</script>
@stop