@extends('layouts.master')

@section('title', 'Home')

@section('header_scripts')
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }
    table, th, td {
        border: 1px solid black;
    }
    th, td {
        padding: 15px;
        text-align: left;
    }
    td {
        height: 50px;
        vertical-align: bottom;
    }
</style>
@stop

@section('content')


<table>
    <thead>
        <tr>
            <th>Title</th>
            <th>Photos</th>
            <th>Offer Type</th>
            <th>Property Type</th>
            <th>Price</th>
            <th>Bedrooms</th>
        </tr>
    </thead>
    <tbody>
        @if($properties)
        @foreach($properties as $property)
        <tr>
            <td>{{ $property->title }}</td>
            <th>
                @foreach($property->photos as $photo)
                <img src="{{ $photo->filename }}" width="80" height="80"><br />
                @endforeach
                <p>First Image: <img src="{{ $property->photos->first()['filename'] }}" width="80" height="80"></p>
            </th>
            <td>{{ $property->offer_type }}</td>
            <td>{{ $property->property_type }}</td>
            <td>&#8369;{{ $property->price }}</td>
            <td>{{ $property->bedrooms }}</td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>

@endsection