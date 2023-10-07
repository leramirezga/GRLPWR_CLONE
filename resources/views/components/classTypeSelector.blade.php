<select class="form-control pl-1" id="classTypeSelector" name="classType">
        <option style="" value="" disabled selected></option>
        @foreach($classTypes as $classType)
            <option style="color: black" value="{{$classType->id}}">{{$classType->type}}</option>
        @endforeach
</select>