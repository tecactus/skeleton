@php
	$attributes = implode(' ', collect(array_merge(['class' => 'skeleton-custom', 'placeholder' => 'Escoge una fecha', 'format' => 'dd-MM-yyyy', ':disabled' => "false"], $attributes))->map(function ($value, $name) { return is_numeric($name) ? $value : $name.'="'.$value.'"'; })->all());
@endphp
<el-date-picker
	{!! $attributes !!}
	v-model="{!! $model !!}"
	type="date"
	picker-options="{firstDayOfWeek: 1}">
</el-date-picker>