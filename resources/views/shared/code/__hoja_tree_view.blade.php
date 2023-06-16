
<ul class="media-list ">
    @foreach($items as $item)
        <li class="media row mb-2 mt-2 p-2  bg-item-treview-inside " >
            <a class="pull-left pl-2" href="#">
                <img class="media-object" src="{{ $item->user->PathImageThumbProfile }}?timestamp='{{ now() }}' " width="40" height="40" />
            </a>
            <div class=" pl-2 col-md-12">
                <h4 class="media-heading">{{$item->user->FullName}} <small>{{$item->fecha}}</small>
                    <span class=" table-action button-list pl-2 ">
                        @include('shared.ui_kit.__edit_item_modal')
                        @include('shared.ui_kit.__remove_item')
                        @include('shared.ui_kit.__respuesta_a_respuesta_item')
                    </span>
                </h4>
                <div class="row ">
                    <div>
                        <div class="col-md-12">
                                {{$item->respuesta}}<br>
                                <small>{{$item->observaciones}}</small>
                            @if(count($item->childs))
                                @include('shared.code.__hoja_tree_view',['items'=>$item->childs])
                            @endif
                        </div>
                        <div class="col-md-12"></div>
                    </div>
                </div>
            </div>
        </li>
    @endforeach
</ul>

