@extends(Auth::user()->Home)

@section('container')

    @component('components.denuncia')
        @slot('contenido')
            @component('components.card')
                @slot('title_card','')
                @slot('body_card')
                    @include('shared.code.__errors')
                    <form method="POST" action="{{ route($postNew) }}" accept-charset="UTF-8" enctype="multipart/form-data" class="formData" id="formData">
                        @csrf
                        @include('SIAC.denuncia.denuncia_dependencia_servicio_ambito.__denuncia_dependencia_servicio_ambito.__denuncia_dependencia_servicio_ambito_edit')
                        @component('components.tools.buttons-form-denuncia-ajax')
                            @slot('msgLeft',' ')
                        @endcomponent
                    </form>
                @endslot
            @endcomponent
        @endslot
    @endcomponent

@endsection
