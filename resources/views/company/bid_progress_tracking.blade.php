@extends('app')

@section('content')
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Bids
            </div>
            <div class="panel-body">
                @if(count($bids) > 0)
                    <table id="bid">
                        <thead>
                        <tr>
                            <th>Bid ID</th>
                            <th>Status</th>
                            <th>Job ID</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($bids as $bid)
                            <tr>
                                <td>
                                    <a href="/bid/{{ $bid->id }}" target="_blank">{{ $bid->id }}</a>
                                </td>
                                <td>
                                    {{ $bid->rfi_status->rfi_status }}
                                </td>
                                <td>
                                    {{ $bid->job->id }}
                                </td>
                                <td><a href="/bid/{{ $bid->id }}/edit" class="btn btn-sm btn-primary">Update Bid</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    {{ 'No jobs found for company '.$company->company_name }}
                @endif
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready( function () {
            $('#bid').DataTable();
        } );
    </script>
@endsection