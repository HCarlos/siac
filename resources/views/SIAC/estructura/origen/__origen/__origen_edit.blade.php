<div class="form-group row mb-3">
    <label for = "origen" class="col-md-3 col-form-label has-origen">Origen</label>
    <div class="col-md-9">
        <input type="text" name="origen" id="origen" value="{{ old('origen',$items->origen) }}" class="form-control" />
        <span class="has-origen">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>
<input type="hidden" name="id" value="{{$items->id}}" >
