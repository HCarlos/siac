
<div class="button-list mt-md-2">
    @isset($newItem)
        <a href="{{route($newItem,['denuncia_id'=>$denuncia_id]) }}" id="{{$newItem}}" @isset($newWindow) target="_blank" @endisset class="btn btn-icon btn-outline-white btn-rounded  " data-toggle="tooltip" data-placement="top" title="" data-original-title="Nuev@" >
            <i class="fas fa-plus"></i>
        </a>

    @endisset

    <a href="#" class="btn btn-icon btn-outline-white btn-rounded float-right" data-toggle="tooltip" data-placement="top" data-original-title="Cerrar" onclick="window.close();">
        <i class="fas fa-times"></i>
    </a>

    <a href="#" class="btn btn-icon btn-outline-white btn-rounded float-right" data-toggle="tooltip" data-placement="top" data-original-title="Actualizar" onclick="window.location.reload(true);">
        <i class="fas fa-sync-alt"></i>
    </a>

</div>
