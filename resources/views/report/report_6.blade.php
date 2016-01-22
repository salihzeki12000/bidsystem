<table class="table table-bordered">
    <tr>
        <th>Total Bids</th>
        <th>Number of success bids</th>
        <th>Number of failure bids</th>
    </tr>
    <tr>
        <td>{{ count($bids) }}</td>
        <td>{{ $count_success }}</td>
        <td>{{ $count_failure }}</td>
    </tr>
</table>