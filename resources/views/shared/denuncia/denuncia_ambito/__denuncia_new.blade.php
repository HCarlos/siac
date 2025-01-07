<div class="row">
    <div class="col-md-6 ">
        <div class="grid-container">
            <div class="form-row mb-1">
                <label for = "fecha_ingreso" class="col-md-2 col-form-label">Fecha </label>
                <div class="col-md-4">
{{--                    {{ Form::date('fecha_ingreso', \Carbon\Carbon::now(), ['id'=>'fecha_ingreso','class'=>'form-control','readonly'=>'readonly']) }}--}}
                    <input type="date" name="fecha_ingreso" id="fecha_ingreso" value="{{ \Carbon\Carbon::now()->format('d-m-Y') }}" class="form-control" readonly >
                </div>
                <label for = "fecha_oficio_dependencia" class="col-md-2 col-form-label">F. Oficio </label>
                <div class="col-md-4">
{{--                    {{ Form::date('fecha_oficio_dependencia', \Carbon\Carbon::now(), ['id'=>'fecha_oficio_dependencia','class'=>'form-control']) }}--}}
                    <input type="date" name="fecha_oficio_dependencia" id="fecha_oficio_dependencia" value="{{ \Carbon\Carbon::now()->format('d-m-Y') }}" class="form-control"  >
                </div>
            </div>
            <div class="form-row mb-1">
                <label for = "fecha_ejecucion" class="col-md-2 col-form-label">F. Ejec. </label>
                <div class="col-md-4">
{{--                    {{ Form::date('fecha_ejecucion', \Carbon\Carbon::now()->addDay(3), ['id'=>'fecha_ejecucion','class'=>'form-control']) }}--}}
                    <input type="date" name="fecha_ejecucion" id="fecha_ejecucion" value="{{ \Carbon\Carbon::now()->addDay(3)->format('d-m-Y') }}" class="form-control"  >
                </div>
                <label for = "fecha_limite" class="col-md-2 col-form-label">F. Límite </label>
                <div class="col-md-4">
{{--                    {{ Form::date('fecha_limite', \Carbon\Carbon::now()->addDay(5), ['id'=>'fecha_limite','class'=>'form-control']) }}--}}
                    <input type="date" name="fecha_limite" id="fecha_limite" value="{{ \Carbon\Carbon::now()->addDay(5)->format('d-m-Y') }}" class="form-control"  >
                </div>
            </div>
            <div class="form-row mb-1">
                <label for = "oficio_envio" class="col-md-2 col-form-label">Oficio E. </label>
                <div class="col-md-10">
                    <input type="text" name="oficio_envio" id="oficio_envio" value="{{ old('oficio_envio') }}" class="form-control" />
                </div>
            </div>
            <div class="form-row mb-1">
                <label for = "descripcion" class="col-md-2 col-form-label">Solicitud </label>
                <div class="col-md-10">
                    <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion') }}</textarea>
                </div>
            </div>
            <div class="form-row mb-1">
                <label for = "referencia" class="col-md-2 col-form-label">Referencia </label>
                <div class="col-md-10">
                    <textarea name="referencia" id="referencia" class="form-control">{{ old('referencia') }}</textarea>
                </div>
            </div>
            <div class="form-row mb-1">
                <label for = "observaciones" class="col-md-2 col-form-label">Observaciones </label>
                <div class="col-md-10">
                    <textarea name="observaciones" id="observaciones" class="form-control">{{ old('observaciones') }}</textarea>
                </div>
            </div>

{{--            <div class="form-group row mb-1">--}}
{{--                <label for = "latitud" class="col-md-2 col-form-label">Lat.</label>--}}
{{--                <div class="col-md-4">--}}
{{--                    <input type="text" name="latitud" id="latitud" value="{{ old('latitud') }}" class="form-control" />--}}
{{--                </div>--}}
{{--                <label for = "longitud" class="col-md-2 col-form-label">Long.</label>--}}
{{--                <div class="col-md-4">--}}
{{--                    <input type="text" name="longitud" id="longitud" value="{{ old('longitud') }}" class="form-control" />--}}
{{--                </div>--}}
{{--            </div>--}}

        </div>
    </div>

    <div class="col-md-6 ">

        <div class="grid-container">

            <div class="form-group row mb-1">

                <label for = "search_autocomplete" class="col-md-3 col-form-label">Buscar</label>
                <div class="col-md-9">
                    <div class="input-group">
{{--                        {!! Form::text('search_autocomplete', null, array('placeholder' => 'Buscar ubicación...','class' => 'form-control','id'=>'search_autocomplete')) !!}--}}
                        <input type="text" name="search_autocomplete" id="search_autocomplete" value="{{ old('search_autocomplete') }}" placeholder="'Buscar ubicación..." class="form-control">
                        <span class="input-group-append">
{{--                            <a href="{{route("newUbicacion")}}" target="_blank" class="btn btn-icon btn-info"> <i class="mdi mdi-plus"></i></a>--}}
                            <a href="{{ route("newUbicacionV2") }}" id="{{ route("newUbicacionV2") }}" class="btn btn-icon btn-info btnFullModal" data-toggle="modal" data-target="#modalFull" title="Agregar Ubicación" >
                                <i class="mdi mdi-plus"></i>
                            </a>
                        </span>
                    </div>
                </div>

            </div>

            <div class="form-group row mb-1">
                <label for = "ubicacion" class="col-md-3 col-form-label">Ubicacion</label>
                <div class="col-md-9">
                    <div class="input-group">
                        <input type="text" name="ubicacion" id="ubicacion" value="{{ old('ubicacion') }}" class="form-control" disabled/>
                        <span class="input-group-addon bootstrap-touchspin-postfix input-group-append">
                            <small class="input-group-text " id="ubicacion_id_span">0</small>
                        </span>
                    </div>
                </div>
            </div>

            <div class="form-group row mb-1">
                <label for = "prioridad_id" class="col-md-3 col-form-label">Prioridad</label>
                <div class="col-md-3">
                    <select id="prioridad_id" name="prioridad_id" class="form-control" size="1">
                        @foreach($prioridades as $t)
                            <option value="{{$t->id}}" {{ $t->isDefault() ? 'selected': '' }} >{{ $t->prioridad }} </option>
                        @endforeach
                    </select>
                </div>
                <label for = "origen_id" class="col-md-2 col-form-label">Origen</label>
                <div class="col-md-4">
                    <select id="origen_id" name="origen_id" class="form-control"size="1">
                        @foreach($origenes as $t)
                            <option value="{{$t->id}}" {{ $t->isDefault() ? 'selected': '' }} >{{ $t->origen }} </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row mb-1">
                <label for = "dependencia_id" class="col-md-3 col-form-label">Dependencia</label>
                <div class="col-md-9">
                    <select id="dependencia_id" name="dependencia_id" class="form-control" size="1">
                        <option value="0" selected>Seleccione una Dependencia</option>
                        @foreach($dependencias as $t)
                            <option value="{{$t->id}}" >{{ $t->dependencia }} </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row mb-1">
                <label for = "servicio_id" class="col-md-3 col-form-label">Servicio</label>
                <div class="col-md-9">
                    <select id="servicio_id" name="servicio_id" class="form-control" size="1">
                    </select>
                </div>
            </div>

            <div class="form-group row mb-1">
                <label for = "ciudadano_id" class="col-md-3 col-form-label">Ciudadano</label>
                <div class="col-md-9">
                    <select id="ciudadano_id" name="ciudadano_id" class="form-control select2" data-toggle="select2" size="1">
                        @foreach($ciudadanos as $t)
                            <option value="{{$t->id}}" >{{$t->fullname}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row mb-1">
                <label for = "estatus_id" class="col-md-3 col-form-label">Estatus</label>
                <div class="col-md-5">
                    <select id="estatus_id" name="estatus_id" class="form-control" size="1">
                        @foreach($estatus as $t)
                            <option value="{{$t->id}}" {{ $t->isDefault() ? 'selected': '' }} >{{ $t->estatus }} </option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>

    </div>

</div>

<input type="hidden" name="id" value="0" >
<input type="hidden" name="ubicacion_id" id="ubicacion_id" value="0" >
<input type="hidden" name="creadopor_id" id="creadopor_id" value="{{$user->id}}" >
<input type="hidden" name="modificadopor_id" id="modificadopor_id" value="1" >
<hr>
