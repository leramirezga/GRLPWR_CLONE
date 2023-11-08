<div class="form-group">
    <label for="classTypeSelector">Tipo de clase</label>
    <select class="form-control pl-1 bg-dark" id="classTypeSelector" name="classType">
        <option value="all" selected>Todas</option>
        @foreach($classTypes as $classType)
            <option value="{{$classType->id}}">{{$classType->type}}</option>
        @endforeach
    </select>
</div>
