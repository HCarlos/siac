@component('components.tools.form-full-modal-search')
    @slot('metodo','POST')
    @slot('action','findDataInDenunciaAmbito')
    @slot('_csrf')
        @csrf
        {{method_field('PUT')}}
    @endslot
    @slot('titulo_full_modal',"Búsqueda de solicitud")
    @slot('body_full_modal')
        @include('SIAC.denuncia.search_ambito.__search.__search_denuncia_in_list')
    @endslot
@endcomponent
