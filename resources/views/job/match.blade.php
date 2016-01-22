@extends('app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <h3 class="pull-left">Top matches of LSP for this job</h3>
        </div>
        @if(count($companies) > 0)
        <table id="lsp_table" class="display">
            <thead>
            <tr>
                <th>Company Name</th>
                <th>Requirements</th>
                <th>Features</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
                @foreach($companies as $company)
                    <tr>
                        <td><a href="/company/{{ $company['id'] }}" target="_blank">{{ $company['company_name'] }}</a></td>
                        <td>
                            @if(count($company['requirements']) > 0)
                                @foreach($company['requirements'] as $requirement)
                                    <p>{{ $requirement['requirement'] }}</p>
                                @endforeach
                            @endif
                        </td>
                        <td>
                            @if(count($company['features']) > 0)
                                @foreach($company['features'] as $feature)
                                    <p>{{ $feature['feature'] }}</p>
                                @endforeach
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#new_message_form" data-recipient="{{ $company['company_name'] }}" data-companyid="{{ $company['id'] }}">Invite LSP to bid</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

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
                                        <select name="receiver_id" class="form-control" id="company_list">
                                            @if(count($companies) > 0)
                                                @foreach($companies as $company_key => $company)
                                                    @if($company['id'] != \Auth::user()->company_id)
                                                        <option value="{{ $company['id'] }}">{{ $company['company_name'] }}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group required">
                                    <label class="col-md-4 control-label">Subject</label>
                                    <div class="col-md-6">
                                        <input type='text' class="form-control" name="subject" value="Bidsystem - You are invited to bid for a job" required/>
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
                                        <input type="checkbox" name="create_appointment" id="show_appointment" value="1"> Create Appointment
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

        @else
            <h4>There's no suitable matches.</h4>
        @endif
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready( function () {
            $('.appointment_field').hide();

            $('#lsp_table').DataTable({
                "paging":   false
            });

            $('#date').datetimepicker({
                format: 'DD-MM-YYYY HH:mm'
            });

            $('#new_message_form').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var recipient = button.data('recipient');
                var company_id = button.data('companyid');
                var modal = $(this);
                modal.find('.modal-title').text('Invite ' + recipient);
                modal.find('.modal-body #company_list').val(company_id);
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