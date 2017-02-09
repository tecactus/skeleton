@php
	$attributes = implode(' ', collect(array_merge(['class' => 'skeleton-custom', 'placeholder' => '-', ':disabled' => "false"], $attributes))->map(function ($value, $name) { return is_numeric($name) ? $value : $name.'="'.$value.'"'; })->all());
@endphp
<el-select v-model="{!! $model !!}" {!! $attributes !!}>
	<el-option
	  v-for="item in {{ $collection }}"
	  :label="{!! $label !!}"
	  :value="{!! $value !!}">
	</el-option>
</el-select>