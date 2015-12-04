@extends('app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <h3 class="pull-left">Newly Received Bids</h3>
        </div>
        <hr>
        <table id="bid_table" class="display">
            <thead>
            <tr>
                <th>Bid ID</th>
                <th>LSP Company Name</th>
                <th>Status</th>
                <th>Update Date</th>
                <th>Target Job</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @if(count($bids) > 0)
                @foreach($bids as $bid)
                    <tr>
                        <td><a href="/bid/{{ $bid->id }}" title="Bid Detail" target="_blank">{{ $bid->id }}</a></td>
                        <td><a href="/company/{{ $bid->company_id }}" title="Company Detail" target="_blank">{{ $bid->company_name }}</a></td>
                        <td>Submitted</td>
                        <td>{{ $bid->updated_at }}</td>
                        <td><a href="/job/{{ $bid->job_id }}" title="Job Detail" target="_blank">{{ $bid->job_id }}</a></td>
                        <td><a href="/bid/{{ $bid->id }}" title="Respond to bid" target="_blank" class="btn btn-sm btn-primary">Respond to bid</a></td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready( function () {
            $('#bid_table').DataTable({
                "bSort" : false
            });
        } );
    </script>
@endsection