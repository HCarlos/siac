@isset($showEditBecas)
    @if( $item->hasRole('ALUMNO') )
        <a href="#" id="{{$showEditBecas.'/'.$item->id}}" class="action-icon text-center btnFullModal" data-toggle="modal" data-target="#modalFull"><i class="fas fa-hand-holding-usd"></i></a>
    @endif
@endisset
