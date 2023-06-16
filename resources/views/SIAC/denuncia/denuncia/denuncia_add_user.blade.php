 @extends(Auth::user()->Home)

@section('container')

@component('components.denuncia')
    @slot('contenido')
            @component('components.card')
                @slot('title_card',$titulo_header ?? "")
                @slot('body_card')
                    @include('shared.code.__errors')
                    <form method="POST" action="{{ route('updateAddUserDenuncia') }}" accept-charset="UTF-8" enctype="multipart/form-data" class="formData" id="formData" >
                        @csrf
                        {{ method_field('PUT') }}
                        @include('SIAC.denuncia.denuncia.__denuncia.__denuncia_add_user')
                        @include('shared.ui_kit.__button_form_denuncia_add_user')
                    </form>
                    @include('shared.ui_kit.__add_user_table')
                @endslot
            @endcomponent
    @endslot
@endcomponent

@endsection
