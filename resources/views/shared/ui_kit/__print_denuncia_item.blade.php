<a href="{{route($item->firmado == true ? 'imprimir_denuncia_archivo' . '/' : 'imprimir_denuncia_respuesta' . '/', ['uuid'=>$item->uuid])}}"
   class="action-icon text-center" @isset($newWindow) target="_blank" @endisset
    data-toggle="tooltip" title="Ver Solicitud en PDF"
    >
    <i class="fas fa-file-pdf text-cafe"></i>
</a>
