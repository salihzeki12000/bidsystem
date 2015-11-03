@if (Session::has('success_message'))
    <div class="alert alert-success" style="z-index: 100;">
        <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ Session::get('success_message') }}
    </div>
@elseif(Session::has('alert_message'))
    <div class="alert alert-danger">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ Session::get('alert_message') }}
    </div>
@endif