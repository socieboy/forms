<div class="form-group @if($error) has-error @endif">
    <label for="{{ $name }}">{{ $label }}</label>
    {!! $control !!}
    @if ($error) <p class="help-block">{!! $error !!}</p> @endif
</div>

