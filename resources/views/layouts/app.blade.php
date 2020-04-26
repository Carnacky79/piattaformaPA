<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('light-bootstrap/img/apple-icon.png') }}">
        <link rel="icon" type="image/png" href="{{ asset('light-bootstrap/img/favicon.ico') }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>{{ $title }}</title>
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
        <!--     Fonts and icons     -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
        <!-- CSS Files -->
        <link href="{{ asset('light-bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
        <!--<link href="{{ asset('light-bootstrap/css/datatables.min.css') }}" rel="stylesheet" /> -->
        <link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet" />
        <link href="{{ asset('light-bootstrap/css/light-bootstrap-dashboard.css?v=2.0.0') }} " rel="stylesheet" />
        <!-- CSS Just for demo purpose, don't include it in your project -->
        <link href="{{ asset('light-bootstrap/css/demo.css') }}" rel="stylesheet" />

        <link href="{{ asset('light-bootstrap/css/Chart.min.css') }}" rel="stylesheet" />

        <link href='https://unpkg.com/@fullcalendar/core@4.4.0/main.min.css' rel='stylesheet' />

        <link href='https://unpkg.com/@fullcalendar/daygrid@4.4.0/main.min.css' rel='stylesheet' />

        <link href='https://unpkg.com/@fullcalendar/timegrid@4.4.0/main.min.css' rel='stylesheet' />



    </head>
    <style>
        .hidden{
            display:none;
        }

        .show{
            display:inline;
        }

        .autocomplete-suggestions { -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; border: 1px solid #999; background: #FFF; cursor: default; overflow: auto; -webkit-box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); -moz-box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); }
        .autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
        .autocomplete-no-suggestion { padding: 2px 5px;}
        .autocomplete-selected { background: #F0F0F0; }
        .autocomplete-suggestions strong { font-weight: bold; color: #000; }
        .autocomplete-group { padding: 2px 5px; font-weight: bold; font-size: 16px; color: #000; display: block; border-bottom: 1px solid #000; }
    </style>

    <body>
        <div class="wrapper @if (!auth()->check() || request()->route()->getName() == "") wrapper-full-page @endif">

            @if (auth()->check() && request()->route()->getName() != "")
                @include('layouts.navbars.sidebar')
                {{-- @include('pages/sidebarstyle') --}}
            @endif

            <div class="@if (auth()->check() && request()->route()->getName() != "") main-panel @endif">
                @include('layouts.navbars.navbar')
                @yield('content')
                @include('layouts.footer.nav')
            </div>

        </div>



    </body>
        <!--   Core JS Files   -->
    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
    <script src="{{ asset('light-bootstrap/js/core/popper.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('light-bootstrap/js/core/bootstrap.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('light-bootstrap/js/plugins/jquery.sharrre.js') }}"></script>
    <!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
    <script src="{{ asset('light-bootstrap/js/plugins/bootstrap-switch.js') }}"></script>
    <!--  Notifications Plugin    -->
    <script src="{{ asset('light-bootstrap/js/plugins/bootstrap-notify.js') }}"></script>
    <!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
    <script src="{{ asset('light-bootstrap/js/light-bootstrap-dashboard.js?v=2.0.0') }}" type="text/javascript"></script>
    <script src='https://unpkg.com/@fullcalendar/core@4.4.0/locales-all.js'></script>

    <script src='https://unpkg.com/@fullcalendar/core@4.4.0/main.min.js'></script>

    <script src='https://unpkg.com/@fullcalendar/interaction@4.4.0/main.min.js'></script>

    <script src='https://unpkg.com/@fullcalendar/daygrid@4.4.0/main.min.js'></script>

    <script src='https://unpkg.com/@fullcalendar/timegrid@4.4.0/main.min.js'></script>

    <script type="text/javascript" charset="utf8" src="{{ asset('light-bootstrap/js/core/datatables.min.js') }}"></script>

    <script type="text/javascript" charset="utf8" src="{{ asset('light-bootstrap/js/plugins/jquery.autocomplete.min.js') }}"></script>

    <script type="text/javascript" charset="utf8" src="{{ asset('light-bootstrap/js/plugins/Chart.bundle.min.js') }}"></script>

    <script type="text/javascript" charset="utf8" src="{{ asset('light-bootstrap/js/plugins/moment-with-locales.js') }}"></script>

    <script type="text/javascript" charset="utf8" src="{{ asset('light-bootstrap/js/plugins/datetime-moment.js') }}"></script>

    <script type="text/javascript" charset="utf8" src="{{ asset('light-bootstrap/js/demo.js') }}"></script>

    @stack('js')
</html>
