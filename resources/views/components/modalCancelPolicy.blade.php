<div class="modal fade" id="alertaCancelaciontemprana" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Recordatorio de cancelación</h5>
            </div>
            <div class="modal-body">
                <p id="advertenciaPenalidad">Recuerda que debes cancelar con {{ HOURS_TO_CANCEL_TRAINING }} horas de antelación para que no se te descuente la clase,
                    la fecha límite es: {{Carbon\Carbon::parse(substr($event->fecha_inicio, 0, 10) . $event->start_hour)->subHours(HOURS_TO_CANCEL_TRAINING)}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn themed-btn" data-dismiss="modal" aria-label="Close" onclick="checkPlan()">Cerrar</button>
            </div>
        </div>
    </div>
</div>