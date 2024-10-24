<div id="datatable-buttons_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer" style="position: relative; z-index: 0">
    <div class="col-sm-12">
        <div class="row">
            <table  id="tblCat" class="table table-condensed table-striped table-bordered dt-responsive w-100-percent dataTable wrap ">
                <thead>
                    <tr role="row">
                        <th class="sorting_asc w-5-percent">ID</th>
                        <th class="sorting w-50-percent">Comunidad</th>
                        <th class="sorting w-20-percent">Delegado</th>
                        <th class="sorting w-10-percent">Tipocomunidad</th>
                        <th class="sorting w-5-percent">Unif.</th>
                        <th class="w-10-percent"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td class="table-user">{{$item->id}}</td>
                        <td>{{ $item->comunidad }}</td>
                        <td>{{ $item->delegado->FullName }}</td>
                        <td>{{ $item->tipoComunidad->tipocomunidad }}</td>
                        <td class="text-center">@if( $item->is_unificadora )<i class="fa fa-arrow-up text-success"></i>@endif</td>
                        <td class="table-action w-100 nowrap">
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
