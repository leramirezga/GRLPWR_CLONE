@extends('layouts.app')

@push('head-content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--     Fonts and icons     -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons"/>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

    <link href="{{asset('css/profileWizard.css')}}" rel="stylesheet"/>

    <!--datetimePicker-->
    <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
    <script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
    <script src="{{asset('js/datetimePicker.js')}}"></script>
@endpush

@section('content')

    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger redondeado">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $error}}</strong>
                         </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="themed-block mb-5 pb-4">
            <div class="wizard-container">
                <div class="wizard-card" data-color="purple" id="wizardProfile">
                    <form id="freezePlanForm" method="post" action="{{route('freezePlan')}}" enctype="multipart/form-data">
                    @method('POST')
                    @csrf
                        <input type="hidden" name="lastPlanId" id="lastPlanId">

                        <!--        You can switch " data-color="purple" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                        <div class="wizard-header">
                            <h3 class="wizard-title">
                                Congelar Plan
                            </h3>
                        </div>
                        <div class="wizard-navigation">
                            <ul>
                                <li><a class="tab-completar-perfil" href="#freeze" data-toggle="tab"></a></li>
                            </ul>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane" id="freeze">
                                <h4 class="info-text">¿Usuario? </h4>
                                <div class="row mt-2">
                                    <div class="m-auto w-100">
                                        <div class="input-group col-10 col-md-5 m-auto">
                                            <span class="iconos">
                                                <i class="material-icons">people</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Usuario <small>(requerido)</small></label>
                                                <select class="form-control select2 bg-dark" id="clientId" name="clientId">
                                                    <option style="color: black" value="" disabled selected>Usuario...</option>
                                                    @foreach($clients as $client)
                                                        <option value="{{$client->usuario_id}}">{{$client->usuario->nombre}} {{$client->usuario->apellido_1}} {{$client->usuario->telefono}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="d-none" id="lastPlan">
                                            <div class="input-group col-10 col-md-5 m-auto">
                                                <p>Último plan</p>
                                                <table class="w-100 table">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Plan</th>
                                                        <th scope="col">Clases restantes</th>
                                                        <th scope="col">F. Vencimiento</th>
                                                        <th scope="col">F. Congelamiento</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="lastPlanBody">
                                                    <tbody>
                                                </table>
                                            </div>
                                            <div class='input-group col-10 col-md-5 m-auto datepicker' id="datepicker_from">
                                                <span class="iconos">
                                                    <i class="material-icons">calendar_today</i>
                                                </span>
                                                <div id="dateContainerFrom" class="form-group label-floating">
                                                    <label class="control-label">Desde <small>(requerido)</small></label>
                                                    <input name="frozenFrom" class="form-control input-group-addon" type="text">
                                                </div>
                                            </div>
                                            <div class='input-group col-10 col-md-5 m-auto datepicker' id="datepicker_to">
                                                <span class="iconos">
                                                    <i class="material-icons">calendar_today</i>
                                                </span>
                                                <div id="dateContainerTo" class="form-group label-floating">
                                                    <label class="control-label">Hasta <small>(requerido)</small></label>
                                                    <input name="frozenTo" class="form-control input-group-addon" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wizard-footer">
                            <div class="float-right">
                                <input type='button' class='btn btn-next btn-fill themed-btn btn-wd' name='next' id="next"
                                       value='Siguiente'/>
                                <input type='submit' class='btn btn-finish btn-fill themed-btn btn-wd' name='finish'
                                       value='Finalizar'/>
                            </div>
                            <div class="float-left">
                                <input type='button' class='btn btn-previous btn-fill btn-default btn-wd'
                                       name='previous' value='Atrás'/>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <!--datetimePicker configuration-->
    <script>
        $(function () {
            var actualDate = new Date();
            actualDate.setHours(0,0);
            $('.datepicker').datetimepicker({
                ignoreReadonly: true,
                format: 'DD/MM/YYYY',
                minDate: actualDate,
                locale: 'es',
                useCurrent: false //Para que con el max date no quede seleccionada por defecto esa fecha
            });
            $("#datepicker_from").on("dp.change", function (e) {
                if(e.date == ''){
                    $("#dateContainerFrom").addClass( "is-empty" );
                }else{
                    $("#dateContainerFrom").removeClass( "is-empty" );
                }
            });
            $("#datepicker_to").on("dp.change", function (e) {
                if(e.date == ''){
                    $("#dateContainerTo").addClass( "is-empty" );
                }else{
                    $("#dateContainerTo").removeClass( "is-empty" );
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
            });
        });
    </script>

    <script>
        const lastPlanContainer = $('#lastPlan');
        const clientId = $("#clientId");
        var hasRemainingClasses = false;

        clientId.on("change", function (e) {
            loadClientLastPlanWithRemainingClasses(clientId.select2('data')[0].id);
        });

        function loadClientLastPlanWithRemainingClasses(clientId){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('clientLastPlanWithRemainingClasses') }}",
                method: "GET",
                data: {
                    clientId: clientId,
                },

                success: function (data) {
                    lastPlanContainer.addClass("d-none");
                    $("#lastPlanBody").empty();
                    hasRemainingClasses = false;
                    $("#remainingClases").val(0);
                    $("#lastPlanId").val(null);

                    if(data.lastPlanWithRemainingClasses){
                        hasRemainingClasses = true;
                        const jsDate = new Date(data.lastPlanWithRemainingClasses.expiration_date);
                        const formattedDate = jsDate.toLocaleDateString('es-ES', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        });

                        const frozenFrom = new Date(data.lastPlanWithRemainingClasses.frozen_from);
                        const formattedFrozenFrom = frozenFrom.toLocaleDateString('es-ES', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        });
                        const frozenTo= new Date(data.lastPlanWithRemainingClasses.frozen_to);
                        const formattedFrozenTo = frozenTo.toLocaleDateString('es-ES', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        });

                        const newRow = $("<tr>");
                        newRow.append('<td><div style="max-height:3rem; overflow:hidden">' + data.lastPlanWithRemainingClasses.name + "</td>");
                        newRow.append('<td><div style="max-height:3rem; overflow:hidden">' + (data.lastPlanWithRemainingClasses.remaining_shared_classes ?? '') + "</td>");
                        newRow.append('<td><div style="max-height:3rem; overflow:hidden">'+ formattedDate  + "</td>");
                        newRow.append('<td><div style="max-height:3rem; overflow:hidden">'+ formattedFrozenFrom  + " - " + formattedFrozenTo + "</td>");
                        if(data.lastPlanWithRemainingClasses.remaining_shared_classes){
                            $("#remainingClases").val(data.lastPlanWithRemainingClasses.remaining_shared_classes);
                            $("#lastPlanId").val(data.lastPlanWithRemainingClasses.id);
                        }
                        $("#lastPlanBody").append(newRow);

                        lastPlanContainer.removeClass("d-none");
                    }
                },
                error: function(data) {
                    console.log(data); //if you want to debug you need to uncomment this line and comment reload
                    $('html, body').animate({ scrollTop: 0 }, 0);
                    //location.reload();
                }
            });
        }
    </script>

    <!--Wizard -->
    <script src="{{asset('js/jquery.bootstrap.js')}}"></script>
    <script src="{{asset('js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('js/validate-freezePlan.js')}}"></script>
    <script src="{{asset('js/wizard.js')}}"></script>
@endpush
