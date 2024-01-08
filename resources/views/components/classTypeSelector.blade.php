<div class="form-group">
    <label for="classTypeSelector">Tipo de clase</label>
    <select class="form-control pl-1" id="classTypeSelector" name="classType">
        @isset($showAll)
            <option value="all" selected>Todas</option>
        @else
            <option value="" disabled selected>selecciona</option>
        @endisset
        @foreach($classTypes as $classType)
            <option value="{{$classType->id}}">{{$classType->type}}</option>
        @endforeach
    </select>
</div>
