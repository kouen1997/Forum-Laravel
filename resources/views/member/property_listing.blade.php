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
                        <h4 class="card-title">Property List</h4>
                        <div class="row">
                            <div class="table-responsive">
                                <div id="loading">
                                    <h3 class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait...</h3>
                                </div>
                                <table class="table table-striped table-bordered" id="content-table" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Price</th>
                                            <th>Offer Type</th>
                                            <th>Property Type</th>
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

<div class="modal fade" id="deletePropertyModal" tabindex="-1" role="dialog" aria-labelledby="deletePropertyModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
          <form class="deletePropertyFrm">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" style="font-size: 15px;"><i class="fa fa-times-circle" style="color: #000;"></i> Delete Property</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-25px;">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">

                        Are you sure you want to delete this property?

                </div>
                <div class="modal-footer">
                    <input type="hidden" id="property_id" name="property_id" value="" />
                    <button type="button" class="btn btn-sm btn-default pl-5 pr-5" data-dismiss="modal"> Cancel </button>
                    <button type="submit" id="delete_property_btn" class="btn btn-sm btn-primary pl-5 pr-5">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer_scripts')
<script src="{{ URL::asset('assets/backend/js/default-assets/data-table.min.js') }}" defer></script>
<script type="text/javascript">
    (function () {

        $("#content-table").hide();

        var propertyApp = angular.module('propertyApp', ['angular.filter']);
        propertyApp.controller('PropertyCtrl', function ($scope, $http, $sce, $compile) {

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
                            url: '/profile/property/listing/data',
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
                            {data: 'title', name: 'title', orderable: false, searchable: false},
                            {data: 'price', name: 'price', orderable: true, searchable: true},
                            {data: 'offer_type', name: 'offer_type', orderable: false, searchable: false},
                            {data: 'property_type', name: 'property_type', orderable: false, searchable: false},
                            {data: 'date', name: 'date', orderable: true, searchable: false},
                            {data: 'action', name: 'action', orderable: false, searchable: false}
                        ],
                        order: [[5, 'desc']],
                        "initComplete": function(settings, json) { 
                            $('#loading').delay( 300 ).hide(); 
                            $compile($("#content-table").delay( 300 ).show())($scope); 
                        } 
                    });

                });
            }

            vm.deleteProperty = function(property_id){

                $('#deletePropertyModal').appendTo('.main-content').modal('show');
                $(".modal-footer #property_id").val(property_id);

            };

            var frm = $('.deletePropertyFrm');

            frm.submit(function (e) {

                e.preventDefault();
                $('#delete_property_btn').attr('disabled', true).append(' <i class="fa fa-spinner fa-pulse "></i>');
                var property_id = document.getElementById("property_id").value;

                var row = $(".delete_properties_"+property_id).closest("tr");    // Find the row

                 $.ajax({
                    type: 'POST',
                    url: '/profile/property/'+property_id+'/delete',
                    data: frm.serialize()
                }).done(function(data) {

                   if(data.status == 'success'){
                        console.log(data.status);

                        row.remove(); 
                        $('#delete_property_btn').attr('disabled', false).html('Delete'); 
                        $('#deletePropertyModal').appendTo("body").modal('hide');

                        
                    }
                }).fail(function(data) {
                    $('#delete_property_btn').attr('disabled', false).html('Delete')

                    if (response.data.status){

                        swal("",response.data.message, "warning");
                         
                    } else {
                        var errors = [];
                        angular.forEach(response.data.errors, function(message, key){
                            errors.push(message[0]);
                        });
                    
                        swal("",errors.toString().split(",").join("\n \n"),"error");
                    }
                });
            });

        });
    })();
</script>
@stop