@extends('app')

@section('content')
    <div class="col-sm-12">
        <div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#credit" aria-controls="credit" role="tab" data-toggle="tab">Credit Transaction</a></li>
                <li role="presentation"><a href="#expiry_date" aria-controls="expiry_date" role="tab" data-toggle="tab">Credit Expiry Date</a></li>
            </ul>
        </div>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="credit">
                <form id="credit_form" class="form-horizontal" role="form" method="POST" action="/credit" enctype="multipart/form-data">
                    <div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="company_id" value="{{ $company->id }}">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Company</label>
                                    <div class="col-md-6">
                                        <p class="display-content">{{ $company->company_name }}</p>
                                    </div>
                                </div>

                                <div class="form-group required">
                                    <label class="col-md-4 control-label">Transaction Type</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="type" required>
                                            <option value="top-up">Credit Top-up</option>
                                            <option value="deduction">Credit Deduction</option>
                                            <option value="edit">Credit Edit</option>
                                            <option value="unit_cost">Credit Unit Cost</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group required">
                                    <label class="col-md-4 control-label">Amount</label>
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" name="amount" value="{{ old('amount') }}" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Comment</label>
                                    <div class="col-md-6">
                                        <textarea style="resize: vertical;" class="form-control" name="comment">{{ old('comment') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" style="margin-right: 15px;">
                                Submit
                            </button>
                        </div>
                        <div class="clearfix"></div>
                        <br>
                    </div>
                </form>
            </div>

            <div role="tabpanel" class="tab-pane" id="expiry_date">
                <form id="credit_form" class="form-horizontal" role="form" method="POST" action="/credit/change_expiry_date" enctype="multipart/form-data">
                    <div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="company_id" value="{{ $company->id }}">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Company</label>
                                    <div class="col-md-6">
                                        <p class="display-content">{{ $company->company_name }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">New Expiry Date</label>
                                    <div class="col-md-6">
                                        <div class='input-group date' id='credit_expiry_date'>
                                            <input type='text' class="form-control" name="expiry_date" value="{{ $company->credit_expiry }}"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" style="margin-right: 15px;">
                                Submit
                            </button>
                        </div>
                        <div class="clearfix"></div>
                        <br>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $('#credit_expiry_date').datetimepicker({
            format: 'DD-MM-YYYY HH:mm'
        });
    </script>
@endsection