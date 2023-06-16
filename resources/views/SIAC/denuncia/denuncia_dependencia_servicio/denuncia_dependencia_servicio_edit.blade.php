@extends(Auth::user()->Home)

@section('container')

@component('components.denuncia')
    @slot('contenido')
            @component('components.card')
                @slot('title_card','')
                @slot('body_card')
                    @include('shared.code.__errors')
                    <form method="POST" action="{{ route($postNew) }}">
                        @csrf
                        @include('SIAC.denuncia.denuncia_dependencia_servicio.__denuncia_dependencia_servicio.__denuncia_dependencia_servicio_edit')
                        @component('components.tools.buttons-form-denuncia')
                            @slot('msgLeft',' ')
                        @endcomponent
                    </form>
                @endslot
            @endcomponent
    @endslot
@endcomponent

@endsection
