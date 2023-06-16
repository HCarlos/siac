@extends(Auth::user()->Home)

@section('container')

@component('components.denuncia')
    @slot('contenido')
            @component('components.card')
                @slot('title_card','Nueva Solicitud')
                @slot('body_card')
                    @include('shared.code.__errors')
                    <form method="POST" action="{{ route('createDenunciaCiudadana') }}" class="col-lg-12" accept-charset="UTF-8" enctype="multipart/form-data" class="formData">
                        @csrf
                        @include('SIAC.denuncia.denuncia_ciudadana.__denuncia_ciudadana.__denuncia_ciudadana_new')
                        @component('components.tools.buttons-form-denuncia-ciudadana')
                            @slot('msgLeft',' ')
                        @endcomponent
                    </form>
                @endslot
            @endcomponent
    @endslot
@endcomponent

@endsection
