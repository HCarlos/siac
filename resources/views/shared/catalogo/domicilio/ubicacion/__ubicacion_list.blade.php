<div id="datatable-buttons_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer" >
    <div class="row">
        <div class="col-sm-12">
            <table  id="tblCat" class="table table-bordered table-striped dt-responsive wrap dataTable " role="grid" aria-describedby="datatable-buttons_info" >
                <thead>
                    <tr role="row">
                        <th class="sorting_asc" style="width: 50px !important;" aria-sort="ascending" >ID</th>
                        <th class="sorting" >Ubicación</th>
                        <th style="width: 100px !important;"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td class="table-user">{{$item->id}}</td>
                        <td style="width: 70% !important;">{{$item->calle.' '.$item->num_ext.' '.$item->num_int.' '.$item->colonia.' '.$item->localidad.' '.$item->ciudad.' '.$item->municipio.' '.$item->estado.' '.$item->pais.' '.$item->cp}}</td>
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
