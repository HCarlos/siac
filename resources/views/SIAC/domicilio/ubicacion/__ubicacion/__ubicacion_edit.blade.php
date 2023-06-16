<div class="form-group row mb-1">
    <label for="calle_id" class="col-md-3 col-form-label">Calle</label>
    <div class="col-md-9">
        {{--        {{ Form::select('calle_id', $calles, $items->calle_id, ['id' => 'calle_id','class'=>'calle_id form-control select2','data-toggle'=>'select2','size'=>1 ]) }}--}}
        <select class="calle_id form-control select2" data-toggle="select2" name="calle_id" id="calle_id" size="1">
            @foreach($calles as $calle)
                <option value="{{ $calle->id }}"
                        @if($calles->id == $items->calle_id) selected @endif>{{ $calles->calle }}</option>
            @endforeach
        </select>
    </div>
    <label for="num_ext" class="col-md-3 col-form-label">Núm. Exterior</label>
    <div class="col-md-9">
        <input type="text" name="num_ext" id="num_ext" value="{{ old('num_ext',$items->num_ext) }}"
               class="form-control"/>
    </div>
    <label for="num_int" class="col-md-3 col-form-label">Núm. Interior</label>
    <div class="col-md-9">
        <input type="text" name="num_int" id="num_int" value="{{ old('num_int',$items->num_int) }}"
               class="form-control"/>
    </div>
</div>
<div class="form-group row mb-1">
    <label for="colonia_id" class="col-md-3 col-form-label">Colonia</label>
    <div class="col-md-7">
        <select class="colonia_id form-control " name="colonia_id" id="colonia_id" size="1">
            @foreach($colonias as $t)
                <option value="{{$t->id}}"
                        @if($t->id == (int) $items->colonia_id) selected @endif>{{ $t->colonia }}</option>
            @endforeach
        </select>
        {{--        {{ Form::select('colonia_id', $colonias, $items->colonia_id, ['id' => 'colonia_id','class'=>'colonia_id form-control select2','data-toggle'=>'select2','size'=>1 ]) }}--}}
    </div>
    <div class="col-md-2">
        <a href="{{route("newColonia")}}" target="_blank" class="btn btn-icon btn-info "> <i
                class="mdi mdi-plus"></i></a>
    </div>
</div>
<div class="form-group row mb-1">
    <label for="comunidad_id" class="col-md-3 col-form-label">Comunidad</label>
    <div class="col-md-7">
        <select class="comunidad_id form-control " name="comunidad_id" id="comunidad_id" size="1">
            @foreach($comunidades as $t)
                <option value="{{$t->id}}"
                        @if((int) $items->comunidad_id == (int) $t->id) selected @endif>{{ $t->id.' '.$items->comunidad_id.' '.$t->comunidad }}</option>
            @endforeach
        </select>
        {{--        {{ Form::select('comunidad_id', $comunidades, $items->comunidad_id, ['id' => 'comunidad_id','class'=>'comunidad_id form-control ','disabled'=>'disabled','size'=>1 ]) }}--}}
    </div>

    <label for="ciudad" class="col-md-3 col-form-label">Ciudad</label>
    <div class="col-md-7">
        <input type="text" name="ciudad" id="ciudad" value="{{ $items->ciudad }}" class="form-control" disabled/>
    </div>
    <label for="municipio" class="col-md-3 col-form-label">Municipio</label>
    <div class="col-md-7">
        <input type="text" name="municipio" id="municipio" value="{{ $items->municipio }}" class="form-control"
               disabled/>
    </div>
    <label for="estado" class="col-md-3 col-form-label">Estado</label>
    <div class="col-md-7">
        <input type="text" name="estado" id="estado" value="{{ $items->estado }}" class="form-control" disabled/>
    </div>
    <label for="codigopostal_id" class="col-md-3 col-form-label">CP</label>
    <div class="col-md-7">
        <select class="codigopostal_id form-control " name="codigopostal_id" id="codigopostal_id" size="1" disabled>
            @foreach($codigospostales as $t)
                <option value="{{$t->id}}"
                        @if( (int) $t->id == (int) $items->codigopostal_id ) selected @endif>{{ $t->cp }}</option>
            @endforeach
        </select>
{{--        {{ Form::select('codigopostal_id', $codigospostales, $items->codigopostal_id, ['id' => 'codigopostal_id','class'=>'codigopostal_id form-control ','disabled'=>'disabled','size'=>1 ]) }}--}}
    </div>
    <label for="latitud" class="col-md-3 col-form-label">Latitud</label>
    <div class="col-md-7">
        <input type="text" name="latitud" id="latitud" value="{{ old('latitud',$items->latitud) }}" class="form-control"
               pattern="^-?\d{1,3}\.\d+" disabled/>
    </div>
    <label for="longitud" class="col-md-3 col-form-label">Longitud</label>
    <div class="col-md-7">
        <input type="text" name="longitud" id="longitud" value="{{ old('longitud',$items->longitud) }}"
               class="form-control" pattern="^-?\d{1,3}\.\d+$" disabled/>
    </div>
</div>

<input type="hidden" name="id" value="{{$items->id}}">
<input type="hidden" name="cd_id" id="cd_id" value="0">
<input type="hidden" name="mun_id" id="mun_id" value="0">
<input type="hidden" name="edo_id" id="edo_id" value="0">

<hr>
