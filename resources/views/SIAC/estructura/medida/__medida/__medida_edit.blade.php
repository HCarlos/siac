<div class="form-group row mb-3">
    <label for = "medida" class="col-md-3 col-form-label has-medida">Medida</label>
    <div class="col-md-9">
        <input type="text" name="medida" id="medida" value="{{ old('medida',$items->medida) }}" class="form-control" />
        <span class="has-medida">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>
<input type="hidden" name="id" value="{{$items->id}}" >
