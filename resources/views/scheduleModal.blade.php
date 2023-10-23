<div class="modal fade" id="scheduleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="agendarForm" autocomplete="off">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agendamiento</h5>
                </div>
                <div class="modal-body">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="rentEquipment1" name="rentEquipment" value="1" class="custom-control-input" required>
                        <label class="custom-control-label" for="rentEquipment1">Necesito {{$event->classType->required_equipment}}</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="rentEquipment2" name="rentEquipment" value="0" class="custom-control-input" required>
                        <label class="custom-control-label" for="rentEquipment2">Tengo mis propi@s {{$event->classType->required_equipment}}</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn bg-fifth ms-3">Agendar</button>
                </div>
            </form>
        </div>
    </div>
</div>