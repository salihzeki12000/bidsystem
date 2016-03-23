@extends('app')

@section('content')
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ 'Job History' }}
            </div>
            <div class="panel-body">
                @if(count($company->jobs) > 0)
                    <table id="job">
                        <thead>
                        <tr>
                            <th>Job ID</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($company->jobs as $job)
                            <tr>
                                <td>
                                    <a href="/job/{{ $job->id }}" target="_blank">{{ $job->id }}</a>
                                </td>
                                <td>
                                    {{ $job->rfi_status->rfi_status }}
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="/job/{{ $job->id }}" title="View">View</a>
                                    <a class="btn btn-sm btn-warning" href="/job/manage_job_files/{{ $job->id }}" title="Files">Files</a>
                                    <a class="btn btn-sm btn-primary" href="/job/{{ $job->id }}/edit" title="Edit">Edit</a>
                                    <a class="btn btn-sm btn-primary" href="/match/{{ $job->id }}" title="Matches">Recommended Match</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    {{ 'No job history found for company '.$company->company_name }}
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
            $('#job').DataTable();
        } );
    </script>
@endsection