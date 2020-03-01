<div class="table-responsive">
    <table class="table table-striped table-bordered" id="content-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Property Type</th>
            </tr>
        </thead>
        <tbody class="table-body">
            @if(count($interior_designs) > 0)
                @foreach($interior_designs as $key => $interior_design)
                
                    <tr>
                        <td>{{ $interior_design->user->first_name.' '.$interior_design->user->middle_name.' '.$interior_design->user->last_name }}
                            @if(!empty($interior_design->user->suffix))
                                {{ $interior_design->user->suffix }}
                            @endif
                        </td>
                        <td>{{ $interior_design->user->email }}</td>
                        <td>{{ $interior_design->contact }}</td>
                        <td>{{ $interior_design->property_type }}</td>


                    </tr>

                @endforeach
            @else
                <td colspan="4" class="text-danger">No data found</td>
            @endif
        </tbody>
    </table>

    {!! $interior_designs->links() !!}
</div>