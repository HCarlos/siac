{{--@if(Auth::user()->getAuthIdentifier() == $user->id)--}}

@if (Auth::user()->hasAnyPermission(['all', 'eliminar']) )


{{--@can('eliminar')--}}
<a href="#"
       class="action-icon text-center removeItemListTwo"
       id="{{$removeItem.'-'.$items->id.'-'.$item->id}}"
       data-toggle="tooltip" title="Quitar Registro"
    >
        <i class="fas fa-trash-alt text-danger"></i>
    </a>
{{--@endcan--}}

@endif

    {{--@endif--}}
