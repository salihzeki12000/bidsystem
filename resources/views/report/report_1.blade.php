<table class="table table-bordered">
    <tr>
        <td>Number of draft jobs: </td>
        <td>{{ $count_draft }}</td>
    </tr>
    <tr>
        <td>Number of published jobs: </td>
        <td>{{ $count_published }}</td>
    </tr>
    <tr>
        <td>Number of awarded jobs: </td>
        <td>{{ $count_awarded }}</td>
    </tr>
    <tr>
        <td>Number of canceled jobs: </td>
        <td>{{ $count_canceled }}</td>
    </tr>
</table>
<table class="table table-bordered">
    <tr>
        <th>Job ID</th>
        <th>Post Date</th>
        <th>Status</th>
    </tr>
    @if(count($jobs) > 0)
        @foreach($jobs as $job)
            <tr>
                <td>{{ $job->id }}</td>
                <td>{{ $job->created_at }}</td>
                <td>{{ $job->rfi_status->rfi_status }}</td>
            </tr>
        @endforeach
    @endif
</table>