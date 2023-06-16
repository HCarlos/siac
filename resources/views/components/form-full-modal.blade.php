@include('shared.code.__errors')
<form method="{{$metodo}}" action="{{ route($action) }}" id="formFullModal">
    {{$_csrf}}
    <div class="modal-header modal-colored-header bg-info">
        <h4 class="modal-title" id="modalHeaderFull">{{$titulo_full_modal}}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    </div>
    <div class="modal-body">
        {{$body_full_modal}}
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-info">Guardar</button>
    </div>
</form>
@include('shared.code.__ajax_form_full_modal_with_errors')

