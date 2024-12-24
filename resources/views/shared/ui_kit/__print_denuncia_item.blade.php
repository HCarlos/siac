<a href="{{route($item->firmado == true ? 'imprimir_denuncia_archivo' . '/' : 'imprimir_denuncia_respuesta' . '/', ['uuid'=>$item->uuid])}}"
   class="action-icon text-center icon_pdf_interno" @isset($newWindow) target="_blank" @endisset
    data-toggle="tooltip" title="Solicitud en PDF"
    >
    @include('.shared.svgs.__pdf')
</a>
