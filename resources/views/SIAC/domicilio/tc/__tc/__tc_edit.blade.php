
<div class="form-group row mb-3">
    <label for = "tipocomunidad" class="col-md-3 col-form-label has-tipocomunidad">Tipo Comunidad</label>
    <div class="col-md-7">
        <input type="text" name="tipocomunidad" id="tipocomunidad" value="{{ old('tipocomunidad',$items->tipocomunidad) }}" class="form-control" />
        <span class="has-tipocomunidad">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>
<div class="form-group row mb-3">
    <label for = "nomenclatura" class="col-md-3 col-form-label has-nomenclatura">Nomenclatura</label>
    <div class="col-md-7">
        <input type="text" name="nomenclatura" id="nomenclatura" value="{{ old('nomenclatura',$items->nomenclatura) }}" class="form-control" />
        <span class="has-nomenclatura">
            <strong class="text-danger"></strong>
        </span>
    </div>
    <div class="col-md-2"></div>
</div>

<input type="hidden" name="id" value="{{$items->id}}" >
