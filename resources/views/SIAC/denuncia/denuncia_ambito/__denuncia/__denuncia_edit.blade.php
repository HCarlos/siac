<div class="grid-structure">
<div class=" row">
    <div class="col-lg-6 ">
        <div class="grid-container">
            <div class="form-row mb-1">
                <label for = "search_autocomplete_user" class="col-lg-12 col-form-label labelDenuncia">Busca el usuario que solicita el servicio:</label>
                <div class="col-lg-12">
                    <div class="input-group">
                        <input type="text" name="search_autocomplete_user" id="search_autocomplete_user" value="{{ $items->Ciudadano->FullName }}" placeholder="Buscar usuario..." class="form-control">
                        <span class="input-group-append">
                            <a href="{{route("newUser")}}" target="_blank" class="btn btn-icon btn-info"> <i class="mdi mdi-plus"></i></a>
                        </span>
                    </div>
                    <div class="input-group btn-group-xs">
                        <input type="text" name="usuario" id="usuario" value="{{ $items->Ciudadano->FullName }}" class="form-control" readonly>
                        <span class="input-group-append">
                            <a  href="{{route("editUser",['Id'=>$items->Ciudadano->id])}}" target="_blank" class="btn btn-xs btn-icon btn-primary editUser" id="editUser" > <i class="mdi mdi-account-edit text-white "></i></a>
                        </span>
                        <span class="input-group-append">
                            <button type="button" class="btn btn-ico btn-secondary" id="btnRefreshButtonUser" >
                                <i class="mdi mdi-refresh"></i>
                            </button>
                        </span>
                    </div>
                    <div class="input-group btn-group-xs mb-1 border-bottom">
                        <span class="input-group-append">
                            <i class="mdi mdi-cellphone-iphone font-18 pl-1 pr-1"></i> <span class="pt-1" id="lblCelulares">{{ $items->Ciudadano->celulares }}</span>
                            <i class="mdi mdi-phone font-18 pl-1 pr-1"></i> <span class="pt-1" id="lblTelefonos">{{ $items->Ciudadano->telefonos }}</span>
                            <i class="mdi mdi-email font-18 pl-1 pr-1"></i> <span class="pt-1" id="lblEMails">{{ $items->Ciudadano->emails }}</span>
                        </span>
                    </div>
                </div>
        </div>

            <div class="form-row mb-1 " >
                <label class="col-lg-12 col-form-label labelDenuncia">Ubica la dirección del problema: </label>
                <div class="col-lg-12 mb-2">
                    <select id="pregunta1" name="pregunta1" class="form-control pregunta1" size="1">
                        <option value="0" {{$pregunta1 === 0 ? 'selected': '' }} >La misma dirección del usuario demandante </option>
                        <option value="1" {{$pregunta1 === 1 ? 'selected': '' }} >Otra dirección </option>
                    </select>

                </div>
            </div>

            <div class="form-row panelUbiProblem pb-2" style="background-color: floralwhite">
                <label for = "search_autocomplete" class="col-lg-12 col-form-label">Buscar ubicación del Problema</label>
                <div class="col-lg-12">
                    <div class="input-group">
                        <input type="text" name="search_autocomplete" id="search_autocomplete" value="{{ $items->Ubicacion->Ubicacion }}" class="form-control" placeholder="Buscar ubicación...">
                        <span class="input-group-append">
                            <a href="{{route("newUbicacion")}}" target="_blank" class="btn btn-icon btn-info"> <i class="mdi mdi-plus"></i></a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-row pb-2">
                <input type="text" name="ubicacion" id="ubicacion" value="{{ old('ubicacion', $items->Ubicacion->id.' '.$items->Ubicacion->Ubicacion) }}" class="form-control" disabled/>
            </div>
            <hr>

            <div class="form-row mb-1 ">
                <label for = "latitud" class="col-lg-2 col-form-label text-right">Latitud: </label>
                <div class="col-lg-4">
                    <input type="text" name="latitud" id="latitud" class="form-control latitud" value="{{ old('latitud', $items->latitud) }}" placeholder="17.9983821" >
                </div>
                <label for = "longitud" class="col-lg-2 col-form-label text-right">Longitud: </label>
                <div class="col-lg-4">
                    <input type="text" name="longitud" id="longitud" class="form-control longitud" value="{{ old('longitud', $items->longitud) }}" placeholder="-92.944787" >
                </div>
            </div>
            <div class="form-row mb-1 ">
                <label for = "searchGoogle" class="col-lg-2 col-form-label text-right">Google: </label>
                <div class="col-lg-8">
                    <input type="text" name="searchGoogle" id="searchGoogle" class="form-control" value="{{ old('searchGoogle', $items->searchGoogle) }}" placeholder="escriba aquí la colonia" >
                    <small class="col-xs-12 text-danger" id="searchGoogleError"></small>
                </div>
                <div class="col-lg-2">
                    <button type="button" class="btn btn-sm btn-primary float-right" id="searchGoogleBtn">
                        <i class="mdi mdi-magnify"></i>
                    </button>
                </div>
            </div>
            <div class="form-row mb-1">
                <label for = "searchGoogle" class="col-lg-2 col-form-label text-right"> </label>
                <div class="col-lg-10">
                    <small class="text-default font-medium text-center p-0 m-0" id="searchGoogleResult">{{ $items->gd_ubicacion }}</small>
                </div>
            </div>
            <div class="form-group row mb-1">
                <div class="col-lg-12 ">
                    <div id="map" class="hidden"></div>
                </div>
            </div>
            <div class="form-group row mb-1">
                <label for = "referencia" class="col-lg-12 col-form-label labelDenuncia text-left">Referencia para una mejor ubicación:  </label>
                <div class="col-lg-12">
                    <textarea name="referencia" id="referencia" rows="5" class="form-control">{{ old('referencia', $items->referencia) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 ">

        <div class="grid-container">
            <div class="form-group row mb-1">
                <label for = "origen_id" class="col-lg-2 col-form-label labelDenuncia text-right m-0 p-0">Origen:</label>
                <div class="col-lg-10">
                    <select id="origen_id" name="origen_id" class="form-control" size="1">
                        @foreach($origenes as $t)
                            <option value="{{$t->id}}" {{ $t->id === $items->origen_id ? 'selected': '' }} >{{ $t->origen }} </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row mb-1">
                <label for = "servicio_id" class="col-lg-2 col-form-label labelDenuncia text-right m-0 p-0">Servicio:</label>
                <div class="col-lg-10">
                    <select id="servicio_id" name="servicio_id" class="form-control" size="1">
                        <option value="0" selected>Seleccione un Servicio</option>
                        @foreach($servicios as $t)
                            <option value="{{$t->id}}" {{ $t->id === $items->servicio_id ? 'selected': '' }} >{{ $t->id }} - {{ $t->servicio.' ('.$t->abreviatura_dependencia.')' }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row mb-1">
                <label for = "descripcion" class="col-lg-2 col-form-label has-descripcion labelDenuncia text-right m-0 p-0">Descripción:</label>
                <div class="col-lg-10">
                    <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion',$items->descripcion) }}</textarea>
                    <span class="has-descripcion">
                        <strong class="text-danger"></strong>
                    </span>
                </div>
            </div>


            <div class="form-group row mb-3 mt-3">
                <div class="col-lg-3"></div>
                <div class="table-responsive-sm col-lg-9">
                    <table class="table-1 table-centered mb-0 col-lg-12">
                        <thead class="overflow-hidden pr-2" >
                        <tr>
                            <th>Imegen</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items->imagenes as $item)
                            <tr>
                                @if( $item->descripcion === "mobile" )
                                    <td>
                                        <a class="pull-left pl-2"  href="{{asset($item->PathImageMobile)}}" target="_blank" >
                                            <img class="media-object" src="{{asset($item->PathImageMobileThumb)}}" width="64" height="64" alt="" >
                                        </a>
                                    </td>
                                @else
                                    <td>
                                        <a class="pull-left pl-2"  href="{{asset($item->PathImage)}}" target="_blank" >
                                            <img class="media-object" src="{{asset($item->PathImageThumb)}}" width="64" height="64" alt="" >
                                        </a>
                                    </td>
                                @endif
                                <td>
                                    @include('shared.ui_kit.__remove_item_image_docto')
                                </td>
                            </tr>
                        @endforeach
                        @for($it=$items->imagenes->count()+1;$it<=1;$it++)
                            <tr>
                                <td colspan="2">
                                    <label for="file{{$it}}"><strong>Archivo {{$it}}</strong>: Subir archivo</label>
                                    <input type="file" id="file{{$it}}" name="file{{$it}}" class="form-control-file">
                                </td>
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                </div> <!-- end table-responsive-->
            </div>
        </div>
    @if ( Auth::user()->hasRole('Administrator') )
        <button type="button" class="btn btn-sm btn-default float-left" id="addImage"  onclick="scanWithoutAspriseDialog();">Scanear Imagen</button>
        <div id="scannerImages" name="scannerImages"></div><br><br>
        <input type="text" name="scannerInput" id="scannerInput" class="col-lg-12">
        <input type="text" name="scannerInputs[]" id="scannerInputs" class="col-lg-12">
    @endif

</div>

</div>

</div>



<div class="row mt-4">
<div class="col-sm-3">
<h6>CREADO</h6>
<address>
    <strong class="orange">POR:</strong>  {{ $items->creadopor->Fullname }}<br>
    <strong class="purple">FECHA:</strong>  {{ date('d-m-Y H:i:s', strtotime($items->created_at)) }}<br>
</address>
</div> <!-- end col-->
<div class="col-sm-3">
<h6>MODIFICADO</h6>
<address>
    <strong class="orange">POR:</strong>  {{ $items->modificadopor->Fullname }}<br>
    <strong class="purple">FECHA:</strong>  {{ date('d-m-Y H:i:s', strtotime($items->updated_at)) }}<br>
</address>
</div> <!-- end col-->
<div class="col-sm-6">
<h6>ÚLTIMA RESPUESTA</h6>
<address>
    <strong class="orange">POR:</strong>  {{ $items->ultimo_estatu_denuncia_dependencia_servicio->sort()->last()->dependencia->dependencia }}<br>
    <strong class="info">SERVICIO:</strong>  {{ $items->ultimo_estatu_denuncia_dependencia_servicio->sort()->last()->servicio->servicio }}<br>
    <strong class="seagreen">ESTATUS:</strong>  {{ $items->ultimo_estatu_denuncia_dependencia_servicio->sort()->last()->estatu->estatus }}<br>
    <strong class="red">FAVORABLE:</strong>  {{ $items->ultimo_estatu_denuncia_dependencia_servicio->sort()->last()->favorable == true ? 'SI' : 'NO' }}<br>
    <strong class="purple">FECHA:</strong>  {{ date('d-m-Y H:i:s', strtotime($items->ultimo_estatu_denuncia_dependencia_servicio->sort()->last()->fecha_movimiento)) }}<br>
    <strong class="coral">RESPUESTA:</strong> <small> {{ $items->ultimo_estatu_denuncia_dependencia_servicio->sort()->last()->observaciones }} </small><br>
</address>
</div> <!-- end col-->
</div>



<hr>

<input type="hidden" name="id" id="id" value="{{$items->id}}" >
<input type="hidden" name="ubicacion_id" id="ubicacion_id" value="{{$items->Ubicacion->id}}" >
<input type="hidden" name="creadopor_id" id="creadopor_id" value="{{$items->creadopor_id}}" >
<input type="hidden" name="modificadopor_id" id="modificadopor_id" value="{{$user->id}}" >
<input type="hidden" name="usuario_id" id="usuario_id" value="{{$items->Ciudadano->id}}" >

<input type="hidden" name="oficio_envio" id="oficio_envio" value="{{$items->oficio_envio}}" >
<input type="hidden" name="folio_sas" id="folio_sas" value="{{$items->folio_sas}}" >

<input type="hidden" name="fecha_ingreso" id="fecha_ingreso" value="{{$items->fecha_ingreso}}" >
<input type="hidden" name="fecha_oficio_dependencia" id="fecha_oficio_dependencia" value="{{$items->fecha_oficio_dependencia}}" >
<input type="hidden" name="fecha_limite" id="fecha_limite" value="{{$items->fecha_limite}}" >
<input type="hidden" name="fecha_ejecucion" id="fecha_ejecucion" value="{{$items->fecha_ejecucion}}" >

{{--<input type="hidden" name="referencia" id="referencia" value="{{$items->referencia}}" >--}}

<input type="hidden" name="clave_identificadora" id="clave_identificadora" value="{{$items->clave_identificadora}}" >
{{--<input type="hidden" name="latitud" id="latitud" value="{{$items->latitud}}" >--}}
{{--<input type="hidden" name="longitud" id="longitud" value="{{$items->longitud}}" >--}}

<input type="hidden" name="prioridad_id" id="prioridad_id" value="{{$items->prioridad_id}}" >
{{--<input type="hidden" name="origen_id" id="origen_id" value="{{$items->origen_id}}" >--}}
<input type="hidden" name="estatus_id" id="estatus_id" value="{{$items->estatus_id}}" >

<input type="hidden" name="observaciones" id="observaciones" value="{{$items->observaciones}}" >
<input type="hidden" name="ambito" id="ambito" value="{{$items->ambito}}" >

<input type="hidden" name="isFechaIngresoView" id="isFechaIngresoView" value="{{ config('atemun.modificar_fecha_ingreso') }}" >

<input type="hidden" name="usuario_telefonos" id="usuario_telefonos" value="{{ $items->Ciudadano->TelefonosCelularesEmails }}" class="form-control" readonly>

{{--<input type="hidden" name="g_calle" id="g_calle" value="{{ old('g_calle',$items->Ubicacion->g_calle) }}" >--}}
{{--<input type="hidden" name="g_num_ext" id="g_num_ext" value="{{ old('g_num_ext',$items->Ubicacion->g_num_ext) }}" >--}}
{{--<input type="hidden" name="g_num_int" id="g_num_int" value="{{ old('g_num_int',$items->Ubicacion->g_num_int) }}" >--}}
{{--<input type="hidden" name="g_colonia" id="g_colonia" value="{{ old('g_colonia',$items->Ubicacion->g_colonia) }}" >--}}
{{--<input type="hidden" name="g_comunidad" id="g_comunidad" value="{{ old('g_comunidad',$items->Ubicacion->g_comunidad) }}" >--}}
{{--<input type="hidden" name="g_municipio" id="g_municipio" value="{{ old('g_municipio',$items->Ubicacion->g_municipio) }}" >--}}
{{--<input type="hidden" name="g_estado" id="g_estado" value="{{ old('g_estado',$items->Ubicacion->g_estado) }}" >--}}
{{--<input type="hidden" name="g_cp" id="g_cp" value="{{ old('g_cp',$items->Ubicacion->g_cp) }}" >--}}
{{--<input type="hidden" name="altitud" id="altitud" value="{{ old('altitud',$items->Ubicacion->g_altitud) }}" >--}}
{{--<input type="hidden" name="g_ubicacion" id="g_ubicacion" value="{{ old('g_ubicacion',$items->Ubicacion->g_ubicacion) }}" >--}}

<input type="hidden" name="altitud" id="altitud" value="{{ old('altitud',$items->altitud) }}" >
<input type="hidden" name="gd_ubicacion" id="gd_ubicacion" value="{{ old('gd_ubicacion',$items->gd_ubicacion) }}" >
