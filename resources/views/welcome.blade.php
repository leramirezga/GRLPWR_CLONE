<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta name="google-site-verification" content="P_yEgFijsmcG-GjA_AgDfW4N384ev7ACxASfQB2n-2I" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>@lang('general.AppName')</title>
        <meta name="description" content="Recibe Ofertas de Entrenadores Personales, Compara y Elige al Entrenador Correcto por el Precio que Quieres"/>
        <link rel="canonical" href="{{env('APP_URL')}}/"/>

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

        <link rel="stylesheet" href="{{asset('css/chats.css')}}">

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{env('GTAG')}}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', '{{env('GTAG')}}');
        </script>
    </head>
    <body data-spy="scroll" data-target=".navbar">

    <!--Navbar color effect
    <script>
        $(window).on("scroll", function() {
            $("#top-navbar").css("backgroundColor", 'rgba(0, 0, 0, '+$(window).scrollTop());
        });
    </script>
    -->

    <nav id="top-navbar" class="navbar navbar-expand-md navbar-dark fixed-top">
        <a class="navbar-brand" href="#" style="width: 60px; padding: 0">
            <img src="{{asset('images/brand/logo_letras_blanco.png')}}" width="70%" height="70%">
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

    @if(session('msg'))
        <script>
            $(document).ready(function(){
                $('#msgModal').modal({show: true});
            });
        </script>
    @endif

    <div class="modal fade justify-content-center align-items-center" id="msgModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="background: none; border: none">
                <div class="modal-body" style="padding: 0 0 3vh 0">
                    <div class="alert bg-{{session('msg_level')}} color-white redondeado">
                        <p>{{session('msg')}}</p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div id="welcome" class="flex-center position-ref full-height">
        <div class="content">
            <div class="title mb-3">
                <img src="{{asset('images/brand/imago_fondo_oscuro.png')}}" width="50%" height="50%">
            </div>
            <h4 class="mb-5">El refugio donde las <strong style="font-size: xx-large">Mujeres</strong> desarrollan todo su <strong style="font-size: xx-large">Potencial</strong></h4>
            <button class="btn btn-success d-block ml-auto mr-auto" data-toggle="modal"
                    data-target="#scheduleCourtesyModal">¡Agendar Cortesía!
            </button>
        </div>
    </div>
    <div class="section" id="welcome">
        <div class="sub-section-info">
            <h1 class="mb-5">¿Porqué Girl Power?</h1>
            <p class="text-justify">
            En GRL PWR ofrecemos un refugio para que puedas encontrar y desarrollar todo tu POWER. Unimos cuerpo, mente y espíritu, para que te sientas cómoda entrenando en la gran variedad de ejercicios que ofrecemos.
            </p>
        </div>
        {{--
        <div class="boots-image d-flex align-items-center">
            <img class="h-100 w-100 how-works-image m-auto" src="{{asset('images/botas_2.png')}}" alt="First slide">
        </div>
        --}}
    </div>
    <div class="section text-center d-block" id="welcome">
        <h1>Modalidades</h1>

        <div id="immediateDeliveryCarousel" class="carousel slide mt-3" data-ride="carousel">
            <div id="innerImmediateDelivery" class="carousel-inner row mx-auto carousel-inner-cyclic" style="width: 75%">
                <div class="carousel-item carousel-item-cyclic col-12 itemDivImmediateDelivery my-5">
                    <a class="card-link">
                        <div class="card floating-card bg-semi-transparent p-0 carousel-card col-12 col-md-3 mx-auto"  style="min-width: 230px">
                            <div style="height: 70%; background-image: url('{{asset('images/funcional.jpg')}}'); background-size: cover; background-position: 70%"></div>
                            <div class="pt-2 px-3 text-center">
                                <h4><strong>Funcional</strong></h4>
                                <p><small>Entrenamiento semipersonalizado que mejora la vida diaria al fortalecer movimientos naturales y el núcleo, promoviendo la salud y la funcionalidad. 💪🏋️‍</small></p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="carousel-item carousel-item-cyclic col-12 itemDivImmediateDelivery my-5">
                    <a class="card-link ">
                        <div class="card floating-card bg-semi-transparent p-0 carousel-card col-12 col-md-3 mx-auto"  style="min-width: 230px">
                            <div style="height: 50%; background-image: url('{{asset('images/boxeo.jpg')}}'); background-size: cover; background-position: center"></div>
                            <div class="pt-2 px-3 text-center">
                                <h4 class="card-text"><small><strong>Boxeo</strong></small></h4>
                                <p><small>El boxeo es un arte marcial y deporte que combina fuerza, velocidad y estrategia, donde los puños son las herramientas de expresión, para desestresarte y sacar el fuego que llevas por dentro. 🥊 💥</small></p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="carousel-item carousel-item-cyclic col-12 itemDivImmediateDelivery my-5">
                    <a class="card-link ">
                        <div class="card floating-card bg-semi-transparent p-0 carousel-card col-12 col-md-3 mx-auto" style="min-width: 230px">
                            <div style="height: 70%; background-image: url('{{asset('images/actividad_kangoo.jpg')}}'); background-size: contain; background-position: center; background-repeat: no-repeat"></div>
                            <div class="pt-2 px-3 text-center">
                                <h4 class="card-text"><small><strong>Kangoo</strong></small></h4>
                                <p class="text-justify"><small>Entrenamiento de rebote con el que podrás quemar 1000 calorias en una clase de 1 hora, reduciendo el impacto en tus articulaciones hasta en un 80% 🦘</small></p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="carousel-item carousel-item-cyclic col-12 itemDivImmediateDelivery my-5">
                    <a class="card-link ">
                        <div class="card floating-card bg-semi-transparent p-0 carousel-card col-12 col-md-3 mx-auto" style="min-width: 230px">
                            <div style="height: 70%; background-image: url('{{asset('images/yoga.jpg')}}'); background-size: cover; background-position: 100%"></div>
                            <div class="pt-2 px-3 text-center">
                                <h4 class="card-text"><small><strong>Yoga</strong></small></h4>
                                <p class="text-justify"><small>Conecta cuerpo y mente a través de posturas, respiración y meditación, mejora tu equilibrio y bienestar con movimientos concientes. 🧘‍♀️🌼</small></p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="carousel-item carousel-item-cyclic col-12 itemDivImmediateDelivery my-5">
                    <a class="card-link ">
                        <div class="card floating-card bg-semi-transparent p-0 carousel-card col-12 col-md-3 mx-auto"  style="min-width: 230px">
                            <div style="height: 70%; background-image: url('{{asset('images/fitdance.jpg')}}'); background-size: cover; background-position: center"></div>
                            <div class="pt-2 px-3 text-center">
                                <h4 class="card-text"><small><strong>FitDance</strong></small></h4>
                                <p class="text-justify"><small>Quema calorias al ritmo de la música, cambiando de género cada 10 minutos en una clase dinámica y divertida 💃🕺🎶</small></p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <a class="carousel-control-prev-personalized carousel-control-cyclic immediateDeliveryControl" href="#immediateDeliveryCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next-personalized carousel-control-cyclic immediateDeliveryControl" href="#immediateDeliveryCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

    <div class="section text-center d-block color-white" id="welcome">
        <h1 class="text-center">
            Síguenos en nuestras redes sociales
        </h1>
        <div
            loading="lazy"
            data-mc-src="b0d5ad7d-5646-435f-9f97-9bb2c4e2f014#instagram">
        </div>
    </div>

    <!--
    <div class="section text-center d-block color-white">
        <h1 class="mb-5">Experiencias</h1>
        <div class="floating-card bg-dark p-3 mb-3 text-left col-8 col-md-6 mx-auto color-white">
            <div class="float-left">
                <img class="rounded-circle" height="48px" width="48px" alt="user"
                     src="{{asset('images/avatars/1')}}">
            </div>
            <div class="user-info d-inline-block w-auto">
                <h6>Camilo Hernandez</h6>
                <div class="fullRating-container"
                     style="min-width: calc(64px); max-width: calc(100px); width: calc(10vw);"></div>
                <img id="emptyRating" alt="rating" src="{{asset('images/empty_rating.png')}}">
            </div>
            <div style="height: 2.5vw; min-height: 16px; max-height: 25px;"></div>
            <blockquote class="blockquote" style="font-size: 1rem">
                    <h5 class="mb-0">"Me encanta"</h5>
                    <footer class="blockquote-footer">{{now()}}</footer>
            </blockquote>
        </div>

        <div class="floating-card bg-dark p-3 mb-3 text-left col-8 col-md-6 mx-auto color-white">
            <div class="float-left">
                <img class="rounded-circle" height="48px" width="48px" alt="user"
                     src="{{asset('images/avatars/2')}}">
            </div>
            <div class="user-info d-inline-block w-auto">
                <h6>Camilo Hernandez</h6>
                <div class="fullRating-container"
                     style="min-width: calc(64px); max-width: calc(100px); width: calc(10vw);"></div>
                <img id="emptyRating" alt="rating" src="{{asset('images/empty_rating.png')}}">
            </div>
            <div style="height: 2.5vw; min-height: 16px; max-height: 25px;"></div>
            <blockquote class="blockquote" style="font-size: 1rem">
                <h5 class="mb-0">"Me encanta"</h5>
                <footer class="blockquote-footer">{{now()}}</footer>
            </blockquote>
        </div>
    </div>
    -->

    <!--Pure Chat component
    <div class="draggable purechat-button-expand" style="background-image: url(&quot;https://app.purechat.com/assets/spanish.c1fabaeb81f83ee3f3db.png&quot;) !important; background-size: cover; position: fixed; right: 0; bottom: 0; margin: 3vh; height: 80.55px !important; width: 90px !important; z-index: 9 !important;"></div>
    -->

    <footer style="margin: 0" class="footer-distributed">

        <div class="footer-left">

            <img src="{{asset('images/brand/logo_letras_blanco.png')}}" width="70%" height="70%">

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


            <p class="footer-company-name mt-4 d-none d-md-block">Desarrollado por: Educlick &copy; 2018</p>
            <p class="footer-company-name d-none d-md-block">322 243 42 96</p>
        </div>

        <div class="footer-center">

            <div>
                <a href="https://goo.gl/maps/SZKV84zvwuorBJha8" target=”_blank”>
                    <i class="fa fa-map-marker"></i>
                    <p><span>Av. Esperanza #75-25</span> Modelia, Bogotá</p>
                </a>
            </div>

            <div>
                <a href="https://api.whatsapp.com/send/?phone=573123781174<&text=Hola,%20quiero%20conocer%20Girl%20Power&app_absent=0" target=”_blank”>
                    <i class="fa fa-phone"></i>
                    <p>312 378 11 74</p>
                </a>
            </div>

            <div>
                <i class="fa fa-envelope"></i>
                <p><a href="mailto:contacto@girlpower.com.co">contacto@girlpower.com.co</a></p>
            </div>

        </div>

        <div class="footer-right">
            <!--<a href="#"><i class="fab fa-facebook"></i></a>-->
            <a href="https://www.instagram.com/girlpowerstudio/">
                <i class="fab fa-instagram" style="font-size: 25px"></i>
                <p>@girlpowerstudio</p>
            </a>
        </div>

    </footer>

    <div class="floating_button">
        <div class="chats">
            <a href="https://api.whatsapp.com/send/?phone=573123781174<&text=Hola,%20quiero%20conocer%20Girl%20Power&app_absent=0" class="icon-whatsapp" target=”_blank”>
                <img class="icon" width="100%" height="100%" alt="whatsapp" src="{{asset('images/wathsapp_icon.png')}}">
            </a>
        </div>
    </div>

    @include('cliente.scheduleCourtesyModal')

    @stack('modals')

    <!--Instagram-->
    <script
            src="https://cdn2.woxo.tech/a.js#616af38872a6520016a29c25"
            async data-usrc>
    </script>

    <!--google analytics-->
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-128937544-1', 'auto');
        ga('send', 'pageview');
    </script>

    <script src="{{asset('js/bootstrap-swipe-carousel.min.js')}}" type="text/javascript"></script>

    <!--Script para carousel con items que vienen de backend-->
    <script>
        $(document).ready(function() {
            $(".carousel-item:first-child").addClass('active');
        });
    </script>

    <!--Scripts para que vuelvan a la primer card cuando llegue a la última (slider ciclico)-->
    <script>
        $(document).ready(function() {
            var totalItems = $(".itemDivAlmostReady").length;
            //console.log('totalItems: '+totalItems);//for debug purpose

            $("#almostReadyCarousel").on("slide.bs.carousel", function(e) {
                var $e = $(e.relatedTarget);
                var idx = $e.index();
                //console.log('index: '+idx);//for debug purpose
                if (idx == totalItems) {
                    var it = (totalItems - idx);
                    //console.log('otro: '+it);//for debug purpose
                    for (var i = 0; i < it; i++) {
                        // append slides to end
                        if (e.direction == "left") {//forward
                            $(".itemDivAlmostReady")
                                .eq(i)
                                .appendTo("#innerAlmostReady");
                        }
                    }
                    /*$(".media-slider").css('width', '100');*/
                }
                if (e.direction == "right") {
                    //console.log('index: '+idx);//for debug purpose
                    if(idx == 0){
                        $(".itemDivAlmostReady")
                            .eq(totalItems-1)
                            .prependTo("#innerAlmostReady");
                    }

                }
            });
            /*$("#myCarousel").on("slid.bs.carousel", function(e) {
                $(".media-slider").css('width', '100%');
            });*/
        });
    </script>

    @stack('scripts')

    </body>
</html>
