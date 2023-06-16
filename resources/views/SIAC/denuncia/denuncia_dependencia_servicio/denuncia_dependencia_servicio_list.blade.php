@extends(Auth::user()->Home)

@section('container')

    @component('components.catalogo')

        @slot('buttons')
            @include('shared.ui_kit.__menu_denuncia_dependencia_servicio')
        @endslot
        @slot('body_catalogo')
            @include('SIAC.denuncia.denuncia_dependencia_servicio.__denuncia_dependencia_servicio.__denuncia_dependencia_servicio_list')
        @endslot

    @endcomponent

@endsection

