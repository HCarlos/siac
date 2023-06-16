<a href="{{route($respuestasDenunciaItem,['Id'=>$item->id])}}"
   class="action-icon text-center" @isset($newWindow) target="_blank" @endisset
   data-toggle="tooltip" title="Listado de Respuestas"
    >
    <i class="fas fa-comments text-primary"></i>
</a>
