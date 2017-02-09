<div class="form-group {{ $errors->has($name) ? 'has-error' : '' }}">
	{{ Form::label($name, $label, ['class' => 'control-label ' . (isset($formSizes['label']) ? 'col-sm-'.$formSizes['label'] : 'col-sm-4')]) }}
	<div class="{{ isset($formSizes['input']) ? 'col-sm-'.$formSizes['input'] : 'col-sm-8' }}">
		{{ Form::select($name, $options, $value, array_merge(['id' => $name, 'class' => 'form-control'], $attributes)) }}
		@if ($errors->has($name))
			<p class="help-block">{{ $errors->first($name) }}</p>
		@endif
	</div>
</div>