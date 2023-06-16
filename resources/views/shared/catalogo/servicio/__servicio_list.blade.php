
<div id="datatable-buttons_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer" style="position: relative; z-index: 0">
    <div class="row">
        <div class="col-sm-12">
            <table  id="tblCat" class="table table-bordered table-striped dataTable " role="grid" aria-describedby="datatable-buttons_info" style="width: 100%; position: relative; z-index:0;" width="100%">
                <thead>
                    <tr role="row">
                        <th class="sorting_asc" aria-sort="ascending" aria-label="Name: activate to sort column descending">ID</th>
                        <th class="sorting" >Servicio</th>
                        <th class="sorting" >Subarea</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td style="width: 5% !important;">{{$item->id}}</td>
                        <td style="width: 45% !important;">{{$item->servicio}}</td>
                        <td style="width: 35% !important;"><div class="w-50">{{ $item->subarea->subarea.' - '.$item->subarea->area->area.' - '.$item->subarea->area->dependencia->dependencia }}</div></td>
                        <td class="table-action" style="width: 15% !important;">
                            <div class="button-list ">
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
