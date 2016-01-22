<table class="table table-bordered">
    <tr>
        <th>Industry List</th>
        <th>Number of success bids</th>
        <th>Number of failure bids</th>
    </tr>
    @foreach($refined_bids_group_by_industry_array as $bid_industry)
        <tr>
            <td>{{ $bid_industry['industry'] }}</td>
            <td>{{ $bid_industry['success'] }}</td>
            <td>{{ $bid_industry['failure'] }}</td>
        </tr>
    @endforeach
</table>

<table class="table table-bordered">
    <tr>
        <th>State List</th>
        <th>Number of success bids</th>
        <th>Number of failure bids</th>
    </tr>
    @foreach($refined_bids_group_by_location_array as $bid_location)
        <tr>
            <td>{{ $bid_location['state'] }}</td>
            <td>{{ $bid_location['success'] }}</td>
            <td>{{ $bid_location['failure'] }}</td>
        </tr>
    @endforeach
</table>