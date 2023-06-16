@if (Auth::user()->hasAnyPermission(['all', 'eliminar']) )

{{--@can('eliminar')--}}
<a
    href="#"
    class="action-icon text-center removeItemList"
    id="{{$removeItem.'-'.$item->pivot->id}}"
    data-toggle="tooltip" title="Quitar Registro"
    >
    <i class="fas fa-trash-alt text-danger"></i>
</a>
{{--@endcan--}}

@if (Auth::user()->hasAnyPermission(['all', 'eliminar']) )
