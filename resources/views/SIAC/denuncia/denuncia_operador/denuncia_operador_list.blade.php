@extends(Auth::user()->Home)

@section('container')

    @component('components.catalogo')

        @slot('buttons')
            @include('shared.ui_kit.__menu_denuncia_dependencia_servicio_ambito')
        @endslot
        @slot('body_catalogo')
            @include('SIAC.denuncia.denuncia_operador.__denuncia_operador.__denuncia_operador_list')
        @endslot

    @endcomponent

@endsection

