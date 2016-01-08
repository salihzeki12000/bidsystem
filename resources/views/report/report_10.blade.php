<table class="table">
    <tr>
        <th>Area of Outsource</th>
        <th>Industry(Job count)</th>
        <th>LSP Bids(Bid count)</th>
        <th>Your Company(Bid Count)</th>
        <th>% of Participation(Your company vs Job Count)</th>
        <th>% of Market Compete(Your company vs Other LSP)</th>
    </tr>
    @if(count($requirements) > 0)
        @foreach($requirements as $requirement)
            <tr>
                <td>{{ $requirement->requirement }}</td>
                <td>{{ $requirement->total_jobs }}</td>
                <td>{{ $requirement->total_bids }}</td>
                <td>{{ $requirement->total_bids_post_by_current_company }}</td>
                <td>{{ $requirement->job_bid_percentage }}%</td>
                <td>{{ $requirement->bid_percentage }}%</td>
            </tr>
        @endforeach
    @endif
</table>