<table class="table">
    <tr>
        <th>Area of Outsource</th>
        <th>Industry(Job count)</th>
        <th>Your Company(Job Count)</th>
        <th>%</th>
    </tr>
    @if(count($requirements) > 0)
        @foreach($requirements as $requirement)
            <tr>
                <td>{{ $requirement->requirement }}</td>
                <td>{{ $requirement->total_jobs }}</td>
                <td>{{ $requirement->total_jobs_post_by_current_company }}</td>
                <td>{{ $requirement->percentage }}%</td>
            </tr>
        @endforeach
    @endif
</table>