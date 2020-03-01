@extends('layouts.dashboard.master')

@section('title', 'Forum')

@section('header_scripts')

@stop

@section('content')
<main role="main" class="pt-5 py-3 pl-5 pr-5 desk-padding bg-light-2" ng-controller="HomebookCtrl as form">
    
    <div class="row">
        <div class="col-xl-2 col-lg-2 col-md-2 mb-4">
            
        </div>
        <div class="col-xl-8 col-lg-8 col-md-8 mb-4">
            <div class="p-3 bg-white shadow-light">
                <h5 class="pb-2 mb-0">Start Discussion</h5>
                @if(Session::has('failed'))
                                                
                    <div class="alert alert-danger alert-dismissable">
                        <b>Failed : </b> {{ Session::get('failed') }}
                        <button type="button" class="close btn-sm" data-dismiss="alert" aria-hidden="true" style="margin-right: 20px;margin-top: -5px;"><small>×</small></button>
                    </div>
                                                                    
                @endif 
                <form method="POST" action="{{ url('/post/forum') }}">
		        {{ csrf_field() }}
		            <div class="form-group">
		                <label for="title">Title</label>
		                <input type="text" name="title" class="form-control" placeholder="Title" required>
		            </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select name="category" class="form-control" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
		            <div class="form-group">
		              <label for="title">Content <small class="text-danger">*Minimum of 30 characters</small></label>
		              <textarea id="editor" name="content" placeholder="Write Discussion..." rows="10" cols="80" class="form-control" required></textarea>
		            </div>
		            <div class="form-group">
		                <button type="submit" id="create_forum_btn" class="btn btn-primary">Post</button>
		            </div>
		        </form>
             </div>
        </div>
        <div class="col-xl-2 col-lg-2 col-md-2 mb-4">
            
        </div>
    </div>
</main>

@endsection

@section('footer_scripts')

<script type="text/javascript">
  $(function () {
    
    var editor = CKEDITOR.replace('editor', {
      // Define the toolbar groups as it is a more accessible solution.
      toolbarGroups: [{
          "name": "basicstyles",
          "groups": ["basicstyles"]
        },
        {
          "name": "paragraph",
          "groups": ["list", "blocks"]
        },
      ],
      // Remove the redundant buttons from toolbar groups defined above.
      removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
    });

    

    $(document).ready(function() {
       $('#create_forum_btn').attr('disabled', true);
    });

    editor.on('change', function(evt) {
        // getData() returns CKEditor's HTML content.
        if(evt.editor.getData().length > 30){

          $('#create_forum_btn').attr('disabled', false).html('Post')

        }else{

          $('#create_forum_btn').attr('disabled', true);
        }

    });

  });
</script>
@stop
