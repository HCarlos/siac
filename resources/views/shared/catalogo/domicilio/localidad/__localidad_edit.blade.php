
<div class="form-group row mb-3">
    <label for = "localidad" class="col-md-3 col-form-label">Localidad</label>
    <div class="col-md-9">
        <input type="text" name="localidad" id="localidad" value="{{ old('localidad',$items->localidad) }}" class="form-control" />
    </div>
</div>
<input type="hidden" name="id" value="{{$items->id}}" >

<hr>
