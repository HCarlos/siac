@extends(Auth::user()->Home)

@section('container')

    @component('components.catalogo')
        @slot('buttons')
            @include('shared.ui_kit.__menu_denuncia')
        @endslot
        @slot('body_catalogo')
            @include('shared.denuncia.denuncia_ambito.__denuncia_list')
        @endslot
    @endcomponent

@endsection

