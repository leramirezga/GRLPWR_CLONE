<!-- Fonts -->
<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

<!-- CSS Files -->
<link href="{{asset('css/profileWizard.css')}}" rel="stylesheet"/>
<link href="{{asset('css/scheduleCourtesyModal.css')}}" rel="stylesheet"/>

<!--     Fonts and icons     -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />

<!--datetimePicker-->
<link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
<script src="{{asset('js/datetimePicker.js')}}"></script>

@if($errors->all() != null)
    <script>
        $(document).ready(function(){
            $('#scheduleCourtesyModal').modal({show: true});
        });
    </script>
@endif

<div class="modal fade justify-content-center align-items-center" id="scheduleCourtesyModal" tabindex="-1" role="dialog">
    <div class="modal-dialog wizard-schedule-courtesy" role="document">
        <div class="modal-content">
            <div class="modal-body" style="padding: 0 0 3vh 0">
                @if ($errors->all() != null)
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
                <!--      Wizard container        -->
                <div class="wizard-container">
                    <div class="wizard-card" data-color="green" id="wizardProfile">
                        <form id="scheduleCourtesyForm" method="post" action="{{route('scheduleCourtesy')}}" enctype="multipart/form-data">
                            @method('POST')
                            @csrf
                            <!--        You can switch " data-color="purple" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                            <div class="wizard-header">
                                <h3 class="wizard-title">
                                    Agenda tu clase
                                </h3>
                            </div>
                            <div class="wizard-navigation">
                                <ul>
                                    <li><a class="tab-schedule-courtesy" href="#classType" data-toggle="tab">Tipo de Clase</a></li>
                                    <li><a class="tab-schedule-courtesy" href="#about" data-toggle="tab">Información básica</a></li>
                                </ul>
                            </div>

                            <div class="tab-content">
                                <div class="tab-pane" id="classType">
                                    <div class="row">
                                        <h4 class="info-text"></h4>
                                        <div class="col-sm-10 m-auto">
                                            <div class="input-group">
                                                <span class="iconos">
                                                    <i class="material-icons">fitness_center</i>
                                                </span>
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Tipo de clase <small>(requerido)</small></label>
                                                    @include('components.classTypeSelector')
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="col-sm-10 m-auto kangooForm" style="display: none">
                                                <span class="iconos">
                                                        <i class="material-icons">snowshoeing</i>
                                                </span>
                                                <div class="custom-control custom-radio custom-control-inline">

                                                    <input type="radio" id="rentEquipment1" name="rentEquipment" value="1" class="custom-control-input" required>
                                                    <label class="custom-control-label rentEquipmentLabel" for="rentEquipment1">Alquilar Kangoos</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">

                                                    <input type="radio" id="rentEquipment2" name="rentEquipment" value="0" class="custom-control-input" required>
                                                    <label class="custom-control-label rentEquipmentLabel" for="rentEquipment2">Tengo mis propios Kangoos</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-10 mt-3 mx-auto renting" style="display: none">
                                                <div class="input-group">
                                                    <span class="input-group-addon iconos">
                                                        <i class="fas fa-shoe-prints"></i>
                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Talla de zapatos <small>(34 a 45)</small></label>
                                                        <input id="shoeSize" name="shoeSize" type="number" step="any" min="34" max="45" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-10 mx-auto weight" style="display: none">
                                                <div class="input-group">
                                                    <span class="input-group-addon iconos">
                                                        <i class="fas fa-weight"></i>
                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Peso <small>(Kg)</small></label>
                                                        <input id="weight" name="weight" type="number" step="1" min="34" max="200" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-10 m-auto daySelector" style="display: none">
                                            <div class="input-group">
                                                <span class="iconos">
                                                    <i class="material-icons">calendar_today</i>
                                                </span>
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Día <small>(requerido)</small></label>
                                                    <select class="form-control pl-1" id="daySelector" name="event">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane" id="about">
                                    <div class="row">
                                        <h4 class="info-text"></h4>
                                        <div class="col-sm-10 m-auto">
                                            <div class="input-group">
                                                <span class="iconos">
                                                    <i class="material-icons">face</i>
                                                </span>
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Nombre <small>(requerido)</small></label>
                                                    <input name="name" type="text" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-10 m-auto">
                                            <div class="input-group">
                                                                <span class="iconos">
                                                                    <i class="material-icons">phone_iphone</i>
                                                                </span>
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Celular <small>(requerido)</small></label>
                                                    <input name="cellphone" type="number" min="1000000000" max="9999999999" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-10 m-auto">
                                            <div class="input-group">
                                                                <span class="iconos">
                                                                    <i class="material-icons">email</i>
                                                                </span>
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Correo eléctronico <small>(requerido)</small></label>
                                                    <input name="email" type="email" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        @include('termsAndConditions')

                                        <p class="mt-3 col-sm-11 m-auto text-justify" style="display: none">* Cómo tenemos botas limitadas, debemos cobrar $10.000 para la reserva de las botas, este valor será abonado al plan que adquieras o se te devolverá si asistes a la cortesía y no deseas inscribirte</p>
                                    </div>
                                </div>
                            </div>
                            <div class="wizard-footer">
                                <div class="float-right">
                                    <input type='button' class='btn btn-next btn-fill btn-success btn-wd' name='next' value='Siguiente' onclick="validar()"/>
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
    <script src="{{asset('js/validate-scheduleCourtesy.js')}}"></script>
    <script src="{{asset('js/wizard.js')}}"></script>

    <!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->f
    <script src="{{asset('js/jquery.validate.min.js')}}"></script>

    <script>
        const select = document.getElementById('classTypeSelector');
        const shoeSize = document.getElementById('shoeSize');
        const weight = document.getElementById('weight');
        document.addEventListener('DOMContentLoaded', function() {
            const rentEquipment = document.getElementById('rentEquipment1');
            const notRentEquipment = document.getElementById('rentEquipment2');


            select.addEventListener('change', function () {
                rentEquipment.checked = false;
                notRentEquipment.checked = false;
                $(".renting").css("display", "none");
                $(".weight").css("display", "none");
                if (select.value === "1") {
                    $(".kangooForm").css("display", "flex");
                    $(".daySelector").css("display", "none");
                } else {
                    loadSessions(false);
                    $(".daySelector").css("display", "flex");
                    $(".kangooForm").css("display", "none");
                }
            });

            rentEquipment.addEventListener('change', function () {
                if (rentEquipment.checked) {
                    shoeSize.value = '';
                    weight.value = '';
                    $(".renting").css("display", "block");
                    $(".daySelector").css("display", "none");
                }

            });
            notRentEquipment.addEventListener('change', function () {
                loadSessions(false);
                if (notRentEquipment.checked) {
                    $(".daySelector").css("display", "flex");
                    $(".renting").css("display", "none");
                    $(".weight").css("display", "none");
                }
            });
            shoeSize.addEventListener('change', function () {
                $(".weight").css("display", "block");
            });

            weight.addEventListener('change', function () {
                loadSessions(true);
                $(".daySelector").css("display", "flex");
            });
        });

        function loadSessions(rentEquipment){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('loadSessions') }}",
                method: "GET",
                data: {
                    classTypeId: select.value,
                    rentEquipment: rentEquipment,
                    shoeSize: shoeSize.value,
                    weight: weight.value
                },

                success: function (data) {
                    var select = $('#daySelector');
                    select.empty(); // Limpia las opciones actuales

                    select.append($('<option style="" value="" disabled selected></option>'));
                    // Agrega las nuevas opciones desde el resultado de la llamada AJAX
                    $.each(data.events, function(key, value) {
                        select.append($('<option></option>')
                            //JSON format
                            .attr('value',
                                '{"id": ' + value.id + ',' +
                                '"startDate": "' + value.fecha_inicio.slice(0,10) + '",' +
                                '"startHour": "' + value.start_hour + '",' +
                                '"endDate": "' + value.fecha_fin.slice(0,10) + '",' +
                                '"endHour": "' + value.end_hour +
                                '"}')
                            .text(value.fecha_inicio.slice(0,10) + ' ' + value.start_hour));
                    });
                },
                error: function(data) {
                    console.log(data); //if you want to debug you need to uncomment this line and comment reload
                    $('html, body').animate({ scrollTop: 0 }, 0);
                    //location.reload();
                }
            });
        }
    </script>

    <!--script para solucionar el scroll que no funciona cuando un segundo modal se abre-->
    <script>
        $(document).on('hidden.bs.modal', '.modal', function () {
            $('.modal:visible').length && $(document.body).addClass('modal-open');
        });
    </script>

    <!--Validar completar perfil-->
    <script>
        function validar() {
            <!--Validar la seleccion del número de sesiones-->
            if($("input[name='rentEquipment']").is(':visible')){
                if (typeof $("input[name='rentEquipment']:checked").val() === "undefined") {
                    $('.rentEquipmentLabel').css("cssText", "color: red!important;")
                    $('.rentEquipmentLabel').css("border-color", "red");
                }
            }

            if($("input[name='aceptacion']").is(':visible')) {
                if (!$("input[name='aceptacion']").is(":checked")) {
                    $('.terms-label').css("cssText", "color: red!important;")
                    $('.terms-label').css("border-color", "red");
                }
            }
        }
        $(document).ready(function () {
            $("input[name='rentEquipment']").click(function () {
                $('.rentEquipmentLabel').css("cssText", "color:'';")
                $('.rentEquipmentLabel').css("border-color", "");
            });
            $("input[name='aceptacion']").click(function () {
                $('.terms-label').css("cssText", "color:'';")
                $('.terms-label').css("border-color", "");
            });
        });
    </script>
@endpush