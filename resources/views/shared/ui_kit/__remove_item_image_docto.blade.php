@if (Auth::user()->hasAnyPermission(['all', 'eliminar_imagen/documento', 'test_admin']) )

{{--@can('eliminar')--}}
@if(Auth::user()->getAuthIdentifier() == $user->id)
<a href="#"
   class="action-icon text-center text-danger removeItemList"
   id="{{$removeItem.'-'.$item->id}}"
   data-toggle="tooltip"
   title="Eliminar permanentemente este objeto."
    >
{{--    <i class="fas fa-trash-alt text-danger"></i>--}}
    @include('.shared.svgs.__eliminar')
</a>
@endif
{{--@endcan--}}
@endif
