@extends('app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <h3 class="pull-left">Message List</h3>
            <h3 class="pull-right"><button type="button" class="btn btn-success" data-toggle="modal" data-target="#new_message_form">New Message</button></h3>
        </div>
        <hr>
        <table id="message_table" class="display">
            <thead>
            <tr>
                <th>Sender</th>
                <th>Receiver</th>
                <th>Subject</th>
                <th>Description</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($messages as $message)
                <tr>
                    <td>{{ $message->get_sender['company_name'] or 'Admin' }}</td>
                    <td>{{ $message->get_receiver['company_name'] or 'Admin' }}</td>
                    <td>{{ $message->subject }}</td>
                    <td>{{ $message->description }}</td>
                    <td>{{ $message->message_type }}</td>
                    <td>
                        <form method="POST" action="/messages/{{ $message->id }}" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#edit_message_{{ $message->id }}"><span class="glyphicon glyphicon-edit"></span></a>
                            @can('super-admin-only')
                            <button class="btn btn-sm btn-danger" type="submit"><span class="glyphicon glyphicon-trash"></span></button>
                            @endcan
                        </form>
                        <div class="modal fade" role="dialog" id="edit_message_{{ $message->id }}">
                            <div class="modal-dialog" role="document">
                                <form class="form-horizontal" action="/messages/{{ $message->id }}" method="POST" enctype="multipart/form-data">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="gridSystemModalLabel">Edit Message</h4>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="_method" value="PUT">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                            <div class="form-group required">
                                                <label class="col-md-4 control-label">Subject</label>
                                                <div class="col-md-6">
                                                    <input type='text' class="form-control" name="subject" value="{{ $message->subject }}" required/>
                                                </div>
                                            </div>

                                            <div class="form-group required">
                                                <label class="col-md-4 control-label">Description</label>
                                                <div class="col-md-6">
                                                    <textarea name="description" class="form-control" style="resize: vertical;" required>{{ $message->description }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </form>
                            </div><!-- /.modal-dialog -->
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal fade" role="dialog" id="new_message_form">
        <div class="modal-dialog" role="document">
            <form class="form-horizontal" action="/message/send_message" method="POST" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel">New Message</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="message_type" value="Initiate">
                        <input type="hidden" name="sender_id" value="{{ \Auth::user()->company_id }}">

                        <div class="form-group">
                            <label class="col-md-4 control-label">Receiver</label>
                            <div class="col-md-6">
                                <select name="receiver_id" class="form-control">
                                    @if(count($companies) > 0)
                                        @foreach($companies as $company_key => $company)
                                            @if($company_key != \Auth::user()->company_id)
                                                <option value="{{ $company_key }}">{{ $company }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Subject</label>
                            <div class="col-md-6">
                                <input type='text' class="form-control" name="subject" required/>
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Description</label>
                            <div class="col-md-6">
                                <textarea name="description" class="form-control" style="resize: vertical;" required></textarea>
                            </div>
                        </div>

                        @can('super-admin-only')
                        <div class="checkbox">
                            <label class="col-md-offset-4">
                                <input type="checkbox" name="create_appointment" id="show_appointment" value="1" checked> Create Appointment
                            </label>
                        </div>

                        <div class="clearfix"></div>
                        <br>

                        <div class="form-group required appointment_field">
                            <label class="col-md-4 control-label">No. of PIC</label>
                            <div class="col-md-6">
                                <input name="appointment_no_of_pic" class="form-control appointment_required_fields" type="number" required>
                            </div>
                        </div>

                        <div class="form-group required appointment_field">
                            <label class="col-md-4 control-label">Objective</label>
                            <div class="col-md-6">
                                <select name="appointment_objective" class="form-control appointment_required_fields" required>
                                    @foreach($appointment_objectives as $objective_key => $objective)
                                        <option value="{{ $objective_key }}">{{ $objective }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group required appointment_field">
                            <label class="col-md-4 control-label">Appointment Description</label>
                            <div class="col-md-6">
                                <textarea name="appointment_description" class="form-control appointment_required_fields" style="resize: vertical;" required></textarea>
                            </div>
                        </div>

                        <div class="form-group required appointment_field">
                            <label class="col-md-4 control-label">Location</label>
                            <div class="col-md-6">
                                <textarea name="appointment_location" class="form-control appointment_required_fields" style="resize: vertical;" required></textarea>
                            </div>
                        </div>

                        <div class="form-group required appointment_field">
                            <label class="col-md-4 control-label">Date Time</label>
                            <div class="col-md-6">
                                <div class='input-group date' id='date'>
                                    <input type='text' class="form-control appointment_required_fields" name="appointment_date" required/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                </div>
                            </div>
                        </div>
                        @endcan
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
            $('#message_table').DataTable();

            $('#date').datetimepicker({
                format: 'DD-MM-YYYY HH:mm'
            });

            $('#show_appointment').change(function(){
                if($('#show_appointment').is(":checked")){
                    $('.appointment_field').show();
                    $('.appointment_required_fields').prop('required',true);
                }else{
                    $('.appointment_field').hide();
                    $('.appointment_required_fields').prop('required',false);
                }
            });
        });
    </script>
@endsection