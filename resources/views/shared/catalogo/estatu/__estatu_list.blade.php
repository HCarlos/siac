<div id="datatable-buttons_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer" style="position: relative; z-index: 0">
    <div class="row">
        <div class="col-sm-12">
            <table  id="tblCat" class="table table-bordered table-striped dt-responsive nowrap dataTable " role="grid" aria-describedby="datatable-buttons_info" style="width: 100%; position: relative; z-index:0;" width="100%">
                <thead>
                    <tr role="row">
                        <th class="sorting_asc" aria-sort="ascending" aria-label="Name: activate to sort column descending">ID</th>
                        <th class="sorting" >Status</th>
                        <th class="sorting" >Dependencia</th>
                        <th class="sorting" >Predeterminado</th>
                        <th style="width: 100vw"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td class="table-user">{{$item->id}}</td>
                        <td>{{$item->estatus}}</td>
                        <td class="w-30vh">
                            @foreach($item->dependencias as $dep)
                            <b class="badge badge-warning"> {{$dep->dependencia}} </b><br>
                            @endforeach
                        </td>
                        <td class="text-center">
                            @if ($item->isDefault()) <i class="fas fa-check-circle text-primary fa-2x"></i> @endif
                        </td>
                        <td class="table-action w-100">
                            <div class="button-list">
                                @if( strtoupper(trim($item->estatus)) != 'CERRADO' )
                                    @include('shared.ui_kit.__edit_item')
                                    @include('shared.ui_kit.__remove_item')
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
