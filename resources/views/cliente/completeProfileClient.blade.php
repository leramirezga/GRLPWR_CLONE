@section('tab3Title')
    Información físca
@endsection

@section('tab3Content')
    <div class="row m-auto">
        <div class="col-sm-12 col-md-6 m-auto">
            <div class="input-group">
                <span class="input-group-addon iconos">
                    <span class="fas fa-weight"></span>
                </span>
                <div class="form-group label-floating">
                    <label class="control-label">Peso aproximado <small>(kilogramos)</small></label>
                    @if(Auth::user()->cliente != null &&  Auth::user()->cliente->peso())
                        <input name="peso" type="number" step="1" class="form-control" required
                               value="{{number_format(Auth::user()->cliente->peso()->peso, 2)}}">
                    @else
                        <input name="peso" type="number" step="1" class="form-control" required>
                    @endif
                </div>
            </div>

            <div class="input-group">
                <span class="input-group-addon iconos">
                    <i class="fas fa-ruler-horizontal"></i>
                </span>
                <div class="form-group label-floating">
                    <label class="control-label">Estatura inicial <small>(centimetros)</small></label>
                    @if(Auth::user()->cliente != null && Auth::user()->cliente->estatura())
                        <input name="estatura" type="number" step="1" class="form-control" required
                               value="{{number_format(Auth::user()->cliente->estatura()->estatura, 2)}}">
                    @else
                        <input name="estatura" type="number" step="1" class="form-control" required>
                    @endif
                </div>
            </div>
            <div class="input-group">
                <span class="input-group-addon iconos">
                    <i class="fas fa-shoe-prints"></i>
                </span>
                <div class="form-group label-floating">
                    <label class="control-label">Talla de zapatos <small>(34 a 45)</small></label>
                    @if(Auth::user()->cliente != null && Auth::user()->cliente->talla_zapato)
                        <input name="tallaZapato" type="number" step="1" min="34" class="form-control" required
                               value="{{number_format(Auth::user()->cliente->talla_zapato, 2)}}">
                    @else
                        <input name="tallaZapato" type="number" step="1" class="form-control" required>
                    @endif
                </div>
            </div>
            <!--
            <div class="input-group">
                <span class="input-group-addon iconos">
                    <span class="fas fa-weight"></span>
                </span>
                <div class="form-group label-floating">
                    <label class="control-label">Meta <small>(kilogramos)</small></label>
                    @if(Auth::user()->cliente != null)
                        <input name="pesoIdeal" type="number" step="any" class="form-control" required
                               value="{{number_format(Auth::user()->cliente->peso_ideal, 2)}}">
                    @else
                        <input name="pesoIdeal" type="number" step="any" class="form-control" required>
                    @endif
                </div>
            </div>

            <div class="input-group">
                <span class="iconos" style="padding: 0/*para que en firefox queden horizontales*/">
                    <i class="fas fa-venus-mars"></i>
                </span>
                <div class="radio">
                    <label class="radio-label">
                        <input required type="radio" name="genero"
                               value="f" {{Auth::user()->genero != null && Auth::user()->genero == 'f' ? "checked=true" : ""}}>
                        Femenino
                    </label>
                </div>
                <div class="radio">
                    <label class="radio-label">
                        <input required type="radio" name="genero"
                               value="m" {{Auth::user()->genero != null && Auth::user()->genero == 'm' ? "checked=true" : ""}}>
                        Masculino
                    </label>
                </div>
            </div>
            -->

            <div class="input-group">
                <span class="input-group-addon iconos">
                    <i class="fa-solid fa-bullseye"></i>
                </span>
                <div class="form-group label-floating">
                    <label class="control-label">¿Cúal es tu objetivo? <small>(requerido)</small></label>
                    <input name="objective" class="form-control" required value="{{Auth::user()->cliente != null ? Auth::user()->cliente->objective : ''}}">
                </div>
            </div>

            <div class="input-group">
                <span class="input-group-addon iconos">
                    <i class="fa-solid fa-staff-snake"></i>
                </span>
                <div class="form-group label-floating">
                    <label class="control-label">¿Tienes alguna patología? <small>(requerido)</small></label>
                    <input name="pathology" class="form-control" required value="{{ Auth::user()->cliente ? Auth::user()->cliente->pathology : '' }}">
                </div>
            </div>
        </div>
        <!--
        <div class="col-sm-8" style="text-align: center">
            <h4>¿Qué tipo de cuerpo tienes?</h4>
            <a style="cursor: help" data-toggle="modal" data-target="#modalExplicacionCuerpo">
                ayudame a escoger
                <i class="far fa-question-circle"></i>
            </a>
            <div class="row">
                <div class="col-sm-4">
                    @if(Auth::user()->cliente != null and Auth::user()->cliente->biotipo == 'ectomorfo')
                        <div class="choice form-group active" checked="checked" data-toggle="wizard-radio">
                            <input type="radio" name="tipoCuerpo" value="ectomorfo" required checked="checked">
                    @else
                        <div class="choice form-group" data-toggle="wizard-radio">
                            <input type="radio" name="tipoCuerpo" value="ectomorfo" required>
                    @endif
                            <div class="icon">
                                <img src="{{asset('images/ectomorfo.png')}}" id="bodytype"
                                     title="Tipos de cuerpo" style="height: 200px; width: 100px"/>
                            </div>
                            <h6>ectomorfo</h6>
                        </div>
                </div>
                <div class="col-sm-4">
                    @if(Auth::user()->cliente != null and Auth::user()->cliente->biotipo == 'mesomorfo')
                        <div class="choice form-group active" checked="checked" data-toggle="wizard-radio">
                            <input type="radio" name="tipoCuerpo" value="mesoomorfo" required checked="checked">
                    @else
                        <div class="choice form-group" data-toggle="wizard-radio">
                            <input type="radio" name="tipoCuerpo" value="mesomorfo" required>
                    @endif
                            <div class="icon">
                                <img src="{{asset('images/mesomorfo.png')}}" id="bodytype"
                                     title="Tipos de cuerpo" style="height: 200px; width: 100px"/>
                            </div>
                            <h6>mesomorfo</h6>
                        </div>
                </div>
                <div class="col-sm-4">
                    @if(Auth::user()->cliente != null and Auth::user()->cliente->biotipo == 'endomorfo')
                        <div class="choice form-group active" checked="checked"
                             data-toggle="wizard-radio">
                            <input type="radio" name="tipoCuerpo" value="endomorfo" required
                                   checked="checked">
                    @else
                        <div class="choice form-group" data-toggle="wizard-radio">
                            <input type="radio" name="tipoCuerpo" value="endomorfo" required>
                    @endif
                            <div class="icon">
                                <img src="{{asset('images/endomorfo.png')}}" id="bodytype"
                                     title="Tipos de cuerpo"
                                     style="height: 200px; width: 100px"/>
                            </div>
                            <h6>endomorfo</h6>
                        </div>
                </div>
            </div>
        </div>
        -->
    </div>

    <!-- Modal explicación tipo cuerpo
    <div class="modal fade" id="modalExplicacionCuerpo" data-backdrop="false" tabindex="-1" role="dialog"
         aria-labelledby="modalExplicacionCuerpoTitle" aria-hidden="true" style="z-index: 1100">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="exampleModalLongTitle">Tipos de cuerpo</h5>
                    <button type="button" class="close" onclick="cerrarModal('modalExplicacionCuerpo')"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <script>
                        function cerrarModal(idModal) {
                            $('#' + idModal).modal('hide');
                        }
                    </script>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <b>Ectomorfos:</b>
                            <ul>
                                <li>Altos,delgados y largos</li>
                                <li>Estructura osea poco pesada</li>
                                <li>Ligeramente musculados</li>
                                <li>No ganan grasa facilmente</li>
                                <li>Dificultad para ganar musculos</li>
                                <li>Metábolismo super rápido</li>
                                <li>Pecho plano</li>
                                <li>Hombos pequeños</li>
                                <li>Estan por debajo del peso medio</li>
                            </ul>
                        </div>

                        <div class="col-sm-4">
                            <b>Mesomorfos:</b>
                            <ul>
                                <li>Atleticos</li>
                                <li>Forma de "reloj de arena" en las mujeres</li>
                                <li>Forma en "V" en hombres</li>
                                <li>Cuerpo duro y musculado</li>
                                <li>Fuertes</li>
                                <li>Ganan musculo facilmente</li>
                                <li>Ganan grasa más facilmente</li>
                                <li>Hombreos anchos</li>
                                <li>Metábolismo regular</li>
                            </ul>
                        </div>

                        <div class="col-sm-4">
                            <b>Endomorfos:</b>
                            <ul>
                                <li>Cuerpo blando y redondo</li>
                                <li>Por lo general bajos y fornidos</li>
                                <li>Ganan musculo facilmente</li>
                                <li>Acumulan grasa con facilidad</li>
                                <li>Dificultad para perder peso</li>
                                <li>Metábolismo lento</li>
                                <li>Hombros grandes</li>
                                <li>Están por encima del peso promedio</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal explicación tipo cuerpo-->
@endsection
