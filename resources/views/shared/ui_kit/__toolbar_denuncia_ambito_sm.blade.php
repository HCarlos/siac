{{--<div class="button-list pt-2 pb-1 tbSM">--}}
<div class="pt-2 pb-1 tbSM">
    @isset($newItem)
        @if( \Illuminate\Support\Facades\Auth::user()->isPermission('crear_expediente_servicios_municipales|crear_expediente_apoyos_sociales|all') )
            <a href="{{url($newItem)}}" class="btn btn-outline-white btn-rounded btn-sm ml-1" data-toggle="tooltip" data-placement="top" data-original-title="Nueva Solicitud">
                <i class="fas fa-plus"></i> Nueva Solicitud
            </a>
        @endif
    @endisset
    @isset($showProcess1)
        <button type="button" class="btn btn-icon btn-outline-white ml-1 btn-rounded dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-file-excel"></i>
        </button>
        <div class="dropdown-menu">
            @php $indice = -1 @endphp
            @foreach(config("atemun.menu_archivos_sm") as $key=>$value )
                <a class="dropdown-item btnGetItems" href="{{ route($showProcess1)}}-{{$value}}-{{++$indice}}">{{$key}}</a>
            @endforeach
        </div>
    @endisset
    @isset($showModalSearchDenuncia)
        <span data-toggle="modal" data-target="#modalFull" >
            <a href="{{url($showModalSearchDenuncia)}}" id="{{$showModalSearchDenuncia}}" class="btn btn-icon btn-outline-white ml-1 btn-rounded  btnFullModal" data-toggle="tooltip" data-placement="top" title="" data-original-title="Búsqueda Avanzada">
                <i class="fas fa-search"></i>
            </a>
        </span>
    @endisset
</div>
