@extends(Auth::user()->Home)

@section('container')

@component('components.home')
    @slot('titulo_catalogo',$titulo_catalogo)
    @slot('titulo_header','Perfil')
    @slot('contenido')
        <div class="col-md-4">
            @include('shared.catalogo.user.__user_photo_header')
        </div> <!-- end col-->

        <div class="col-md-8">
            <!-- Chart-->
            @component('components.card')
                @slot('title_card',$user->FullName)
                @slot('body_card')
                    @include('shared.code.__errors')
                    <form method="POST" action="{{ route('EditUser') }}">
                        @csrf
                        {{method_field('PUT')}}
                        @include('shared.catalogo.user.__user_edit')
                        @include('shared.ui_kit.__button_form_normal')
                    </form>
                @endslot
            @endcomponent
        </div>
    @endslot
@endcomponent


@endsection

@section("script_extra")
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{asset('/js/servimun.autocomplete.js')}}?time()"></script>
    <script >
        jQuery(function($) {
            $(document).ready(function () {
            });
        });

    </script>
@endsection
