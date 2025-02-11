@if (Auth::user()->hasAnyPermission(['all', 'eliminar_expediente_servicios_municipales', 'test_admin']) )
    @if(Auth::user()->getAuthIdentifier() == $user->id)
        <a href="#"
           class="action-icon text-center removeItemList "
           id="{{$removeItem.'-'.$item->id}}"
           data-toggle="tooltip"
           title="Eliminar permanentemente este objeto."
            >
            @include('.shared.svgs.__eliminar')
        </a>
    @endif
@endif
