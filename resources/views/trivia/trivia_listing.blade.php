@extends('layouts.backend.master')

@section('title', 'Trivia List')

@section('header_scripts')

@stop

@section('content')
<div ng-app="triviaApp" ng-controller="triviaCtrl as frm">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card bg-boxshadow mb-3">
                    <div class="card-body">
                        <h4 class="card-title">Trivia Listing</h5>
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

                                            @if(count($trivias) > 0)

                                                @foreach($trivias as $trivia)
                                                    <tr class="trivia-{{ $trivia->id }}">
                                                        <td>
                                                            <h6><a href="{{ url('/trivia/view/'.$trivia->slug) }}">{{ $trivia->title }}</a></h6>
                                                        </td>
                                                        <td>{{ $trivia->views->count() }}</td>
                                                        <td>
                                                            <td><a href="{{ url('/trivia/edit/'.Crypt::encrypt($trivia->id)) }}"><i class="fa fa-edit"></i></a></td>
                                                            <td><i class="fa fa-times" onclick="deleteTrivia('{{ $trivia->id }}');"></i></td>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            @else
                                                <td colspan="3">
                                                    <div class="alert alert-danger">No trivia data found</div>
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

<div class="modal fade" id="deleteTriviaModal" tabindex="-1" role="dialog" aria-labelledby="deleteTriviaModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
          <form class="deleteTriviaFrm">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" style="font-size: 15px;"><i class="fa fa-times-circle" style="color: #000;"></i> Delete Trivia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-25px;">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">

                        Are you sure you want to delete this trivia?

                </div>
                <div class="modal-footer">
                    <input type="hidden" id="trivia_id" name="trivia_id" value="" />
                    <button type="button" class="btn btn-sm btn-default pl-5 pr-5" data-dismiss="modal"> Cancel </button>
                    <button type="submit" id="delete_trivia_btn" class="btn btn-sm btn-primary pl-5 pr-5">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('footer_scripts')
<script type="text/javascript">
    function deleteTrivia(trivia_id){

        $('#deleteTriviaModal').appendTo('.main-content').modal('show');
        $(".modal-footer #trivia_id").val(trivia_id);

    }

    var frm = $('.deleteTriviaFrm');

    frm.submit(function (e) {

        e.preventDefault();
        $('#delete_trivia_btn').attr('disabled', true).append(' <i class="fa fa-spinner fa-pulse "></i>');
        var trivia_id = document.getElementById("trivia_id").value;

         $.ajax({
            type: 'POST',
            url: '/trivia/'+trivia_id+'/delete',
            data: frm.serialize()
        }).done(function(data) {

           if(data.status == 'success'){
                console.log(data.status);

                $('.trivia-'+trivia_id).remove();
                $('#delete_trivia_btn').attr('disabled', false).html('Delete'); 
                $('#deleteTriviaModal').appendTo("body").modal('hide');

                
            }
        }).fail(function(data) {
            $('#delete_trivia_btn').attr('disabled', false).html('Delete')

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