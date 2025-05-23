<div class="grid-structure">
<div class=" row">
    <div class="col-lg-6 ">
        <div class="grid-container">
            <div class="form-row mb-1">
                <label for = "search_autocomplete_user" class="col-lg-12 col-form-label labelDenuncia">Busca el usuario que solicita el servicio: </label>
                <div class="col-lg-12">
                    <div class="input-group">
                        <small data-toggle="tooltip" class="text-rojo-morena"
                               title="Escribe el nombre completo del ciudadano. Asegúrate que aparezca en el menú desplegable con su CURP, en caso de no estar en el menú, puedes agregarlo en el icono de (+) revisa que cuente con número de teléfono, si no cuenta con teléfono de contacto, lo puedes agregar en el icono color naranja."
                        >
                            <i class="fa fa-question-circle pl-1 pr-1 pt-2"></i>
                        </small>
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

            <table class="table w-100-percent">

                <tr class="w-100-percent p-0 m-0 border-none">
                    <td class="w-15-percent p-0 m-0 text-right">
                        <label for = "search_google" class="col-form-label text-right ">Calle y núm.: </label>
                    </td>
                    <td class="w-5-percent p-0 m-0 text-center" >
                        <small data-toggle="tooltip" class="text-rojo-morena mr-1 w-100-percent" title="Coloca aquí el nombre correcto de la calle, avenida, carretera… con su número. Asegúrate que salga el menú desplegable, de lo contrario recarga la página.">
                            <i class="fa fa-question-circle pt-2"></i>
                        </small>
                    </td>
                    <td class="w-80-percent p-0 m-0">
                        <input type="text" name="search_google" id="search_google" class="form-control w-100-percent" value="{{ old('search_google') }}" placeholder="Escriba la calle y el número" >
                        <ul id="autocomplete-results"></ul>
                        <small class="muted w-100-percent chikirimbita chikirimbita_1"></small>
                    </td>
                </tr>

                <tr  class="p-0 m-0">
                    <td class="w-15-percent p-0 m-0 text-left">
                        <label for = "centro_localidad_id" class="col-form-label text-right w-100-percent">Localidad: </label>
                    </td>
                    <td class="w-5-percent p-0 m-0 text-center">
                        <small data-toggle="tooltip" class="text-rojo-morena mr-1 w-100-percent" title="Selecciona la colonia y la delegación, asegúrate que salga el menú desplegable, de lo contrario recarga la página.">
                            <i class="fa fa-question-circle pt-2"></i>
                        </small>
                    </td>
                    <td class="w-80-percent p-0 m-0">
                        <select id="centro_localidad_id" name="centro_localidad_id" class="form-control centro_localidad_id select2 w-100-percent" data-toggle="select2" size="1" value="{{ old('centro_localidad_id') }}">
                            <option value="0"  >Seleccione una Localidad</option>
                            @foreach($localidades_centro as $t)
                                <option value="{{$t->id}}" >{{ $t->ItemColoniaDelegacion() }} </option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr  class="p-0 m-0">
                    <td class="w-15-percent p-0 m-0 text-left">
                        <label for = "codigo_postal_manual" class="col-form-label text-right w-100-percent">Código Postal: </label>
                    </td>
                    <td class="w-5-percent p-0 m-0 text-center">
                        <small data-toggle="tooltip" class="text-rojo-morena mr-1 w-100-percent" title="Escribe el código postal que le corresponda o el sugerido por google.">
                            <i class="fa fa-question-circle pt-2"></i>
                        </small>
                    </td>
                    <td class="w-80-percent p-0 m-0">
                        <input type="text" name="codigo_postal_manual" id="codigo_postal_manual" class="form-control w-100-percent" value="{{ old('codigo_postal_manual') }}" placeholder="Escriba el Código Postal" >
                    </td>
                </tr>
            </table>



        </div>

        <div class="grid-container rounded-lg-1em p-2 mt-2">

            <div class="form-row">
                <label for = "search_google" class="col-sm-2 col-form-label text-right"> </label>
                <div class="col-lg-10">
                    <button type="button" class="btn btn-sm btn-primary float-right w-100-percent" id="searchGoogleBtn">
                        <i class="mdi mdi-magnify"></i> Buscar Calle y Número, y Localidad
                    </button>
                </div>
            </div>

            <div class="form-row mb-1 mt-1 ">
                <label for = "searchGoogleResult" class="col-lg-2 col-form-label text-right"> </label>
                <div class="col-lg-10">
                    <small class="text-success font-medium text-center p-0 m-0" id="searchGoogleResult"></small>
                    <small class="text-danger font-medium text-center p-0 m-0" id="searchGoogleError"></small>
                </div>
{{--                <div class="cargando" id="cargando">Buscando dirección...</div>--}}
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
            <div class="form-group row mb-1 mt-2">
                <div class="col-lg-12 ">
{{--                    <div id="map" class="hidden"></div>--}}
                    <div id="map-container">
                        <div id="map" class="hidden"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 ">
        <div class="grid-container">
            <div class="form-group row mb-1">
                <label for = "origen_id" class="col-lg-2 col-form-label labelDenuncia text-right m-0 p-0">Fuente: </label>
                <div class="col-lg-5">
                    <select id="origen_id" name="origen_id" class="form-control" size="1" value="{{ old('origen_id') }}">
                        <option value="0"  >Seleccione una fuente</option>
                        @foreach($origenes as $t)
                            <option value="{{$t->id}}" {{ $t->isDefault() ? 'selected': '' }} >{{ $t->origen }} </option>
                        @endforeach
                    </select>
                </div>
                <label for = "prioridad_id" class="col-lg-2 col-form-label labelDenuncia text-right m-0 p-0">Prioridad: </label>
                <div class="col-lg-3">
                    <select id="prioridad_id" name="prioridad_id" class="form-control" size="1" >
                        @foreach($prioridades as $t)
                            <option value="{{$t->id}}" {{ $t->isDefault() ? 'selected': '' }} >{{ $t->prioridad }} </option>
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
                <label for = "descripcion" class="col-lg-2 col-form-label has-descripcion labelDenuncia text-right m-0 p-0">Descripción y/o referencia:</label>
                <div class="input-group col-lg-10">
                    <small data-toggle="tooltip" class="text-rojo-morena"
                          title="Agregar dirección completa (calle, avenida, carretera con número). Y agregar datos que ayuden a nuestras cuadrillas a localizar el problema reportado, como referencias, tipo de vialidad, si hay una tiendita, color de casa, entre qué calles, si hay un árbol, etc…"
                    >
                        <i class="fa fa-question-circle pl-1 pr-1 pt-1"></i>
                    </small>
                    <textarea name="descripcion" id="descripcion" class="form-control" rows="6">{{ old('descripcion') }}</textarea>
                    <span class="has-descripcion">
                        <strong class="text-danger"></strong>
                    </span>
                </div>
            </div>
            <div class="form-group row mb-3 mt-3">
                <label for="file1" class="col-lg-2 col-form-label labelDenuncia text-right m-0 p-0">Archivo 1:</label>
                <div class="col-lg-10">
                    <input type="file" id="file1" name="file1" class="form-control-file">
                </div>
            </div>
            <div class="form-group row mb-3 mt-3">
                <label for="file2" class="col-lg-2 col-form-label labelDenuncia text-right m-0 p-0">Archivo 2:</label>
                <div class="col-lg-10">
                    <input type="file" id="file2" name="file2" class="form-control-file">
                </div>
            </div>
            <div class="form-group row mb-3 mt-3">
                <label for="file3" class="col-lg-2 col-form-label labelDenuncia text-right m-0 p-0">Archivo 3:</label>
                <div class="col-lg-10">
                    <input type="file" id="file3" name="file3" class="form-control-file">
                </div>
            </div>
            <div class="form-group row mb-1">
                <div class="col-lg-3"></div>
                <div class="col-lg-9">
                    <a href="#" class="btn btn-block btn-danger-primary text-center btn-rounded shadow text-white searchIdenticalAmbito"><i class="fas fa-search"></i> Buscar coincidencias  </a>
                </div>
            </div>
            <div class="form-group row mb-1">
                <div class="col-lg-12">
                    <table class="table table-bordered table-striped dt-responsive dataTable p-0 " role="grid">
                            <thead class="p-0">
                                <tr role="row">
                                    <th>Demandas similares</th>
                                    <th>Acción</th>
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
<input type="hidden" name="search_google_select" id="search_google_select" value="{{ old('search_google_select') }}" >

<input type="hidden" name="referencia" id="referencia" value="...." >
<input type="hidden" name="ambito_dependencia" id="ambito_dependencia" value="{{ old('ambito_dependencia',$ambito_dependencia) }}" >
<input type="hidden" name="ambito_estatus" id="ambito_estatus" value="{{ old('ambito_estatus',$ambito_estatus) }}" >
<input type="hidden" name="centro_localidad" id="centro_localidad" value="" >
@include('shared/code/__modal_denuncia_user_data')
