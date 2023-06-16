
<div class="form-group row mb-3">
    <label for = "comunidad" class="col-md-3 col-form-label has-comunidad">Comunidad</label>
    <div class="col-md-9">
        <input type="text" name="comunidad" id="comunidad" value="{{ old('comunidad',$items->comunidad) }}" class="form-control" />
        <span class="has-comunidad">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>

<div class="form-group row mb-3">
    <label for = "nomenclatura" class="col-md-3 col-form-label has-nomenclatura">Nomenclatura</label>
    <div class="col-md-9">
        <input type="text" name="nomenclatura" id="nomenclatura" value="{{ old('nomenclatura',$items->nomenclatura) }}" class="form-control" />
        <span class="has-nomenclatura">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>

<div class="form-group row mb-3">
    <label for = "tipocomunidad_id" class="col-md-3 col-form-label has-tipocomunidad_id">Tipo Comunidad</label>
    <div class="col-md-3">
        <select class="tipocomunidad_id form-control select2" data-toggle="select2"  name="tipocomunidad_id" id="tipocomunidad_id" size="1">
            @foreach($tipocomunidades as $t)
                <option value="{{$t->id}}" @if($t->id == $items->tipocomunidad_id) selected @endif>{{ $t->tipocomunidad }}</option>
            @endforeach
        </select>
        <span class="has-tipocomunidad_id">
            <strong class="text-danger"></strong>
        </span>
    </div>
    <label for = "ambito_comunidad" class="col-md-3 col-form-label text-right">Ámbito Comunidad</label>
    <div class="col-md-3">
{{--        {{ Form::select('ambito_comunidad', array(''=>'', 'RURAL'=>'RURAL', 'URBANO'=>'URBANO', 'NO APLICA'=>'NO APLICA'), $items->ambito_comunidad , ['id' => 'ambito_comunidad','class' => 'form-control']) }}--}}
        <select class="ambito_comunidad form-control select2" data-toggle="select2"  name="ambito_comunidad" id="ambito_comunidad" size="1">
            <option value="RURAL" @if($items->ambito_comunidad == 'RURAL') selected @endif>RURAL</option>
            <option value="URBANO" @if($items->ambito_comunidad == 'URBANO') selected @endif>URBANO</option>
            <option value="NO APLICA" @if($items->ambito_comunidad == 'NO APLICA') selected @endif>NO APLICA</option>
        </select>
    </div>
</div>

<div class="form-group row mb-3">
    <label for = "ciudad_id" class="col-md-3 col-form-label">Ciudad</label>
    <div class="col-md-9">
        <select class="ciudad_id form-control select2" data-toggle="select2"  name="ciudad_id" id="ciudad_id" size="1">
            @foreach($ciudades as $t)
                <option value="{{$t->id}}" @if( $t->id == $items->ciudad_id ) selected @endif>{{ $t->ciudad }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group row mb-3">
    <label for = "municipio_id" class="col-md-3 col-form-label">Municipio</label>
    <div class="col-md-9">
        <select class="municipio_id form-control select2" data-toggle="select2"  name="municipio_id" id="municipio_id" size="1" >
            @foreach($municipios as $t)
                <option value="{{$t->id}}" @if( $t->id == $items->municipio_id ) selected @endif>{{ $t->municipio }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group row mb-3">
    <label for = "estado_id" class="col-md-3 col-form-label">Estado</label>
    <div class="col-md-9">
        <select class="estado_id form-control select2" data-toggle="select2"  name="estado_id" id="estado_id" size="1" >
            @foreach($estados as $t)
                <option value="{{$t->id}}" @if( $t->id == $items->estado_id ) selected @endif>{{ $t->estado }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group row mb-3">
    <label for = "delegado_id" class="col-md-3 col-form-label has-delegado_id">Delegado</label>
    <div class="col-md-7">
        <select class="delegado_id form-control select2" data-toggle="select2"  name="delegado_id" id="delegado_id" size="1">
            @foreach($delegados as $t)
                <option value="{{$t->id}}" @if($t->id == $items->delegado_id) selected @endif>{{ $t->fullName }}</option>
            @endforeach
        </select>
        <span class="has-delegado_id">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>

<input type="hidden" name="id" value="{{$items->id}}" >
