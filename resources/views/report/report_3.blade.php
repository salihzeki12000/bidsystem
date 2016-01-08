<table class="table">
    <tr>
        <th>Job ID</th>
        <th>Existing Budget</th>
        <th>Exceed Budget(count)</th>
        <th>Below Budget(count)</th>
        <th>Equal Budget(count)</th>
    </tr>
    @if(count($jobs) > 0)
        @foreach($jobs as $job)
            <tr>
                <td>{{ $job->id }}</td>
                <td>
                    @if($job->existing_budget != "")
                        {{ $job->existing_budget }}
                    @else
                        0
                    @endif
                </td>
                <td>{{ $job->exceed_budget }}</td>
                <td>{{ $job->below_budget }}</td>
                <td>{{ $job->equal_budget }}</td>
            </tr>
        @endforeach
    @endif
</table>