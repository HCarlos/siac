@isset($item)
    @if ($item->id == 0)
        @if($item->cerrado==false )
            @canany(['all','guardar_expediente','guardar_expediente'])
                <button type="submit" class="btn btn-lg btn-rounded btn-primary float-right btnGuardarDenuncia">
                    <i class="fas fa-check-circle"></i> Guardar
                </button>
            @endcanany
        @endif
     @else
        @if($item->cerrado==false )
            @canany(['all','modificar_expediente','guardar_expediente'])
                <button type="submit" class="btn btn-lg btn-rounded btn-primary float-right btnGuardarDenuncia">
                    <i class="fas fa-check-circle"></i> Guardar
                </button>
            @endcanany
        @endif
    @endif
@else

    @canany(['all','guardar_expediente','guardar_respuesta','guardar_expediente'])
        <button type="submit" class="btn btn-lg btn-rounded btn-primary float-right btnGuardarDenuncia">
            <i class="fas fa-check-circle"></i> Guardar
        </button>
    @endcanany

@endisset
