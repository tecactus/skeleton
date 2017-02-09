<div class="panel panel-{{ $type or 'default' }}" id="{{ $id or null }}">
    @if (isset($heading))
       <div class="panel-heading">{{ $heading or 'Título' }}</div>
    @endif
    @if (isset($body))
       <div class="panel-body">{{ $body }}</div>
    @endif
    @if (isset($footer))
	   <div class="panel-footer">{{ $footer }}</div>
    @endif
    {{ $slot }}
</div>