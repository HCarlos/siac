
<div class="form-group row mb-1">
    <label for = "subarea" class="col-md-3 col-form-label has-subarea">Subsubarea</label>
    <div class="col-md-9">
        <input type="text" name="subarea" id="subarea" value="{{ old('subarea',$items->subarea) }}" class="form-control" />
        <span class="has-subarea">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "area_id" class="col-md-3 col-form-label">Área</label>
    <div class="col-md-9">
        <select class="area_id form-control select2" data-toggle="select2"  name="area_id" id="area_id" size="1">
            @foreach($area as $t)
                <option value="{{$t->id}}" @if($t->id == $items->area_id) selected @endif>{{ $t->area.' - '.$t->dependencia->abreviatura }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "jefe_id" class="col-md-3 col-form-label">Jefe</label>
    <div class="col-md-9">
        <select class="jefe_id form-control select2" data-toggle="select2"  name="jefe_id" id="jefe_id" size="1">
            @foreach($jefes as $t)
                <option value="{{$t->id}}" @if($t->id ==$items->jefe_id) selected @endif>{{ $t->fullname.' '.$t->username }}</option>
            @endforeach
        </select>
    </div>
</div>
<input type="hidden" name="id" value="{{$items->id}}" >
