<div class="row">
    <div class="col-lg-12">
        <ul class="media-list">
            @foreach($items as $item)
                @if(count($item->childs))
                    @include('shared.code.__hoja_tree_image_one',['items'=>$item,"isborder"=>true])
                    @include('shared.code.__hoja_tree_image',['items'=>$item->childs])
                @else
                    @include('shared.code.__hoja_tree_image_one',['items'=>$item])
                @endif
            @endforeach
        </ul>
    </div>
</div>


