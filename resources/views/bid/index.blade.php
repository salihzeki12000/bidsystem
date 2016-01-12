@extends('app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <h3 class="pull-left">Bid List</h3>
            <h3 class="pull-right"><a href="/bid/create" class="btn btn-primary">Create Bid</a></h3>
        </div>
        <hr>
        <table id="bid_table" class="display">
            <thead>
            <tr>
                <th>Target Job ID</th>
                <th>Company Name</th>
                <th>Est. Budget</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($bids as $bid)
                <tr>
                    <td><a href="/job/{{ $bid->job_id }}" title="Job Detail" target="_blank">{{ $bid->job_id }}</a></td>
                    <td><a href="/company/{{ $bid->company_id }}" title="Company Detail" target="_blank">{{ $bid->company->company_name }}</a></td>
                    <td>{{ $bid->est_budget }}</td>
                    <td>{{ $bid->rfi_status->rfi_status }}</td>
                    <td>
                        <form method="POST" action="/bid/{{ $bid->id }}" enctype="multipart/form-data" class="delete_bid_form">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <a class="btn btn-sm btn-success" href="/bid/{{ $bid->id }}" title="View">View</a>
                            <a class="btn btn-sm btn-warning" href="/bid/manage_bid_files/{{ $bid->id }}" title="Files">File</a>
                            <a class="btn btn-sm btn-primary" href="/bid/{{ $bid->id }}/edit" title="Edit">Edit</a>
                            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready( function () {
            $('#bid_table').DataTable();

            $('.delete_bid_form').submit(function(ev) {
                ev.preventDefault();
                if (confirm('Are you sure you want to delete this bid?')) {
                    this.submit();
                }
            });
        } );
    </script>
@endsection