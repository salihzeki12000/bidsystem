@extends('app')
@section('style')
        <!-- WYSIWYG editor -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="/css/summernote.css" />
<script type="text/javascript" src="/js/summernote.min.js"></script>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <form class="form-horizontal" role="form" method="POST" action="/job/{{ $job->id }}" enctype="multipart/form-data" id="job_form">
                <div class="col-md-8 col-md-offset-2">
                    <h4>Edit Job</h4>
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
                            <div class="form-group">
                                <label class="col-md-4 control-label">Date</label>
                                <div class="col-md-6">
                                    <div class='input-group date' id='date'>
                                        <input type='text' class="form-control" name="date" value="{{ $job->date }}"/>
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
                                            <option value="{{ $location->id }}" @if($job->location_id == $location->id) selected @endif>{{ $location->town.'/'.$location->state.'/'.$location->country.' ('.$location->postcode.')' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group required">
                                <label class="col-md-4 control-label">Requirement</label>
                                <div class="col-md-6">
                                    @foreach($requirements as $requirement_key => $requirement)
                                        <div class="checkbox">
                                            <label>
                                                <input class="requirement" type="checkbox" name="requirement[]" value="{{ $requirement_key }}" @if(in_array($requirement_key, $selected_requirements)) checked @endif> {{ $requirement }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group required">
                                <label class="col-md-4 control-label">Potential</label>
                                <div class="col-md-6">
                                    @foreach($potentials as $potential_key => $potential)
                                        <div class="checkbox">
                                            <label>
                                                <input class="potential" type="checkbox" name="potential[]" value="{{ $potential_key }}" @if(in_array($potential_key, $selected_potentials)) checked @endif> {{ $potential }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group required">
                                <label class="col-md-4 control-label">Highlight</label>
                                <div class="col-md-6">
                                    @foreach($highlights as $highlight_key => $highlight)
                                        <div class="checkbox">
                                            <label>
                                                <input class="highlight" type="checkbox" name="highlight[]" value="{{ $highlight_key }}" @if(in_array($highlight_key, $selected_highlights)) checked @endif> {{ $highlight }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Special Request</label>
                                <div class="col-md-6">
                                    <textarea style="resize: vertical;" class="form-control" name="special_request">{{ $job->special_request }}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Existing Budget</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="existing_budget" value="{{ $job->existing_budget }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Existing LSP</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="existing_lsp">
                                        <option value="1" @if($job->existing_lsp == 1) selected @endif>Yes</option>
                                        <option value="0" @if($job->existing_lsp == 0) selected @endif>No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Contract Term</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="contract_term" value="{{ $job->contract_term }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Close Date/Time</label>
                                <div class="col-md-6">
                                    <div class='input-group date' id='close_date'>
                                        <input type='text' class="form-control" name="close_date" value="{{ $job->close_date }}"/>
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
                                        <input type='text' class="form-control" name="announcement_date" value="{{ $job->announcement_date }}"/>
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
                                        <input type='text' class="form-control" name="outsource_date" value="{{ $job->outsource_start_date }}"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{--<div class="form-group">--}}
                                {{--<label class="col-md-4 control-label">Keyword</label>--}}
                                {{--<div class="col-md-6">--}}
                                    {{--<textarea style="resize: vertical;" class="form-control" name="keyword">{{ $job->keyword }}</textarea>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            <div class="form-group">
                                <label class="col-md-4 control-label">Status</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="status">
                                        @foreach($rfi_status as $state)
                                            <option value="{{ $state->id }}" @if($state->id == $job->status_id) selected @endif>{{ $state->rfi_status }}</option>
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
                        <a href="/job" class="btn btn-default">Back</a>
                    </div>
                    <div class="clearfix"></div>
                    <br>
                </div>
            </form>
        </div>
    </div>
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
                    ["font",["bold","italic","underline","clear", 'strikethrough', 'superscript', 'subscript',]],
                    ["para",["ul","ol","paragraph", "height"]],
                    ["height",["height"]],
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

            $('#description').code('{!! $job->additional_description !!}');

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