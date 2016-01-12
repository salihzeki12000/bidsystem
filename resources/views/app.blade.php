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
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Bid System</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
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
        <ul class="sidebar-nav">
            <li class="sidebar-brand">
            </li>
            <li>
                <a href="/home">Home</a>
            </li>
            <li>
                <a href="/company"><img src="/images/icons/Department-100.png" width="15" height="15"/> Company</a>
            </li>

            @can('globe-admin-above')
                <li>
                    <a href="/user"><img src="/images/icons/User Male-100.png" width="15" height="15"/>User</a>
                </li>
            @endcan
            @can('non-outward-user')
                <li>
                    @can('non-system-admin')
                    <a href="/company/job_history/{{ \Auth::user()->company_id }}"><img src="/images/icons/Strike-100.png" width="15" height="15"/> Job</a>
                    @else
                        <a href="/job"><img src="/images/icons/Strike-100.png" width="15" height="15"/> Job</a>
                    @endcan
                </li>
            @endcan
            @can('non-inward-user')
                <li>
                    @can('non-system-admin')
                    <a href="/company/bid_history/{{ \Auth::user()->company_id }}"><img src="/images/icons/Court Judge-100.png" width="15" height="15"/> Bid</a>
                    @else
                        <a href="/bid"><img src="/images/icons/Court Judge-100.png" width="15" height="15"/> Bid</a>
                        @endcan
                </li>
            @endcan
            @can('non-system-admin')

                <li>
                    <a href="/manage_group_user/{{ \Auth::user()->company_id }}"><img src="/images/icons/Conference-100.png" width="15" height="15"/> Manage Group User</a>
                </li>
            @endcan
            @can('non-inward-user')

                <li>
                    <a href="/search_job"><img src="/images/icons/Search-100.png" width="15" height="15"/> Search Job</a>
                </li>
            @endcan
                <li>
                    @can('globe-admin-above')
                    <a href="/appointments"><img src="/images/icons/Calendar-100.png" width="15" height="15"/> Appointments</a>
                    @else
                        <a href="/show_all_appointments/{{ \Auth::user()->company_id }}"><img src="/images/icons/Calendar-100.png" width="15" height="15"/> Appointments</a>
                        @endcan
                </li>

                <li>
                    @can('globe-admin-above')
                    <a href="/ticket"><img src="/images/icons/Customer Support-100.png" width="15" height="15"/> Ticket</a>
                    @else
                        <a href="/ticket/show_my_tickets/{{ \Auth::user()->company_id }}"><img src="/images/icons/Customer Support-100.png" width="15" height="15"/> Ticket</a>
                        @endcan
                </li>

                <li>
                    <a href="/rating/list_companies"><img src="/images/icons/Star-100.png" width="15" height="15"/> Rating</a>
                </li>
            @can('super-admin-only')

                <li>
                    <a href="/user_performance" ><img src="/images/icons/User Menu-100.png" width="15" height="15"/> User Performance</a>
                </li>
            @endcan
            @can('globe-admin-above')

                <li>
                    <a href="/system" ><img src="/images/icons/system.png" width="15" height="15"/> System</a>
                </li>
            @endcan
            @can('globe-admin-above')

                <li>
                    <a href="/log" ><img src="/images/icons/system.png" width="15" height="15"/> Transaction Logs</a>
                </li>
            @endcan
                <li>
                    <a href="/report/report" ><img src="/images/icons/system.png" width="15" height="15"/> Report</a>
                </li>
        </ul>
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
</body>
</html>
