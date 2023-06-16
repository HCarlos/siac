@include('shared.code.__errors')
<form method="{{$Method}}" action="{{ route($Route) }}"  accept-charset="UTF-8" @if($IsUpload) enctype="multipart/form-data" class="formData" @endif id="{{$formData ?? 'formData'}}" >
    @csrf
    @if( !$IsNew )
        {{ method_field('PUT') }}
    @endif
    @include( $items_forms )
    <div class="modal-footer">
        <button type="submit" class="btn btn-info">Guardar</button>
    </div>
</form>
@include('shared.code.__ajax_form_full_modal_with_errors')

