@push('head-content')

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- CSS Files -->
    <link href="{{asset('css/profileWizard.css')}}" rel="stylesheet"/>

    <!--     Fonts and icons     -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />

    <!--datetimePicker-->
    <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
    <script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
    <script src="{{asset('js/datetimePicker.js')}}"></script>
@endpush

@if($errors->completarPerfil->all() != null)
    <script>
        $(document).ready(function(){
            $('#completarPerfilModal').modal({show: true});
        });
    </script>
@endif

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
                                    <li><a class="tab-completar-perfil text-break" href="#about" data-toggle="tab">Información básica</a></li>
                                    <li><a class="tab-completar-perfil text-break" href="#moreAbout" data-toggle="tab">Más de ti</a></li>
                                    <li><a class="tab-completar-perfil text-break" href="#contact" data-toggle="tab" disabled="true">Información de contacto</a></li>
                                    <li><a class="tab-completar-perfil text-break" href="#address" data-toggle="tab">@yield('tab3Title')</a></li>
                                </ul>
                            </div>

                            <div class="tab-content">
                                <div class="tab-pane" id="about">
                                    <div class="row">
                                        <h4 class="info-text"></h4>
                                        <div class="col-sm-4 offset-sm-1 mb-3">
                                            <div class="picture-container">
                                                <div class="picture">
                                                    <img src="{{asset('images/avatars/'. Auth::user()->foto)}}" class="picture-src" id="wizardPicturePreview" title=""/>
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
                                                    <input name="firstname" type="text" class="form-control" value="{{Auth::user()->nombre}}">
                                                </div>
                                            </div>

                                            <div class="input-group">
                                                                <span class="iconos">
                                                                    <i class="material-icons">record_voice_over</i>
                                                                </span>
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Primer apellido <small>(requerido)</small></label>
                                                    <input name="lastname" type="text" class="form-control" value="{{Auth::user()->apellido_1}}">
                                                </div>
                                            </div>

                                            <div class="input-group">
                                                                <span class="iconos">
                                                                    <i class="material-icons">record_voice_over</i>
                                                                </span>
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Segundo apellido <small>(opcional)</small></label>
                                                    <input name="lastname2" type="text" class="form-control" value="{{Auth::user()->apellido_2}}">
                                                </div>
                                            </div>

                                            <div class='input-group' id="datepicker">
                                                            <span class="iconos">
                                                                <i class="material-icons">calendar_today</i>
                                                            </span>
                                                <div id="dateContainer" class="form-group label-floating">
                                                    <label class="control-label">Fecha de nacimiento <small>(requerido)</small></label>
                                                    <input name="dateborn" class="form-control input-group-addon" type="text" value="{{Auth::user()->fecha_nacimiento ? Auth::user()->fecha_nacimiento->format('d/m/Y') : ''}}">
                                                </div>
                                            </div>

                                            <div class="input-group">
                                                                <span class="iconos">
                                                                    <i class="fa-solid fa-id-card"></i>
                                                                </span>
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Número de Identidad <small>(requerido)</small></label>
                                                    <input name="documentId" type="number" class="form-control" value="{{Auth::user()->document_id}}">
                                                </div>
                                            </div>
                                            @yield('generoEntrenador')
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="moreAbout">
                                    <h4 class="info-text"></h4>
                                    <div class="col-sm-12 col-md-6 m-auto">
                                        <div class="input-group">
                                            <span class="iconos">
                                                <i class="fa-solid fa-user-doctor"></i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">EPS <small>(requerido)</small></label>
                                                <input name="eps" type="text" class="form-control" value="{{Auth::user()->eps}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 m-auto">
                                        <div class="input-group">
                                            <span class="iconos">
                                                <i class="fa-regular fa-heart"></i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Estado Civil <small>(requerido)</small></label>
                                                <select class="form-control" name="maritalStatus">
                                                    <option disabled selected value style="display:none"></option>
                                                    <option value="Soltera" {{Auth::user()->marital_status === 'Soltera' ? "selected" : ""}}>Soltera</option>
                                                    <option value="Casada" {{Auth::user()->marital_status === 'Casada' ? "selected" : ""}}>Casada</option>
                                                    <option value="Otro" {{Auth::user()->marital_status === 'Otro' ? "selected" : ""}}>Otro</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 m-auto">
                                        <div class="input-group">
                                            <span class="iconos">
                                                <i class="fa-solid fa-briefcase"></i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Ocupación <small>(requerido)</small></label>
                                                <input name="occupation" type="text" class="form-control" value="{{Auth::user()->occupation}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 m-auto">
                                        <div class="input-group">
                                            <span class="iconos">
                                                <i class="fa-solid fa-house-chimney-window"></i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">¿Cómo nos conociste? <small>(requerido)</small></label>
                                                <select class="form-control" name="channel">
                                                    <option disabled selected value style="display:none"></option>
                                                    <option value="Facebook" {{Auth::user()->cliente != null && Auth::user()->cliente->channel === 'Facebook' ? "selected" : ""}}>Facebook</option>
                                                    <option value="Instagram" {{Auth::user()->cliente != null && Auth::user()->cliente->channel === 'Instagram' ? "selected" : ""}}>Instagram</option>
                                                    <option value="TikTok" {{Auth::user()->cliente != null && Auth::user()->cliente->channel === 'TikTok' ? "selected" : ""}}>TikTok</option>
                                                    <option value="Google" {{Auth::user()->cliente != null && Auth::user()->cliente->channel === 'Google' ? "selected" : ""}}>Google</option>
                                                    <option value="Fisico" {{Auth::user()->cliente != null && Auth::user()->cliente->channel === 'Fisico' ? "selected" : ""}}>Punto Físico</option>
                                                    <option value="Referido" {{Auth::user()->cliente != null && Auth::user()->cliente->channel === 'Referido' ? "selected" : ""}}>Referido</option>
                                                    <option value="Otro" {{Auth::user()->cliente != null && Auth::user()->cliente->channel === 'Otro' ? "selected" : ""}}>Otro</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="contact">
                                    <h4 class="info-text"></h4>
                                    <div class="col-sm-12 col-md-6 m-auto">
                                        <div class="input-group">
                                            <span class="iconos">
                                                <i class="material-icons">phone_iphone</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Télefono celular <small>(requerido)</small></label>
                                                <input name="cellphone" type="number" min="1000000000" max="9999999999" class="form-control" value="{{Auth::user()->telefono}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 m-auto">
                                        <div class="input-group">
                                            <span class="iconos">
                                                <i class="material-icons">email</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Correo eléctronico <small>(requerido)</small></label>
                                                <input name="email" type="email" class="form-control deshabilitado" value="{{Auth::user()->email}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 m-auto">
                                        <div class="input-group">
                                            <span class="iconos">
                                                <i class="fa-brands fa-instagram"></i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Instagram <small>(opcional)</small></label>
                                                <input name="instagram" type="text" class="form-control" value="{{Auth::user()->instagram}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 m-auto">
                                        <div class="input-group">
                                            <span class="iconos">
                                                <i class="material-icons">record_voice_over</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Nombre Contacto de emergencia <small>(requerido)</small></label>
                                                <input name="emergencyContact" type="text" class="form-control" value="{{Auth::user()->emergency_contact}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 m-auto">
                                        <div class="input-group">
                                            <span class="iconos">
                                                <i class="material-icons">phone_iphone</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Número contacto de emergencia <small>(requerido)</small></label>
                                                <input name="emergencyPhone" type="number" min="1000000000" max="9999999999" class="form-control" value="{{Auth::user()->emergency_phone}}">
                                            </div>
                                        </div>
                                    </div>
                                    @yield('tab2AditionalContent')
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

@push('scripts')
    <!--   Core JS Files   -->
    <script src="{{asset('js/jquery.bootstrap.js')}}" type="text/javascript"></script>
    <!--  Plugin for the Wizard -->
    <script src="{{asset('js/validar-completarPerfil.js')}}"></script>
    <script src="{{asset('js/wizard.js')}}"></script>

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

    <!--Validar completar perfil-->
    <script>
        $(document).ready(function () {
            $('.icon').click(function () {
                $('.icon').css("border-color", "");
            });
        });

        function validar() {
            if (typeof $("input[name='genero']:checked").val() === "undefined") {
                $('.radio-label').css("cssText", "color: red!important;")
            } else {
                $('.radio-label').css("color", "red")
            }
            if (typeof $("input[name='tipoCuerpo']:checked").val() === "undefined") {
                $('.icon').css("border-color", "red");
            }
        }
    </script>
@endpush