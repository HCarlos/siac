
<div class="form-group row mb-3">
    <label for = "calle" class="col-md-3 col-form-label has-calle">Calle</label>
    <div class="col-md-7">
        <input type="text" name="calle" id="calle" value="{{ old('calle',$items->calle) }}" class="form-control" />
        <span class="has-calle">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>
<input type="hidden" name="id" value="{{$items->id}}" >
