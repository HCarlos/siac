<a href="{{route($showEditDenunciaDependenciaServicio,['Id'=>$item->id])}}"
   class="action-icon text-center icon_tres_puntitos_interno" @isset($newWindow) target="_blank" @endisset
   data-toggle="tooltip" title="Cambiar estatus"
>
{{--    <i class="fas fa-dice-three text-default-lighter"></i>--}}
    @include('.shared.svgs.__edicion_cargo')

</a>
