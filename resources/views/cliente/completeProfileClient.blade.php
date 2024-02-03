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
                    <input name="objective" id="objective" class="form-control" value="{{Auth::user()->cliente != null ? Auth::user()->cliente->objective : ''}}">
                </div>
            </div>

            <div class="input-group" style="margin-top: -12px">
                <span class="input-group-addon iconos">
                    <i class="fa-solid fa-staff-snake"></i>
                </span>
                <div class="d-inline-block">
                    <label class="control-label d-block m-0">¿Tienes alguna patología? <small>(requerido)</small></label>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input name="hasPathology" type="radio" id="pathology1" value="1" class="custom-control-input" {{ Auth::user()->cliente && Auth::user()->cliente->pathology != null ? 'checked=checked' : '' }}>
                        <label class="custom-control-label" for="pathology1">Si</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input name="hasPathology" type="radio" id="pathology2" value="0" class="custom-control-input" {{ Auth::user()->cliente && Auth::user()->cliente->pathology != null ? '': 'checked=checked'  }}>
                        <label class="custom-control-label" for="pathology2">No</label>
                    </div>
                </div>
            </div>
            <div id="pathology-description" class="input-group mt-2" style="margin-left: 45px; {{Auth::user()->cliente != null && Auth::user()->cliente->pathology != null ? '' : 'display:none'}}">
                <div class="form-group label-floating">
                    <label class="control-label">¿Cúal? <small>(requerido)</small></label>
                    <input name="pathology" class="form-control" required value="{{Auth::user()->cliente != null ? Auth::user()->cliente->pathology : ''}}">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pathologyTrue = document.getElementById('pathology1');
            const pathologyFalse = document.getElementById('pathology2');

            pathologyTrue.addEventListener('change', function () {
                if (pathologyTrue.checked) {
                    $("#pathology-description").show();
                }
            });

            pathologyFalse.addEventListener('change', function () {
                if (pathologyFalse.checked) {
                    $("#pathology-description").hide();
                }
            });
        });
    </script>
@endpush
