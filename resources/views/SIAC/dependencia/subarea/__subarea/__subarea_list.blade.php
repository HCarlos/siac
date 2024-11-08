<div id="datatable-buttons_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer" style="position: relative; z-index: 0">
    <div class="row">
        <div class="col-sm-12">
            <table  id="tblCat" class=" table-bordered table-striped dt-responsive nowrap dataTable wrap">
                <thead>
                    <tr role="row">
                        <th class="sorting_asc w-5-percent" aria-sort="ascending" aria-label="Name: activate to sort column descending">ID</th>
                        <th class="sorting  w-25-percent">Subrea</th>
                        <th class="sorting  w-20-percent">Área</th>
                        <th class="sorting  w-20-percent">Dependencia</th>
                        <th class="sorting  w-20-percent">Jefe</th>
                        <th class="w-10-percent"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->subarea}}</td>
                        <td>{{trim($item->area->area)}}</td>
                        <td>{{trim($item->area->dependencia->dependencia)}}</td>
                        <td>{{trim($item->jefe->FullName) }}</td>
                        <td class="table-action w-100 nowrap">
                            <div class="button-list">
                                @include('shared.ui_kit.__edit_item')
                                @include('shared.ui_kit.__remove_item_catalogos')
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
