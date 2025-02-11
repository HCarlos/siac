@if (Auth::user()->hasAnyPermission(['all', 'modificar_expediente_apoyos_sociales', 'test_admin']) )
    <a href="{{route($showEditDenunciaDependenciaServicio,['Id'=>$item->id])}}"
       class="action-icon text-center icon_tres_puntitos_interno" @isset($newWindow) target="_blank" @endisset
       data-toggle="tooltip" title="Cambiar estatus"
    >
        @include('.shared.svgs.__edicion_cargo')
    </a>
@endif
