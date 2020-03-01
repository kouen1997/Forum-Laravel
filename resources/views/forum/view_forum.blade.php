@extends('layouts.dashboard.master')

@section('title', $forum->title)

@section('header_scripts')
<style type="text/css">
    .deleteComment{
        color: #bdbdbd;
        float:right;
    }
    .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropdown-content {
      margin-top: 12px;
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
            <div class="col-xl-9 col-lg-7 col-md-7 mb-4">
                <div class="p-3 bg-white">
                    <div style="padding:20px; word-break: break-all;">
                        
                        <h1 class="pb-2 mb-0">{{ $forum->title }}</h1>
                        <small>BY <b>{{ strtoupper($forum->user->username) }}</b> - {{ $forum->created_at->diffforHumans() }} in 

                        <span class="badge {{ $forum->category->badge }}">{{ $forum->category->category_name }}</span>
                        <br>
                        TOTAL VIEWS: {{ $forum->views->count() }}
                        </small>

                        <div style="padding:20px;">{!! $forum->content !!}</div>
                    </div>
                 </div>
                 <div class="comment-reply-area" style="padding-top:20px;">
                    <b>Comments</b>
                    <br>
                    <br>
                    <div class="comment-list">
                        <div class="row" id="comment-list">
           
                            @if(count($comments) > 0)

                                @foreach($comments as $comment)
                                    @include('forum.comments')
                                @endforeach

                            @else

                                <div class="col-md-12" id="comment_alert">
                                    <div class="alert alert-warning"> No comments </div>
                                </div>

                            @endif
                        </div>
                    </div>
                    <div class="comment-section">
                        <div class="row">
                            <div class="col-md-12">
                                <form class="comment-form" method="POST" ng-submit="form.submitComment()">
                                    <textarea placeholder="Write your comment" ng-enter="form.submitComment('{{$forum->id}}')" name="comment_{{$forum->id}}" ng-model="form.comment" class="comment-field forum-comment comment{{$forum->id}} form-control" rows="3" placeholder="Write comment here.." required></textarea>
                                </form>
                            </div>
                        </div>
                    </div>
                 </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 mb-4">
                <div class="p-3 bg-white">
                    <h6>Latest Discussion</h6>
                    <div style="overflow-y: scroll; height: 300px; padding-right: 20px;">
                        @if(count($lastests) > 0)

                            @foreach($lastests as $latest)

                                <div class="media text-muted pt-3 forum-{{ $latest->id }}">
                                    <p class="media-body pb-3 mb-0 medium lh-125">
                                        <strong class="d-block text-gray-dark"><a href="{{ url('/forum/view/'.$latest->slug) }}">{{ $latest->title }}</a>
                                        </strong>
                                        <small>Category: 
                                            <a href="{{ url('/forum/category/'.$latest->category->slug) }}">{{ strtolower($latest->category->category_name) }}
                                            </a>
                                        </small>
                                        <span class="pull-right"><i class="fa fa-eye" style="color:#bdbdbd;"></i> {{ $latest->views->count() }} &nbsp;&nbsp;<i class="fa fa-comments" style="color:#bdbdbd;"></i> {{ $latest->comments->count() }}
                                    </p>
                                </div>

                            @endforeach

                            
                        @else

                            <div class="alert alert-danger"> No forum data found </div>

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
</span>

<div class="modal fade" id="editCommentModal" tabindex="-1" role="dialog" aria-labelledby="editCommentModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
          <form class="deleteForumFrm">
          {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" style="font-size: 15px;"><i class="fa fa-edit" style="color: #000;"></i> Edit Comment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-25px;">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div class="form-group">
                        <textarea name="content" placeholder="Edit Comment" rows="10" class="form-control comment-content"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="forum_id" name="forum_id" value="" />
                    <button type="button" class="btn btn-sm btn-default pl-5 pr-5" data-dismiss="modal"> Cancel </button>
                    <button type="submit" id="edit_comment_btn" class="btn btn-sm btn-primary pl-5 pr-5">Edit</button>
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

        vm.submitComment = function(forum_id){
            $http({
                method: 'POST',
                url: '/forum/'+forum_id+'/comment',
                data: JSON.stringify({
                    forum_id: forum_id,
                    comment: vm.comment
                })
            }).then(function successCallback(response) {

                if(response.data.status == 'success'){

                    $('#comment_alert').remove();
                    $('#comment-list').prepend($compile(response.data.data)($scope));
                    $('.forum-comment').val('');

                }else {

                    alert('one comment per 5 minutes only');

                }

            }, function errorCallback(response) {
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
        };

        vm.replyComment = function(forum_id, comment_id){

            var reply = $('.contentReply'+comment_id).val();

            $http({
                method: 'POST',
                url: '/forum/'+forum_id+'/'+comment_id+'/reply',
                data: JSON.stringify({
                    forum_id: forum_id,
                    comment_id: comment_id,
                    reply: reply
                })
            }).then(function successCallback(response) {

                if(response.data.status == 'success'){

                    $('.reply-list #reply-section-list-'+comment_id).prepend($compile(response.data.data)($scope));
                    $('.forum-reply').val('');

                }else {

                    alert('one reply per 5 minutes only');

                }

            }, function errorCallback(response) {
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
        };
        
        vm.editComment = function(forum_id){

            $('#editCommentModal').appendTo("body").modal('show');
            $(".modal-footer #forum_id").val(forum_id);

        };

    });

    HomebookApp.directive("filesInput", function() {
        return {
          require: "ngModel",
          link: function postLink(scope,elem,attrs,ngModel) {
            elem.on("change", function(e) {
              var files = elem[0].files;
              ngModel.$setViewValue(files);
            })
          }
        }
    });

    HomebookApp.directive('ngEnter', function () {
        return function (scope, element, attrs) {
            element.bind("keydown keypress", function (event) {
                if (event.which === 13) {
                    scope.$apply(function () {
                        scope.$eval(attrs.ngEnter);
                    });

                    event.preventDefault();
                }
            });
        };
    });

  })();

</script>
@stop
