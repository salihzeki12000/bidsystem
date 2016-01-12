@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <form class="form-horizontal" role="form" method="POST" action="/company" enctype="multipart/form-data" id="company_form">
                <div>
                    <h4>Add New Company</h4>
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

                            <div class="form-group required">
                                <label class="col-md-4 control-label">Company Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="company_name" value="{{ old('company_name') }}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Category</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="category" id="company_category">
                                        <option value="LSP">LSP</option>
                                        <option value="Outsourcing">Outsourcing</option>
                                        <option value="Advertiser">Advertiser</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Date Joined</label>
                                <div class="col-md-6">
                                    <div class='input-group date' id='joined_date'>
                                        <input type='text' class="form-control" name="joined_date"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Date Operation Started</label>
                                <div class="col-md-6">
                                    <div class='input-group date' id='operation_date'>
                                        <input type='text' class="form-control" name="operation_date"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Registration Num</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="registration_num" value="{{ old('registration_num') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Paid Up Capital</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="paid_up_capital" value="{{ old('paid_up_capital') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Logo</label>
                                <div class="col-md-6">
                                    <input type="file" class="form-control" name="logo">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">No of Employees</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="no_of_employees" value="{{ old('no_of_employees') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Annual Turnover</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="annual_turnover" value="{{ old('annual_turnover') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Keyword</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="keyword" value="{{ old('keyword') }}" style="resize: vertical"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Physical File Number</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="physical_file_number" value="{{ old('physical_file_number') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Billing Period (No. of days)</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="billing_period" value="{{ old('billing_period') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Charge GST</label>
                                <div class="col-md-6">
                                    <select name="gst" class="form-control" id="charge_gst">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group" id="gst_percent">
                                <label class="col-md-4 control-label">GST Percent</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="gst_percent" value="{{ old('gst_percent') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Status</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="status">
                                        <option value="Draft">Draft</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group required">
                                <label class="col-md-4 control-label">Account Quota</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="account_quota" value="{{ old('account_quota') }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">Contact</div>
                        <div class="panel-body">
                            <input type="hidden" name="contact_type" value="1" />
                            <div class="form-group">
                                <label class="col-md-4 control-label">Address Line 1</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="address_line_1" value="{{ old('address_line_1') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Address Line 2</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="address_line_2" value="{{ old('address_line_2') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Address Line 3</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="address_line_3" value="{{ old('address_line_3') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Postcode</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="postcode" value="{{ old('postcode') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Town</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="town" value="{{ old('town') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">State</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="state" value="{{ old('state') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Country</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="country" value="{{ old('country') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Telephone Number</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="tel_num" value="{{ old('tel_num') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Fax Number</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="fax_num" value="{{ old('fax_num') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Website</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="website" value="{{ old('website') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">PIC Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="pic_name" value="{{ old('pic_name') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">PIC Department</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="pic_department" value="{{ old('pic_department') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">PIC Designation</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="pic_designation" value="{{ old('pic_designation') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">PIC Mobile Number</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="pic_mobile_num" value="{{ old('pic_mobile_num') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">PIC Email 1</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="pic_email_1" value="{{ old('pic_email_1') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">PIC Email 2</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="pic_email_2" value="{{ old('pic_email_2') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--<div class="panel panel-default" id="logistic_panel">--}}
                        {{--<div class="panel-heading">Logistic</div>--}}
                        {{--<div class="panel-body">--}}
                            {{--<div class="form-group">--}}
                                {{--<div class="col-md-6">--}}
                                    {{--@foreach($logistics as $logistic)--}}
                                        {{--<div class="checkbox">--}}
                                            {{--<label>--}}
                                                {{--<input class="logistic" type="checkbox" name="logistic[]" value="{{ $logistic->id }}"> {{ $logistic->name }}--}}
                                            {{--</label>--}}
                                        {{--</div>--}}
                                    {{--@endforeach--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="panel panel-default" id="service_panel">--}}
                        {{--<div class="panel-heading">Service</div>--}}
                        {{--<div class="panel-body">--}}
                            {{--<div class="form-group">--}}
                                {{--<div class="col-md-6">--}}
                                    {{--@foreach($services as $service)--}}
                                        {{--<div class="checkbox">--}}
                                            {{--<label>--}}
                                                {{--<input class="service" type="checkbox" name="service[]" value="{{ $service->id }}"> {{ $service->name }}--}}
                                            {{--</label>--}}
                                        {{--</div>--}}
                                    {{--@endforeach--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    <div class="panel panel-default">
                        <div class="panel-heading">Industry</div>
                        <div class="panel-body">

                            <div class="form-group">
                                <div class="col-md-6">
                                    @foreach($industries as $industry)
                                        <div class="checkbox">
                                            <label>
                                                <input class="industry" type="checkbox" name="industry[]" value="{{ $industry->id }}"> {{ $industry->industry }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">Requirements</div>
                        <div class="panel-body">
                            <div class="form-group">
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
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">Potentials</div>
                        <div class="panel-body">
                            <div class="form-group">
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
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Achievements
                            <a class="btn btn-xs btn-primary pull-right" id="add_new_achievement">Add New Achievement</a>
                        </div>
                        <div class="panel-body" id="achievement_panel">
                            <div style="border: 1px lightgrey solid;">
                                <br>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Category</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="achievements[1][category]">
                                            <option value="" selected disabled></option>
                                            @foreach($achievements as $achievement)
                                                <option value="{{ $achievement->id }}">{{ $achievement->achievement_type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Descriptions</label>
                                    <div class="col-md-6">
                                        <textarea class="form-control" style="resize: vertical;" name="achievements[1][descriptions]"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Features
                            <a class="btn btn-xs btn-primary pull-right" id="add_new_feature">Add New Feature</a>
                        </div>
                        <div class="panel-body" id="feature_panel">
                            <div style="border: 1px lightgrey solid;">
                                <br>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Feature</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="feature[1][name]" value="{{ old('feature') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Details</label>
                                    <div class="col-md-6">
                                        <textarea class="form-control" style="resize: vertical;" name="feature[1][detail]"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Remarks
                            <a class="btn btn-xs btn-primary pull-right" id="add_new_remark">Add New Remark</a>
                        </div>
                        <div class="panel-body" id="remark_panel">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Remarks</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="remarks[]">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" style="margin-right: 15px;">
                            Submit
                        </button>
                        <a href="/company" class="btn btn-default">Back</a>
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
        var count_feature_panel = 1;
        $('#add_new_feature').click(function(){
            count_feature_panel++;
            var new_feature_panel = '<div id="feature_'+count_feature_panel+'" style="border: 1px lightgrey solid; margin-top: 2%;"><br><div class="form-group"><label class="col-md-4 control-label">Feature</label><div class="col-md-6"> <input type="text" class="form-control" name="feature['+count_feature_panel+'][name]"></div></div><div class="form-group"><label class="col-md-4 control-label">Details</label><div class="col-md-6"><textarea class="form-control" style="resize: vertical;" name="feature['+count_feature_panel+'][detail]"></textarea></div><a class="btn btn-xs btn-danger remove_btn" data-feature="feature_'+count_feature_panel+'"><span class="glyphicon glyphicon-remove"></span></a></div></div>';
            $('#feature_panel').append(new_feature_panel);
        });

        var count_remark_panel = 1;
        $('#add_new_remark').click(function(){
            count_remark_panel++;
            var new_remark_panel = '<div class="form-group" id="remark_'+count_remark_panel+'"><label class="col-md-4 control-label">Remarks</label><div class="col-md-6"><input type="text" class="form-control" name="remarks[]"></div><a class="btn btn-xs btn-danger remove_btn" data-feature="remark_'+count_remark_panel+'"><span class="glyphicon glyphicon-remove"></span></a></div>';
            $('#remark_panel').append(new_remark_panel);
        });

        var count_achievement_panel = 1;
        $('#add_new_achievement').click(function(){
            count_achievement_panel++;
            var new_achievement_panel = '<div id="achievement_'+count_achievement_panel+'" style="border: 1px lightgrey solid;"><br><div class="form-group"><label class="col-md-4 control-label">Category</label><div class="col-md-6"><select class="form-control" name="achievements['+count_achievement_panel+'][category]"><option value="" selected disabled></option>@foreach($achievements as $achievement)<option value="{{ $achievement->id }}">{{ $achievement->achievement_type }}</option>@endforeach</select></div></div><div class="form-group"><label class="col-md-4 control-label">Descriptions</label><div class="col-md-6"><textarea class="form-control" style="resize: vertical;" name="achievements['+count_achievement_panel+'][descriptions]"></textarea></div><a class="btn btn-xs btn-danger remove_btn" data-feature="achievement_'+count_achievement_panel+'"><span class="glyphicon glyphicon-remove"></span></a></div></div>';
            $('#achievement_panel').append(new_achievement_panel);
        });

        $('body').on('click', 'a.remove_btn', function() {
            var id = $(this).data("feature");
            $('#'+id).remove();
        });

        $('#joined_date').datetimepicker({
            format: 'DD-MM-YYYY'
        });

        $('#operation_date').datetimepicker({
            format: 'DD-MM-YYYY'
        });

        $('#credit_expiry_date').datetimepicker({
            format: 'DD-MM-YYYY HH:mm'
        });

        $('#charge_gst').change(function(){
            if(this.value == 0){
                $('#gst_percent').hide();
            }else{
                $('#gst_percent').show();
            }
        });

        $('#company_category').change(function(){
            if(this.value == 'LSP'){
                $('#logistic_panel').show();
                $('#service_panel').show();
            }else{
                $('#logistic_panel').hide();
                $('#service_panel').hide();
            }
        });

        $('#company_form').submit(function(ev) {
            ev.preventDefault();

            var company_category = $('#company_category').val();
            var industry_checked = $(".industry:checkbox:checked").length;
            var requirement_checked = $(".requirement:checkbox:checked").length;
            var potential_checked = $(".potential:checkbox:checked").length;

            if(!industry_checked) {
                alert("You must check at least one industry.");
                return false;
            }else if(!requirement_checked){
                alert("You must check at least one requirement.");
                return false;
            }else if(!potential_checked){
                alert("You must check at least one potential.");
                return false;
            }else{
                this.submit();
            }
        });
    </script>
@endsection