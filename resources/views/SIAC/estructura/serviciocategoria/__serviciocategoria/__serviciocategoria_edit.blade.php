<div class="form-group row mb-3">
    <label for = "categoria_servicios" class="col-md-3 col-form-label has-categoria_servicios">Categoría</label>
    <div class="col-md-9">
        <input type="text" name="categoria_servicios" id="categoria_servicios" value="{{ old('categoria_servicios',$items->categoria_servicios) }}" class="form-control" />
        <span class="has-categoria_servicios">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>

<div class="form-group row mb-3">
    <label for = "enlaces_unidades" class="col-md-3 col-form-label has-enlaces_unidades">Unidades</label>
    <div class="col-md-9">
        <input type="text" name="enlaces_unidades" id="enlaces_unidades" value="{{ old('enlaces_unidades',$items->enlaces_unidades) }}" class="form-control" />
        <span class="has-enlaces_unidades">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>

<input type="hidden" name="id" value="{{$items->id}}" >
