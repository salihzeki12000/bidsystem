<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bid System</title>

    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/css/sidebar.css" />
    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/moment.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>

    <!-- date time picker -->
    <link rel="stylesheet" href="/css/bootstrap-datetimepicker.min.css" />
    <script type="text/javascript" src="/js/bootstrap-datetimepicker.min.js"></script>

    <style>
        .form-group.required .control-label:after {
            content:"*";
            color:red;
        }
        .display-content{
            padding-top: 7px;
            margin-bottom: 0;
            text-align: left;
        }

        .no-color-no-border{
            background-color: transparent;
            border: none;
        }

        .padding{
            padding-left: 35px !important;
        }
        .no-margin-bot{
            margin-bottom: 0px !important;
        }
        @yield('inside-style')
    </style>
    @yield('style')
            <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- data table -->
    <link href='//cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="/js/dataTable.js"></script>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#default_bar">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <button href="#menu-toggle" class="btn btn-default navbar-toggle collapsed" id="menu-toggle">
                <span class="glyphicon glyphicon-list"></span>
            </button>
            <a class="navbar-brand" href="/">Bid System</a>
        </div>


        <div class="collapse navbar-collapse" id="default_bar">
            <ul class="nav navbar-nav">
                @if (!Auth::guest())
                    @can('non-system-admin')
                        <li><a href="/company/{{ Auth::user()->company_id }}">Company Profile</a></li>
                    @endcan
                    @can('globe-admin-above')
                        <li><a href="/messages"><span class="glyphicon glyphicon-envelope"></span></a></li>
                    @else
                        <li><a href="/messages/{{ \Auth::user()->company_id }}"><span class="glyphicon glyphicon-envelope"></span></a></li>
                    @endcan
                @endif
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest())
                    <li><a href="/auth/login">Login</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->first_name.' '.Auth::user()->last_name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="/user/edit_user_profile/{{ Auth::user()->id }}">Profile</a></li>
                            <li><a href="/auth/logout">Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
@yield('fullbody')
<div id="wrapper">

    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <div class="list-group list-group-root well">
            <a class="list-group-item no-color-no-border" href="/home">Home</a>

            <a class="list-group-item no-color-no-border" href="/company"><img src="/images/icons/Department-100.png" width="15" height="15"/> Company</a>

            @can('globe-admin-above')
            <a class="list-group-item no-color-no-border" href="/user"><img src="/images/icons/User Male-100.png" width="15" height="15"/>User</a>
            @endcan

            @can('non-outward-user')
            @can('non-system-admin')
            <a href="#jobs" class="list-group-item no-color-no-border" data-toggle="collapse"><img src="/images/icons/Strike-100.png" width="15" height="15"/> Job</a>
            <div class="list-group @if($collapse) collapse @endif no-margin-bot" id="jobs">
                <a href="/job" class="list-group-item no-color-no-border padding @if($action == 'index' && $controller == 'JobsController') active @endif">Browse Jobs</a>
                <a href="/company/job_history/{{ \Auth::user()->company_id }}" class="list-group-item no-color-no-border padding @if($action == 'jobHistory') active @endif">Job History</a>
                <a href="/job_progress_tracking/{{ \Auth::user()->company_id }}" class="list-group-item no-color-no-border padding @if($action == 'jobProgressTracking') active @endif">Job Progress Tracking</a>
                <a href="/job/create" class="list-group-item no-color-no-border padding @if($action == 'create' && $controller == 'JobsController') active @endif">Create Job</a>
            </div>
            @else
            <a class="list-group-item no-color-no-border" href="/job"><img src="/images/icons/Strike-100.png" width="15" height="15"/> Job</a>
            @endcan
            @endcan

            @can('non-inward-user')
            @can('non-system-admin')
            <a href="#bids" class="list-group-item no-color-no-border" data-toggle="collapse"><img src="/images/icons/Court Judge-100.png" width="15" height="15"/> Bid</a>
            <div class="list-group @if($collapse) collapse @endif no-margin-bot" id="bids">
                <a href="/company/bid_history/{{ \Auth::user()->company_id }}" class="list-group-item no-color-no-border padding @if($action == 'bidHistory') active @endif">Bid History</a>
                <a href="/bid_progress_tracking/{{ \Auth::user()->company_id }}" class="list-group-item no-color-no-border padding @if($action == 'bidProgressTracking') active @endif">Bid Progress Tracking</a>
                <a href="/bid/create" class="list-group-item no-color-no-border padding @if($action == 'create' && $controller == 'BidsController') active @endif">Create Bid</a>
            </div>
            @else
            <a class="list-group-item no-color-no-border" href="/bid"><img src="/images/icons/Court Judge-100.png" width="15" height="15"/> Bid</a>
            @endcan
            @endcan

            @can('non-system-admin')
            <a class="list-group-item no-color-no-border" href="/manage_group_user/{{ \Auth::user()->company_id }}"><img src="/images/icons/Conference-100.png" width="15" height="15"/> Manage Group User</a>
            @endcan

            @can('non-inward-user')
            <a class="list-group-item no-color-no-border" href="/search_job"><img src="/images/icons/Search-100.png" width="15" height="15"/> Search Job</a>
            @endcan

            @can('globe-admin-above')
            <a class="list-group-item no-color-no-border" href="/appointments"><img src="/images/icons/Calendar-100.png" width="15" height="15"/> Appointments</a>
            @else
            <a class="list-group-item no-color-no-border" href="/show_all_appointments/{{ \Auth::user()->company_id }}"><img src="/images/icons/Calendar-100.png" width="15" height="15"/> Appointments</a>
            @endcan

            @can('globe-admin-above')
            <a class="list-group-item no-color-no-border" href="/ticket"><img src="/images/icons/Customer Support-100.png" width="15" height="15"/> Ticket</a>
            @else
            <a class="list-group-item no-color-no-border" href="/ticket/show_my_tickets/{{ \Auth::user()->company_id }}"><img src="/images/icons/Customer Support-100.png" width="15" height="15"/> Ticket</a>
            @endcan

            <a class="list-group-item no-color-no-border" href="/rating/list_companies"><img src="/images/icons/Star-100.png" width="15" height="15"/> Rating</a>

            @can('super-admin-only')
            <a class="list-group-item no-color-no-border" href="/user_performance" ><img src="/images/icons/User Menu-100.png" width="15" height="15"/> User Performance</a>
            @endcan

            @can('globe-admin-above')
            <a class="list-group-item no-color-no-border" href="/system" ><img src="/images/icons/system.png" width="15" height="15"/> System</a>
            @endcan
            @can('globe-admin-above')
            <a class="list-group-item no-color-no-border" href="/log" ><img src="/images/icons/system.png" width="15" height="15"/> Transaction Logs</a>
            @endcan

            <a class="list-group-item no-color-no-border" href="/report/report" ><img src="/images/icons/system.png" width="15" height="15"/> Report</a>

        </div>
    </div>


    <!-- /#sidebar-wrapper -->
    <div class="container-fluid">
    @include('partial.flash')
    <div style="margin-bottom: 20px;"></div>
    <div class="clearfix"></div>

    @yield('content')
    </div>
</div>

<!-- Scripts -->
@yield('script')
<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    $('.list-group-item').on('click', function() {
        $('.glyphicon', this)
                .toggleClass('glyphicon-chevron-right')
                .toggleClass('glyphicon-chevron-down');
    });
</script>
</body>
</html>
