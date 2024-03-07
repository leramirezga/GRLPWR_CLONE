<div class="form-group row">
    <label for="{{$name}}" class="col-12 col-form-label text-md-center">{{$description}}</label>
    <div class="col-12 col-md-8 m-auto">
        <input id="{{$name}}" class="{{ $errors->has($name) ? ' is-invalid' : '' }} w-100" name="{{$name}}" value="{{ old($name) ?? ''}}" {{$attributes}} autofocus>
        @if ($errors->has($name))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first($name) }}</strong>
            </span>
        @endif
    </div>
</div>