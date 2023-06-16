
<div class="form-group row mb-3">
    <label for = "asentamiento" class="col-md-3 col-form-label has-asentamiento">Asentamiento</label>
    <div class="col-md-7">
        <input type="text" name="asentamiento" id="asentamiento" value="{{ old('asentamiento',$items->asentamiento) }}" class="form-control" />
        <span class="has-asentamiento">
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
