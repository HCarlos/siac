{{--@if(Gate::check('all'))--}}
@php $IsModal = $IsModal ?? false  @endphp
@php $IsModalEdit = $IsModalEdit ?? false @endphp
@if( $IsModal || $IsModalEdit )
    <a href="{{route($showEdit,['Id'=>$item->id])}}"  id="{{ $showAddUser.'/'.$item->id }}"
       class="action-icon text-center icon_usuarios_interno btnFullModal"
       data-toggle="modal"
       data-target="#modalFull"
       title="Ver/vincular solicitud"
    >
{{--        <i class="fas fa-users text-info"></i>--}}
        @include('.shared.svgs.__usuarios')

    </a>
@else
    <a href="{{route($showAddUser,['Id'=>$item->id])}}"
       class="action-icon text-center icon_usuarios_interno "
       data-toggle="tooltip"
       title="Ver/vincular solicitud"
    >
{{--        <i class="fas fa-users text-info"></i>--}}
        @include('.shared.svgs.__usuarios')

    </a>
@endisset
{{--@endif--}}
