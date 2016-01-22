<table class="table table-bordered">
    <tr>
        <th>Total Bids</th>
        <th>Number of sales</th>
        <th>Number of open bids</th>
    </tr>
    <tr>
        <td>{{ count($bids) }}</td>
        <td>{{ $count_sales }}</td>
        <td>{{ $count_open_bids }}</td>
    </tr>
</table>