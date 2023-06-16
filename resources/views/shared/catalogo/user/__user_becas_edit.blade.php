<div class="form-group has-error row mb-3">
    <label for = "beca_sep" class="col-md-3 col-form-label">Beca SEP</label>
    <div class="col-md-9">
        <input type="text" name="beca_sep" id="beca_sep" value="{{ old('beca_sep',$items->user_becas->beca_sep) }}" pattern="^\d+(\.\d{1,2})?$" class="form-control" />
        <span class="has-error has-beca_sep">
            <strong class="text-danger"></strong>
        </span>
    </div>
    <label for = "beca_arji" class="col-md-3 col-form-label">Beca Arjí</label>
    <div class="col-md-9">
        <input type="text" name="beca_arji" id="beca_arji" value="{{ old('beca_arji',$items->user_becas->beca_arji) }}" pattern="^\d+(\.\d{1,2})?$" class="form-control" />
        <span class="has-error has-beca_arji">
            <strong class="text-danger"></strong>
        </span>
    </div>
    <label for = "beca_spf" class="col-md-3 col-form-label">Beca SPF</label>
    <div class="col-md-9">
        <input type="text" name="beca_spf" id="beca_spf" value="{{ old('beca_spf',$items->user_becas->beca_spf) }}" pattern="^\d+(\.\d{1,2})?$" class="form-control" />
        <span class="has-error has-beca_spf">
            <strong class="text-danger"></strong>
        </span>
    </div>
    <label for = "beca_bach" class="col-md-3 col-form-label">Beca Bach.</label>
    <div class="col-md-9">
        <input type="text" name="beca_bach" id="beca_bach" value="{{ old('beca_bach',$items->user_becas->beca_bach) }}" pattern="^\d+(\.\d{1,2})?$" class="form-control" />
        <span class="has-error has-beca_bach">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>

<div class="form-group row mb-3">
    <label for = "observaciones" class="col-md-3 col-form-label">Observaciones</label>
    <div class="col-md-9">
        <input type="text" name="observaciones" id="observaciones" value="{{ old('calle',$items->user_becas->observaciones) }}" class="form-control" />
    </div>
</div>
<input type="hidden" name="user_id" value="{{$items->id}}" >
<input type="hidden" name="id" value="{{$items->user_becas->id}}" >
