<div class="table-responsive">
    <table class="table table-striped table-bordered" id="content-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Property Type</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody class="table-body">
            @if(count($interior_designs) > 0)
                @foreach($interior_designs as $key => $interior_design)
                
                    <tr class="interior_design_{{ $interior_design->id }}">
                        <td>{{ $interior_design->user->first_name.' '.$interior_design->user->middle_name.' '.$interior_design->user->last_name }}
                            @if(!empty($interior_design->user->suffix))
                                {{ $interior_design->user->suffix }}
                            @endif
                        </td>
                        <td>{{ $interior_design->user->email }}</td>
                        <td>{{ $interior_design->contact }}</td>
                        <td>{{ $interior_design->property_type }}</td>
                        <td class="text-center text-primary"><a href="{{ url('/interior-design/edit/'.$interior_design->id) }}"><i class="fa fa-edit"></i> Edit</a></td>
                        <td class="text-center text-danger" style="cursor:pointer;" ng-click="frm.deleteInteriorDesign('{{ $interior_design->id }}')"><i class="fa fa-times"></i> Delete</td>


                    </tr>

                @endforeach
            @else
                <td colspan="5" class="text-danger">No data found</td>
            @endif
        </tbody>
    </table>

    {!! $interior_designs->links() !!}
</div>