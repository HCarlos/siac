@extends(Auth::user()->Home)

@section('container')

    @component('components.catalogo_operador')

        @slot('buttons_catalogo_operador')
{{--            @include('shared.ui_kit.__menu_denuncia_dependencia_servicio_ambito')--}}
        @endslot
        @slot('body_catalogo_operador')
            @include('SIAC.denuncia.denuncia_operador.__denuncia_operador.__denuncia_operador_list')
        @endslot

    @endcomponent

@endsection

