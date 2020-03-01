<div class="col-md-2">
    
</div>
<div class="col-md-11">
    <div style="margin-left: 20px; font-weight: bold;">{{ $comment->user->username}} <small>{{ $comment->created_at->diffforHumans() }}</small>

        
    </div>
   <!--  <div class="dropdown pull-right" style="color:#000; cursor: pointer; font-weight: normal;">
      <span><i class="fa fa-ellipsis-v deleteComment" aria-hidden="true"></i></span>
      <div class="dropdown-content">
        <span ng-click="form.editComment('{{ $forum->id }}')"><i class="fa fa-edit" style="color:#000;"></i> Edit</span>
        <br>
        <span ng-click="form.deleteComment('{{ $forum->id }}')"><i class="fa fa-times" style="color:#000;"></i> Delete</span>
      </div>
    </div> -->
    <div class="comment-speech-cloud" style="margin-left: 10px; padding: 10px; height: auto; width: 450px;">
       {{ $comment->content }}

    </div>
    <a style="margin-left:800px; cursor: pointer;" data-toggle="collapse" href="#collapse_comment_reply_{{ $comment->id }}" role="button" aria-expanded="false" aria-controls="collapse_comment_reply_{{ $comment->id }}"><small><i class="fa fa-reply"></i> reply</small></a>

    <br>
    <br>
    <div class="reply-list collapse" id="collapse_comment_reply_{{ $comment->id }}">
        <div class="reply-section">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-10">
                            <form class="comment-form inline-items" method="POST" ng-submit="form.replyComment()">
                                <textarea placeholder="Write your reply" ng-enter="form.replyComment('{{ $forum->id }}','{{$comment->id}}')" name="Replycomment_{{$forum->id}}" name="contentReply{{$comment->id}}" ng-model="form.contentReply{{$comment->id}}" class="comment-field forum-comment forum-reply contentReply{{$comment->id}} form-control" colspan="5" rows="3" style="width: 700px;" required></textarea>
                            </form>
                        <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row" id="reply-section-list-{{ $comment->id }}">

        </div>
        @if($comment->replies->count() > 0)
            <div class="row">
                @foreach($comment->replies as $reply)
                    @include('forum.replies')
                @endforeach
            </div>
            <br>
            <br>

        @endif
    </div>
</div>
