<a href="{{route($showEditDenunciaDependenciaServicio,['Id'=>$item->id])}}"
   class="action-icon text-center" @isset($newWindow) target="_blank" @endisset
   data-toggle="tooltip" title="Cambiar estatus"
>
{{--    <i class="fas fa-igloo text-success"></i>--}}
    <i class="fas fa-dice-three text-default-lighter"></i>
</a>
