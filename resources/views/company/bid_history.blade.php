@extends('app')

@section('content')
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ 'Bid History' }}
            </div>
            <div class="panel-body">
                @if(count($company->bids) > 0)
                    <table id="bid">
                        <thead>
                        <tr>
                            <th>Bid ID</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($company->bids as $bid)
                            <tr>
                                <td>
                                    <a href="/bid/{{ $bid->id }}" target="_blank">{{ $bid->id }}</a>
                                </td>
                                <td>
                                    {{ $bid->rfi_status->rfi_status }}
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="/bid/{{ $bid->id }}" title="View">View</a>
                                    <a class="btn btn-sm btn-warning" href="/bid/manage_bid_files/{{ $bid->id }}" title="Files">Files</a>
                                    <a class="btn btn-sm btn-primary" href="/bid/{{ $bid->id }}/edit" title="Edit">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    {{ 'No bid history found for company '.$company->company_name }}
                @endif
            </div>
        </div>
        <div class="clearfix"></div>
        <br>
        <a class="btn btn-primary" onclick="window.history.back();">Back</a>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready( function () {
            $('#bid').DataTable();
        } );
    </script>
@endsection