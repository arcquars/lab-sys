<!DOCTYPE html>
<html class="wide wow-animation scrollTo" lang="en">
<head>
    <title>HemoLab</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Asap:400,500,600,700%7CLato:400italic,400,700">
    <!--    <link rel="stylesheet" href="css/bootstrap.css">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" integrity="sha512-b2QcS5SsA8tZodcDtGRELiGv5SaKSk1vDHDaQRda0htPYWZ6046lr3kJ5bAAQdpV2mmA/4v0wQF9MyU6/pDIAg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="preloader">
    <div class="preloader-body">
        <div class="cssload-container">
            <div class="cssload-double-torus"></div>
        </div>
        <p>&nbsp;</p>
    </div>
</div>
<div class="page">
    <header class="section page-header header-absolute">
        <!--RD Navbar-->
        <div class="rd-navbar-wrap">
            <nav class="rd-navbar rd-navbar-classic" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-fixed" data-lg-device-layout="rd-navbar-fixed" data-xl-layout="rd-navbar-static" data-xl-device-layout="rd-navbar-static" data-lg-stick-up-offset="46px" data-xl-stick-up-offset="46px" data-xxl-stick-up-offset="46px" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
                <div class="rd-navbar-collapse-toggle rd-navbar-fixed-element-1" data-rd-navbar-toggle=".rd-navbar-collapse"><span></span></div>
                <div class="rd-navbar-aside-outer rd-navbar-collapse">
                    <!--RD Navbar Brand-->
                    <div class="rd-navbar-aside">
                        <div class="rd-navbar-brand">
                            <!--Brand-->
                            <a class="brand" href="index.html">
                                <!--                                <img class="brand-logo-dark" src="images/logo-default-154x53.png"/>-->
                                <img class="brand-logo-light" src="images/logo-letras-web.png" alt="" width="10"/>
                            </a>
                        </div>
                        <div class="contacts-wrap">
                            <address class="contact-info reveal-sm-inline-block text-start offset-none">
                                <div class="p unit unit-spacing-xs unit-horizontal">
                                    <div class="unit-left"><span class="icon icon-xs icon-circle icon-white-17 mdi mdi-phone"></span></div>
                                    <div class="unit-body">
                                        <a class="text-white" href="tel:#">+ 591 458 476 2</a>
                                        <br><a class="text-white" href="tel:#">+ 591 707 404 80</a> | <a class="text-white" href="tel:#">+ 591 797 279 08 </a>
                                    </div>
                                </div>
                            </address>
                            <address class="contact-info reveal-sm-inline-block text-start">
                                <div class="p unit unit-horizontal unit-spacing-xs">
                                    <div class="unit-left"><span class="icon icon-xs icon-circle icon-white-17 mdi mdi-map-marker"></span></div>
                                    <div class="unit-body"><a class="text-white" href="#">2130 Fulton Street San Diego<br>CA 94117-1080 USA</a></div>
                                </div>
                            </address>
                        </div>
                    </div>
                </div>
                <div class="rd-navbar-main-outer">
                    <div class="rd-navbar-main">
                        <!--RD Navbar Panel-->
                        <div class="rd-navbar-panel">
                            <!--RD Navbar Toggle-->
                            <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                            <!--RD Navbar Brand-->
                            <div class="rd-navbar-brand">
                                <!--Brand--><a class="brand" href="index.html"><img class="brand-logo-dark" src="images/logo-default-154x53.png" alt="" width="77" height="26"/><img class="brand-logo-light" src="images/logo-inverse-154x53.png" alt="" width="77" height="26"/></a>
                            </div>
                        </div>
                        <div class="rd-navbar-main-element">
                            <div class="rd-navbar-nav-wrap">
                                <ul class="rd-navbar-nav">
                                    <li class="rd-nav-item active"><a class="rd-nav-link" href="index.html">INICIO</a>
                                    </li>
                                    <li class="rd-nav-item"><a class="rd-nav-link" href="#pdm-we-are">NOSOTROS</a></li>
                                    <li class="rd-nav-item"><a class="rd-nav-link" href="#pdm-mision">MISIÓN</a></li>
                                    <li class="rd-nav-item"><a class="rd-nav-link" href="#pdm-services">SERVICIOS</a>
                                    </li>
                                    <!--                                    <li class="rd-nav-item"><a class="rd-nav-link" href="services.html">Services</a>-->
                                    <!--                                    </li>-->
                                    <!--                                    <li class="rd-nav-item"><a class="rd-nav-link" href="departments.html">Departments</a>-->
                                    <!--                                    </li>-->
                                    <!--                                    <li class="rd-nav-item"><a class="rd-nav-link" href="timetable.html">Timetable</a>-->
                                    <!--                                    </li>-->
                                    <li class="rd-nav-item"><a class="rd-nav-link" href="contacts.html">CONTACTENOS</a>
                                    </li>
                                    <li class="rd-nav-item"><a class="rd-nav-link" href="{{route('guest.auth.home')}}">RESULTADOS</a>
                                    </li>
                                    <li class="rd-nav-item"><a class="rd-nav-link" href="{{route('login')}}">ADMINISTRACIÓN</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <section class="section swiper-container swiper-slider bg-default" data-swiper='{"autoplay":{"delay":5000},"effect":"fade"}'>
        <div class="swiper-wrapper text-center">
            <div class="swiper-slide" id="page-loader" data-slide-bg="images/slide-01.jpg">
                <div class="swiper-caption">
                    <div class="swiper-slide-caption">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-7 section-slider-custom">
                                    <div class="inset-xl-right-80 text-lg-start">
                                        <h2>Cuide su <br class="d-block">salud
                                        </h2>
                                        <h5 class="d-none d-lg-block mw-400">En Medina nos dedicamos a diagnosticar todo tipo de enfermedades.</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide" data-slide-bg="images/slide-02.jpg">
                <div class="swiper-caption">
                    <div class="swiper-slide-caption">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6 section-slider-custom to-front">
                                    <div class="text-lg-start">
                                        <h2>Años de <br class="d-block"> Experiencia
                                        </h2>
                                        <h5 class="d-none d-lg-block mw-400">Desde nuestra fundación, ofrecemos soluciones de diagnóstico.</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide" data-slide-bg="images/slide-03.jpg">
                <div class="swiper-caption">
                    <div class="swiper-slide-caption">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-7 section-slider-custom">
                                    <div class="text-lg-start">
                                        <h2>Equipo cualificado <br class="d-block">de expertos</h2>
                                        <h5 class="d-none d-lg-block mw-400">Nuestro equipo de diagnosticadores está siempre dispuesto a ayudarle a estar más sano.</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-pagination"></div>
    </section>
    <!--Sheldue-->
    <section class="bg-default-liac bg-white-liac section section-md pt-xl-0">
        <div class="container section-top-34 section-lg-top-0">
            <div class="row g-0 justify-content-sm-center justify-content-xl-start offset-lg-top-34-negative sheldue text-sm-start to-front row-30">
                <div class="col-md-8 col-lg-5 col-xl-3">
                    <div class="sheldue-item light first">
                        <div class="sheldue-item-body">
                            <div class="icon icon-xs mdi mdi-calendar-clock text-white-50"></div>
                            <h6 class="d-inline-block inset-left-10 text-white">horario de apertura</h6>
                            <hr>
                            <div class="row offset-top-24 justify-content-sm-between text-gray-light">
                                <div class="col-sm-4">Lunes a viernes</div>
                                <div class="col-sm-7 offset-top-10 offset-xs-top-0 text-sm-end">07:30 a 18:00</div>
                                <div class="col-sm-4 offset-top-30 offset-xs-top-10">Saturday</div>
                                <div class="col-sm-7 offset-top-10 text-sm-end">08:00 a 12:00</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-lg-5 col-xl-3">
                    <div class="sheldue-item last">
                        <div class="sheldue-item-body">
                            <div class="icon icon-xs icon-emergency-01 text-white-50"></div>
                            <h6 class="d-inline-block inset-left-10 text-white">casos de emergencia</h6>
                            <hr>
                            <div class="offset-top-24">
                                <h5 class="font-weight-bold"><a class="text-white" href="tel:#">+ 591 707 404 80</a></h5>
                                <p class="text-gray-light">Llámenos.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--What makes us different-->
    <section id="pdm-we-are" class="section-lg bg-default-liac">
        <div class="container text-center">
            <h3>Lo que nos diferencia</h3>
            <div class="row offset-top-60 row-50">
                <div class="col-md-6 col-lg-4">
                    <div class="icon icon-xlg icon-circle icon-default icon-pills-xl"></div>
                    <h5 class="font-weight-bold text-gray-darkest">Profesionales con especialidad</h5>
                    <p>Contratamos a los mejores especialistas para ofrecerle servicios de diagnóstico de primera categoría.</p>
                </div>
                <div class="col-md-6 col-lg-4 offset-md-top-0">
                    <div class="icon icon-xlg icon-circle icon-default icon-doctor-xl"></div>
                    <h5 class="font-weight-bold text-gray-darkest">Equipos modernos</h5>
                    <p>Contamos con equipos de última tecnología para el diagnóstico oportuno, seguimiento de enfermedades</p>
                </div>
                <div class="col-md-6 col-lg-4 offset-md-top-0">
                    <div class="icon icon-xlg icon-circle icon-default icon-medical-car-xl"></div>
                    <h5 class="font-weight-bold text-gray-darkest">Controles de Calidad</h5>
                    <p>Contamos con Controles de Calidad Interno y Externo</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Material Parallax-->
    <section class="parallax-container" data-parallax-img="images/background-03-1920x939.jpg">
        <div class="parallax-content section-98 section-sm-110 context-dark">
            <div class="container text-start">
                <div class="row justify-content-sm-center justify-content-lg-start">
                    <div class="col-md-10 col-lg-8 col-xl-5">
                        <h2>Todo tipo <br class="d-none d-xl-inline-block">de diagnósticos</h2>
                        <p class="offset-top-30 text-white">Medina ofrece la gama más completa de servicios de diagnóstico de la región, desde resonancias magnéticas hasta radiografías.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- main services-->
    <section id="pdm-services" class="section-lg bg-default section">
        <div class="container">
            <h3 class="text-center">Nuestros servicios</h3>
            <div class="offset-top-41">
                <p class="custom-paragraph">En nuestra clínica podrá disfrutar de la mejor y más amplia gama de servicios de diagnóstico del estado. No dude en navegar por nuestro sitio web para obtener más información.</p>
            </div>
            <div class="row offset-top-60 text-lg-start row-30">
                <div class="col-md-6 col-lg-4">
                    <div class="service"><img class="img-responsive" src="images/hemolab/image-1.png" width="320" height="320" alt=""/><a class="service-desc h6" href="#">Química Sanguínea</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 offset-sm-top-0">
                    <div class="service"><img class="img-responsive" src="images/hemolab/image-2.png" width="320" height="320" alt=""/><a class="service-desc h6" href="#">Uroánalisis</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 offset-md-top-0">
                    <div class="service"><img class="img-responsive" src="images/hemolab/image-3.png" width="320" height="320" alt=""/><a class="service-desc h6" href="#">Hematología</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="service"><img class="img-responsive" src="images/hemolab/image-4.png" width="320" height="320" alt=""/><a class="service-desc h6" href="#">Serologia</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="service"><img class="img-responsive" src="images/hemolab/image-5.png" width="320" height="320" alt=""/><a class="service-desc h6" href="#">Inmunología</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="service"><img class="img-responsive" src="images/hemolab/image-6.png" width="320" height="320" alt=""/><a class="service-desc h6" href="#">Parasitología</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- main mision-->
    <section id="pdm-mision" class="section-lg bg-default section">
        <div class="container">
            <h3 class="text-center">Misión</h3>
            <div class="offset-top-41">
                <p class="custom-paragraph">Proveer un servicio de salud personalizado y especializado, destinado a realizar análisis de muestras biológicas humanas, con el propósito de orientar la prevención, diagnóstico y tratamiento de los problemas de salud de forma oportuna con calidad y calidez.</p>
            </div>
        </div>
    </section>
    <!--    <section class="section">-->
    <!--        &lt;!&ndash;Please, add the data attribute data-key="YOUR_API_KEY" in order to insert your own API key for the Google map.&ndash;&gt;-->
    <!--        &lt;!&ndash;Please note that YOUR_API_KEY should replaced with your key.&ndash;&gt;-->
    <!--        &lt;!&ndash;Example: <div class="google-map-container" data-key="YOUR_API_KEY">&ndash;&gt;-->
    <!--        <div class="google-map-container" data-center="9870 St Vincent Place, Glasgow, DC 45 Fr 45." data-zoom="5" data-icon="images/gmap_marker.png" data-icon-active="images/gmap_marker_active.png" data-styles="[{&quot;featureType&quot;:&quot;landscape&quot;,&quot;stylers&quot;:[{&quot;saturation&quot;:-100},{&quot;lightness&quot;:60}]},{&quot;featureType&quot;:&quot;road.local&quot;,&quot;stylers&quot;:[{&quot;saturation&quot;:-100},{&quot;lightness&quot;:40},{&quot;visibility&quot;:&quot;on&quot;}]},{&quot;featureType&quot;:&quot;transit&quot;,&quot;stylers&quot;:[{&quot;saturation&quot;:-100},{&quot;visibility&quot;:&quot;simplified&quot;}]},{&quot;featureType&quot;:&quot;administrative.province&quot;,&quot;stylers&quot;:[{&quot;visibility&quot;:&quot;off&quot;}]},{&quot;featureType&quot;:&quot;water&quot;,&quot;stylers&quot;:[{&quot;visibility&quot;:&quot;on&quot;},{&quot;lightness&quot;:30}]},{&quot;featureType&quot;:&quot;road.highway&quot;,&quot;elementType&quot;:&quot;geometry.fill&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#ef8c25&quot;},{&quot;lightness&quot;:40}]},{&quot;featureType&quot;:&quot;road.highway&quot;,&quot;elementType&quot;:&quot;geometry.stroke&quot;,&quot;stylers&quot;:[{&quot;visibility&quot;:&quot;off&quot;}]},{&quot;featureType&quot;:&quot;poi.park&quot;,&quot;elementType&quot;:&quot;geometry.fill&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#b6c54c&quot;},{&quot;lightness&quot;:40},{&quot;saturation&quot;:-40}]},{}]">-->
    <!--            <div class="google-map"></div>-->
    <!--            <ul class="google-map-markers">-->
    <!--                <li data-location="9870 St Vincent Place, Glasgow, DC 45 Fr 45." data-description="9870 St Vincent Place, Glasgow"></li>-->
    <!--            </ul>-->
    <!--        </div>-->
    <!--    </section>-->
    <!-- Page Footer-->
    <footer class="section-relative section-top-66 section-bottom-34 page-footer bg-accent context-dark footer-classic">
        <div class="container">
            <div class="row justify-content-md-center text-xl-start">
                <div class="col-md-8 col-lg-12">
                    <div class="row justify-content-sm-center row-40">
                        <div class="col-sm-10 text-sm-start col-lg-4 order-lg-2">
                            <h6>Contacto</h6>
                            <hr class="text-subline">
                            <div class="text-center text-xl-start">
                                <address class="contact-info d-md-inline-block text-start">
                                    <div class="p unit unit-spacing-xxs flex-row">
                                        <div class="unit-left"><span class="icon icon-xxs mdi mdi-phone text-white"></span></div>
                                        <div class="unit-body">
                                            <a class="text-white-70" href="tel:#">+591 707 404 80 </a><span class="text-white-70">, </span><a class="text-white-70" href="tel:#">+ 591 797 279 08</a>
                                        </div>
                                    </div>
                                    <div class="p unit flex-row unit-spacing-xxs">
                                        <div class="unit-left"><span class="icon icon-xxs mdi mdi-map-marker text-white"></span></div>
                                        <div class="unit-body"><a class="text-white-70" href="#">2130 Fulton Street San Diego, CA 94117-1080 USA</a></div>
                                    </div>
                                    <div class="p unit unit-spacing-xxs flex-row offset-top-16">
                                        <div class="unit-left"><span class="icon icon-xxs mdi mdi-email-outline text-white"></span></div>
                                        <div class="unit-body"><a class="text-white-70 text-java" href="mailto:#">info@demolink.org</a></div>
                                    </div>
                                </address>
                            </div>
                        </div>
                        <div class="col-sm-10 col-lg-4 order-lg-1 text-center text-lg-start">
                            <!--Brand--><a class="brand" href="index.html"><img class="brand-logo-dark" src="images/logo-letras-web.png" alt="" width="77" height="26"/>
                                <img class="brand-logo-light" src="images/logo-letras-web.png" alt="" width="77" height="26"/></a>
                            <div class="offset-top-30">
                                <ul class="list-inline">
                                    <li><a class="icon fa fa-facebook icon-xxs icon-circle icon-white" href="#"></a></li>
                                    <li><a class="icon fa fa-twitter icon-xxs icon-circle icon-white" href="#"></a></li>
                                    <li><a class="icon fa fa-google-plus icon-xxs icon-circle icon-white" href="#"></a></li>
                                    <li><a class="icon fa fa-rss icon-xxs icon-circle icon-white" href="#"></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container offset-top-50 offset-md-top-60">
            <p class="rights"><span>&copy;&nbsp;</span><span class="copyright-year"></span><span>&nbsp;</span><span>Hemolab</span><span>.&nbsp;</span><a href="privacy-policy.html">Política de privacidad</a></p>
        </div>
    </footer>
</div>
<div class="snackbars" id="form-output-global"></div>
<script src="js/core.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>
