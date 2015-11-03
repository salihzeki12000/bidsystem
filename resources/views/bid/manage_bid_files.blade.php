@extends('app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <h3 class="pull-left">Documents/Files</h3>
            <h3 class="pull-right">Bid ID: {{ $bid->id }}</h3>
        </div>
        <hr>

        <div class="row">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading_invoice_panel">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#invoice_panel" aria-expanded="true" aria-controls="invoice_panel">
                                Invoice
                                <span id="invoice" class="badge" @if(count($invoice_files) > 0) style="background-color: red;" @endif>{{ count($invoice_files) }}</span>
                            </a>
                        </h4>
                    </div>
                    <div id="invoice_panel" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading_invoice_panel">
                        <div class="panel-body" id="invoice_body">
                            @if(!empty($invoice_files))
                                @foreach($invoice_files as $file)
                                    <div class="col-xs-6 col-sm-2 col-md-2" id="file_panel_{{ $file->id }}">
                                        <div class="thumbnail">
                                            <img src="/images/file_icon.png" width="100"/>
                                            <div class="caption">
                                                <h5 class="text-center">{{ $file->file_name }}</h5>
                                                <p>
                                                    <a class="btn btn-xs btn-success" href="{{ $file->link_path }}"><span class="glyphicon glyphicon-download"></span></a>
                                                    <a class="btn btn-xs btn-danger remove_file" data-company="{{ $bid->company_id }}" data-job="{{ $bid->id }}" data-file="{{ $file->id }}" data-filetype="invoice"><span class="glyphicon glyphicon-trash"></span></a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <h5>No files for this category.</h5>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading_dn_panel">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#dn_panel" aria-expanded="false" aria-controls="dn_panel">
                                DN
                                <span id="dn" class="badge" @if(count($dn_files) > 0) style="background-color: red;" @endif>{{ count($dn_files) }}</span>
                            </a>
                        </h4>
                    </div>
                    <div id="dn_panel" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_dn_panel">
                        <div class="panel-body" id="dn_body">
                            @if(!empty($dn_files))
                                @foreach($dn_files as $file)
                                    <div class="col-xs-6 col-sm-2 col-md-2" id="file_panel_{{ $file->id }}">
                                        <div class="thumbnail">
                                            <img src="/images/file_icon.png" width="100"/>
                                            <div class="caption">
                                                <h5 class="text-center">{{ $file->file_name }}</h5>
                                                <p>
                                                    <a class="btn btn-xs btn-success" href="{{ $file->link_path }}"><span class="glyphicon glyphicon-download"></span></a>
                                                    <a class="btn btn-xs btn-danger remove_file" data-company="{{ $bid->company_id }}" data-job="{{ $bid->id }}" data-file="{{ $file->id }}" data-filetype="dn"><span class="glyphicon glyphicon-trash"></span></a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <h5>No files for this category.</h5>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading_cn_panel">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#cn_panel" aria-expanded="false" aria-controls="cn_panel">
                                CN
                                <span id="cn" class="badge" @if(count($cn_files) > 0) style="background-color: red;" @endif>{{ count($cn_files) }}</span>
                            </a>
                        </h4>
                    </div>
                    <div id="cn_panel" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_cn_panel">
                        <div class="panel-body" id="cn_body">
                            @if(!empty($cn_files))
                                @foreach($cn_files as $file)
                                    <div class="col-xs-6 col-sm-2 col-md-2" id="file_panel_{{ $file->id }}">
                                        <div class="thumbnail">
                                            <img src="/images/file_icon.png" width="100"/>
                                            <div class="caption">
                                                <h5 class="text-center">{{ $file->file_name }}</h5>
                                                <p>
                                                    <a class="btn btn-xs btn-success" href="{{ $file->link_path }}"><span class="glyphicon glyphicon-download"></span></a>
                                                    <a class="btn btn-xs btn-danger remove_file" data-company="{{ $bid->company_id }}" data-job="{{ $bid->id }}" data-file="{{ $file->id }}" data-filetype="cn"><span class="glyphicon glyphicon-trash"></span></a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <h5>No files for this category.</h5>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading_logo_panel">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#logo_panel" aria-expanded="false" aria-controls="logo_panel">
                                Logo
                                <span id="logo" class="badge" @if(count($logo_files) > 0) style="background-color: red;" @endif>{{ count($logo_files) }}</span>
                            </a>
                        </h4>
                    </div>
                    <div id="logo_panel" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_logo_panel">
                        <div class="panel-body" id="logo_body">
                            @if(!empty($logo_files))
                                @foreach($logo_files as $file)
                                    <div class="col-xs-6 col-sm-2 col-md-2" id="file_panel_{{ $file->id }}">
                                        <div class="thumbnail">
                                            <img src="/images/file_icon.png" width="100"/>
                                            <div class="caption">
                                                <h5 class="text-center">{{ $file->file_name }}</h5>
                                                <p>
                                                    <a class="btn btn-xs btn-success" href="{{ $file->link_path }}"><span class="glyphicon glyphicon-download"></span></a>
                                                    <a class="btn btn-xs btn-danger remove_file" data-company="{{ $bid->company_id }}" data-job="{{ $bid->id }}" data-file="{{ $file->id }}" data-filetype="logo"><span class="glyphicon glyphicon-trash"></span></a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <h5>No files for this category.</h5>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading_profile_panel">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#profile_panel" aria-expanded="false" aria-controls="profile_panel">
                                Profile
                                <span id="profile" class="badge" @if(count($profile_files) > 0) style="background-color: red;" @endif>{{ count($profile_files) }}</span>
                            </a>
                        </h4>
                    </div>
                    <div id="profile_panel" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_profile_panel">
                        <div class="panel-body" id="profile_body">
                            @if(!empty($profile_files))
                                @foreach($profile_files as $file)
                                    <div class="col-xs-6 col-sm-2 col-md-2" id="file_panel_{{ $file->id }}">
                                        <div class="thumbnail">
                                            <img src="/images/file_icon.png" width="100"/>
                                            <div class="caption">
                                                <h5 class="text-center">{{ $file->file_name }}</h5>
                                                <p>
                                                    <a class="btn btn-xs btn-success" href="{{ $file->link_path }}"><span class="glyphicon glyphicon-download"></span></a>
                                                    <a class="btn btn-xs btn-danger remove_file" data-company="{{ $bid->company_id }}" data-job="{{ $bid->id }}" data-file="{{ $file->id }}" data-filetype="profile"><span class="glyphicon glyphicon-trash"></span></a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <h5>No files for this category.</h5>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading_support_panel">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#support_panel" aria-expanded="false" aria-controls="support_panel">
                                Support
                                <span id="support" class="badge" @if(count($support_files) > 0) style="background-color: red;" @endif>{{ count($support_files) }}</span>
                            </a>
                        </h4>
                    </div>
                    <div id="support_panel" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_support_panel">
                        <div class="panel-body" id="support_body">
                            @if(!empty($support_files))
                                @foreach($support_files as $file)
                                    <div class="col-xs-6 col-sm-2 col-md-2" id="file_panel_{{ $file->id }}">
                                        <div class="thumbnail">
                                            <img src="/images/file_icon.png" width="100"/>
                                            <div class="caption">
                                                <h5 class="text-center">{{ $file->file_name }}</h5>
                                                <p>
                                                    <a class="btn btn-xs btn-success" href="{{ $file->link_path }}"><span class="glyphicon glyphicon-download"></span></a>
                                                    <a class="btn btn-xs btn-danger remove_file" data-company="{{ $bid->company_id }}" data-job="{{ $bid->id }}" data-file="{{ $file->id }}" data-filetype="support"><span class="glyphicon glyphicon-trash"></span></a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <h5>No files for this category.</h5>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading_registration_panel">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#registration_panel" aria-expanded="false" aria-controls="registration_panel">
                                Registration
                                <span id="registration" class="badge" @if(count($registration_files) > 0) style="background-color: red;" @endif>{{ count($registration_files) }}</span>
                            </a>
                        </h4>
                    </div>
                    <div id="registration_panel" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_registration_panel">
                        <div class="panel-body" id="registration_body">
                            @if(!empty($registration_files))
                                @foreach($registration_files as $file)
                                    <div class="col-xs-6 col-sm-2 col-md-2" id="file_panel_{{ $file->id }}">
                                        <div class="thumbnail">
                                            <img src="/images/file_icon.png" width="100"/>
                                            <div class="caption">
                                                <h5 class="text-center">{{ $file->file_name }}</h5>
                                                <p>
                                                    <a class="btn btn-xs btn-success" href="{{ $file->link_path }}"><span class="glyphicon glyphicon-download"></span></a>
                                                    <a class="btn btn-xs btn-danger remove_file" data-company="{{ $bid->company_id }}" data-job="{{ $bid->id }}" data-file="{{ $file->id }}" data-filetype="registration"><span class="glyphicon glyphicon-trash"></span></a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <h5>No files for this category.</h5>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading_others_panel">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#others_panel" aria-expanded="false" aria-controls="others_panel">
                                Others
                                <span id="others" class="badge" @if(count($others_files) > 0) style="background-color: red;" @endif>{{ count($others_files) }}</span>
                            </a>
                        </h4>
                    </div>
                    <div id="others_panel" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_others_panel">
                        <div class="panel-body" id="others_body">
                            @if(!empty($others_files))
                                @foreach($others_files as $file)
                                    <div class="col-xs-6 col-sm-2 col-md-2" id="file_panel_{{ $file->id }}">
                                        <div class="thumbnail">
                                            <img src="/images/file_icon.png" width="100"/>
                                            <div class="caption">
                                                <h5 class="text-center">{{ $file->file_name }}</h5>
                                                <p>
                                                    <a class="btn btn-xs btn-success" href="{{ $file->link_path }}"><span class="glyphicon glyphicon-download"></span></a>
                                                    <a class="btn btn-xs btn-danger remove_file" data-company="{{ $bid->company_id }}" data-job="{{ $bid->id }}" data-file="{{ $file->id }}" data-filetype="others"><span class="glyphicon glyphicon-trash"></span></a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <h5>No files for this category.</h5>
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

                        <form class="form-horizontal" role="form" method="POST" action="/bid/save_bid_file/{{ $bid->id }}" enctype="multipart/form-data">
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
                                        @foreach($file_types as $file_type)
                                            <option value="{{ $file_type->id }}">{{ $file_type->file_type }}</option>
                                        @endforeach
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
                                    <a href="/bid" class="btn btn-default">Back</a>
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
                    url: '/bid/delete_bid_file/'+file_id+'/'+company_id,
                    success: function(response)
                    {
                        if(response.status){
                            $('#file_panel_'+file_id).remove();
                            $('#'+file_type).text(file_counter);
                            if(file_counter <= 0){
                                $('#'+file_type).css("background-color", "black");
                                $('#'+file_type+'_body').html("<h5>No files for this category.</h5>");
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