@php $IsModal = $IsModal ?? false  @endphp
@php $IsModalEdit = $IsModalEdit ?? false @endphp
@if( $IsModal || $IsModalEdit )
    <a href="{{route($showEdit,['Id'=>$item->id])}}"  id="{{ $showEdit.'/'.$item->id }}"
       class="action-icon text-center btnFullModal" @isset($newWindow)     @endisset
       data-toggle="modal"
       data-target="#modalFull"
       title="Editar"
    >
        <i class="fas fa-edit text-primary"></i>
    </a>
@else
    <a href="{{route($showEdit,['Id'=>$item->id])}}"
       class="action-icon text-center" @isset($newWindow)     @endisset
       data-toggle="tooltip" title="Editar"
    >
        <i class="fas fa-edit text-primary"></i>
    </a>
@endisset
