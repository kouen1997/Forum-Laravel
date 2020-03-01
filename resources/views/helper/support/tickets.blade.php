@extends('layouts.master')

@section('title', 'Tickets')

@section('header_scripts')
<link href="{{ URL::asset('assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/datatables/plugins/responsive/responsive.dataTables.min.css') }}" rel="stylesheet">
<style type="text/css">
    .dataTables_wrapper .dt-buttons {
        float: left!important;
    }
</style>
@stop

@section('content')

<div class="page-content-wrapper" ng-app="customerSupportApp" ng-controller="CustomerSupportCtrl as frm">
    <div class="page-content">
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <div class=" pull-left">
                    <div class="page-title">Tickets</div>
                </div>
            </div>
        </div>
         <!-- add content here -->
         <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile-content">
                        <div class="card card-topline-aqua">
                            <div class="card-body no-padding">
                                <div class="row">
                                    <div class="col-md-12">
                                        @if(session('success'))
                                        <div class="col-md-12 m-t-20">
                                            <div class="alert label-success alert-dismissible text-center" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                {!! session('success') !!}
                                            </div>
                                        </div> 
                                        @endif
                                        @if(session('danger'))
                                        <div class="m-t-20">
                                            <div class="alert label-danger alert-dismissible text-center" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                {!! session('danger') !!}
                                            </div>
                                        </div> 
                                        @endif
                                        <div id="loading">
                                            <h3 class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait, the data is loading ...</h3>
                                        </div>
                                        <div class="table-responsive py-4" style="display: none">
                                            <table class="table table-striped table-bordered text-center" id="content-table" width="100%" style="display: none">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Subject</th>
                                                        <th>Status</th>
                                                        <th>Category</th>
                                                        <th>Member</th>
                                                        <th>Last Updated</th>
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
      </div>
    </div>
</div>

@endsection

@section('footer_scripts')
<script src="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.js') }}" ></script>
<script src="{{ URL::asset('assets/plugins/datatables/plugins/buttons/dataTables.buttons.min.js') }}" ></script>
<script src="{{ URL::asset('assets/plugins/datatables/plugins/buttons/buttons.print.min.js') }}" ></script>
<script src="{{ URL::asset('assets/plugins/datatables/plugins/buttons/buttons.html5.min.js') }}" ></script>
<script src="{{ URL::asset('assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap4.min.js') }}" ></script>
<script src="{{ URL::asset('assets/plugins/datatables/plugins/responsive/dataTables.responsive.min.js') }}" ></script>
<script type="text/javascript">
    (function () {

        $("#content-table").hide();

        var customerSupportApp = angular.module('customerSupportApp', ['angular.filter']);
        customerSupportApp.controller('CustomerSupportCtrl', function ($scope, $http, $sce) {

            var vm = this;

            getdata();
            function getdata() {

                $("#content-table").dataTable().fnDestroy();
                $(".table-responsive").hide();  
                $('#loading').show();  
            
                angular.element(document).ready( function () {


                    var t = $('#content-table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '/helper/customer-support-data',
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
                            {data: 'DT_Row_Index', orderable: false, searchable: false},
                            {data: 'subject', name: 'subject', orderable: false, searchable: false},
                            {data: 'status', name: 'status', orderable: false, searchable: true},
                            {data: 'category', name: 'category', orderable: false, searchable: true},
                            {data: 'member', name: 'member', orderable: false, searchable: true},
                            {data: 'updated_at', name: 'updated_at', orderable: false, searchable: true}
                        ],
                        order: [[1, 'desc']],
                        "initComplete": function(settings, json) { 
                            $('#loading').delay( 300 ).hide(); 
                            $("#content-table").show(); 
                            $(".table-responsive").delay( 300 ).show();  
                        } 
                    });

                 });
             }

        });
    })();

</script>

@stop