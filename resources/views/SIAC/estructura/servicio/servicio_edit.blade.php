@extends(Auth::user()->Home)

@section('container')

    @component('components.home')
        @slot('contenido')
            @component('components.card')
                @slot('title_card',$titulo_header ?? 'Edit')
                @slot('body_card')
                    @include('shared.code.__errors')
                    <form method="POST" action="{{ route('updateServicio') }}" accept-charset="UTF-8" enctype="multipart/form-data" class="formData" id="formData" >
                        @csrf
                        {{ method_field('PUT') }}
                        @include('SIAC.estructura.servicio.__servicio.__servicio_edit')
                        @include('shared.ui_kit.__button_form_normal')
                    </form>
                @endslot
            @endcomponent
        @endslot
    @endcomponent

@endsection
