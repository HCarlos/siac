@extends(Auth::user()->Home)

@section('container')

@component('components.catalogo')
    @slot('buttons')
        @include('shared.ui_kit.__menu_catalogo_servicios')
    @endslot
    @slot('body_catalogo')
        <div class="col-md-12">
            @include('SIAC.estructura.servicio.__servicio.__servicio_list')
        </div>
    @endslot
@endcomponent

@endsection
