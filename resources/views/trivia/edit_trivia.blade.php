@extends('layouts.backend.master')

@section('title', 'Edit Trivia')

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
                    <h4 class="card-title mb-0">Edit Trivia</h4>
                    <p class="mb-3">Trivia fill-up form</p>

                    <form method="POST" action="{{ url('/trivia/edit') }}" id="editForm">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" id="title" placeholder="title" value="{{ $trivia->title }}" required>
                            <input type="hidden" name="id" class="form-control" id="title" placeholder="id" value="{{ $trivia->id }}" required>
                        </div>
                        <div class="form-group">
                            <label for="title">Content</label>
                            <div id="editor-container">
                            </div>
                            <textarea class="form-control" name="content" style="display:none;" id="content" placeholder="Content">{{ $trivia->content }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2 pull-right" id="add_trivia_btn">Submit</button>
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