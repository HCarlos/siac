@isset($items)
    @if ($items->id == 0)
        @if($items->cerrado==false )
            @canany(['all','guardar_expediente'])
                <span class="preloader text-secondary hide "><i class="fas fa-stroopwafel text-danger fa-spin"></i> <i class="infoPreloader"></i></span>
                <button type="submit" class="btn btn-lg btn-rounded btn-primary float-right shadow btnGuardarDenuncia">
                    <i class="fas fa-check-circle"></i> Guardar solicitud
                </button>
            @endcanany
        @endif
     @else
        @if($items->cerrado==false )
            @canany(['all','modificar_expediente'])
                <span class="preloader text-secondary hide "><i class="fas fa-stroopwafel text-danger fa-spin"></i> <i class="infoPreloader"></i></span>
                <button type="submit" class="btn btn-lg btn-rounded btn-primary float-right shadow btnGuardarDenuncia">
                    <i class="fas fa-check-circle"></i> Guardar solicitud
                </button>
            @endcanany
        @endif
    @endif
@else
    @canany(['all','guardar_expediente'])
        <span class="preloader text-secondary hide "><i class="fas fa-stroopwafel text-danger fa-spin"></i> <i class="infoPreloader"></i></span>
        <button type="submit" class="btn btn-lg btn-rounded btn-primary float-right shadow btnGuardarDenuncia">
            <i class="fas fa-check-circle"></i> Guardar solicitud
        </button>
    @endcanany
@endisset

