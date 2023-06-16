
<div class="form-group row mb-3">
    <label for = "calle" class="col-md-3 col-form-label">Calle</label>
    <div class="col-md-9">
        <input type="text" name="calle" id="calle" value="{{ old('calle',$items->calle) }}" class="form-control" />
    </div>
</div>
<input type="hidden" name="id" value="{{$items->id}}" >

<hr>
