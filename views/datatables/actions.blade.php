@if($jsShowButonAction)
<a href="javascript:void(0)" onClick="{{$jsShowButonAction}}('{{ $row->id }}')"  class="btn btn-xs btn-info" title="editar"><i class="fa fa-pencil"></i></a>
@else
<a href="{{ url(request()->segments()[0], $row->id) }}" class="btn btn-xs btn-info" title="editar"><i class="fa fa-pencil"></i></a>
@endif
{{ Form::dtDeleteButton( url(request()->segments()[0], $row->id) ) }}