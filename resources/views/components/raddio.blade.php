<div class="form-group row">
    <label for="{{$name}}" class="col-12 col-form-label text-md-center">{{$description}}</label>
    <div class="col-12 col-md-8 m-auto">
        <input id="{{$name}}-yes" class="{{ $errors->has($name) ? ' is-invalid' : '' }}" name="{{$name}}" value="1" {{$attributes}} type="radio" {{$checked ? 'checked=checked' : '' }} autofocus>
        <label for="{{$name}}-yes">Sí</label>
        <input id="{{$name}}-no" class="{{ $errors->has($name) ? ' is-invalid' : '' }}" name="{{$name}}" value="0" {{$attributes}} type="radio" {{$checked ? '' : 'checked=checked' }} autofocus>
        <label for="{{$name}}-no">No</label>
        @if ($errors->has($name))
            <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first($name) }}</strong>
                    </span>
        @endif
        @isset($showReason)
            <div id="{{$name}}-reason" class="input-group" style="{{!$checked ? '' : 'display:none'}}">
                <div class="w-100">
                    <label class="control-label">{{$reason}} <small>(requerido)</small></label>
                    <input id="reason-{{$name}}" name="reason_{{$name}}" class="form-control" value="{{$value ?? ''}}">
                </div>
            </div>
            @if ($errors->has($name.'-reason'))
                <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first($name.'-reason') }}</strong>
                        </span>
            @endif
        @endif
    </div>
</div>

@isset($showReason)
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const raddioTrue = document.getElementById('{{$name}}-yes');
                const raddioFalse = document.getElementById('{{$name}}-no');

                raddioTrue.addEventListener('change', function () {
                    if (raddioTrue.checked) {
                        $('#{{$name}}-reason').show();
                        document.getElementById("reason-{{$name}}").required = true;
                    }
                });
                raddioFalse.addEventListener('change', function () {
                    if (raddioFalse.checked) {
                        $('#{{$name}}-reason').hide();
                        document.getElementById("reason-{{$name}}").required = false;
                    }
                });
            });
        </script>
    @endpush
@endisset