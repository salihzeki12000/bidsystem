@extends('app')

@section('content')
    <div class="col-sm-12">
        <div>
            <div class="row">
                <h4 class="pull-left">Bid ID: {{ $bid->id }}</h4>
                <a class="btn btn-primary pull-right" onclick="window.history.back();">Back</a>
            </div>
            <br>
            @can('super-admin-only')
            <div class="panel panel-default">
                <div class="panel-heading">Action</div>
                <div class="panel-body">
                    <form class="form-inline" method="post" action="/bid/update_bid_status" id="bid_form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="bid_id" value="{{ $bid->id }}">
                        <label class="col-md-4 control-label">Action</label>
                        <div class="col-md-8">
                            <select class="form-control" name="action" id="action">
                                @if(!in_array($bid->status_id, array_keys($rfi_status->toArray())))
                                    <option value="" selected>Select action</option>
                                @endif
                                @foreach($rfi_status as $status_key => $status)
                                    <option value="{{ $status_key }}" @if($bid->status_id == $status_key) selected @endif>{{ $status }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-sm btn-primary" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
            @else
                @can('inward-user-only')
                <div class="panel panel-default">
                    <div class="panel-heading">Action</div>
                    <div class="panel-body">
                        <form class="form-inline" method="post" action="/bid/update_bid_status" id="bid_form">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="bid_id" value="{{ $bid->id }}">
                            <label class="col-md-4 control-label">Action</label>
                            <div class="col-md-8">
                                <select class="form-control" name="action" id="action">
                                    @if(!in_array($bid->status_id, array_keys($rfi_status->toArray())))
                                        <option value="" selected>Select action</option>
                                    @endif
                                    @foreach($rfi_status as $status_key => $status)
                                        <option value="{{ $status_key }}" @if($bid->status_id == $status_key) selected @endif>{{ $status }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-sm btn-primary" type="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                @endcan
            @endcan

            <div class="panel panel-default">
                <div class="panel-heading">Bid Description</div>
                <div class="panel-body">
                    {!! $bid->additional_description !!}
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Reply To Special Request</div>
                <div class="panel-body">
                    <p>{{ $bid->reply_to_special_request }}</p>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Profile</div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-4 control-label">Company Name</label>
                        <div class="col-md-6">
                            <p><a href="/company/{{ $bid->company_id }}" target="_blank">{{ $bid->company->company_name }}</a></p>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Date</label>
                        <div class="col-md-6">
                            <p>{{ $bid->date }}</p>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Est. Budget</label>
                        <div class="col-md-6">
                            <p>{{ $bid->est_budget }}</p>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Sales PIC</label>
                        <div class="col-md-6">
                            <p>{{ $bid->sales_pic }}</p>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">RFP Submission Date/Time</label>
                        <div class="col-md-6">
                            @if($bid->rfp_submission_date !== '01/01/1970 07:30')
                                <p>{{ $bid->rfp_submission_date }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">RFQ Submission Date/Time</label>
                        <div class="col-md-6">
                            @if($bid->rfq_submission_date !== '01/01/1970 07:30')
                                <p>{{ $bid->rfq_submission_date }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">First Meeting Target Date/Time</label>
                        <div class="col-md-6">
                            @if($bid->first_meeting_target_date !== '01/01/1970 07:30')
                                <p>{{ $bid->first_meeting_target_date }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Closure Target Date/Time</label>
                        <div class="col-md-6">
                            @if($bid->closure_target_date !== '01/01/1970 07:30')
                                <p>{{ $bid->closure_target_date }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Status</label>
                        <div class="col-md-6">
                            <p>{{ $bid->rfi_status->rfi_status }}</p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Files</div>
                <div class="panel-body">
                    @if(count($bid->files) > 0)
                        @foreach($bid->files as $file)
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

            <div class="clearfix"></div>
            <br>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(function () {
            $('#bid_form').submit(function(ev) {
                ev.preventDefault();

                var action = $('#action').val();
                if(action != ''){
                    this.submit();
                }else{
                    alert("Please select valid action.");
                }
            });
        });
    </script>
@endsection