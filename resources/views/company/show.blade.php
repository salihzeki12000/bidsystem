@extends('app')

@section('content')
    <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h4>View Company</h4>
                <br>
                <div class="panel panel-default">
                    <div class="panel-heading">Profile</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Company Name</label>
                            <div class="col-md-6">
                                <p>{{ $company->company_name }}</p>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Category</label>
                            <div class="col-md-6">
                                <p>{{ $company->category }}</p>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Date Joined</label>
                            <div class="col-md-6">
                                <p>{{ $company->date_joined }}</p>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Date Operation Started</label>
                            <div class="col-md-6">
                                <p>{{ $company->date_operation_started }}</p>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Registration Num</label>
                            <div class="col-md-6">
                                <p>{{ $company->registration_num }}</p>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Paid Up Capital</label>
                            <div class="col-md-6">
                                <p>{{ $company->paid_up_capital }}</p>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Logo</label>
                            <div class="col-md-6">
                                @if(!empty($company->logo))
                                    <img src="{{ $company->logo }}" style="max-width: 200px; max-height:300px;">
                                @else
                                    <p>{{ 'No Logo' }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">No of Employees</label>
                            <div class="col-md-6">
                                <p>{{ $company->no_of_employees }}</p>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Annual Turnover</label>
                            <div class="col-md-6">
                                <p>{{ $company->annual_turnover }}</p>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Keyword</label>
                            <div class="col-md-6">
                                <p>{{ $company->keyword }}</p>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Physical File Number</label>
                            <div class="col-md-6">
                                <p>{{ $company->physical_file_number }}</p>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Physical File Number</label>
                            <div class="col-md-6">
                                <p>{{ $company->physical_file_number }}</p>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Billing Period</label>
                            <div class="col-md-6">
                                <p>{{ $company->billing_period." days" }}</p>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Charge GST</label>
                            <div class="col-md-6">
                                <p>
                                    @if($company->include_gst == 0)
                                        {{ "Not chargeable" }}
                                    @else
                                        {{ $company->gst_percent."%" }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Status</label>
                            <div class="col-md-6">
                                <p>{{ $company->status }}</p>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Account Quota</label>
                            <div class="col-md-6">
                                <p>{{ $company->account_quota }}</p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Contact
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
                                    <th>Detail</th>
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
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#contact{{ $contact->id }}"><span class="glyphicon glyphicon-eye-open"></span></button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>

                @if(count($company->logistics) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">Logistic</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-md-12">
                                @foreach($company->logistics as $logistic)
                                    <p>{{ $logistic['name'] }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if(count($company->services) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">Services</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-md-12">
                                @foreach($company->services as $service)
                                    <p>{{ $service['name'] }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if(count($company->industries) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">Industry</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-md-12">
                                @foreach($company->industries as $industry)
                                    <p>{{ $industry['industry'] }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if(count($company->requirements) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">Requirements</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-md-12">
                                @foreach($company->requirements as $requirement)
                                    <p>{{ $requirement['requirement'] }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if(count($company->potentials) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">Potentials</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-md-12">
                                @foreach($company->potentials as $potential)
                                    <p>{{ $potential['potential'] }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if(count($company->achievements) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Achievements
                    </div>
                    <div class="panel-body" id="achievement_panel">
                        @foreach($company->achievements as $achievement)
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Category</label>
                                    <div class="col-md-6">
                                        <p>{{ $achievement['achievement_type'] }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Descriptions</label>
                                    <div class="col-md-6">
                                        {{ $achievement['pivot']['descriptions'] }}
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <hr>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(count($company->features) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Features
                    </div>
                    <div class="panel-body" id="feature_panel">
                        @foreach($company->features as $feature_index => $feature)
                            <div class="col-sm-12">
                                <br>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Feature</label>
                                    <div class="col-md-6">
                                        <p>{{ $feature['feature'] }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Details</label>
                                    <div class="col-md-6">
                                        <p>{{ $feature['details'] }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <hr>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(count($company->remarks) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Remarks
                    </div>
                    <div class="panel-body" id="remark_panel">
                        @foreach($company->remarks as $remark)
                            <div class="form-group">
                                <label class="col-md-4 control-label">Remarks</label>
                                <div class="col-md-5">
                                    <p>{{ $remark['remarks'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="text-center">
                    <a href="/company" class="btn btn-default">Back</a>
                </div>
                <div class="clearfix"></div>
                <br>
            </div>
    </div>

    <div class="row">
        @foreach($company->contacts as $contact_key => $contact)
            <form class="form-horizontal" id="contact_form_{{ $contact->id }}">
                <div class="modal fade" role="dialog" id="contact{{ $contact->id }}">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="gridSystemModalLabel">Company Contact</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Contact Type</label>
                                    <div class="col-md-6">
                                        @foreach($contact_types as $contact_type)
                                            @if($contact->contact_type_id == $contact_type->id)
                                                <p>{{ $contact_type->contact_type }}</p>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Address Line 1</label>
                                    <div class="col-md-6">
                                        <p>{{ $contact->address_line_1 }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Address Line 2</label>
                                    <div class="col-md-6">
                                        <p>{{ $contact->address_line_2 }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Address Line 3</label>
                                    <div class="col-md-6">
                                        <p>{{ $contact->address_line_3 }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Postcode</label>
                                    <div class="col-md-6">
                                        <p>{{ $contact->postcode }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Town</label>
                                    <div class="col-md-6">
                                        <p>{{ $contact->town }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">State</label>
                                    <div class="col-md-6">
                                        <p>{{ $contact->state }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Country</label>
                                    <div class="col-md-6">
                                        <p>{{ $contact->country }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Telephone Number</label>
                                    <div class="col-md-6">
                                        <p>{{ $contact->tel_num }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Fax Number</label>
                                    <div class="col-md-6">
                                        <p>{{ $contact->fax_num }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Website</label>
                                    <div class="col-md-6">
                                        <p>{{ $contact->website }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">PIC Name</label>
                                    <div class="col-md-6">
                                        <p>{{ $contact->pic_name }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">PIC Department</label>
                                    <div class="col-md-6">
                                        <p>{{ $contact->pic_department }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">PIC Designation</label>
                                    <div class="col-md-6">
                                        <p>{{ $contact->pic_designation }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">PIC Mobile Number</label>
                                    <div class="col-md-6">
                                        <p>{{ $contact->pic_mobile_num }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">PIC Email 1</label>
                                    <div class="col-md-6">
                                        <p>{{ $contact->pic_email_1 }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">PIC Email 2</label>
                                    <div class="col-md-6">
                                        <p>{{ $contact->pic_email_2 }}</p>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            </form>
        @endforeach
    </div>

@endsection