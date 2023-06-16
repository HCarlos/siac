
<div class="form-group row mb-3">
    <label for = "estado" class="col-md-3 col-form-label">Estado</label>
    <div class="col-md-9">
        <input type="text" name="estado" id="estado" value="{{ old('estado',$items->estado) }}" class="form-control" />
    </div>
</div>
<input type="hidden" name="id" value="{{$items->id}}" >

<hr>
