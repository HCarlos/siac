@extends(Auth::user()->Home)

@section('container')

    @component('components.catalogo')

        @slot('buttons')
            @include('shared.ui_kit.__menu_respuesta')
        @endslot
        @slot('body_catalogo')
            @include('shared.denuncia.respuesta_ciudadana.__respuesta_ciudadana_list')
        @endslot

    @endcomponent

@endsection

