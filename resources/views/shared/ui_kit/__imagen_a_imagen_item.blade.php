{{--<span data-toggle="tooltip" title="Responder" >--}}

{{--    <a--}}
{{--        href="{{route($new2Item,['denuncia_id'=>$denuncia_id,'imagen_id'=>$item->id]) }}"--}}
{{--        id="{{$new2Item}}"--}}
{{--        class="action-icon text-center btnFullModal"--}}
{{--        data-toggle="modal"--}}
{{--        data-target="#modalFull"--}}
{{--        data-placement="top"--}}
{{--        title="Responder"--}}
{{--        data-original-title="Responder" >--}}
{{--        <i class="fas fa-comment-dots"></i>--}}
{{--    </a>--}}

    <a
        href="{{route($new2Item,['denuncia_id'=>$denuncia_id,'imagen_id'=>$item->id]) }}"
        id="{{$new2Item}}" @isset($new2Item) target="_blank" @endisset
        class="action-icon text-center"
        data-toggle="tooltip" data-placement="top" title="" data-original-title="Responder" >
        <i class="fas fa-comment-dots"></i>
    </a>

{{--</span>--}}

