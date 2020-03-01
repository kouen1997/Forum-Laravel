@extends('layouts.master')

@section('title', 'Suspended Members')

@section('header_scripts')
<link href="{{ URL::asset('theme/v1/plugins/DataTables/media/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('theme/v1/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css') }}" rel="stylesheet" />
@stop

@section('content')

<div ng-app="suspendedApp" ng-controller="suspendedCtrl as frm">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item active">Suspended Members</li>
    </ol>
    <h1 class="page-header">Suspended Members</h1>
    <div class="panel">
        <div class="panel-body">
            <div id="loading">
                <h3 class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait, the data is loading ...</h3>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered text-center" id="content-table" width="100%" style="display: none">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Username</th>
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
<script type="text/javascript">
    (function () {
        var suspendedApp = angular.module('suspendedApp', ['angular.filter']);
        suspendedApp.controller('suspendedCtrl', function ($scope, $http, $sce) {
     
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
                            url: '/admin/suspended-data',
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
                            {data: 'member', name: 'member', orderable: false, searchable: false},
                            {data: 'username', name: 'username', orderable: false, searchable: true},
                            {data: 'action', name: 'action', orderable: true, searchable: false}
                        ],
                        order: [[1, 'desc']],
                        "initComplete": function(settings, json) { 
                            $('#loading').delay( 300 ).hide(); 
                            $("#content-table").show(); 
                            $("#content-table").delay( 300 ).show();  
                        } 
                    });

                 });
             }

            vm.retrieve = function (id) {
               
                var ans = confirm("Are you sure want to retrieve this user and marked as verified account?");
                
                if (ans){

                    $http({
                        method: 'POST',
                        url: '/admin/suspended/retrieve',
                        data: JSON.stringify({
                           user_id: id
                        })
                    }).success(function (data) {
                        if (data.result==1){

                            toastr.info(data.message);

                            getdata();
                        }
                    }).error(function (data) {

                      if(data.result == 0){

                        toastr.info(data.message);

                        } else {

                          angular.forEach(data.errors, function(message, key){

                            toastr.warning(message);

                          });
                        }
                    });
                }
            };

            vm.ban = function (id) {
               
                var ans = confirm("Are you sure want to banned this user?");
                
                if (ans){

                    $http({
                        method: 'POST',
                        url: '/admin/suspended/ban',
                        data: JSON.stringify({
                           user_id: id
                        })
                    }).success(function (data) {
                        if (data.result==1){

                            toastr.info(data.message);

                            getdata();
                        }
                    }).error(function (data) {

                      if(data.result == 0){

                        toastr.info(data.message);

                        } else {

                          angular.forEach(data.errors, function(message, key){

                            toastr.warning(message);

                          });
                        }
                    });
                }
            };

        });

    })();

</script>

@stop