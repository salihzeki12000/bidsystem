@extends('app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <h3 class="pull-left">Company List</h3>
            @can('globe-admin-above')
            <h3 class="pull-right"><a href="/company/create" class="btn btn-primary">Create Company</a></h3>
            @endcan
        </div>
        <hr>
        <table id="company_table" class="display">
            <thead>
            <tr>
                <th>Company Name</th>
                <th>Category</th>
                @can('globe-admin-above')
                <th>Status</th>
                <th>Created By</th>
                @endcan
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($companies as $company)
                <tr>
                    <td @if($company->status == 'Inactive') style="color: red;" @endif>{{ $company->company_name }}</td>
                    <td @if($company->status == 'Inactive') style="color: red;" @endif>{{ $company->category }}</td>
                    @can('globe-admin-above')
                    <td @if($company->status == 'Inactive') style="color: red;" @endif>
                        {{ $company->status }}
                    </td>
                    <td @if($company->status == 'Inactive') style="color: red;" @endif>{{ $company->createdBy->email.'('.$company->createdBy->type.')' }}</td>
                    @endcan
                    <td>
                    @can('globe-admin-above')
                        <div class="row">
                            <a class="btn btn-sm btn-success" href="/company/{{ $company->id }}" title="View">View</a>
                            <a class="btn btn-sm btn-warning" href="/company/manage_company_files/{{ $company->id }}" title="Files">Files</a>
                            <a class="btn btn-sm btn-primary" href="/company/{{ $company->id }}/edit" title="Edit">Edit</a>
                            <a class="btn btn-sm btn-default" @if($company->category == 'LSP') href="/company/bid_history/{{ $company->id }}" @elseif($company->category == 'Outsourcing') href="/company/job_history/{{ $company->id }}" @endif title="History">History</a>
                            <a class="btn btn-sm btn-primary" href="/credit/new_credit_transaction/{{ $company->id }}" title="Credit">Credit</a>
                            @can('super-admin-only')
                            <form method="POST" action="/company/{{ $company->id }}" enctype="multipart/form-data" class="delete_company_form">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Are you sure you want to delete {{ $company->company_name }}?')">Delete</button>
                            </form>
                            @endcan
                        </div>
                    @else
                            <a class="btn btn-sm btn-success" href="/company/{{ $company->id }}" title="View">View</a>
                    @endcan
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

            @can('globe-admin-above')
//            $('.delete_company_form').submit(function(ev) {
//                ev.preventDefault();
//                if (confirm('Are you sure you want to delete this company?')) {
//                    this.submit();
//                }
//            });
            @endcan

        } );
    </script>
@endsection