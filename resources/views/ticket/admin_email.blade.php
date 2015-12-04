@extends('app')

@section('content')
    <div class="col-md-10 col-md-offset-1">
        <div class="row">
            <h3 class="pull-left">Ticket Admin Email</h3>
        </div>
        <hr>

        <form class="form-horizontal" role="form" method="POST" action="/ticket/save_admin_email" enctype="multipart/form-data" id="ticket_category_form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="email_id" value="{{ $email->id or null }}">
            <div class="panel panel-default">
                <div class="panel-heading">Admin Email</div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Email</label>
                        <div class="col-sm-6">
                            <input class="form-control" name="email" type="email" value="{{ $email->email or null }}">
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