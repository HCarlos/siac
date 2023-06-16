@extends(Auth::user()->Home)

@section('container')

@component('components.home')
    @slot('titulo_catalogo',$titulo_catalogo)
    @slot('titulo_header','Ver mi perfil')
    @slot('contenido')
        <div class="col-md-4">
            @include('shared.catalogo.user.__user_photo_header')
        </div> <!-- end col-->

        <div class="col-md-8">
            <!-- Chart-->
            @component('components.card-sin-fondo')
                @slot('title_card',Auth::user()->FullName)
                @slot('body_card')
                    @include('shared.code.__errors')
                    <form method="POST" action="#">
                        @include('shared.catalogo.user.__user_solo_lectura')
                        @include('shared.ui_kit.__button_form_normal')
                    </form>
                @endslot
            @endcomponent
        </div>
    @endslot
@endcomponent

@endsection
