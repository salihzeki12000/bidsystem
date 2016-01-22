<table class="table table-bordered">
    <tr>
        <th>Industry</th>
        @foreach($states as $state)
            <th>{{ $state }}</th>
        @endforeach
    </tr>
    @foreach($refined_array as $industry)
        <tr>
            <td>{{ $industry['industry'] }}</td>
            @foreach($states as $key => $state)
                @if(count($industry['places']) > 0)
                    @foreach($industry['places'] as $place_key => $place)
                        @if($place_key == $key)
                            <td>{{ $place }}</td>
                        @endif
                    @endforeach
                @else
                    <td>0</td>
                @endif
            @endforeach
        </tr>
    @endforeach
</table>