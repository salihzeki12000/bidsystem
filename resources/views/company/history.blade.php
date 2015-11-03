@extends('app')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h4>{{ $company->company_name }}</h4>
            <br>
            <div class="panel panel-default">
                <div class="panel-heading">
                    @if($company->category == 'LSP')
                        {{ 'Bid History' }}
                    @elseif($company->category == 'Outsourcing')
                        {{ 'Jobs History' }}
                    @else
                        {{ 'History' }}
                    @endif
                </div>
                <div class="panel-body">
                    @if(count($company->jobs) > 0)
                        <table id="job">
                            <thead>
                            <tr>
                                <th>Job ID</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($company->jobs as $job)
                                <tr>
                                    <td>
                                        <a href="/job/{{ $job->id }}" target="_blank">{{ $job->id }}</a>
                                    </td>
                                    <td>
                                        {{ $job->rfi_status->rfi_status }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @elseif(count($company->bids) > 0)
                        <table id="bid">
                            <thead>
                            <tr>
                                <th>Bid ID</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($company->bids as $bid)
                                <tr>
                                    <td>
                                        <a href="/bid/{{ $bid->id }}" target="_blank">{{ $bid->id }}</a>
                                    </td>
                                    <td>
                                        {{ $bid->rfi_status->rfi_status }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        {{ 'No history found for company '.$company->company_name }}
                    @endif
                </div>
            </div>
            <div class="text-center">
                <a href="/company" class="btn btn-default">Back</a>
            </div>
            <div class="clearfix"></div>
            <br>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready( function () {
            $('#job').DataTable();
            $('#bid').DataTable();
        } );
    </script>
@endsection