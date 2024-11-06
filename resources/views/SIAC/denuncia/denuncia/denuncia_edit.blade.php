 @extends(Auth::user()->Home)

@section('container')

@component('components.denuncia')
    @slot('contenido')
            @component('components.card')
                @slot('title_card',$titulo_header ?? "")
                @slot('body_card')
                    @include('shared.code.__errors')
                    <form method="POST" action="{{ route('updateDenuncia') }}" accept-charset="UTF-8" enctype="multipart/form-data" class="formData" id="formData" >
                        @csrf
                        {{ method_field('PUT') }}
                        @include('SIAC.denuncia.denuncia.__denuncia.__denuncia_edit')
                        @component('components.tools.buttons-form-denuncia')
                            @slot('msgLeft',' ')
                            @slot('item',$items)
                        @endcomponent
                    </form>
                @endslot
            @endcomponent
    @endslot
@endcomponent

@endsection

