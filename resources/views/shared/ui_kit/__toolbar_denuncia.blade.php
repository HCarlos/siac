<div class="button-list pt-2 pb-0">
    @isset($newItem)
{{--        @php dd(\Illuminate\Support\Facades\Auth::user()->isPermission('csd_sas|consultar|all')) @endphp--}}
        @if( \Illuminate\Support\Facades\Auth::user()->isPermission('crear_expediente|all') )
            <a href="{{route($newItem)}}" class="btn btn-outline-white btn-rounded btn-sm ml-1" data-toggle="tooltip" data-placement="top" data-original-title="Nueva Solicitud">
                <i class="fas fa-plus"></i>
            </a>
        @endif
    @endisset
    @isset($showProcess1)
{{--        <a href="{{ route($showProcess1)}}" class="btn btn-icon btn-outline-success ml-1 btn-rounded btnGetItems" data-toggle="tooltip" data-placement="top" data-original-title="Exportar a MS Excel">--}}
{{--            <i class="fas fa-file-excel text-white"></i>--}}
{{--        </a>--}}
            <button type="button" class="btn btn-icon btn-outline-white ml-1 btn-rounded dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-file-excel"></i>
            </button>
            <div class="dropdown-menu">
                @php $indice = -1 @endphp
                @foreach(config("atemun.menu_archivos") as $key=>$value )
                    <a class="dropdown-item btnGetItems" href="{{ route($showProcess1)}}-{{$value}}-{{++$indice}}">{{$key}}</a>
                @endforeach
            </div>

    @endisset
    @isset($showModalSearchDenuncia)
        <span data-toggle="modal" data-target="#modalFull" >
            <a href="{{route($showModalSearchDenuncia)}}" id="{{$showModalSearchDenuncia}}" class="btn btn-icon btn-outline-white ml-1 btn-rounded  btnFullModal" data-toggle="tooltip" data-placement="top" title="" data-original-title="Búsqueda Avanzada">
                <i class="fas fa-search"></i>
            </a>
        </span>
    @endisset

        <a href="" class="btn btn-icon btn-outline-white ml-1 btn-rounded" data-toggle="tooltip" data-placement="top" data-original-title="Actualizar" onclick="window.location.reload(true);">
            <i class="fas fa-sync-alt"></i>
        </a>

</div>

