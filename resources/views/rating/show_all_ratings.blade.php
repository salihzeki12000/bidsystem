@extends('app')

@section('style')
    <style>
        @charset "UTF-8";
        .star-cb-group {
            /* remove inline-block whitespace */
            font-size: 0;
            /* flip the order so we can use the + and ~ combinators */
            unicode-bidi: bidi-override;
            direction: rtl;
            /* the hidden clearer */
        }
        .star-cb-group * {
            font-size: 2rem;
        }
        .star-cb-group > input {
            display: none;
        }
        .star-cb-group > input + label {
            /* only enough room for the star */
            display: inline-block;
            overflow: hidden;
            text-indent: 9999px;
            width: 1em;
            white-space: nowrap;
            cursor: pointer;
        }
        .star-cb-group > input + label:before {
            display: inline-block;
            text-indent: -9999px;
            content: "☆";
            color: #888;
        }
        .star-cb-group > input:checked ~ label:before {
            content: "★";
            color: #FFEB42;
            text-shadow: 0 0 1px #333;
        }
        .star-cb-group > .star-cb-clear + label {
            text-indent: -9999px;
            width: .5em;
            margin-left: -.5em;
        }
        .star-cb-group > .star-cb-clear + label:before {
            width: .5em;
        }
    </style>
@endsection

@section('content')
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>{{ $company->company_name }} <small>Overview</small></h4>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Cost and Competitiveness</label>
                    <div class="col-sm-6">
                        <p><b>{{ round($rating_averages->c, 2) }}</b></p>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Environmental Responsible</label>
                    <div class="col-sm-6">
                        <p><b>{{ round($rating_averages->e, 2) }}</b></p>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Technology</label>
                    <div class="col-sm-6">
                        <p><b>{{ round($rating_averages->t, 2) }}</b></p>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Responsiveness</label>
                    <div class="col-sm-6">
                        <p><b>{{ round($rating_averages->r, 2) }}</b></p>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Assurance</label>
                    <div class="col-sm-6">
                        <p><b>{{ round($rating_averages->a, 2) }}</b></p>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Quality</label>
                    <div class="col-sm-6">
                        <p><b>{{ round($rating_averages->q, 2) }}</b></p>
                    </div>
                </div>
            </div>
        </div>

        @if(count($company->ratings) > 0)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Recent Ratings</h4>
                </div>
                <div class="panel-body" id="panel_body">
                    @foreach($company->ratings as $rating)
                        <div class="rating_div">
                            <div class="form-group">
                                <label>Rate by <span style="text-decoration: underline">{{ $rating->creator_company->company_name or 'Admin'}}</span></label>
                                <small class="pull-right">{{ $rating->updated_at }}</small>
                            </div>
                            <div class="clearfix"></div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Cost and Competitiveness</label>
                                <div class="col-sm-6">
                        <span class="star-cb-group">
                          <input type="radio" id="crating" name="c-{{ $rating->id }}" value="5" @if($rating->c == 5) checked @endif disabled/><label for="crating">5</label>
                          <input type="radio" id="crating" name="c-{{ $rating->id }}" value="4" @if($rating->c == 4) checked @endif disabled/><label for="crating">4</label>
                          <input type="radio" id="crating" name="c-{{ $rating->id }}" value="3" @if($rating->c == 3) checked @endif disabled/><label for="crating">3</label>
                          <input type="radio" id="crating" name="c-{{ $rating->id }}" value="2" @if($rating->c == 2) checked @endif disabled/><label for="crating">2</label>
                          <input type="radio" id="crating" name="c-{{ $rating->id }}" value="1" @if($rating->c == 1) checked @endif disabled/><label for="crating">1</label>
                        </span>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Environmental Responsible</label>
                                <div class="col-sm-6">
                        <span class="star-cb-group">
                          <input type="radio" id="erating" name="e-{{ $rating->id }}" value="5" @if($rating->e == 5) checked @endif disabled/><label for="erating">5</label>
                          <input type="radio" id="erating" name="e-{{ $rating->id }}" value="4" @if($rating->e == 4) checked @endif disabled/><label for="erating">4</label>
                          <input type="radio" id="erating" name="e-{{ $rating->id }}" value="3" @if($rating->e == 3) checked @endif disabled/><label for="erating">3</label>
                          <input type="radio" id="erating" name="e-{{ $rating->id }}" value="2" @if($rating->e == 2) checked @endif disabled/><label for="erating">2</label>
                          <input type="radio" id="erating" name="e-{{ $rating->id }}" value="1" @if($rating->e == 1) checked @endif disabled/><label for="erating">1</label>
                        </span>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Technology</label>
                                <div class="col-sm-6">
                        <span class="star-cb-group">
                          <input type="radio" id="trating" name="t-{{ $rating->id }}" value="5" @if($rating->t == 5) checked @endif disabled/><label for="trating">5</label>
                          <input type="radio" id="trating" name="t-{{ $rating->id }}" value="4" @if($rating->t == 4) checked @endif disabled/><label for="trating">4</label>
                          <input type="radio" id="trating" name="t-{{ $rating->id }}" value="3" @if($rating->t == 3) checked @endif disabled/><label for="trating">3</label>
                          <input type="radio" id="trating" name="t-{{ $rating->id }}" value="2" @if($rating->t == 2) checked @endif disabled/><label for="trating">2</label>
                          <input type="radio" id="trating" name="t-{{ $rating->id }}" value="1" @if($rating->t == 1) checked @endif disabled/><label for="trating">1</label>
                        </span>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Responsiveness</label>
                                <div class="col-sm-6">
                        <span class="star-cb-group">
                          <input type="radio" id="rrating" name="r-{{ $rating->id }}" value="5" @if($rating->r == 5) checked @endif disabled/><label for="rrating">5</label>
                          <input type="radio" id="rrating" name="r-{{ $rating->id }}" value="4" @if($rating->r == 4) checked @endif disabled/><label for="rrating">4</label>
                          <input type="radio" id="rrating" name="r-{{ $rating->id }}" value="3" @if($rating->r == 3) checked @endif disabled/><label for="rrating">3</label>
                          <input type="radio" id="rrating" name="r-{{ $rating->id }}" value="2" @if($rating->r == 2) checked @endif disabled/><label for="rrating">2</label>
                          <input type="radio" id="rrating" name="r-{{ $rating->id }}" value="1" @if($rating->r == 1) checked @endif disabled/><label for="rrating">1</label>
                        </span>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Assurance</label>
                                <div class="col-sm-6">
                        <span class="star-cb-group">
                          <input type="radio" id="arating" name="a-{{ $rating->id }}" value="5" @if($rating->a == 5) checked @endif disabled/><label for="arating">5</label>
                          <input type="radio" id="arating" name="a-{{ $rating->id }}" value="4" @if($rating->a == 4) checked @endif disabled/><label for="arating">4</label>
                          <input type="radio" id="arating" name="a-{{ $rating->id }}" value="3" @if($rating->a == 3) checked @endif disabled/><label for="arating">3</label>
                          <input type="radio" id="arating" name="a-{{ $rating->id }}" value="2" @if($rating->a == 2) checked @endif disabled/><label for="arating">2</label>
                          <input type="radio" id="arating" name="a-{{ $rating->id }}" value="1" @if($rating->a == 1) checked @endif disabled/><label for="arating">1</label>
                        </span>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Quality</label>
                                <div class="col-sm-6">
                        <span class="star-cb-group">
                          <input type="radio" id="qrating" name="q-{{ $rating->id }}" value="5" @if($rating->q == 5) checked @endif disabled/><label for="qrating">5</label>
                          <input type="radio" id="qrating" name="q-{{ $rating->id }}" value="4" @if($rating->q == 4) checked @endif disabled/><label for="qrating">4</label>
                          <input type="radio" id="qrating" name="q-{{ $rating->id }}" value="3" @if($rating->q == 3) checked @endif disabled/><label for="qrating">3</label>
                          <input type="radio" id="qrating" name="q-{{ $rating->id }}" value="2" @if($rating->q == 2) checked @endif disabled/><label for="qrating">2</label>
                          <input type="radio" id="qrating" name="q-{{ $rating->id }}" value="1" @if($rating->q == 1) checked @endif disabled/><label for="qrating">1</label>
                        </span>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Comment</label>
                                <div class="col-sm-6">
                                    <p>{{ $rating->comment or 'No comment.' }}</p>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <hr>
                        </div>
                    @endforeach
                    @if(count($company->ratings) > 3)
                        <div class="text-center">
                            <a id="show_more" class="btn btn-sm btn-primary">Show More <span class="caret"></span></a>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            var size_li = {{ count($company->ratings) }};
            var x=3;
            $('.rating_div').hide();
            $( '.rating_div' ).slice( 0, 3 ).show();
            $('#show_more').click(function () {
                x= (x+3 <= size_li) ? x+3 : size_li;
                $( ".rating_div" ).slice( 0, x ).show();

                if(x >= size_li){
                    $('#show_more').hide();
                }
            });
        });
    </script>
@endsection