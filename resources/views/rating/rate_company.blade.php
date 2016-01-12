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
        .star-cb-group > input:checked ~ label:before, .star-cb-group > input + label:hover ~ label:before, .star-cb-group > input + label:hover:before {
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
        .star-cb-group:hover > input + label:before {
            content: "☆";
            color: #888;
            text-shadow: none;
        }
        .star-cb-group:hover > input + label:hover ~ label:before, .star-cb-group:hover > input + label:hover:before {
            content: "★";
            color: #e52;
            text-shadow: 0 0 1px #333;
        }
    </style>
@endsection

@section('content')
    <div class="col-sm-12">
        <div class="row">
            <h4>Rate Company: {{ $company->company_name or 'Admin' }}</h4>
        </div>
        <hr>

        <form class="form-horizontal" method="post" action="/rating/save_rating" id="rating_form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="company_id" value="{{ $company->id }}">
            @if(count($rating) > 0)
                <input type="hidden" name="rating_id" value="{{ $rating->id }}">
            @endif

            <div class="form-group required">
                <label class="col-sm-3 control-label">Cost and Competitiveness</label>
                <div class="col-sm-6">
                    <span class="star-cb-group">
                      <input type="radio" id="crating-5" name="c" value="5" @if(count($rating) > 0 && $rating->c == 5) checked @endif/><label for="crating-5">5</label>
                      <input type="radio" id="crating-4" name="c" value="4" @if(count($rating) > 0 && $rating->c == 4) checked @endif/><label for="crating-4">4</label>
                      <input type="radio" id="crating-3" name="c" value="3" @if(count($rating) > 0 && $rating->c == 3) checked @endif/><label for="crating-3">3</label>
                      <input type="radio" id="crating-2" name="c" value="2" @if(count($rating) > 0 && $rating->c == 2) checked @endif/><label for="crating-2">2</label>
                      <input type="radio" id="crating-1" name="c" value="1" @if(count($rating) > 0 && $rating->c == 1) checked @endif/><label for="crating-1">1</label>
                    </span>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="form-group required">
                <label class="col-sm-3 control-label">Environmental Responsible</label>
                <div class="col-sm-6">
                    <span class="star-cb-group">
                      <input type="radio" id="erating-5" name="e" value="5" @if(count($rating) > 0 && $rating->e == 5) checked @endif/><label for="erating-5">5</label>
                      <input type="radio" id="erating-4" name="e" value="4" @if(count($rating) > 0 && $rating->e == 4) checked @endif/><label for="erating-4">4</label>
                      <input type="radio" id="erating-3" name="e" value="3" @if(count($rating) > 0 && $rating->e == 3) checked @endif/><label for="erating-3">3</label>
                      <input type="radio" id="erating-2" name="e" value="2" @if(count($rating) > 0 && $rating->e == 2) checked @endif/><label for="erating-2">2</label>
                      <input type="radio" id="erating-1" name="e" value="1" @if(count($rating) > 0 && $rating->e == 1) checked @endif/><label for="erating-1">1</label>
                    </span>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="form-group required">
                <label class="col-sm-3 control-label">Technology</label>
                <div class="col-sm-6">
                    <span class="star-cb-group">
                      <input type="radio" id="trating-5" name="t" value="5" @if(count($rating) > 0 && $rating->t == 5) checked @endif/><label for="trating-5">5</label>
                      <input type="radio" id="trating-4" name="t" value="4" @if(count($rating) > 0 && $rating->t == 4) checked @endif/><label for="trating-4">4</label>
                      <input type="radio" id="trating-3" name="t" value="3" @if(count($rating) > 0 && $rating->t == 3) checked @endif/><label for="trating-3">3</label>
                      <input type="radio" id="trating-2" name="t" value="2" @if(count($rating) > 0 && $rating->t == 2) checked @endif/><label for="trating-2">2</label>
                      <input type="radio" id="trating-1" name="t" value="1" @if(count($rating) > 0 && $rating->t == 1) checked @endif/><label for="trating-1">1</label>
                    </span>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="form-group required">
                <label class="col-sm-3 control-label">Responsiveness</label>
                <div class="col-sm-6">
                    <span class="star-cb-group">
                      <input type="radio" id="rrating-5" name="r" value="5" @if(count($rating) > 0 && $rating->r == 5) checked @endif/><label for="rrating-5">5</label>
                      <input type="radio" id="rrating-4" name="r" value="4" @if(count($rating) > 0 && $rating->r == 4) checked @endif/><label for="rrating-4">4</label>
                      <input type="radio" id="rrating-3" name="r" value="3" @if(count($rating) > 0 && $rating->r == 3) checked @endif/><label for="rrating-3">3</label>
                      <input type="radio" id="rrating-2" name="r" value="2" @if(count($rating) > 0 && $rating->r == 2) checked @endif/><label for="rrating-2">2</label>
                      <input type="radio" id="rrating-1" name="r" value="1" @if(count($rating) > 0 && $rating->r == 1) checked @endif/><label for="rrating-1">1</label>
                    </span>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="form-group required">
                <label class="col-sm-3 control-label">Assurance</label>
                <div class="col-sm-6">
                    <span class="star-cb-group">
                      <input type="radio" id="arating-5" name="a" value="5" @if(count($rating) > 0 && $rating->a == 5) checked @endif/><label for="arating-5">5</label>
                      <input type="radio" id="arating-4" name="a" value="4" @if(count($rating) > 0 && $rating->a == 4) checked @endif/><label for="arating-4">4</label>
                      <input type="radio" id="arating-3" name="a" value="3" @if(count($rating) > 0 && $rating->a == 3) checked @endif/><label for="arating-3">3</label>
                      <input type="radio" id="arating-2" name="a" value="2" @if(count($rating) > 0 && $rating->a == 2) checked @endif/><label for="arating-2">2</label>
                      <input type="radio" id="arating-1" name="a" value="1" @if(count($rating) > 0 && $rating->a == 1) checked @endif/><label for="arating-1">1</label>
                    </span>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="form-group required">
                <label class="col-sm-3 control-label">Quality</label>
                <div class="col-sm-6">
                    <span class="star-cb-group">
                      <input type="radio" id="qrating-5" name="q" value="5" @if(count($rating) > 0 && $rating->q == 5) checked @endif/><label for="qrating-5">5</label>
                      <input type="radio" id="qrating-4" name="q" value="4" @if(count($rating) > 0 && $rating->q == 4) checked @endif/><label for="qrating-4">4</label>
                      <input type="radio" id="qrating-3" name="q" value="3" @if(count($rating) > 0 && $rating->q == 3) checked @endif/><label for="qrating-3">3</label>
                      <input type="radio" id="qrating-2" name="q" value="2" @if(count($rating) > 0 && $rating->q == 2) checked @endif/><label for="qrating-2">2</label>
                      <input type="radio" id="qrating-1" name="q" value="1" @if(count($rating) > 0 && $rating->q == 1) checked @endif/><label for="qrating-1">1</label>
                    </span>
                </div>
            </div>

            <div class="clearfix"></div>
            <hr>

            <div class="form-group">
                <label class="col-sm-3 control-label">Comment</label>
                <div class="col-sm-6">
                    <textarea name="comment" class="form-control" style="resize: vertical">{{ $rating->comment or '' }}</textarea>
                </div>
            </div>

            <div class="clearfix"></div>
            <br>

            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </form>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $('#rating_form').submit(function() {
            if ($('input:radio[name="c"]').is(':checked') && $('input:radio[name="e"]').is(':checked') && $('input:radio[name="t"]').is(':checked') &&
                    $('input:radio[name="r"]').is(':checked') && $('input:radio[name="a"]').is(':checked') && $('input:radio[name="q"]').is(':checked')
            ) {
                return true;
            } else {
                alert('Please rate all categories.');
                return false;
            }
        });
    </script>
@endsection