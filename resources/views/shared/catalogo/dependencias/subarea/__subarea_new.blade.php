
<div class="form-group row mb-3">
    <label for = "subarea" class="col-md-3 col-form-label">Subrea</label>
    <div class="col-md-9">
        <input type="text" name="subarea" id="subarea" value="{{ old('subarea') }}" class="form-control" />
    </div>

    <label for = "area_id" class="col-md-3 col-form-label">Área</label>
    <div class="col-md-9">
        <select class="area_id form-control select2" data-toggle="select2"  name="area_id" id="area_id" size="1">
            @foreach($area as $t)
                <option value="{{$t->id}}">{{ $t->area.' - '.$t->dependencia->abreviatura }}</option>
            @endforeach
        </select>
    </div>

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

<hr>
