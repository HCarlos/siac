@extends(Auth::user()->Home)

@section('container')

@component('components.denuncia')
    @slot('contenido')
            @component('components.card')
                @slot('title_card','Nueva Denuncia')
                @slot('body_card')
                    @include('shared.code.__errors')
                    <form method="POST" action="{{ route('createDenunciaCiudadana') }}">
                        @csrf
                        @include('shared.denuncia.denuncia_ciudadana.__denuncia_ciudadana_new')
                        @component('components.tools.buttons-form-denuncia')
                            @slot('msgLeft',' ')
                        @endcomponent
                    </form>
                @endslot
            @endcomponent
    @endslot
@endcomponent

@endsection
