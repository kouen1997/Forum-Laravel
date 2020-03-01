@extends('layouts.backend.master')

@section('title', 'Codes History')

@section('header_scripts')
<link href="{{ URL::asset('assets/backend/css/default-assets/data-table.css') }}" rel="stylesheet" />
@stop

@section('content')
<div ng-app="activationCodesHistoryApp" ng-controller="activationCodesHistoryCtrl as frm">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card bg-boxshadow mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Codes History</h5>
                        <div class="ibox-content">
                            <div class="table-responsive">
                                <div id="loading">
                                    <h3 class="text-center"><i class="fa fa-spinner fa-spin"></i>Please wait...</h3>
                                </div>
                                <table class="table table-striped table-bordered" id="content-table" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Details</th>    
                                            <th>Code</th>   
                                            <th>Transferred at</th>
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
<script>
	(function () {

        $("#content-table").hide();

        var activationCodesHistoryApp = angular.module('activationCodesHistoryApp', ['angular.filter']);
        activationCodesHistoryApp.controller('activationCodesHistoryCtrl', function ($scope, $http, $sce) {

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
                            url: '/admin/transfer-codes-data',
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
                            {data: 'DT_RowIndex', name: 'id', orderable: true, searchable: false},
                            {data: 'details', name: 'details', orderable: false, searchable: false},
                            {data: 'code', name: 'code', orderable: false, searchable: true},
                            {data: 'date', name: 'created_at', orderable: true, searchable: false}
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