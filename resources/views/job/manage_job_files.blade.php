@extends('app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <h3 class="pull-left">Job ID: {{ $job->id }}</h3>
            <h3 class="pull-right">Documents/Files</h3>
        </div>
        <hr>

        <div class="row">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading_file_panel">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#file_panel" aria-expanded="true" aria-controls="file_panel">
                                Files
                                <span id="file" class="badge" @if(count($job->files) > 0) style="background-color: red;" @endif>{{ count($job->files) }}</span>
                            </a>
                        </h4>
                    </div>
                    <div id="file_panel" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading_file_panel">
                        <div class="panel-body" id="file_body">
                            @if(!empty($job->files))
                                @foreach($job->files as $file)
                                    <div class="col-xs-6 col-sm-2 col-md-2" id="file_panel_{{ $file->id }}">
                                        <div class="thumbnail">
                                            <img src="/images/file_icon.png" width="100"/>
                                            <div class="caption">
                                                <h5 class="text-center">{{ $file->file_name }}</h5>
                                                <p>
                                                    <a class="btn btn-xs btn-success" href="{{ $file->link_path }}"><span class="glyphicon glyphicon-download"></span></a>
                                                    <a class="btn btn-xs btn-danger remove_file" data-company="{{ $job->company_id }}" data-job="{{ $job->id }}" data-file="{{ $file->id }}" data-filetype="file"><span class="glyphicon glyphicon-trash"></span></a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <h5>No files</h5>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Upload Document/File</div>
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

                        <form class="form-horizontal" role="form" method="POST" action="/job/save_job_file/{{ $job->id }}" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group required">
                                <label class="col-md-4 control-label">File Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="file_name" value="{{ old('file_name') }}" required>
                                </div>
                            </div>

                            <div class="form-group required">
                                <label class="col-md-4 control-label">File Type</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="file_type">
                                        <option value="8">File</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group required">
                                <label class="col-md-4 control-label">File</label>
                                <div class="col-md-6">
                                    <input type="file" class="form-control" name="file" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary" style="margin-right: 15px;">
                                        Submit
                                    </button>
                                    <a href="/job/{{ $job->id }}" class="btn btn-default">Back</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $('.remove_file').click(function(){
            if (confirm('Are you sure you want to delete this file?')) {
                var company_id = $(this).data("company");
                var file_id = $(this).data("file");
                var file_type = $(this).data("filetype");
                var file_counter = parseInt($('#'+file_type).text()) - 1;

                var data = {'_method': 'DELETE',  '_token': "{{ csrf_token() }}"};
                $.ajax({
                    type: "DELETE",
                    data: data,
                    url: '/job/delete_job_file/'+file_id+'/'+company_id,
                    success: function(response)
                    {
                        if(response.status){
                            $('#file_panel_'+file_id).remove();
                            $('#'+file_type).text(file_counter);
                            if(file_counter <= 0){
                                $('#'+file_type).css("background-color", "black");
                                $('#'+file_type+'_body').html("<h5>No files.</h5>");
                            }
                        }else{
                            alert('Unknown error, cannot delete this file.');
                        }

                    }
                });
            }
        });
    </script>
@endsection