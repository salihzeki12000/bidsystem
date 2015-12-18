@extends('app')

@section('content')
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-body text-center">
                <h1>
                    <span class="glyphicon glyphicon-ok" style="color: green"></span>
                    <small> Rating has been submitted. Thank you for your support!</small>
                </h1>
                <p><a class="btn btn-success" href="/rating/list_companies">OK</a></p>
            </div>
        </div>
    </div>
@endsection