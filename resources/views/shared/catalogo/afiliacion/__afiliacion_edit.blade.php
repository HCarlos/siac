
<div class="form-group row mb-3">
    <label for = "afiliacion" class="col-md-3 col-form-label">Afiliación</label>
    <div class="col-md-9">
        <input type="text" name="afiliacion" id="afiliacion" value="{{ old('afiliacion',$items->afiliacion) }}" class="form-control" />
    </div>
</div>
<input type="hidden" name="id" value="{{$items->id}}" >

<hr>
