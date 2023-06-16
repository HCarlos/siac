
<div class="form-group row mb-3">
    <label for = "tipoasentamiento" class="col-md-3 col-form-label">Tipo Asentamiento</label>
    <div class="col-md-9">
        <input type="text" name="tipoasentamiento" id="tipoasentamiento" value="{{ old('tipoasentamiento',$items->tipoasentamiento) }}" class="form-control" />
    </div>
</div>
<input type="hidden" name="id" value="{{$items->id}}" >

<hr>
