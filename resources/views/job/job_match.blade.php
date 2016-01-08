@extends('app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <h3 class="pull-left">Top matches of jobs</h3>
        </div>
        @if(count($jobs) > 0)
            <table id="job_table" class="display">
                <thead>
                <tr>
                    <th>Job ID</th>
                    <th>Job Requirements</th>
                    <th>Job Potentials</th>
                    <th>Match Percentage</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach($jobs as $job)
                    <tr>
                        <td><a href="/job/{{ $job->id }}" target="_blank">{{ $job->id }}</a></td>
                        <td>
                            @foreach($job->requirements as $requirement)
                                {{ $requirement->requirement }}
                                <br>
                            @endforeach
                        </td>
                        <td>
                            @foreach($job->potentials as $potential)
                                {{ $potential->potential }}
                                <br>
                            @endforeach
                        </td>
                        <td></td>
                        <td>
                            <a href="/bid/bid_job/{{ $job->id }}" class="btn btn-sm btn-success" target="_blank">Bid</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <h4>There's no suitable matches.</h4>
        @endif
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready( function () {
            $('#job_table').DataTable({
                "paging":   false
            });
        });
    </script>
@endsection