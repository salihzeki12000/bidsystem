@extends('app')

@section('style')
    <style>
        h4{
            font-weight: 400 !important;
        }
        .unread > h4 {
            font-weight: 800 !important;
        }
    </style>
@endsection

@section('content')
    <div class="center-block">
        <h3>
            Messages
            <button type="button" class="pull-right btn btn-sm btn-success" data-toggle="modal" data-target="#new_message_form">New Message</button>
        </h3>
        <div class="clearfix"></div>
        <hr>
            <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#inbox" aria-controls="inbox" role="tab" data-toggle="tab">Inbox</a></li>
            <li role="presentation"><a href="#sent_message" aria-controls="sent_message" role="tab" data-toggle="tab">Sent Message</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="inbox">
                <br>
                @if(count($received_messages) > 0)
                    @foreach($received_messages as $message)
                        <div class="list-group">
                            <a data-toggle="modal" data-target="#message_form_{{ $message['id'] }}" class="list-group-item list-group-item-info @if($message->is_read == 0) unread @endif" data-index="{{ $message->id }}" id="{{ $message->id }}">
                                <h4 class="list-group-item-heading">
                                    {{ $message->subject }}
                                    <small>Sent By: {{ $message->get_sender->company_name or 'Admin' }}</small>
                                    <small class="pull-right">{{ $message->updated_at }}</small>
                                </h4>
                            </a>
                        </div>
                        <div class="modal fade" role="dialog" id="message_form_{{ $message->id }}">
                            <div class="modal-dialog" role="document">
                                <form class="form-horizontal" action="/message/send_reply_message" method="POST" enctype="multipart/form-data">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title">Message</h4>
                                        </div>
                                        <div class="modal-body">
                                            <h4>{{ $message->subject }}</h4>
                                            <p>
                                                <i>
                                                    <small>{{ $message->get_sender->company_name or 'Admin' }}</small>
                                                </i>
                                                <small class="pull-right">{{ $message->updated_at }}</small>
                                            </p>
                                            <div class="clearfix"></div>
                                            <p>{{ $message->description }}</p>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="message_type" value="Reply">
                                            <input type="hidden" name="reply_to" value="{{ $message->id }}">
                                            <input type="hidden" name="receiver_id" value="{{ $message->sender }}">
                                            <input type="hidden" name="subject" value="{{ 'Re:'.$message->subject }}">
                                            <input type="hidden" name="sender_id" value="{{ $message->receiver }}">
                                        </div>
                                        <div class="clearfix"></div>
                                        <hr>
                                        @if(count($message->reply_messages_list) > 0)
                                            @foreach($message->reply_messages_list as $reply_message)
                                                <div class="col-sm-12">
                                                    <p>
                                                        <i>
                                                            <small>
                                                                @if($reply_message['sender'] == $message->sender)
                                                                    {{ $message->get_sender->company_name or 'Admin' }}
                                                                @else
                                                                    {{ 'Self' }}
                                                                @endif
                                                            </small>
                                                            <small class="pull-right">{{ $reply_message['updated_at'] }}</small>
                                                        </i>
                                                    </p>
                                                    <div class="clearfix"></div>
                                                    <p>{{ $reply_message['description'] }}</p>
                                                </div>
                                                <div class="clearfix"></div>
                                                <hr>
                                            @endforeach
                                        @endif
                                        <div class="col-sm-12">
                                            <label class="control-label">Reply</label>
                                            <textarea class="form-control" style="resize: vertical;" name="description"></textarea>
                                        </div>
                                        <div class="clearfix"></div>
                                        <br>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Reply</button>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </form>
                            </div><!-- /.modal-dialog -->
                        </div>
                    @endforeach
                @else
                    {{ "No messages." }}
                @endif
            </div>
            <div role="tabpanel" class="tab-pane" id="sent_message">
                <br>
                @if(count($sent_messages) > 0)
                    @foreach($sent_messages as $sent_message)
                        <div class="list-group">
                            <a data-toggle="modal" data-target="#message_form_{{ $sent_message['id'] }}" class="list-group-item list-group-item-success @if($sent_message->is_read == 0) unread @endif" data-index="{{ $sent_message->id }}" id="{{ $sent_message->id }}">
                                <h4 class="list-group-item-heading">
                                    {{ $sent_message->subject }}
                                    <small>Sent To: {{ $sent_message->get_receiver->company_name or 'Admin' }}</small>
                                    <small class="pull-right">{{ $sent_message->updated_at }}</small>
                                </h4>
                            </a>
                        </div>
                        <div class="modal fade" role="dialog" id="message_form_{{ $sent_message->id }}">
                            <div class="modal-dialog" role="document">
                                <form class="form-horizontal" action="/message/send_reply_message" method="POST" enctype="multipart/form-data">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title">Message</h4>
                                        </div>
                                        <div class="modal-body">
                                            <h4>{{ $sent_message->subject }}</h4>
                                            <p>
                                                <i>
                                                    <small>Self</small>
                                                </i>
                                                <small class="pull-right">{{ $sent_message->updated_at }}</small>
                                            </p>
                                            <div class="clearfix"></div>
                                            <p>{{ $sent_message->description }}</p>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="message_type" value="Reply">
                                            <input type="hidden" name="reply_to" value="{{ $sent_message->id }}">
                                            <input type="hidden" name="receiver_id" value="{{ $sent_message->receiver }}">
                                            <input type="hidden" name="subject" value="{{ 'Re:'.$sent_message->subject }}">
                                            <input type="hidden" name="sender_id" value="{{ $sent_message->sender }}">
                                        </div>
                                        <div class="clearfix"></div>
                                        <hr>
                                        @if(count($sent_message->reply_messages_list) > 0)
                                            @foreach($sent_message->reply_messages_list as $reply_message)
                                                <div class="col-sm-12">
                                                    <p>
                                                        <i>
                                                            <small>
                                                                @if($reply_message['sender'] !== $sent_message->sender)
                                                                    {{ $sent_message->get_receiver->company_name or 'Admin' }}
                                                                @else
                                                                    {{ 'Self' }}
                                                                @endif
                                                            </small>
                                                            <small class="pull-right">{{ $reply_message['updated_at'] }}</small>
                                                        </i>
                                                    </p>
                                                    <div class="clearfix"></div>
                                                    <p>{{ $reply_message['description'] }}</p>
                                                </div>
                                                <div class="clearfix"></div>
                                                <hr>
                                            @endforeach
                                        @endif
                                        <div class="col-sm-12">
                                            <label class="control-label">Reply</label>
                                            <textarea class="form-control" style="resize: vertical;" name="description"></textarea>
                                        </div>
                                        <div class="clearfix"></div>
                                        <br>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Reply</button>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </form>
                            </div><!-- /.modal-dialog -->
                        </div>
                    @endforeach
                @else
                    {{ "No messages." }}
                @endif
            </div>
        </div>
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

            $('.unread').click(function(){
                var id = $(this).data('index');
                var data = {'_token': "{{ csrf_token() }}", 'id': $(this).data('index')};
                $.ajax({
                    type: "POST",
                    data: data,
                    url: '/message/read_message',
                    success: function(response)
                    {
                        if(response.status){
                            $('#'+id).removeClass('unread');
                        }else{
                            console.log('Unknown error, cannot mark this message as read.');
                        }

                    }
                });
            });
        });
    </script>
@endsection