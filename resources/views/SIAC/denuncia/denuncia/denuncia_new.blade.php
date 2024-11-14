@extends(Auth::user()->Home)

@section('container')

@component('components.denuncia')
    @slot('contenido')
            @component('components.card')
                @slot('title_card',$titulo_header ?? "")
                @slot('body_card')
                    @include('shared.code.__errors')
                    <form method="POST" action="{{ route($postNew) }}" accept-charset="UTF-8" enctype="multipart/form-data" class="formData" id="formData" >
                        @csrf
                        @include('SIAC.denuncia.denuncia.__denuncia.__denuncia_new')
                        @component('components.tools.buttons-form-denuncia')
                            @slot('msgLeft',' ')
                        @endcomponent
                    </form>
                @endslot
            @endcomponent
    @endslot
@endcomponent
@endsection


