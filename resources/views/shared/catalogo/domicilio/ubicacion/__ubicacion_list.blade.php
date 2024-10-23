<div id="datatable-buttons_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer" >
    <div class="row">
        <div class="col-sm-12">
            <table id="tblCat" class="table table-condensed table-bordered table-striped wrap dataTable " style="width: 100% !important">
                <thead>
                    <tr role="row">
                        <th class="sorting_asc"  aria-sort="ascending" >ID</th>
                        <th class="sorting" >Ubicación</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody >
                @foreach($items as $item)
                    <tr role="row">
                        <td style="width: 10% !important;">{{$item->id}}</td>
                        <td style="width: 70% !important;">{{$item->calle.' '.$item->num_ext.' '.$item->num_int.' '.$item->colonia.' '.$item->localidad.' '.$item->ciudad.' '.$item->municipio.' '.$item->estado.' '.$item->pais.' '.$item->cp}}</td>
                        <td class="table-action " style="width: 20% !important;">
                            <div class="button-list w-100">
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
