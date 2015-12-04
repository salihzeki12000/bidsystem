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
                <th>Category</th>
                <th>Performance (Jobs or Bids/Per Day)</th>
            </tr>
            </thead>
            <tbody>
            @foreach($companies as $company_key => $company)
                <tr>
                    <td>{{ $company->company_name }}</td>
                    <td>{{ $company->category }}</td>
                    <td>{{ $company->performance }}</td>
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