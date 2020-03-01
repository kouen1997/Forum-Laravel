@extends('layouts.backend.master')

@section('title', 'Codes')

@section('header_scripts')
<link href="{{ URL::asset('assets/backend/css/default-assets/data-table.css') }}" rel="stylesheet" />
@stop

@section('content')
<div ng-app="activationCodesApp" ng-controller="activationCodesCtrl as frm">
    <div class="col-12 mb-3">
        <div class="card bg-boxshadow full-height">
            <div class="card-body">
                <h4 class="card-title">Codes</h4>
                <div class="table-responsive">
                    <div id="loading">
                        <h3 class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait...</h3>
                    </div>
                    <table class="table table-striped table-bordered" id="content-table" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Code</th>
                                <th>Type</th>
                                <th>Used to (Account name)</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer_scripts')
<script src="{{ URL::asset('assets/backend/js/default-assets/data-table.min.js') }}"></script>
<script>
	(function () {

        $("#content-table").hide();

        var activationCodesApp = angular.module('activationCodesApp', ['angular.filter']);
        activationCodesApp.controller('activationCodesCtrl', function ($scope, $http, $sce) {

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
                            url: '/activation-codes-data',
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
                            {data: 'code', name: 'code', orderable: false, searchable: true},
                            {data: 'code_type', name: 'code_type', orderable: false, searchable: true},
                            {data: 'used_by', name: 'used_by_user_id', orderable: false, searchable: false},
                            {data: 'status', name: 'status', orderable: false, searchable: false},
                            {data: 'date', name: 'date', orderable: true, searchable: false}
                        ],
                        order: [[3, 'desc']],
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