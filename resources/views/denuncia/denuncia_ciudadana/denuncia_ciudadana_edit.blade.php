@extends(Auth::user()->Home)

@section('container')

@component('components.denuncia')
{{--    @slot('titulo_catalogo',$titulo_catalogo)--}}
{{--    @slot('titulo_header','Folio: '. $items->id)--}}
    @slot('contenido')
            @component('components.card')
                @slot('title_card','Editando... ')
                @slot('body_card')
                    @include('shared.code.__errors')
{{--                    @include('shared.search.__search_denuncia_adress_list')--}}
                    <form method="POST" action="{{ route('updateDenuncia') }}">
                        @csrf
                        {{method_field('PUT')}}
                        @include('shared.denuncia.denuncia.__denuncia_edit')
                        @component('components.tools.buttons-form-denuncia')
                            @slot('msgLeft',' ')
                        @endcomponent
                    </form>
                @endslot
            @endcomponent
    @endslot
@endcomponent

@endsection
