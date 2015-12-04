@extends('app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <h3 class="pull-left">Appointment List</h3>
            <h3 class="pull-right"><button type="button" class="btn btn-success" data-toggle="modal" data-target="#new_appointment_form">New Appointment</button></h3>
        </div>
        <div class="clearfix"></div>
        <hr>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#appointment_request" aria-controls="appointment_request" role="tab" data-toggle="tab">Appointment Request</a></li>
            <li role="presentation"><a href="#appointment_response" aria-controls="appointment_response" role="tab" data-toggle="tab">Appointment Response</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="appointment_request">
                <table id="appointment_table" class="display">
                    <thead>
                    <tr>
                        <th>Sender</th>
                        <th>Receiver</th>
                        <th>Type</th>
                        <th>Date Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->get_sender['company_name'] or 'Admin' }}</td>
                            <td>{{ $appointment->get_receiver['company_name'] or 'Admin' }}</td>
                            <td>{{ $appointment->objective->app_objective }}</td>
                            <td>{{ $appointment->date_time }}</td>
                            <td>{{ $appointment->status }}</td>
                            <td>
                                <a data-toggle="modal" data-target="#appointment_form_{{ $appointment->id }}" class="btn btn-sm btn-primary">Edit</a>
                                <div class="modal fade" role="dialog" id="appointment_form_{{ $appointment->id }}">
                                    <div class="modal-dialog" role="document">
                                        <form class="form-horizontal" action="/appointments/modify_appointment/{{ $appointment->id }}" method="POST" enctype="multipart/form-data">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="gridSystemModalLabel">Edit Appointment Request</h4>
                                                </div>
                                                <div class="modal-body" id="modal_body_{{ $appointment->id }}">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="appointment_request_id" value="{{ $appointment->id }}">

                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">Initiate By </label>
                                                        <div class="col-md-6">
                                                            <p class="display-content">{{ $appointment->get_sender->company_name or 'Admin' }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">Received By </label>
                                                        <div class="col-md-6">
                                                            <p class="display-content">{{ $appointment->get_receiver->company_name or 'Admin' }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group required">
                                                        <label class="col-md-4 control-label">No. of PIC</label>
                                                        <div class="col-md-6">
                                                            <input class="form-control" type="number" name="no_of_pic" value="{{ $appointment->no_of_pic }}" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group required">
                                                        <label class="col-md-4 control-label">Objective</label>
                                                        <div class="col-md-6">
                                                            <select name="appointment_objective" class="form-control" required>
                                                                @foreach($appointment_objectives as $objective_key => $objective)
                                                                    <option value="{{ $objective_key }}" @if($appointment->objective_id == $objective_key) selected @endif>{{ $objective }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group required">
                                                        <label class="col-md-4 control-label">Appointment Description</label>
                                                        <div class="col-md-6">
                                                            <textarea name="appointment_description" class="form-control" style="resize: vertical;" required>{{ $appointment->description }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group required">
                                                        <label class="col-md-4 control-label">Location</label>
                                                        <div class="col-md-6">
                                                            <textarea name="location" class="form-control" style="resize: vertical;" required>{{ $appointment->location }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group required">
                                                        <label class="col-md-4 control-label">Date Time</label>
                                                        <div class="col-md-6">
                                                            <div class='input-group date old_appointment_date' id='date'>
                                                                <input type='text' class="form-control" name="appointment_date" value="{{ $appointment->date_time }}" required/>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group required">
                                                        <label class="col-md-4 control-label">Status</label>
                                                        <div class="col-md-6">
                                                            <select class="form-control" name="appointment_status" required>
                                                                <option value="Confirmed" @if($appointment->status == 'Confirmed') selected @endif>Confirmed</option>
                                                                <option value="Unconfirmed" @if($appointment->status == 'Unconfirmed') selected @endif>Unconfirmed</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </form>
                                    </div><!-- /.modal-dialog -->
                                </div>
                                <form method="POST" action="/appointment/{{ $appointment->id }}" enctype="multipart/form-data">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    @can('super-admin-only')
                                    <button class="btn btn-sm btn-danger" type="submit"><span class="glyphicon glyphicon-trash"></span></button>
                                    @endcan
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="appointment_response">
                <table id="appointment_response_table" class="display">
                    <thead>
                    <tr>
                        <th>Appointment Request ID</th>
                        <th>Response Action</th>
                        <th>Submit Date Time</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($appointment_response as $response)
                        <tr>
                            <td>
                                <a data-toggle="modal" data-target="#duplicate_appointment_form_{{ $response->appointment_request_id }}">{{ $response->appointment_request_id }}</a>
                            </td>
                            <td>{{ $response->response_action }}</td>
                            <td>{{ $response->updated_at }}</td>
                            <td>
                                <a data-toggle="modal" data-target="#appointment_response_form_{{ $response->id }}" class="btn btn-sm btn-primary">Edit</a>
                                <div class="modal fade" role="dialog" id="appointment_response_form_{{ $response->id }}">
                                    <div class="modal-dialog" role="document">
                                        <form class="form-horizontal" action="/appointments/modify_appointment_response/{{ $response->id }}" method="POST" enctype="multipart/form-data">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="gridSystemModalLabel">Edit Appointment Response</h4>
                                                </div>
                                                <div class="modal-body" id="modal_body_{{ $response->id }}">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="response_id" value="{{ $response->id }}">

                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">Appointment Request ID</label>
                                                        <div class="col-md-6">
                                                            <p class="display-content">
                                                                <a data-toggle="modal" data-target="#duplicate_appointment_form_{{ $response->appointment_request_id }}">{{ $response->appointment_request_id }}</a>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group required">
                                                        <label class="col-md-4 control-label">Appointment Response Description</label>
                                                        <div class="col-md-6">
                                                            <textarea name="response_description" class="form-control" style="resize: vertical;" required>{{ $response->description }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group required">
                                                        <label class="col-md-4 control-label">Response Action</label>
                                                        <div class="col-md-6">
                                                            <select name="response_action" class="form-control">
                                                                <option value="Accept" @if($response->response_action == 'Accept') selected @endif>Accept</option>
                                                                <option value="Reject" @if($response->response_action == 'Reject') selected @endif>Reject</option>
                                                                <option value="Request to modify" @if($response->response_action == 'Request to modify') selected @endif>Request to modify</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </form>
                                    </div><!-- /.modal-dialog -->
                                </div>
                                <form method="POST" action="/appointment/{{ $appointment->id }}" enctype="multipart/form-data">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    @can('super-admin-only')
                                    <button class="btn btn-sm btn-danger" type="submit"><span class="glyphicon glyphicon-trash"></span></button>
                                    @endcan
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                @if(count($appointments) > 0)
                    @foreach($appointments as $appointment)
                        <div class="modal fade" role="dialog" id="duplicate_appointment_form_{{ $appointment->id }}">
                            <div class="modal-dialog" role="document">
                                <form class="form-horizontal" action="/appointments/modify_appointment/{{ $appointment->id }}" method="POST" enctype="multipart/form-data">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="gridSystemModalLabel">Edit Appointment Request</h4>
                                        </div>
                                        <div class="modal-body" id="modal_body_{{ $appointment->id }}">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="appointment_request_id" value="{{ $appointment->id }}">

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Initiate By </label>
                                                <div class="col-md-6">
                                                    <p class="display-content">{{ $appointment->get_sender->company_name or 'Admin' }}</p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Received By </label>
                                                <div class="col-md-6">
                                                    <p class="display-content">{{ $appointment->get_receiver->company_name or 'Admin' }}</p>
                                                </div>
                                            </div>

                                            <div class="form-group required">
                                                <label class="col-md-4 control-label">No. of PIC</label>
                                                <div class="col-md-6">
                                                    <input class="form-control" type="number" name="no_of_pic" value="{{ $appointment->no_of_pic }}" required>
                                                </div>
                                            </div>

                                            <div class="form-group required">
                                                <label class="col-md-4 control-label">Objective</label>
                                                <div class="col-md-6">
                                                    <select name="appointment_objective" class="form-control" required>
                                                        @foreach($appointment_objectives as $objective_key => $objective)
                                                            <option value="{{ $objective_key }}" @if($appointment->objective_id == $objective_key) selected @endif>{{ $objective }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group required">
                                                <label class="col-md-4 control-label">Appointment Description</label>
                                                <div class="col-md-6">
                                                    <textarea name="appointment_description" class="form-control" style="resize: vertical;" required>{{ $appointment->description }}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group required">
                                                <label class="col-md-4 control-label">Location</label>
                                                <div class="col-md-6">
                                                    <textarea name="location" class="form-control" style="resize: vertical;" required>{{ $appointment->location }}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group required">
                                                <label class="col-md-4 control-label">Date Time</label>
                                                <div class="col-md-6">
                                                    <div class='input-group date old_appointment_date' id='date'>
                                                        <input type='text' class="form-control" name="appointment_date" value="{{ $appointment->date_time }}" required/>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group required">
                                                <label class="col-md-4 control-label">Status</label>
                                                <div class="col-md-6">
                                                    <select class="form-control" name="appointment_status" required>
                                                        <option value="Confirmed" @if($appointment->status == 'Confirmed') selected @endif>Confirmed</option>
                                                        <option value="Unconfirmed" @if($appointment->status == 'Unconfirmed') selected @endif>Unconfirmed</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </form>
                            </div><!-- /.modal-dialog -->
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" id="new_appointment_form">
        <div class="modal-dialog" role="document">
            <form class="form-horizontal" action="/appointments" method="POST" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel">New Appointment</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="sender_id" value="{{ \Auth::user()->company_id }}">

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Sender</label>
                            <div class="col-md-6">
                                <select name="sender_id" class="form-control" required>
                                    @foreach($companies as $company_key => $company)
                                        <option value="{{ $company_key }}">{{ $company }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Receiver</label>
                            <div class="col-md-6">
                                <select name="appointment_receiver" class="form-control" required>
                                    @foreach($companies as $company_key => $company)
                                        <option value="{{ $company_key }}">{{ $company }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">No. of PIC</label>
                            <div class="col-md-6">
                                <input name="appointment_no_of_pic" class="form-control" type="number" required>
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Objective</label>
                            <div class="col-md-6">
                                <select name="appointment_objective" class="form-control" required>
                                    @foreach($appointment_objectives as $objective_key => $objective)
                                        <option value="{{ $objective_key }}">{{ $objective }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Appointment Description</label>
                            <div class="col-md-6">
                                <textarea name="appointment_description" class="form-control" style="resize: vertical;" required></textarea>
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Location</label>
                            <div class="col-md-6">
                                <textarea name="appointment_location" class="form-control" style="resize: vertical;" required></textarea>
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Date Time</label>
                            <div class="col-md-6">
                                <div class='input-group date' id='new_date'>
                                    <input type='text' class="form-control" name="appointment_date" required/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </div><!-- /.modal-content -->
            </form>
        </div><!-- /.modal-dialog -->
    </div>

@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready( function () {
            $('#appointment_table').DataTable();
            $('#appointment_response_table').DataTable();

            $('.old_appointment_date').datetimepicker({
                format: 'DD-MM-YYYY HH:mm'
            });

            $('#new_date').datetimepicker({
                format: 'DD-MM-YYYY HH:mm'
            });
        });
    </script>
@endsection