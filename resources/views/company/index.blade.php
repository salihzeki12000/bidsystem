@extends('app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <h3 class="pull-left">Company List</h3>
            <h3 class="pull-right"><a href="/company/create" class="btn btn-primary">Create Company</a></h3>
        </div>
        <hr>
        <table id="company_table" class="display">
            <thead>
            <tr>
                <th>Company Name</th>
                <th>Category</th>
                <th>Status</th>
                <th>Created By</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($companies as $company)
                <tr>
                    <td @if($company->status == 'Inactive') style="color: red;" @endif>{{ $company->company_name }}</td>
                    <td @if($company->status == 'Inactive') style="color: red;" @endif>{{ $company->category }}</td>
                    <td @if($company->status == 'Inactive') style="color: red;" @endif>
                        {{ $company->status }}
                    </td>
                    <td @if($company->status == 'Inactive') style="color: red;" @endif>{{ $company->createdBy->email.'('.$company->createdBy->type.')' }}</td>
                    <td>
                        <form method="POST" action="/company/{{ $company->id }}" enctype="multipart/form-data" class="delete_company_form">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <a class="btn btn-sm btn-success" href="/company/{{ $company->id }}" title="View"><span class="glyphicon glyphicon-file"></span></a>
                            <a class="btn btn-sm btn-warning" href="/company/manage_company_files/{{ $company->id }}" title="Files"><span class="glyphicon glyphicon-folder-open"></span></a>
                            <a class="btn btn-sm btn-primary" href="/company/{{ $company->id }}/edit" title="Edit"><span class="glyphicon glyphicon-edit"></span></a>
                            <a class="btn btn-sm btn-default" href="/company/history/{{ $company->id }}" title="History"><span class="glyphicon glyphicon-list-alt"></span></a>
                            <button class="btn btn-sm btn-danger" type="submit"><span class="glyphicon glyphicon-trash" title="Delete"></span></button>
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
        $(document).ready( function () {
            $('#company_table').DataTable();

            $('.delete_company_form').submit(function(ev) {
                ev.preventDefault();
                if (confirm('Are you sure you want to delete this company?')) {
                    this.submit();
                }
            });
        } );
    </script>
@endsection