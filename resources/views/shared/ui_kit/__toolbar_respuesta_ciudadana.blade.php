
<div class="button-list mt-md-2">
    @isset($newItem)
        <span data-toggle="modal" data-target="#modalFull" >
            <a href="{{route($newItem,['denuncia_id'=>$denuncia_id]) }}" id="{{$newItem}}" class="btn btn-icon btn-outline-light btn-rounded  btnFullModal" data-toggle="tooltip" data-placement="top" title="" data-original-title="Nuev@" >
                <i class="fas fa-plus"></i>
            </a>
        </span>
    @endisset

    <a class="btn btn-icon btn-outline-danger btn-rounded float-right" data-toggle="tooltip" data-placement="top" data-original-title="Cerrar" onclick="window.close();">
        <i class="fas fa-times text-white"></i>
    </a>

    <a class="btn btn-icon btn-outline-success btn-rounded float-right" data-toggle="tooltip" data-placement="top" data-original-title="Actualizar" onclick="window.location.reload(true);">
        <i class="fas fa-sync-alt text-white"></i>
    </a>

</div>
