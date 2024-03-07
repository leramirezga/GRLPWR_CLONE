<div class="form-group row">
    <label for="{{$name}}" class="col-12 col-form-label text-md-center">{{$description}} <span id="{{$name}}-value">0</span></label>
    <div class="col-12 col-md-8 m-auto">
        <input id="{{$name}}" class="{{ $errors->has($name) ? ' is-invalid' : '' }}" name="{{$name}}" value="{{ old($name) ?? 0 }}" {{$attributes}} type="range" autofocus>
        @if ($errors->has($name))
            <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first($name) }}</strong>
                    </span>
        @endif
        @isset($showReason)
            <div id="{{$name}}_reason" class="input-group">
                <div class="w-100">
                    <label class="control-label">{{$reason}} <small>(requerido)</small></label>
                    <input id="reason_{{$name}}" name="reason_{{$name}}" class="form-control" value="{{$value ?? ''}}">
                </div>
            </div>
            @if ($errors->has($name.'_reason'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first($name.'_reason') }}</strong>
                </span>
            @endif
        @endif
    </div>
</div>