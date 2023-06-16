<div class="row" style="width: 100% !important;">
    <div class="col-lg-12">
        <div class="card card-primary">
            <div class="card-header">
                <h6>{{$Denuncia->Ciudadano->FullName}}  <small>{{ date('d-m-Y H:i:s', strtotime($Denuncia->fecha_ingreso)) }}</small></h6>
            </div>
            <div class="card-body">
                <p><strong>DESCRIPCIÓN:</strong></p>
                <p>{{$Denuncia->descripcion}}</p>
                <p><strong>REFERENCIA / OBSERVACIONES:</strong></p>
                <p>{{$Denuncia->referencia.'  '.$Denuncia->observaciones}}</p>
            </div>
        </div>
    </div>
</div>

<table  id="tblCat" class="table table-bordered table-striped dt-responsive dataTable " role="grid" aria-describedby="datatable-buttons_info" style="width: 100%; position: relative; z-index:0;" width="100%">
    <thead>
    <tr role="row">
        <th class="sorting_asc" aria-sort="ascending" aria-label="Name: activate to sort column descending">ID</th>
        <th class="sorting" >DEPENDENCIA</th>
        <th class="sorting">SERVICIO</th>
        <th class="sorting">RESPUESTA</th>
        <th class="sorting">ESTATUS</th>
        <th class="sorting">FAVORABLE</th>
        <th class="sorting">FECHA</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    @foreach($items as $item)
        <tr>
        <td class="table-user">{{$item->id}}</td>
            <td>{{$item->dependencia->dependencia}}</td>
                <td class="w-75">{{$item->servicio->servicio}}</td>
                    <td>{{$item->observaciones}}</td>
                    <td>{{$item->estatu->estatus}}</td>
                    <td class="text-center">@if($item->favorable==true)<i class="fas fa-check seagreen"></i> @else <i class="mdi mdi-close-box red mdi-18px"></i> @endif </td>
                    <td>{{$item->fecha_movimiento}}</td>
                    <td class="table-action  w-25">
                        <div class="button-list">
                            @if(Gate::check('all') || Gate::check('eliminar_respuesta'))
                                @include('shared.ui_kit.__edit_item')
                                @include('shared.ui_kit.__remove_item')
                            @endif

        {{--                    @include('shared.ui_kit.__respuestas_list_item')--}}
        {{--                    @include('shared.ui_kit.__imagenes_list_item')--}}
        {{--                    @include('shared.ui_kit.__print_denuncia_item')--}}

                        </div>
                    </td>
        </tr>
    @endforeach

    </tbody>
</table>
