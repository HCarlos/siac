@extends(Auth::user()->Home)

@section('container')

    @component('components.form.form-dropzone')

        @slot('metodo','POST')
        @slot('action','saveImagenAImagenDen')
        @slot('_csrf')
            @csrf
            {{--{{method_field('PUT')}}--}}
        @endslot
        @slot('titulo_dropzone',"Subir Imágenes")
        @slot('body_full_modal')
            @include('shared.denuncia.imagen_a_imagen.__imagene_a_imagen_upload')
        @endslot
        @slot('removeItem',$removeItem)

    @endcomponent

@endsection
