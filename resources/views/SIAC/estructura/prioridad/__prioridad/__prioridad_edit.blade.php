<div class="form-group row mb-1">
    <label for = "prioridad" class="col-md-3 col-form-label has-prioridad">Prioridad</label>
    <div class="col-md-9">
        <input type="text" name="prioridad" id="prioridad" value="{{ old('prioridad',$items->prioridad) }}" class="form-control" />
        <span class="has-prioridad">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "class_css" class="col-md-3 col-form-label">Clase CSS</label>
    <div class="col-md-9">
        <input type="text" name="class_css" id="class_css" value="{{ old('class_css',$items->class_css) }}" class="form-control" />
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "predeterminado" class="col-md-3 col-form-label">Predeterminado</label>
    <div class="col-md-9">
{{--        {{ Form::select('predeterminado', array('0'=>'No','1'=>'Si'), $items->isDefault()==true ? 1 : 0 , ['id' => 'predeterminado','class' => 'form-control']) }}--}}
        <select class=" form-control " name="predeterminado" id="predeterminado" size="1">
            <option value="1" @if( $items->isDefault() ) selected @endif >SI</option>
            <option value="0" @if( !$items->isDefault()) selected @endif >NO</option>
        </select>
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "ambito_prioridad" class="col-md-3 col-form-label">Ámbito</label>
    <div class="col-md-9">
        <select class=" form-control "  name="ambito_prioridad" id="ambito_prioridad" size="1">
            @foreach($ambito as $id => $valor)
{{--                <option value="{{ $id }}" >{{ $valor }}</option>--}}
                <option value="{{ $id }}" @if($id === $items->ambito_prioridad) selected @endif>{{ $valor }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "orden_impresion" class="col-md-3 col-form-label">Orden</label>
    <div class="col-md-9">
        <input type="text" name="orden_impresion" id="orden_impresion" value="{{ old('orden_impresion',$items->orden_impresion) }}" class="form-control" />
    </div>
</div>

<input type="hidden" name="id" value="{{$items->id}}" >
