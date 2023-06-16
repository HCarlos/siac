@include('shared.code.__errors')
<form method="{{$metodo}}"
      action="{{ route($action) }}"
      class="dropzone dropzone-with-border"
      id="my-awesome-dropzone"
      data-plugin="dropzone"
      data-previews-container="#file-previews"
      data-upload-preview-template="#uploadPreviewTemplate">
{{$_csrf}}
    <div class="modal-header modal-colored-header bg-info">
        <h4 class="modal-title" id="modalHeaderFull">{{$titulo_dropzone}}</h4><br/><br/>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    </div>
    <div class="modal-body">
        {{ $body_full_modal }}
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger float-right" onclick="window.close()">
        <i class="fas fa-times-circle"></i> Cerrar
        </button>
    </div>
</form>
@include('shared.code.__ajax_form_dropzone')

