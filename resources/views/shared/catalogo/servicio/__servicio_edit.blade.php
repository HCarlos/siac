
<div class="form-group row mb-3">
    <label for = "servicio" class="col-md-3 col-form-label">Servicio</label>
    <div class="col-md-9">
        <input type="text" name="servicio" id="servicio" value="{{ old('servicio',$items->servicio) }}" class="form-control" />
    </div>
    <label for = "habilitado" class="col-md-3 col-form-label">Habilitado</label>
    <div class="col-md-9">
{{--        {{ Form::select('habilitado', array('1'=>'SI', '0'=>'NO'), $items->isEnabled()==true ? 1 : 0 , ['id' => 'habilitado','class' => 'form-control']) }}--}}
        <select class=" form-control " name="habilitado" id="habilitado" size="1">
            <option value="1" @if( $items->isEnabled() ) selected @endif >SI</option>
            <option value="0" @if( ! $items->isEnabled() ) selected @endif >NO</option>
        </select>
    </div>
</div>

<div class="form-group row mb-3">
    <label for = "medida_id" class="col-md-3 col-form-label">Medida</label>
    <div class="col-md-9">
        <select class="medida_id form-control select2" data-toggle="select2"  name="medida_id" id="medida_id" size="1">
            @foreach($medidas as $t)
                <option value="{{$t->id}}" @if($t->id ==$items->medida_id) selected @endif>{{ $t->medida }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group row mb-3">
    <label for = "subarea_id" class="col-md-3 col-form-label">Subarea</label>
    <div class="col-md-9">
        <select class="subarea_id form-control select2" data-toggle="select2"  name="subarea_id" id="subarea_id" size="1">
            @foreach($subareas as $t)
                <option value="{{$t->id}}" @if($t->id ==$items->subarea_id) selected @endif>{{ $t->subarea.' - '.$t->area->area.' - '.$t->area->dependencia->dependencia }}</option>
            @endforeach
        </select>
    </div>
</div>

<input type="hidden" name="id" value="{{$items->id}}" >

<hr>
