
<div id="datatable-buttons_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer" style="position: relative; z-index: 0">
    <div class="row">
        <div class="col-sm-12">
            <table  id="tblCat" class="table table-bordered table-striped dt-responsive wrap dataTable w-100-percent" role="grid" aria-describedby="datatable-buttons_info">
                <thead>
                    <tr role="row">
                        <th class="sorting_asc w-5-percent" aria-sort="ascending" aria-label="Name: activate to sort column descending">ID</th>
                        <th class="sorting w-45-percent">Servicio</th>
                        <th class="sorting w-8-percent">Unidad</th>
                        <th class="sorting w-8-percent">Es Mobile</th>
                        <th class="sorting w-8-percent">Mobile</th>
                        <th class="sorting w-8-percent">Es Servicio</th>
                        <th class="sorting w-8-percent">Servicio</th>
                        <th class="sorting w-8-percent">Prom</th>
                        <th class="sorting w-8-percent">Habilitado</th>
                        <th class="w-10-percent"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->servicio}}</td>
                        <td>{{$item->abreviatura_dependencia}}</td>
                        <td class="text-center">
                            @if( (int) $item->is_visible_mobile == 1 )
                                <i class="fa fa-check text-success "></i>
                            @endif
                        </td>
                        <td>
                            @if( (int) $item->is_visible_mobile == 1 )
                                {{$item->nombre_mobile}}
                            @endif
                        </td>
                        <td class="text-center">
                            @if( (int) $item->is_visible_nombre_corto_ss == 1 )
                                <i class="fa fa-check text-success "></i>
                            @endif
                        </td>
                        <td>
                            @if( (int) $item->is_visible_nombre_corto_ss == 1 )
                                {{$item->nombre_corto_ss}}
                            @endif
                        </td>
                        <td>{{$item->promedio_dias_atendida}}</td>
                        <td class="text-center">
                            @if( (int) $item->habilitado == 1 )
                                <i class="fa fa-check text-success "></i>
                            @else
                                <i class="fa fa-times text-danger "></i>
                            @endif
                        </td>
                        <td class="table-action nowrap" >
{{--                            @if( (int) $item->is_visible_mobile == 0 )--}}
                                <div class="button-list nowrap">
                                    @include('shared.ui_kit.__edit_item')
                                    @include('shared.ui_kit.__remove_item_catalogos')
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
