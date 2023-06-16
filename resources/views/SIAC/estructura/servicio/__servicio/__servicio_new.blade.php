<div class="form-group row mb-1">
    <label for = "servicio" class="col-md-3 col-form-label has-servicio">Servicio</label>
    <div class="col-md-9">
        <input type="text" name="servicio" id="servicio" value="{{ old('servicio') }}" class="form-control" />
        <span class="has-servicio">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "ambito_servicio" class="col-md-3 col-form-label">Tipo Servicio</label>
    <div class="col-md-9">
{{--        {{ Form::select('ambito_servicio', array(''=>'', 'RURAL'=>'RURAL', 'URBANO'=>'URBANO', 'NO APLICA'=>'NO APLICA'), old('ambito_servicio') , ['id' => 'ambito_servicio','class' => 'form-control']) }}--}}
        <select class=" form-control " name="ambito_servicio" id="ambito_servicio" size="1">
            <option value="" selected ></option>
            <option value="RURAL" >RURAL</option>
            <option value="URBANO" >URBANO</option>
            <option value="NO APLICA" >NO APLICA</option>
        </select>
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "habilitado" class="col-md-3 col-form-label">Habilitado</label>
    <div class="col-md-3">
{{--        {{ Form::select('habilitado', array('1'=>'Si', '0'=>'No'), old('habilitado'), ['id' => 'habilitado','class' => 'form-control']) }}--}}
        <select class=" form-control " name="habilitado" id="habilitado" size="1">
            <option value="1" selected >SI</option>
            <option value="0">NO</option>
        </select>
    </div>
    <label for = "is_visible_mobile" class="col-md-3 col-form-label">Activo en App Mobile</label>
    <div class="col-md-3">
{{--        {{ Form::select('is_visible_mobile', array('0'=>'No','1'=>'Si'), old('is_visible_mobile'), ['id' => 'is_visible_mobile','class' => 'form-control']) }}--}}
        <select class=" form-control " name="is_visible_mobile" id="is_visible_mobile" size="1">
            <option value="1" selected >SI</option>
            <option value="0">NO</option>
        </select>
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "nombre_mobile" class="col-md-3 col-form-label has-nombre_mobile">Nombre Mobile</label>
    <div class="col-md-5">
        <input type="text" name="nombre_mobile" id="nombre_mobile" value="{{ old('nombre_mobile') }}" class="form-control" />
        <span class="has-nombre_mobile">
            <strong class="text-danger"></strong>
        </span>
    </div>
    <label for = "orden_image_mobile" class="col-md-2 col-form-label has-orden_image_mobile">Orden Mobile</label>
    <div class="col-md-2">
        <input type="text" name="orden_image_mobile" id="orden_image_mobile" value="{{ old('orden_image_mobile') }}" class="form-control" />
        <span class="has-orden_image_mobile">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "url_image_mobile" class="col-md-3 col-form-label has-url_image_mobile">Imagen Mobile</label>
    <div class="col-md-9">
        <input type="file" name="url_image_mobile" id="url_image_mobile" value="{{ old('url_image_mobile') }}" class="form-control" />
        <span class="has-url_image_mobile">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>

<div class="form-group row mb-1">
    <label for = "medida_id" class="col-md-3 col-form-label">Medida</label>
    <div class="col-md-9">
        <select class="medida_id form-control select2" data-toggle="select2"  name="medida_id" id="medida_id" size="1">
            @foreach($medidas as $t)
                <option value="{{$t->id}}">{{ $t->medida }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "subarea_id" class="col-md-3 col-form-label">Subarea</label>
    <div class="col-md-9">
        <select class="subarea_id form-control select2" data-toggle="select2"  name="subarea_id" id="subarea_id" size="1">
            @foreach($subareas as $t)
                <option value="{{$t->id}}">{{ $t->subarea.' - '.$t->area->area.' - '.$t->area->dependencia->dependencia }}</option>
            @endforeach
        </select>
    </div>
</div>

<input type="hidden" name="id" value="0" >
