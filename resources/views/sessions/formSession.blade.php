@extends('layouts.app')

@push('head-content')
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


    <link href="{{asset('css/profileWizard.css')}}" rel="stylesheet"/>

@endpush

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

        <div class="{{\Illuminate\Support\Facades\Blade::check('feature', 'dark_theme', false) ? "floating-card bg-semi-transparent" : "box-shadow"}} mb-5 pb-4">
            <div class="wizard-container">
                <div class="wizard-card" data-color="green" id="wizardProfile">
                    @section('form')
                        <!--        You can switch " data-color="purple" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                        <div class="wizard-header">
                            <h3 class="wizard-title" style="color: white!important;">
                                @yield('titulo')
                            </h3>
                        </div>
                        <div class="wizard-navigation">
                            <ul>
                                <li><a class="tab-completar-perfil" href="#sessions" data-toggle="tab">Número de Sesiones</a></li>
                                <li><a class="tab-completar-perfil" href="#event" data-toggle="tab">Evento</a></li>
                                <li><a class="tab-completar-perfil" href="#where" data-toggle="tab">Cúando y Donde</a></li>
                                <li><a class="tab-completar-perfil" href="#how" data-toggle="tab" disabled="true">Precio</a></li>
                            </ul>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane" id="sessions">
                                <h4 class="info-text">¿Este evento se repite? </h4>
                                <div class="row mt-2">
                                    <div class="m-auto text-center">
                                        <input id="checkboxUnico" class="checkbox-input w-0" type="radio"
                                               name="repeatable"
                                               value="0" {{ old('repeatable') != null && old('repeatable') == \App\Utils\Constantes::UNICA_SESION || (isset($event) &&  $event->repeatable) ? 'checked=checked' : ''}}>
                                        <!--tiene que tener el checkeo de null porque de lo contrario siempre lo iniciaba seleccionado-->
                                        <label for="checkboxUnico" class="checkbox-image">
                                            <i class="material-icons" style="font-size: 55px">event</i>
                                        </label>
                                        <h6>UNA SESIÓN</h6>
                                    </div>
                                    <div class="m-auto text-center">
                                        <input id="checkboxVarios" class="checkbox-input w-0" type="radio"
                                               name="repeatable"
                                               value="1" {{ old('repeatable') == \App\Utils\Constantes::VARIAS_SESIONES || (isset($solicitud) &&  $solicitud->tipo == \App\Utils\Constantes::VARIAS_SESIONES) ? 'checked=checked' : ''}}>
                                        <label for="checkboxVarios" class="checkbox-image">
                                            <i class="far fa-calendar-alt"></i>
                                        </label>
                                        <h6>VARIAS SESIONES</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="event">
                                <div class="row mt-2">
                                    <div class="m-auto w-100">
                                        <div class="d-md-flex flex-wrap justify-content-center">
                                            <h4 class="info-text"></h4>
                                            <div class="col-sm-6 mb-3 mx-auto">
                                                <div class="picture-container">
                                                    <div class="picture">
                                                        <img src="{{asset('images/avatars/'. Auth::user()->foto)}}?{{time()}}" class="picture-src" id="wizardPicturePreview" title=""/>
                                                        <input type="file" id="wizard-picture" name="avatar" accept="image/*">
                                                    </div>
                                                    <h6>Carga una foto de perfil</h6>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 m-auto">
                                                <div class="input-group">
                                                    <span class="iconos">
                                                        <i class="material-icons">festival</i>
                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Nombre del Evento <small>(requerido)</small></label>
                                                        <input name="name" type="text" class="form-control color-white">
                                                    </div>
                                                </div>
                                                <div class="input-group">
                                                    <span class="iconos">
                                                        <i class="material-icons">article</i>
                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Descripción <small>(opcional)</small></label>
                                                        <textarea class="form-control color-white" placeholder name="description" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="input-group">
                                                    <span class="iconos">
                                                        <i class="material-icons">info</i>
                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Info adiciona <small>(opcional)</small></label>
                                                        <textarea class="form-control color-white" name="info" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="where">
                                <div class="row mt-2">
                                    <div class="w-100">
                                        <div class="input-group col-10 col-md-5 m-auto">
                                            <span class="iconos">
                                                <i class="material-icons">place</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Lugar <small>(requerido)</small></label>
                                                <select class="form-control color-white" id="place" name="place">
                                                    <option value="cliente">Atleta</option>
                                                    <option value="entrenador">Entrenador</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div id="unicaSesion" class="flex-wrap justify-content-center">
                                            <div class='input-group datepicker col-10 col-md-5' id="startDate">
                                                <span class="iconos">
                                                    <i class="material-icons">calendar_today</i>
                                                </span>
                                                <div class="form-group label-floating dateContainer"
                                                     id="startDate-label">
                                                    <label class="control-label">Fecha inicio
                                                        <small>(requerido)</small></label>
                                                    <input name="startDate"
                                                           class="form-control input-group-addon color-white"
                                                           type="text"
                                                           value="{{ old('startDate') }}">
                                                </div>
                                            </div>
                                            <div class='input-group datepicker col-10 col-md-5' id="endDate">
                                                <span class="iconos">
                                                    <i class="material-icons">calendar_today</i>
                                                </span>
                                                <div class="form-group label-floating dateContainer"
                                                     id="endDate-label">
                                                    <label class="control-label">Fecha finalización <small>(requerido)</small></label>
                                                    <input name="endDate"
                                                           class="form-control input-group-addon color-white"
                                                           type="text"
                                                           value="{{ old('endDate') }}">
                                                </div>
                                            </div>
                                            <div class='input-group horaInicial col-10 col-md-5' id="horaInicial">
                                                <span class="iconos">
                                                    <i class="material-icons">schedule</i>
                                                </span>
                                                <div class="form-group label-floating startHour" id="startHour">
                                                    <label class="control-label">Hora inicio <small>(requerido)</small></label>
                                                    <input name="startHour"
                                                           class="form-control input-group-addon color-white"
                                                           type="text"
                                                           value="{{ old('startHour', isset($solicitud) && $solicitud->horarios->first() != null ? $solicitud->horarios->first()->hora_inicio->format('g:i A') : '') }}">
                                                </div>
                                            </div>
                                            <div class='input-group horaFinal col-10 col-md-5' id="horaFinal">
                                                <span class="iconos">
                                                    <i class="material-icons">schedule</i>
                                                </span>
                                                <div class="form-group label-floating endHour" id="endHour">
                                                    <label class="control-label">Hora finalización
                                                        <small>(requerido)</small></label>
                                                    <input name="endHour"
                                                           class="form-control input-group-addon color-white"
                                                           type="text"
                                                           value="{{ old('endHour', isset($solicitud) && $solicitud->horarios->first() != null ? $solicitud->horarios->first()->hora_fin->format('g:i A') : '') }}">
                                                </div>
                                            </div>
                                            <script>
                                                $(document).ready(function () {
                                                    $("#horaInicial").on("dp.change", function (e) {//Para que el label suba cuando seleccionan la fecha
                                                        if (e.date == '') {
                                                            $("#startHour").addClass("is-empty");
                                                        } else {
                                                            $("#startHour").removeClass("is-empty");
                                                        }
                                                    });
                                                    $("#horaFinal").on("dp.change", function (e) {//Para que el label suba cuando seleccionan la fecha
                                                        if (e.date == '') {
                                                            $("#endHour").addClass("is-empty");
                                                        } else {
                                                            $("#endHour").removeClass("is-empty");
                                                        }
                                                    });
                                                });
                                            </script>
                                        </div>
                                        <div id="variasSesiones" class="flex-wrap justify-content-center w-75 m-auto">
                                            @for ($i = 3; $i < 3+7; $i++)
                                                <!--Porque la fecha de aniversario empieza en viernes-->
                                                {{old('diasSemana.*')}}
                                                <div class="form-check w-50 m-auto">
                                                    <label data-toggle="collapse" data-target="#collapse{{$i-3}}"
                                                           aria-expanded="false" aria-controls="collapse{{$i-3}}"
                                                           class="check-container daysLabel">
                                                        {{ucfirst(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l'))}}
                                                        <input type="checkbox" name="diasSemana[{{$i-3}}]"
                                                               value="{{$i-3}}" {{ old('diasSemana.'.($i-3)) != null ? 'checked=checked' : ''}}>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                                <div id="collapse{{$i-3}}" aria-expanded="false"
                                                     class="collapse {{ old('diasSemana.'.($i-3) != null) ? 'show' : ''}}">
                                                    <div class="d-flex">
                                                        <div class='input-group horaInicial'
                                                             id="horaInicial{{ucfirst(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l'))}}">
                                                        <span class="iconos mt-3">
                                                            <i class="material-icons">schedule</i>
                                                        </span>
                                                            <div class="form-group label-floating mt-3"
                                                                 id="startHour{{ucfirst(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l'))}}">
                                                                <label class="control-label">Hora inicio <small>(requerido)</small></label>
                                                                <input name="startHour[{{$i-3}}]"
                                                                       class="form-control input-group-addon color-white"
                                                                       type="text"
                                                                       value="{{ old('startHour'.ucfirst(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l')), '') }}">
                                                            </div>
                                                        </div>
                                                        <div class='input-group horaFinal'
                                                             id="horaFinal{{ucfirst(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l'))}}">
                                                        <span class="iconos mt-3">
                                                            <i class="material-icons">schedule</i>
                                                        </span>
                                                            <div class="form-group label-floating mt-3"
                                                                 id="endHour{{ucfirst(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l'))}}">
                                                                <label class="control-label">Hora finalización <small>(requerido)</small></label>
                                                                <input name="endHour[{{$i-3}}]"
                                                                       class="form-control input-group-addon color-white"
                                                                       type="text"
                                                                       value="{{ old('endHour'.ucfirst(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l')),  '') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <script>
                                                    $(document).ready(function () {
                                                        $("#horaInicial" + "{{ucfirst(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l'))}}").on("dp.change", function (e) {//Para que el label suba cuando seleccionan la fecha
                                                            if (e.date == '') {
                                                                $("#startHour" + "{{ucfirst(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l'))}}").addClass("is-empty");
                                                            } else {
                                                                $("#startHour" + "{{ucfirst(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l'))}}").removeClass("is-empty");
                                                            }
                                                        });
                                                        $("#horaFinal" + "{{ucfirst(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l'))}}").on("dp.change", function (e) {//Para que el label suba cuando seleccionan la fecha
                                                            if (e.date == '') {
                                                                $("#endHour" + "{{ucfirst(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l'))}}").addClass("is-empty");
                                                            } else {
                                                                $("#endHour" + "{{ucfirst(\Jenssegers\Date\Date::createFromDate(2014, 07, 18)->addDays($i)->format('l'))}}").removeClass("is-empty");
                                                            }
                                                        });
                                                    });
                                                </script>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="how">
                                <div class="col-10 col-md-6 mx-auto mt-5">
                                    <div class="input-group w-100">
                                        <span class="iconos">
                                            <i class="material-icons">people</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Cupos <small>(requerido)</small></label>
                                            <input name="quotas" type="number" min="1" class="form-control color-white">
                                        </div>
                                    </div>
                                    <div class="input-group w-100">
                                        <span class="iconos">
                                            <i class="material-icons">attach_money</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Precio <small>(requerido)</small></label>
                                            <input name="price" type="number" min="1" max="1000000000" class="form-control color-white">
                                        </div>
                                    </div>
                                    <div class="input-group w-100">
                                        <span class="iconos">
                                            <i class="material-icons">do_not_step</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Precio sin botas <small>(opcional)</small></label>
                                            <input name="priceWithoutBoots" type="number" min="1" max="1000000000" class="form-control color-white">
                                        </div>
                                    </div>
                                    <div class="input-group w-100">
                                        <span class="iconos">
                                            <i class="material-icons">money_off</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Descuento <small>(opcional)</small></label>
                                            <input name="discount" type="number" min="1" max="1000000000" class="form-control color-white">
                                        </div>
                                    </div>
                                    <div class="input-group w-100">
                                        <span class="iconos">
                                            <i class="material-icons">local_offer</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Oferta <small>(opcional)</small></label>
                                            <input name="offer" type="number" min="1" max="100" class="form-control color-white">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wizard-footer">
                            <div class="float-right">
                                <input type='button' class='btn btn-next btn-fill btn-success btn-wd' name='next' id="next"
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

    <!--Validación días que se repite-->
    <script>
        const nextButton = document.getElementById("next");
        var $checkboxValidation = true;

        nextButton.addEventListener("click", (event) => {
            $checkboxValidation = true;
            const daysLabels = $(".daysLabel");
            if(!daysLabels.is(":visible")) {
                return;
            }

            <!--Validar que al menos un día sea seleccionado para un evento que se repite-->
            const inputs = document.querySelectorAll('input[type="checkbox"][name^="diasSemana"]');

            let isAtLeastOneChecked = false;

            for (const input of inputs) {
                if (input.checked) {
                    isAtLeastOneChecked = true;
                    break;
                }
            }

            if (!isAtLeastOneChecked) {
                daysLabels.css("cssText", "color: red!important;")
                daysLabels.css("border-color", "red");
                $checkboxValidation = false;
            }else {
                daysLabels.css("cssText", "")
                daysLabels.css("border-color", "");
            }
        });
    </script>

    <!--Selección número de sesiones-->
    <script>
        $(document).ready(function () {
            if ("{{old('repeatable') == \App\Utils\Constantes::UNICA_SESION || (isset($solicitud) &&  $solicitud->tipo == \App\Utils\Constantes::UNICA_SESION)}}") {
                document.getElementById("variasSesiones").style.display = "none";
                document.getElementById("unicaSesion").style.display = "flex";
            }
            if ("{{old('repeatable') == \App\Utils\Constantes::VARIAS_SESIONES || (isset($solicitud) &&  $solicitud->tipo == \App\Utils\Constantes::VARIAS_SESIONES)}}") {
                document.getElementById("variasSesiones").style.display = "flex";
                document.getElementById("unicaSesion").style.display = "none";
            }
            $("#checkboxUnico").change(function () {
                $("#variasSesiones").hide();
                $("#unicaSesion").show();
            });
            $("#checkboxVarios").change(function () {
                $("#variasSesiones").show();
                $("#unicaSesion").hide();
            });
            $('.checkbox-input').change(function () {
                $('.checkbox-image').css("border-color", "");
                $('.checkbox-image').css("color", "");
            });
        });

        function validar() {
            <!--Validar la seleccion del número de sesiones-->
            if (typeof $("input[name='repeatable']:checked").val() === "undefined") {
                $('.checkbox-image').css("cssText", "color: red!important;")
                $('.checkbox-image').css("border-color", "red");
            }
        }
    </script>
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
            $("#startDate").on("dp.change", function (e) {//Para que el label suba cuando seleccionan la fecha
                if (e.date == '') {
                    $("#startDate-label").addClass("is-empty");
                } else {
                    $("#startDate-label").removeClass("is-empty");
                }
            });
            $("#endDate").on("dp.change", function (e) {//Para que el label suba cuando seleccionan la fecha
                if (e.date == '') {
                    $("#endDate-label").addClass("is-empty");
                } else {
                    $("#endDate-label").removeClass("is-empty");
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

    <!--Wizard -->
    <script src="{{asset('js/jquery.bootstrap.js')}}"></script>
    <script src="{{asset('js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('js/validate-formSession.js')}}"></script>
    <script src="{{asset('js/wizard.js')}}"></script>

@endsection