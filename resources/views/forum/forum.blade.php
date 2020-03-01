@extends('layouts.dashboard.master')

@section('title', 'Forum')

@section('header_scripts')
<style type="text/css">
    .fa{
        color: #bdbdbd;
    }
    .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropdown-content {
      margin-left: -100px;
      display: none;
      position: absolute;
      background-color: #fff;
      min-width: 120px;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      padding: 12px 16px;
      z-index: 1;
    }

    .dropdown:hover .dropdown-content {
      display: block;
    }
</style>
@stop

@section('content')
<div ng-app="HomebookApp" ng-controller="HomebookCtrl as form">

<main role="main" class="pt-5 py-3 pl-5 pr-5 desk-padding bg-light-2">
    
    <div class="row">
        <div class="col-xl-2 col-lg-2 col-md-2 mb-4">
            Search
                <br>
                <br>
                <form action="{{ url('/forum/search/keyword') }}" method="post" role="search">
                    {{ csrf_field() }}  
                    <div class="form-group">
                        <input type="text" name="search" class="form-control" placeholder="Search.." required>
                    </div>
                </form>
            Category
            <br>
            <br>

            <ul style="list-style-type: none;padding: 10px;">
                    <li><a href="{{ url('/forum/category/all') }}">ALL CATEGORIES</a></li>
                    <br>
                @foreach($categories as $category)
                    <li><a href="{{ url('/forum/category/'.$category->slug) }}">{{ $category->category_name }}</a></li>
                    <br>
                @endforeach
            </ul>
        </div>
        <div class="col-xl-7 col-lg-7 col-md-7 mb-4">
            
            <h5 class="pb-2 mb-0">Forum <small class="pull-right" style="color:#bdbdbd;"><a href="{{ url('/write/forum') }}"><i class="fa fa-comment" style="color: #007bff;"></i> Start Discussion</a></small></h5>

            @if(count($forums) > 0)

                @foreach($forums as $forum)
                    <div class="p-3 bg-white" style="margin-top: 10px;">
                        <div class="row">

                            <div class="col-md-9" style="border-right: 1px solid #bdbdbd;">
                                <div style="padding:10px; word-break: break-all;">
                                    <h6 class="pb-2 mb-0"><a href="{{ url('/forum/view/'.$forum->slug) }}">{{ $forum->title }}</a></h6>
                                    <small>by <b>{{ $forum->user->username }}</b></small> 
                                    <span class="badge {{ $forum->category->badge }}">{{ $forum->category->category_name }}</span>
                                    <br>
                                    <br>
                                    {!!  substr($forum->content, 0, 150) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-lg-12" style="border-bottom: 1px solid #bdbdbd;">
                                        <p class="media-body pb-3 mb-0 medium lh-125 
                                        " style="text-align: center;padding-top: 10px;">
                                            <span><i class="fa fa-comments" style="font-size: 30px;"></i> {{ $forum->comments->count() }}</span>
                                        </p>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <p class="media-body pb-3 mb-0 medium lh-125" style="text-align: center;padding-top: 10px;">
                                                    <span style="font-size: 10px;"><i class="fa fa-eye" style="font-size: 15px;"></i> {{ $forum->views->count() }}</span>
                                                </p>
                                            </div>

                                            <div class="col-md-8">

                                                <p class="media-body pb-3 mb-0 medium lh-125" style="text-align: center;padding-top: 10px;">
                                                    <span style="font-size: 10px;"><i class="fa fa-clock-o" style="font-size: 15px;"></i> {{ $forum->created_at->diffforHumans() }}</span>
                                                </p>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-lg-12">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach

                
            @else

                <div class="alert alert-danger"> No forum data found </div>

            @endif
            <div style="padding-top: 1em; float: right;"> 
                {!! $forums->render() !!}
            </div>

        </div>
        @if(count($forums) > 0)
            <div class="col-xl-3 col-lg-3 col-md-3 mb-4">
                <div class="p-3 bg-white">

                    <h6>My Discussion</h6>
                    <div style="overflow-y: scroll; height: 300px; padding-right: 20px;">
                        @if(count($userForums) > 0)

                            @foreach($userForums as $userForum)

                                <div class="media text-muted pt-3 forum-{{ $userForum->id }}">
                                    <p class="media-body pb-3 mb-0 medium lh-125">
                                        <strong class="d-block text-gray-dark"><a href="{{ url('/forum/view/'.$userForum->slug) }}">{{ $userForum->title }}</a>

                                        </strong>

                                        <small>Category: 
                                            <a href="{{ url('/forum/category/'.$userForum->category->slug) }}">{{ strtolower($userForum->category->category_name) }}
                                            </a>
                                        </small>
                                        <span class="pull-right">

                                            <i class="fa fa-eye" style="color:#bdbdbd;"></i> {{ $userForum->views->count() }} &nbsp;&nbsp;

                                            <i class="fa fa-comments" style="color:#bdbdbd;"></i> {{ $userForum->comments->count() }} &nbsp;&nbsp;


                                            <div class="dropdown" style="color:#000; cursor: pointer; font-weight: normal;">
                                              <span><i class="fa fa-ellipsis-v" aria-hidden="true"></i></span>
                                              <div class="dropdown-content">
                                                <a href="{{ url('/forum/edit/'.$userForum->slug) }}" style="color:#000;"><i class="fa fa-edit" style="color:#000;"></i> Edit</a><br>
                                                <span ng-click="form.deleteForum('{{ $userForum->id }}')"><i class="fa fa-times" style="color:#000;"></i> Delete</span>
                                              </div>
                                            </div>

                                        </span>
                                    </p>
                                </div>

                            @endforeach

                            
                        @else

                            <div class="alert alert-danger"> No forum data found </div>

                        @endif
                    </div>
                </div>

                <div class="my-4 p-3 bg-white">

                    <h6>Most Viewed</h6>
                   @if(count($mostViewed) > 0)

                        @foreach($mostViewed as $mostV)

                            <div class="media text-muted pt-3">
                                <p class="media-body pb-3 mb-0 medium lh-125">
                                    <strong class="d-block text-gray-dark"><a href="{{ url('/forum/view/'.$mostV->forum->slug) }}">{{ $mostV->forum->title }}</a>
                                    </strong>
                                    <small>Category: 
                                        <a href="{{ url('/forum/category/'.$mostV->forum->category->slug) }}">{{ strtolower($mostV->forum->category->category_name) }}
                                        </a>
                                    </small>
                                    <span class="pull-right"><i class="fa fa-eye" style="color:#bdbdbd;"></i> {{ $mostV->forum->views->count() }} &nbsp;&nbsp;<i class="fa fa-comments" style="color:#bdbdbd;"></i> {{ $mostV->forum->comments->count() }}
                                </p>
                            </div>

                        @endforeach

                        
                    @else

                        <div class="alert alert-danger"> No forum data found </div>

                    @endif
                </div> 

                <div class="my-4 p-3 bg-white">

                    <h6>Most Discuss</h6>
                   @if(count($mostDiscuss) > 0)

                        @foreach($mostDiscuss as $mostD)

                            <div class="media text-muted pt-3">
                                <p class="media-body pb-3 mb-0 medium lh-125 border-bottom border-gray">
                                    <strong class="d-block text-gray-dark"><a href="{{ url('/forum/view/'.$mostD->forum->slug) }}">{{ $mostD->forum->title }}</a>
                                    </strong>

                                    <small>Category: 
                                        <a href="{{ url('/forum/category/'.$mostD->forum->category->slug) }}">{{ strtolower($mostD->forum->category->category_name) }}
                                        </a>
                                    </small>
                                    <span class="pull-right"><i class="fa fa-eye" style="color:#bdbdbd;"></i> {{ $mostD->forum->views->count() }} &nbsp;&nbsp;<i class="fa fa-comments" style="color:#bdbdbd;"></i> {{ $mostD->forum->comments->count() }}
                                </p>
                            </div>

                        @endforeach

                        
                    @else

                        <div class="alert alert-danger"> No forum data found </div>

                    @endif
                </div>
            </div>

        @endif
    </div>
</main>
</div>
<div class="modal fade" id="deleteForumModal" tabindex="-1" role="dialog" aria-labelledby="deleteForumModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
          <form class="deleteForumFrm">
          {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" style="font-size: 15px;"><i class="fa fa-times-circle" style="color: #000;"></i> Delete Forum</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-25px;">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">

                        Are you sure you want to delete this forum?

                </div>
                <div class="modal-footer">
                    <input type="hidden" id="forum_id" name="forum_id" value="" />
                    <button type="button" class="btn btn-sm btn-default pl-5 pr-5" data-dismiss="modal"> Cancel </button>
                    <button type="submit" id="delete_forum_btn" class="btn btn-sm btn-primary pl-5 pr-5">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer_scripts')
<script type="text/javascript">
  (function () {
      var HomebookApp = angular.module('HomebookApp', ['angular.filter']);


    HomebookApp.controller('HomebookCtrl', function ($scope, $http, $sce, $compile) {
          
        var vm = this;
        
        vm.deleteForum = function(forum_id){

            $('#deleteForumModal').appendTo("body").modal('show');
            $(".modal-footer #forum_id").val(forum_id);

        };

        var frm = $('.deleteForumFrm');

        frm.submit(function (e) {

            $('#delete_forum_btn').attr('disabled', true).append(' <i class="fa fa-spinner fa-pulse "></i>');
            var forum_id = document.getElementById("forum_id").value;

            $http({
                method: 'POST',
                url: '/forum/'+forum_id+'/delete',
                data: frm.serialize()
            }).then(function successCallback(response) {

                if(response.data.status == 'success'){
                    console.log(response.data);

                    $('.forum-'+forum_id).remove();
                    $('#delete_forum_btn').attr('disabled', false).html('Delete'); 
                    $('#deleteForumModal').appendTo("body").modal('hide');

                    
                }
                
            }, function errorCallback(response) {
                
                $('#delete_forum_btn').attr('disabled', false).html('Delete')

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

 