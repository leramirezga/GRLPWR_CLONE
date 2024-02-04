@push('head-content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
@endpush

<!--modal dar review-->
<div class="modal fade color-black" id="registerAttendee" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: none">
                <h5 class="modal-title">Registrar Asistente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" id="register" role="form">
                <div class="modal-body" style="padding-bottom: 0">
                    @if(strcasecmp($event->classType->type, \App\Utils\PlanTypesEnum::KANGOO->value) == 0)
                        <div class="mb-2">
                            <p class="mb-1">¿Rentar {{$event->classType->required_equipment}}?</p>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="rentEquipment1" name="rentEquipment" value="1" class="custom-control-input" required>
                                <label class="custom-control-label" for="rentEquipment1">Si</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="rentEquipment2" name="rentEquipment" value="0" class="custom-control-input" required>
                                <label class="custom-control-label text-danger" for="rentEquipment2">No</label>
                            </div>
                        </div>
                    @endif
                    <div>
                        <p class="mb-1">¿Es Cortesía?</p>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="isCourtesy1" name="isCourtesy" value="1" class="custom-control-input" required>
                            <label class="custom-control-label" for="isCourtesy1">Si</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="isCourtesy2" name="isCourtesy" value="0" class="custom-control-input" required>
                            <label class="custom-control-label text-danger" for="isCourtesy2">No</label>
                        </div>
                    </div>
                    <div class="mb-2">
                        <p class="mb-1">¿Validar cupos?</p>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="validateVacancy1" name="validateVacancy" value="1" class="custom-control-input" required>
                            <label class="custom-control-label" for="validateVacancy1">Si</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="validateVacancy2" name="validateVacancy" value="0" class="custom-control-input" required>
                            <label class="custom-control-label text-danger" for="validateVacancy2">No</label>
                        </div>
                    </div>
                    <div class="form-group label-floating mt-4">
                        <select class="form-control select2" id="clientId" name="clientId" required>
                            <option value="" disabled selected>Usuario...</option>
                            @foreach(\App\Model\Cliente::all() as $client)
                                <option class="color-black" value="{{$client->usuario_id}}">{{$client->usuario->nombre}} {{$client->usuario->apellido_1}} {{$client->usuario->telefono}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 0; padding-top: 0">
                    <button type="submit" class="btn btn-success">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
                dropdownParent: $("#registerAttendee")
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#register").submit(function(e) {
                e.preventDefault();
                addParticipant();
            });
        });

        function addParticipant(){
            const clientId = $("#clientId").val();
            const rentEquipment = $('input[name="rentEquipment"]:checked').val();
            const isCourtesy = $('input[name="isCourtesy"]:checked').val();
            const validateVacancy  = $('input[name="validateVacancy"]:checked').val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('scheduleEvent') }}",
                method: "POST",
                data: {clientId: clientId,
                    eventId: {{$event->id}},
                    startDate: "{{Carbon\Carbon::parse($event->fecha_inicio)->format('d-m-Y')}}",
                    startHour: "{{$event->start_hour}}",
                    endDate: "{{Carbon\Carbon::parse($event->fecha_fin)->format('d-m-Y')}}",
                    endHour: "{{$event->end_hour}}",
                    isCourtesy : isCourtesy,
                    rentEquipment: rentEquipment,
                    validateVacancy: validateVacancy
                },

                success: function (data) {
                    console.log(data); //if you want to debug you need to uncomment this line and comment reload
                    $('html, body').animate({ scrollTop: 0 }, 0);
                    location.reload();
                },
                error: function(data) {
                    console.log(data); //if you want to debug you need to uncomment this line and comment reload
                    $('html, body').animate({ scrollTop: 0 }, 0);
                    location.reload();
                }
            });
        }
    </script>
@endpush