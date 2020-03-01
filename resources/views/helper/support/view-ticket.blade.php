@extends('layouts.master')

@section('title', 'View Ticket')

@section('header_scripts')
<link href="{{ URL::asset('assets/plugins/summernote/summernote.css') }}" rel="stylesheet">
@stop

@section('content')

<div class="page-content-wrapper" ng-app="ticketApp" ng-controller="TicketCtrl as frm">
    <div class="page-content">
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <div class=" pull-left">
                    <div class="page-title">{{ $tickets->subject }}</div>
                </div>
            </div>
        </div>
         <!-- add content here -->
         <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile-content">
                        <div class="card card-topline-aqua">
                            <div class="card-body no-padding">
                                @if(session('success'))
                                <div class="m-t-20">
                                    <div class="alert label-success alert-dismissible text-center" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        {!! session('success') !!}
                                    </div>
                                </div> 
                                @endif
                                @if(session('danger'))
                                <div class="m-t-20">
                                    <div class="alert label-danger alert-dismissible text-center" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        {!! session('danger') !!}
                                    </div>
                                </div> 
                                @endif
                                <div class="panel m-t-20">
                                    <header class="panel-heading panel-heading-blue">
                                        <span> {{ $tickets->subject }}</span>
                                        <div class="pull-right">
                                            @if($tickets->status == 'OPEN')
                                            <a href="{{ url('/helper/customer-support/ticket/'.$tickets->id.'/complete') }}" class="btn btn-success btn-xs" >Mark Complete</a>
                                            <!-- <a href="{{ url('customer-support/ticket/'.$tickets->id.'/edit') }}" class="btn btn-info btn-xs" >Edit</a> -->
                                            @endif
                                        </div>
                                    </header>
                                    <div class="panel-body">
                                        <div class="card">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p><b>Owner:</b> {{ $tickets->user->full_name }} / {{$tickets->user->username}}</p>
                                                        <p><b>Status:</b> {{ $tickets->status }}</p>
                                                        <p ><b>Category:</b> <span style="color:{{ $tickets->category->color }}">{{ $tickets->category->name }}</span></p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p><b>Assign To:</b> {{ $tickets->agent->agent_name }}</p>
                                                        <p><b>Created:</b> {{ $tickets->created_at }}</p>
                                                        <p><b>Last Update:</b> {{ $tickets->updated_at->diffForHumans() }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {!! $tickets->html !!}
                                    </div>
                                </div>
                                <p><b>Comments</b></p>

                                @foreach($tickets->comments as $comment)
                                    <div class="panel m-t-10">
                                        <header class="panel-heading panel-heading-gray">
                                            @if($comment->user->agent == 1)
                                            <span> {{ $comment->user->agent_name }}</span>
                                            @else
                                            <span> {{ $comment->user->full_name }}</span>
                                            @endif
                                            <div class="pull-right">
                                                <span>{{ $comment->created_at->diffForHumans() }}</span>
                                            </div>
                                        </header>
                                        <div class="panel-body">
                                            {!! $comment->html !!}
                                        </div>
                                    </div>
                                @endforeach
                                <!-- @if($tickets->status == 'OPEN') -->
                                <form method="POST" action="{{ url('/helper/customer-support/comments') }}">
                                    {{ csrf_field() }}
                                    <div class="row m-b-20">
                                        <input type="hidden" name="ticket_id" value="{{ $tickets->id }}">
                                        <div class="form-group col-md-12 m-t-10">
                                            <textarea class="form-control summernote-editor" rows="3" required="required" name="comments" cols="30" id="comments"></textarea>
                                        </div>
                                        <div class="col-md-12">
                                            
                                            <button type="submit" class="btn btn-block btn-primary">Reply            
                                            </button>
                                            
                                        </div> 
                                    </div>
                                </form>
                               <!--  @endif -->
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
<script src="{{ URL::asset('assets/plugins/summernote/summernote.js') }}"></script>
<script>

    $(function() {

        var options = $.extend(true, {lang: '' , codemirror: {theme: 'monokai', mode: 'text/html', htmlMode: true, lineWrapping: true} } , {
            "toolbar": [
                ["font", ["bold", "underline", "italic", "clear"]],
                ["color", ["color"]],
                ["para", ["ul", "ol", "paragraph"]],
                ["insert", ["link", "picture"]]
                // ["view", ["codeview"]]
            ],
            "height" : 75
        });

        $("textarea.summernote-editor").summernote(options);

    });
</script>
<script type="text/javascript">
    (function () {
        var ticketApp = angular.module('ticketApp', ['angular.filter']);
        ticketApp.controller('TicketCtrl', function ($scope, $http, $sce) {

            var vm = this;

        });
    })();

</script>

@stop