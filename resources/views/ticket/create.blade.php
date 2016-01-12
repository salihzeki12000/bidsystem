@extends('app')
@section('style')
        <!-- WYSIWYG editor -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="/css/summernote.css" />
<script type="text/javascript" src="/js/summernote.min.js"></script>
@endsection

@section('content')
    <div class="col-sm-12">
        <form class="form-horizontal" role="form" method="POST" action="/ticket" enctype="multipart/form-data" id="ticket_form">
            <div class="panel panel-default">
                <div class="panel-heading">New Ticket</div>
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

                    <div class="form-group required">
                        <label class="col-md-4 control-label">Subject</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="subject" required>
                        </div>
                    </div>

                    <div class="form-group required">
                        <label class="col-md-4 control-label">Category</label>
                        <div class="col-md-6">
                            <select class="form-control" name="category" required>
                                @foreach($categories as $category_key => $category)
                                    <option value="{{ $category_key }}">{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Description</div>
                <div class="panel-body">
                    <input type="hidden" id="description_val" name="description">
                    <div id="description"></div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Files</div>
                <div class="panel-body">
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
        <div class="clearfix"></div>
        <br>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
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

        $('#ticket_form').submit(function(ev) {
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