<a href="{{route($imagenesDenunciaItem,['Id'=>$item->id])}}"
   class="action-icon text-center @if ($item->imagenes->count() > 0) text-warning-reload @else text-warning @endif"
   @isset($newWindow)target="_blank" @endisset
   data-toggle="tooltip" title="Imágenes"
    >
    @include('.shared.svgs.__imagenes')

</a>
