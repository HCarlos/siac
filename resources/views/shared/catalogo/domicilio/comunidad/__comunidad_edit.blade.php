
<div class="form-group row mb-3">
    <label for = "comunidad" class="col-md-3 col-form-label">Comunidad</label>
    <div class="col-md-9">
        <input type="text" name="comunidad" id="comunidad" value="{{ old('comunidad',$items->comunidad) }}" class="form-control" />
    </div>
</div>

<div class="form-group row mb-3">
    <label for = "tipocomunidad_id" class="col-md-3 col-form-label">Tipo Comunidad</label>
    <div class="col-md-9">
        <select class="tipocomunidad_id form-control select2" data-toggle="select2"  name="tipocomunidad_id" id="tipocomunidad_id" size="1">
            @foreach($tipocomunidades as $t)
                <option value="{{$t->id}}" @if($t->id == $items->tipocomunidad_id) selected @endif>{{ $t->tipocomunidad }}</option>
            @endforeach
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
    <label for = "ciudad_id" class="col-md-3 col-form-label">Municipio</label>
    <div class="col-md-9">
        <select class="municipio_id form-control select2" data-toggle="select2"  name="municipio_id" id="municipio_id" size="1" disabled>
            @foreach($municipios as $t)
                <option value="{{$t->id}}" @if( $t->id == $items->municipio_id ) selected @endif>{{ $t->municipio }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group row mb-3">
    <label for = "ciudad_id" class="col-md-3 col-form-label">Estado</label>
    <div class="col-md-9">
        <select class="estado_id form-control select2" data-toggle="select2"  name="estado_id" id="estado_id" size="1" disabled>
            @foreach($estados as $t)
                <option value="{{$t->id}}" @if( $t->id == $items->estado_id ) selected @endif>{{ $t->estado }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group row mb-3">
    <label for = "delegado_id" class="col-md-3 col-form-label">Delegado</label>
    <div class="col-md-9">
        <select class="delegado_id form-control select2" data-toggle="select2"  name="delegado_id" id="delegado_id" size="1">
            @foreach($delegados as $t)
                <option value="{{$t->id}}" @if($t->id == $items->delegado_id) selected @endif>{{ $t->fullName }}</option>
            @endforeach
        </select>
    </div>
</div>

<input type="hidden" name="id" value="{{$items->id}}" >
<input type="hidden" name="cd_id" id="cd_id" value="0" >
<input type="hidden" name="mun_id" id="mun_id" value="0" >
<input type="hidden" name="edo_id" id="edo_id" value="0" >

<hr>
