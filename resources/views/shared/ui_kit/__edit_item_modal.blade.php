@if(Auth::user()->getAuthIdentifier() == $item->user__id)
<span data-toggle="tooltip" title="Editar" >
    <a
        href="{{route($editItem,['Id'=>$item->id])}}"
        id="{{$editItem}}"
        class="action-icon text-center btnFullModal"
        data-toggle="modal"
        data-target="#modalFull"
        data-placement="top"
        title="Editar"
        data-original-title="Editar" >
        <i class="fas fa-edit text-success"></i>
    </a>
</span>
@endif