@extends('layouts.master')

@section('title', 'News')

@section('header_scripts')
<style type="text/css">

</style>
@stop

@section('content')
<div ng-app="HomebookApp" ng-controller="HomebookCtrl as form">
    <div class="container">
        <div class="row justify-content-md-center">
              <div class="col col-lg-12 col-xl-10">
            <div class="row has-sidebar">
              <div class="col-md-7 col-lg-8 col-xl-8">
                <div class="page-header v2 bordered mb0">
                <h3>Latest News</h3>
                </div>
                <div class="clearfix"></div>
                    @if(count($newss) > 0)

                        @foreach($newss as $news)

                            <div class="item-listing grid">
                                <div class="item item-lg">
                                    <div class="item-image"><a href="{{ url('/news/view/'.$news->slug) }}"><img src="{{ URL::asset('news/'.$news->cover_image) }}" class="img-fluid" alt="" style="width: 100%;">
                                    </a>
                                    </div>
                                    <h3 class="item-title"><a href="{{ url('/news/view/'.$news->slug) }}">{{ $news->title }}</a></h3>
                                    <div class="item-meta-info"><span class="date">{{ $news->created_at->diffforHumans() }}</span><span class="author">By Homebook</span></div>
                                    <a href="{{ url('/news/view/'.$news->slug) }}" class="read-more">Read More</a>
                                  </div>
                            </div>

                        @endforeach

                    @else

                        No news available

                    @endif

                    <div style="padding-top: 1em; float: right;"> 
                        {!! $newss->links() !!}
                    </div>
              </div>
              <div class="col-md-5 col-lg-4 col-xl-4 col-sidebar">
                <div id="sidebar" class="sidebar-right">
                  <div class="sidebar_inner">
                    <h3 class="subheadline">Most Viewed</h3>
                    <div class="list-group no-border">
                      @if(count($mostViewed) > 0)

                            @foreach($mostViewed as $mostV)

                                <br>
                                <p class="media-body pb-3 mb-0 medium lh-125 border-bottom border-gray">
                                    <strong class="d-block text-gray-dark"><a href="{{ url('/news/view/'.$mostV->news->slug) }}">{{ $mostV->news->title }}</a>
                                    </strong>
                                    <small>{{ $mostV->news->created_at->diffforHumans() }}</small>
                                    <span style="float: right;"><i class="fa fa-eye" style="color:#bdbdbd;"></i> {{ $mostV->news->views->count() }}
                                </p>

                            @endforeach

                            
                        @else

                            <div class="alert alert-danger"> No news data found </div>

                        @endif
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

@stop

 