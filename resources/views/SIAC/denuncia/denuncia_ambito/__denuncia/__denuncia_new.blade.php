<div class="grid-structure">
<div class=" row">
    <div class="col-lg-6 ">
        <div class="grid-container">
            <div class="form-row mb-1">
                <label for = "search_autocomplete_user" class="col-lg-12 col-form-label labelDenuncia">Busca el usuario que solicita el servicio: </label>
                <div class="col-lg-12">
                    <div class="input-group">
                        <input type="text" name="search_autocomplete_user" id="search_autocomplete_user" class="form-control" value="" placeholder="Buscar usuario...">
                        <span class="input-group-append">
                            <a href="{{route("newUser")}}" target="_blank" class="btn btn-icon btn-info"> <i class="mdi mdi-plus"></i></a>
                        </span>
                    </div>
{{--                    <div class="input-group btn-group-xs">--}}
{{--                        <input type="text" name="usuario" id="usuario" class="form-control" value="" readonly>--}}
{{--                        <span class="input-group-append">--}}
{{--                            <a  target="_blank" class="btn btn-xs btn-icon btn-primary editUser" id="editUser" disabled> <i class="mdi mdi-account-edit text-white"></i></a>--}}
{{--                        </span>--}}
{{--                        <span class="input-group-append">--}}
{{--                            <button type="button" class="btn btn-ico btn-secondary" id="btnRefreshButtonUser" disabled>--}}
{{--                                <i class="mdi mdi-reload"></i>--}}
{{--                            </button>--}}
{{--                        </span>--}}
{{--                    </div>--}}
                </div>
                <div class="col-lg-12 border-bottom">
                    <div class="input-group btn-group-sm mb-1 mt-1 ">
                        <span class="input-group-append float-left flex-fill">
                            <i class="mdi mdi-cellphone-iphone font-18 pl-1 pr-1"></i> <span class="pt-1" id="lblCelulares"></span>
                            <i class="mdi mdi-phone font-18 pl-1 pr-1"></i> <span class="pt-1" id="lblTelefonos"></span>
                            <i class="mdi mdi-email font-18 pl-1 pr-1"></i> <span class="pt-1" id="lblEMails"></span>
                        </span>
                        <button type="button" class="btn btn-sm btn-orange float-right text-white  denunciaUserModalChange"  data-toggle="modal" data-placement="top" data-target="#denunciaUserModalChange" data-original-title="Actualizar datos del usuario"><i class="mdi mdi-refresh"></i></button>
                    </div>
                </div>
            </div>

{{--            <div class="form-row mb-1 " >--}}
{{--                <label class="col-lg-12 col-form-label labelDenuncia">Ubica la dirección del problema: </label>--}}
{{--                <div class="col-lg-8 mb-2">--}}
{{--                    <div class="custom-control custom-radio mb-2">--}}
{{--                        <input type="radio" id="radio1" name="pregunta1" class="custom-control-input pregunta1" value="0">--}}
{{--                        <label class="custom-control-label" for="radio1">La misma ubicación del usuario demandante</label>--}}
{{--                    </div>--}}
{{--                    <div class="custom-control custom-radio">--}}
{{--                        <input type="radio" id="radio2" name="pregunta1" class="custom-control-input pregunta1" value="1">--}}
{{--                        <label class="custom-control-label" for="radio2">Otra Ubicación</label>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="form-row panelUbiProblem pb-2" style="background-color: floralwhite">--}}
{{--                <label for = "search_autocomplete" class="col-lg-12 col-form-label">Buscar ubicación del Problema</label>--}}
{{--                <div class="col-lg-12">--}}
{{--                    <div class="input-group">--}}
{{--                        <input type="text" name="search_autocomplete" id="search_autocomplete" class="form-control search_autocomplete" value="" placeholder="Buscar ubicación...">--}}
{{--                        <span class="input-group-append">--}}
{{--                            <a href="{{route("newUbicacion")}}" target="_blank" class="btn btn-icon btn-info"> <i class="mdi mdi-plus"></i></a>--}}
{{--                        </span>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="form-row ">--}}
{{--                <input type="text" name="ubicacion" id="ubicacion" value="{{ old('ubicacion') }}" class="form-control" disabled/>--}}
{{--            </div>--}}
{{--            <hr>--}}

            <div class="form-row mb-1 ">
                <label for = "searchGoogle" class="col-sm-2 col-form-label text-right">Ubicación: </label>
                <div class="col-sm-10">
                    <div class="input-group">
                    <input type="text" name="searchGoogle" id="searchGoogle" class="form-control" value="{{ old('searchGoogle') }}" placeholder="escriba aquí la colonia" >
                    <button type="button" class="btn btn-sm btn-primary float-right" id="searchGoogleBtn">
                        <i class="mdi mdi-magnify"></i>
                    </button>
                    </div>
                </div>
            </div>
            <div class="form-row mb-1">
                <label for = "searchGoogleResult" class="col-lg-2 col-form-label text-right"> </label>
                <div class="col-lg-10">
                    <small class="text-success font-medium text-center p-0 m-0" id="searchGoogleResult"></small>
                    <small class="text-danger font-medium text-center p-0 m-0" id="searchGoogleError"></small>
                </div>
            </div>
            <div class="form-row mb-1 ">
                <label for = "latitud" class="col-lg-2 col-form-label text-right">Latitud: </label>
                <div class="col-lg-4">
                    <input type="text" name="latitud" id="latitud" class="form-control latitud" value="" placeholder="17.9983821" >
                </div>
                <label for = "longitud" class="col-lg-2 col-form-label text-right">Longitud: </label>
                <div class="col-lg-4">
                    <input type="text" name="longitud" id="longitud" class="form-control longitud" value="" placeholder="-92.944787" >
                </div>
            </div>
            <hr>
            <div class="form-group row mb-1 mt-2">
                <div class="col-lg-12 ">
                    <div id="map" class="hidden"></div>
                </div>
            </div>
            <hr>
        </div>
    </div>

    <div class="col-lg-6 ">
        <div class="grid-container">
            <div class="form-group row mb-1">
                <label for = "origen_id" class="col-lg-2 col-form-label labelDenuncia text-right m-0 p-0">Fuente: </label>
                <div class="col-lg-10">
                    <select id="origen_id" name="origen_id" class="form-control" size="1" value="{{ old('origen_id') }}">
                        <option value="0"  >Seleccione una fuente</option>
                        @foreach($origenes as $t)
                            <option value="{{$t->id}}" {{ $t->isDefault() ? 'selected': '' }} >{{ $t->origen }} </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row mb-1">
                <label for = "servicio_id" class="col-lg-2 col-form-label labelDenuncia text-right m-0 p-0">Servicio: </label>
                <div class="col-lg-10">
                    <select id="servicio_id" name="servicio_id" class="form-control" size="1" value="{{ old('servicio_') }}">
                        <option value="0" >Seleccione un servicio</option>
                        @foreach($servicios as $t)
                            <option value="{{$t->id}}" >{{ $t->servicio.' ('.$t->abreviatura_dependencia.')'  }} </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row mb-1">
                <label for = "descripcion" class="col-lg-2 col-form-label has-descripcion labelDenuncia text-right m-0 p-0">Descripción:</label>
                <div class="col-lg-10">
                    <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion') }}</textarea>
                    <span class="has-descripcion">
                        <strong class="text-danger"></strong>
                    </span>
                </div>
            </div>
            <div class="form-group row mb-1">
                <label for = "referencia" class="col-lg-2 col-form-label has-referencia labelDenuncia text-right m-0 p-0">Referencia:</label>
                <div class="col-lg-10">
                    <textarea name="referencia" id="referencia" class="form-control">{{ old('referencia') }}</textarea>
                    <span class="has-descripcion">
                        <strong class="text-danger"></strong>
                    </span>
                </div>
            </div>

            <div class="form-group row mb-3 mt-3">
                <label for="file1" class="col-lg-2 col-form-label labelDenuncia text-right m-0 p-0">Archivo:</label>
                <div class="col-lg-10">
                    <input type="file" id="file1" name="file1" class="form-control-file">
                </div>
            </div>
            <div class="form-group row mb-1">
                <div class="col-lg-3"></div>
                <div class="col-lg-9">
                    <a href="#" class="btn btn-block btn-danger-primary w-50 text-center text-white searchIdentical"><i class="fas fa-search"></i> Buscar coincidencias  </a>
                </div>
            </div>
            <div class="form-group row mb-1">
                <div class="col-lg-12">
                    <table class="table-1 table-centered p-0 ">
                        <thead class="p-0">
                        <tr>
                            <th>Demandas similares</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody id="tblBody">
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
</div>

<input type="hidden" name="id" value="0" >
<input type="hidden" name="ubicacion_id" id="ubicacion_id" value="{{ old('ubicacion_id') }}" >
<input type="hidden" name="creadopor_id" id="creadopor_id" value="{{ old('creadopor_id', $user->id ?? 0) }}" >
<input type="hidden" name="modificadopor_id" id="modificadopor_id" value="{{ old('modificadopor_id', $user->id ?? 0) }}" >
<input type="hidden" name="usuario_id" id="usuario_id" value="{{ old('usuario_id') }}" >
<input type="hidden" name="isFechaIngresoView" id="isFechaIngresoView" value="{{ config('atemun.modificar_fecha_ingreso') }}" >
<input type="hidden" name="usuario_telefonos" id="usuario_telefonos" class="form-control" value="{{ old('usuario_telefonos') }}" >

{{--<input type="hidden" name="g_calle" id="g_calle" value="{{ old('g_calle',$items->g_calle) }}" >--}}
{{--<input type="hidden" name="g_num_ext" id="g_num_ext" value="{{ old('g_num_ext',$items->g_num_ext) }}" >--}}
{{--<input type="hidden" name="g_num_int" id="g_num_int" value="{{ old('g_num_int',$items->g_num_int) }}" >--}}
{{--<input type="hidden" name="g_colonia" id="g_colonia" value="{{ old('g_colonia',$items->g_colonia) }}" >--}}
{{--<input type="hidden" name="g_comunidad" id="g_comunidad" value="{{ old('g_comunidad',$items->g_comunidad) }}" >--}}
{{--<input type="hidden" name="g_municipio" id="g_municipio" value="{{ old('g_municipio',$items->g_municipio) }}" >--}}
{{--<input type="hidden" name="g_estado" id="g_estado" value="{{ old('g_estado',$items->g_estado) }}" >--}}
{{--<input type="hidden" name="g_cp" id="g_cp" value="{{ old('g_cp',$items->g_cp) }}" >--}}
{{--<input type="hidden" name="altitud" id="altitud" value="{{ old('altitud') }}" >--}}
{{--<input type="hidden" name="g_ubicacion" id="g_ubicacion" value="{{ old('g_ubicacion') }}" >--}}

<input type="hidden" name="altitud" id="altitud" value="{{ old('altitud') }}" >
<input type="hidden" name="gd_ubicacion" id="gd_ubicacion" value="{{ old('gd_ubicacion') }}" >

@include('shared/code/__modal_denuncia_user_data')
