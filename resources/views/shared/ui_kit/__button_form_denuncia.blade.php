@isset($item)
    @if ($item->id == 0)
        @if($item->cerrado==false )
            @can('guardar_expediente')
                <button type="submit" class="btn btn-lg btn-rounded btn-primary float-right btnGuardarDenuncia">
                    <i class="fas fa-check-circle"></i> Guardar
                </button>
            @endcan
        @endif
     @else
        @if($item->cerrado==false )
            @can('modificar_expediente')
                <button type="submit" class="btn btn-lg btn-rounded btn-primary float-right btnGuardarDenuncia">
                    <i class="fas fa-check-circle"></i> Guardar
                </button>
            @endcan
        @endif
    @endif
@else

    @canany(['all','guardar_expediente','guardar_respuesta'])
        <button type="submit" class="btn btn-lg btn-rounded btn-primary float-right btnGuardarDenuncia">
            <i class="fas fa-check-circle"></i> Guardar
        </button>
    @endcanany

@endisset
