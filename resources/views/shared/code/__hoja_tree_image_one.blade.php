<li class="media row p-2 @isset($isborder)  bg-item-treview-inside @else mb-2 mt-2 bg-item-treview-outside @endisset " >

    @if( $item->descripcion === "mobile" )
        <a class="pull-left pl-2"  href="{{asset($item->PathImageMobile)}}" target="_blank" >
            <img class="media-object" src="{{asset($item->PathImageMobileThumb)}}" width="64" height="64" >
        </a>
    @else
        <a class="pull-left pl-2"  href="{{asset($item->PathImage)}}" target="_blank" >
            <img class="media-object" src="{{asset($item->PathImageThumb)}}" width="64" height="64" >
        </a>
    @endif

    <div class="media-body pl-2 col-md-12">
        <h4 class="media-heading">{{$item->titulo}} <small>{{$item->fecha}}</small>
            <span class=" table-action button-list pl-2 ">
                @include('shared.ui_kit.__edit_item_modal')
                @include('shared.ui_kit.__remove_item_image_docto')
                @include('shared.ui_kit.__imagen_a_imagen_item')
            </span>
        </h4>
        <div class="media">
            <div class="col-md-12">
                    {{$item->descripcion}}<br>
                    <small>{{$item->momento}}</small>
            </div>
        </div>
    </div>
</li>
