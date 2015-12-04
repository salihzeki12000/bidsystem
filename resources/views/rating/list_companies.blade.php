@extends('app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <h3 class="pull-left">Company List</h3>
        </div>
        <hr>
        <table id="companies_table" class="display">
            <thead>
            <tr>
                <th>Company Name</th>
                <th>Rate</th>
            </tr>
            </thead>
            <tbody>
            @foreach($companies as $company_key => $company)
                <tr>
                    <td>{{ $company }}</td>
                    <td>
                        <form method="POST" action="/rating/rate_company" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="company_id" value="{{ $company_key }}">
                            <a href="/rating/show_all_ratings/{{ $company_key }}" class="btn btn-sm btn-success">View Ratings</a>
                            <button class="btn btn-sm btn-primary" type="submit">Rate this company</button>
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
            $('#companies_table').DataTable();
        });
    </script>
@endsection