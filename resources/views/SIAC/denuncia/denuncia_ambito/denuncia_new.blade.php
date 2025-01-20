@extends(Auth::user()->Home)

@section('container')

@component('components.denuncia_ambito')
    @slot('contenido')
        @component('components.card_ambito')
            @slot('title_card',$titulo_header ?? "")
            @slot('body_card')
                @include('shared.code.__errors')
                <form method="POST" action="{{ route($createDenunciaAmbito) }}" accept-charset="UTF-8" enctype="multipart/form-data" class="formData" id="formData" >
                    @csrf
                    @include('SIAC.denuncia.denuncia_ambito.__denuncia.__denuncia_new')
                    @component('components.tools.buttons-form-denuncia-ambito')
                        @slot('msgLeft',' ')
                    @endcomponent
                </form>
            @endslot
        @endcomponent
    @endslot
@endcomponent

@endsection

@include('partials.script_google_maps')
