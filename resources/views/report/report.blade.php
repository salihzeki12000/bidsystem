@extends('app')
@section('content')
    <h4>Reports</h4>
    <div class="clearfix"></div>
    <hr>
    <form method="post" action="/report/export_report" enctype="multipart/form-data" id="excel_form">
        <input type="hidden" name="_method" value="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="export_type" value="csv" id="export_type_field">
        <div class="col-sm-12">
            <div class="form-group">
                <label class="col-sm-1 control-label text-right">From</label>
                <div class="col-sm-2">
                    <div class='input-group date' id='from_date'>
                        <input type='text' class="form-control" name="start_date" id="from"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                    </div>
                </div>

                <label class="col-sm-1 control-label text-right">To</label>
                <div class="col-sm-2">
                    <div class='input-group date' id='to_date'>
                        <input type='text' class="form-control" name="end_date" id="to"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                    </div>
                </div>

                <label class="col-sm-2 control-label text-right">Report Type</label>
                <div class="col-sm-4">
                    <select id="report_type" class="form-control" name="report_type">
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
                @can('non-system-admin')
                <input type="hidden" name="company_id" id="company_id" value="{{ \Auth::user()->company_id }}">
                @endcan
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
                    <select class="form-control" name="company_id" id="company_id">
                        @foreach($companies as $company_id => $company_name)
                            <option value="{{ $company_id }}">{{ $company_name }}</option>
                        @endforeach
                    </select>
                </div>
                @endcan
            </div>
            <div class="col-sm-6 text-right">
                <a id="generate_report" class="btn btn-success generate_report" data-export="report">Generate Report</a>
                <button type="submit" class="btn btn-primary" data-export="csv" id="export">Export As Excel</button>
            </div>
        </div>
    </form>

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

            $('#excel_form').submit(function(ev) {
                ev.preventDefault();
                var report_type = $('#report_type').val();
                var from = $('#from').val();
                var to = $('#to').val();
                var export_type = $('#export_type_field').val();

                if(report_type == 0){
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

                if(export_type == null || export_type == ""){
                    alert("Invalid export type.");
                    return false;
                }

                this.submit();
            });

            $('.generate_report').click(function(){
                var report_type = $('#report_type').val();
                var from = $('#from').val();
                var to = $('#to').val();
                var company_id = $('#company_id').val();
                var export_type = $(this).data('export');

                if(report_type == 0){
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

                report(from, to, company_id, export_type, report_type);
            });

            var report = function(from, to, company_id, export_type, report_type){
                var data = {'_method': 'POST',  '_token': "{{ csrf_token() }}", 'start_date':from, 'end_date':to, 'company_id':company_id, 'export_type': export_type, 'report_type':report_type};
                $.ajax({
                    type: "POST",
                    data: data,
                    url: '/report/export_report',
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