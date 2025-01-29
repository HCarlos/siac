@extends(Auth::user()->home)

@section('container')

    @component('components.catalogo')
        @slot('buttons')
            @include('shared.ui_kit.__menu_denuncia_ambito_'.$prefijo_toolbar)
        @endslot
        @slot('body_catalogo')
            @include('SIAC.denuncia.denuncia_ambito.__denuncia.__denuncia_list')
        @endslot
    @endcomponent

@endsection

