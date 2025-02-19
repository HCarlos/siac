@isset($item)
    @if ($item->id == 0)
        @if($item->cerrado==false )
            @canany(['all','guardar_expediente','guardar_expediente'])
                <span class="preloader text-secondary hide "><i class="fas fa-stroopwafel text-danger fa-spin"></i> <i class="infoPreloader"></i></span>
                <button type="submit" class="btn btn-lg btn-rounded btn-primary float-right shadow btnGuardarDenuncia">
                    <i class="fas fa-check-circle"></i> Guardar solicitud
                </button>
            @endcanany
        @endif
     @else
        @if($item->cerrado==false )
            @canany(['all','modificar_expediente','guardar_expediente'])
                <span class="preloader text-secondary hide "><i class="fas fa-stroopwafel text-danger fa-spin"></i> <i class="infoPreloader"></i></span>
                <button type="submit" class="btn btn-lg btn-rounded btn-primary float-right shadow btnGuardarDenuncia">
                    <i class="fas fa-check-circle"></i> Guardar solicitud
                </button>
            @endcanany
        @endif
    @endif
@else

    @canany(['all','guardar_expediente','guardar_respuesta','guardar_expediente'])
        <span class="preloader text-secondary hide "><i class="fas fa-stroopwafel text-danger fa-spin"></i> <i class="infoPreloader"></i></span>
        <button type="submit" class="btn btn-lg btn-rounded btn-primary float-right shadow btnGuardarDenuncia">
            <i class="fas fa-check-circle"></i> Guardar solicitud
        </button>
    @endcanany

@endisset
