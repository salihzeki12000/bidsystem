@extends('app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <h4>
                                        New Jobs ({{ $current_month }})
                                        <span class="badge">{{ count($new_jobs) }}</span>
                                    </h4>
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse @if(count($new_jobs) > 0) in @endif" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                @if(count($new_jobs) > 0)
                                    <ul class="list-group">
                                    @foreach($new_jobs as $job)
                                            <li class="list-group-item">
                                                <a href="/job/{{ $job->id }}" target="_blank">Job ID: {{ $job->id }}</a>
                                                <a href="/company/{{ $job->company_id }}" target="_blank" class="pull-right">{{ $job->company->company_name }}</a>
                                            </li>
                                    @endforeach
                                    </ul>
                                @else
                                    <p>No new job published this month.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="panel-group" id="bid" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingBid">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#bid" href="#bidPanel" aria-expanded="true" aria-controls="bid">
                                    <h4>
                                        New Bids ({{ $current_month }})
                                        <span class="badge">{{ count($new_bids) }}</span>
                                    </h4>
                                </a>
                            </h4>
                        </div>
                        <div id="bidPanel" class="panel-collapse collapse @if(count($new_bids) > 0) in @endif" role="tabpanel" aria-labelledby="headingBid">
                            <div class="panel-body">
                                @if(count($new_bids) > 0)
                                    <ul class="list-group">
                                        @foreach($new_bids as $bid)
                                            <li class="list-group-item">
                                                <a href="/bid/{{ $bid->id }}" target="_blank">Bid ID: {{ $bid->id }}</a>
                                                <a href="/company/{{ $bid->company_id }}" target="_blank" class="pull-right">{{ $bid->company->company_name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>No new outsourcer registered this month.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="panel-group" id="lsp" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingLsp">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#lsp" href="#lspPanel" aria-expanded="true" aria-controls="lsp">
                                    <h4>
                                        New LSP ({{ $current_month }})
                                        <span class="badge">{{ count($new_lsp) }}</span>
                                    </h4>
                                </a>
                            </h4>
                        </div>
                        <div id="lspPanel" class="panel-collapse collapse @if(count($new_lsp) > 0) in @endif" role="tabpanel" aria-labelledby="headingLsp">
                            <div class="panel-body">
                                @if(count($new_lsp) > 0)
                                    <ul class="list-group">
                                        @foreach($new_lsp as $lsp)
                                            <li class="list-group-item">
                                                <a href="/company/{{ $lsp->id }}" target="_blank">{{ $lsp->company_name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>No new LSP registered this month.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-1">

            </div>
            <div class="col-sm-3">
                <div class="panel-group" id="outsourcer" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOutsourcer">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#outsourcer" href="#outsourcerPanel" aria-expanded="true" aria-controls="outsourcer">
                                    <h4>
                                        New Outsourcer ({{ $current_month }})
                                        <span class="badge">{{ count($new_outsourcer) }}</span>
                                    </h4>
                                </a>
                            </h4>
                        </div>
                        <div id="outsourcerPanel" class="panel-collapse collapse @if(count($new_outsourcer) > 0) in @endif" role="tabpanel" aria-labelledby="headingOutsourcer">
                            <div class="panel-body">
                                @if(count($new_outsourcer) > 0)
                                    <ul class="list-group">
                                        @foreach($new_outsourcer as $outsourcer)
                                            <li class="list-group-item">
                                                <a href="/company/{{ $outsourcer->id }}" target="_blank">{{ $outsourcer->company_name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>No new outsourcer registered this month.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
        <hr>
        <div class="col-xs-6 col-sm-3">
            <h5>
                <a href="/company">Manage Company</a>
            </h5>
        </div>
        <div class="col-xs-6 col-sm-3">
            <h5>
                <a href="/user">Manage User</a>
            </h5>
        </div>
        <div class="col-xs-6 col-sm-3">
            <h5>
                <a href="/job">Manage Job</a>
            </h5>
        </div>
        <div class="col-xs-6 col-sm-3">
            <h5>
                <a href="/bid">Manage Bid</a>
            </h5>
        </div>
        <div class="col-xs-6 col-sm-3">
            <h5>
                <a href="/user/edit_user_profile/{{ \Auth::id() }}">Profile</a>
            </h5>
        </div>
        <div class="col-xs-6 col-sm-3">
            <h5>
                <a href="/manage_group_user">Manage Group User</a>
            </h5>
        </div>
    </div>
@endsection