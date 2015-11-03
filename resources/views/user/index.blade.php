@extends('app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <h3 class="pull-left">User List</h3>
            <h3 class="pull-right"><a href="/user/create" class="btn btn-primary">Create User</a></h3>
        </div>
        <hr>
        <table id="user_table" class="display">
            <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Company</th>
                <th>Type</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->company->company_name or null }}</td>
                    <td>{{ $user->type }}</td>
                    <td>{{ $user->status }}</td>
                    <td>
                        <form method="POST" action="/user/{{ $user->id }}" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <a class="btn btn-sm btn-primary" href="/user/{{ $user->id }}/edit"><span class="glyphicon glyphicon-edit"></span></a>
                            <button class="btn btn-sm btn-danger" type="submit"><span class="glyphicon glyphicon-trash"></span></button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#user_table').DataTable();
        });
    </script>
@endsection