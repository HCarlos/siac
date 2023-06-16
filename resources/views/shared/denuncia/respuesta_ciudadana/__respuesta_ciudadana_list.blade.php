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



{{--<table  id="tblCat" class="table table-bordered table-striped dt-responsive dataTable " role="grid" aria-describedby="datatable-buttons_info" style="width: 100%; position: relative; z-index:0;" width="100%">--}}
{{--    <thead>--}}
{{--    <tr role="row">--}}
{{--        <th class="sorting_asc" aria-sort="ascending" aria-label="Name: activate to sort column descending">ID</th>--}}
{{--        <th class="sorting" >FOLIO</th>--}}
{{--        <th class="sorting">RESPUESTA</th>--}}
{{--        <th class="sorting">CIUDADANO</th>--}}
{{--        <th class="sorting">FECHA</th>--}}
{{--        <th class="table-action tbl100W"></th>--}}
{{--    </tr>--}}
{{--    </thead>--}}
{{--    <tbody>--}}

{{--    @foreach($items as $item)--}}
{{--            <tr>--}}
{{--                <td class="table-user">{{ $item->id }}</td>--}}
{{--                <td class="table-user">--}}
{{--                        {{ $item->denuncia->id }}--}}
{{--                </td>--}}
{{--                <td>{{($item->respuesta)}}<br/><small class="text-primary">{{$item->observaciones}}</small></td>--}}
{{--                <td>{{$item->user->FullName}}</td>--}}
{{--                <td>{{($item->fecha)}}</td>--}}
{{--                <td class="table-action tbl100W">--}}
{{--                    <div class="button-list">--}}
{{--                        @if( ($item->user->id === Auth::user()->id) || Auth::user()->isRole('Administrator|SysOp') )--}}
{{--                            @include('shared.ui_kit.__edit_item_modal')--}}
{{--                            @include('shared.ui_kit.__remove_item')--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </td>--}}
{{--            </tr>--}}
{{--    @endforeach--}}

{{--    </tbody>--}}
{{--</table>--}}
