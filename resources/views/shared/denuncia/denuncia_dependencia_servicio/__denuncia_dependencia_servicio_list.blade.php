<table  id="tblCat" class="table table-bordered table-striped dt-responsive dataTable " role="grid" aria-describedby="datatable-buttons_info" style="width: 100%; position: relative; z-index:0;" width="100%">
    <thead>
    <tr role="row">
        <th class="sorting_asc" aria-sort="ascending" aria-label="Name: activate to sort column descending">ID</th>
        <th class="sorting" >DEPENDENCIA</th>
        <th class="sorting">SERVICIO</th>
        <th class="sorting">ESTATUS</th>
        <th class="sorting">FECHA</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    @foreach($items as $item)
        <tr>
        <td class="table-user">{{$item->id}}</td>
            <td>{{$item->dependencia->dependencia}}</td>
                <td class="w-75">{{$item->servicio->servicio}}</td>
                    <td>{{$item->estatu->estatus}}</td>
                    <td>{{$item->fecha_movimiento}}</td>
                    <td class="table-action  w-25">
                        <div class="button-list">
                            @include('shared.ui_kit.__edit_item')
                            @include('shared.ui_kit.__remove_item')
        {{--                    @include('shared.ui_kit.__respuestas_list_item')--}}
        {{--                    @include('shared.ui_kit.__imagenes_list_item')--}}
        {{--                    @include('shared.ui_kit.__print_denuncia_item')--}}
                        </div>
                    </td>
        </tr>
    @endforeach

    </tbody>
</table>
