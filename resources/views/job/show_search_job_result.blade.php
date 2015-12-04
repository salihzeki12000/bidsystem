@extends('app')

@section('style')
    <script type="text/javascript" src="/js/sumoselect.min.js"></script>
    <link rel="stylesheet" href="/css/sumoselect.css" />
@endsection

@section('content')
    <div class="col-sm-6 col-sm-offset-3">
        <p>Results for jobs containing: </p>
        <p>State:
            <b>
                @foreach($states as $state_key => $state)
                    @if($state_key == (count($states) - 1))
                        {{ $state }}
                    @else
                        {{ $state.', ' }}
                    @endif
                @endforeach
            </b>
        </p>
        <p>Requirement:
            <b>
                @foreach($requirements as $requirement_key => $requirement)
                    @if($requirement_key == (count($requirements) - 1))
                        {{ $requirement }}
                    @else
                        {{ $requirement.', ' }}
                    @endif
                @endforeach
            </b>
        </p>
        <div class="clearfix"></div>
        <hr>
        @if(count($jobs) > 0)
            @foreach($jobs as $job)
                <p>Job ID: <a href="job/{{ $job->id }}">{{ $job->id }}</a></p>
                <p>Location: {{ $job->location->town.' '.$job->location->state.' '.$job->location->country }}</p>
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