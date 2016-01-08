<table class="table">
    <tr>
        <th>Job ID</th>
        <th>Number of Days</th>
        <th>Total number of bids received over defined time period</th>
        <th>Performance</th>
    </tr>
    @if(count($jobs) > 0)
        @foreach($jobs as $job)
            <tr>
                <td>{{ $job->id }}</td>
                <td>{{ $job->number_of_days }}</td>
                <td>{{ $job->total_bids }}</td>
                <td>{{ $job->performance }}</td>
            </tr>
        @endforeach
    @endif
</table>