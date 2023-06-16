
<div class="form-group row mb-3">
    <label for = "codigo" class="col-md-3 col-form-label">Zona</label>
    <div class="col-md-9">
        <input type="text" name="codigo" id="codigo" value="{{ old('codigo',$items->codigo) }}" class="form-control" />
    </div>
    <label for = "cp" class="col-md-3 col-form-label">CP</label>
    <div class="col-md-9">
        <input type="text" name="cp" id="cp" value="{{ old('cp',$items->cp) }}" class="form-control" />
    </div>
</div>
<input type="hidden" name="id" value="{{$items->id}}" >

<hr>
