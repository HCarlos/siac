
<div class="button-list mt-md-2">
    @isset($newItem)
        <a href="{{route($newItem,['Id'=>$Id])}}"  @isset($newWindow) @endisset class="btn btn-outline-light btn-rounded btn-sm ml-3" data-toggle="tooltip" data-placement="top" data-original-title="Agregar dependencia / respuesta a Solicitud">
            <i class="fas fa-plus"></i>
        </a>
    @endisset
    @isset($showProcess1)
        <a href="{{ route($showProcess1)}} " @isset($newWindow)  @endisset class="btn btn-icon btn-outline-success btn-rounded btnGetItems" data-toggle="tooltip" data-placement="top" data-original-title="Exportar a XLSX">
            <i class="fas fa-file-excel text-white"></i>
        </a>
    @endisset
    @isset($imprimirDenunciaConRespuesta)
        <a href="{{route($imprimirDenunciaConRespuesta,['uuid' => $Denuncia->uuid])}}" @isset($newWindow)  @endisset class="btn btn-icon btn-outline-dark btn-rounded" data-toggle="tooltip" data-placement="top" data-original-title="Imprimir hoja de seguimiento">
            <i class="fas fa-print text-white"></i>
        </a>
    @endisset

    @isset($showModalSearchDenuncia)
        <span data-toggle="modal" data-target="#modalFull" >
            <a href="{{route($showModalSearchDenuncia)}}" id="{{$showModalSearchDenuncia}}" class="btn btn-icon btn-outline-light btn-rounded  btnFullModal" data-toggle="tooltip" data-placement="top" title="" data-original-title="Búsqueda Avanzada">
                <i class="fas fa-search"></i>
            </a>
        </span>
    @endisset

        <a href="" class="btn btn-icon btn-outline-info btn-rounded float-right" data-toggle="tooltip" data-placement="top" data-original-title="Actualizar" onclick="window.location.reload(true);">
            <i class="fas fa-sync-alt text-white"></i>
        </a>

</div>
