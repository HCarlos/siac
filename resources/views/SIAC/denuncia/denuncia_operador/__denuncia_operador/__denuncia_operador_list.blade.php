<div class="row" style="width: 100% !important;">
        <div class="col-lg-6">
            <div class="card card-primary">
                <div class="card-header">
                    Hola
                </div>
                <div class="card-body">
                    <div class="form-row mb-1">
                        <label for = "operador_id" class="col-md-2 col-form-label">Operador Por:</label>
                        <div class="col-md-4">
                            <select id="operador_id" name="operador_id" class="form-control" size="1">
                                <option value="0" selected >Seleccione un Usuario</option>
{{--                                @foreach($capturistas as $id => $valor)--}}
{{--                                    <option value="{{ $id }}">{{ $valor }}</option>--}}
{{--                                @endforeach--}}
                            </select>
                        </div>
                        <label for = "id" class="col-md-1 col-form-label text-right">ID </label>
                        <div class="col-md-5">
                            <input type="text" name="id" id="id" value="{{ old('id') }}" class="form-control" />
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-primary">
                <div class="card-header">
                    Mundo
                </div>
                <div class="card-body">
                </div>
            </div>
        </div>
</div>

<table  id="tblCat" class="table table-bordered table-striped dt-responsive dataTable " role="grid" aria-describedby="datatable-buttons_info" >
    <thead>
    <tr role="row">
        <th class="sorting_asc  w-10-percent" aria-sort="ascending" aria-label="Name: activate to sort column descending">FOLIO</th>
        <th class="sorting  w-20-percent">USUARIO</th>
        <th class="sorting  w-30-percent">SOLICITUD</th>
        <th class="sorting  w-15-percent">ULTIMO ESTATUS</th>
        <th class="sorting  w-10-percent">FECHA</th>
        <th class="sorting  w-10-percent">COMENTARIO</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    @foreach($items as $item)
        <tr>
            <td>{{$item->id}}</td>
            <td>{{$item->operador->full_name}}</td>
            <td>{{$item->denuncia->servicio.', '.$item->denuncia->denuncia}}</td>
            <td>{{$item->denuncia->ultimo_estatus }}</td>
            <td>{{$item->fecha}}</td>
            <td>{{$item->comentario}}</td>
            <td>
                    @if(Gate::check('all') || Gate::check('editar_respuesta'))
                        @include('shared.ui_kit.__edit_item')
                    @endif
                    @if(Gate::check('all') || Gate::check('eliminar_respuesta'))
                        @include('shared.ui_kit.__remove_item_respuesta')
                    @endif
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
