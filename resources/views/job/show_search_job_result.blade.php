@extends('app')

@section('style')
    <script type="text/javascript" src="/js/sumoselect.min.js"></script>
    <link rel="stylesheet" href="/css/sumoselect.css" />
@endsection

@section('content')
    <div class="col-sm-10 col-sm-offset-1">
        <p>Results for jobs containing: <a class="btn btn-sm btn-success pull-right" href="/search_job">Search Again</a></p>
        @if(!empty($keyword))
            <p>Keyword: <b>{{ $keyword }}</b> </p>
        @endif

        @if(count($search_locations) > 0)
            <br>
            <p>Location:</p>
            @foreach($search_locations as $location)
                <p><b>{{ $location->town.' '.$location->state.' '.$location->country.' '.$location->postcode }}</b></p>
            @endforeach
        @endif

        @if(count($search_industries) > 0)
            <br>
            <p>Industry:</p>
            @foreach($search_industries as $industry)
                <p><b>{{ $industry }}</b></p>
            @endforeach
        @endif

        @if(count($search_requirements) > 0)
            <br>
            <p>Requirement:</p>
            @foreach($search_requirements as $requirement)
                <p><b>{{ $requirement }}</b></p>
            @endforeach
        @endif

        <div class="clearfix"></div>
        <hr>
        @if(count($jobs) > 0 && !$return_empty_result)
            @foreach($jobs as $job)
                <p><b><a class="btn btn-primary" href="job/{{ $job->id }}" target="_blank">View Job Detail</a></b></p>
                <p>Location: {{ $job->location->town.' '.$job->location->state.' '.$job->location->country.' '.$job->location->postcode }}</p>
                <p>Requirements:
                    @foreach($job->requirements as $count => $individual_requirement)
                        @if($count == (count($job->requirements) - 1))
                            {{ $individual_requirement->requirement }}
                        @else
                            {{ $individual_requirement->requirement.', ' }}
                        @endif
                    @endforeach
                </p>
                <div class="clearfix"></div>
                <hr>
            @endforeach
        @else
            <h4>No jobs found.</h4>
        @endif
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready( function () {

        });
    </script>
@endsection