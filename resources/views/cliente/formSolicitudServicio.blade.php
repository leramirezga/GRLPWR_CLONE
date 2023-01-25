@extends('layouts.app')

@section('head-content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--     Fonts and icons     -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons"/>

    <!--datetimePicker-->
    <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css"
          rel="stylesheet">
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
    <script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
    <script src="{{asset('js/datetimePicker.js')}}"></script>

    <link href="{{asset('css/crearSolicitudServicio.css')}}" rel="stylesheet"/>
@endsection

@section('content')

    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger redondeado">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>
                        <span class="invalid-feedback" role="alert" style="color: white">
                            <strong>{{ $error}}</strong>
                         </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="floating-card bg-semi-transparent mb-5">
            <div class="wizard-container">
                <div class="wizard-card" data-color="green" id="wizardProfile">
                    @section('form')
                        <!--parametros obtenidos del marker en maps-->
                        <input type="hidden" id="ciudad" name="ciudad"
                               value="{{!empty($solicitud) ? $solicitud->ciudad : ''}}">
                        <input type="hidden" id="latitud" name="latitud"
                               value="{{!empty($solicitud) ? $solicitud->latitud : ''}}">
                        <input type="hidden" id="longitud" name="longitud"
                               value="{{!empty($solicitud) ? $solicitud->longitud : ''}}">
                        <input type="hidden" id="tags" name="tags">


                        <!--        You can switch " data-color="purple" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                        <div class="wizard-header">
                            <h3 class="wizard-title" style="color: white!important;">
                                @yield('titulo')
                            </h3>
                        </div>
                        <div class="wizard-navigation">
                            <ul>
                                <li><a class="tab-completar-perfil" href="#about" data-toggle="tab">Descripción</a></li>
                                <li><a class="tab-completar-perfil" href="#sesiones" data-toggle="tab" disabled="true">Sesiones</a>
                                </li>
                                <li><a class="tab-completar-perfil" href="#lugar" data-toggle="tab" disabled="true">Fecha
                                        y lugar</a></li>
                            </ul>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane" id="about"><!--Debe quedar about para que quede activo-->
                                <div class="col-12 p-0 col-md-9 m-auto">
                                    <h4 class="info-text"></h4>

                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <div class="form-group label-floating w-100"><!--mt-5
                                                <span class="d-none d-md-block">
                                                    <label id="label-titulo" class="control-label">Titulo del entrenamiento <small>(requerido)</small></label>
                                                </span>
                                                <span class="d-block d-md-none">
                                                    <label id="label-titulo" class="control-label">Actividad <small>(requerido)</small></label>
                                                </span>-->
                                                <input id="titulo" name='titulo' placeholder="Titulo (requerido)"
                                                       class="form-control color-white" style="font-size: 30px"
                                                       value="{{ old('titulo', !empty($solicitud) ? $solicitud->titulo : '') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="comment" style="font-size: 20px">Más detalles:
                                                <small>(opcional)</small></label>
                                            <textarea name="descripcion" style="font-size: 20px" maxlength="140"
                                                      class="form-control h-auto color-white"
                                                      rows="3">{{ old('descripcion', !empty($solicitud) ? $solicitud->descripcion : '') }}</textarea>
                                        </div>
                                    </div>
                                    <div>
                                        <div id="tags-container" class="d-inline-block">
                                            <div class="d-inline-block mb-3">
                                                <div class="tag">
                                                    <input id="tag0" onblur="fadeOutAutocompletar(this)"
                                                           onkeyup="autoCompletar(this)"
                                                           style="width: 10vw; min-width: 100px; color: white; text-align: center"
                                                           placeholder="tag" type="text" name="tag"
                                                           value="{{ old('tag', !empty($tags) ? $tags->get()[0]->tag->descripcion : '')}}">
                                                </div>
                                                <div id="tagList0" class="floating tagList"
                                                     style="position: absolute!important;">
                                                    <!--position absolute evita que cuando sea el paso actual quede dentro del div de creaci+pn-->
                                                </div>
                                            </div>
                                            @if(!empty($tags))
                                                @for ($i = 1; $i < $tags->count(); $i++)
                                                    <div class="d-inline-block mb-3">
                                                        <div class="tag bg-base">
                                                            <button id="removeTag{{$i}}" onclick="removeTag(this)"
                                                                    type="button" class="close" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                            <input id="tag{{$i}}"
                                                                   value="{{$tags->get()[$i]->tag->descripcion}}"
                                                                   style="width: 10vw; min-width: 100px; color: white; text-align: center"
                                                                   placeholder="tag" type="text"
                                                                   onchange="pushTag(this)"
                                                                   onkeyup="autoCompletar(this)"
                                                                   onblur="fadeOutAutocompletar(this)">
                                                        </div>
                                                        <div id="tagList{{$i}}" class="floating tagList">
                                                        </div>
                                                    </div>
                                                @endfor
                                            @endif
                                        </div>
                                        <img class="banner-icon" onclick="addTag()" src="{{asset('images/add.png')}}">
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="sesiones">
                                <h4 class="info-text">¿Cuántos entramientos quieres agendar? </h4>
                                <div class="row mt-2">
                                    <div class="col-sm-4 m-auto text-center">
                                        <input id="checkboxUnico" class="checkbox-input" type="radio"
                                               name="cantidadSesiones"
                                               value="0" {{ old('cantidadSesiones') != null && old('cantidadSesiones') == \App\Utils\Constantes::UNICA_SESION || ((isset($solicitud) &&  $solicitud->tipo == \App\Utils\Constantes::UNICA_SESION)) ? 'checked=checked' : ''}}>
                                        <!--tiene que tener el checkeo de null porque de lo contrario siempre lo iniciaba seleccionado-->
                                        <label for="checkboxUnico" class="checkbox-image">
                                            <i class="material-icons" style="font-size: 55px">event</i>
                                        </label>
                                        <h6>UNA SESIÓN</h6>
                                    </div>
                                    <div class="col-sm-4 m-auto text-center">
                                        <input id="checkboxVarios" class="checkbox-input" type="radio"
                                               name="cantidadSesiones"
                                               value="1" {{ old('cantidadSesiones') == \App\Utils\Constantes::VARIAS_SESIONES || (isset($solicitud) &&  $solicitud->tipo == \App\Utils\Constantes::VARIAS_SESIONES) ? 'checked=checked' : ''}}>
                                        <label for="checkboxVarios" class="checkbox-image">
                                            <i class="far fa-calendar-alt"></i>
                                        </label>
                                        <h6>VARIAS SESIONES</h6>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="lugar">
                                <div class="row mt-2">

                                    <div id="map-container" class="col-sm-6 mb-3" style="height: 50vh;">
                                        <div id="map" class="d-block" style="height:100%;"></div>
                                    </div>
                                    <div id="fecha-lugar-container" class="m-auto">
                                        <div class="input-group">
                                            <span class="iconos">
                                                <i class="material-icons">place</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <input id="input-lugar" placeholder="" type="text"
                                                       class="form-control color-white" name="direccion" required
                                                       value="{{ old('direccion', !empty($solicitud) ? $solicitud->direccion : '') }}">
                                                <!--Debe tener placeholder porque el autocompletar dirección de google le pone placeholder-->
                                                <label id="label-lugar" class="control-label">Lugar
                                                    <small>(requerido)</small></label>
                                            </div>
                                        </div>
                                        <div id="unicaSesion">
                                            <div class='input-group datepicker' id="fecha">
                                                <span class="iconos">
                                                    <i class="material-icons">calendar_today</i>
                                                </span>
                                                <div class="form-group label-floating dateContainer" id="fecha-label">
                                                    <label class="control-label">Fecha
                                                        <small>(requerido)</small></label>
                                                    <input name="fecha"
                                                           class="form-control input-group-addon color-white"
                                                           type="text"
                                                           value="{{ old('fecha', isset($solicitud) && $solicitud->horarios->first() != null ? $solicitud->horarios->first()->fecha->format('d-m-Y') : '') }}">
                                                </div>
                                            </div>
                                            <div class='input-group horaInicial' id="horaInicial">
                                                <span class="iconos">
                                                    <i class="material-icons">schedule</i>
                                                </span>
                                                <div class="form-group label-floating horaInicio" id="horaInicio">
                                                    <label class="control-label">Hora inicio <small>(requerido)</small></label>
                                                    <input name="horaInicio"
                                                           class="form-control input-group-addon color-white"
                                                           type="text"
                                                           value="{{ old('horaInicio', isset($solicitud) && $solicitud->horarios->first() != null ? $solicitud->horarios->first()->hora_inicio->format('g:i A') : '') }}">
                                                </div>
                                            </div>
                                            <div class='input-group horaFinal' id="horaFinal">
                                                <span class="iconos">
                                                    <i class="material-icons">schedule</i>
                                                </span>
                                                <div class="form-group label-floating horaFin" id="horaFin">
                                                    <label class="control-label">Hora finalización
                                                        <small>(requerido)</small></label>
                                                    <input name="horaFin"
                                                           class="form-control input-group-addon color-white"
                                                           type="text"
                                                           value="{{ old('horaFin', isset($solicitud) && $solicitud->horarios->first() != null ? $solicitud->horarios->first()->hora_fin->format('g:i A') : '') }}">
                                                </div>
                                            </div>
                                            <script>
                                                $(document).ready(function () {
                                                    $("#horaInicial").on("dp.change", function (e) {//Para que el label suba cuando seleccionan la fecha
                                                        if (e.date == '') {
                                                            $("#horaInicio").addClass("is-empty");
                                                        } else {
                                                            $("#horaInicio").removeClass("is-empty");
                                                        }
                                                    });
                                                    $("#horaFinal").on("dp.change", function (e) {//Para que el label suba cuando seleccionan la fecha
                                                        if (e.date == '') {
                                                            $("#horaFin").addClass("is-empty");
                                                        } else {
                                                            $("#horaFin").removeClass("is-empty");
                                                        }
                                                    });
                                                });
                                            </script>
                                        </div>

                                        <div id="variasSesiones">
                                            <div class="d-md-flex">
                                                <div class='input-group datepicker' id="fechaInicio">
                                                    <span class="iconos">
                                                        <i class="material-icons">calendar_today</i>
                                                    </span>
                                                    <div class="form-group label-floating dateContainer"
                                                         id="fechaInicio-label">
                                                        <label class="control-label">Fecha inicio
                                                            <small>(requerido)</small></label>
                                                        <input name="fechaInicio"
                                                               class="form-control input-group-addon color-white"
                                                               type="text"
                                                               value="{{ old('fechaInicio', isset($solicitud->programacion) ? $solicitud->programacion->fecha_inicio->format('d-m-Y') : '') }}">
                                                    </div>
                                                </div>
                                                <div class='input-group datepicker' id="fechaFin">
                                                    <span class="iconos">
                                                        <i class="material-icons">calendar_today</i>
                                                    </span>
                                                    <div class="form-group label-floating dateContainer"
                                                         id="fechaFin-label">
                                                        <label class="control-label">Fecha finalización <small>(requerido)</small></label>
                                                        <input name="fechaFin"
                                                               class="form-control input-group-addon color-white"
                                                               type="text"
                                                               value="{{ old('fechaFin', isset($solicitud->programacion) ? $solicitud->programacion->fecha_finalizacion->format('d-m-Y') : '') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            @for ($i = 3; $i < 3+7; $i++)
                                                <!--Porque la fecha de aniversario empieza en viernes-->
                                                {{old('diasSemana.*')}}
                                                <div class="form-check">
                                                    <label data-toggle="collapse" data-target="#collapse{{$i-3}}"
                                                           aria-expanded="false" aria-controls="collapse{{$i-3}}"
                                                           class="check-container">
                                                        {{ucfirst(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l'))}}
                                                        <input type="checkbox" name="diasSemana[{{$i-3}}]"
                                                               value="{{$i-2}}" {{ old('diasSemana.'.($i-3), isset($solicitud->programacion) && ($solicitud->programacion->{App\Utils\Utils::normalize(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l'))}) != null) ? 'checked=checked' : ''}}>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                                <div id="collapse{{$i-3}}" aria-expanded="false"
                                                     class="collapse {{ old('diasSemana.'.($i-3), isset($solicitud->programacion) && ($solicitud->programacion->{App\Utils\Utils::normalize(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l'))}) != null) ? 'show' : ''}}">
                                                    <div class="d-flex">
                                                        <div class='input-group horaInicial'
                                                             id="horaInicial{{ucfirst(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l'))}}">
                                                        <span class="iconos mt-3">
                                                            <i class="material-icons">schedule</i>
                                                        </span>
                                                            <div class="form-group label-floating mt-3"
                                                                 id="horaInicio{{ucfirst(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l'))}}">
                                                                <label class="control-label">Hora inicio <small>(requerido)</small></label>
                                                                <input name="horaInicio{{ucfirst(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l'))}}"
                                                                       class="form-control input-group-addon color-white"
                                                                       type="text"
                                                                       value="{{ old('horaInicio'.ucfirst(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l')), isset($solicitud->programacion) && ($solicitud->programacion->{'hora_inicio_'.App\Utils\Utils::normalize(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l'))} != null) ? $solicitud->programacion->{'hora_inicio_'.App\Utils\Utils::normalize(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l'))}->format('g:i A') : '') }}">
                                                            </div>
                                                        </div>
                                                        <div class='input-group horaFinal'
                                                             id="horaFinal{{ucfirst(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l'))}}">
                                                        <span class="iconos mt-3">
                                                            <i class="material-icons">schedule</i>
                                                        </span>
                                                            <div class="form-group label-floating mt-3"
                                                                 id="horaFin{{ucfirst(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l'))}}">
                                                                <label class="control-label">Hora finalización <small>(requerido)</small></label>
                                                                <input name="horaFin{{ucfirst(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l'))}}"
                                                                       class="form-control input-group-addon color-white"
                                                                       type="text"
                                                                       value="{{ old('horaFin'.ucfirst(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l')), isset($solicitud->programacion) && ($solicitud->programacion->{'hora_fin_'.App\Utils\Utils::normalize(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l'))} != null) ? $solicitud->programacion->{'hora_fin_'.App\Utils\Utils::normalize(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l'))}->format('g:i A') : '') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <script>
                                                    $(document).ready(function () {
                                                        $("#horaInicial" + "{{ucfirst(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l'))}}").on("dp.change", function (e) {//Para que el label suba cuando seleccionan la fecha
                                                            if (e.date == '') {
                                                                $("#horaInicio" + "{{ucfirst(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l'))}}").addClass("is-empty");
                                                            } else {
                                                                $("#horaInicio" + "{{ucfirst(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l'))}}").removeClass("is-empty");
                                                            }
                                                        });
                                                        $("#horaFinal" + "{{ucfirst(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l'))}}").on("dp.change", function (e) {//Para que el label suba cuando seleccionan la fecha
                                                            if (e.date == '') {
                                                                $("#horaFin" + "{{ucfirst(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l'))}}").addClass("is-empty");
                                                            } else {
                                                                $("#horaFin" + "{{ucfirst(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l'))}}").removeClass("is-empty");
                                                            }
                                                        });
                                                    });
                                                </script>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wizard-footer">
                            <div class="float-right">
                                <input type='button' class='btn btn-next btn-fill btn-success btn-wd' name='next'
                                       value='Siguiente' onclick="validar()"/>
                                <input type='submit' class='btn btn-finish btn-fill btn-success btn-wd' name='finish'
                                       value='Finalizar'/>
                            </div>

                            <div class="float-left">
                                <input type='button' class='btn btn-previous btn-fill btn-default btn-wd'
                                       name='previous' value='Atrás'/>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    @show
                </div>
            </div>
        </div>
    </div>


    <!--Selección número de sesiones-->
    <script>
        $(document).ready(function () {
            if ("{{old('cantidadSesiones') == \App\Utils\Constantes::UNICA_SESION || (isset($solicitud) &&  $solicitud->tipo == \App\Utils\Constantes::UNICA_SESION)}}") {
                document.getElementById("variasSesiones").style.display = "none";
                document.getElementById("unicaSesion").style.display = "block";
                $('#map-container').addClass('offset-sm-1');
                $('#fecha-lugar-container').addClass('col-sm-4');
                $('#fecha-lugar-container').removeClass('col-sm-6');
            }
            if ("{{old('cantidadSesiones') == \App\Utils\Constantes::VARIAS_SESIONES || (isset($solicitud) &&  $solicitud->tipo == \App\Utils\Constantes::VARIAS_SESIONES)}}") {
                document.getElementById("variasSesiones").style.display = "block";
                document.getElementById("unicaSesion").style.display = "none";
                $('#map-container').removeClass('offset-sm-1');
                $('#fecha-lugar-container').removeClass('col-sm-4');
                $('#fecha-lugar-container').addClass('col-sm-6');
            }
            $("#checkboxUnico").change(function () {
                $('#map-container').addClass('offset-sm-1');
                $('#fecha-lugar-container').addClass('col-sm-4');
                $('#fecha-lugar-container').removeClass('col-sm-6');
                $("#variasSesiones").hide();
                $("#unicaSesion").show();
            });
            $("#checkboxVarios").change(function () {
                $('#map-container').removeClass('offset-sm-1');
                $('#fecha-lugar-container').removeClass('col-sm-4');
                $('#fecha-lugar-container').addClass('col-sm-6');
                $("#variasSesiones").show();
                $("#unicaSesion").hide();
            });
            $('.checkbox-input').change(function () {
                $('.checkbox-image').css("border-color", "");
                $('.checkbox-image').css("color", "");
            });
        });

        <!--Validar la seleccion del número de sesiones-->
        function validar() {
            if (typeof $("input[name='cantidadSesiones']:checked").val() === "undefined") {
                $('.checkbox-image').css("cssText", "color: red!important;")
                $('.checkbox-image').css("border-color", "red");
            }
        }
    </script>

    <!--datetimePicker configuration-->
    <script>
        $(function () {

        });
    </script>

    <!--Tags-->
    <script>
        var tags = new Map();
        var contadorTags = 0;

        $(document).ready(function () {

            loadFromEdit();

            $(document).on('click', 'li', function () {
                var tagListContainer = this.parentElement.parentElement;
                var id = tagListContainer.id.substring(tagListContainer.id.length - 1, tagListContainer.id.length);
                var input = 'tag' + id;
                $('#' + input).val($(this).text());
                $('#tagList' + id).fadeOut();
            });
        });

        function loadFromEdit() {
            contadorTags = {{!empty($tags) ? $tags->count() : 0}};

            for (var i = 0; i < contadorTags; i++) {//para que guarde los tags que ya tiene
                $('input[id=tag' + i + ']').trigger("change");
            }

        }

        function autoCompletar(input) {
            var id = input.id.substring(input.id.length - 1, input.id.length);
            var query = input.value;
            if (query != '') {
                //var _token = ('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('autocomplete.fetch') }}",
                    method: "POST",
                    data: {query: query},
                    success: function (data) {
                        if (data.includes('<li')) {//solo cuando trae resultado muestra el div
                            $('#tagList' + id).fadeIn();
                            $('#tagList' + id).html(data);
                        } else {
                            $('#tagList' + id).fadeOut();
                        }
                    },
                });
            }
        }

        function fadeOutAutocompletar(input) {
            var id = input.id.substring(input.id.length - 1, input.id.length);
            $('#tagList' + id).fadeOut();
        }

        function removeTag(elementToDelete) {
            var id = elementToDelete.id;
            var tagToDelete = 'tag' + id.substring(id.length - 1, id.length);
            tags.delete(tagToDelete);
            elementToDelete.parentElement.remove();
            asignTagToInput()
        }

        function addTag() {

            contadorTags++;
            $('#tags-container').append(
                '<div class="d-inline-block mb-3">\n' +
                '<div class="tag bg-base">\n' +
                '<button id="removeTag' + contadorTags + '" onclick="removeTag(this)" type="button" class="close" aria-label="Close">\n' +
                '<span aria-hidden="true">&times;</span>\n' +
                '</button>\n' +
                '<input id="tag' + contadorTags + '" style="width: 10vw; min-width: 100px; color: white; text-align: center" placeholder="tag" type="text" onchange="pushTag(this)" onkeyup="autoCompletar(this)" onblur="fadeOutAutocompletar(this)">\n' +
                '</div>\n' +
                '<div id="tagList' + contadorTags + '" class="floating tagList">\n' +
                '</div>\n' +
                '</div>'
            );
        }

        function pushTag(input) {
            tags.set(input.id, input.value);
            asignTagToInput();
        }

        function asignTagToInput() {
            var arrayTags = [];
            tags.forEach(function (value, key, map) {
                arrayTags.push(value);
            });
            document.getElementById('tags').value = arrayTags;
        }
    </script>

    <!--Maps-->
    <script>
        // Note: This example requires that you consent to location sharing when
        // prompted by your browser. If you see the error "The Geolocation service
        // failed.", it means you probably did not give permission for the browser to
        // locate you.
        var map, infoWindow;
        var marker;
        var geocoder;

        function initMap() {
            geocoder = new google.maps.Geocoder();

            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -34.397, lng: 150.644},
                zoom: 16
            });

            // Try HTML5 geolocation.
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var location;
                    var latitud = {{isset($solicitud ) ? $solicitud->latitud : 0}};
                    var longitud = {{isset($solicitud ) ? $solicitud->longitud : 0}};
                    if (latitud != 0 && longitud != 0) {
                        location = {
                            lat: latitud,
                            lng: longitud
                        };
                    } else {
                        location = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                    }


                    crearMarker(map, location);
                    getAddress(location, true);

                    map.setCenter(location);

                    google.maps.event.addListener(map, 'click', function (event) {
                        reubicarMarcador(map, event.latLng);
                    });
                }, function () {
                    handleLocationError(true, infoWindow, map.getCenter());
                });
            } else {
                // Browser doesn't support Geolocation
                handleLocationError(false, infoWindow, map.getCenter());
            }

            var input = document.getElementById('input-lugar');
            var autocomplete = new google.maps.places.Autocomplete(input);

            // Bind the map's bounds (viewport) property to the autocomplete object,
            // so that the autocomplete requests use the current map bounds for the
            // bounds option in the request.
            autocomplete.bindTo('bounds', map);

            // Set the data fields to return when the user selects a place.
            autocomplete.setFields(
                ['address_components', 'geometry', 'icon', 'name']);

            autocomplete.addListener('place_changed', function () {
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    // User entered the name of a Place that was not suggested and
                    // pressed the Enter key, or the Place Details request failed.
                    window.alert("No encontramos la dirección, por favor intenta reubicando el marcador'");
                    getAddress(marker.getPosition());
                    return;
                }

                // If the place has a geometry, then present it on a map.
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                }
                marker.setPosition(place.geometry.location);
                map.setZoom(16);
                document.getElementById('latitud').value = place.geometry.location.lat();
                document.getElementById('longitud').value = place.geometry.location.lng();

                var address = '';
                if (place.address_components) {
                    address = [
                        (place.address_components[0] && place.address_components[0].short_name || ''),
                        (place.address_components[1] && place.address_components[1].short_name || ''),
                        (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');
                }
            });
        }

        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
            infoWindow.setPosition(pos);
            infoWindow.setContent(browserHasGeolocation ?
                'Error: The Geolocation service failed.' :
                'Error: Your browser doesn\'t support geolocation.');
            infoWindow.open(map);
        }

        function reubicarMarcador(map, location) {
            if (marker) {
                marker.setPosition(location);
            } else {
                crearMarker(map, location);
            }
            getAddress(location);
        }

        function crearMarker(map, location) {
            marker = new google.maps.Marker({
                position: location,
                draggable: true,
                map: map
            });
            marker.addListener('dragend', function () {
                getAddress(marker.getPosition());
            });
            //no es necesario llamar a getAddress porque se llama en otros métodos que invocan esta función
        }

        function getAddress(latLng, fromInit = false) {
            if (fromInit) {
                document.getElementById('latitud').value = latLng.lat;
                document.getElementById('longitud').value = latLng.lng;
            } else {
                document.getElementById('latitud').value = latLng.lat();
                document.getElementById('longitud').value = latLng.lng();
            }
            geocoder.geocode({'latLng': latLng},
                function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            document.getElementById('input-lugar').value = results[0].formatted_address;
                            for (var i = 0; i < results.length; i++) {
                                if (results[i].types[0] === "locality") {
                                    document.getElementById('ciudad').value = results[i].address_components[0].short_name;
                                }
                            }
                        } else {
                        }
                    } else {
                    }
                });
        }
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDjn6uQjll2HhwGi8L5_QTs4bAxAjqh5E0&libraries=places&callback=initMap"
            async defer></script>



    <!--Wizard -->
    <script src="{{asset('js/jquery.bootstrap.js')}}"></script>
    <script src="{{asset('js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('js/validar-solicitudServicio.js')}}"></script>

    <!--datetimePicker configuration-->
    <script>
        $(function () {
            var actualDate = new Date();
            actualDate.setHours(0, 0, 0, 0);
            $('.datepicker').datetimepicker({
                ignoreReadonly: true,
                format: 'DD/MM/YYYY',
                minDate: actualDate,
                locale: 'es',
                useCurrent: false //Para que con el max date no quede seleccionada por defecto esa fecha
            });
            $("#fecha").on("dp.change", function (e) {//Para que el label suba cuando seleccionan la fecha
                if (e.date == '') {
                    $("#fecha-label").addClass("is-empty");
                } else {
                    $("#fecha-label").removeClass("is-empty");
                }
            });
            $("#fechaInicio").on("dp.change", function (e) {//Para que el label suba cuando seleccionan la fecha
                if (e.date == '') {
                    $("#fechaInicio-label").addClass("is-empty");
                } else {
                    $("#fechaInicio-label").removeClass("is-empty");
                }
            });
            $("#fechaFin").on("dp.change", function (e) {//Para que el label suba cuando seleccionan la fecha
                if (e.date == '') {
                    $("#fechaFin-label").addClass("is-empty");
                } else {
                    $("#fechaFin-label").removeClass("is-empty");
                }
            });

            $('.horaInicial').datetimepicker({
                ignoreReadonly: true,
                locale: 'es',
                format: 'hh:mm A',
                useCurrent: false //Para que con el max date no quede seleccionada por defecto esa fecha
            });
            $('.horaFinal').datetimepicker({
                ignoreReadonly: true,
                locale: 'es',
                format: 'hh:mm A',
                useCurrent: false //Para que con el max date no quede seleccionada por defecto esa fecha
            });
        });
    </script>
    <!--Fin wizard scripts-->

@endsection