<!DOCTYPE html>

<html lang="es">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/hemolab/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/hemolab/favicon.ico') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <!-- CSS Files -->
    <link href="{{ asset('font-awesome/css/fontawesome.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/brands.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/regular.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/solid.css') }}" rel="stylesheet">

    <link href="{{ asset('light-bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('js/jquery-ui-1.12.1/jquery-ui.css') }}" rel="stylesheet" />
    <link href="{{ asset('js/jquery-ui-1.12.1/jquery-ui.theme.css') }}" rel="stylesheet" />
    <link href="{{ asset('js/jquery-ui-1.12.1/jquery-ui.structure.css') }}" rel="stylesheet" />
    <link href="{{ asset('light-bootstrap/css/bootstrap.min.bk.css') }}" rel="stylesheet" />
    <link href="{{ asset('light-bootstrap/css/light-bootstrap-dashboard.css?v=2.0.0') }} " rel="stylesheet" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{ asset('light-bootstrap/css/demo.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/jdtpaginate.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/clinica.css') }}" rel="stylesheet" />
</head>

<body>
<div id="app"></div>
<div class="container">
    <header class="blog-header py-3">
        <div class="row flex-nowrap justify-content-between align-items-center">
            <div class="col-8 pt-1">
                <a class="text-muted" href="#">
                    {{-- <img width="500" src="https://laboratorio-cdcc.online/wp-content/uploads/2022/08/logoPATO1.png" class="custom-logo" alt="Centro de Diagnostico Citopatologico Cochabamba" srcset="https://laboratorio-cdcc.online/wp-content/uploads/2022/08/logoPATO1.png 1024w, https://laboratorio-cdcc.online/wp-content/uploads/2022/08/logoPATO1-300x53.png 300w, https://laboratorio-cdcc.online/wp-content/uploads/2022/08/logoPATO1-768x136.png 768w, https://laboratorio-cdcc.online/wp-content/uploads/2022/08/logoPATO1-600x106.png 600w" sizes="(max-width: 1024px) 100vw, 1024px"> --}}
                    <img src="{{ asset('images/hemo-todo.png') }}" class="custom-logo" width="250">
                </a>
            </div>
            <div class="col-4 d-flex justify-content-end align-items-center">
{{--                <a class="text-muted" href="#" aria-label="Search">--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="mx-3" role="img" viewBox="0 0 24 24" focusable="false"><title>Search</title><circle cx="10.5" cy="10.5" r="7.5"></circle><path d="M21 21l-5.2-5.2"></path></svg>--}}
{{--                </a>--}}
{{--                <a class="btn btn-sm btn-outline-secondary" href="#">Sign up</a>--}}
            </div>
        </div>
    </header>

    @yield('content')
</div>

<footer class="blog-footer">

</footer>

<script src="{{ asset('js/app.js') }}"></script>
<!--   Core JS Files   -->
<script src="{{ asset('js/jquery-ui-1.12.1/jquery-ui.js') }}" type="text/javascript"></script>
<script src="{{ asset('light-bootstrap/js/core/popper.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('light-bootstrap/js/core/bootstrap.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('light-bootstrap/js/plugins/jquery.sharrre.js') }}"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="{{ asset('light-bootstrap/js/plugins/bootstrap-switch.js') }}"></script>
<!--  Google Maps Plugin    -->
{{--    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>--}}
<!--  Chartist Plugin  -->
<script src="{{ asset('light-bootstrap/js/plugins/chartist.min.js') }}"></script>
<!--  Notifications Plugin    -->
<script src="{{ asset('light-bootstrap/js/plugins/bootstrap-notify.js') }}"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="{{ asset('light-bootstrap/js/light-bootstrap-dashboard.js?v=2.0.0') }}" type="text/javascript"></script>
<!-- Light Bootstrap Dashboard DEMO methods, don't include it in your project! -->
{{--    <script src="{{ asset('light-bootstrap/js/demo.js') }}"></script>--}}

<script src="{{ asset('light-bootstrap/js/plugins/bootstrap-datepicker.js') }}" type="text/javascript"></script>


@stack('js')
<script>

</script>

</body>
</html>
