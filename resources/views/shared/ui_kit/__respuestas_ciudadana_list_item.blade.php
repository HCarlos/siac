@if (Gate::check('all'))
    <a href="{{route($respuestasDenunciaCiudadanaItem,['Id'=>$item->id])}}"
       class="action-icon text-center icon_chat_interno" @isset($newWindow) target="_blank" @endisset
       data-toggle="tooltip" title="Chats"
    >
        @include('.shared.svgs.__chat')
    </a>
@endif
