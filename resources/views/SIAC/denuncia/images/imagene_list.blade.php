@extends(Auth::user()->Home)

@section('container')

    @component('components.catalogo')

        @slot('buttons')
            @include('shared.ui_kit.__menu_imagene')
        @endslot
        @slot('body_catalogo')
            @include('shared.denuncia.images.__imagene_list')
        @endslot

    @endcomponent

@endsection

