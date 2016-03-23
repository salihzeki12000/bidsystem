@extends('app')
@section('content')
    <div class="row">
        <h3 class="pull-left">Transaction Logs</h3>
    </div>
    <hr>
    <div class="col-sm-12">
        <form method="post" action="/log" enctype="multipart/form-data" id="form">
            <input type="hidden" name="_method" value="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <label class="col-sm-1 control-label text-right">From</label>
            <div class="col-sm-4">
                <div class='input-group date' id='from_date'>
                    <input type='text' class="form-control" name="start_date" id="from" value="{{ $start_date or '' }}"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>

            <label class="col-sm-1 control-label text-right">To</label>
            <div class="col-sm-4">
                <div class='input-group date' id='to_date'>
                    <input type='text' class="form-control" name="end_date" id="to" value="{{ $end_date or '' }}"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
            <div class="col-sm-2">
                <button class="btn btn-primary" type="submit">Find</button>
            </div>
        </form>
    </div>
    <div class="clearfix"></div>
    <hr>
    <div class="row">
        <form method="post" action="/log/export" enctype="multipart/form-data" id="form">
            <input type="hidden" name="_method" value="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type='hidden' class="form-control" name="start_date_for_export" value="{{ $start_date or '' }}"/>
            <input type='hidden' class="form-control" name="end_date_for_export" value="{{ $end_date or '' }}"/>
            <button class="btn btn-success pull-right" type="submit">Export</button>
        </form>
    </div>
    <div class="clearfix"></div>
    <br>
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
                        <a href="/user/edit_user_profile/{{ $log->perform_by }}" target="_blank">{{ $log->createdBy->email }}</a>
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

            $('#from_date').datetimepicker({
                format: 'YYYY-MM-DD'
            });

            $('#to_date').datetimepicker({
                format: 'YYYY-MM-DD'
            });

        });
    </script>
@endsection