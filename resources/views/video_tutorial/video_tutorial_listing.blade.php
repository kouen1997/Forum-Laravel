@extends('layouts.backend.master')

@section('title', 'Video Tutorial List')

@section('header_scripts')

@stop

@section('content')
<div ng-app="videotutorialApp" ng-controller="videotutorialCtrl as frm">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card bg-boxshadow mb-3">
                    <div class="card-body">
                        <h4 class="card-title">Video Tutorial Listing</h5>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table border-0 mb-0 project-table">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @if(count($videos) > 0)

                                                @foreach($videos as $video)
                                                    <tr class="video-{{ $video->id }}">
                                                        <td>
                                                            <h6><a href="{{ url('/video/tutorial/view/'.$video->slug) }}">{{ $video->title }}</a></h6>
                                                        </td>
                                                        <td>
                                                            <td><a href="{{ url('/video/tutorial/edit/'.Crypt::encrypt($video->id)) }}"><i class="fa fa-edit"></i></a></td>
                                                            <td><i class="fa fa-times" onclick="deleteVideo('{{ $video->id }}');"></i></td>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            @else
                                                <td colspan="3">
                                                    <div class="alert alert-danger">No video tutorials data found</div>
                                                </td>
                                            @endif  
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteVideoModal" tabindex="-1" role="dialog" aria-labelledby="deleteVideoModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
          <form class="deleteVideoFrm">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" style="font-size: 15px;"><i class="fa fa-times-circle" style="color: #000;"></i> Delete Video Tutorial</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-25px;">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">

                        Are you sure you want to delete this video tutorial?

                </div>
                <div class="modal-footer">
                    <input type="hidden" id="video_id" name="video_id" value="" />
                    <button type="button" class="btn btn-sm btn-default pl-5 pr-5" data-dismiss="modal"> Cancel </button>
                    <button type="submit" id="delete_video_btn" class="btn btn-sm btn-primary pl-5 pr-5">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('footer_scripts')
<script type="text/javascript">
    function deleteVideo(video_id){

        $('#deleteVideoModal').appendTo('.main-content').modal('show');
        $(".modal-footer #video_id").val(video_id);

    }

    var frm = $('.deleteVideoFrm');

    frm.submit(function (e) {

        e.preventDefault();
        $('#delete_video_btn').attr('disabled', true).append(' <i class="fa fa-spinner fa-pulse "></i>');
        var video_id = document.getElementById("video_id").value;

         $.ajax({
            type: 'POST',
            url: '/video/tutorial/'+video_id+'/delete',
            data: frm.serialize()
        }).done(function(data) {

           if(data.status == 'success'){
                console.log(data.status);

                $('.video-'+video_id).remove();
                $('#delete_video_btn').attr('disabled', false).html('Delete'); 
                $('#deleteVideoModal').appendTo("body").modal('hide');

                
            }
        }).fail(function(data) {
            $('#delete_video_btn').attr('disabled', false).html('Delete')

            if (response.data.status){

                swal("",response.data.message, "warning");
                 
            } else {
                var errors = [];
                angular.forEach(response.data.errors, function(message, key){
                    errors.push(message[0]);
                });
            
                swal("",errors.toString().split(",").join("\n \n"),"error");
            }
        });
    });
</script>
@stop