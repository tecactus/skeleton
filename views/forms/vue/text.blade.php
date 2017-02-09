@php
	$attributes = implode(' ', collect(array_merge([':disabled' => "false"], $attributes))->map(function ($value, $name) { return is_numeric($name) ? $value : $name.'="'.$value.'"'; })->all());
@endphp
<el-input
	{!! $attributes !!}
	v-model="{!! $model !!}">
</el-input>