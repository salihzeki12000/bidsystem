@extends('app')

@section('content')
    <div class="col-md-10 col-md-offset-1">
        <div class="row">
            <h3 class="pull-left">Ticket Category</h3>
        </div>
        <hr>
        <table id="ticket_category_table" class="table table-bordered">
            <thead>
            <tr>
                <th>Category Name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category_key => $category)
                <tr>
                    <td>{{ $category }}</td>
                    <td>
                        <form method="POST" action="/ticket/{{ $category_key }}" enctype="multipart/form-data" class="delete_ticket_category_form">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button class="btn btn-sm btn-danger" type="submit"><span class="glyphicon glyphicon-trash" title="Delete"></span></button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <form class="form-horizontal" role="form" method="POST" action="/ticket/save_category" enctype="multipart/form-data" id="ticket_category_form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="panel panel-default">
                <div class="panel-heading">Add Category</div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Category Name</label>
                        <div class="col-sm-6">
                            <input class="form-control" name="category_name">
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready( function () {
            //$('#ticket_category_table').DataTable();
        });
    </script>
@endsection