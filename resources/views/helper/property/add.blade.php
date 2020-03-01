@extends('layouts.backend.master')

@section('title', 'Add Property')

@section('header_scripts')
<link rel="stylesheet" href="{{ URL::asset('assets/backend/css/bootstrap-datepicker.min.css') }}">
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    #editor-container {
        height: 375px;
    }
</style>
@stop

@section('content')
<div ng-app="propertyApp" ng-controller="PropertyCtrl as frm">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card bg-boxshadow mb-3">
                    <div class="card-body">
                        <h4 class="card-title">ADD PROPERTY</h4>

                        @if(session('success'))
                        <div class="alert alert-success" role="alert">
                        {!! session('success') !!}
                        </div>
                        @endif

                        @if(session('danger'))
                        <div class="alert alert-warning" role="alert">
                        {!! session('danger') !!}
                        </div>
                        @endif

                        @if ($errors->any())
                        <div class="alert alert-warning" role="alert">
                            @foreach ($errors->all() as $error)
                            * {{ $error }}<br>
                            @endforeach
                        </div>
                        @endif

                        <div class="col-md-6 offset-md-3">
                            <form method="POST" action="{{ url('helper/property/add') }}" autocomplete="off" accept-charset="utf-8" enctype="multipart/form-data" id="addForm">
                                {!! csrf_field() !!}
                                <div class="form-group">
                                    <label for="offer_type">Offer Type</label>
                                    <select class="form-control" name="offer_type">
                                        <option value="" selected disabled>Choose</option>
                                        <option value="Sell">Sell</option>
                                        <option value="Rent">Rent</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="property_type">Property Type </label>
                                    <select class="form-control" name="property_type">
                                        <option value="" selected disabled>Choose</option>
                                        <option value="Condominium">Condominium</option>
                                        <option value="Commercial">Commercial</option>
                                        <option value="Apartment">Apartment</option>
                                        <option value="Foreclosures">Foreclosures</option>
                                        <option value="House">House</option>
                                        <option value="Land">Land</option>
                                        <option value="House and Lot">House and Lot</option>
                                        <option value="Office">Office</option>
                                        <option value="Farm">Farm</option>
                                        <option value="Beach">Beach</option>
                                        <option value="Building">Building</option>
                                        <option value="Resort">Resort</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="sub_type">Sub Type</label>
                                    <select class="form-control" name="sub_type">
                                        <option value="" selected disabled>Choose</option>
                                        <option value="Condotel">Condotel</option>
                                        <option value="Other">Other</option>
                                        <option value="Penthouse">Penthouse</option>
                                        <option value="1 Bedroom">1 Bedroom</option>
                                        <option value="2 Bedroom">2 Bedroom</option>
                                        <option value="3 Bedroom">3 Bedroom</option>
                                        <option value="4 Bedroom">4 Bedroom</option>
                                        <option value="Studio">Studio</option>
                                        <option value="Loft">Loft</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="Title">
                                </div>
                                <div class="form-group">
                                    <label for="title">Description</label>
                                    <div id="editor-container">
                                    </div>
                                    <textarea class="form-control" name="description" style="display:none;" id="description" placeholder="Description"></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="title">Bedrooms*</label>
                                            <input type="text" class="form-control" name="bedrooms" value="{{ old('bedrooms') }}" placeholder="Bedrooms">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="title">Baths</label>
                                            <input type="text" class="form-control" name="baths" value="{{ old('baths') }}" placeholder="Baths">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="title">Floor area (m²)</label>
                                            <input type="text" class="form-control" name="floor_area" value="{{ old('floor_area') }}" placeholder="Floor area">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Unit/Floor Number</label>
                                            <input type="text" class="form-control" name="floor_number" value="{{ old('floor_number') }}" placeholder="Unit/Floor Number">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Property Name</label>
                                            <input type="text" class="form-control" name="condominium_name" value="{{ old('condominium_name') }}" placeholder="Property Name">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="title">Price (&#8369;)</label>
                                    <input type="text" class="form-control" name="price" value="{{ old('price') }}" placeholder="&#8369;">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Available from</label>
                                            <input type="text" class="form-control" data-provide="datepicker" name="available_from">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Property ID</label>
                                            <input type="text" class="form-control" name="object_id" value="{{ old('object_id') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="title">Video URL </label>
                                    <input type="text" class="form-control" name="video_url" value="{{ old('video_url') }}" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="title">Province</label>
                                    <input type="text" class="form-control" name="province" value="{{ old('province') }}" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="title">City</label>
                                    <input type="text" class="form-control" name="city" value="{{ old('city') }}" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="title">Barangay</label>
                                    <input type="text" class="form-control" name="barangay" value="{{ old('barangay') }}" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="title">Address</label>
                                    <input type="text" class="form-control" name="address" value="{{ old('address') }}" placeholder="Address">
                                </div>
                                <div class="form-group">
                                    <label for="title">Map (Embed)</label>
                                    <input type="text" class="form-control" name="map" value="{{ old('map') }}" placeholder="Embed Code">
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="title">Name and Surname</label>
                                            <input type="text" class="form-control" name="name" value="Speqta Prime" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="title">Contact Email</label>
                                            <input type="text" class="form-control" name="email" value="speqtaprimerealty@gmail.com" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="title">Mobile Phone</label>
                                            <input type="text" class="form-control" name="mobile" value="09175155028" placeholder="Phone">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="title">Photos</label>s
                                            <input type="file" name="photos[]" accept=".png, .jpg, .jpeg" required="" multiple/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="offer_type">Featured</label>
                                    <select class="form-control" name="is_featured">
                                        <option value="" selected disabled>Choose</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                                <button type="submit" id="add_property_btn" class="btn btn-primary mt-30" type="submit">PUBLISH YOUR PROPERTY</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer_scripts')
<script src="{{ URL::asset('assets/backend/js/bootstrap-datepicker.min.js') }}"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script type="text/javascript">
  	(function () {
        var propertyApp = angular.module('propertyApp', ['angular.filter']);
        propertyApp.controller('PropertyCtrl', function ($scope, $http, $sce) {
            
            var vm = this;

            vm.add = function () {

                $('#add_property_btn').prop('disabled', true);
                $('#add_property_btn').html('Please wait... <i class="fa fa-spinner fa-spin"></i>');

                $http({
                    method: 'POST',
                    url: '/helper/property/add',
                    data: JSON.stringify({
                        offer_type: vm.offer_type,
                        property_type: vm.property_type,
                        sub_type: vm.sub_type,
                        title: vm.title,
                        description: vm.description,
                        bedrooms: vm.bedrooms,
                        baths: vm.baths,
                        floor_area: vm.floor_area,
                        floor_number: vm.floor_number,
                        condominium_name: vm.condominium_name,
                        price: vm.price,
                        available_from: vm.available_from,
                        object_id: vm.object_id,
                        video_url: vm.video_url,
                        province: vm.province,
                        city: vm.city,
                        barangay: vm.barangay,
                        address: vm.address,
                        latitude: vm.latitude,
                        longitude: vm.longitude,
                        name: vm.name,
                        email: vm.email,
                        mobile: vm.mobile
                    })
                }).success(function (data) {
                    if (data.result == 1){

                        alert(data.message);

                        setTimeout(window.location.href = '/helper/property/add', 10000);

                    } else {

                        $('#add_property_btn').prop('disabled', false);
                        $('#add_property_btn').html('Withdraw');
                        
                        alert(data.message);
                    }
                }).error(function (data) {

                    $('#add_property_btn').prop('disabled', false);
                    $('#add_property_btn').html('Withdraw');

                    if(data.result == 0){

                        alert(data.message);

                    } else {
                        
                        angular.forEach(data.errors, function(message, key){

                            alert(message);

                        });
                    }
                });

            };
        });
    })();
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

    //$("#addForm").submit(function() {
    //    $("#description").val(quill.getContents());
    //});

    $(document).ready(function(){
  $("#addForm").on("submit", function () {
    //var hvalue = $('#editor-container').html();
    var hvalue = quill.root.innerHTML;
    $(this).append("<textarea name='description' style='display:none'>"+hvalue+"</textarea>");
   });
});
</script>
@stop