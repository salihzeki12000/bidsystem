@extends('app')

@section('content')
    <div class="col-md-10 col-md-offset-1">
        <div class="row">
            <h3 class="pull-left">Tickets</h3>
            <h3 class="pull-right">
                <a href="/ticket/create" class="btn btn-sm btn-primary">Create Ticket</a>
            </h3>
        </div>
        <hr>
        <table id="ticket_table" class="display">
            <thead>
            <tr>
                <th>Company Name</th>
                <th>Category</th>
                <th>Subject</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->company->company_name or 'Admin' }}</td>
                    <td>{{ $ticket->category->name }}</td>
                    <td>{{ $ticket->issue_subject }}</td>
                    <td>{{ $ticket->status }}</td>
                    <td>
                        <a class="btn btn-sm btn-success" href="/ticket/{{ $ticket->id }}" title="View"><span class="glyphicon glyphicon-file"></span></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready( function () {
            $('#ticket_table').DataTable();
        });
    </script>
@endsection