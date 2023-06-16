@extends(Auth::user()->Home)

@section('container')

@component('components.home')

    @slot('titulo_catalogo',$titulo_catalogo)
    @slot('titulo_header','Nuev(@)')
    @slot('contenido')
        <div class="col-md-8">
            @component('components.card')
                @slot('title_card','')
                @slot('body_card')
                    @include('shared.code.__errors')
                    <form method="POST" action="{{ route('createAfiliacion') }}">
                        @csrf
                        @include('shared.catalogo.afiliacion.__afiliacion_new')
                        @include('shared.ui_kit.__button_form_normal')
                    </form>
                @endslot
            @endcomponent
        </div>
    @endslot

@endcomponent

@endsection
