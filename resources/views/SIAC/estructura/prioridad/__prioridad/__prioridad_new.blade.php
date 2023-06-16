<div class="form-group row mb-1">
    <label for = "prioridad" class="col-md-3 col-form-label has-prioridad">Prioridad</label>
    <div class="col-md-9">
        <input type="text" name="prioridad" id="prioridad" value="{{ old('prioridad') }}" class="form-control" />
        <span class="has-prioridad">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "class_css" class="col-md-3 col-form-label">Clase CSS</label>
    <div class="col-md-9">
        <input type="text" name="class_css" id="class_css" value="{{ old('class_css') }}" class="form-control" />
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "predeterminado" class="col-md-3 col-form-label">Predeterminado</label>
    <div class="col-md-9">
{{--        {{ Form::select('predeterminado', array('0'=>'No','1'=>'Si'), old('predeterminado'), ['id' => 'predeterminado','class' => 'form-control']) }}--}}
        <select class="form-control" name="predeterminado" id="predeterminado" size="1">
            <option value="1" selected >SI</option>
            <option value="0">NO</option>
        </select>
    </div>
</div>
<input type="hidden" name="id" value="0" >
