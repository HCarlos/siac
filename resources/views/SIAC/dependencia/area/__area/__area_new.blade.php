
<div class="form-group row mb-1">
    <label for = "area" class="col-md-3 col-form-label has-area">Área</label>
    <div class="col-md-9">
        <input type="text" name="area" id="area" value="{{ old('area') }}" class="form-control" />
        <span class="has-area">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "dependencia_id" class="col-md-3 col-form-label">Dependencia</label>
    <div class="col-md-9">
        <select class="dependencia_id form-control select2" data-toggle="select2"  name="dependencia_id" id="dependencia_id" size="1">
            @foreach($dependencia as $t)
                <option value="{{$t->id}}">{{ $t->dependencia }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "jefe_id" class="col-md-3 col-form-label">Jefe</label>
    <div class="col-md-9">
        <select class="jefe_id form-control select2" data-toggle="select2"  name="jefe_id" id="jefe_id" size="1">
            @foreach($jefes as $t)
                <option value="{{$t->id}}">{{ $t->fullname.' '.$t->username }}</option>
            @endforeach
        </select>
    </div>
</div>

<input type="hidden" name="id" value="0" >
