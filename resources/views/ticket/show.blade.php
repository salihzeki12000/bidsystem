@extends('app')
@section('style')
        <!-- WYSIWYG editor -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="/css/summernote.css" />
<script type="text/javascript" src="/js/summernote.min.js"></script>
<style>
    .row {
        display: flex;
    }

    .col {
        flex: 1;

        padding: 1em;
        border: solid;
    }
</style>
@endsection

@section('content')
    <div class="col-md-10 col-md-offset-1">
        <div class="row">
            <div class="col-sm-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <img src="{{ $ticket->company->logo or null }}">
                        <h5>
                            <a @if($ticket->company_id) href="/company/{{ $ticket->company->id }}" target="_blank" @endif>{{ $ticket->company->company_name or 'Admin' }}</a>
                        </h5>
                    </div>
                </div>
            </div>
            <div class="col-sm-10">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Subject:
                        <h4>
                            {{ $ticket->issue_subject }}
                            <small class="pull-right">{{ $ticket->category->name }}</small>
                        </h4>
                    </div>
                    <div class="panel-body">
                        {!! $ticket->issue_description !!}
                        <div class="clearfix"></div>
                        <hr>
                        @if(count($ticket->files) > 0)
                            @foreach($ticket->files as $file)
                                <a href="{{ $file->file_path }}" target="_blank"><img src="{{ $file->file_path }}" class="img-thumbnail" width="100px"></a>
                            @endforeach
                        @endif
                    </div>
                    <div class="panel-footer">
                        <p class="text-right">Post time: <b>{{ $ticket->updated_at }}</b></p>
                    </div>
                </div>
            </div>
        </div>
        @if(!empty($ticket->responses))
            @foreach($ticket->responses as $response)
                <div class="row">
                    <div class="col-sm-2">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h5>
                                    <img src="{{ $response->creator->company->logo or null }}">
                                    <h5>
                                        <a @if($response->creator->company_id) href="/company/{{ $response->creator->company_id }}" target="_blank" @endif>{{ $response->creator->company->company_name or 'Admin' }}</a>
                                    </h5>
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-10">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                {!! $response->reply_description !!}
                                <div class="clearfix"></div>
                                <hr>
                                @if(count($response->files) > 0)
                                    @foreach($response->files as $file)
                                        <a href="{{ $file->file_path }}" target="_blank"><img src="{{ $file->file_path }}" class="img-thumbnail" width="100px"></a>
                                    @endforeach
                                @endif
                            </div>
                            <div class="panel-footer">
                                <p class="text-right">Post time: <b>{{ $response->updated_at }}</b></p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

        <div class="clearfix"></div>
        <hr>

        <div class="col-sm-12">
            <form class="form-horizontal" role="form" method="POST" action="/ticket/save_response" enctype="multipart/form-data" id="ticket_response_form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                <div class="panel panel-default">
                    <div class="panel-heading">Response</div>
                    <div class="panel-body">
                        <input type="hidden" id="description_val" name="description">
                        <div id="description"></div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Attachments (Image only)</label>
                            <div class="col-md-6" id="attachment_div">
                                <div class="input-group" id="file_div_1">
                                    <input type="file" name="files[]" class="form-control">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-plus add_file"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $('#description').summernote({
            height: 100,
            minHeight: 100,
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

        $('#ticket_response_form').submit(function(ev) {
            ev.preventDefault();

            var description_content = $('#description').code();
            $('#description_val').val(description_content);

            this.submit();
        });

        var file_panel_count = 1;

        $('body').on('click', '.add_file', function(){
            file_panel_count++;
            var file_panel = '<div class="input-group" id="file_div_'+file_panel_count+'"><input type="file" name="files[]" class="form-control"><div class="input-group-addon"><span class="glyphicon glyphicon-plus add_file"></span></div><div class="input-group-addon"><span class="glyphicon glyphicon-minus remove_file" data-index="'+file_panel_count+'"></span></div></div>';
            $('#attachment_div').append(file_panel);
        });

        $('body').on('click', '.remove_file', function(){
            var file_panel_index = $(this).data("index");
            $('#file_div_'+file_panel_index).remove();
        });
    </script>
@endsection