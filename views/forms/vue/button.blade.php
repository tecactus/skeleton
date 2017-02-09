@php
	$attributes = implode(' ', collect(array_merge([':disabled' => "false"], $attributes))->map(function ($value, $name) { return is_numeric($name) ? $value : $name.'="'.$value.'"'; })->all());
@endphp
<el-button {!! $attributes !!}>
	{{ $name }}
</el-button>