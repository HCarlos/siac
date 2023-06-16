@extends(Auth::user()->Home)

@section('container')

    @component('components.form.form-dropzone')

        @slot('metodo','POST')
        @slot('action','saveImageneDen')
        @slot('_csrf')
            @csrf
        @endslot
        @slot('titulo_dropzone',"Subir Imágenes")
        @slot('body_full_modal')
            @include('shared.denuncia.images.__imagene_upload')
        @endslot
        @slot('removeItem',$removeItem)

    @endcomponent

    @endsection

