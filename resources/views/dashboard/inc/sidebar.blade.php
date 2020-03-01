<aside class="col-md-4 blog-sidebar">
    <div class="p-3 mb-3 mt-2 bg-white rounded shadow-light">
        <h4>About</h4>
        <p class="mb-0">HomeBook is an Affiliate Marketing Company which focuses on <em><strong>Real Estate</strong></em>. You may use it for FREE but being a <strong>Basic</strong> or <strong>Premium</strong> Member will open up more <strong>services</strong> for you to avail.</p>
    </div>
    <div class="my-4 p-3 bg-white shadow-light">
        <h5 class="pb-2 mb-2">Recent property</h5>
        @if($recent_property)
        <div class="sidebar-featured-news-item pb-2 mb-2">
            <a href="{{ url('/property/'.$recent_property->slug) }}" target="_blank">
                <img class="img-fluid" src="{{ $recent_property->photos->first()['filename'] }}" height="90" width="280" alt="{{ $recent_property->title }}">
            </a>
            <div class="media text-muted pt-3">
                <p class="media-body pb-3 mb-0 medium lh-125 border-bottom border-gray">
                    <strong class="d-block text-gray-dark"><a href="{{ url('/property/'.$recent_property->slug) }}" target="_blank" class="h-link" title="{{ $recent_property->title }}">{{ str_limit(strip_tags($recent_property->title), $limit = 25, $end = '...') }}</a></strong>
                    <span class="pb-3 mb-0 small">{{ date('F j, Y', strtotime($recent_property->created_at)) }}</span><br>
                    {{ str_limit(strip_tags($recent_property->description), $limit = 90, $end = '...') }}
                </p>
            </div>
        </div>
        @endif
    </div>
    <div class="my-4 p-3 bg-white shadow-light">
        <h5 class="pb-2 mb-0">Forum updates</h5>
        @if(count($forums) > 0)

            @foreach($forums as $forum)
                <br>
                <strong class="d-block text-gray-dark"><a href="{{ url('/forum/view/'.$forum->slug) }}">{{ $forum->title }}</a>
                </strong>
                <div class="media text-muted pt-3 forum-{{ $forum->id }}" style="word-break: break-all;">
                    <small>
                        {!! substr($forum->content, 0, 200) !!}
                    </small>
                </div>

                <div class="footer">
                    <span>
                        By: {{ $forum->user->username }}
                    </span>
                    <span class="pull-right">
                        <i class="fa fa-eye" style="color:#bdbdbd;"></i> {{ $forum->views->count() }} &nbsp;&nbsp;<i class="fa fa-comments" style="color:#bdbdbd;"></i> {{ $forum->comments->count() }}
                    </span>
                </div>

            @endforeach

        @endif
        <small class="d-block text-right mt-3">
            <a href="{{ url('/forum') }}">Visit Forum</a>
        </small>
    </div>
</aside>