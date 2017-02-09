@php
	$attributes = implode(' ', collect($attributes)->map(function ($value, $name) { return is_numeric($name) ? $value : $name.'="'.$value.'"'; })->all());
@endphp
<div class="form-group" :class="errors['{{$name}}'] ? 'has-error' : ''" {!! $attributes !!}>
	{{ Form::label($label, $label, ['class' => 'control-label ' . (isset($formSizes['label']) ? 'col-sm-'.$formSizes['label'] : 'col-sm-4')]) }}
	<div class="{{ isset($formSizes['input']) ? 'col-sm-'.$formSizes['input'] : 'col-sm-8' }}">