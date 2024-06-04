<!--
=========================================================
 Light Bootstrap Dashboard - v2.0.1
=========================================================

 Product Page: https://www.creative-tim.com/product/light-bootstrap-dashboard
 Copyright 2019 Creative Tim (https://www.creative-tim.com) & Updivision (https://www.updivision.com)
 Licensed under MIT (https://github.com/creativetimofficial/light-bootstrap-dashboard/blob/master/LICENSE)

 Coded by Creative Tim & Updivision

=========================================================

 The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.  -->
<!DOCTYPE html>

<html lang="es">
    <head>
        <meta charset="utf-8" />
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('light-bootstrap/img/apple-icon.png') }}">
        <link rel="icon" type="image/png" href="{{ asset('light-bootstrap/img/favicon.ico') }}">
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

        <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">

        <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/jdtpaginate.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/clinica.css') }}" rel="stylesheet" />
    </head>

    <body>
    <div id="app"></div>
        <div class="wrapper @if (!auth()->check() || request()->route()->getName() == "") wrapper-full-page @endif">

            @if (auth()->check() && request()->route()->getName() != "")
                @include('layouts.navbars.sidebar')
{{--                @include('pages/sidebarstyle')--}}
            @endif

            <div class="@if (auth()->check() && request()->route()->getName() != "") main-panel @endif">
                @include('layouts.navbars.navbar')
                @include('flash-message')
                <div id="c_message_ajax" class="alert alert-dark m-2" role="alert" style="display: none;">
                    A simple dark alert—check it out!
                </div>
                @yield('content')
                @include('layouts.footer.nav')
            </div>

        </div>
    <!-- Modal -->
    <div class="modal fade" id="textPreModal" tabindex="-1" aria-labelledby="textpreModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="textpreModalLabel">Textos Predefinidos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('textopredefinido.includes.texto-list')
                    <div id="alert-box-texto-pre" class="alert alert-info alert-dismissible" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h6>Copiado!</h6>
                        Texto predefinido copiado.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

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

    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

    @stack('js')
    <script>
        $('body').on("keydown", function(e) {
            // if (e.ctrlKey && e.shiftKey && e.which === 83) {
            // ctrl + m
            if (e.ctrlKey  && e.which === 77) {
                $("#textPreModal").modal('show');
                e.preventDefault();
            }
        });
        $(document).ready(function () {


        });

        function uppercaseInput(input){
            $(input).val($(input).val().toUpperCase());
        }

        function copyToClipboard(id){
            copyElementToClipboard('select_t_'+id);
            $("#alert-box-texto-pre").css('display', 'block').delay(2000).slideUp(300);
        }

        function copyElementToClipboard(element) {
            window.getSelection().removeAllRanges();
            let range = document.createRange();
            range.selectNode(typeof element === 'string' ? document.getElementById(element) : element);
            window.getSelection().addRange(range);
            document.execCommand('copy');
            window.getSelection().removeAllRanges();
        }

        function getCodigo(){
            tipo = $('#s_tipoanalisis').val();
            if(tipo != ''){
                $.ajax({
                    url: "{{ route('analisis.agetcode') }}",
                    type: 'POST',
                    data: {'tipo-analisis': tipo},
                    success: function (data) {
                        $('#i_codigo').val(data.success);
                    }
                });
            } else {
                $('#i_codigo').val('');
            }

        }

        function showMessageAjax(type, message){
            divClass = "alert m-2 alert-"+type;
            divMessage = "#c_message_ajax";
            $(divMessage).removeClass();
            $(divMessage).addClass(divClass);
            $(divMessage).empty();
            $(divMessage).append(message);
            $(divMessage).fadeIn();
            $(divMessage).delay(5000).fadeOut();

        }
    </script>

    </body>
</html>
