@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12" id="{{ $appId or 'datatable-creation-app' }}">
            
            @if (isset($creationForm))
                @include($creationForm)
            @else
                @include('skeleton::datatables.creation-form')
            @endif

            @component('skeleton::components.panel')
                @slot('heading')
                    {{ $panelTitle or 'Título' }}
                @endslot
                @slot('body')
                    <div class="table-responsive">
                        {!! $dataTable->table() !!}
                    </div>
                @endslot
            @endcomponent

        </div>
    </div>  

</div>
@endsection

@push('scripts')

    @if(isset($jsAsyncApp))
        @include('skeleton::datatables.creation-script', compact('jsAsyncApp'))
    @endif

	{!! $dataTable->scripts() !!}

@endpush
