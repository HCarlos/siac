<div id="datatable-buttons_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer" style="position: relative; z-index: 0">
    <div class="row">
        <div class="col-sm-12">
            <table  id="tblCat" class="table table-bordered table-striped dataTable " role="grid" aria-describedby="datatable-buttons_info" style="width: 100%; position: relative; z-index:0;" width="100%">
                <thead>
                    <tr role="row">
                        <th class="sorting_asc " aria-sort="ascending" aria-label="Name: activate to sort column descending">ID</th>
                        <th class="sorting w-25">Subrea</th>
                        <th class="sorting w-25">Área</th>
                        <th class="sorting w-25">Dependencia</th>
                        <th class="sorting w-15">Jefe</th>
                        <th class="w-25"></th>
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
                        <td class="table-action w-100">
                            <div class="button-list">
                                @include('shared.ui_kit.__edit_item')
                                @include('shared.ui_kit.__remove_item')
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
