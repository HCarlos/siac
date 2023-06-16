
<div class="form-group row mb-3">
    <label for = "ciudad" class="col-md-3 col-form-label">Ciudad</label>
    <div class="col-md-9">
        <input type="text" name="ciudad" id="ciudad" value="{{ old('ciudad',$items->ciudad) }}" class="form-control" />
    </div>
</div>
<input type="hidden" name="id" value="{{$items->id}}" >

<hr>
