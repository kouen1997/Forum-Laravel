@extends('layouts.backend.master')

@section('title', 'News List')

@section('header_scripts')

@stop

@section('content')
<div ng-app="newsApp" ng-controller="newsCtrl as frm">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card bg-boxshadow mb-3">
                    <div class="card-body">
                        <h4 class="card-title">News List</h4>
                        <div class="row">
                            <div class="col-md-12">
                               <div class="table-responsive">
                                    <table class="table border-0 mb-0 project-table">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Views</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @if(count($newss) > 0)

                                                @foreach($newss as $news)
                                                    <tr class="news-{{ $news->id }}">
                                                        <td>
                                                            <h6><a href="{{ url('/news/view/'.$news->slug) }}">{{ $news->title }}</a></h6><span class="text-muted">
                                                        </td>
                                                        <td>{{ $news->views->count() }}</td>
                                                        <td>
                                                            <td><a href="{{ url('/news/edit/'.Crypt::encrypt($news->id)) }}"><i class="fa fa-edit"></i></a></td>
                                                            <td><i class="fa fa-times" onclick="deleteNews('{{ $news->id }}');"></i></td>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            @else
                                                <td colspan="3">
                                                    <div class="alert alert-danger">No news data found</div>
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

<div class="modal fade" id="deleteNewsModal" tabindex="-1" role="dialog" aria-labelledby="deleteTriviaModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
          <form class="deleteNewsFrm">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" style="font-size: 15px;"><i class="fa fa-times-circle" style="color: #000;"></i> Delete News</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-25px;">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">

                        Are you sure you want to delete this news?

                </div>
                <div class="modal-footer">
                    <input type="hidden" id="news_id" name="news_id" value="" />
                    <button type="button" class="btn btn-sm btn-default pl-5 pr-5" data-dismiss="modal"> Cancel </button>
                    <button type="submit" id="delete_news_btn" class="btn btn-sm btn-primary pl-5 pr-5">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer_scripts')
<script type="text/javascript">
    function deleteNews(news_id){

        $('#deleteNewsModal').appendTo('.main-content').modal('show');
        $(".modal-footer #news_id").val(news_id);

    }

    var frm = $('.deleteNewsFrm');

    frm.submit(function (e) {

        e.preventDefault();
        $('#delete_news_btn').attr('disabled', true).append(' <i class="fa fa-spinner fa-pulse "></i>');
        var news_id = document.getElementById("news_id").value;

         $.ajax({
            type: 'POST',
            url: '/news/'+news_id+'/delete',
            data: frm.serialize()
        }).done(function(data) {

           if(data.status == 'success'){
                console.log(data.status);

                $('.news-'+news_id).remove();
                $('#delete_news_btn').attr('disabled', false).html('Delete'); 
                $('#deleteNewsModal').appendTo("body").modal('hide');

                
            }
        }).fail(function(data) {
            $('#delete_news_btn').attr('disabled', false).html('Delete')

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