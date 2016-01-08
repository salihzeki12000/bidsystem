@extends('app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <h3 class="pull-left">Job List</h3>
            @can('super-admin-only')
            <h3 class="pull-right"><a href="/job/create" class="btn btn-primary">Create Job</a></h3>
            @endcan
        </div>
        <hr>
        <table id="job_table" class="display">
            <thead>
            <tr>
                <th>Job ID</th>
                <th>Company Name</th>
                <th>Location</th>
                <th>Requirements</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($jobs as $job)
                <tr>
                    <td><a href="/job/{{ $job->id }}" target="_blank">{{ $job->id }}</a></td>
                    <td><a href="/company/{{ $job->company_id }}" target="_blank">{{ $job->company->company_name }}</a></td>
                    <td>{{ $job->location->town.','.$job->location->state.','.$job->location->country.' '.$job->location->postcode }}</td>
                    <td>
                        @if(count($job->requirements) > 0)
                            @foreach($job->requirements as $requirement)
                                {{ $requirement->requirement }}<br>
                            @endforeach
                        @endif
                    </td>
                    <td>
                        <form method="POST" action="/job/{{ $job->id }}" enctype="multipart/form-data" class="delete_job_form">
                            <a class="btn btn-sm btn-success" href="/job/{{ $job->id }}" title="View">View</a>
                            <a class="btn btn-sm btn-warning" href="/job/manage_job_files/{{ $job->id }}" title="Files">Files</a>
                            <a class="btn btn-sm btn-primary" href="/job/{{ $job->id }}/edit" title="Edit">Edit</a>
                            <a class="btn btn-sm btn-primary" href="/match/{{ $job->id }}" title="Matches">Recommended Match</a>
                            @can('super-admin-only')
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                            @endcan
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
            $('#job_table').DataTable();

            $('.delete_job_form').submit(function(ev) {
                ev.preventDefault();
                if (confirm('Are you sure you want to delete this job?')) {
                    this.submit();
                }
            });
        } );
    </script>
@endsection