@extends('app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <h3 class="pull-left">Job List</h3>
            <h3 class="pull-right"><a href="/job/create" class="btn btn-primary">Create Job</a></h3>
        </div>
        <hr>
        <table id="job_table" class="display">
            <thead>
            <tr>
                <th>Company Name</th>
                <th>Location</th>
                <th>Contract Term (Year)</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($jobs as $job)
                <tr>
                    <td><a href="/company/{{ $job->company_id }}" target="_blank">{{ $job->company->company_name }}</a></td>
                    <td>{{ $job->location->town.','.$job->location->state.','.$job->location->country.' '.$job->location->postcode }}</td>
                    <td>{{ $job->contract_term }}</td>
                    <td>{{ $job->rfi_status->rfi_status }}</td>
                    <td>
                        <form method="POST" action="/job/{{ $job->id }}" enctype="multipart/form-data" class="delete_job_form">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <a class="btn btn-sm btn-success" href="/job/{{ $job->id }}" title="View"><span class="glyphicon glyphicon-file"></span></a>
                            <a class="btn btn-sm btn-warning" href="/job/manage_job_files/{{ $job->id }}" title="Files"><span class="glyphicon glyphicon-folder-open"></span></a>
                            <a class="btn btn-sm btn-primary" href="/job/{{ $job->id }}/edit" title="Edit"><span class="glyphicon glyphicon-edit"></span></a>
                            <button class="btn btn-sm btn-danger" type="submit"><span class="glyphicon glyphicon-trash" title="Delete"></span></button>
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