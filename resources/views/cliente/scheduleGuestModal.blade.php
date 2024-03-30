<!--This code can't be in the push head-content -->
<!-- Fonts -->
<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

<!-- CSS Files -->
<link href="{{asset('css/scheduleCourtesyModal.css')}}" rel="stylesheet"/>

<!-- Fonts and icons -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />

<script src="https://kit.fontawesome.com/2ccdb5d1d9.js" crossorigin="anonymous"></script>

<!--datetimePicker-->
<link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
<script src="{{asset('js/datetimePicker.js')}}"></script>

<div class="modal fade justify-content-center align-items-center" id="guestModal" tabindex="-1" role="dialog">
    <div class="modal-dialog wizard-guest-courtesy" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h3 class="modal-title m-auto" style="padding-left: 1.5rem!important;">
                    Agenda a tu invitado
                </h3>
                <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body wizard-card" data-color="green" style="padding: 0 0 3vh 0">
                <form id="scheduleGuestForm" method="post" action="{{route('scheduleGuest')}}" enctype="multipart/form-data">
                    @method('POST')
                    @csrf

                    <input type="hidden" name="event" value="{{$event}}">
                    <div class="row">
                        <h4 class="info-text"></h4>
                        <div class="col-10 m-auto">
                            <div class="input-group">
                                                <span class="iconos">
                                                    <i class="material-icons">phone_iphone</i>
                                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Celular de tu invitado <small>(requerido)</small></label>
                                    <input name="cellphone" type="number" min="1000000000" max="9999999999" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-10 m-auto kangooForm d-{{strcasecmp($event->classType->type, \App\Utils\PlanTypesEnum::KANGOO->value) === 0 ? 'flex': 'none'}}">
                            <span class="iconos">
                                    <i class="material-icons">snowshoeing</i>
                            </span>
                            <div class="custom-control custom-radio custom-control-inline">

                                <input type="radio" id="rentEquipment1" name="rentEquipment" value="1" class="custom-control-input" required>
                                <label class="custom-control-label rentEquipmentLabel" for="rentEquipment1">Separar Kangoos</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">

                                <input type="radio" id="rentEquipment2" name="rentEquipment" value="0" class="custom-control-input" required>
                                <label class="custom-control-label rentEquipmentLabel" for="rentEquipment2">Tengo mis propios Kangoos</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-10 m-auto">
                        <input type='submit' class='btn btn-fill btn-success btn-wd float-right' name='finish' value='Finalizar' onclick="validar()"/>
                    </div>
                    <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <!--   Core JS Files   -->
    <script src="{{asset('js/jquery.bootstrap.js')}}" type="text/javascript"></script>
    <!--  Plugin for the Wizard -->
    <script src="{{asset('js/validate-scheduleGuest.js')}}"></script>
    <script src="{{asset('js/wizard.js')}}"></script>

    <!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
    <script src="{{asset('js/jquery.validate.min.js')}}"></script>

    <script>
        const select = document.getElementById('classTypeSelector');
        document.addEventListener('DOMContentLoaded', function() {
            const rentEquipment = document.getElementById('rentEquipment1');
            const notRentEquipment = document.getElementById('rentEquipment2');


            select.addEventListener('change', function () {
                rentEquipment.checked = false;
                notRentEquipment.checked = false;
                if (select.value === "1") {
                    $(".kangooForm").css("display", "flex");
                } else {
                    loadSessions(false);
                    $(".kangooForm").css("display", "none");
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

    <script>
        function validar() {
            if($("input[name='rentEquipment']").is(':visible')){
                if (typeof $("input[name='rentEquipment']:checked").val() === "undefined") {
                    $('.rentEquipmentLabel').css("cssText", "color: red!important;")
                    $('.rentEquipmentLabel').css("border-color", "red");
                }
            }
        }

        $(document).ready(function () {
            $("input[name='rentEquipment']").click(function () {
                $('.rentEquipmentLabel').css("cssText", "color:'';")
                $('.rentEquipmentLabel').css("border-color", "");
            });
        });
    </script>
@endpush
