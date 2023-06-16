@extends(Auth::user()->home)

@section('container')

    @component('components.catalogo')
        @slot('buttons')
            @include('shared.ui_kit.__menu_denuncia')
        @endslot
        @slot('body_catalogo')
            @include('SIAC.denuncia.denuncia.__denuncia.__denuncia_list')
        @endslot
    @endcomponent

@endsection

