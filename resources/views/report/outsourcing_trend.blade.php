<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

@if(count($jobs) > 0)
    <table>
        <tr>
            <td>Month</td>
            <td>Company</td>
            <td>Number of jobs</td>
        </tr>
        @foreach($jobs as $job)
            <tr>
                <td>{{ $job->month }}</td>
                <td>{{ $job->company_id }}</td>
                <td>{{ $job->number_of_jobs }}</td>
            </tr>
        @endforeach
    </table>
@endif


</html>