@extends(Auth::user()->Home)

@section('container')

@component('components.catalogo')
    @slot('buttons')
        @include('shared.ui_kit.__menu_catalogo')
    @endslot
    @slot('body_catalogo')
        <div class="col-md-12">
            @include('SIAC.domicilio.comunidad.__comunidad.__comunidad_list')
        </div>
    @endslot
@endcomponent

@endsection
