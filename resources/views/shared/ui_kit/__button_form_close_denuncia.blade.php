@if( \Illuminate\Support\Facades\Auth::user()->isRole('Administrator|SysOp|USER_OPERATOR_ADMIN|ENLACE') && ( $item->cerrado==false )  && ( $item->firmado==false ) )
    @can('cerrar_expediente')
        <a class="btn btn-danger text-white float-left mr-2  operDenuncia" id="CERRAR.cerrarDenuncia/{{$item->id}}" >
            <i class="fas fa-times-circle"></i> Cerrar Solicitud
        </a>
    @endcan
@endif

@if( \Illuminate\Support\Facades\Auth::user()->isRole('Administrator|SysOp|USER_OPERATOR_ADMIN|USER_ARCHIVO_ADMIN') && ( $item->cerrado==true )  && ( $item->firmado==false ) )
    <a class="btn btn-orange text-white float-left mr-2  operDenuncia" id="FIRMAR.firmarDenuncia/{{$item->id}}" >
        <i class="fas fa-times-circle"></i> Firmar Solicitud
    </a>
@endif
