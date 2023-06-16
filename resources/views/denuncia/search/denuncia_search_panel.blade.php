@component('components.tools.form-full-modal-search')
    @slot('metodo','POST')
    @slot('action','findDataInDenuncia')
    @slot('_csrf')
        @csrf
        {{method_field('PUT')}}
    @endslot
    @slot('titulo_full_modal',"Busqueda de denuncia")
    @slot('body_full_modal')
        @include('shared.search.__search_denuncia_in_list')
    @endslot
@endcomponent
