@component('components.form.form-modal')

    @slot('metodo','POST')
    @slot('action','saveImageneDen')
    @slot('_csrf')
        @csrf
        {{--{{method_field('PUT')}}--}}
    @endslot
    @slot('titulo_full_modal',"Datos de la imagen".$item->id)
    @slot('body_full_modal')
        @include('shared.denuncia.images.__imagene_edit_data')
    @endslot

@endcomponent
