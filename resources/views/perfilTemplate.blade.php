@extends('cliente.clienteTemplate')

@section('title') Mi Perfil @endsection

@section('head-content')

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{asset('css/perfilCliente.css')}}">

    <!-- CSS Files -->
    <link href="{{asset('css/material-bootstrap-wizard.css')}}" rel="stylesheet" />

    <!--     Fonts and icons     -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />


    <!--datetimePicker-->
    <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
    <script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
    <script src="{{asset('js/datetimePicker.js')}}"></script>

    @stack('head-content')
@endsection

@section('content')


    <!--mostrar direccion-->
    <script>
        $(document).ready(function() {
            $('#mapModal').on('shown.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                document.getElementById('direccion').innerHTML = button.data('direccion');
            });
        });
    </script>
    <!-- Modal maps-->
    <div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubicacion <br/><small id="direccion"></small></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="map" style="height:80vh;"></div>
                </div>
            </div>
        </div>
    </div>

    <!--modal completar perfil-->
    @if($errors->completarPerfil->all() != null)
        <script>
            $(document).ready(function(){
                $('#completarPerfilModal').modal({show: true});
            });
        </script>
    @endif;

    <div class="modal fade" id="completarPerfilModal" tabindex="-1" role="dialog">
        <div class="modal-dialog wizard-completar-perfil" role="document">
            <div class="modal-content">
                <div class="modal-body" style="padding: 0 0 3vh 0">
                    @if ($errors->completarPerfil->all() != null)
                        <div class="alert alert-danger redondeado">
                            <ul>
                                @foreach($errors->completarPerfil->all() as $error)
                                    <li>
                                        <span class="invalid-feedback" role="alert" style="color: white">
                                            <strong>{{ $error}}</strong>
                                         </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!--      Wizard container        -->
                    <div class="wizard-container">
                        <div class="wizard-card" data-color="green" id="wizardProfile">
                            <!--enctype="multipart/form-data" en el form para que cargue la imagen cuando cambien la foto de perfil-->
                            <form id="actualizarPerfilForm" method="post" action="{{route('actualizarPerfil', ['user'=> Auth::user()->slug])}}" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <!--        You can switch " data-color="purple" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                                <div class="wizard-header">
                                    <h3 class="wizard-title">
                                        Completa tu perfil
                                    </h3>
                                    <h5>Esta información nos permite conocerte mejor</h5>
                                </div>
                                <div class="wizard-navigation">
                                    <ul>
                                        <li><a class="tab-completar-perfil" href="#about" data-toggle="tab">Información básica</a></li>
                                        <li><a class="tab-completar-perfil" href="#contact" data-toggle="tab" disabled="true">Información de contacto</a></li>
                                        <li><a class="tab-completar-perfil" href="#address" data-toggle="tab">@yield('tab3Title')</a></li>
                                    </ul>
                                </div>

                                <div class="tab-content">
                                    <div class="tab-pane" id="about">
                                        <div class="row">
                                            <h4 class="info-text"></h4>
                                            <div class="col-sm-4 offset-sm-1 mb-3">
                                                <div class="picture-container">
                                                    <div class="picture">
                                                        <img src="{{asset('images/avatars/'.$user->foto)}}?{{time()}}" class="picture-src" id="wizardPicturePreview" title=""/>
                                                        <input type="file" id="wizard-picture" name="avatar" accept="image/*">
                                                    </div>
                                                    <h6>Carga una foto de perfil</h6>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="input-group">
                                                                    <span class="iconos">
                                                                        <i class="material-icons">face</i>
                                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Nombres <small>(requerido)</small></label>
                                                        <input name="firstname" type="text" class="form-control" value="{{$user->nombre}}">
                                                    </div>
                                                </div>

                                                <div class="input-group">
                                                                    <span class="iconos">
                                                                        <i class="material-icons">record_voice_over</i>
                                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Primer apellido <small>(requerido)</small></label>
                                                        <input name="lastname" type="text" class="form-control" value="{{$user->apellido_1}}">
                                                    </div>
                                                </div>

                                                <div class="input-group">
                                                                    <span class="iconos">
                                                                        <i class="material-icons">record_voice_over</i>
                                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Segundo apellido <small>(opcional)</small></label>
                                                        <input name="lastname2" type="text" class="form-control" value="{{$user->apellido_2}}">
                                                    </div>
                                                </div>

                                                <div class='input-group' id="datepicker">
                                                                <span class="iconos">
                                                                    <i class="material-icons">calendar_today</i>
                                                                </span>
                                                    <div id="dateContainer" class="form-group label-floating">
                                                        <label class="control-label">Fecha de nacimiento <small>(requerido)</small></label>
                                                        @if($user->fecha_nacimiento != null)
                                                            <input name="dateborn" class="form-control input-group-addon" type="text" value="{{$user->fecha_nacimiento->format('d/m/Y')}}">
                                                        @else
                                                            <input name="dateborn" class="form-control input-group-addon" type="text">
                                                        @endif
                                                    </div>
                                                </div>
                                                @yield('generoEntrenador')
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="contact">
                                        <div class="col-12 p-0 col-md-9 m-auto">
                                            <h4 class="info-text"></h4>
                                            <div class="col-sm-12">
                                                <div class="input-group">
                                                    <span class="iconos">
                                                        <i class="material-icons">place</i>
                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Ciudad <small>(requerido)</small></label>
                                                        <select class="form-control" name="ciudad">
                                                            <option disabled selected value style="display:none"></option>
                                                            <option value="bogota" {{$user->ciudad === 'bogota' ? "selected" : ""}}>Bogotá</option>
                                                            <option value="medellin" {{$user->ciudad === 'medellin' ? "selected" : ""}}>Medellin</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="input-group">
                                                                    <span class="iconos">
                                                                        <i class="material-icons">phone_iphone</i>
                                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Télefono celular <small>(requerido)</small></label>
                                                        <input name="numCel"  class="form-control" value="{{$user->telefono}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="input-group">
                                                                    <span class="iconos">
                                                                        <i class="material-icons">email</i>
                                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Correo eléctronico <small>(requerido)</small></label>
                                                        <input name="email" type="email" class="form-control deshabilitado" value="{{$user->email}}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            @yield('tab2AditionalContent')
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="address">
                                        @yield('tab3Content')
                                    </div>
                                </div>
                                <div class="wizard-footer">
                                    <div class="float-right">
                                        <input type='button' class='btn btn-next btn-fill btn-success btn-wd' name='next' value='Siguiente' />
                                        <input type='submit' class='btn btn-finish btn-fill btn-success btn-wd' name='finish' value='Finalizar' onclick="validar()"/>
                                    </div>

                                    <div class="float-left">
                                        <input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous' value='Atrás' />
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- end wizard container -->
                </div>
            </div>
        </div>
    </div>

    @include('crearBlogModal')

    @yield('modals')

    <!--modal dar review-->
    <div class="modal fade" id="reviewModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" action="{{route('finalizarEntrenamiento')}}" autocomplete="off">
                    @csrf

                    <input type="hidden" name="rating" id="rating">
                    <input type="hidden" name="entrenamientoReview" id="entrenamientoReview">
                    
                    <div class="modal-header" style="border-bottom: none">
                        <h5 class="modal-title">¿Que tal estuvo tu entrenamiento?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding-bottom: 0">
                        <img style="width: 200px; height: 50px; margin-bottom: 0" alt="rating" src="{{asset('images/empty_rating.png')}}">
                        <div style="width: 200px; height: 1px" class="mb-3">
                            <div id="rating1" class="dar-rating" style="width: calc(40px); z-index: 5;" onclick="darRating(this)"></div>
                            <div id="rating2" class="dar-rating" style="width: calc(80px); z-index: 4;" onclick="darRating(this)"></div>
                            <div id="rating3" class="dar-rating" style="width: calc(120px); z-index: 3;" onclick="darRating(this)"></div>
                            <div id="rating4" class="dar-rating" style="width: calc(160px); z-index: 2;" onclick="darRating(this)"></div>
                            <div id="rating5" class="dar-rating" style="width: calc(200px); z-index: 1;" onclick="darRating(this)"></div>
                            <div id="ratingSeleccionado"></div>
                            <script>
                                function darRating(rating) {
                                    var numeroRating = rating.id.substring(6, 7);
                                    $('#rating'+document.getElementById('rating').value).removeClass('dar-rating-seleccionado');
                                    document.getElementById('rating').value= numeroRating;
                                    $('#ratingSeleccionado').css('width', 200*numeroRating/5+'px');
                                }

                                $('.dar-rating').mouseover(function () {
                                    $('#ratingSeleccionado').css('display', 'none');
                                });
                                $('.dar-rating').mouseleave(function () {
                                    $('#ratingSeleccionado').css('display', 'block');
                                });
                            </script>
                        </div>
                        <p>Review:</p>
                        <textarea class="text-area d-block form-control h-auto" maxlength="140" style="width: 100%;" placeholder="Puedes escribir un comentario sobre {{(strcasecmp ($user->rol, 'entrenador' ) == 0) ? 'el atleta' : 'tu entrenador'}}" rows="3" type="text" name="review"></textarea>
                    </div>
                    <div class="modal-footer" style="border-top: 0; padding-top: 0">
                        <button type="submit" class="btn btn-success">Finalizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="d-md-flex">
            <div class="floating-card bg-semi-transparent perfil-container m-3">
                <img src="{{asset('images/avatars/'.$user->foto)}}?{{time()}}" class="user-profile-icon">
                @if(!$visitante)
                    
                    @if((strcasecmp ($user->rol, 'entrenador' ) == 0 && $user->entrenador == null) || (strcasecmp ($user->rol, 'cliente' ) == 0 && $user->cliente == null))
                        <div class="progress bg-dark ml-auto mr-auto" style="width: 80%;">
                            <div class="progress-bar bg-white" role="progressbar" style="width: 25%; color: black" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                        </div>
                        <button class="btn btn-success d-block ml-auto mr-auto"  data-toggle="modal" data-target="#completarPerfilModal">Completar perfil</button>
                    @else
                        <button class="btn btn-success d-block ml-auto mr-auto"  data-toggle="modal" data-target="#completarPerfilModal">Editar perfil</button>
                    @endif

                @endif
                <img style="width: 100px; height: 25px; margin-bottom: 0" alt="rating" src="{{asset('images/empty_rating.png')}}">
                <div style="margin: 0 auto 3vh auto; width: 100px; height: 1px">
                    <div class="fullRating-container" style="width: calc(100px*{{$user->ratingPorcentage()}}); height: 25px; margin-top: -25px;"></div>
                </div>
                <h4>{{$user->nombre}} {{$user->apellido_1}}</h4>
                <p>@yield('tipoUsuario')</p>
                <p>{{$user->edad}}</p>
                @yield('medidasCliente')
            </div>
            <div id="right-div" class="ml-md-auto m-3">
                @yield('card1')
                @yield('card2')
                <div class="floating-card bg-semi-transparent p-3 mb-3">
                    <h3 class="mb-5">Reviews ({{$user->reviews->count()}}):</h3>
                    @foreach($user->reviews as $review)
                        <div class="floating-card bg-dark p-3 mb-3">
                            <div class="float-left">
                                <img class="rounded-circle" height="48px" width="48px" alt="user" src="{{asset('images/avatars/'.$review->reviewer->foto)}}">
                            </div>

                            <div class="user-info d-inline-block">
                                <h4>{{$review->reviewer->nombre}}</h4>
                                <div class="fullRating-container" style="min-width: calc(64px*{{$review->rating/5}}); max-width: calc(100px*{{$review->rating/5}}); width: calc(10vw*{{$review->rating/5}});"></div>
                                <img id="emptyRating" alt="rating" src="{{asset('images/empty_rating.png')}}">
                            </div>
                            <div style="height: 2.5vw; min-height: 16px; max-height: 25px;"></div>
                            <blockquote class="blockquote">
                                @if($review->review != null)
                                    <p class="mb-0">"{{$review->review}}"</p>
                                @endif
                                <footer class="blockquote-footer">{{$review->tiempo()}}</footer>
                            </blockquote>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        $('.counter-count').each(function () {
            $(this).prop('Counter',0).animate({
                Counter: $(this).text()
            }, {
                duration: 3000,
                easing: 'swing',
                step: function (now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });
    </script>

    @yield('scripts')
    <!--   Core JS Files   -->

    <script src="{{asset('js/jquery.bootstrap.js')}}" type="text/javascript"></script>

    <!--  Plugin for the Wizard -->
    <script src="{{asset('js/validar-completarPerfil.js')}}"></script>

    <!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->f
    <script src="{{asset('js/jquery.validate.min.js')}}"></script>

    <!--datetimePicker configuration-->
    <script>
        $(function () {
            var actualDate = new Date();
            actualDate.setHours(23,59);
            $('#datepicker').datetimepicker({
                ignoreReadonly: true,
                format: 'DD/MM/YYYY',
                maxDate: actualDate,
                locale: 'es',
                useCurrent: false //Para que con el max date no quede seleccionada por defecto esa fecha
            });
            $("#datepicker").on("dp.change", function (e) {
                if(e.date == ''){
                    $("#dateContainer").addClass( "is-empty" );
                }else{
                    $("#dateContainer").removeClass( "is-empty" );
                }
            });
        });
    </script>

    <!--script para solucionar el scroll que no funciona cuando un segundo modal se abre-->
    <script>
        $(document).on('hidden.bs.modal', '.modal', function () {
            $('.modal:visible').length && $(document.body).addClass('modal-open');
        });
    </script>

    <!--Maps-->
    <script>
        var map;
        var marker;

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -34.397, lng: 150.644},
                zoom: 16
            });
        }

        function cargarUbicacion(solicitud) {

            initMap();

            var location = {
                lat: Number(solicitud.latitud),
                lng: Number(solicitud.longitud)
            };

            crearMarker(map, location);

            map.setCenter(location);
        }

        function crearMarker(map, location, draggable) {
            marker = new google.maps.Marker({
                position:location,
                draggable:draggable,
                map:map
            });
        }
    </script>
    <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDjn6uQjll2HhwGi8L5_QTs4bAxAjqh5E0&libraries=geometry&callBack=initMap">
    </script>
@endsection