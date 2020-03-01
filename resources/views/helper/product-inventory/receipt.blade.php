@extends('layouts.master')

@section('title', 'Receipt')

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item active">Receipt</li>
</ol>
<h1 class="page-header">Receipt</h1>
<div class="panel">
    <div class="panel-heading">
        <h4 class="panel-title">Receipt</h4>
    </div>
    <div class="panel-body">
        <div class="row">
            @if(session('success'))
                <div class="col-md-12">
                    <div class="alert alert-success text-center" role="alert">
                      {!! session('success') !!}
                    </div>
                </div>
            @endif
            @if(session('error'))
                <div class="col-md-12">
                    <div class="alert alert-warning text-center" role="alert">
                      {!! session('error') !!}
                    </div>
                </div>
            @endif
            <div class="col-md-12">
                @if($product_order->receipt != NULL)
                <h4 class="text-center"><b>Current Receipt</b></h4>
                    <div class="text-center">
                        <img ng-if="order.receipt!=NULL"  src="{{$product_order->receipt}}" class="img img-responsive img-thumbnail text-center center-block" style="height: 300px;margin:0 auto;">
                    </div>
                <hr/>
                @endif
            </div>
            <div class="col-md-12">
                <form naction="{{ url('/helper/product-inventory/history/'.$product_order->id.'/receipt') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                    <div class="row p-3">
                        {{ csrf_field() }}
                         <div class="col-md-12">
                            <div class="form-group text-center">
                              <label>Upload Receipt Image</label> 
                              <br>
                              <img src="{{ asset('products/product.jpg') }}" class="img img-responsive center-block" id="receipt-img-tag" style="background-color: #fff; border: 1px solid #ddd; border-radius: 4px;height: 200px;margin:0 auto; "  />
                              <br>
                              <br>
                              <input type="file" name="receipt" id="receipt_image"  accept="image/*">
                            </div>
                        </div>
                        <div class="col-md-12 m-t-15 text-center">
                            <button type="submit" class="btn btn-primary btn-sm">Upload</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_scripts')
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#receipt-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#receipt_image").change(function(){
        readURL(this);
    });
</script>
@stop