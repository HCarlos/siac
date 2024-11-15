<div id="datatable-buttons_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer" style="position: relative; z-index: 0">
    <div class="row">
        <div class="col-sm-12">
            <table  id="tblCat" class="table table-bordered table-striped dt-responsive nowrap dataTable " role="grid" aria-describedby="datatable-buttons_info" width="100%">
                <thead>
                    <tr role="row">
                        <th class="sorting_asc w-10" aria-sort="ascending" aria-label="Name: activate to sort column descending">ID</th>
                        <th class="sorting w-50" >Unidad</th>
                        <th class="sorting w-10" >Abreviatura</th>
                        <th class="sorting w-10" >Jefe</th>
                        <th style="width: 100vw"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td class="table-user">{{$item->id}}</td>
                        <td>{{$item->dependencia}}</td>
                        <td>{{$item->abreviatura}} {{$item->estatus_cve}}</td>
                        <td>{{ $item->jefe->FullName }}</td>
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
