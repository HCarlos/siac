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

            <div class="form-row mb-1 ">
                <label for = "search_google" class="col-sm-2 col-form-label text-right">Ubicación: </label>
                <div class="col-sm-10">
                    <div class="input-group">
                    <input type="text" name="search_google" id="search_google" class="form-control" value="{{ old('search_google') }}" placeholder="escriba aquí la colonia" >
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
        <hr>
        <div class="form-group row mb-1">
            <div class="col-lg-12">
                @include('shared.ui_kit.__button_form_denuncia_ambito')
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

<input type="hidden" name="altitud" id="altitud" value="{{ old('altitud') }}" >
<input type="hidden" name="gd_ubicacion" id="gd_ubicacion" value="{{ old('gd_ubicacion') }}" >

@include('shared/code/__modal_denuncia_user_data')
