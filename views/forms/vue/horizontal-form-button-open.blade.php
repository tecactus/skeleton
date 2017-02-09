@php
	$attributes = implode(' ', collect($attributes)->map(function ($value, $name) { return is_numeric($name) ? $value : $name.'="'.$value.'"'; })->all());
@endphp
<div class="form-group" {!! $attributes !!}>
	<div class="{{ isset($formSizes['input']) ? 'col-sm-'.$formSizes['input'] : 'col-sm-8' }} {{isset($formSizes['label']) ? 'col-sm-'.$formSizes['label'] : 'col-sm-offset-4'}}">