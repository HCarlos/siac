<table  id="tblCat" class="table table-bordered table-striped dt-responsive dataTable " role="grid" aria-describedby="datatable-buttons_info" style="width: 100%; position: relative; z-index:0;" width="100%">
    <thead>
    <tr role="row">
        <th class="sorting_asc" aria-sort="ascending" aria-label="Name: activate to sort column descending">ID</th>
        <th class="sorting">Ciudadano</th>
        <th class="sorting">Fecha</th>
        <th class="sorting">Área</th>
        <th class="sorting">Servicio</th>
        <th class="sorting ">Ubicación</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    @foreach($items as $item)
        <tr>
            <td class="table-user @if($item->origen_id == config('atemun.pagina_web_id')) text-danger @endif">{{$item->id}}</td>
            <td class="w-25">
                {{$item->ciudadano->FullName}} <br>
                <small>{{$item->ciudadano->curp}}</small>
            </td>
            <td  class="w-15">{{($item->fecha_ingreso)}}</td>
            <td><a title="{{($item->dependencia->dependencia)}}">{{($item->dependencia->abreviatura)}}</a></td>

            <td class="w-25">
                {{($item->servicio->servicio)}}<br>
                <small class="text-gray-lighter">{{( $item->ultimo_estatus )}}</small>
                @if( $item->TotalRespuestas>0 )
                    > <small class="text-danger"><strong> {{( $item->TotalRespuestas )}}</strong></small>
                @endif
            </td>

            <td class="w-25">{{$item->fullUbication}} @if($item->ciudadanos->count() > 1)<span class="text-danger">( <i class="fas fa-users"></i> <strong>  {{$item->ciudadanos->count()}} </strong> )</span> @endif
            </td>            <td class="table-action  w-25">
                <div class="button-list">
                    @include('shared.ui_kit.__respuestas_ciudadana_list_item')
                    @include('shared.ui_kit.__imagenes_list_item')
                    @include('shared.ui_kit.__print_denuncia_item')
                </div>
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
