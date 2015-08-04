<div class="form-group @if($error) has-error @endif">
    {!! Form::label($name, $label) !!}
    {!! $control !!}
    @if ($error) <p class="help-block">{!! $error !!}</p> @endif
</div>

