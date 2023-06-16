<div class="form-group row mb-3">
    <label for = "codigo" class="col-md-3 col-form-label has-codigo">Zona</label>
    <div class="col-md-7">
        <input type="text" name="codigo" id="codigo" value="{{ old('codigo') }}" class="form-control" />
        <span class="has-codigo">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>

<div class="form-group row mb-3">
    <label for = "cp" class="col-md-3 col-form-label has-cp">CP</label>
    <div class="col-md-7">
        <input type="text" name="cp" id="cp" value="{{ old('cp') }}" class="form-control" />
        <span class="has-cp">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>

<input type="hidden" name="id" value="0" >
