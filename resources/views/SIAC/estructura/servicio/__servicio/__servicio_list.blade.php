
<div id="datatable-buttons_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer" style="position: relative; z-index: 0">
    <div class="row">
        <div class="col-sm-12">
            <table  id="tblCat" class="table table-bordered table-striped dt-responsive nowrap w-100 ">
                <thead>
                    <tr role="row">
                        <th class="sorting_asc w-5-percent" aria-sort="ascending" aria-label="Name: activate to sort column descending">ID</th>
                        <th class="sorting w-40-percent">Servicio</th>
                        <th class="sorting w-8-percent">Es Mobile</th>
                        <th class="sorting w-10-percent">Mobile</th>
                        <th class="sorting w-12-percent">Es Servicio</th>
                        <th class="sorting w-10-percent">Servicio</th>
{{--                        <th class="sorting w-5-percent">Subarea</th>--}}
                        <th class="w-14-percent"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td style="width: 5% !important;">{{$item->id}}</td>
                        <td style="width: 45% !important;">{{$item->servicio}}</td>
                        <td style="width: 1% !important;" class="text-center">
                            @if( (int) $item->is_visible_mobile == 1 )
                                <i class="fa fa-check text-success "></i>
                            @endif
                        </td>
                        <td style="width: 1% !important;">
                            @if( (int) $item->is_visible_mobile == 1 )
                                {{$item->nombre_mobile}}
                            @endif
                        </td>
                        <td style="width: 1% !important;" class="text-center">
                            @if( (int) $item->is_visible_nombre_corto_ss == 1 )
                                <i class="fa fa-check text-success "></i>
                            @endif
                        </td>
                        <td style="width: 1% !important;">
                            @if( (int) $item->is_visible_nombre_corto_ss == 1 )
                                {{$item->nombre_corto_ss}}
                            @endif
                        </td>
{{--                        <td style="width: 34% !important; overflow: hidden !important;"><div class="w-50">{{ $item->subarea.' - '.$item->area.' - '.$item->dependencia.' - '.$item->abreviatura_dependencia }}</div></td>--}}
                        <td class="table-action nowrap" >
{{--                            @if( (int) $item->is_visible_mobile == 0 )--}}
                                <div class="button-list nowrap">
                                    @include('shared.ui_kit.__edit_item')
                                    @include('shared.ui_kit.__remove_item')
                                </div>
{{--                            @endif--}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
