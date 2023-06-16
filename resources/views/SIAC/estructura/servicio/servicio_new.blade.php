@extends(Auth::user()->Home)

@section('container')

    @component('components.home')
        @slot('titulo_catalogo',$titulo_catalogo)
        @slot('titulo_header','Nuevo')
        @slot('contenido')
            <div class="col-md-8">
                @component('components.card')
                    @slot('title_card','')
                    @slot('body_card')
                        @include('shared.code.__errors')
                        <form method="POST" action="{{ route('createServicio') }}" accept-charset="UTF-8" enctype="multipart/form-data" class="formData" id="formData" >
                            @csrf
                            @include('SIAC.estructura.servicio.__servicio.__servicio_new')
                            @include('shared.ui_kit.__button_form_normal')
                        </form>
                    @endslot
                @endcomponent
            </div>
        @endslot
    @endcomponent

@endsection
