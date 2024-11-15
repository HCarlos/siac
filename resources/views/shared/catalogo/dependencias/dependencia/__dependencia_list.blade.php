<div id="datatable-buttons_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer" style="position: relative; z-index: 0">
    <div class="row">
        <div class="col-sm-12">
            <table  id="tblCat" class="table table-bordered table-striped dt-responsive nowrap dataTable " role="grid" aria-describedby="datatable-buttons_info" width="100%">
                <thead>
                    <tr role="row">
                        <th class="sorting_asc w-10-percent" aria-sort="ascending" aria-label="Name: activate to sort column descending">ID</th>
                        <th class="sorting w-50-percent">Unidad</th>
                        <th class="sorting w-20-percent" >Abreviatura</th>
                        <th class="sorting w-20-percent" >Categoría</th>
                        <th class="sorting w-20-percent" >CSS</th>
                        <th class="w-20-percent"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td >{{$item->id}}</td>
                        <td>{{$item->dependencia}}</td>
                        <td>{{$item->abreviatura}}</td>
                        <td>{{$item->DependenciaAmbito}}</td>
                        <td style="background: {{$item->class_css}}">{{$item->class_css}}</td>
                        <td class="table-action ">
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
