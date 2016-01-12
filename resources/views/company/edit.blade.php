@extends('app')

@section('content')
    <div class="col-sm-12">
        <form class="form-horizontal" role="form" method="POST" action="/company/{{ $company->id }}" enctype="multipart/form-data" id="company_form">
        <div>
            <div class="panel panel-default">
                <div class="panel-heading">Update Company Profile</div>
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

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Company Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="company_name" value="{{ $company->company_name }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Category</label>
                            <div class="col-md-6">
                                <select class="form-control" name="category" id="company_category">
                                    <option value="LSP" @if($company->category == "LSP") selected @endif>LSP</option>
                                    <option value="Outsourcing" @if($company->category == "Outsourcing") selected @endif>Outsourcing</option>
                                    <option value="Advertiser" @if($company->category == "Advertiser") selected @endif>Advertiser</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Date Joined</label>
                            <div class="col-md-6">
                                <div class='input-group date' id='joined_date'>
                                    <input type='text' class="form-control" name="joined_date" value="{{ $company->date_joined }}"/>
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
                                    <input type='text' class="form-control" name="operation_date" value="{{ $company->date_operation_started }}"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Registration Num</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="registration_num" value="{{ $company->registration_num }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Paid Up Capital</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="paid_up_capital" value="{{ $company->paid_up_capital }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Logo</label>
                            <div class="col-md-6">
                                <input type="file" class="form-control" name="logo">
                                @if(!empty($company->logo))
                                    <img src="{{ $company->logo }}" style="max-width: 200px; max-height:300px;">
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">No of Employees</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="no_of_employees" value="{{ $company->no_of_employees }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Annual Turnover</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="annual_turnover" value="{{ $company->annual_turnover }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Keyword</label>
                            <div class="col-md-6">
                                <textarea class="form-control" name="keyword" style="resize: vertical">{{ $company->keyword }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Physical File Number</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="physical_file_number" value="{{ $company->physical_file_number }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Billing Period (No. of days)</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="billing_period" value="{{ $company->billing_period }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Charge GST</label>
                            <div class="col-md-6">
                                <select name="gst" class="form-control" id="charge_gst">
                                    <option value="1" @if($company->include_gst == 1) selected @endif>Yes</option>
                                    <option value="0" @if($company->include_gst == 0) selected @endif>No</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group" id="gst_percent" @if($company->include_gst == 0) style="display: none;" @endif>
                            <label class="col-md-4 control-label">GST Percent</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="gst_percent" value="{{ $company->gst_percent }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Status</label>
                            <div class="col-md-6">
                                <select class="form-control" name="status">
                                    <option value="Draft" @if($company->status == "Draft") selected @endif>Draft</option>
                                    <option value="Active" @if($company->status == "Active") selected @endif>Active</option>
                                    <option value="Inactive" @if($company->status == "Inactive") selected @endif>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Account Quota</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="account_quota" value="{{ $company->account_quota }}" required>
                            </div>
                        </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    Contact
                    <a class="btn btn-xs btn-primary pull-right" id="add_new_contact" data-toggle="modal" data-target="#new_contact_form">Add New Contact</a>
                </div>
                <div class="panel-body">
                    @if(count($company->contacts) > 0)
                        <table id="company_contact" class="table">
                            <thead>
                            <tr>
                                <th>Contact Type</th>
                                <th>Address</th>
                                <th>Country</th>
                                <th>Telephone Number</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($company->contacts as $contact_key => $contact)
                                <tr id="contact_row_{{ $contact->id }}">
                                    <td>
                                        @foreach($contact_types as $contact_type)
                                            @if($contact->contact_type_id == $contact_type->id)
                                                {{ $contact_type->contact_type }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $contact->address_line_1.' '.$contact->address_line_2.' '.$contact->address_line_3 }}</td>
                                    <td>{{ $contact->country }}</td>
                                    <td>{{ $contact->tel_num }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#contact{{ $contact->id }}"><span class="glyphicon glyphicon-edit"></span></button>
                                        @if($contact->contact_type_id != 1)
                                            <a class="btn btn-sm btn-danger delete_company_contact" data-contact="{{ $contact->id }}" title="Trash"><span class="glyphicon glyphicon-trash"></span></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

            {{--<div class="panel panel-default" id="logistic_panel" @if($company->category != "LSP") style="display: none;" @endif>--}}
                {{--<div class="panel-heading">Logistic</div>--}}
                {{--<div class="panel-body">--}}
                    {{--<div class="form-group">--}}
                        {{--<div class="col-md-6">--}}
                            {{--@foreach($logistics as $logistic)--}}
                                {{--<div class="checkbox">--}}
                                    {{--<label>--}}
                                        {{--<input class="logistic" type="checkbox" name="logistic[]" value="{{ $logistic->id }}" @if(in_array($logistic->id, $selected_logistics)) checked @endif> {{ $logistic->name }}--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                            {{--@endforeach--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<div class="panel panel-default" id="service_panel" @if($company->category != "LSP") style="display: none;" @endif>--}}
                {{--<div class="panel-heading">Service</div>--}}
                {{--<div class="panel-body">--}}
                    {{--<div class="form-group">--}}
                        {{--<div class="col-md-6">--}}
                            {{--@foreach($services as $service)--}}
                                {{--<div class="checkbox">--}}
                                    {{--<label>--}}
                                        {{--<input class="service" type="checkbox" name="service[]" value="{{ $service->id }}" @if(in_array($service->id, $selected_services)) checked @endif> {{ $service->name }}--}}
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
                                        <input class="industry" type="checkbox" name="industry[]" value="{{ $industry->id }}" @if(in_array($industry->id, $selected_industries)) checked @endif> {{ $industry->industry }}
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
                                        <input class="requirement" type="checkbox" name="requirement[]" value="{{ $requirement->id }}" @if(in_array($requirement->id, $selected_requirements)) checked @endif> {{ $requirement->requirement }}
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
                                        <input class="potential" type="checkbox" name="potential[]" value="{{ $potential->id }}" @if(in_array($potential->id, $selected_potentials)) checked @endif> {{ $potential->potential }}
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
                    @if(count($company->achievements) > 0)
                        @foreach($company->achievements as $achievement)
                            <div style="border: 1px lightgrey solid;" id="previous_achievement_{{ $achievement['pivot']['id'] }}">
                                <br>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Category</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="previous_achievements[{{ $achievement['pivot']['id'] }}][category]">
                                            @foreach($achievements as $achievement_info)
                                                <option value="{{ $achievement_info->id }}" @if($achievement['id'] == $achievement_info->id) selected @endif>{{ $achievement_info->achievement_type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Descriptions</label>
                                    <div class="col-md-6">
                                        <textarea class="form-control" style="resize: vertical;" name="previous_achievements[{{ $achievement['pivot']['id'] }}][descriptions]">{{ $achievement['pivot']['descriptions'] }}</textarea>
                                    </div>
                                    <a class="btn btn-xs btn-danger delete_achievement_btn" data-achievement="{{ $achievement['pivot']['id'] }}"><span class="glyphicon glyphicon-remove" title="Delete"></span></a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div style="border: 1px lightgrey solid;">
                            <br>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Category</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="achievements[1][category]">
                                        <option value="" selected disabled></option>
                                        @foreach($achievements as $achievement_info)
                                            <option value="{{ $achievement_info->id }}">{{ $achievement_info->achievement_type }}</option>
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
                    @endif
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    Features
                    <a class="btn btn-xs btn-primary pull-right" id="add_new_feature">Add New Feature</a>
                </div>
                <div class="panel-body" id="feature_panel">
                    @if(count($company->features) > 0)
                        @foreach($company->features as $feature_index => $feature)
                            <div style="border: 1px lightgrey solid;" id="previous_feature_{{ $feature['id'] }}">
                                <br>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Feature</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="previous_feature[{{ $feature['id'] }}][name]" value="{{ $feature['feature'] }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Details</label>
                                    <div class="col-md-6">
                                        <textarea class="form-control" style="resize: vertical;" name="previous_feature[{{ $feature['id'] }}][detail]">{{ $feature['details'] }}</textarea>
                                    </div>
                                    <a class="btn btn-xs btn-danger delete_feature_btn" data-feature="{{ $feature['id'] }}"><span class="glyphicon glyphicon-remove" title="Delete"></span></a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div style="border: 1px lightgrey solid;">
                            <br>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Feature</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="feature[1][name]">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Details</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" style="resize: vertical;" name="feature[1][detail]"></textarea>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    Remarks
                    <a class="btn btn-xs btn-primary pull-right" id="add_new_remark">Add New Remark</a>
                </div>
                <div class="panel-body" id="remark_panel">
                    @if(count($company->remarks) > 0)
                        @foreach($company->remarks as $remark)
                            <div class="form-group" id="previous_remark_panel_{{ $remark['id'] }}">
                                <label class="col-md-4 control-label">Remarks</label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="previous_remarks[{{ $remark['id'] }}]" value="{{ $remark['remarks'] }}">
                                </div>
                                <div class="col-md-1">
                                    <a class="btn btn-xs btn-danger delete_remark_btn" data-remark="{{ $remark['id'] }}"><span class="glyphicon glyphicon-remove"></span></a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="form-group">
                            <label class="col-md-4 control-label">Remarks</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="remarks[]" value="{{ old('remarks') }}">
                            </div>
                        </div>
                    @endif
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

    <div class="row">
        @foreach($company->contacts as $contact_key => $contact)
            <form class="form-horizontal" role="form" method="POST" action="/company/edit_company_contact/{{ $contact->id }}" enctype="multipart/form-data" id="contact_form_{{ $contact->id }}">
                <div class="modal fade" role="dialog" id="contact{{ $contact->id }}">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="gridSystemModalLabel">Company Contact</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Contact Type</label>
                                    <div class="col-md-6">
                                        @if($contact->contact_type_id == 1)
                                            <p>Main</p>
                                        @else
                                            <select class="form-control contact_type_select" name="select_contact_type" data-contact="{{ $contact->id }}">
                                                @foreach($contact_types as $contact_type)
                                                    @if($contact_type->id != 1)
                                                        <option value="{{ $contact_type->id }}" @if($contact->contact_type_id == $contact_type->id) selected @endif>{{ $contact_type->contact_type }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        @endif
                                        <input type="hidden" name="contact_type"  value="{{ $contact->contact_type_id }}" id="contact_type_{{ $contact->id }}"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Address Line 1</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="address_line_1" value="{{ $contact->address_line_1 }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Address Line 2</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="address_line_2" value="{{ $contact->address_line_2 }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Address Line 3</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="address_line_3" value="{{ $contact->address_line_3 }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Postcode</label>
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" name="postcode" value="{{ $contact->postcode }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Town</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="town" value="{{ $contact->town }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">State</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="state" value="{{ $contact->state }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Country</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="country" value="{{ $contact->country }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Telephone Number</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="tel_num" value="{{ $contact->tel_num }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Fax Number</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="fax_num" value="{{ $contact->fax_num }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Website</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="website" value="{{ $contact->website }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">PIC Name</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="pic_name" value="{{ $contact->pic_name }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">PIC Department</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="pic_department" value="{{ $contact->pic_department }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">PIC Designation</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="pic_designation" value="{{ $contact->pic_designation }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">PIC Mobile Number</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="pic_mobile_num" value="{{ $contact->pic_mobile_num }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">PIC Email 1</label>
                                    <div class="col-md-6">
                                        <input type="email" class="form-control" name="pic_email_1" value="{{ $contact->pic_email_1 }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">PIC Email 2</label>
                                    <div class="col-md-6">
                                        <input type="email" class="form-control" name="pic_email_2" value="{{ $contact->pic_email_2 }}">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            </form>
        @endforeach
    </div>
    <div id="new_contact_panel_div">
        <form class="form-horizontal" role="form" method="POST" action="/company/add_company_contact/{{ $company->id }}" enctype="multipart/form-data">
            <div class="modal fade" role="dialog" id="new_contact_form">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="gridSystemModalLabel">Company Contact</h4>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Contact Type</label>
                                <div class="col-md-6">
                                    <select class="form-control contact_type_select" name="new_contact_contact_type">
                                        @foreach($contact_types as $contact_type)
                                            @if($contact_type->id != 1)
                                                <option value="{{ $contact_type->id }}">{{ $contact_type->contact_type }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Address Line 1</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="new_contact_address_line_1" value="{{ old('new_contact[address_line_1') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Address Line 2</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="new_contact_address_line_2" value="{{ old('new_contact_address_line_2') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Address Line 3</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="new_contact_address_line_3" value="{{ old('new_contact_address_line_3') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Postcode</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="new_contact_postcode" value="{{ old('new_contact_postcode') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Town</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="new_contact_town" value="{{ old('new_contact_town') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">State</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="new_contact_state" value="{{ old('new_contact_state') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Country</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="new_contact_country" value="{{ old('new_contact_country') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Telephone Number</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="new_contact_tel_num" value="{{ old('new_contact_tel_num') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Fax Number</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="new_contact_fax_num" value="{{ old('new_contact_fax_num') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Website</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="new_contact_website" value="{{ old('new_contact_website') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">PIC Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="new_contact_pic_name" value="{{ old('new_contact_pic_name') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">PIC Department</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="new_contact_pic_department" value="{{ old('new_contact_pic_department') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">PIC Designation</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="new_contact_pic_designation" value="{{ old('new_contact_pic_designation') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">PIC Mobile Number</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="new_contact_pic_mobile_num" value="{{ old('new_contact_pic_mobile_num') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">PIC Email 1</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="new_contact_pic_email_1" value="{{ old('new_contact_pic_email_1') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">PIC Email 2</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="new_contact_pic_email_2" value="{{ old('new_contact_pic_email_2') }}">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </form>
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

        $('.delete_feature_btn').click(function(){
            if (confirm('Are you sure you want to delete this feature?')) {
                var id = 'previous_feature_'+$(this).data("feature");
                var data = {'_method': 'DELETE',  '_token': "{{ csrf_token() }}"};
                $.ajax({
                    type: "DELETE",
                    data: data,
                    url: '/company/delete_company_feature/'+$(this).data("feature"),
                    success: function(response)
                    {
                        if(response.status){
                            $('#'+id).remove();
                        }else{
                            alert('Unknown error, cannot delete this feature.');
                        }

                    }
                });
            }
        });

        $('.delete_remark_btn').click(function(){
            if (confirm('Are you sure you want to delete this remark?')) {
                var id = 'previous_remark_panel_'+$(this).data("remark");
                var data = {'_method': 'DELETE',  '_token': "{{ csrf_token() }}"};
                $.ajax({
                    type: "DELETE",
                    data: data,
                    url: '/company/delete_company_remark/'+$(this).data("remark"),
                    success: function(response)
                    {
                        if(response.status){
                            $('#'+id).remove();
                        }else{
                            alert('Unknown error, cannot delete this remark.');
                        }

                    }
                });
            }
        });

        $('.delete_achievement_btn').click(function(){
            if (confirm('Are you sure you want to delete this achievement?')) {
                var id = 'previous_achievement_'+$(this).data("achievement");
                var data = {'_method': 'DELETE',  '_token': "{{ csrf_token() }}"};
                $.ajax({
                    type: "DELETE",
                    data: data,
                    url: '/company/delete_company_achievement/'+$(this).data("achievement"),
                    success: function(response)
                    {
                        if(response.status){
                            $('#'+id).remove();
                        }else{
                            alert('Unknown error, cannot delete this achievement.');
                        }

                    }
                });
            }
        });

        $('.delete_company_contact').click(function(){
            if (confirm('Are you sure you want to delete this contact?')) {
                var id = $(this).data("contact");
                var data = {'_method': 'DELETE',  '_token': "{{ csrf_token() }}"};
                $.ajax({
                    type: "DELETE",
                    data: data,
                    url: '/company/delete_company_contact/'+$(this).data("contact"),
                    success: function(response)
                    {
                        if(response.status){
                            $('#contact_row_'+id).remove();
                            $('#contact_form_'+id).remove();
                        }else{
                            alert('Unknown error, cannot delete this achievement.');
                        }

                    }
                });
            }
        });

        $('.contact_type_select').on('change',function(){
            var contact_id = $(this).data('contact');
            $('#contact_type_'+contact_id).val($(this).val());
        });

        var count_contact = 1;
        var new_contact_form = '<form class="form-horizontal" role="form" method="POST" action="" enctype="multipart/form-data" id="new_contact_form_'+count_contact+'">';
        var new_contact_panel = '<div class="modal" role="dialog"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close remove_new_company_contact" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title">New Company Contact</h4></div><div class="modal-body" id="new_contact_panel_body"><input type="hidden" name="_token" value="{{ csrf_token() }}">';
        var contact_type = '<select class="form-control contact_type_select" name="new['+count_contact+'][contact_type]">@foreach($contact_types as $contact_type) @if($contact_type->id != 1) <option value="{{ $contact_type->id }}">{{ $contact_type->contact_type }}</option> @endif @endforeach</select>';
        var address_line_1 = '<div class="form-group"><label class="col-md-4 control-label">Address Line 1</label><div class="col-md-6"><input type="text" class="form-control" name="new['+count_contact+'][address_line_1]"></div></div>';
        var address_line_2 = '<div class="form-group"><label class="col-md-4 control-label">Address Line 2</label><div class="col-md-6"><input type="text" class="form-control" name="new['+count_contact+'][address_line_2]"></div></div>';
        var address_line_3 = '<div class="form-group"><label class="col-md-4 control-label">Address Line 3</label><div class="col-md-6"><input type="text" class="form-control" name="new['+count_contact+'][address_line_3]"></div></div>';
        var postcode = '<div class="form-group"><label class="col-md-4 control-label">Postcode</label><div class="col-md-6"><input type="number" class="form-control" name="new['+count_contact+'][postcode]"></div></div>';
        var town = '<div class="form-group"><label class="col-md-4 control-label">Town</label><div class="col-md-6"><input type="text" class="form-control" name="new['+count_contact+'][town]"></div></div>';
        var state = '<div class="form-group"><label class="col-md-4 control-label">State</label><div class="col-md-6"><input type="text" class="form-control" name="new['+count_contact+'][state]"></div></div>';
        var country = '<div class="form-group"><label class="col-md-4 control-label">Country</label><div class="col-md-6"><input type="text" class="form-control" name="new['+count_contact+'][country]"></div></div>';
        var tele_num = '<div class="form-group"><label class="col-md-4 control-label">Telephone Number</label><div class="col-md-6"><input type="number" class="form-control" name="new['+count_contact+'][tel_num]"></div></div>';
        var fax_num = '<div class="form-group"><label class="col-md-4 control-label">Fax Number</label><div class="col-md-6"><input type="number" class="form-control" name="new['+count_contact+'][fax_num]"></div></div>';
        var website = '<div class="form-group"><label class="col-md-4 control-label">Website</label><div class="col-md-6"><input type="text" class="form-control" name="new['+count_contact+'][website]"></div></div>';
        var pic_name = '<div class="form-group"><label class="col-md-4 control-label">PIC Name</label><div class="col-md-6"><input type="text" class="form-control" name="new['+count_contact+'][pic_name]"></div></div>';
        var pic_department = '<div class="form-group"><label class="col-md-4 control-label">PIC Department</label><div class="col-md-6"><input type="text" class="form-control" name="new['+count_contact+'][pic_department]"></div></div>';
        var pic_designation = '<div class="form-group"><label class="col-md-4 control-label">PIC Designation</label><div class="col-md-6"><input type="text" class="form-control" name="new['+count_contact+'][pic_designation]"></div></div>';
        var pic_mobile_num = '<div class="form-group"><label class="col-md-4 control-label">PIC Mobile Number</label><div class="col-md-6"><input type="number" class="form-control" name="new['+count_contact+'][pic_mobile_num]"></div></div>';
        var pic_email_1 = '<div class="form-group"><label class="col-md-4 control-label">PIC Email 1</label><div class="col-md-6"><input type="email" class="form-control" name="new['+count_contact+'][pic_email_1]"></div></div>';
        var pic_email_2 = '<div class="form-group"><label class="col-md-4 control-label">PIC Email 2</label><div class="col-md-6"><input type="email" class="form-control" name="new['+count_contact+'][pic_email_2]"></div></div>';
        var new_contact_panel_close_div = '</div><div class="modal-footer"><button type="button" class="btn btn-default remove_new_company_contact" data-dismiss="modal">Close</button><button type="submit" class="btn btn-primary">Save changes</button></div></div></div></div></form>';
        var combined_new_contact_panel = new_contact_form + new_contact_panel + contact_type + address_line_1 + address_line_2 + address_line_3 + postcode + town + state + country + tele_num + fax_num + website + pic_name + pic_department + pic_designation + pic_mobile_num + pic_email_1 + pic_email_2 + new_contact_panel_close_div;

        $('#add_new_contact').click(function(){
            console.log('1');
            $('#new_contact_panel_div').append(combined_new_contact_panel);
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