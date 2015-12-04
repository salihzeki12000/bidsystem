@extends('content_with_sidebar')

@section('sidebar')
    <ul class="nav nav-sidebar">
        <h4 class="text-center">{{ $company->company_name }}</h4>
    </ul>
    <ul class="nav nav-sidebar">
        <li class="active"><a href="/company/bid_history/{{ $company->id }}">Bid History</a></li>
        <li><a href="/bid_progress_tracking/{{ $company->id }}">Bid Progress Tracking</a></li>
        <li><a href="/bid/create">Create Bid</a></li>
    </ul>
@endsection

@section('content')
    <div class="row">
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
                                    <a class="btn btn-sm btn-success" href="/bid/{{ $bid->id }}" title="View"><span class="glyphicon glyphicon-file"></span></a>
                                    <a class="btn btn-sm btn-warning" href="/bid/manage_bid_files/{{ $bid->id }}" title="Files"><span class="glyphicon glyphicon-folder-open"></span></a>
                                    <a class="btn btn-sm btn-primary" href="/bid/{{ $bid->id }}/edit" title="Edit"><span class="glyphicon glyphicon-edit"></span></a>
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
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready( function () {
            $('#bid').DataTable();
        } );
    </script>
@endsection