<div class="feature-box gray centered">
  <div>
    <div class="container">
      <div class="main-title"><span>News &amp; Updates </span></div>
      <div class="main-title-description">Stay up to date with the latest happenings.</div>
      <div class="row justify-content-md-center">
        @if(count($newss) > 0)

          @foreach($newss as $news)

            <div class="col col-lg-3 col-xl-3">
              <div class="item-listing grid mb50">
                <div class="row">
                  <div class="col-md-12">
                    <div class="item">
                      <div class="item-image"> <a href="#"><img src="{{ URL::asset('news/'.$news->cover_image) }}" class="img-fluid" alt="">
                        <div class="item-meta">
                          <div class="item-price"><small>{{ date("F j, Y",strtotime($news->created_at)) }}</small> </div>
                        </div>
                        </a> </div>
                      <div class="item-info">
                        <h3 class="item-title">
                          <a href="{{ url('/news/view/'.$news->slug) }}">
                            @if(strlen($news->title) > 25)
                              {{ substr($news->title, 0, 25).' ...' }}
                            @else
                              {{ $news->title }}
                            @endif
                          </a>
                        </h3>
                        <div class="item-author">By HomeBook</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          @endforeach

        @else

          <div class="alert alert-danger">No news available</div>

        @endif
      </div>
    </div>
  </div>
</div>