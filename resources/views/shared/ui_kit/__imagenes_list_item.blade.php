<a href="{{route($imagenesDenunciaItem,['Id'=>$item->id])}}"
   class="action-icon text-center" @isset($newWindow)target="_blank" @endisset
   data-toggle="tooltip" title="Listado de Imágenes"
    >
    @if ($item->imagenes->count() > 0)
        <i class="fas fa-camera-retro text-warning-reload"></i>
    @else
        <i class="fas fa-camera-retro text-warning"></i>
    @endif
</a>
