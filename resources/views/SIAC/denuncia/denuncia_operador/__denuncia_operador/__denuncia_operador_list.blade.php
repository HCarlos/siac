<div class="row" style="width: 100% !important;">
        <div class="col-lg-6">
            <div class="card card-primary">
                <div class="card-body">
                    <div class="form-row mb-1">
                        <div class="input-group mb-1">
                            <label for = "operador_id" class="col-form-label font-weight-bold text-rojo-morena">Operador : </label>
                            <select id="operador_id" name="operador_id" class="form-control ml-1" size="1">
                                <option value="0" selected >Seleccione un Operador</option>
                                @foreach($operadores as $id => $valor)
                                    <option value="{{ $id }}">{{ $valor }}</option>
                                @endforeach
                            </select>
{{--                            <button type="button" class="btn btn-info btn-rounded ml-1" id="btnSearchDenuncia"><i class="mdi mdi-magnify"></i></button>--}}
                        </div>
                    </div>

                    <table  border="1" cellpadding="5" cellspacing="0" class="w-100-percent">
                        <tbody>
                        <!-- Aquí irían los datos dinámicamente -->
                        <tr>
                            <th>ROL</th>
                            <td id="user_roles" class="w-100-percent"></td>
                        </tr>
                        <tr>
                            <th>PERMISOS</th>
                            <td id="user_permissions"></td>
                        </tr>
                        <tr>
                            <th>UNIDAD</th>
                            <td id="user_unidades"></td>
                        </tr>
                        <tr>
                            <th>CURP</th>
                            <td id="user_curp"></td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="w-100-percent mt-2" >
                        <button type="button"  class="btn btn-info btn-rounded-sm w-40-percent text-white float-left" id="btnGetSolicitudesOperator"><i class="mdi mdi-content-copy"></i> Solicitudes de Este Operador</button>
                        <button type="button" class="btn btn-primary btn-rounded-sm w-40-percent float-right" id="btnSaveSolicitud"><i class="mdi mdi-content-save"></i> Agregar Operador a Solicitud</button>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-primary">
                <div class="card-body">

                    <div class="form-row mb-1">
                        <form  class="w-100-percent" autocomplete="on" >
                        <div class="input-group mb-1">
                            <label for = "denuncia_id" class="col-form-label  font-weight-bold text-rojo-morena text-right ml-1">Solicitud Id : </label>
                            <input type="text" name="denuncia_id" id="denuncia_id" value="{{old('denuncia_id')}}" class="form-control ml-1" autocomplete="on" />
                            <button type="button" class="btn btn-info btn-rounded ml-1" id="btnSolicitudId"><i class="mdi mdi-magnify"></i></button>
                        </div>
                        </form>
                    </div>

                    <table  border="1" cellpadding="5" cellspacing="0" class="w-100-percent">
                        <tbody>
                        <!-- Aquí irían los datos dinámicamente -->
                        <tr>
                            <th>SOLICITUD<br><strong class="text-success" id="lblSolicitudId"></strong></th>
                            <td id="solicitud" class="w-100-percent"></td>
                        </tr>
                        <tr>
                            <th>SERVICIO</th>
                            <td id="sue"></td>
                        </tr>
                        <tr>
                            <th>UBICACIÓN</th>
                            <td id="ubicacion"></td>
                        </tr>
                        <tr>
                            <th>CIUDADANO</th>
                            <td id="ciudadano"></td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="w-100-percent mt-2" >
                        <button type="button"  class="btn btn-info btn-rounded-sm w-40-percent text-white float-left" id="btnGetSolicitudOperator"><i class="mdi mdi-paper-cut-vertical "></i> Buscar Solicitud</button>
                    </div>

                </div>
            </div>
        </div>
</div>

<table  id="tblCat" class="table table-bordered table-striped dt-responsive dataTable " role="grid" aria-describedby="datatable-buttons_info" >
    <thead>
    <tr role="row">
        <th class="sorting_asc  w-10-percent" aria-sort="ascending" aria-label="Name: activate to sort column descending">FOLIO</th>
        <th class="sorting  w-20-percent">OPERADOR</th>
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
            <td>{{$item->denuncia->id}}</td>
            <td>{{$item->operador->full_name}}</td>
            <td>{{$item->denuncia->ciudadano->full_name}}</td>
            <td>{{$item->denuncia->servicio->servicio}}<br><br>{{$item->denuncia->descripcion}}</td>
            <td>{{$item->denuncia->ultimo_estatus }}</td>
            <td>{{\Carbon\Carbon::parse($item->denuncia->fecha_ingreso)->format('d-m-Y H:i')}}</td>
            <td>{{ $item->comentario}}</td>
            <td>
{{--                    @if(Gate::check('all') || Gate::check('editar_respuesta'))--}}
{{--                        @include('shared.ui_kit.__edit_item')--}}
{{--                    @endif--}}
                    @if(Gate::check('all') || Gate::check('eliminar_respuesta'))
                        @include('shared.ui_kit.__remove_item_operador_solicitud')
                    @endif
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
