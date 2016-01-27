@extends('app')
@section('content')
    <h4>Reports</h4>
    <div class="clearfix"></div>
    <hr>
    <div class="col-sm-12">
        <div class="form-group">
            <label class="col-sm-1 control-label text-right">From</label>
            <div class="col-sm-2">
                <div class='input-group date' id='from_date'>
                    <input type='text' class="form-control" name="date" id="from"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>

            <label class="col-sm-1 control-label text-right">To</label>
            <div class="col-sm-2">
                <div class='input-group date' id='to_date'>
                    <input type='text' class="form-control" name="date" id="to"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>

            <label class="col-sm-2 control-label text-right">Report Type</label>
            <div class="col-sm-4">
                <select id="report_type" class="form-control">
                    <option value="0">Select A Type</option>
                    @can('non-outward-user')
                    <option value="1">Job Management</option>
                    <option value="2">Job Performance</option>
                    <option value="3">Positioning Management</option>
                    <option value="4">Potential Overview</option>
                    @endcan
                    @can('non-inward-user')
                    <option value="5">Target Management</option>
                    <option value="6">Bid Performance</option>
                    <option value="7">Positioning Performance</option>
                    <option value="8">Rating Performance</option>
                    <option value="9">Outsourcing Trend</option>
                    <option value="10">Future Demands</option>
                    @endcan
                </select>
            </div>
            <input type="hidden" name="company_id" id="company_id" value="{{ \Auth::user()->id }}">
        </div>
    </div>
    <div class="clearfix"></div>
    <br>
    <div class="col-sm-12">
        <div class="col-sm-6 form-group">
            @can('globe-admin-above')
            <div class="col-sm-4">
                <label class="control-label">Company Name</label>
            </div>
            <div class="col-sm-8">
                <select class="form-control">
                    @foreach($companies as $company_id => $company_name)
                        <option value="{{ $company_id }}">{{ $company_name }}</option>
                    @endforeach
                </select>
            </div>
            @endcan
        </div>
        <div class="col-sm-6 text-right">
            <a id="generate_report" class="btn btn-success">Generate Report</a>
        </div>
    </div>
    <div class="clearfix"></div>
    <hr>
    <div id="table_list"></div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready( function () {
            $('#from_date').datetimepicker({
                format: 'YYYY-MM-DD'
            });

            $('#to_date').datetimepicker({
                format: 'YYYY-MM-DD'
            });

            $('#generate_report').click(function(){
                var type = $('#report_type').val();
                var from = $('#from').val();
                var to = $('#to').val();
                var company_id = $('#company_id').val();

                if(type == 0){
                    alert("Please select a report type.");
                    return false;
                }

                if(from == null || from == ""){
                    alert("Please enter a valid start date.");
                    return false;
                }

                if(to == null || to == ""){
                    alert("Please enter a valid end date.");
                    return false;
                }

                switch(type) {
                    case "1":
                        report_one(from, to, company_id);
                        break;
                    case "2":
                        report_two(from, to, company_id);
                        break;
                    case "3":
                        report_three(from, to);
                        break;
                    case "4":
                        report_four(from, to, company_id);
                        break;
                    case "5":
                        report_five(from, to, company_id);
                        break;
                    case "6":
                        report_six(from, to, company_id);
                        break;
                    case "7":
                        report_seven(from, to, company_id);
                        break;
                    case "8":
                        report_eight(from, to, company_id);
                        break;
                    case "9":
                        report_nine(from, to, company_id);
                        break;
                    case "10":
                        report_ten(from, to, company_id);
                        break;
                }
            });

            var report_one = function(from, to, company_id){
                var data = {'_method': 'POST',  '_token': "{{ csrf_token() }}", 'start_date':from, 'end_date':to, 'company_id':company_id};
                $.ajax({
                    type: "POST",
                    data: data,
                    url: '/report/job_management',
                    success: function(response)
                    {
                        $("#table_list").empty();
                        $('#table_list').append(response);
                    }
                });
            };

            var report_two = function(from, to, company_id){
                var data = {'_method': 'POST',  '_token': "{{ csrf_token() }}", 'start_date':from, 'end_date':to, 'company_id':company_id};
                $.ajax({
                    type: "POST",
                    data: data,
                    url: '/report/job_performance',
                    success: function(response)
                    {
                        $("#table_list").empty();
                        $('#table_list').append(response);
                    }
                });
            };

            var report_three = function(from, to){
                var data = {'_method': 'POST',  '_token': "{{ csrf_token() }}", 'start_date':from, 'end_date':to};
                $.ajax({
                    type: "POST",
                    data: data,
                    url: '/report/compare_budget',
                    success: function(response)
                    {
                        $("#table_list").empty();
                        $('#table_list').append(response);
                    }
                });
            };

            var report_four = function(from, to, company_id){
                var data = {'_method': 'POST',  '_token': "{{ csrf_token() }}", 'start_date':from, 'end_date':to, 'company_id':company_id};
                $.ajax({
                    type: "POST",
                    data: data,
                    url: '/report/outsource_distribution',
                    success: function(response)
                    {
                        $("#table_list").empty();
                        $('#table_list').append(response);
                    }
                });
            };

            var report_five = function(from, to, company_id){
                var data = {'_method': 'POST',  '_token': "{{ csrf_token() }}", 'start_date':from, 'end_date':to, 'company_id':company_id};
                $.ajax({
                    type: "POST",
                    data: data,
                    url: '/report/target_management',
                    success: function(response)
                    {
                        $("#table_list").empty();
                        $('#table_list').append(response);
                    }
                });
            };

            var report_six = function(from, to, company_id){
                var data = {'_method': 'POST',  '_token': "{{ csrf_token() }}", 'start_date':from, 'end_date':to, 'company_id':company_id};
                $.ajax({
                    type: "POST",
                    data: data,
                    url: '/report/bid_performance',
                    success: function(response)
                    {
                        $("#table_list").empty();
                        $('#table_list').append(response);
                    }
                });
            };

            var report_seven = function(from, to, company_id){
                var data = {'_method': 'POST',  '_token': "{{ csrf_token() }}", 'start_date':from, 'end_date':to, 'company_id':company_id};
                $.ajax({
                    type: "POST",
                    data: data,
                    url: '/report/positioning_performance',
                    success: function(response)
                    {
                        $("#table_list").empty();
                        $('#table_list').append(response);
                    }
                });
            };

            var report_eight = function(from, to, company_id){
                var data = {'_method': 'POST',  '_token': "{{ csrf_token() }}", 'start_date':from, 'end_date':to, 'company_id':company_id};
                $.ajax({
                    type: "POST",
                    data: data,
                    url: '/report/rating_performance',
                    success: function(response)
                    {
                        $("#table_list").empty();
                        $('#table_list').append(response);
                    }
                });
            };

            var report_nine = function(from, to, company_id){
                var data = {'_method': 'POST',  '_token': "{{ csrf_token() }}", 'start_date':from, 'end_date':to, 'company_id':company_id};
                $.ajax({
                    type: "POST",
                    data: data,
                    url: '/report/outsourcing_trend',
                    success: function(response)
                    {
                        $("#table_list").empty();
                        $('#table_list').append(response);
                    }
                });
            };

            var report_ten = function(from, to, company_id){
                var data = {'_method': 'POST',  '_token': "{{ csrf_token() }}", 'start_date':from, 'end_date':to, 'company_id':company_id};
                $.ajax({
                    type: "POST",
                    data: data,
                    url: '/report/lsp_distribution',
                    success: function(response)
                    {
                        $("#table_list").empty();
                        $('#table_list').append(response);
                    }
                });
            };

        } );
    </script>
@endsection