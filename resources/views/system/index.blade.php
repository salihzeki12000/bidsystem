@extends('app')
@section('content')
    <div class="center">
        <div class="col-sm-12">
            <div class="panel-group" id="industry" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#industry" href="#industry_collapse" aria-expanded="true" aria-controls="industry_collapse">
                                <h4>
                                    Industry
                                </h4>
                            </a>
                        </h4>
                    </div>
                    <div id="industry_collapse" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body industry">
                            @if(count($industries) > 0)
                                <ul class="list-group">
                                    @foreach($industries as $industry_key => $industry)
                                        <div id="industry_div_{{ $industry_key }}">
                                            <input name="industry" value="{{ $industry }}" id="industry_{{ $industry_key }}" />
                                            <a class="btn btn-sm btn-primary edit_btn" data-type="industry" data-id="{{ $industry_key }}">Save</a>
                                            <a class="btn btn-sm btn-danger delete_btn" data-type="industry" data-id="{{ $industry_key }}">Delete</a>
                                            <div class="clearfix"></div>
                                            <br>
                                        </div>
                                    @endforeach
                                </ul>
                            @endif
                            <a class="btn btn-sm btn-default add_btn" data-type="industry">Add</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="panel-group" id="highlight" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#highlight" href="#highlight_collapse" aria-expanded="true" aria-controls="highlight_collapse">
                                <h4>
                                    Highlight
                                </h4>
                            </a>
                        </h4>
                    </div>
                    <div id="highlight_collapse" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body highlight">
                            @if(count($highlights) > 0)
                                <ul class="list-group">
                                    @foreach($highlights as $highlight_key => $highlight)
                                        <div id="highlight_div_{{ $highlight_key }}">
                                            <input name="highlight" value="{{ $highlight }}" id="highlight_{{ $highlight_key }}" />
                                            <a class="btn btn-sm btn-primary edit_btn" data-type="highlight" data-id="{{ $highlight_key }}">Save</a>
                                            <a class="btn btn-sm btn-danger delete_btn" data-type="highlight" data-id="{{ $highlight_key }}">Delete</a>
                                            <div class="clearfix"></div>
                                            <br>
                                        </div>
                                    @endforeach
                                </ul>
                            @endif
                            <a class="btn btn-sm btn-default add_btn" data-type="highlight">Add</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-sm-12">
            <div class="panel-group" id="potential" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#potential" href="#potential_collapse" aria-expanded="true" aria-controls="potential_collapse">
                                <h4>
                                    Potential
                                </h4>
                            </a>
                        </h4>
                    </div>
                    <div id="potential_collapse" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body potential">
                            @if(count($potentials) > 0)
                                <ul class="list-group">
                                    @foreach($potentials as $potential_key => $potential)
                                        <div id="potential_div_{{ $potential_key }}">
                                            <input name="potential" value="{{ $potential }}" id="potential_{{ $potential_key }}" />
                                            <a class="btn btn-sm btn-primary edit_btn" data-type="potential" data-id="{{ $potential_key }}">Save</a>
                                            <a class="btn btn-sm btn-danger delete_btn" data-type="potential" data-id="{{ $potential_key }}">Delete</a>
                                            <div class="clearfix"></div>
                                            <br>
                                        </div>
                                    @endforeach
                                </ul>
                            @endif
                            <a class="btn btn-sm btn-default add_btn" data-type="potential">Add</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-sm-12">
            <div class="panel-group" id="location" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#location" href="#location_collapse" aria-expanded="true" aria-controls="location_collapse">
                                <h4>
                                    Location
                                </h4>
                            </a>
                        </h4>
                    </div>
                    <div id="location_collapse" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body location">
                            @if(count($locations) > 0)
                                <ul class="list-group">
                                    @foreach($locations as $location)
                                        <div id="location_div_{{ $location->id }}">
                                            <input name="town" value="{{ $location->town }}" id="town_{{ $location->id }}" type="text"/>
                                            <input name="state" value="{{ $location->state }}" id="state_{{ $location->id }}" type="text"/>
                                            <input name="country" value="{{ $location->country }}" id="country_{{ $location->id }}" type="text"/>
                                            <input name="postcode" value="{{ $location->postcode }}" id="postcode_{{ $location->id }}" type="number"/>
                                            <a class="btn btn-sm btn-primary edit_btn" data-type="location" data-id="{{ $location->id }}">Save</a>
                                            <a class="btn btn-sm btn-danger delete_btn" data-type="location" data-id="{{ $location->id }}">Delete</a>
                                            <div class="clearfix"></div>
                                            <br>
                                        </div>
                                    @endforeach
                                </ul>
                            @endif
                            <a class="btn btn-sm btn-default add_btn" data-type="location">Add</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-sm-12">
            <div class="panel-group" id="requirement" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#requirement" href="#requirement_collapse" aria-expanded="true" aria-controls="requirement_collapse">
                                <h4>
                                    Requirement
                                </h4>
                            </a>
                        </h4>
                    </div>
                    <div id="requirement_collapse" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body requirement">
                            @if(count($requirements) > 0)
                                <ul class="list-group">
                                    @foreach($requirements as $requirement_key => $requirement)
                                        <div id="requirement_div_{{ $requirement_key }}">
                                            <input name="requirement" value="{{ $requirement }}" id="requirement_{{ $requirement_key }}" />
                                            <a class="btn btn-sm btn-primary edit_btn" data-type="requirement" data-id="{{ $requirement_key }}">Save</a>
                                            <a class="btn btn-sm btn-danger delete_btn" data-type="requirement" data-id="{{ $requirement_key }}">Delete</a>
                                            <div class="clearfix"></div>
                                            <br>
                                        </div>
                                    @endforeach
                                </ul>
                            @endif
                            <a class="btn btn-sm btn-default add_btn" data-type="requirement">Add</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-sm-12">
            <div class="panel-group" id="ticket" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#ticket" href="#ticket_collapse" aria-expanded="true" aria-controls="ticket_collapse">
                                <h4>
                                    Ticket Category
                                </h4>
                            </a>
                        </h4>
                    </div>
                    <div id="ticket_collapse" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body ticket">
                            @if(count($industries) > 0)
                                <ul class="list-group">
                                    @foreach($ticket_categories as $ticket_category_key => $ticket_category)
                                        <div id="ticket_div_{{ $ticket_category_key }}">
                                            <input name="ticket" value="{{ $ticket_category }}" id="ticket_{{ $ticket_category_key }}" />
                                            <a class="btn btn-sm btn-primary edit_btn" data-type="ticket" data-id="{{ $ticket_category_key }}">Save</a>
                                            <a class="btn btn-sm btn-danger delete_btn" data-type="ticket" data-id="{{ $ticket_category_key }}">Delete</a>
                                            <div class="clearfix"></div>
                                            <br>
                                        </div>
                                    @endforeach
                                </ul>
                            @endif
                            <a class="btn btn-sm btn-default add_btn" data-type="ticket">Add</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-sm-12">
            <div class="panel-group" id="appointment" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#appointment" href="#appointment_collapse" aria-expanded="true" aria-controls="appointment_collapse">
                                <h4>
                                    Appointment Objectives
                                </h4>
                            </a>
                        </h4>
                    </div>
                    <div id="appointment_collapse" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body appointment">
                            @if(count($appointment_objectives) > 0)
                                <ul class="list-group">
                                    @foreach($appointment_objectives as $appointment_objective_key => $appointment_objective)
                                        <div id="appointment_div_{{ $appointment_objective->id }}">
                                            <input name="appointment" value="{{ $appointment_objective->app_objective }}" id="appointment_{{ $appointment_objective->id }}" />
                                            <a class="btn btn-sm btn-primary edit_btn" data-type="appointment" data-id="{{ $appointment_objective->id }}">Save</a>
                                            <a class="btn btn-sm btn-danger delete_btn" data-type="appointment" data-id="{{ $appointment_objective->id }}">Delete</a>
                                            <div class="clearfix"></div>
                                            <br>
                                        </div>
                                    @endforeach
                                </ul>
                            @endif
                            <a class="btn btn-sm btn-default add_btn" data-type="appointment">Add</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready( function () {
            var counter = 1;
            function tempAlert(msg,duration)
            {
                var el = document.createElement("div");
                el.setAttribute("style","position:fixed;top:50%;left:50%;");
                el.setAttribute("class","alert alert-success");
                el.setAttribute("role","alert");
                el.innerHTML = msg;
                setTimeout(function(){
                    el.parentNode.removeChild(el);
                },duration);
                document.body.appendChild(el);
            }

            $('.add_btn').click(function(){
                var type = $(this).data('type');
                var input = '';
                switch (type) {
                    case 'location':
                        input = "<div id='new_"+type+"_div_"+counter+"'><div class='clearfix'></div><br><input name='town' type='text' id='new_town_"+counter+"' placeholder='Town' /> <input name='state' type='text' id='new_state_"+counter+"' placeholder='State' /> <input name='country' type='text' id='new_country_"+counter+"' placeholder='Country'/> <input name='postcode' type='number' id='new_postcode_"+counter+"' placeholder='Postcode'/> <a class='btn btn-sm btn-primary save_btn' data-id='"+counter+"' data-type='"+type+"'>Save</a></div>";
                        counter++;
                        break;
                    default:
                        input = "<div id='new_"+type+"_div_"+counter+"'><div class='clearfix'></div><br><input name='"+type+"' type='text' id='"+counter+"' /> <a class='btn btn-sm btn-primary save_btn' data-id='"+counter+"' data-type='"+type+"'>Save</a></div>";
                        counter++;
                        break;
                }
                $('.'+type).append(input);
            });


            $('body').on('click', 'a.edit_btn', function() {
                var type = $(this).data('type');
                var id = $(this).data('id');
                var data = null;

                switch (type) {
                    case 'location':
                        var town = $('#town_'+id).val();
                        var state = $('#state_'+id).val();
                        var country = $('#country_'+id).val();
                        var postcode = $('#postcode_'+id).val();
                        data = {'_method': 'POST',  '_token': "{{ csrf_token() }}", 'type':type, 'id':id, 'town':town, 'state':state, 'country':country, 'postcode':postcode};
                        break;
                    default:
                        var content = $('#'+type+'_'+id).val();
                        data = {'_method': 'POST',  '_token': "{{ csrf_token() }}", 'type':type, 'id':id, 'value':content};
                        break;
                }

                $.ajax({
                    type: "POST",
                    data: data,
                    url: '/system/edit',
                    success: function(response)
                    {
                        if(response.status){
                            tempAlert("Saved!",2000);
                        }else{
                            alert('Unknown error, cannot edit value.');
                        }
                    }
                });
            });

            $('body').on('click', 'a.delete_btn', function() {
                var type = $(this).data('type');
                var id = $(this).data('id');
                var data = {'_method': 'POST',  '_token': "{{ csrf_token() }}", 'type':type, 'id':id};
                $.ajax({
                    type: "POST",
                    data: data,
                    url: '/system/delete',
                    success: function(response)
                    {
                        if(response.status){
                            tempAlert("Deleted!",2000);
                            $('#'+type+'_div_'+id).remove();
                        }else{
                            alert('Unknown error, cannot delete value.');
                        }
                    }
                });
            });


            $('body').on('click', 'a.save_btn', function() {
                var type = $(this).data('type');
                var index = $(this).data('id');
                var current_element = $(this);
                var data = null;

                switch (type) {
                    case 'location':
                        var town = $('#new_town_'+index).val();
                        var state = $('#new_state_'+index).val();
                        var country = $('#new_country_'+index).val();
                        var postcode = $('#new_postcode_'+index).val();
                        data = {'_method': 'POST',  '_token': "{{ csrf_token() }}", 'type':type, 'town':town, 'state':state, 'country':country, 'postcode':postcode};
                        break;
                    default:
                        var content = $('#'+index).val();
                        data = {'_method': 'POST',  '_token': "{{ csrf_token() }}", 'type':type, 'value':content};
                        break;
                }
                $.ajax({
                    type: "POST",
                    data: data,
                    url: '/system/add',
                    success: function(response)
                    {
                        if(response.status){
                            tempAlert("Saved!",2000);
                            current_element.addClass('edit_btn');
                            current_element.removeClass('save_btn');
                            current_element.data('id', response.id);
                            if(type != 'location'){
                                $('#'+index).attr("id",type+'_'+response.id);
                            }else{
                                $('#new_town_'+index).attr("id",'town_'+response.id);
                                $('#new_state_'+index).attr("id",'state_'+response.id);
                                $('#new_country_'+index).attr("id",'country_'+response.id);
                                $('#new_postcode_'+index).attr("id",'postcode_'+response.id);
                            }
                            $('#new_'+type+'_div_'+index).attr("id", type+'_div_'+response.id);
                            var delete_btn = " <a class='btn btn-sm btn-danger delete_btn' data-type='"+type+"' data-id='"+response.id+"'>Delete</a>";
                            $('#'+type+'_div_'+response.id).append(delete_btn);
                        }else{
                            alert('Unknown error, cannot save value.');
                        }
                    }
                });
            });

        } );
    </script>
@endsection