@extends('app')

@section('style')
    <style>
        .response-history{
            color: lightgrey;
        }
    </style>
@endsection

@section('content')
    <div class="center-block">
        <h3>
            Appointments
            <button type="button" class="pull-right btn btn-sm btn-success" data-toggle="modal" data-target="#appointment">New Appointment</button>
        </h3>
        <div class="clearfix"></div>
        <hr>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#received_appointment" aria-controls="received_appointment" role="tab" data-toggle="tab">Received appointments</a></li>
            <li role="presentation"><a href="#sent_appointment" aria-controls="sent_appointment" role="tab" data-toggle="tab">Sent Appointments</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="received_appointment">
                @if(count($received_appointments) > 0)
                    @foreach($received_appointments as $received_appointment)
                        <div class="list-group">
                            <a data-toggle="modal" data-target="#appointment_form_{{ $received_appointment->id }}" class="list-group-item @if($received_appointment->sender == \Auth::user()->company_id) list-group-item-info @else list-group-item-success @endif">
                                <h4 class="list-group-item-heading">
                                    {{ $received_appointment->get_sender->company_name or 'Admin' }}
                                    <small class="pull-right">{{ $received_appointment->updated_at }}</small>
                                </h4>
                            </a>
                        </div>
                        <div class="modal fade" role="dialog" id="appointment_form_{{ $received_appointment->id }}">
                            <div class="modal-dialog" role="document">
                                <form class="form-horizontal" action="/appointments/response_appointment" method="POST" enctype="multipart/form-data">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="gridSystemModalLabel">New Appointment</h4>
                                        </div>
                                        <div class="modal-body" id="modal_body_{{ $received_appointment->id }}">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="appointment_request_id" value="{{ $received_appointment->id }}">

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Initiate By </label>
                                                <div class="col-md-6">
                                                    <p class="display-content">{{ $received_appointment->get_sender->company_name or 'Admin' }}</p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">No. of PIC</label>
                                                <div class="col-md-6">
                                                    <p class="display-content">{{ $received_appointment->no_of_pic }}</p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Objective</label>
                                                <div class="col-md-6">
                                                    <p class="display-content">{{ $received_appointment->objective->app_objective }}</p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Appointment Description</label>
                                                <div class="col-md-6">
                                                    <p class="display-content">{{ $received_appointment->description }}</p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Location</label>
                                                <div class="col-md-6">
                                                    <p class="display-content">{{ $received_appointment->location }}</p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Date Time</label>
                                                <div class="col-md-6">
                                                    <p class="display-content">{{ $received_appointment->date_time }}</p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Status</label>
                                                <div class="col-md-6">
                                                    <p class="display-content">{{ $received_appointment->status }}</p>
                                                </div>
                                            </div>

                                            <div class="clearfix"></div>
                                            <hr>

                                            @if(count($received_appointment->response) > 0)
                                                @if(count($received_appointment->response) > 1)
                                                    <div class="text-center col-sm-12">
                                                        <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                                            Show response history
                                                        </a>
                                                    </div>
                                                    <div class="collapse" id="collapseExample">
                                                        @foreach($received_appointment->response as $response_key => $response)
                                                            @if($response_key < count($received_appointment->response) - 1)
                                                                <div class="form-group response-history">
                                                                    <label class="col-md-4 control-label">Previous response</label>
                                                                    <div class="col-md-6">
                                                                        <p class="display-content">{{ $response->response_action }}</p>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group response-history">
                                                                    <label class="col-md-4 control-label">Comment</label>
                                                                    <div class="col-md-6">
                                                                        <p class="display-content">{{ $response->description or 'NULL' }}</p>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group response-history">
                                                                    <label class="col-md-4 control-label">Previous response time</label>
                                                                    <div class="col-md-6">
                                                                        <p class="display-content">{{ $response->updated_at }}</p>
                                                                    </div>
                                                                </div>

                                                                <div class="clearfix"></div>
                                                                <hr>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @endif
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Response</label>
                                                    <div class="col-md-6">
                                                        <p class="display-content" @if($received_appointment->response[count($received_appointment->response) - 1]->response_action == 'Accept') style="color: green;" @else style="color: red;" @endif><b>{{ $received_appointment->response[count($received_appointment->response) - 1]->response_action }}</b></p>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Comment</label>
                                                    <div class="col-md-6">
                                                        <p class="display-content">{{ $received_appointment->response[count($received_appointment->response) - 1]->description or 'NULL' }}</p>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Response Time</label>
                                                    <div class="col-md-6">
                                                        <p class="display-content">{{ $received_appointment->response[count($received_appointment->response) - 1]->updated_at }}</p>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <hr>
                                            @endif

                                            @if(\Auth::user()->company_id != $received_appointment->sender)
                                                @if($received_appointment->expired == 0)
                                                    <div class="form-group required">
                                                        <label class="col-md-4 control-label">Answer to appointment</label>
                                                        <div class="col-md-6">
                                                            <select name="answer_to_appointment" class="form-control answer_to_appointment" data-appointment="{{ $received_appointment->id }}">
                                                                <option value="Accept">Accept</option>
                                                                <option value="Reject">Reject</option>
                                                                <option value="Request to modify">Request to modify</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group" id="comment_{{ $received_appointment->id }}">
                                                        <label class="col-md-4 control-label">Comment</label>
                                                        <div class="col-md-6">
                                                            <textarea name="comment" class="form-control" style="resize: vertical;" id="comment_box_{{ $received_appointment->id }}"></textarea>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="form-group">
                                                        <p class="text-center">Appointment expired.</p>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            @if(\Auth::user()->company_id != $received_appointment->sender)
                                                <button type="submit" class="btn btn-primary">Send</button>
                                            @endif
                                        </div>
                                    </div><!-- /.modal-content -->
                                </form>
                            </div><!-- /.modal-dialog -->
                        </div>
                    @endforeach
                @else
                    {{ "No appointments." }}
                @endif
            </div>

            <div role="tabpanel" class="tab-pane" id="sent_appointment">
                @if(count($sent_appointments) > 0)
                    @foreach($sent_appointments as $sent_appointment)
                        <div class="list-group">
                            <a data-toggle="modal" data-target="#appointment_form_{{ $sent_appointment->id }}" class="list-group-item @if($sent_appointment->sender == \Auth::user()->company_id) list-group-item-info @else list-group-item-success @endif">
                                <h4 class="list-group-item-heading">
                                    {{ $sent_appointment->get_sender->company_name or 'Admin' }}
                                    <small class="pull-right">{{ $sent_appointment->updated_at }}</small>
                                </h4>
                            </a>
                        </div>
                        <div class="modal fade" role="dialog" id="appointment_form_{{ $sent_appointment->id }}">
                            <div class="modal-dialog" role="document">
                                <form class="form-horizontal" action="/appointments/modify_appointment/{{ $sent_appointment->id }}" method="POST" enctype="multipart/form-data">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="gridSystemModalLabel">New Appointment</h4>
                                        </div>
                                        <div class="modal-body" id="modal_body_{{ $sent_appointment->id }}">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="appointment_request_id" value="{{ $sent_appointment->id }}">

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Initiate By </label>
                                                <div class="col-md-6">
                                                    <p class="display-content">{{ $sent_appointment->get_sender->company_name or 'Admin' }}</p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">No. of PIC</label>
                                                <div class="col-md-6">
                                                    <input class="form-control" type="number" name="no_of_pic" value="{{ $sent_appointment->no_of_pic }}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Objective</label>
                                                <div class="col-md-6">
                                                    <select name="appointment_objective" class="form-control">
                                                        @foreach($appointment_objectives as $objective_key => $objective)
                                                            <option value="{{ $objective_key }}" @if($sent_appointment->objective_id == $objective_key) selected @endif>{{ $objective }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Appointment Description</label>
                                                <div class="col-md-6">
                                                    <textarea name="appointment_description" class="form-control" style="resize: vertical;" required>{{ $sent_appointment->description }}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Location</label>
                                                <div class="col-md-6">
                                                    <textarea name="location" class="form-control" style="resize: vertical;" required>{{ $sent_appointment->location }}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Date Time</label>
                                                <div class="col-md-6">
                                                    <div class='input-group date old_appointment_date' id='date'>
                                                        <input type='text' class="form-control" name="appointment_date" value="{{ $sent_appointment->date_time }}" />
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Status</label>
                                                <div class="col-md-6">
                                                    <p class="display-content">{{ $sent_appointment->status }}</p>
                                                </div>
                                            </div>

                                            <div class="form-group text-center">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>

                                            @if(count($sent_appointment->response) > 0)
                                                <div class="clearfix"></div>
                                                <hr>
                                                @if(count($sent_appointment->response) > 1)
                                                    <div class="text-center col-sm-12">
                                                        <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                                            Show response history
                                                        </a>
                                                    </div>
                                                    <div class="collapse" id="collapseExample">
                                                        @foreach($sent_appointment->response as $response_key => $response)
                                                            @if($response_key < count($sent_appointment->response) - 1)
                                                                <div class="form-group response-history">
                                                                    <label class="col-md-4 control-label">Previous response</label>
                                                                    <div class="col-md-6">
                                                                        <p class="display-content">{{ $response->response_action }}</p>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group response-history">
                                                                    <label class="col-md-4 control-label">Comment</label>
                                                                    <div class="col-md-6">
                                                                        <p class="display-content">{{ $response->description or 'NULL' }}</p>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group response-history">
                                                                    <label class="col-md-4 control-label">Previous response time</label>
                                                                    <div class="col-md-6">
                                                                        <p class="display-content">{{ $response->updated_at }}</p>
                                                                    </div>
                                                                </div>

                                                                <div class="clearfix"></div>
                                                                <hr>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @endif
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Response</label>
                                                    <div class="col-md-6">
                                                        <p class="display-content" @if($sent_appointment->response[count($sent_appointment->response) - 1]->response_action == 'Accept') style="color: green;" @else style="color: red;" @endif><b>{{ $sent_appointment->response[count($sent_appointment->response) - 1]->response_action }}</b></p>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Comment</label>
                                                    <div class="col-md-6">
                                                        <p class="display-content">{{ $sent_appointment->response[count($sent_appointment->response) - 1]->description or 'NULL' }}</p>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Response Time</label>
                                                    <div class="col-md-6">
                                                        <p class="display-content">{{ $sent_appointment->response[count($sent_appointment->response) - 1]->updated_at }}</p>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </form>
                            </div><!-- /.modal-dialog -->
                        </div>
                    @endforeach
                @else
                    {{ "No appointments." }}
                @endif
            </div>
        </div>



        <div class="modal fade" role="dialog" id="appointment">
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
                                <label class="col-md-4 control-label">Receiver</label>
                                <div class="col-md-6">
                                    <select name="appointment_receiver" class="form-control">
                                        @foreach($companies as $company_key => $company)
                                            @if(\Auth::user()->company_id != $company_key)
                                                <option value="{{ $company_key }}">{{ $company }}</option>
                                            @endif
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
                                    <select name="appointment_objective" class="form-control">
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
                                        <input type='text' class="form-control" name="appointment_date"/>
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
            $('.old_appointment_date').datetimepicker({
                format: 'DD-MM-YYYY HH:mm'
            });

            $('#new_date').datetimepicker({
                format: 'DD-MM-YYYY HH:mm'
            });

            $('.answer_to_appointment').change(function(){
                var appointment_index = $(this).data('appointment');
                var answer = this.value;

                if(answer != 'Accept'){
                    $('#comment_'+appointment_index).addClass( "required" );
                    $('#comment_box_'+appointment_index).prop('required',true);
                    $('#comment_'+appointment_index).show();
                }else{
                    $('#comment_'+appointment_index).removeClass( "required" );
                    $('#comment_box_'+appointment_index).prop('required',false);
                }
            });
        });
    </script>
@endsection