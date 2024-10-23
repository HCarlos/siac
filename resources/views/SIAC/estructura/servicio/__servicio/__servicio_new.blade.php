<div class="form-group row mb-1">
    <label for = "servicio" class="col-md-2 col-form-label has-servicio text-right">Servicio</label>
    <div class="col-md-10">
        <input type="text" name="servicio" id="servicio" value="{{ old('servicio') }}" class="form-control" />
        <span class="has-servicio">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "is_visible_nombre_corto_ss" class="col-md-2 col-form-label text-right">Is Servicio</label>
    <div class="col-md-2">
        <select class=" form-control " name="is_visible_nombre_corto_ss" id="is_visible_nombre_corto_ss" size="1">
            <option value="1">SI</option>
            <option value="0" selected >NO</option>
        </select>
    </div>
    <label for = "nombre_corto_orden_ss" class="col-md-2 col-form-label has-nombre_corto_orden_ss text-right">Orden Serv.</label>
    <div class="col-md-2">
        <input type="text" name="nombre_corto_orden_ss" id="nombre_corto_orden_ss" value="{{ old('nombre_corto_orden_ss') }}" class="form-control" />
        <span class="has-orden_image_mobile">
            <strong class="text-danger"></strong>
        </span>
    </div>
    <label for = "nombre_corto_ss" class="col-md-2 col-form-label has-nombre_mobile text-right">Nombre Serv.</label>
    <div class="col-md-2">
        <input type="text" name="nombre_corto_ss" id="nombre_corto_ss" value="{{ old('nombre_corto_ss') }}" class="form-control" />
        <span class="has-nombre_mobile">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "is_visible_mobile" class="col-md-2 col-form-label text-right">Is Mobile</label>
    <div class="col-md-2">
        <select class=" form-control " name="is_visible_mobile" id="is_visible_mobile" size="1">
            <option value="1" selected >SI</option>
            <option value="0">NO</option>
        </select>
    </div>
    <label for = "orden_image_mobile" class="col-md-2 col-form-label has-orden_image_mobile text-right">Orden Mob.</label>
    <div class="col-md-2">
        <input type="text" name="orden_image_mobile" id="orden_image_mobile" value="{{ old('orden_image_mobile') }}" class="form-control" />
        <span class="has-orden_image_mobile">
            <strong class="text-danger"></strong>
        </span>
    </div>
    <label for = "nombre_mobile" class="col-md-2 col-form-label has-nombre_mobile text-right">Nombre Mob.</label>
    <div class="col-md-2">
        <input type="text" name="nombre_mobile" id="nombre_mobile" value="{{ old('nombre_mobile') }}" class="form-control" />
        <span class="has-nombre_mobile">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "url_image_mobile" class="col-md-2 col-form-label has-url_image_mobile text-right">Imagen Mob.</label>
    <div class="col-md-10">
        <input type="file" name="url_image_mobile" id="url_image_mobile" value="{{ old('url_image_mobile') }}" class="form-control" />
        <span class="has-url_image_mobile">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>

<div class="form-group row mb-1">
    <label for = "subarea_id" class="col-md-2 col-form-label text-right">Subarea</label>
    <div class="col-md-10">
        <select class="subarea_id form-control select2" data-toggle="select2"  name="subarea_id" id="subarea_id" size="1">
            @foreach($subareas as $t)
                <option value="{{$t->id}}">{{ $t->subarea.' - '.$t->area->area.' - '.$t->area->dependencia->dependencia }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "habilitado" class="col-md-2 col-form-label text-right">Habilitado</label>
    <div class="col-md-2">
        <select class=" form-control " name="habilitado" id="habilitado" size="1">
            <option value="1" selected >SI</option>
            <option value="0">NO</option>
        </select>
    </div>
    <label for = "medida_id" class="col-md-2 col-form-label float-right  text-right">Medida</label>
    <div class="col-md-2">
        <select class="medida_id form-control select2" data-toggle="select2"  name="medida_id" id="medida_id" size="1">
            @foreach($medidas as $t)
                <option value="{{$t->id}}">{{ $t->medida }}</option>
            @endforeach
        </select>
    </div>
    <label for = "ambito_servicio" class="col-md-2 col-form-label text-right text-right">Tipo Servicio</label>
    <div class="col-md-2">
        <select class=" form-control " name="ambito_servicio" id="ambito_servicio" size="1">
            <option value="" selected ></option>
            <option value="RURAL" >RURAL</option>
            <option value="URBANO" >URBANO</option>
            <option value="NO APLICA" >NO APLICA</option>
        </select>
    </div>

</div>
<div class="form-group row mb-3">
    <label for = "dias_ejecucion" class="col-md-2 col-form-label has-url_image_mobile text-right">Dias Ejec.</label>
    <div class="col-md-4">
        <input type="text" name="dias_ejecucion" id="dias_ejecucion" value="{{ old('dias_ejecucion') }}" class="form-control" />
        <span class="has-dias_ejecucion">
            <strong class="text-danger"></strong>
        </span>
    </div>
    <label for = "dias_maximos_ejecucion" class="col-md-3 col-form-label has-url_image_mobile text-right">Max. Dias Ejec.</label>
    <div class="col-md-3">
        <input type="text" name="dias_maximos_ejecucion" id="dias_maximos_ejecucion" value="{{ old('dias_maximos_ejecucion') }}" class="form-control" />
        <span class="has-dias_ejecucion">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>

<input type="hidden" name="id" value="0" >
