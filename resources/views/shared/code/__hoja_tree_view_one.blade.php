<li class="media row p-2 @isset($isborder)  bg-item-treview-inside @else mb-2 mt-2 bg-item-treview-outside @endisset " >
    <a class="pull-left pl-2" href="#">
        <img class="media-object" src="{{ $item->user->PathImageThumbProfile }}?timestamp='{{ now() }}' " width="40" height="40" />
    </a>
    <div class="media-body pl-2 col-md-12">
        <h4 class="media-heading">{{$item->user->FullName}} <small>{{$item->fecha}}</small>
            <span class=" table-action button-list pl-2 ">
                @include('shared.ui_kit.__edit_item_modal')
                @include('shared.ui_kit.__remove_item')
                @include('shared.ui_kit.__respuesta_a_respuesta_item')
            </span>
        </h4>
        <div class="media">
            <div class="col-md-12">
                    {{$item->respuesta}}<br>
            </div>
        </div>
    </div>
</li>
