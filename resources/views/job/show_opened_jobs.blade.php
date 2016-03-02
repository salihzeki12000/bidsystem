@extends('app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <h3 class="pull-left">Opened Job List</h3>
        </div>
        <hr>
        @if(count($opened_jobs) > 0)
            <form action="/close_jobs" role="form" method="POST" enctype="multipart/form-data" id="close_job_form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <table id="job_table" class="display">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Job ID</th>
                        <th>Company Name</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($opened_jobs as $job)
                        <tr>
                            <td><input type="checkbox" name="jobs[]" value="{{ $job->id }}"></td>
                            <td><a href="/job/{{ $job->id }}" target="_blank">{{ $job->id }}</a></td>
                            <td class="text-center">
                                <a href="/company/{{ $job->company_id }}" target="_blank">
                                    <img src="{{ $job->company->logo }}" style="max-width: 100px;"><br>
                                    {{ $job->company->company_name }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="clearfix"></div>
                <hr>
                <a class="btn btn-primary" onclick="window.history.back();">Back</a>
                <button class="btn btn-danger pull-right" type="submit">Close Selected Jobs</button>
            </form>
        @else
            <p>No pending or opening jobs.</p>
        @endif
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready( function () {
            $('#job_table').DataTable();
        } );
    </script>
@endsection