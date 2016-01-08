@extends('content_with_sidebar')
@section('style')
        <!-- WYSIWYG editor -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="/css/summernote.css" />
<script type="text/javascript" src="/js/summernote.min.js"></script>
@endsection

@section('sidebar')
    @can('inward-user-only')
    <ul class="nav nav-sidebar">
        <h4 class="text-center">{{ $company->company_name }}</h4>
    </ul>
    @endcan
    <ul class="nav nav-sidebar">
        @can('inward-user-only')
        <li><a href="/company/job_history/{{ $company->id }}">Job History</a></li>
        <li><a href="/job_progress_tracking/{{ $company->id }}">Job Progress Tracking</a></li>
        @endcan
        <li class="active"><a href="/job/create">Create Job<span class="sr-only">(current)</span></a></li>
    </ul>
@endsection

@section('content')
        <form id="job_form" class="form-horizontal" role="form" method="POST" action="/job" enctype="multipart/form-data">
            <div class="row">
                <h4>Submit New Job</h4>
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
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="company_id" value="{{ Auth::user()->company_id }}">
                            @if(\Auth::user()->type == 'super_admin' || \Auth::user()->type == 'globe_admin')
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Company</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="admin_company">
                                            @foreach($companies as $company)
                                                <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group">
                                <label class="col-md-4 control-label">Date</label>
                                <div class="col-md-6">
                                    <div class='input-group date' id='date'>
                                        <input type='text' class="form-control" name="date"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Location</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="location">
                                        @foreach($locations as $location)
                                            <option value="{{ $location->id }}">{{ $location->town.'/'.$location->state.'/'.$location->country.' ('.$location->postcode.')' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group required">
                                <label class="col-md-4 control-label">Requirement</label>
                                <div class="col-md-6">
                                    @foreach($requirements as $requirement)
                                        <div class="checkbox">
                                            <label>
                                                <input class="requirement" type="checkbox" name="requirement[]" value="{{ $requirement->id }}"> {{ $requirement->requirement }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group required">
                                <label class="col-md-4 control-label">Potential</label>
                                <div class="col-md-6">
                                    @foreach($potentials as $potential)
                                        <div class="checkbox">
                                            <label>
                                                <input class="potential" type="checkbox" name="potential[]" value="{{ $potential->id }}"> {{ $potential->potential }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group required">
                                <label class="col-md-4 control-label">Highlight</label>
                                <div class="col-md-6">
                                    @foreach($highlights as $highlight)
                                        <div class="checkbox">
                                            <label>
                                                <input class="highlight" type="checkbox" name="highlight[]" value="{{ $highlight->id }}"> {{ $highlight->highlight }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Special Request</label>
                                <div class="col-md-6">
                                    <textarea style="resize: vertical;" class="form-control" name="special_request">{{ old('special_request') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Existing Budget</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="existing_budget" value="{{ old('existing_budget') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Existing LSP</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="existing_lsp">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Contract Term</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="contract_term" value="{{ old('contract_term') }}">
                                </div>
                            </div>

                            <div class="form-group required">
                                <label class="col-md-4 control-label">Close Date/Time</label>
                                <div class="col-md-6">
                                    <div class='input-group date' id='close_date'>
                                        <input type='text' class="form-control" name="close_date" required/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Announcement Date/Time</label>
                                <div class="col-md-6">
                                    <div class='input-group date' id='announcement_date'>
                                        <input type='text' class="form-control" name="announcement_date"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Outsource Date/Time</label>
                                <div class="col-md-6">
                                    <div class='input-group date' id='outsource_date'>
                                        <input type='text' class="form-control" name="outsource_date"/>
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
                    <input type="submit" class="btn btn-primary" name="button" value="Save as draft" />
                    <input type="submit" class="btn btn-success" name="button" value="Submit job" />
                </div>
                <div class="clearfix"></div>
                <br>
            </div>
        </form>
@endsection
@section('script')
    <script type="text/javascript">
        $(function () {
            $('#date').datetimepicker({
                format: 'DD-MM-YYYY'
            });
            $('#close_date').datetimepicker({
                format: 'DD-MM-YYYY HH:mm'
            });
            $('#announcement_date').datetimepicker({
                format: 'DD-MM-YYYY HH:mm'
            });
            $('#outsource_date').datetimepicker({
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

            $('#job_form').submit(function(ev) {
                ev.preventDefault();

                var description_content = $('#description').code();
                $('#description_input').val(description_content);

                var requirement_checked = $(".requirement:checkbox:checked").length;
                var potential_checked = $(".potential:checkbox:checked").length;
                var highlight_checked = $(".highlight:checkbox:checked").length;

                if(!requirement_checked) {
                    alert("You must check at least one requirement.");
                    return false;
                }else if(!potential_checked) {
                    alert("You must check at least one potential.");
                    return false;
                }else if(!highlight_checked){
                    alert("You must check at least one highlight.");
                    return false;
                }else {
                    this.submit();
                }
            });
        });
    </script>
@endsection