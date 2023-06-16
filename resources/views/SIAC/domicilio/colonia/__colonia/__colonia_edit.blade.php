
<div class="form-group row mb-1">
    <label for = "colonia" class="col-md-3 col-form-label">Colonia</label>
    <div class="col-md-7">
        <input type="text" name="colonia" id="colonia" value="{{ old('colonia',$items->colonia) }}" class="form-control" />
    </div>
    <div class="col-md-2"></div>
</div>
<div class="form-group row mb-1">
    <label for = "nomenclatura" class="col-md-3 col-form-label has-nomenclatura">Nomenclatura</label>
    <div class="col-md-7">
        <input type="text" name="nomenclatura" id="nomenclatura" value="{{ old('nomenclatura',$items->nomenclatura) }}" class="form-control" />
        <span class="has-nomenclatura">
            <strong class="text-danger"></strong>
        </span>
    </div>
    <div class="col-md-2"></div>
</div>
<div class="form-group row mb-1">
    <label for = "latitud" class="col-md-3 col-form-label">Latitud</label>
    <div class="col-md-7">
{{--        <input type="text" name="latitud" id="latitud" value="{{ old('latitud',$items->latitud) }}" class="form-control" pattern="^-?\d{1,3}\.\d+"/>--}}
        <input type="text" name="latitud" id="latitud" value="{{ old('latitud',$items->latitud) }}" class="form-control" />
    </div>
    <label for = "longitud" class="col-md-3 col-form-label">Longitud</label>
    <div class="col-md-7">
{{--        <input type="text" name="longitud" id="longitud" value="{{ old('longitud',$items->longitud) }}" class="form-control" pattern="^-?\d{1,3}\.\d+$"/>--}}
        <input type="text" name="longitud" id="longitud" value="{{ old('longitud',$items->longitud) }}" class="form-control" />
    </div>
    <label for = "altitud" class="col-md-3 col-form-label">Altitud</label>
    <div class="col-md-7">
{{--        <input type="text" name="altitud" id="altitud" value="{{ old('altitud',$items->altitud) }}" class="form-control" pattern="^[-+]?[0-9]*[.,]?[0-9]+$"/>--}}
        <input type="text" name="altitud" id="altitud" value="{{ old('altitud',$items->altitud) }}" class="form-control" />
    </div>
</div>

<div class="form-group row mb-1">
    <label for = "codigo" class="col-md-3 col-form-label">Zona Postal</label>
    <div class="col-md-7">
        <input type="text" name="codigo" id="codigo" value="{{ old('codigo',$items->codigoPostal->codigo) }}" class="form-control" disabled/>
    </div>
    <label for = "search_autocomplete_cp" class="col-md-3 col-form-label">CP</label>
    <div class="col-md-7">
        <div class="input-group">
{{--            {!! Form::text('search_autocomplete_cp', $items->codigoPostal->cp, array('placeholder' => 'Buscar código postal...','class' => 'form-control search_autocomplete_cp','id'=>'search_autocomplete_cp')) !!}--}}
            <input type="text" name="search_autocomplete_cp" id="search_autocomplete_cp" value="{{ $items->codigoPostal->cp }}" placeholder="Buscar código postal..." class="form-control search_autocomplete_cp">
        </div>
    </div>
    <div class="col-md-2">
        <a href="{{ route("newCodigopostalV2") }}" id="{{route("newCodigopostalV2")}}" class="btn btn-icon btn-info btnFullModal" data-toggle="modal" data-target="#modalFull"> <i class="mdi mdi-plus"></i></a>
    </div>

</div>

<div class="form-group row mb-3">
    <label for = "tipocomunidad" class="col-md-3 col-form-label">Tipo Comunidad</label>
    <div class="col-md-7">
        <input type="text" name="tipocomunidad" id="tipocomunidad" value="{{ old('tipocomunidad',$items->comunidad->tipoComunidad->tipocomunidad) }}" class="form-control" disabled/>
    </div>
    <label for = "search_autocomplete_comunidad" class="col-md-3 col-form-label">Comunidad</label>
    <div class="col-md-7">
        <div class="input-group">
{{--            {!! Form::text('search_autocomplete_comunidad', old('search_autocomplete_comunidad',$items->comunidad->comunidad), array('placeholder' => 'Buscar colonia...','class' => 'form-control','id'=>'search_autocomplete_comunidad')) !!}--}}
            <input type="text" name="search_autocomplete_comunidad" id="search_autocomplete_comunidad" value="{{ $items->comunidad->comunidad }}" placeholder="Buscar colonia..." class="form-control">
        </div>
    </div>
    <div class="col-md-2">
        <a href="{{route("newComunidadV2")}}" id="{{route("newComunidadV2")}}" class="btn btn-icon btn-info btnFullModal" data-toggle="modal" data-target="#modalFull"> <i class="mdi mdi-plus"></i></a>
    </div>
    <label for = "delegado" class="col-md-3 col-form-label">Delegado</label>
    <div class="col-md-7">
        <input type="text" name="delegado" id="delegado" value="{{ old('delegado',$items->comunidad->delegado->fullName) }}" class="form-control" disabled/>
    </div>
</div>

<input type="hidden" name="id" id="id" value="{{ $items->id }}" >
<input type="hidden" name="codigopostal_id" id="codigopostal_id" value="{{ $items->codigopostal_id }}" >
<input type="hidden" name="comunidad_id" id="comunidad_id" value="{{ $items->comunidad_id }}" >

