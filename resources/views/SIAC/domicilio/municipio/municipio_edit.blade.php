@extends(Auth::user()->Home)

@section('container')

@component('components.home')
    @slot('titulo_catalogo',$titulo_catalogo)
    @slot('titulo_header','Editando el registro '. $items->id)
    @slot('contenido')
        <div class="col-md-8">
            @component('components.card')
                @slot('title_card','')
                @slot('body_card')
                    @include('shared.code.__errors')
                    <form method="POST" action="{{ route('updateMunicipio') }}">
                        @csrf
                        {{method_field('PUT')}}
                        @include('shared.catalogo.domicilio.municipio.__municipio_edit')
                        @include('shared.ui_kit.__button_form_normal')
                    </form>
                @endslot
            @endcomponent
        </div>
    @endslot
@endcomponent

@endsection
