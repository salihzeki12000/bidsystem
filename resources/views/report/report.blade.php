@extends('app')
@section('content')
    <a class="btn btn-sm btn-success" id="report_1">Report 1</a>
    <a class="btn btn-sm btn-success" id="report_2">Report 2</a>
    <a class="btn btn-sm btn-success" id="report_3">Report 3</a>
    <a class="btn btn-sm btn-success" id="report_4">Report 4</a>
    <a class="btn btn-sm btn-success" id="report_5">Report 5</a>
    <a class="btn btn-sm btn-success" id="report_6">Report 6</a>
    <a class="btn btn-sm btn-success" id="report_7">Report 7</a>
    <a class="btn btn-sm btn-success" id="report_8">Report 8</a>
    <a class="btn btn-sm btn-success" id="report_9">Report 9</a>
    <a class="btn btn-sm btn-success" id="report_10">Report 10</a>
    <div id="table_list"></div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready( function () {
            $('#report_1').click(function(){
                var data = {'_method': 'POST',  '_token': "{{ csrf_token() }}", 'start_date':'2015-12-01 17:00:39', 'end_date':'2015-12-30 17:00:39', 'company_id':'1'};
                $.ajax({
                    type: "POST",
                    data: data,
                    url: '/report/job_management',
                    success: function(response)
                    {
                        $('#table_list').append(response);
                    }
                });
            });

            $('#report_2').click(function(){
                var data = {'_method': 'POST',  '_token': "{{ csrf_token() }}", 'start_date':'2015-12-01 17:00:39', 'end_date':'2015-12-30 17:00:39', 'company_id':'1'};
                $.ajax({
                    type: "POST",
                    data: data,
                    url: '/report/job_performance',
                    success: function(response)
                    {
                        $('#table_list').append(response);
                    }
                });
            });

            $('#report_3').click(function(){
                var data = {'_method': 'POST',  '_token': "{{ csrf_token() }}", 'start_date':'2015-12-01 17:00:39', 'end_date':'2015-12-30 17:00:39'};
                $.ajax({
                    type: "POST",
                    data: data,
                    url: '/report/compare_budget',
                    success: function(response)
                    {
                        $('#table_list').append(response);
                    }
                });
            });

            $('#report_4').click(function(){
                var data = {'_method': 'POST',  '_token': "{{ csrf_token() }}", 'start_date':'2015-12-01 17:00:39', 'end_date':'2015-12-30 17:00:39', 'company_id':'1'};
                $.ajax({
                    type: "POST",
                    data: data,
                    url: '/report/outsource_distribution',
                    success: function(response)
                    {
                        $('#table_list').append(response);
                    }
                });
            });

            $('#report_5').click(function(){
                var data = {'_method': 'POST',  '_token': "{{ csrf_token() }}", 'start_date':'2015-12-01 17:00:39', 'end_date':'2015-12-30 17:00:39', 'company_id':'2'};
                $.ajax({
                    type: "POST",
                    data: data,
                    url: '/report/target_management',
                    success: function(response)
                    {
                        $('#table_list').append(response);
                    }
                });
            });

            $('#report_6').click(function(){
                var data = {'_method': 'POST',  '_token': "{{ csrf_token() }}", 'start_date':'2015-12-01 17:00:39', 'end_date':'2015-12-30 17:00:39', 'company_id':'2'};
                $.ajax({
                    type: "POST",
                    data: data,
                    url: '/report/bid_performance',
                    success: function(response)
                    {
                        $('#table_list').append(response);
                    }
                });
            });

            $('#report_7').click(function(){
                var data = {'_method': 'POST',  '_token': "{{ csrf_token() }}", 'start_date':'2015-12-01 17:00:39', 'end_date':'2015-12-30 17:00:39', 'company_id':'2'};
                $.ajax({
                    type: "POST",
                    data: data,
                    url: '/report/positioning_performance',
                    success: function(response)
                    {
                        $('#table_list').append(response);
                    }
                });
            });

            $('#report_8').click(function(){
                var data = {'_method': 'POST',  '_token': "{{ csrf_token() }}", 'start_date':'2015-12-01 17:00:39', 'end_date':'2015-12-30 17:00:39', 'company_id':'2'};
                $.ajax({
                    type: "POST",
                    data: data,
                    url: '/report/rating_performance',
                    success: function(response)
                    {
                        $('#table_list').append(response);
                    }
                });
            });

            $('#report_9').click(function(){
                var data = {'_method': 'POST',  '_token': "{{ csrf_token() }}", 'start_date':'2015-12-01 17:00:39', 'end_date':'2016-12-30 17:00:39', 'company_id':'1'};
                $.ajax({
                    type: "POST",
                    data: data,
                    url: '/report/outsourcing_trend',
                    success: function(response)
                    {
                        $('#table_list').append(response);
                    }
                });
            });

            $('#report_10').click(function(){
                var data = {'_method': 'POST',  '_token': "{{ csrf_token() }}", 'start_date':'2015-12-01 17:00:39', 'end_date':'2015-12-30 17:00:39', 'company_id':'2'};
                $.ajax({
                    type: "POST",
                    data: data,
                    url: '/report/lsp_distribution',
                    success: function(response)
                    {
                        $('#table_list').append(response);
                    }
                });
            });
        } );
    </script>
@endsection