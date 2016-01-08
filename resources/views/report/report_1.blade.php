<table class="table">
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