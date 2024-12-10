@if (Gate::check('all'))
    <a href="{{route($respuestasDenunciaCiudadanaItem,['Id'=>$item->id])}}"
       class="action-icon text-center" @isset($newWindow) target="_blank" @endisset
       data-toggle="tooltip" title="Chats"
    >
        <i class="fas fa-comments text-success"></i>
    </a>
@endif
