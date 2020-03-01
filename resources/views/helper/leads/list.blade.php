@extends('layouts.backend.master')

@section('title', 'Properties')

@section('header_scripts')
<link href="{{ URL::asset('assets/backend/css/default-assets/data-table.css') }}" rel="stylesheet" />
@stop

@section('content')
<div ng-app="propertyApp" ng-controller="PropertyCtrl as frm">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card bg-boxshadow mb-3">
                    <div class="card-body">
                        <h4 class="card-title">PROPERTIES</h4>
                        <div class="row">
                            <div class="table-responsive">
                                <div id="loading">
                                    <h3 class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait...</h3>
                                </div>
                                <table class="table table-striped table-bordered" id="content-table" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Property Title</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
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
<script type="text/javascript">
	(function () {

        $("#content-table").hide();

        var propertyApp = angular.module('propertyApp', ['angular.filter']);
        propertyApp.controller('PropertyCtrl', function ($scope, $http, $sce) {

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
                            url: '/helper/leads-data',
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
                            {data: 'property', name: 'property.title', orderable: false, searchable: false},
                            {data: 'name', name: 'name', orderable: true, searchable: true},
                            {data: 'phone', name: 'phone', orderable: false, searchable: false},
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

        });
    })();
</script>
@stop