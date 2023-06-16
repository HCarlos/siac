@if (Auth::user()->hasAnyPermission(['all', 'eliminar_respuesta']) )

{{--@can('eliminar')--}}
@if(Auth::user()->getAuthIdentifier() == $user->id)
<a href="#"
   class="action-icon text-center removeItemList"
   id="{{$removeItem.'-'.$item->id}}"
   data-toggle="tooltip" title="Eliminar permanentemente esta solicitud"
    >
    <i class="fas fa-trash-alt text-danger"></i>
</a>
@endif
{{--@endcan--}}
@endif
