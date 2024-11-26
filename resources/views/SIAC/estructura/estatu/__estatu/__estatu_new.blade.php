<div class="form-group row mb-1">
    <label for = "estatus" class="col-md-2 col-form-label has-estatus">Status</label>
    <div class="col-md-9">
        <input type="text" name="estatus" id="estatus" value="{{ old('estatus') }}" class="form-control" />
        <span class="has-estatus">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "abreviatura" class="col-md-2 col-form-label has-abreviatura">Abreviatura</label>
    <div class="col-md-9">
        <input type="text" name="abreviatura" id="abreviatura" value="{{ old('abreviatura') }}" class="form-control" />
        <span class="has-abreviatura">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "dependencia_id" class="col-md-2 col-form-label has-dependencia_id">Unidad</label>
    <div class="col-md-9">
        <select class="dependencia_id form-control " data-toggle="select2"  name="dependencia_id" id="dependencia_id" size="1">
            <option value="0" selected>Ninguna</option>
            @foreach($dependencia as $t)
                <option value="{{$t->id}}">{{ $t->dependencia }}</option>
            @endforeach
        </select>
        <span class="has-dependencia_id">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>

<div class="form-group row mb-1">
    <label for = "predeterminado" class="col-md-2 col-form-label">Predeterminado</label>
    <div class="col-md-2">
        <select class="predeterminado form-control " name="predeterminado" id="predeterminado" size="1">
            <option value="0" selected>No</option>
            <option value="1">Si</option>
        </select>
    </div>
    <label for = "resuelto" class="col-md-2 col-form-label">Evalua Resuelto</label>
    <div class="col-md-2">
        <select class="resuelto form-control select2" name="resuelto" id="resuelto" size="1">
            <option value="0" selected>No</option>
            <option value="1">Si</option>
        </select>
    </div>
    <label for = "estatus_cve" class="col-md-2 col-form-label">Clave Estatus</label>
    <div class="col-md-2">
        <select class="estatus_cve form-control " name="estatus_cve" id="estatus_cve" size="1">
            <option value="0">Inactivo</option>
            <option value="1" selected>Activo</option>
            <option value="2">Suspendido</option>
            <option value="3">Cancelado</option>
        </select>
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "favorable" class="col-md-2 col-form-label">Es Favorable</label>
    <div class="col-md-2">
        <select class="favorable form-control select2" name="favorable" id="favorable" size="1">
            <option value="0">No</option>
            <option value="1" selected>Si</option>
        </select>
    </div>
    <label for = "orden_impresion" class="col-md-2 col-form-label has-orden_impresion">Orden Imp.</label>
    <div class="col-md-2">
        <input type="number" name="orden_impresion" id="orden_impresion" value="{{ old('orden_impresion',0) }}" class="form-control" min="0" max="99" step="1" />
        <span class="has-orden_impresion">
            <strong class="text-danger"></strong>
        </span>
    </div>
    <label for = "ambito_estatus" class="col-md-2 col-form-label">Categoría</label>
    <div class="col-md-2">
        <select class=" form-control "  name="ambito_estatus" id="ambito_estatus" size="1">
            @foreach($ambito as $id => $valor)
                <option value="{{ $id }}" >{{ $valor }}</option>
            @endforeach
        </select>
    </div>
</div>

<input type="hidden" name="id" value="0" >
