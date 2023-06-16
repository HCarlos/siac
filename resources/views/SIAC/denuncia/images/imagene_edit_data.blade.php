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
    @slot('titulo_full_modal',"Datos de la imagen".$item->id)
    @slot('body_full_modal')
        @include('shared.denuncia.images.__imagene_edit_data')
    @endslot
    @slot('removeItem', 'removeImagene')

@endcomponent

