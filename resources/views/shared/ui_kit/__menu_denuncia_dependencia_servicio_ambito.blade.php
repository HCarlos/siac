<div class="row bg-dark-lighten rounded ">
    @if( $items->total() > 15 )
        <div class="col-md-6 mb-0" >
            @include('shared.ui_kit.__toolbar_denuncia_dependencia_servicio_ambito')
        </div>
        <div class="col-md-6 ">
            <div class="mt-md-2">
                {{ $items->onEachSide(1)->links() }}
            </div>
        </div>
    @else
        <div class="col-md-12 mb-0" >
            @include('shared.ui_kit.__toolbar_denuncia_dependencia_servicio_ambito')
        </div>
    @endif
</div>
