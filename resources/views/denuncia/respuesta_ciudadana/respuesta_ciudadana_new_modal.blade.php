@component('components.form.form-modal')
    @slot('metodo','POST')
    @slot('action','saveRespuestaDen')
    @slot('_csrf')
        @csrf
        {{--{{method_field('PUT')}}--}}
    @endslot
    @slot('titulo_full_modal',"Nueva Respuesta")
    @slot('body_full_modal')
        @include('shared.denuncia.respuesta_ciudadana.__respuesta_ciudadana_new')
    @endslot
@endcomponent
