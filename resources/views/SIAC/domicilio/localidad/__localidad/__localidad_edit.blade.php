
<div class="form-group row mb-3">
    <label for = "localidad" class="col-md-3 col-form-label has-localidad">Localidad</label>
    <div class="col-md-7">
        <input type="text" name="localidad" id="localidad" value="{{ old('localidad',$items->localidad) }}" class="form-control" />
        <span class="has-localidad">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>
<input type="hidden" name="id" value="{{$items->id}}" >
