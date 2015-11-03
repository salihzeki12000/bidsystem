@extends('app')
@section('style')
        <!-- WYSIWYG editor -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="/css/summernote.css" />
<script type="text/javascript" src="/js/summernote.min.js"></script>
@endsection

@section('content')
    <div class="row">
        <form id="bid_form" class="form-horizontal" role="form" method="POST" action="/bid/{{ $bid->id }}" enctype="multipart/form-data">
            <div class="col-md-8 col-md-offset-2">
                <h4>Edit Bid</h4>
                <br>
                <div class="panel panel-default">
                    <div class="panel-heading">Profile</div>
                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="company_id" value="{{ Auth::user()->company_id }}">
                        @if(\Auth::user()->type == 'super_admin' || \Auth::user()->type == 'globe_admin')
                            <div class="form-group">
                                <label class="col-md-4 control-label">Company</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="admin_company">
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}" @if($bid->company_id == $company->id) selected @endif>{{ $company->company_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif

                        <div class="form-group">
                            <label class="col-md-4 control-label">Job</label>
                            <div class="col-md-6">
                                <select class="form-control" name="job">
                                    @foreach($jobs as $job)
                                        <option value="{{ $job }}" @if($bid->job_id == $job) selected @endif>{{ $job }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Date</label>
                            <div class="col-md-6">
                                <div class='input-group date' id='date'>
                                    <input type='text' class="form-control" name="date" value="{{ $bid->date }}"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Est. Budget</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="est_budget" value="{{ $bid->est_budget }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Reply To Special Request</label>
                            <div class="col-md-6">
                                <textarea style="resize: vertical;" class="form-control" name="reply_special_request">{{ $bid->reply_to_special_request }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Sales PIC</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="sales_pic" value="{{ $bid->sales_pic }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">RFP Submission Date/Time</label>
                            <div class="col-md-6">
                                <div class='input-group date' id='rfp_submission_date'>
                                    <input type='text' class="form-control" name="rfp_submission_date" value="{{ $bid->rfp_submission_date }}"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">RFQ Submission Date/Time</label>
                            <div class="col-md-6">
                                <div class='input-group date' id='rfq_submission_date'>
                                    <input type='text' class="form-control" name="rfq_submission_date" value="{{ $bid->rfq_submission_date }}"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">First Meeting Target Date/Time</label>
                            <div class="col-md-6">
                                <div class='input-group date' id='first_meeting_target_date'>
                                    <input type='text' class="form-control" name="first_meeting_target_date" value="{{ $bid->first_meeting_target_date }}"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Closure Target Date/Time</label>
                            <div class="col-md-6">
                                <div class='input-group date' id='closure_target_date'>
                                    <input type='text' class="form-control" name="closure_target_date" value="{{ $bid->closure_target_date }}"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{--<div class="form-group">--}}
                        {{--<label class="col-md-4 control-label">Keyword</label>--}}
                        {{--<div class="col-md-6">--}}
                        {{--<textarea style="resize: vertical;" class="form-control" name="keyword">{{ old('keyword') }}</textarea>--}}
                        {{--</div>--}}
                        {{--</div>--}}

                        <div class="form-group">
                            <label class="col-md-4 control-label">Status</label>
                            <div class="col-md-6">
                                <select class="form-control" name="status">
                                    @foreach($status as $state)
                                        <option value="{{ $state->id }}" @if($state->id == $bid->status_id) selected @endif>{{ $state->rfi_status }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Description</div>
                    <div class="panel-body">
                        <div id="description"></div>
                    </div>
                </div>
                <input type="hidden" id="description_input" name="description" />
                <div class="text-center">
                    <button type="submit" class="btn btn-primary" style="margin-right: 15px;">
                        Submit
                    </button>
                    <a href="/bid" class="btn btn-default">Back</a>
                </div>
                <div class="clearfix"></div>
                <br>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(function () {
            $('#date').datetimepicker({
                format: 'DD-MM-YYYY'
            });
            $('#rfp_submission_date').datetimepicker({
                format: 'DD-MM-YYYY HH:mm'
            });
            $('#rfq_submission_date').datetimepicker({
                format: 'DD-MM-YYYY HH:mm'
            });
            $('#first_meeting_target_date').datetimepicker({
                format: 'DD-MM-YYYY HH:mm'
            });
            $('#closure_target_date').datetimepicker({
                format: 'DD-MM-YYYY HH:mm'
            });

            $('#description').summernote({
                height: 400,
                minHeight: 300,
                toolbar: [
                    ["style",["style"]],
                    ["font",["bold","italic","underline","clear", 'strikethrough', 'superscript', 'subscript']],
                    ["para",["ul","ol","paragraph", "height"]],
                    ["table",["table"]],
                    ["insert",["link","hr"]],
                    ["tools",["undo","redo"]],
                    ["view",["fullscreen","codeview"]],
                    ["fontname",["fontname"]],
                    ["fontsize",["fontsize"]],
                    ["color",["color"]],
                    ["help",["help"]]
                ]
            });

            $('#description').code('{!! $bid->additional_description !!}');

            $('#bid_form').submit(function(ev) {
                ev.preventDefault();

                var description_content = $('#description').code();
                $('#description_input').val(description_content);

                this.submit();
            });
        });
    </script>
@endsection