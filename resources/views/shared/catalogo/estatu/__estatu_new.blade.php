
<div class="form-group row mb-3">

    <label for = "estatus" class="col-md-3 col-form-label">Status</label>
    <div class="col-md-9">
        <input type="text" name="estatus" id="estatus" value="{{ old('estatus') }}" class="form-control" />
    </div>

    <label for = "dependencia_id" class="col-md-3 col-form-label">Dependencia</label>
    <div class="col-md-9">
        <select class="dependencia_id form-control select2" data-toggle="select2"  name="dependencia_id" id="dependencia_id" size="1">
            <option value="0" selected>Ninguna</option>
            @foreach($dependencia as $t)
                <option value="{{$t->id}}">{{ $t->dependencia }}</option>
            @endforeach
        </select>
    </div>

    <label for = "predeterminado" class="col-md-3 col-form-label">Predeterminado</label>
    <div class="col-md-9">
        <select class="predeterminado form-control select2" name="predeterminado" id="predeterminado" size="1">
            <option value="0" selected>No</option>
            <option value="1">Si</option>
        </select>
    </div>

</div>


<input type="hidden" name="id" value="0" >

<hr>
