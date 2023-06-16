@extends(Auth::user()->Home)

@section('container')

@component('components.catalogo')
    @slot('buttons')
        @include('shared.ui_kit.__menu_catalogo')
    @endslot
    @slot('body_catalogo')
        <div class="col-md-12">
            @include('shared.catalogo.domicilio.cp.__cp_list')
        </div>
    @endslot
@endcomponent

@endsection
