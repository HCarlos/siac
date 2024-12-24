<div class="button-list mt-md-2">

    @php $IsModal = $IsModal ?? false @endphp

    @php $IsModalNew = $IsModalNew ?? false @endphp

    @if( !$IsModal && !$IsModalNew )
        @isset($newItem)
            <a href="{{route($newItem)}}"  @isset($newWindow) @endisset class="btn btn-icon btn-rounded btn-outline-white"> <i class="fas fa-plus"></i> Nuevo</a>
        @endisset
    @else
        @isset($newItem)
            <a href="{{route($newItem)}}"  @isset($newWindow) @endisset id="{{route($newItem)}}" class="btn btn-icon btn-rounded btn-outline-white btnFullModal" data-toggle="modal" data-target="#modalFull"> <i class="fas fa-plus"></i> Nuevo</a>
        @endisset
    @endisset

    @isset($showProcess1)
        @if(\Illuminate\Support\Facades\Auth::user()->hasRole('Administrator|test_admin'))
            <a href="{{route($showProcess1)}}" @isset($newWindow)  @endisset class="btn btn-icon btn-rounded btn-outline-white btnFilters"> <i class="fas fa-file-excel"></i> Exportar a Excel</a>
        @endif
    @endisset

    @isset($exportModel)
        @if(\Illuminate\Support\Facades\Auth::user()->hasRole('Administrator|test_admin'))
            <a href="{{route('getModelListXlS',['model'=>$exportModel])}}" @isset($newWindow) @endisset class="btn btn-icon btn-rounded btn-outline-white btnFilters"> <i class="fas fa-file-excel"></i> Exportar Modelo a Excel</a>
        @endif
    @endisset
    <span data-toggle="modal" data-target="#modalFull" >
        <a href="{{route($showModalSearchServicio)}}" id="{{$showModalSearchServicio}}" class="btn btn-icon btn-outline-white ml-1 btn-rounded  btnFullModal" data-toggle="tooltip" data-placement="top" title="" data-original-title="Búsqueda Avanzada">
            <i class="fas fa-search"></i>
        </a>
    </span>
    <a href="{{route('listServicios')}}" class="btn btn-icon btn-outline-white ml-1 btn-rounded" data-toggle="tooltip" data-placement="top" data-original-title="Actualizar" >
        <i class="fas fa-sync-alt"></i>
    </a>

</div>
