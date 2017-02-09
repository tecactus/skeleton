@php
	$attributes = implode(' ', collect(array_merge([':disabled' => "false"], $attributes))->map(function ($value, $name) { return is_numeric($name) ? $value : $name.'="'.$value.'"'; })->all());
@endphp
<el-switch
	{!! $attributes !!}
	class="skeleton-custom"
	v-model="{!! $model !!}">
</el-switch>