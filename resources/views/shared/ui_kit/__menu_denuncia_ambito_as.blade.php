<div class="row bg-dark-lighten rounded ">
    @if( $items->count() > 15 )
        <div class="col-md-6 mb-0" >
            @include('shared.ui_kit.__toolbar_denuncia_ambito_as')
        </div>
        <div class="col-md-6 ">
            <div class="mt-md-2">
                @if ( $is_pagination )
                    {{ $items->onEachSide(1)->links() }}
                @endif
            </div>
        </div>
    @else
        <div class="col-md-12 mb-0" >
            @include('shared.ui_kit.__toolbar_denuncia_ambito_as')
        </div>
    @endif
</div>
