<span data-toggle="tooltip" title="Responder" >
    <a
        href="{{route($new2Item,['denuncia_id'=>$denuncia_id,'respuesta_id'=>$item->id]) }}"
        id="{{$new2Item}}"
        class="action-icon text-center icon_chat_interno btnFullModal"
        data-toggle="modal"
        data-target="#modalFull"
        data-placement="top"
        title="Responder"
        data-original-title="Responder" >
        @include('.shared.svgs.__chat')

    </a>
</span>

