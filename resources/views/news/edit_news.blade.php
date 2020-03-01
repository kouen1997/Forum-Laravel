@extends('layouts.backend.master')

@section('title', 'Edit News')

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
                        <h4 class="card-title mb-0">Edit News</h4>
                        <p class="mb-3">News fill-up form</p>

                        <form method="POST" action="{{ url('/news/edit') }}" enctype='multipart/form-data' id="editForm">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" class="form-control" id="title" placeholder="title" value="{{ $news->title }}" required>
                                <input type="hidden" name="id" class="form-control" id="id" placeholder="id" value="{{ $news->id }}" required>
                            </div>
                            <div class="form-group">
                                <label for="cover_image">Cover Image</label>
                                <input type="file" name="cover_image" class="form-control cover_image" id="cover_image" placeholder="Cover Image">
                                <br>
                                <output id="image_preview">
                                  <img src="{{ URL::asset('news/'.$news->cover_image) }}">
                                </output>
                            </div>
                            <div class="form-group">
                                <label for="title">Description</label>
                                <div id="editor-container">
                                </div>
                                <textarea class="form-control" name="description" style="display:none;" id="description" placeholder="Description">{{ $news->content }}</textarea>
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
<script type="text/javascript">

  function handleFileSelectImage(evt) {
            
        var file = evt.target.files;
        var f = file[0]
        if (!f.type.match('image.*')) {

            alert("Please Select Image.");

        }else{
                var file_reader = new FileReader();
                file_reader.onload = (function(theFile) {
                    return function(e) {
                      var span = document.createElement('span');
                      span.innerHTML = ['<div style="margin-top:30px;margin-left:30px;height:400px;width:1366px;"><img src="../../images/Facebook-1s-200px.gif"></div>'].join('');
                          document.getElementById('image_preview').innerHTML = "";
                          document.getElementById('image_preview').insertBefore(span, null);
                      setTimeout(function () {
                          span.innerHTML = ['<div id="overlay"><img src="', e.target.result, '" title="', escape(theFile.name), '" style="opacity:0.5px;filter: alpha(opacity=50);height:400px; width:400px;margin-top:10px;"/></div></div>'].join('');
                          document.getElementById('image_preview').innerHTML = "";
                          document.getElementById('image_preview').insertBefore(span, null);
                      }, 2000);
                    };
                })(f);
              
            file_reader.readAsDataURL(f);
        }
    }


    $('.cover_image').change(function(evt){
        handleFileSelectImage(evt);
    });  
</script>
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

    var justHtml = $("#description").val();
    console.log(justHtml);
    quill.root.innerHTML = justHtml;

    $(document).ready(function(){
      $("#editForm").on("submit", function () {
        //var hvalue = $('#editor-container').html();
        var hvalue = quill.root.innerHTML;
            $(this).append("<textarea name='description' style='display:none'>"+hvalue+"</textarea>");
        });
    });
</script>
@stop