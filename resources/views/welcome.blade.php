<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta name="google-site-verification" content="P_yEgFijsmcG-GjA_AgDfW4N384ev7ACxASfQB2n-2I" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>In Training</title>
        <meta name="description" content="Recibe Ofertas de Entrenadores Personales, Compara y Elige al Entrenador Correcto por el Precio que Quieres"/>
        <link rel="canonical" href="https://www.intraining.com.co/"/>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,900|K2D" rel="stylesheet" type="text/css">

        <!-- bootstrap 4.1.0 -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <!-- End bootstrap -->

        <!--footer-->
        <link rel="stylesheet" href="{{asset('css/footer/footer-distributed-with-address-and-phones.css')}}">
        <link href="https://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

        <link rel="stylesheet" href="{{asset('css/welcome.css')}}">

        <link rel="stylesheet" href="{{asset('css/carousel.css')}}">

        <link rel="stylesheet" href="{{asset('css/utils.css')}}">


        <!-- Global site tag (gtag.js) - Google Ads: 780220913 -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=AW-780220913"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'AW-780220913');
        </script>

    </head>
    <body data-spy="scroll" data-target=".navbar">

    <script>
        $(window).on("scroll", function() {
            $("#top-navbar").css("backgroundColor", 'rgba(0, 0, 0, '+$(window).scrollTop());
        });
    </script>

    <nav id="top-navbar" class="navbar navbar-expand-md navbar-dark fixed-top">
        <a class="navbar-brand" href="#" style="width: 60px; padding: 0">
            <!--<img src="{{asset('images/logo-navbar.png')}}" width="100%" height="100%">-->
            <h3 class="d-inline-block brand-name"><span>Kangoo</span>Flow</h3>
        </a>
        <div class="top-right links">
            <a href="{{ route('blogs') }}">Blogs</a>
        @auth
            <a href="{{route('home', ['user'=> Auth::user()->slug])}}">Home</a>
        @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Registro</a>
        @endauth

        </div>
    </nav>

    <div id="welcome" class="flex-center position-ref full-height">
        <div class="content">
            <div class="title mb-3">
                Kangoo Flow
            </div>
            <h4 class="mb-5">Ven a <strong>Saltar</strong> hasta el cielo, con el deporte <strong>Más Divertido.</strong></h4>
            <a class="btn btn-success" style="font-size: 20px; padding: 7px 35px;" href="{{ route('register') }}">
                ¡Quiero Saltar!
            </a>
        </div>
    </div>
    <div class="section" id="section1">
        <div class="sub-section-info">
            <h1 class="mb-5 d-none d-md-block">1. Publica tu entrenamiento</h1>
            <h1 class="mb-5 d-block d-md-none">1. Publica</h1>
            <h3>Describe que clase de entrenamiento quieres hacer (TRX, Yoga, Workout, Funcional, Rumba, etc)</h3>
            <br/>
            <h3><strong>Escoge la fecha y lugar.</strong></h3>
            <h3><strong>Cuando tú quieras, Donde tú quieras.</strong></h3>
        </div>
        <div class="sub-section-image">
            <div class="shadow-bottom h-100 w-100">
                <img class="d-block w-100 h-100 how-works-image redondeado" src="{{asset('images/publicar.PNG')}}" alt="First slide">
            </div>
        </div>
    </div>
    <div class="section" id="section2">
        <!--repetido pero con el orden de la info y la imagen diferente para que en dispositivos pequeños el texto esté siempre arriba-->
        <div class="d-block d-md-none sub-section-info">
            <h1 class="mb-5">2. Recibe ofertas</h1>
            <h3>Recibe ofertas de diferentes entrenadores que compiten por ayudarte a lograr tu meta <strong>fitness</strong></h3>
        </div>
        <div class="d-block d-md-none sub-section-image">
            <div class="shadow-bottom h-100 w-100">
                <img class="d-block w-100 h-100 how-works-image" src="{{asset('images/recibeOfertas.PNG')}}" alt="First slide">
            </div>
        </div>


        <div class="d-none d-md-block sub-section-image">
            <div class="shadow-bottom h-100 w-100">
                <img class="d-block w-100 h-100 how-works-image" src="{{asset('images/recibeOfertas.PNG')}}" alt="First slide">
            </div>
        </div>
        <div class="d-none d-md-block sub-section-info">
            <h1 class="mb-5">2. Recibe ofertas</h1>
            <h3>Recibe ofertas de diferentes entrenadores que compiten por ayudarte a lograr tu meta <strong>fitness</strong></h3>
        </div>
    </div>
    <div class="section" id="section3">
        <div class="sub-section-info">
            <h1 class="mb-5">3. Selecciona tu entrenador</h1>
            <h3>Compara los precios, puntuaciones y reviews y selecciona al <strong>Entrenador Ideal</strong> por el <strong>Mejor Precio</strong></h3>
        </div>
        <div class="sub-section-image">
            <div class="shadow-bottom h-100 w-100">
                <img class="d-block w-100 h-100 how-works-image" src="{{asset('images/seleccionar.PNG')}}" alt="First slide">
            </div>
        </div>
    </div>
    <div class="section" id="section4">
        <!--repetido pero con el orden de la info y la imagen diferente para que en dispositivos pequeños el texto esté siempre arriba-->
        <div class="d-block d-md-none sub-section-info">
            <h1 class="mb-5">5. Pago seguro</h1>
            <h3>El pago se libera cuando has finalizado el entrenamiento, solo pagas por los entrenamientos que hagas</h3>
        </div>
        <div class="d-block d-md-none pay-image">
            <img class="rounded-circle d-block how-works-image w-100 h-100" src="{{asset('images/safePay1.png')}}" alt="First slide">
            <img class="pay-image2 d-block how-works-image position-relative" src="{{asset('images/safePay2.png')}}" alt="First slide">
        </div>

        <div class="d-none d-md-block pay-image">
            <img class="rounded-circle d-block how-works-image w-100 h-100" src="{{asset('images/safePay1.png')}}" alt="First slide">
            <img class="pay-image2 d-block how-works-image position-relative" src="{{asset('images/safePay2.png')}}" alt="First slide">
        </div>
        <div class="d-none d-md-block sub-section-info">
            <h1 class="mb-5">5. Pago seguro</h1>
            <h3>El pago se libera cuando has finalizado el entrenamiento, solo pagas por los entrenamientos que hagas</h3>
        </div>
    </div>
    <!--Hasta que no se tengan imágenes o videos de los entrenamientos se dejará comentada esta sección
    <div class="section d-block" id="section6">
        <h1 class="mt-5 text-center overflow-text color-white">Experiencias InTraining</h1>
        <div id="myCarousel" class="carousel slide mt-5" data-ride="carousel">
            <div class="carousel-inner row w-75 mx-auto">
                <div class="carousel-item col-md-4 active">
                    <div class="card">
                        <video controls class="media-slider">
                            <source src="{{asset('video/video.mp4')}}" type="video/mp4">
                            Entrenamiento
                        </video>
                        <div class="card-body media-descripcion">
                            <h4 class="card-title">Card 1</h4>
                            <p class="card-text ellipsis">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item col-md-4">
                    <div class="card">
                        <video controls class="media-slider">
                            <source src="{{asset('video/video.mp4')}}" type="video/mp4">
                            Entrenamiento
                        </video>
                        <div class="card-body media-descripcion">
                            <h4 class="card-title">Card 2</h4>
                            <p class="card-text ellipsis">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item col-md-4">
                    <div class="card">
                        <video controls class="media-slider">
                            <source src="{{asset('video/video.mp4')}}" type="video/mp4">
                            Entrenamiento
                        </video>
                        <div class="card-body media-descripcion">
                            <h4 class="card-title">Card 3</h4>
                            <p class="card-text ellipsis">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item col-md-4">
                    <div class="card">
                        <video controls class="media-slider">
                            <source src="{{asset('video/video.mp4')}}" type="video/mp4">
                            Entrenamiento
                        </video>
                        <div class="card-body media-descripcion">
                            <h4 class="card-title">Card 5</h4>
                            <p class="card-text ellipsis">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>

            </div>
            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    -->

    <div class="section d-block text-center" id="section5">
        <h1 class="mt-5">¿Qué Esperas?</h1>
        <div class="h-50 d-flex">
            <div class="m-auto">
                <h3>¡Cumple tu meta <strong>Fitness</strong> con In Training!</h3>
                <a class="btn btn-success mt-5" style="font-size: 20px; padding: 7px 35px;" href="{{ route('register') }}">
                    Quiero Ser Fitness
                </a>
            </div>
        </div>

    </div>

    <div class="draggable purechat-button-expand" style="background-image: url(&quot;https://app.purechat.com/assets/spanish.c1fabaeb81f83ee3f3db.png&quot;) !important; background-size: cover; position: fixed; right: 0; bottom: 0; margin: 3vh; height: 80.55px !important; width: 90px !important; z-index: 9 !important;">

    </div>


    <footer style="margin: 0" class="footer-distributed">

        <div class="footer-left">

            <h3><span>Kangoo</span>Flow</h3>

            <!--<p class="footer-links">
                <a href="#quienesSomos">Quienes somos</a>
                ·
                <a href="#nuestoCompromiso">Nuestro compromiso</a>
                ·
                <a href="#mision">Mision</a>
                ·
                <a href="#valores">Valores</a>
                ·
                <a href="#equipo">Equipo de trabajo</a>
            </p>-->

            <p class="footer-company-name mt-4">Desarrollado por: Educlick &copy; 2018</p>
            <p class="footer-company-name">322 243 42 96</p>
        </div>

        <div class="footer-center">

            <!--<div>
                <i class="fa fa-map-marker"></i>
                <p><span>Calle 8A # 100-44</span> World trade center, Bogotá</p>
            </div>-->

            <div>
                <i class="fa fa-phone"></i>
                <p>322 243 42 96</p>
            </div>

            <div>
                <i class="fa fa-envelope"></i>
                <p><a href="mailto:soporte@exaltaclub.com">soporte@exaltaclub.com</a></p>
            </div>

        </div>

        <div class="footer-right">

            <p class="footer-company-about">

            </p>

            <div class="footer-icons">

                <!--<a href="#"><i class="fab fa-facebook"></i></a>-->
                <a href="https://www.instagram.com/exaltaclub/"><i class="fab fa-instagram"></i></a>

            </div>

        </div>

    </footer>

    <!--Script para que vuelva a la primer card cuando llegue a la última (slider ciclico)-->
    <script>
        $(document).ready(function() {
            var itemsPerSlide = 3;
            var totalItems = $(".carousel-item").length;
            if(itemsPerSlide >= totalItems){//se ocultan las flechas de mover el carrousel cuando tiene 3 o menos items para mostrar
                $("a[class^='carousel-control-']").css('display', 'none');
            }

            $("#myCarousel").on("slide.bs.carousel", function(e) {

                if(itemsPerSlide >= totalItems) {//solo se mueve el carousel cuando hay más de 3 cards
                    return false
                }

                var $e = $(e.relatedTarget);
                var idx = $e.index();
                console.log('indice: '+idx);
                if (idx >= totalItems - (itemsPerSlide - 1)) {
                    var it = itemsPerSlide - (totalItems - idx);
                    console.log('otro: '+it);
                    for (var i = 0; i < it; i++) {
                        // append slides to end
                        if (e.direction == "left") {
                            $(".carousel-item")
                                .eq(i)
                                .appendTo(".carousel-inner");
                        } else {
                            $(".carousel-item")
                                .eq(0)
                                .appendTo(".carousel-inner");
                        }
                    }
                    /*$(".media-slider").css('width', '100');*/
                }


            });
            /*$("#myCarousel").on("slid.bs.carousel", function(e) {
                $(".media-slider").css('width', '100%');
            });*/
        });
    </script>

    <!--subscribers-->
    <script type="text/javascript">
        var subscribersSiteId = 'cd602984-8642-4484-8a8b-431d84a5faf0';
    </script>
    <script type="text/javascript" src="https://cdn.subscribers.com/assets/subscribers.js"></script>

    <!--google analytics-->
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-128937544-1', 'auto');
        ga('send', 'pageview');
    </script>

    <!--chat de soporte-->
        <!--Para que se dragable pero que no muestre el chat al finalizar el drag-->
            <script>
                $(function() {
                    $( ".draggable" ).draggable({
                        stop: function(event, ui) {
                            $('.purechat-expanded').attr('style', 'display: none!important');
                        }
                    });
                    $( ".draggable" ).click(function(){
                        $('.purechat-expanded').attr('style', 'display: ');
                    });
                });
            </script>
            <!--<script src="https://code.jquery.com/jquery-1.9.1.js"></script> Si se deja se daña el slider y al parecer ya está en otro lugar o no se necesita porque se quita y aún así funciona correctamente el draggable.-->
            <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
        <!--fin Para que se dragable pero que no muestre el chat al finalizar el drag-->

        <script type='text/javascript' data-cfasync='false'>window.purechatApi = { l: [], t: [], on: function () { this.l.push(arguments); } }; (function () { var done = false; var script = document.createElement('script'); script.async = true; script.type = 'text/javascript'; script.src = 'https://app.purechat.com/VisitorWidget/WidgetScript'; document.getElementsByTagName('HEAD').item(0).appendChild(script); script.onreadystatechange = script.onload = function (e) { if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) { var w = new PCWidget({c: '1e110dc0-e024-4b2b-a871-4e07f3dec0d3', f: true }); done = true; } }; })();</script>
    <!--fin chat de soporte-->
    </body>
</html>
