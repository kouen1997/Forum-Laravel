@extends('layouts.backend.master')

@section('title', 'Interior Design')

@section('header_scripts')

@stop

@section('content')
<div ng-app="interiordesignApp" ng-controller="interiordesignCtrl as frm">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card bg-boxshadow mb-3">
                    <div class="card-body">
                        <h4 class="card-title">Interior Design List</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-data">
                                    @include('member.interior_design_data')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="deleteInteriorDesignModal" tabindex="-1" role="dialog" aria-labelledby="deleteInteriorDesignModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
            <form class="deleteInteriorDesignFrm">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" style="font-size: 15px;"><i class="fa fa-times-circle" style="color: #000;"></i> Delete Interior Design</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-25px;">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">

                        Are you sure you want to delete this?

                </div>
                <div class="modal-footer">
                    <input type="hidden" id="interior_design_id" name="interior_design_id" value="" />
                    <button type="button" class="btn btn-sm btn-default pl-5 pr-5" data-dismiss="modal"> Cancel </button>
                    <button type="submit" id="delete_interior_design_btn" class="btn btn-sm btn-primary pl-5 pr-5">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer_scripts')
<script type="text/javascript">
    (function () {
        var interiordesignApp = angular.module('interiordesignApp', ['angular.filter']);
        interiordesignApp.controller('interiordesignCtrl', function ($scope, $http, $sce, $compile) {

            var vm = this;

            $(document).on("click",'.pagination a',function(e){
                e.preventDefault();
                var page = $(this).attr('href').split('page=')[1];

                $http({
                    method: 'GET',
                    url: '/pagination/interior-design/listing?page='+page,
                    headers: {
                        'Content-Type': undefined
                    }
                }).then(function successCallback(response) {

                    if (response.data.status == 'success'){

                        $('.table-data').html('<h3 class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait, the data is loading ...</h3>');

                        setTimeout(function () {
                            $('.table-data').html($compile(response.data.responseHtml)($scope));
                        }, 2000);
                    }

                }, function errorCallback(response) {
                   
                    if (response.data.status){

                        swal("","Something went wrong. Please try again!", "warning");
                         
                    } else {
                        var errors = [];
                        angular.forEach(response.data.errors, function(message, key){
                            errors.push(message[0]);
                        });
                    
                        swal("",errors.toString().split(",").join("\n \n"),"error");
                    }
                    
                });

            });

            vm.deleteInteriorDesign = function(interior_design_id){
                $('#deleteInteriorDesignModal').appendTo('.main-content').modal('show');
                $(".modal-footer #interior_design_id").val(interior_design_id)
            };

            var frm = $('.deleteInteriorDesignFrm');

            frm.submit(function (e) {

                $('#delete_interior_design_btn').attr('disabled', true).append(' <i class="fa fa-spinner fa-pulse "></i>');

                var interior_design_id = document.getElementById("interior_design_id").value;

                 $.ajax({
                    type: 'GET',
                    url: '/interior_design/'+interior_design_id+'/delete',
                    data: frm.serialize()
                }).done(function(data) {

                   if(data.status == 'success'){
                        console.log(data.status);

                       
                        $('.interior_design_'+interior_design_id).remove();
                        $('#delete_interior_design_btn').attr('disabled', false).html('Delete'); 
                        $('#deleteInteriorDesignModal').appendTo(".main-content").modal('hide');

                        
                    }
                }).fail(function(data) {
                    $('#delete_interior_design_btn').attr('disabled', false).html('Delete')

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