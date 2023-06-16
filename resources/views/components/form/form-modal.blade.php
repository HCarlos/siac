<form method="{{$Method}}" action="{{ route($Route) }}"  accept-charset="UTF-8" @if($IsUpload) enctype="multipart/form-data" class="formData" @endif id="{{$formData ?? 'formData'}}" >
    @csrf
    @if( !$IsNew )
        {{ method_field('PUT') }}
    @endif
    <div class="modal-header modal-colored-header bg-info">
        <h4 class="modal-title" id="modalHeaderFull">{{$Titulo}}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    </div>
    <div class="modal-body">
        @include('shared.code.__errors_modal')
        @include( $items_forms )
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary float-left">
            <i class="fas fa-check-circle"></i> Guardar
        </button>
        <button type="button" class="btn btn-danger float-right" data-dismiss="modal">
            <i class="fas fa-times-circle"></i> Cerrar
        </button>
    </div>
</form>
@include('shared.code.__ajax_form_full_modal_with_errors')
