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
            @if(count($architectural_designs) > 0)
                @foreach($architectural_designs as $key => $architectural_design)
                
                    <tr class="architectural_design_{{ $architectural_design->id }}">
                        <td>{{ $architectural_design->user->first_name.' '.$architectural_design->user->middle_name.' '.$architectural_design->user->last_name }}
                            @if(!empty($architectural_design->user->suffix))
                                {{ $architectural_design->user->suffix }}
                            @endif
                        </td>
                        <td>{{ $architectural_design->user->email }}</td>
                        <td>{{ $architectural_design->contact }}</td>
                        <td>{{ $architectural_design->property_type }}</td>
                        <td class="text-center text-primary"><a href="{{ url('/edit/architectural_design/'.$architectural_design->id) }}"><i class="fa fa-edit"></i> Edit</a></td>
                        <td class="text-center text-danger" style="cursor:pointer;" ng-click="frm.deleteArchitecturalDesign('{{ $architectural_design->id }}')"><i class="fa fa-times"></i> Delete</td>


                    </tr>

                @endforeach
            @else
                <td colspan="5" class="text-danger">No data found</td>
            @endif
        </tbody>
    </table>

    {!! $architectural_designs->links() !!}
</div>