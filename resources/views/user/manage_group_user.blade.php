@extends('app')
@section('content')
    <div class="col-sm-12">
        <div class="row">
            <h3 class="pull-left">User List For {{ $company->company_name or 'Admin' }}</h3>
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
                @if( $user->type !== 'inward_group_admin' && $user->type !== 'outward_group_admin' && $user->type !== 'super_admin' && $user->type !== 'globe_admin' )
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
                @endif
            @endforeach
            </tbody>
        </table>

        <div class="clearfix"></div>
        <hr>
        <div class="col-md-8 col-md-offset-2">
            <h4>Available Quota: {{ $company->account_quota or 0 - count($users) }}</h4>
            <div class="panel panel-default">
                <div class="panel-heading">Create New User</div>
                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="form-horizontal" role="form" method="POST" action="/add_normal_user" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="company_type" value="{{ $company->category or null }}" />
                        <input type="hidden" name="company_id" value="{{ $company->id or null }}" />
                        <input type="hidden" name="company_quota" value="{{ $company->account_quota or 0 - count($users) }}" />

                        <div class="form-group required">
                            <label class="col-md-4 control-label">First Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required>
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Last Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required>
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Email</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="email" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Password</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password" required>
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Status</label>
                            <div class="col-md-6">
                                <select class="form-control" name="status">
                                    <option value="Draft">Draft</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary" style="margin-right: 15px;">
                                    Submit
                                </button>
                                <a href="/home" class="btn btn-default">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#user_table').DataTable();
        });
    </script>
@endsection