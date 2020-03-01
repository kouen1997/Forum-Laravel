@extends('layouts.backend.master')

@section('title', 'Edit Video Tutorial')

@section('header_scripts')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    #editor-container {
        height: 375px;
    }
</style>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card bg-boxshadow mb-3">
                    <div class="card-body">
                        <h4 class="card-title mb-0">Edit Video Tutorial</h4>
                        <p class="mb-3">Video Tutorial fill-up form</p>
                        @if(Session::has('failed'))
                                            
                            <div class="alert alert-danger alert-dismissable">
                                <b>Failed : </b> {{ Session::get('failed') }}
                                <button type="button" class="close btn-sm" data-dismiss="alert" aria-hidden="true" style="margin-right: 20px;margin-top: -5px;"><small>×</small></button>
                            </div>
                                                                            
                        @endif 
                        <form method="POST" action="{{ url('/video/tutorial/edit') }}" id="editForm">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" class="form-control" id="title" placeholder="title" value="{{ $video->title }}" required>
                                <input type="hidden" name="id" class="form-control" id="id" placeholder="id" value="{{ $video->id }}" required>
                            </div>
                            <div class="form-group">
                                <label for="title">Content</label>
                                <div id="editor-container">
                                </div>
                                <textarea class="form-control" name="content" style="display:none;" id="content" placeholder="Content">{{ $video->content }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="link">Link</label>
                                <input type="text" name="link" class="form-control" id="link" placeholder="Video Link" value="{{ 'https://www.youtube.com/watch?v='.$video->video_link }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2 pull-right" id="add_video_btn">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
    var quill = new Quill('#editor-container', {
        modules: {
            toolbar: [
            ['bold', 'italic'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }]
            ]
        },
        theme: 'snow'  // or 'bubble'
    });

    var justHtml = $("#content").val();
    console.log(justHtml);
    quill.root.innerHTML = justHtml;

    $(document).ready(function(){
      $("#editForm").on("submit", function () {
        //var hvalue = $('#editor-container').html();
        var hvalue = quill.root.innerHTML;
            $(this).append("<textarea name='content' style='display:none'>"+hvalue+"</textarea>");
        });
    });
</script>
@stop