<div id="datatable-buttons_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer" style="position: relative; z-index: 0">
    <div class="row">
        <div class="col-sm-12">
            <table  id="tblCat" class="table table-bordered table-striped dt-responsive dataTable w-100-percent " >
                <thead>
                    <tr role="row">
                        <th class="w-10-percent" aria-sort="ascending" aria-label="Name: activate to sort column descending">ID</th>
                        <th class="w-70-percent" >Categoría</th>
                        <th class="w-20-percent"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td class="table-user">{{$item->id}}</td>
                        <td>{{$item->categoria_servicios}}</td>
                        <td class="table-action w-100">
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
