@extends('app')
@section('content')
    <div class="col-sm-12">
        <h4>Select LSP to compare</h4>
        <div class="clearfix"></div>
        <hr>
        <form method="post" enctype="multipart/form-data" id="compare_form">
            @if(count($job) > 0 && count($job->valid_bids) > 0)
                @foreach($job->valid_bids as $bid)
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" class="bids" name="bids_id" value="{{ $bid->id }}">
                            {{ $bid->company->company_name }}
                        </label>
                    </div>
                @endforeach
            @else
                <h5>No available LSPs.</h5>
            @endif
        <div class="clearfix"></div>
        <hr>
        <a class="btn btn-success" id="compare">Compare</a>
        </form>
        <div class="clearfix"></div>
        <br>
        <div class="report_div"></div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#compare').click(function(){
                var bids_id = [];
                $.each($("input[name='bids_id']:checked"), function(){
                    bids_id.push($(this).val());
                });

                var data = {'_method': 'POST',  '_token': "{{ csrf_token() }}", 'bids_id':bids_id, 'job_id': '{{ $job->id }}'};
                $.ajax({
                    type: "POST",
                    data: data,
                    url: '/report/compare_report',
                    success: function(response)
                    {
                        $(".report_div").empty();
                        $(".report_div").append(response);
                    }
                });
            });
        });
    </script>
@endsection