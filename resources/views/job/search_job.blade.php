@extends('app')

@section('style')
    <script type="text/javascript" src="/js/sumoselect.min.js"></script>
    <link rel="stylesheet" href="/css/sumoselect.css" />
@endsection

@section('content')
    <div class="center-block">
        <div class="col-sm-8 col-sm-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Search Job</div>
                <div class="panel-body">
                    <form action="/show_search_job_result" role="form" method="POST" enctype="multipart/form-data" id="search_form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Keyword</label>
                            <div class="col-sm-8">
                                <input type="text" name="keyword" class="form-control" id="keyword_val" value=""/>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <br>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Location</label>
                            <div class="col-sm-8">
                                <select name="location[]" class="SlectBox" multiple id="state">
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}">{{ $location->town.' '.$location->state.' '.$location->country.' '.$location->postcode }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Industries</label>
                            <div class="col-sm-8">
                                <select name="industry[]" class="SlectBox" multiple id="industry">
                                    @foreach($industries as $industry_key => $industry)
                                        <option value="{{ $industry_key }}">{{ $industry }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Requirements</label>
                            <div class="col-sm-8">
                                <select name="requirement[]" class="SlectBox" multiple id="requirement">
                                    @foreach($requirements as $requirement)
                                        <option value="{{ $requirement->id }}">{{ $requirement->requirement }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        <button type="submit" class="btn btn-primary pull-right">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready( function () {
            $('.SlectBox').SumoSelect({
                selectAll : true,
                selectAlltext : 'Select All'
            });

            $('#search_form').submit(function(ev) {
                ev.preventDefault();

                if( $('#state').val() == null && $('#industry').val() == null && $('#requirement').val() == null && $.trim($('#keyword_val').val()) == ''){
                    alert("Your search criteria cannot be empty.");
                    return false;
                }else{
                    this.submit();
                }
            });
        });
    </script>
@endsection