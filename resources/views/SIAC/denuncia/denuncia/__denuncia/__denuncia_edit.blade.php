<div class="grid-structure">
<div class=" row">
    <div class="col-lg-6 ">
        <div class="grid-container">
            <div class="form-row mb-1">
                <label for = "search_autocomplete_user" class="col-lg-12 col-form-label labelDenuncia">Busca el usuario que solicita el servicio</label>
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
                            <a  href="{{route("editUser",['Id'=>$items->Ciudadano->id])}}" target="_blank" class="btn btn-xs btn-icon btn-primary editUser" id="editUser" name="editUser"> <i class="mdi mdi-account-edit text-white "></i></a>
                        </span>
                    </div>
                    <input type="text" name="usuario_telefonos" id="usuario_telefonos" value="{{ $items->Ciudadano->TelefonosCelularesEmails }}" class="form-control" readonly>
                </div>
        </div>

            <div class="form-row mb-1 " >
                <label class="col-lg-12 col-form-label labelDenuncia">Ubica la dirección del problema </label>
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
                <label for = "fecha_ingreso" class="col-lg-2 col-form-label text-right">Fecha </label>
                <div class="col-lg-4">
                    <input type="date" name="fecha_ingreso" id="fecha_ingreso" value="{{ old('fecha_ingreso',date('Y-m-d',strtotime($items->fecha_ingreso))) }}" class="form-control fecha_ingreso" readonly >
                </div>
                <label for = "fecha_oficio_dependencia" class="col-lg-2 col-form-label text-right">F. Docto. </label>
                <div class="col-lg-4">
                    <input type="date" name="fecha_oficio_dependencia" id="fecha_oficio_dependencia" value="{{ old('fecha_oficio_dependencia',$items->fecha_oficio_dependencia) }}" class="form-control" >
                </div>
            </div>
            <div class="form-row mb-1">
                <label for = "fecha_ejecucion" class="col-lg-2 col-form-label text-right">F. Ejec. </label>
                <div class="col-lg-4">
                    <input type="date" name="fecha_ejecucion" id="fecha_ejecucion" value="{{ old('fecha_ejecucion',$items->fecha_ejecucion) }}" class="form-control" >
                </div>
                <label for = "fecha_limite" class="col-lg-2 col-form-label text-right">F. Límite </label>
                <div class="col-lg-4">
                    <input type="date" name="fecha_limite" id="fecha_limite" value="{{ old('fecha_limite',$items->fecha_limite) }}" class="form-control" >
                </div>
            </div>

            <div class="form-row mb-1 ">
                <label for = "latitud" class="col-lg-2 col-form-label text-right">Latitud: </label>
                <div class="col-lg-4">
                    <input type="text" name="latitud" id="latitud" value="{{ old('latitud',$items->latitud) }}" class="form-control latitud" placeholder="17.9983821">
                </div>
                <label for = "longitud" class="col-lg-2 col-form-label text-right">Longitud: </label>
                <div class="col-lg-4">
                    <input type="text" name="longitud" id="longitud" value="{{ old('longitud',$items->longitud) }}" class="form-control longitud" placeholder="-92.944787">
                </div>
            </div>

            <hr>

        </div>
    </div>

    <div class="col-lg-6 ">

        <div class="grid-container">

            <div class="form-group row mb-1">
                <label for = "descripcion" class="col-lg-3 col-form-label has-descripcion labelDenuncia text-right">Descripción </label>
                <div class="col-lg-9">
                    <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion',$items->descripcion) }}</textarea>
                    <span class="has-descripcion">
                        <strong class="text-danger"></strong>
                    </span>
                </div>
            </div>

            <div class="form-group row mb-1">
                <label for = "referencia" class="col-lg-3 col-form-label labelDenuncia text-right">Referencia </label>
                <div class="col-lg-9">
                    <textarea name="referencia" id="referencia" class="form-control">{{ old('referencia',$items->referencia) }}</textarea>
                </div>
            </div>

            <div class="form-group row mb-1">
                <label for = "clave_identificadora" class="col-lg-3 col-form-label labelDenuncia text-right">Cve Identificadora</label>
                <div class="col-lg-9">
                    @if ( Auth::user()->hasAnyPermission(['seleccionar_hashtag']) )
                        <select id="clave_identificadora" name="clave_identificadora" class="form-control" size="1">
                            <option value="" selected >Seleccione una Clave</option>
                            @foreach($hashtag as $id => $valor)
                                <option value="{{ $id }}" @if($items->clave_identificadora === $valor) selected @endif >{{ $valor }}</option>
                            @endforeach
                        </select>
                    @else
                        <input type="text" name="clave_identificadora" id="clave_identificadora" value="{{ old('clave_identificadora',$items->clave_identificadora) }}"  class="form-control" />
                    @endif
                </div>
            </div>

            <div class="form-group row mb-1">
                <label for = "prioridad_id" class="col-lg-3 col-form-label labelDenuncia text-right">Prioridad</label>
                <div class="col-lg-3">
                    <select id="prioridad_id" name="prioridad_id" class="form-control" size="1">
                        @foreach($prioridades as $t)
                            <option value="{{$t->id}}" {{ $t->id === $items->prioridad_id ? 'selected': '' }} >{{ $t->prioridad }} </option>
                        @endforeach
                    </select>
                </div>
                <label for = "origen_id" class="col-lg-2 col-form-label labelDenuncia text-right">Origen</label>
                <div class="col-lg-4">
                    <select id="origen_id" name="origen_id" class="form-control" size="1">
                        @foreach($origenes as $t)
                            <option value="{{$t->id}}" {{ $t->id === $items->origen_id ? 'selected': '' }} >{{ $t->origen }} </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row mb-1">
                <label for = "dependencia_id" class="col-lg-3 col-form-label labelDenuncia text-right">Unidad Adm.</label>
                <div class="col-lg-9">
                    <select id="dependencia_id" name="dependencia_id" class="form-control" size="1">
                        <option value="0" selected>Seleccione una Dependencia</option>
                        @foreach($dependencias as $t)
                            <option value="{{$t->id}}" {{ $t->id === $items->dependencia_id ? 'selected': '' }} >{{ $t->dependencia }} </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row mb-1">
                <label for = "servicio_id" class="col-lg-3 col-form-label labelDenuncia text-right">Servicio</label>
                <div class="col-lg-9">
                    <select id="servicio_id" name="servicio_id" class="form-control" size="1">
                        <option value="0" selected>Seleccione un Servicio</option>
                        @foreach($servicios as $t)
                            <option value="{{$t->id}}" {{ $t->id === $items->servicio_id ? 'selected': '' }} >{{ $t->id }} - {{ $t->servicio }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row mb-1">
                <label for = "estatus_id" class="col-lg-3 col-form-label labelDenuncia text-right">Estatus</label>
                <div class="col-lg-9">
                    <select id="estatus_id" name="estatus_id" class="form-control" size="1">
                        @foreach($estatus as $t)
                            <option value="{{$t->id}}" {{ $t->id === $items->estatus_id ? 'selected': '' }} >{{ $t->estatus }} </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row mb-1">
                <label for = "observaciones" class="col-lg-3 col-form-label text-right">Observaciones </label>
                <div class="col-lg-9">
                    <textarea name="observaciones" id="observaciones" class="form-control">{{ old('observaciones',$items->observaciones) }}</textarea>
                </div>
            </div>
        </div>
        <div class="grid-container cards-container">

            <div class="card border-2 shadow-sm " >
                <div class="card-header bg-dark-lighten pt-0 pb-0">
                    <h5 class="text-110 text-white">
                        Aplica solo para SAS
                    </h5>
                </div>
                <div class="card-body border-2 border-t-0 brg-default-light p-2" >
                    <div class="form-group row mb-1">
                        <label for = "folio_sas" class="col-lg-2 col-form-label text-right">Folio SAS</label>
                        <div class="col-lg-4">
                            <input type="text" name="folio_sas" id="folio_sas" value="{{ old('folio_sas',$items->folio_sas) }}" class="form-control" />
                        </div>
                        <label for = "folio_sas" class="col-lg-2 col-form-label text-right">Ámbito</label>
                        <div class="col-lg-4">
                            <select class="form-control" size="1" id="ambito" name="ambito">
                                <option value="0" @if($items->ambito===0) selected @endif>No Aplica</option>
                                <option value="1" @if($items->ambito===1) selected @endif>Urbano</option>
                                <option value="2" @if($items->ambito===2) selected @endif>Rural</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

</div>

<div class="grid-structure">
    <div class=" row">
        <div class="col-lg-12 ">
            <div class="grid-container">
                <div class="form-group mb-3">
                    <div class="table-responsive-sm">
                        <table class="table table-centered mb-0">
                            <thead class="thead-dark">
                            <tr>
                                <th>Imegen</th>
                                <th>Directorio</th>
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
                                <td>{{ asset("/storage/mobile/denuncia/".$item->image) }}</td>
                                @else
                                    <td>
                                        <a class="pull-left pl-2"  href="{{asset($item->PathImage)}}" target="_blank" >
                                            <img class="media-object" src="{{asset($item->PathImageThumb)}}" width="64" height="64" alt="" >
                                        </a>
                                    </td>
                                    <td>{{ asset("/storage/denuncia/".$item->image) }}</td>
                                @endif
                                <td>
                                    @include('shared.ui_kit.__remove_item_image_docto')
                                </td>
                            </tr>
                            @endforeach
                            @for($it=$items->imagenes->count()+1;$it<=3;$it++)
                                <tr>
                                    <td colspan="3">
                                        <div class="form-group mb-1 col-lg-3">
                                            <label for="file{{$it}}"><strong>Archivo {{$it}}</strong>: Subir archivo</label>
                                            <input type="file" id="file{{$it}}" name="file{{$it}}" class="form-control-file">
                                        </div>
                                    </td>
                                </tr>
                            @endfor
                            </tbody>
                        </table>
                    </div> <!-- end table-responsive-->
                </div>
            </div>
        </div>
    </div>
</div>

<hr>

<div class="grid-structure">
    <div class=" row">
        <div class="col-lg-12 ">
            <div class="col-lg-10">
            </div>
            <div class="col-lg-3">
                <a href="#" class="btn btn-block btn-danger-primary btn-rounded text-white searchIdentical"><i class="fas fa-search"></i> Buscar coincidencias  </a>
            </div>
            <div class="grid-container">
                <div class="form-group mb-3">
                    <div class="table-responsive-sm">
                        <table class="table table-centered mb-0">
                            <thead class="thead-dark">
                            <tr>
                                <th>Demandas similares</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="tblBody">
                            </tbody>
                        </table>
                    </div> <!-- end table-responsive-->
                </div>
            </div>
        </div>
    </div>
</div>


<hr>


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
<input type="hidden" name="isFechaIngresoView" id="isFechaIngresoView" value="{{ config('atemun.modificar_fecha_ingreso') }}" >
<input type="hidden" name="ambito_dependencia" id="ambito_dependencia" value="{{ old('ambito_dependencia',$ambito_dependencia) }}" >
<input type="hidden" name="ambito_estatus" id="ambito_estatus" value="{{ old('ambito_estatus',$ambito_estatus) }}" >


