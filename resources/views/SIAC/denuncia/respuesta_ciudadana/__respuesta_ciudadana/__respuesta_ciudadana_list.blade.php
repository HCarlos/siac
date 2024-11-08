<div class="col-lg-12">
    <ul class="media-list">
        @foreach($items as $item)
            @if(count($item->childs))
                @include('shared.code.__hoja_tree_view_one',['items'=>$item])
                @include('shared.code.__hoja_tree_view',['items'=>$item->childs])
            @else
                @include('shared.code.__hoja_tree_view_one',['items'=>$item])
            @endif
        @endforeach
    </ul>
</div>

