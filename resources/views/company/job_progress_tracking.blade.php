@extends('content_with_sidebar')

@section('sidebar')
    <ul class="nav nav-sidebar">
        <h4 class="text-center">{{ $company->company_name }}</h4>
    </ul>
    <ul class="nav nav-sidebar">
        <li><a href="/company/job_history/{{ $company->id }}">Job History</a></li>
        <li class="active"><a href="/job_progress_tracking/{{ $company->id }}">Job Progress Tracking</a></li>
        <li><a href="/job/create">Create Job<span class="sr-only">(current)</span></a></li>
    </ul>
@endsection

@section('content')
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                Jobs
            </div>
            <div class="panel-body">
                @if(count($jobs) > 0)
                    <table id="job">
                        <thead>
                        <tr>
                            <th>Job ID</th>
                            <th>Status</th>
                            <th>Number of bids received</th>
                            <th>Bids</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($jobs as $job)
                            <tr>
                                <td>
                                    <a href="/job/{{ $job->id }}" target="_blank">{{ $job->id }}</a>
                                </td>
                                <td>
                                    {{ $job->rfi_status->rfi_status }}
                                </td>
                                <td>{{ count($job->bids)  }}</td>
                                <td>
                                    @if(count($job->bids) > 0)
                                        @foreach($job->bids as $bid)
                                            <p><a href="/bid/{{ $bid->id }}" target="_blank">Bid ID: {{ $bid->id }} ({{ $rfi_status[$bid->status_id] }})</a></p>
                                        @endforeach
                                    @else
                                        {{ 'No bids.' }}
                                    @endif
                                </td>
                                <td>
                                    <a href="/job/{{ $job->id }}/edit" class="btn btn-sm btn-primary">Update Job</a>
                                    <a href="/job/compare_lsps/{{ $job->id }}" class="btn btn-sm btn-primary">Compare LSPs</a>
                                </td>
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
            $('#job').DataTable({
                "bSort" : false
            });
        } );
    </script>
@endsection