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



{{--<table  id="tblCat" class="table table-bordered table-striped dt-responsive dataTable " role="grid" aria-describedby="datatable-buttons_info" style="width: 100%; position: relative; z-index:0;" width="100%">--}}
{{--    <thead>--}}
{{--    <tr role="row">--}}
{{--        <th class="sorting_asc" aria-sort="ascending" aria-label="Name: activate to sort column descending">--}}
{{--            <div class="custom-control custom-checkbox">--}}
{{--                <input name="lblcheckbox"--}}
{{--                       id="lblcheckbox"--}}
{{--                       type="checkbox"--}}
{{--                       class="custom-control-input header-checkbox">--}}
{{--                <label class="custom-control-label" for="lblcheckbox">ID</label>--}}
{{--            </div>--}}

{{--        </th>--}}
{{--        <th class="sorting" >FOLIO</th>--}}
{{--        <th class="sorting">IMAGE</th>--}}
{{--        <th class="sorting">MOMENTO</th>--}}
{{--        <th class="sorting">CIUDADANO</th>--}}
{{--        <th class="sorting">FECHA</th>--}}
{{--        <th class="table-action tbl100W"></th>--}}
{{--    </tr>--}}
{{--    </thead>--}}
{{--    <tbody>--}}

{{--    @foreach($items as $item)--}}
{{--            <tr>--}}
{{--                <td class="table-user">--}}
{{--                    <div class="custom-control custom-checkbox">--}}
{{--                        <input name="file-select"--}}
{{--                               type="checkbox"--}}
{{--                               class="custom-control-input image-chk"--}}
{{--                               id="image_{{ $item->id }}"--}}
{{--                               value="{{ $item->id }}">--}}
{{--                        <label class="custom-control-label" for="image_{{ $item->id }}">{{ $item->id}}</label>--}}
{{--                    </div>--}}
{{--                </td>--}}
{{--                <td class="table-user">--}}
{{--                    <a href="{{route($showEdit,['Id'=>$item->denuncia->id])}}" class="action-icon text-center" @isset($newWindow) target="_blank" @endisset>--}}
{{--                        {{ $item->denuncia->id }}--}}
{{--                    </a>--}}
{{--                </td>--}}
{{--                <td>--}}
{{--                    <span class="action-buttons">--}}
{{--                        <a href="{{asset($item->PathImage)}}" target="_blank" >--}}
{{--                            <img src="{{asset($item->PathImageThumb)}}" width="40" height="40" >--}}
{{--                        </a>--}}
{{--                    </span>--}}
{{--                    <span class="w-75 ellipsis-span"> {{$item->titulo}} </span>--}}
{{--                </td>--}}
{{--                <td>{{$item->momento}}</td>--}}
{{--                <td>{{$item->user->FullName}}</td>--}}
{{--                <td>{{($item->fecha)}}</td>--}}
{{--                <td class="table-action tbl100W">--}}
{{--                    <div class="button-list action-buttons">--}}
{{--                        @include('shared.ui_kit.__edit_item_modal')--}}
{{--                        @include('shared.ui_kit.__remove_items_select')--}}
{{--                    </div>--}}
{{--                </td>--}}
{{--            </tr>--}}
{{--    @endforeach--}}

{{--    </tbody>--}}
{{--</table>--}}
