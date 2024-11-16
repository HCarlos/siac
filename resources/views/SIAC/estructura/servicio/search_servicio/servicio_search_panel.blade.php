@component('components.tools.form-full-modal-search')
    @slot('metodo','POST')
    @slot('action','findDataInServicio')
    @slot('_csrf')
        @csrf
        {{method_field('PUT')}}
    @endslot
    @slot('titulo_full_modal',"Filtrar de servicios")
    @slot('body_full_modal')
        @include('SIAC.estructura.servicio.search_servicio.__search.__search_servicio_in_list')
    @endslot
@endcomponent
