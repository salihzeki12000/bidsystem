@extends('app')
@section('inside-style')
        h5{
            font-size: 16px !important;
        }
@endsection
@section('content')
    <div class="container-fluid">
        @can('inward-user-only')
        <div class="row">
            <div class="col-sm-3">
                <div class="panel-group" id="expiring_jobs" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#expiring_jobs" href="#expiring_jobs_collapse" aria-expanded="true" aria-controls="expiring_jobs_collapse">
                                    <h5>
                                        Expiring Jobs
                                        <span class="badge pull-right">{{ count($expiring_jobs) }}</span>
                                    </h5>
                                </a>
                            </h4>
                        </div>
                        <div id="expiring_jobs_collapse" class="panel-collapse collapse @if(count($expiring_jobs) > 0) in @endif" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                @if(count($expiring_jobs) > 0)
                                    <ul class="list-group">
                                        @foreach($expiring_jobs as $job)
                                            <li class="list-group-item">
                                                <a href="/job/{{ $job->id }}" target="_blank">Job ID: {{ $job->id }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>No expiring jobs.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="panel-group" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a role="button" aria-expanded="true" aria-controls="collapseOne">
                                    <h5>
                                        Total number of LSP
                                        <span class="badge pull-right">{{ count($total_number_of_suppliers) }}</span>
                                    </h5>
                                </a>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="panel-group" id="new_lsp" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#new_lsp" href="#new_lsp_collapse" aria-expanded="true" aria-controls="new_lsp_collapse">
                                    <h5>
                                        New LSP
                                        <span class="badge pull-right">{{ count($new_suppliers) }}</span>
                                    </h5>
                                </a>
                            </h4>
                        </div>
                        <div id="new_lsp_collapse" class="panel-collapse collapse @if(count($new_suppliers) > 0) in @endif" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                @if(count($new_suppliers) > 0)
                                    <ul class="list-group">
                                        @foreach($new_suppliers as $supplier)
                                            <li class="list-group-item">
                                                <a href="/company/{{ $supplier->id }}" target="_blank">{{ $supplier->company_name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>No expiring jobs.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="panel-group" id="incomingBid" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingincomingBid">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#incomingBid" href="#incomingBidPanel" aria-expanded="true" aria-controls="incomingBid">
                                    <h5>
                                        Incoming bids
                                        <span class="badge pull-right">{{ count($incoming_bids) }}</span>
                                    </h5>
                                </a>
                            </h4>
                        </div>
                        <div id="incomingBidPanel" class="panel-collapse collapse @if(count($incoming_bids) > 0) in @endif" role="tabpanel" aria-labelledby="headingincomingBid">
                            <div class="panel-body">
                                @if(count($incoming_bids) > 0)
                                    <ul class="list-group">
                                        @foreach($incoming_bids as $bid)
                                            <li class="list-group-item">
                                                <a href="/bid/{{ $bid }}" target="_blank">Bid ID: {{ $bid }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>No new incoming bids.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <div class="panel-group" id="message" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingMessage">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#message" href="#messagePanel" aria-expanded="true" aria-controls="message">
                                    <h5>
                                        New Messages
                                        <span class="badge pull-right">{{ count($new_messages) }}</span>
                                    </h5>
                                </a>
                            </h4>
                        </div>
                        <div id="messagePanel" class="panel-collapse collapse @if(count($new_messages) > 0) in @endif" role="tabpanel" aria-labelledby="headingMessage">
                            <div class="panel-body">
                                @if(count($new_messages) > 0)
                                    <ul class="list-group">
                                        @foreach($new_messages as $message)
                                            <li class="list-group-item">
                                                <a href="/messages/{{ \Auth::user()->company_id }}" target="_blank">{{ $message->subject }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>No new messages.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="panel-group" id="appointment" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingAppointment">
                            <h4 class="panel-title">
                                <a role="button" aria-expanded="true">
                                    <h5>
                                        Unconfirmed Appointments
                                        <span class="badge pull-right">{{ count($new_appointments_request) }}</span>
                                    </h5>
                                </a>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        @can('outward-user-only')
        <div class="row">
            <div class="col-sm-3">
                <div class="panel-group" id="expiring_unbid_jobs" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#expiring_unbid_jobs" href="#expiring_unbid_jobs_collapse" aria-expanded="true" aria-controls="expiring_unbid_jobs_collapse">
                                    <h5>
                                        Expiring Unbid Jobs
                                        <span class="badge pull-right">{{ count($unbid_jobs) }}</span>
                                    </h5>
                                </a>
                            </h4>
                        </div>
                        <div id="expiring_unbid_jobs_collapse" class="panel-collapse collapse @if(count($unbid_jobs) > 0) in @endif" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                @if(count($unbid_jobs) > 0)
                                    <ul class="list-group">
                                        @foreach($unbid_jobs as $job)
                                            <li class="list-group-item">
                                                <a href="/job/{{ $job->id }}" target="_blank">Job ID: {{ $job->id }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>No expiring unbid jobs.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="panel-group" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a role="button" aria-expanded="true" aria-controls="collapseOne">
                                    <h5>
                                        Total number of outsourcers
                                        <span class="badge pull-right">{{ count($total_number_of_outsourcers) }}</span>
                                    </h5>
                                </a>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="panel-group" id="outsourser_industry" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#outsourser_industry" href="#outsourser_industry_collapse" aria-expanded="true" aria-controls="outsourser_industry_collapse">
                                    <h5>
                                        New outsourcers
                                        <span class="badge pull-right">{{ count($companies_group_by_industry) }}</span>
                                    </h5>
                                </a>
                            </h4>
                        </div>
                        <div id="outsourser_industry_collapse" class="panel-collapse collapse @if(count($companies_group_by_industry) > 0) in @endif" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                @if(count($companies_group_by_industry) > 0)
                                    <ul class="list-group">
                                        @foreach($companies_group_by_industry as $industry => $outsourcer)
                                            <li class="list-group-item">
                                                <p>
                                                    {{ $industry }}
                                                    <span class="badge pull-right">{{ count($outsourcer) }}</span>
                                                </p>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>No expiring jobs.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="panel-group" id="message" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingMessage">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#message" href="#messagePanel" aria-expanded="true" aria-controls="message">
                                    <h5>
                                        New Messages
                                        <span class="badge pull-right">{{ count($new_messages) }}</span>
                                    </h5>
                                </a>
                            </h4>
                        </div>
                        <div id="messagePanel" class="panel-collapse collapse @if(count($new_messages) > 0) in @endif" role="tabpanel" aria-labelledby="headingMessage">
                            <div class="panel-body">
                                @if(count($new_messages) > 0)
                                    <ul class="list-group">
                                        @foreach($new_messages as $message)
                                            <li class="list-group-item">
                                                <a href="/messages/{{ \Auth::user()->company_id }}" target="_blank">{{ $message->subject }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>No new messages.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <div class="panel-group" id="appointment" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingAppointment">
                            <h4 class="panel-title">
                                <a role="button" aria-expanded="true">
                                    <h5>
                                        Unconfirmed Appointments
                                        <span class="badge pull-right">{{ count($new_appointments_request) }}</span>
                                    </h5>
                                </a>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        @can('globe-admin-above')
        <div class="row">
            <div class="col-sm-3">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <h5>
                                        New Jobs in last 30 days
                                        <span class="badge pull-right">{{ $sum_new_jobs }}</span>
                                    </h5>
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse @if(count($industries) > 0) in @endif" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                @if(count($industries) > 0)
                                    <ul class="list-group">
                                        @foreach($industries as $industry)
                                            <li class="list-group-item">
                                                <p>
                                                    {{ $industry->industry }}
                                                    <span class="pull-right">{{ $industry->count }}</span>
                                                </p>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>No new job published in last 30 days.</p>
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
                                    <h5>
                                        New Bids in last 30 days
                                        <span class="badge pull-right">{{ $sum_new_bids }}</span>
                                    </h5>
                                </a>
                            </h4>
                        </div>
                        <div id="bidPanel" class="panel-collapse collapse @if(count($locations) > 0) in @endif" role="tabpanel" aria-labelledby="headingBid">
                            <div class="panel-body">
                                @if(count($locations) > 0)
                                    <ul class="list-group">
                                        @foreach($locations as $location)
                                            <li class="list-group-item">
                                                <p>
                                                    {{ $location->town.' '.$location->state.' '.$location->country }}
                                                    <span class="pull-right">{{ $location->count }}</span>
                                                </p>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>No new bids posted in last 30 days.</p>
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
                                    <h5>
                                        New LSP in last 30 days
                                        <span class="badge pull-right">{{ count($new_lsp) }}</span>
                                    </h5>
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
                                    <p>No new LSP registered in last 30 days.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="panel-group" id="outsourcer" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOutsourcer">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#outsourcer" href="#outsourcerPanel" aria-expanded="true" aria-controls="outsourcer">
                                    <h5>
                                        New Outsourcer in last 30 days
                                        <span class="badge pull-right">{{ count($new_outsourcer) }}</span>
                                    </h5>
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
                                    <p>No new outsourcer registered in last 30 days.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <div class="panel-group" id="ticket" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingTicket">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#ticket" href="#ticketPanel" aria-expanded="true" aria-controls="ticket">
                                    <h5>
                                        Unattended Ticket
                                        <span class="badge pull-right">{{ count($new_tickets) }}</span>
                                    </h5>
                                </a>
                            </h4>
                        </div>
                        <div id="ticketPanel" class="panel-collapse collapse @if(count($new_tickets) > 0) in @endif" role="tabpanel" aria-labelledby="headingTicket">
                            <div class="panel-body">
                                @if(count($new_tickets) > 0)
                                    <ul class="list-group">
                                        @foreach($new_tickets as $ticket)
                                            <li class="list-group-item">
                                                <a href="/ticket/{{ $ticket->id }}" target="_blank">Ticket ID: {{ $ticket->id }}</a>
                                                @if(!empty($ticket->company))
                                                    <a href="/company/{{ $ticket->company->id }}" target="_blank" class="pull-right">{{ $ticket->company->company_name }}</a>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>No new tickets.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        <div class="clearfix"></div>
        <hr>
        <div class="col-xs-6 col-sm-2">
            <h5 class="text-center">
                <a href="/company"><img src="/images/icons/Department-100.png" width="50" height="50"/> <br>Company</a>
            </h5>
        </div>
        @can('globe-admin-above')
        <div class="col-xs-6 col-sm-2">
            <h5 class="text-center">
                <a href="/user"><img src="/images/icons/User Male-100.png" width="50" height="50"/> <br>User</a>
            </h5>
        </div>
        @endcan
        @can('non-outward-user')
        <div class="col-xs-6 col-sm-2">
            <h5 class="text-center">
                @can('non-system-admin')
                    <a href="/company/job_history/{{ \Auth::user()->company_id }}"><img src="/images/icons/Strike-100.png" width="50" height="50"/> <br>Job</a>
                @else
                    <a href="/job"><img src="/images/icons/Strike-100.png" width="50" height="50"/> <br>Job</a>
                @endcan
            </h5>
        </div>
        @endcan
        @can('non-inward-user')
        <div class="col-xs-6 col-sm-2">
            <h5 class="text-center">
                @can('non-system-admin')
                    <a href="/company/bid_history/{{ \Auth::user()->company_id }}"><img src="/images/icons/Court Judge-100.png" width="50" height="50"/> <br>Bid</a>
                @else
                    <a href="/bid"><img src="/images/icons/Court Judge-100.png" width="50" height="50"/> <br>Bid</a>
                @endcan
            </h5>
        </div>
        @endcan
        @can('non-system-admin')
        <div class="col-xs-6 col-sm-2">
            <h5 class="text-center">
                <a href="/manage_group_user/{{ \Auth::user()->company_id }}"><img src="/images/icons/Conference-100.png" width="50" height="50"/> <br>Manage Group User</a>
            </h5>
        </div>
        @endcan
        @can('non-inward-user')
        <div class="col-xs-6 col-sm-2">
            <h5 class="text-center">
                <a href="/search_job"><img src="/images/icons/Search-100.png" width="50" height="50"/> <br>Search Job</a>
            </h5>
        </div>
        @endcan
        <div class="col-xs-6 col-sm-2">
            <h5 class="text-center">
                @can('globe-admin-above')
                    <a href="/appointments"><img src="/images/icons/Calendar-100.png" width="50" height="50"/> <br>Appointments</a>
                @else
                    <a href="/show_all_appointments/{{ \Auth::user()->company_id }}"><img src="/images/icons/Calendar-100.png" width="50" height="50"/> <br>Appointments</a>
                @endcan
            </h5>
        </div>
        <div class="col-xs-6 col-sm-2">
            <h5 class="text-center">
                @can('globe-admin-above')
                    <a href="/ticket"><img src="/images/icons/Customer Support-100.png" width="50" height="50"/> <br>Ticket</a>
                @else
                       <a href="/ticket/show_my_tickets/{{ \Auth::user()->company_id }}"><img src="/images/icons/Customer Support-100.png" width="50" height="50"/> <br>Ticket</a>
                @endcan
            </h5>
        </div>
        <div class="col-xs-6 col-sm-2">
            <h5 class="text-center">
                <a href="/rating/list_companies"><img src="/images/icons/Star-100.png" width="50" height="50"/> <br>Rating</a>
            </h5>
        </div>
        @can('super-admin-only')
		<div class="col-xs-6 col-sm-2">
            <h5 class="text-center">
                <a href="/user_performance" ><img src="/images/icons/User Menu-100.png" width="50" height="50"/> <br>User Performance</a>
            </h5>
        </div>
        @endcan
        @can('globe-admin-above')
        <div class="col-xs-6 col-sm-2">
            <h5 class="text-center">
                <a href="/system" ><img src="/images/icons/system.png" width="50" height="50"/> <br>System</a>
            </h5>
        </div>
        @endcan
        @can('globe-admin-above')
        <div class="col-xs-6 col-sm-2">
            <h5 class="text-center">
                <a href="/log" ><img src="/images/icons/system.png" width="50" height="50"/> <br>Transaction Logs</a>
            </h5>
        </div>
        @endcan
        <div class="col-xs-6 col-sm-2">
            <h5 class="text-center">
                <a href="/report/report" ><img src="/images/icons/system.png" width="50" height="50"/> <br>Report</a>
            </h5>
        </div>
    </div>
@endsection