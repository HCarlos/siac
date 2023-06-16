@extends(Auth::user()->Home)

@section('container')

@component('components.home')
    @slot('titulo_catalogo',$titulo_catalogo)
    @slot('titulo_header','Nueva')
    @slot('contenido')
        <div class="col-md-8">
            @component('components.card')
                @slot('title_card','')
                @slot('body_card')
                    @include('shared.code.__errors')
                    <form method="POST" action="{{ route('createCategoria') }}">
                        @csrf
                        @include('shared.catalogo.user.categoria.__categoria_new')
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary float-right">Guardar</button>
                        </div>
                    </form>
                @endslot
            @endcomponent
        </div>
    @endslot
@endcomponent

@endsection
