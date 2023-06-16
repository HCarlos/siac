@extends(Auth::user()->Home)

@section('container')

    @component('components.catalogo')
        @slot('buttons')
            @include('shared.ui_kit.__menu_denuncia_ciudadana')
        @endslot
        @slot('body_catalogo')
            @include('SIAC.denuncia.denuncia_ciudadana.__denuncia_ciudadana.__denuncia_ciudadana_list')
        @endslot
    @endcomponent

@endsection

