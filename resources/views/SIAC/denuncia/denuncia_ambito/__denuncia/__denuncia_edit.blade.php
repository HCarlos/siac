<div class="grid-structure">
<div class=" row">
    <div class="col-lg-6 ">
        <div class="grid-container">
            <div class="form-row mb-1">
                <label for = "search_autocomplete_user" class="col-lg-12 col-form-label labelDenuncia">Busca el usuario que solicita el servicio:</label>
                <div class="col-lg-12">
                    <div class="input-group">
                        <small data-toggle="tooltip" class="text-rojo-morena"
                              title="Escribe el nombre completo del ciudadano. Asegúrate que aparezca en el menú desplegable con su CURP, en caso de no estar en el menú, puedes agregarlo en el icono de (+) revisa que cuente con número de teléfono, si no cuenta con teléfono de contacto, lo puedes agregar en el icono color naranja."
                        >
                            <i class="fa fa-question-circle pl-1 pr-1 pt-2"></i>
                        </small>
                        <input type="text" name="search_autocomplete_user" id="search_autocomplete_user" value="{{ $items->Ciudadano->FullName }}" placeholder="Buscar usuario..." class="form-control">
                        <span class="input-group-append">
                            <a href="{{route("newUser")}}" target="_blank" class="btn btn-icon btn-info"> <i class="mdi mdi-plus"></i></a>
                        </span>
                    </div>
                </div>
                <div class="col-lg-12 border-bottom">
                    <div class="input-group btn-group-sm mb-1 mt-1 ">
                        <span class="input-group-append float-left flex-fill">
                            <i class="mdi mdi-cellphone-iphone font-18 pl-1 pr-1"></i> <span class="pt-1" id="lblCelulares">{{ $items->ciudadano->celulares }}</span>
                            <i class="mdi mdi-phone font-18 pl-1 pr-1"></i> <span class="pt-1" id="lblTelefonos">{{ $items->ciudadano->telefonos }}</span>
                            <i class="mdi mdi-email font-18 pl-1 pr-1"></i> <span class="pt-1" id="lblEMails">{{ $items->ciudadano->emails }}</span>
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
                        <input type="text" name="search_google" id="search_google" class="form-control w-100-percent" value="{{ old('search_google', $items->search_google) }}" placeholder="escriba aquí la colonia" required >
                        <small class="muted chikirimbita chikirimbita_1 w-100-percent">{{ $items->search_google_select }}</small>
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
                        <select id="centro_localidad_id" name="centro_localidad_id" class="form-control centro_localidad_id select2" data-toggle="select2" size="1" value="{{ old('centro_localidad_id') }}">
                            <option value="0"  >Seleccione una Localidad</option>
                            @foreach($localidades_centro as $t)
                                <option value="{{$t->id}}"  {{ $t->id === $items->centro_localidad_id ? 'selected': '' }}  >{{ $t->ItemColoniaDelegacion() }} </option>
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
                        <input type="text" name="codigo_postal_manual" id="codigo_postal_manual" class="form-control" value="{{ old('codigo_postal_manual', $items->codigo_postal_manual) }}" placeholder="Escriba el Código Postal" >
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

            <div class="form-row mb-1 mt-1">
                <label for = "searchGoogleResult" class="col-lg-2 col-form-label text-right"> </label>
                <div class="col-lg-10">
                    <small class="text-success font-medium text-center p-0 m-0" id="searchGoogleResult"></small>
                    <small class="text-danger font-medium text-center p-0 m-0" id="searchGoogleError"></small>
                </div>
            </div>


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
            <div class="form-group row mb-1 mt-2">
                <div class="col-lg-12 ">
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
                <label for = "origen_id" class="col-lg-2 col-form-label labelDenuncia text-right m-0 p-0">Fuente:</label>
                <div class="col-lg-5">
                    <select id="origen_id" name="origen_id" class="form-control" size="1">
                        <option value="0" >Seleccione una fuente</option>
                        @foreach($origenes as $t)
                            <option value="{{$t->id}}" {{ $t->id === $items->origen_id ? 'selected': '' }} >{{ $t->origen }} </option>
                        @endforeach
                    </select>
                </div>
                <label for = "prioridad_id" class="col-lg-2 col-form-label labelDenuncia text-right m-0 p-0">Prioridad: </label>
                <div class="col-lg-3">
                    <select id="prioridad_id" name="prioridad_id" class="form-control" size="1" >
                        @foreach($prioridades as $t)
                            <option value="{{$t->id}}" {{ $t->id === $items->prioridad_id ? 'selected': '' }} >{{ $t->prioridad }} </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="form-group row mb-1">
                <label for = "servicio_id" class="col-lg-2 col-form-label labelDenuncia text-right m-0 p-0">Servicio:</label>
                <div class="col-lg-10">
                    <select id="servicio_id" name="servicio_id" class="form-control" size="1">
                        <option value="0" >Seleccione un Servicio</option>
                        @foreach($servicios as $t)
                            <option value="{{$t->id}}" {{ $t->id === $items->servicio_id ? 'selected': '' }} >{{ $t->servicio.' ('.$t->abreviatura_dependencia.')' }}</option>
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
                    <textarea name="descripcion" id="descripcion" class="form-control" rows="6" required>{{ old('descripcion',$items->descripcion) }}</textarea>
                    <span class="has-descripcion">
                        <strong class="text-danger"></strong>
                    </span>
                </div>
            </div>

            <div class="form-group row mb-1">
                <label for = "ambito" class="col-lg-2 col-form-label labelDenuncia text-right m-0 p-0">Categoría:</label>
                <div class="col-lg-10">
                    <select id="ambito" name="ambito" class="form-control" size="1">
                        <option value="0" {{ $items->ambito === 0 ? 'selected': '' }} >No Aplica</option>
                        @foreach($ambito as $id => $valor)
                            <option value="{{$id}}" {{ $id === $items->ambito ? 'selected': '' }} >{{ $valor }} </option>
                        @endforeach
                    </select>
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
                        @for($it=$items->imagenes->count()+1;$it<=3;$it++)
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
        <hr>
        <div class="form-group row mb-1 ml-1">
                @if ( Auth::user()->hasRole('Administrator|ENLACE|ESCANEAR|test_admin') )
                    <button type="button" class="btn btn-sm btn-amarillo-morena btn-rounded text-white pb-3px float-left" id="addImage"  onclick="scanWithoutAspriseDialog();" style="padding-bottom: 0.3em !important;">Escanear documento</button>
                    <div id="scannerImages" name="scannerImages"></div><br><br>
                @endif
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









<div class="row mt-4">
<div class="col-sm-3">
<h6>CREADO</h6>
<address>
    <strong class="orange">POR:</strong>  {{ $items->creadopor->Fullname ?? 'N/A' }}<br>
{{--    <small class="text-gray-darker">Und:</small>{{ str_replace('|',', ',$items->creadopor->DependenciaAbreviaturaArray) }}<br>--}}
    <strong class="purple">FECHA:</strong>  {{ date('d-m-Y H:i:s', strtotime($items->created_at)) }}<br>
</address>
</div> <!-- end col-->
<div class="col-sm-3">
<h6>MODIFICADO</h6>
<address>
    <strong class="orange">POR:</strong>  {{ $items->denuncia_modificado->sort()->last()->modificadopor->Fullname ?? 'N/A' }}<br>
    <strong class="purple">FECHA:</strong>  {{ date('d-m-Y H:i:s', strtotime($items->updated_at)) }}<br>
    <strong class="info">MODIFICÓ:</strong> <small class="text-gray-darker">{{ $items->denuncia_modificado->sort()->last()->campos_modificados ?? 'N/A' }}</small><br>
</address>
</div> <!-- end col-->
<div class="col-sm-6">
<h6>ÚLTIMA RESPUESTA</h6>
<address>
    <strong class="orange">POR:</strong>  {{ $items->ultimo_estatu_denuncia_dependencia_servicio->sort()->last()->creadopor->full_name }}<br>
{{--    <small class="text-gray-darker">Und:</small>{{ str_replace('|',', ',$items->ultimo_estatu_denuncia_dependencia_servicio->sort()->last()->creadopor->DependenciaAbreviaturaArray) }}<br>--}}
    <strong class="info">SERVICIO:</strong>  {{ $items->ultimo_estatu_denuncia_dependencia_servicio->sort()->last()->servicio->servicio }}<br>
    <strong class="seagreen">ESTATUS:</strong>  {{ $items->ultimo_estatu_denuncia_dependencia_servicio->sort()->last()->estatu->estatus }}<br>
    <strong class="purple">FECHA:</strong>  {{ date('d-m-Y H:i:s', strtotime($items->ultimo_estatu_denuncia_dependencia_servicio->sort()->last()->fecha_movimiento)) }}<br>
    <strong class="coral">RESPUESTA:</strong> <small> {{ $items->ultimo_estatu_denuncia_dependencia_servicio->sort()->last()->observaciones }} </small><br>
</address>
</div> <!-- end col-->
</div>



<hr>

<input type="hidden" name="id" id="id" value="{{$items->id}}" >
<input type="hidden" name="ubicacion_id" id="ubicacion_id" value="{{$items->ubicacion->id}}" >
<input type="hidden" name="creadopor_id" id="creadopor_id" value="{{$items->creadopor_id}}" >
<input type="hidden" name="modificadopor_id" id="modificadopor_id" value="{{$user->id}}" >
<input type="hidden" name="usuario_id" id="usuario_id" value="{{$items->ciudadano->id}}" >

<input type="hidden" name="oficio_envio" id="oficio_envio" value="{{$items->oficio_envio}}" >

<input type="hidden" name="fecha_ingreso" id="fecha_ingreso" value="{{$items->fecha_ingreso}}" >
<input type="hidden" name="fecha_oficio_dependencia" id="fecha_oficio_dependencia" value="{{$items->fecha_oficio_dependencia}}" >
<input type="hidden" name="fecha_limite" id="fecha_limite" value="{{$items->fecha_limite}}" >
<input type="hidden" name="fecha_ejecucion" id="fecha_ejecucion" value="{{$items->fecha_ejecucion}}" >

<input type="hidden" name="clave_identificadora" id="clave_identificadora" value="{{$items->clave_identificadora}}" >

<input type="hidden" name="estatus_id" id="estatus_id" value="{{$items->estatus_id}}" >

<input type="hidden" name="observaciones" id="observaciones" value="{{$items->observaciones}}" >

<input type="hidden" name="isFechaIngresoView" id="isFechaIngresoView" value="{{ config('atemun.modificar_fecha_ingreso') }}" >

<input type="hidden" name="usuario_telefonos" id="usuario_telefonos" value="{{ $items->Ciudadano->TelefonosCelularesEmails }}" class="form-control" readonly>

<input type="hidden" name="altitud" id="altitud" value="{{ old('altitud',$items->altitud) }}" >
<input type="hidden" name="gd_ubicacion" id="gd_ubicacion" value="{{ old('gd_ubicacion',$items->gd_ubicacion) }}" >
<input type="hidden" name="search_google_select" id="search_google_select" value="{{ old('search_google_select',$items->search_google_select) }}" >
<input type="hidden" name="referencia" id="referencia" value="{{ old('referencia',$items->referencia) }}" >

<input type="hidden" name="ambito_dependencia" id="ambito_dependencia" value="{{ old('ambito_dependencia',$ambito_dependencia) }}" >
<input type="hidden" name="ambito_estatus" id="ambito_estatus" value="{{ old('ambito_estatus',$ambito_estatus) }}" >
<input type="hidden" name="centro_localidad" id="centro_localidad" value="{{ old('centro_localidad',$centro_localidad) }}" >

@include('shared/code/__modal_denuncia_user_data')

