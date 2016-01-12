@extends('app')

@section('content')
    <div class="col-sm-12">
        <h4>
            View Job
            @can('super-admin-only')
            <a class="pull-right btn btn-sm btn-success" href="/bid/bid_job/{{ $job->id }}">Bid This Job</a>
            @else
                @can('outward-user-only')
                <a class="pull-right btn btn-sm btn-success" href="/bid/bid_job/{{ $job->id }}">Bid This Job</a>
                @endcan
            @endcan
        </h4>
        <br>
        <div class="panel panel-default">
            <div class="panel-heading">Job Description</div>
            <div class="panel-body">
                {!! $job->additional_description !!}
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">Special Request</div>
            <div class="panel-body">
                <p>{{ $job->special_request }}</p>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">Requirement</div>
            <div class="panel-body">
                <div class="col-md-6">
                    @foreach($job->requirements as $requirement)
                        <p>{{ $requirement->requirement }}</p>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">Potential</div>
            <div class="panel-body">
                <div class="col-md-6">
                    @foreach($job->potentials as $potential)
                        <p>{{ $potential->potential }}</p>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">Highlight</div>
            <div class="panel-body">
                <div class="col-md-6">
                    @foreach($job->highlights as $highlight)
                        <p>{{ $highlight->highlight }}</p>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">Profile</div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-md-4 control-label">Company Name</label>
                    <div class="col-md-6">
                        <p><a href="/company/{{ $job->company->id }}" target="_blank">{{ $job->company->company_name }}</a></p>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Date</label>
                    <div class="col-md-6">
                        <p>{{ $job->date }}</p>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Location</label>
                    <div class="col-md-6">
                        <p>{{ $job->location->town.','.$job->location->state.','.$job->location->country.' '.$job->location->postcode }}</p>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Existing Budget</label>
                    <div class="col-md-6">
                        <p>{{ $job->existing_budget }}</p>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Existing LSP</label>
                    <div class="col-md-6">
                        <p>
                            @if($job->existing_lsp == 1)
                                {{ 'Yes' }}
                            @else
                                {{ 'No' }}
                            @endif
                        </p>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Contract Term</label>
                    <div class="col-md-6">
                        <p>{{ $job->contract_term }}</p>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Close Date/Time</label>
                    <div class="col-md-6">
                        @if($job->close_date !== '01/01/1970 07:30')
                            <p>{{ $job->close_date }}</p>
                        @endif
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Announcement Date/Time</label>
                    <div class="col-md-6">
                        @if($job->announcement_date !== '01/01/1970 07:30')
                            <p>{{ $job->announcement_date }}</p>
                        @endif
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Outsource Date/Time</label>
                    <div class="col-md-6">
                        @if($job->outsource_start_date !== '01/01/1970 07:30')
                            <p>{{ $job->outsource_start_date }}</p>
                        @endif
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Status</label>
                    <div class="col-md-6">
                        <p>{{ $job->rfi_status->rfi_status }}</p>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Files</div>
            <div class="panel-body">
                @if(count($job->files) > 0)
                    @foreach($job->files as $file)
                        <div class="col-xs-6 col-sm-2 col-md-2">
                            <div class="thumbnail">
                                <img src="/images/file_icon.png" width="80"/>
                                <div class="caption">
                                    <h5 class="text-center">{{ $file->file_name }}</h5>
                                    <p class="text-center">
                                        <a class="btn btn-xs btn-success" href="{{ $file->link_path }}"><span class="glyphicon glyphicon-download"></span></a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h5>No files.</h5>
                @endif
            </div>
        </div>
    </div>
@endsection