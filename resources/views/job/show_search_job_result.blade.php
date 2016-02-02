@extends('app')

@section('inside-style')
    a.morelink {
    text-decoration:none;
    outline: none;
    }
    .morecontent span {
    display: none;
    }
    .comment {
    width: 400px;
    background-color: #f0f0f0;
    margin: 10px;
    }
@endsection

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
            <p class="more">
                @foreach($search_locations as $location)
                    {{ $location->town.' '.$location->state.' '.$location->country.' '.$location->postcode.';' }}
                @endforeach
            </p>
        @endif

        @if(count($search_industries) > 0)
            <br>
            <p>Industry:</p>
            <p class="more">
                @foreach($search_industries as $industry)
                    {{ $industry.';' }}
                @endforeach
            </p>
        @endif

        @if(count($search_requirements) > 0)
            <br>
            <p>Requirement:</p>
            <p class="more">
                @foreach($search_requirements as $requirement)
                    {{ $requirement.';' }}
                @endforeach
            </p>
        @endif

        <div class="clearfix"></div>
        <hr>
        @if(count($jobs) > 0 && !$return_empty_result)
            @foreach($jobs as $job)
                <div class="col-sm-2">
                    <img src="{{ $job->company_logo->logo }}" width="100%">
                </div>
                <div class="col-sm-8">
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
                </div>
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
            var showChar = 300;
            var ellipsestext = "...";
            var moretext = "Show all";
            var lesstext = "Show less";

            $('.more').each(function() {
                var content = $(this).html();
                if(content.length > showChar) {

                    var c = content.substr(0, showChar);
                    var h = content.substr(showChar-1, content.length - showChar);

                    var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

                    $(this).html(html);
                }

            });

            $(".morelink").click(function(){
                if($(this).hasClass("less")) {
                    $(this).removeClass("less");
                    $(this).html(moretext);
                } else {
                    $(this).addClass("less");
                    $(this).html(lesstext);
                }
                $(this).parent().prev().toggle();
                $(this).prev().toggle();
                return false;
            });
        });
    </script>
@endsection