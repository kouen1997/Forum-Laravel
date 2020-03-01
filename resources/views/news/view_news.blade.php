@extends('layouts.master')

@section('title', $news->title)

@section('header_scripts')

@stop

@section('content')
<div ng-app="HomebookApp" ng-controller="HomebookCtrl as form">
    <div class="container">
        <div class="row justify-content-md-center">
              <div class="col col-lg-12 col-xl-10">
            <div class="row has-sidebar">
              <div class="col-md-7 col-lg-8 col-xl-8">
                <div class="page-header v2 bordered">
                  <h1>{{ $news->title }}</h1>
                </div>
                <div class="clearfix"></div>
                <img src="{{ URL::asset('news/'.$news->cover_image) }}" class="img-fluid" style="width: 100%;">
                <div class="item-meta-info"><span class="date">{{ date("F j, Y",strtotime($news->created_at)) }}</span><span class="author">By Homebook</span><small style="float: right;">Views: {{ number_format($news->views->count()) }}</small></div>
                <div class="item-detail">
                  {!! $news->content !!}
                </div>
              </div>
              <div class="col-md-5 col-lg-4 col-xl-4 col-sidebar">
                <div id="sidebar" class="sidebar-right">
                  <div class="sidebar_inner">
                    <h3 class="subheadline">Latest News</h3>
                    <div class="list-group no-border">
                      @if(count($lnewss) > 0)

                          @foreach($lnewss as $lnews)
                                <br>
                                <p class="media-body pb-3 mb-0 medium lh-125 border-bottom border-gray">
                                    <strong class="d-block text-gray-dark"><a href="{{ url('/news/view/'.$lnews->slug) }}">{{ $lnews->title }}</a>
                                    </strong>
                                    <small>{{ $lnews->created_at->diffforHumans() }}</small>
                                    <span style="float: right;"><i class="fa fa-eye" style="color:#bdbdbd;"></i> {{ $lnews->views->count() }}</span>
                                </p>
                          @endforeach

                          
                      @else

                          <div class="alert alert-danger"> No news data found 1</div>

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
