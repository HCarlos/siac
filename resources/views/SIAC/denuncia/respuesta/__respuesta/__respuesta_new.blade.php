<div class="form-row mb-1">
    <label for = "fecha" class="col-md-2 col-form-label">Fecha </label>
    <div class="col-md-4">
        <input type="date" name="fecha" id="fecha" value="{{ \Carbon\Carbon::now() }}" class="form-control" >
        <span class="has-error has-fecha">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>
<div class="form-row mb-1">
    <label for = "respuesta" class="col-md-2 col-form-label has-respuesta">Respuesta </label>
    <div class="col-md-10">
        <textarea name="respuesta" id="respuesta" class="form-control">{{ old('respuesta') }}</textarea>
        <span class="has-error has-respuesta">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>
<div class="form-row mb-1">
    <label for = "observaciones" class="col-md-2 col-form-label">Observaciones </label>
    <div class="col-md-10">
        <textarea name="observaciones" id="observaciones" class="form-control">{{ old('observaciones') }}</textarea>
        <span class="has-error has-observaciones">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>

<input type="hidden" id="denuncia__id" name="denuncia__id" value="{{ $denuncia_id }}"/>
<input type="hidden" id="id" name="id" value="0"/>



