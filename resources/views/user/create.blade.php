@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="col-sm-12">
            <div>
                <div class="panel panel-default">
                    <div class="panel-heading">Create User Profile</div>
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

                        <form class="form-horizontal" role="form" method="POST" action="/user" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

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
                                <label class="col-md-4 control-label">Type</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="type" id="user_type_list">
                                        <option value="globe_admin">Globe Admin</option>
                                        <option value="inward_group_admin">Inward Group Admin</option>
                                        <option value="inward_group_user">Inward Group User</option>
                                        <option value="outward_group_admin">Outward Group Admin</option>
                                        <option value="outward_group_user">Outward Group User</option>
                                    </select>
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

                            <div class="form-group required" id="company_list">
                                <label class="col-md-4 control-label">Company</label>
                                <div class="col-md-6" id="company_list_wrapper">
                                    <select class="form-control" name="company_id">
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary" style="margin-right: 15px;">
                                        Submit
                                    </button>
                                    <a href="/user" class="btn btn-default">Back</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        if($('#user_type_list').val() == 'globe_admin'){
            $('#company_list').hide();
        };
        $('#user_type_list').change(function(){
            if($(this).val() == 'globe_admin'){
                $('#company_list').hide();
            }else{
                $.ajax({
                    type: "GET",
                    url: '/generate_company_list/'+$(this).val(),
                    success: function(response)
                    {
                        $('#company_list_wrapper').html(response);
                        $('#company_list').show();
                    }
                });
            }
        });
    </script>
@endsection