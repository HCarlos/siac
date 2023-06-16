<table  id="tblCat" class="table table-bordered table-striped dt-responsive dataTable " role="grid" aria-describedby="datatable-buttons_info" style="width: 100%; position: relative; z-index:0;" width="100%">
    <thead>
    <tr role="row">
        <th class="sorting_asc" aria-sort="ascending" aria-label="Name: activate to sort column descending">ID</th>
        <th class="sorting" >Ciudadano</th>
        <th class="sorting">Fecha</th>
        <th class="sorting">Estatus</th>
        <th class="sorting ">Ubicación</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    @foreach($items as $item)
        <tr>
            <td class="table-user">{{$item->id}}</td>
            <td>{{$item->ciudadano->FullName}}</td>
            <td>{{($item->fecha_ingreso)}}</td>
            <td>{{($item->Estatu->estatus)}}</td>
            <td class="w-75">{{$item->fullUbication}}</td>
            <td class="table-action  w-25">
                <div class="button-list">
                    @include('shared.ui_kit.__respuestas_ciudadana_list_item')
                    @include('shared.ui_kit.__imagenes_list_item')
                    @include('shared.ui_kit.__print_denuncia_item')
{{--                    @include('shared.ui_kit.__edit_denuncia_dependencia_servicio_item')--}}
                </div>
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
