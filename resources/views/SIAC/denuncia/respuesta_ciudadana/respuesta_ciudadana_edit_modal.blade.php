{{--@component('components.form.form-modal')--}}
{{--    @slot('metodo','POST')--}}
{{--    @slot('action','saveRespuestaDen')--}}
{{--    @slot('_csrf')--}}
{{--        @csrf--}}
{{--        {{method_field('PUT')}}--}}
{{--    @endslot--}}
{{--    @slot('titulo_full_modal','Editando la respuesta '.$id)--}}
{{--    @slot('body_full_modal')--}}
{{--        @include('SIAC.denuncia.respuesta_ciudadana.__respuesta_ciudadana.__respuesta_ciudadana_edit')--}}
{{--    @endslot--}}
{{--@endcomponent--}}

@component('components.form.form-modal')
    @slot('Method', $Method ?? 'GET')
    @slot('Titulo', $Titulo ?? '')
    @slot('Route', $Route ?? '#')
    @slot('IsUpload', $IsUpload ?? false)
    @slot('IsNew', $IsNew ?? false)
    @slot('IsModal', $IsModal ?? false )
    @slot('items_forms', $items_forms ?? '')
    @slot('item', $item ?? null)
    @slot('formData', 'formFullModal')
    @slot('user',$user ?? null)
    @slot('id',$id ?? null)
    @slot('denuncia_id',$denuncia_id ?? null)
@endcomponent
