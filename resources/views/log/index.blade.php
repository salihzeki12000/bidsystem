@extends('app')
@section('content')
    <div class="row">
        <h3 class="pull-left">Transaction Logs</h3>
    </div>
    <hr>
    <table id="log_table" class="display">
        <thead>
        <tr>
            <th>Action Type</th>
            <th>Action Description</th>
            <th>Perform By</th>
            <th>IP Address</th>
            <th>Target Category</th>
            <th>Target ID</th>
            <th>Result</th>
            <th>Action Time</th>
        </tr>
        </thead>
        <tbody>
        @foreach($system_logs as $log)
            <tr>
                <td>{{ $log->action_type }}</td>
                <td>{{ $log->action_description }}</td>
                <td>
                    @if(is_numeric($log->perform_by))
                        <a href="/user/edit_user_profile/{{ $log->perform_by }}">{{ $log->perform_by }}</a>
                    @else
                        {{ $log->perform_by }}
                    @endif
                </td>
                <td>{{ $log->ip_address_of_initiator }}</td>
                <td>{{ $log->target_category }}</td>
                <td>{{ $log->target_id }}</td>
                <td>{{ $log->result }}</td>
                <td>{{ $log->updated_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#log_table').DataTable({
                "bSort" : false
            });
        });
    </script>
@endsection