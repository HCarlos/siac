 @extends(Auth::user()->Home)

@section('container')

@component('components.denuncia_ambito')
    @slot('contenido')
        @component('components.card')
            @slot('title_card',$titulo_header ?? "")
            @slot('body_card')
                @include('shared.code.__errors')
                <form method="POST" action="{{ route($updateDenunciaAmbito) }}" accept-charset="UTF-8" enctype="multipart/form-data" class="formData" id="formData" >
                    @csrf
                    {{ method_field('PUT') }}
                    @include('SIAC.denuncia.denuncia_ambito.__denuncia.__denuncia_edit')
                    @component('components.tools.buttons-form-denuncia-ambito')
                        @slot('msgLeft',' ')
                        @slot('item',$items)
                    @endcomponent
                </form>
            @endslot
        @endcomponent
    @endslot
@endcomponent

@endsection

@include('partials.script_google_maps')
