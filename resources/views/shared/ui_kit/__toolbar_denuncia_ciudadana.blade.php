
<div class="button-list mt-md-2">
    @isset($newItem)
        <a href="{{route($newItem)}}"  @isset($newWindow) @endisset class="btn btn-outline-light btn-rounded btn-sm ml-3" data-toggle="tooltip" data-placement="top" data-original-title="Nueva Solicitud">
            <i class="fas fa-plus"></i>
        </a>
    @endisset

        <a href="" class="btn btn-icon btn-outline-info btn-rounded float-right" data-toggle="tooltip" data-placement="top" data-original-title="Actualizar" onclick="window.location.reload(true);">
            <i class="fas fa-sync-alt text-white"></i>
        </a>

</div>
