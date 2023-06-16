
<div class="form-group row mb-3">
    <label for = "tipocomunidad" class="col-md-3 col-form-label">Tipo Comunidad</label>
    <div class="col-md-9">
        <input type="text" name="tipocomunidad" id="tipocomunidad" value="{{ old('tipocomunidad',$items->tipocomunidad) }}" class="form-control" />
    </div>
</div>
<input type="hidden" name="id" value="{{$items->id}}" >

<hr>
