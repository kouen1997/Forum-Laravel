<div class="col-md-2">
</div>
<div class="col-md-10 reply-list-{{ $comment->id }}">
    <br>

    <div class="row">
        <div class="col-md-1">
            
            <div class="reply-avatar">
                <div class="row">
                    <div class="col-md-12">
                        <div class="vl" style="border-left: 6px solid green; height: 100px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-11">
            <div style="margin-left: 20px; font-weight: bold;">{{ $reply->user->username }} <small>{{ $reply->created_at->diffforHumans() }}</small>

            <!-- <div class="dropdown pull-right" style="color:#000; cursor: pointer; font-weight: normal;">
              <span><i class="fa fa-ellipsis-v deleteComment" aria-hidden="true"></i></span>
              <div class="dropdown-content">
                <a href="{{ url('/forum/edit/'.$forum->slug) }}" style="color:#000;"><i class="fa fa-edit" style="color:#000;"></i> Edit</a><br>
                <span ng-click="form.deleteForum('{{ $forum->id }}')"><i class="fa fa-times" style="color:#000;"></i> Delete</span>
              </div>
            </div> -->
    
            </div>
            <div class="reply-speech-cloud" style="margin-left: 10px; padding: 10px;  height: auto; width: 360px;">
                {{ $reply->content }}
            </div>
        </div>
    </div>
</div>